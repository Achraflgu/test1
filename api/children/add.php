<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit();
}

try {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($input['user_id']) || !isset($input['kid_name']) || !isset($input['kid_gender']) || !isset($input['kid_age'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Required fields: user_id, kid_name, kid_gender, kid_age']);
        exit();
    }

    $userId = $input['user_id'];
    $kidName = $input['kid_name'];
    $kidGender = $input['kid_gender'];
    $kidAge = $input['kid_age'];
    $kidPhoto = $input['kid_photo'] ?? null;

    // Validate gender
    if (!in_array($kidGender, ['male', 'female'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid gender. Must be male or female']);
        exit();
    }

    // Validate age
    if ($kidAge < 3 || $kidAge > 6) {
        http_response_code(400);
        echo json_encode(['error' => 'Age must be between 3 and 6']);
        exit();
    }

    // Create new child profile
    $childId = executeUpdate(
        "INSERT INTO children (user_id, kid_name, kid_gender, kid_age, kid_photo) VALUES (:user_id, :kid_name, :kid_gender, :kid_age, :kid_photo)",
        [
            'user_id' => $userId,
            'kid_name' => $kidName,
            'kid_gender' => $kidGender,
            'kid_age' => $kidAge,
            'kid_photo' => $kidPhoto
        ]
    );

    if ($childId) {
        $newChildId = getLastInsertId();
        
        $response = [
            'success' => true,
            'message' => 'Child profile created successfully',
            'child_id' => $newChildId
        ];

        echo json_encode($response);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to create child profile']);
    }

} catch (Exception $e) {
    error_log("Add child error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Internal server error']);
}
?>
