<?php
include('connexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $storyId = $_POST['storyId'];
    $newTitle = $_POST['newTitle'];
    $newDescription = $_POST['newDescription'];
    $newLink = $_POST['newLink'];
    $newPhoto = $_POST['newPhoto'];
    $newCategory = $_POST['newCategory'];

    // Debugging statements
    error_log('Story ID: ' . $storyId);
    error_log('New Title: ' . $newTitle);
    error_log('New Description: ' . $newDescription);
    error_log('New Link: ' . $newLink);
    error_log('New Photo: ' . $newPhoto);
    error_log('New Category: ' . $newCategory);

    // Prepare and bind parameters to prevent SQL injection
    $updateStmt = $conn->prepare("UPDATE stories SET 
                                  story_title = ?, 
                                  description = ?, 
                                  link_of_stories = ?, 
                                  photo = ?, 
                                  category = ? 
                                  WHERE id = ?");

    $updateStmt->bind_param("sssssi", $newTitle, $newDescription, $newLink, $newPhoto, $newCategory, $storyId);

    // Execute the update query
    if ($updateStmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Story updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating story: ' . $conn->error]);
    }

    // Close the prepared statement
    $updateStmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

// Close the database connection
$conn->close();
?>
