<?php
include('connexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $activityId = $_POST['activityId'];
    $newTitle = $_POST['newTitle'];
    $newDescription = $_POST['newDescription'];
    $newPhoto = $_POST['newPhoto'];
    $newLink = $_POST['newLink'];
    $newCategory = $_POST['newCategory'];

    // Debugging statements
    error_log('Activity ID: ' . $activityId);
    error_log('New Title: ' . $newTitle);
    error_log('New Description: ' . $newDescription);
    error_log('New Photo: ' . $newPhoto);
    error_log('New Link: ' . $newLink);
    error_log('New Category: ' . $newCategory);

    // Prepare and bind parameters to prevent SQL injection
    $updateStmt = $conn->prepare("UPDATE activities SET 
                                  activity_title = ?, 
                                  description = ?, 
                                  photo = ?, 
                                  link_of_activities = ?, 
                                  category = ? 
                                  WHERE id = ?");

    if (!$updateStmt) {
        // Handle the error if the statement preparation fails
        echo json_encode(['success' => false, 'message' => 'Error preparing update statement: ' . $conn->error]);
        exit();
    }

    $updateStmt->bind_param("sssssi", $newTitle, $newDescription, $newPhoto, $newLink, $newCategory, $activityId);

    // Execute the update query
    if ($updateStmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Activity updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating activity: ' . $updateStmt->error]);
    }

    // Close the prepared statement
    $updateStmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

// Close the database connection
$conn->close();
?>
