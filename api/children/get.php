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
    $userId = $_GET['user_id'] ?? null;
    $kidId = $_GET['kid_id'] ?? null;

    if ($userId) {
        // Get all children for a user
        $children = fetchAll(
            "SELECT * FROM children WHERE user_id = :user_id ORDER BY created_at DESC",
            ['user_id' => $userId]
        );

        $response = [
            'success' => true,
            'children' => $children
        ];
    } elseif ($kidId) {
        // Get specific child
        $child = fetchOne(
            "SELECT * FROM children WHERE id = :kid_id",
            ['kid_id' => $kidId]
        );

        if (!$child) {
            http_response_code(404);
            echo json_encode(['error' => 'Child not found']);
            exit();
        }

        $response = [
            'success' => true,
            'child' => $child
        ];
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'user_id or kid_id parameter required']);
        exit();
    }

    echo json_encode($response);

} catch (Exception $e) {
    error_log("Get children error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Internal server error']);
}
?>
