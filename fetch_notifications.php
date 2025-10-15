<?php
// fetch_notifications.php

// Include necessary files and database connection
require_once('config/simple_database.php');


// Get the child ID from the POST data
$childId = $_POST['childId'];

// Fetch all notifications for the specified child ID
$sql = "SELECT * FROM notifications WHERE kid_id = '$childId'";
$result = $result = simpleQuery($sql);

if ($result && count($result) > 0) {
    $notifications = [];
    while ($row = $result[0]) {
        $notifications[] = $row;
    }

    echo json_encode(['success' => true, 'notifications' => $notifications]);
} else {
    echo json_encode(['success' => false, 'error' => 'No notifications found']);
}

$conn// PDO connection closes automatically;
?>
