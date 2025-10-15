<?php
require_once('config/database.php');
$database = new Database();
$conn = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gameId = $_POST['gameId'];

    // Prepare and execute the SQL query to delete the game
    $deleteStmt = $conn->prepare("DELETE FROM games WHERE id = ?");
    $deleteStmt->bind_param('i', $gameId);

    // Execute the delete query
    if ($deleteStmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Game deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error deleting game: ' . $conn->errorInfo()[2]]);
    }

    // Close the prepared statement
    $deleteStmt// PDO connection closes automatically;
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

// Close the database connection
$conn// PDO connection closes automatically;
?>
