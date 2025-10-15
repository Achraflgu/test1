<?php
require_once('config/simple_database.php');
$database = new Database();
$conn = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newTitle = $_POST['newTitle'];
    $newDescription = $_POST['newDescription'];
    $newLink = $_POST['newLink'];
    $newPhoto = $_POST['newPhoto'];
    $newCategory = $_POST['newCategory'];

    // Perform the insert query
    $insertSql = "INSERT INTO stories (story_title, description, link_of_stories, photo, category) 
                  VALUES ('$newTitle', '$newDescription', '$newLink', '$newPhoto', '$newCategory')";

    if ($conn->query($insertSql) === TRUE) {
        echo json_encode(['success' => true, 'message' => 'Story added successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error adding story: ' . $conn->errorInfo()[2]]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

$conn// PDO connection closes automatically;
?>
