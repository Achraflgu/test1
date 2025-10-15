<?php
// fetch_notifications.php

// Include necessary files and database connection
require_once('config/database.php');
$database = new Database();
$conn = $database->getConnection();

// Get the child ID from the POST data
$childId = $_POST['childId'];

// Fetch all notifications for the specified child ID
$sql = "SELECT * FROM notifications WHERE kid_id = '$childId'";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $notifications = [];
    while ($row = $result->fetch_assoc()) {
        $notifications[] = $row;
    }

    echo json_encode(['success' => true, 'notifications' => $notifications]);
} else {
    echo json_encode(['success' => false, 'error' => 'No notifications found']);
}

$conn// PDO connection closes automatically;
?>
