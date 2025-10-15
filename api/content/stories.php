<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit();
}

try {
    $category = $_GET['category'] ?? 'all';
    $kidId = $_GET['kid_id'] ?? null;
    $limit = $_GET['limit'] ?? 5;

    // Initialize condition
    $condition = '';
    $params = [];

    // If kidId is provided, check for hidden categories
    if ($kidId) {
        $hiddenCategories = fetchOne(
            "SELECT hidden_stories_categories FROM children WHERE id = :kid_id",
            ['kid_id' => $kidId]
        );

        $hiddenCats = [];
        if ($hiddenCategories && $hiddenCategories['hidden_stories_categories']) {
            $hiddenCats = explode(',', $hiddenCategories['hidden_stories_categories']);
            $hiddenCats = array_map('trim', $hiddenCats);
        }

        if ($category !== 'all') {
            if (in_array($category, $hiddenCats)) {
                http_response_code(403);
                echo json_encode(['error' => 'Category is hidden for this child']);
                exit();
            }
            $condition = "WHERE category = :category";
            $params['category'] = $category;
        } else {
            if (!empty($hiddenCats)) {
                $placeholders = str_repeat('?,', count($hiddenCats) - 1) . '?';
                $condition = "WHERE category IS NULL OR category NOT IN ($placeholders)";
                $params = array_merge($params, $hiddenCats);
            }
        }
    } else {
        if ($category !== 'all') {
            $condition = "WHERE category = :category";
            $params['category'] = $category;
        }
    }

    // Add limit
    $limitClause = "LIMIT :limit";
    $params['limit'] = (int)$limit;

    $sql = "SELECT * FROM stories $condition ORDER BY RAND() $limitClause";
    
    $stories = fetchAll($sql, $params);

    $response = [
        'success' => true,
        'stories' => $stories,
        'count' => count($stories)
    ];

    echo json_encode($response);

} catch (Exception $e) {
    error_log("Get stories error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Internal server error']);
}
?>
