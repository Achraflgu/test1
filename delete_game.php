<?php
include('connexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gameId = $_POST['gameId'];

    // Prepare and execute the SQL query to delete the game
    $deleteStmt = $conn->prepare("DELETE FROM games WHERE id = ?");
    $deleteStmt->bind_param('i', $gameId);

    // Execute the delete query
    if ($deleteStmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Game deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error deleting game: ' . $conn->error]);
    }

    // Close the prepared statement
    $deleteStmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

// Close the database connection
$conn->close();
?>
