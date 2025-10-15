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
    
    if (!isset($input['email']) || !isset($input['password'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Email and password are required']);
        exit();
    }

    $email = $input['email'];
    $password = $input['password'];
    $isParent = $input['is_parent'] ?? null;
    $numberOfKids = $input['number_of_kids'] ?? null;

    // Check if user already exists
    $existingUser = fetchOne(
        "SELECT id FROM users WHERE email = :email",
        ['email' => $email]
    );

    if ($existingUser) {
        http_response_code(409);
        echo json_encode(['error' => 'User already exists']);
        exit();
    }

    // Create new user
    $userId = executeUpdate(
        "INSERT INTO users (email, password, is_parent, number_of_kids) VALUES (:email, :password, :is_parent, :number_of_kids)",
        [
            'email' => $email,
            'password' => $password, // In production, use password_hash($password, PASSWORD_DEFAULT)
            'is_parent' => $isParent,
            'number_of_kids' => $numberOfKids
        ]
    );

    if ($userId) {
        $newUserId = getLastInsertId();
        
        $response = [
            'success' => true,
            'message' => 'User created successfully',
            'user_id' => $newUserId
        ];

        echo json_encode($response);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to create user']);
    }

} catch (Exception $e) {
    error_log("Registration error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Internal server error']);
}
?>
