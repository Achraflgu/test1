<?php
require_once('config/database.php');
$database = new Database();
$conn = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $storyId = $_POST['storyId'];

    // Perform the delete query
    $deleteSql = "DELETE FROM stories WHERE id = $storyId";

    if ($conn->query($deleteSql) === TRUE) {
        echo json_encode(['success' => true, 'message' => 'Story deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error deleting story: ' . $conn->errorInfo()[2]]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

$conn// PDO connection closes automatically;
?>
