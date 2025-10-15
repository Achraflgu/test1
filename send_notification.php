<?php
// send_notification.php

// Include necessary files and database connection
include('connexion.php');

// Get the notification message from the POST data
$notificationMessage = $_POST['message'];

// Fetch all child IDs
$sql = "SELECT id FROM children";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    // Prepare the INSERT statement
    $insertNotificationSql = $conn->prepare("INSERT INTO notifications (kid_id, message) VALUES (?, ?)");

    // Bind parameters
    $insertNotificationSql->bind_param("is", $childId, $notificationMessage);

    while ($row = $result->fetch_assoc()) {
        $childId = $row['id'];

        // Execute the prepared statement for each child
        $insertNotificationSql->execute();
    }

    // Close the prepared statement
    $insertNotificationSql->close();

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'No children found']);
}

// Close the database connection
$conn->close();
?>
