<?php
// mark_all_notifications_as_read.php

// Include necessary files and database connection
include('connexion.php');

// Get the child ID from the POST data
$childId = $_POST['childId'];

// Update the notifications to mark them as read
$sql = "UPDATE notifications SET is_read = TRUE WHERE kid_id = '$childId'";
$result = $conn->query($sql);

if ($result) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Failed to mark notifications as read']);
}

$conn->close();
?>
