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
    $password = trim($input['password']);

    // Get user from database
    $user = fetchOne(
        "SELECT * FROM users WHERE email = :email",
        ['email' => $email]
    );

    if (!$user) {
        http_response_code(401);
        echo json_encode(['error' => 'Invalid credentials']);
        exit();
    }

    // For now, using simple password comparison (in production, use password_hash/verify)
    if ($password !== $user['password']) {
        http_response_code(401);
        echo json_encode(['error' => 'Invalid credentials']);
        exit();
    }

    // Get children for this user
    $children = fetchAll(
        "SELECT * FROM children WHERE user_id = :user_id",
        ['user_id' => $user['id']]
    );

    // Remove password from response
    unset($user['password']);

    $response = [
        'success' => true,
        'user' => $user,
        'children' => $children,
        'isAdmin' => (bool)$user['isadmin']
    ];

    echo json_encode($response);

} catch (Exception $e) {
    error_log("Login error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Internal server error']);
}
?>
