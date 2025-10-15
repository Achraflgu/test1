<?php
require_once('config/database.php');
$database = new Database();
$conn = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gameId = $_POST['gameId'];
    $newTitle = $_POST['newTitle'];
    $newDescription = $_POST['newDescription'];
    $newLink = $_POST['newLink'];
    $newPhoto = $_POST['newPhoto'];
    $newCategory = $_POST['newCategory'];

    // Debugging statements
    error_log('Game ID: ' . $gameId);
    error_log('New Title: ' . $newTitle);
    error_log('New Description: ' . $newDescription);
    error_log('New Link: ' . $newLink);
    error_log('New Photo: ' . $newPhoto);
    error_log('New Category: ' . $newCategory);

    // Prepare and bind parameters to prevent SQL injection
    $updateStmt = $conn->prepare("UPDATE games SET 
                                  game_title = ?, 
                                  description = ?, 
                                  link_of_games = ?, 
                                  photo = ?, 
                                  category = ? 
                                  WHERE id = ?");

    if (!$updateStmt) {
        // Handle preparation error
        echo json_encode(['success' => false, 'message' => 'Error preparing update statement: ' . $conn->errorInfo()[2]]);
    } else {
        $updateStmt->bind_param("sssssi", $newTitle, $newDescription, $newLink, $newPhoto, $newCategory, $gameId);

        // Execute the update query
        if ($updateStmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Game updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error updating game: ' . $updateStmt->errorInfo()[2]]);
        }

        // Close the prepared statement
        $updateStmt// PDO connection closes automatically;
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

// Close the database connection
$conn// PDO connection closes automatically;
?>
