<?php
// fetch_unread_notifications.php

// Include necessary files and database connection
require_once('config/simple_database.php');
$database = new Database();
$conn = $database->getConnection();

// Get the child ID from the POST data
$childId = $_POST['childId'];

// Fetch unread notifications for the specified child ID
$sql = "SELECT * FROM notifications WHERE kid_id = '$childId' AND is_read = 0";
simpleQuery($sql);

if ($result && $result->num_rows > 0) {
    $notifications = [];
    while ($row = simpleFetchAll($result)[0]) {
        $notifications[] = $row;
    }

    echo json_encode(['success' => true, 'notifications' => $notifications]);
} else {
    echo json_encode(['success' => false, 'error' => 'No unread notifications found']);
}

$conn// PDO connection closes automatically;
?>
