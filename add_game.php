<?php
require_once('config/database.php');
$database = new Database();
$conn = $database->getConnection();

$newTitle = $_POST['newTitle'];
$newDescription = $_POST['newDescription'];
$newLink = $_POST['newLink'];
$newPhoto = $_POST['newPhoto'];
$newCategory = $_POST['newCategory'];

// Check if the selected category is 'Other'
if ($newCategory === 'Other') {
    $newCategory = $_POST['otherCategory']; // Use the value from the additional input field
}

// Perform database insertion with proper validation and sanitization
// Ensure you use prepared statements to prevent SQL injection

$insertQuery = "INSERT INTO games (game_title, description, link_of_games, photo, category) VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($insertQuery);
$stmt->bind_param("sssss", $newTitle, $newDescription, $newLink, $newPhoto, $newCategory);

if ($stmt->execute()) {
    // Insertion successful
    echo "Game added successfully!";
} else {
    // Insertion failed
    echo "Error adding game: " . $stmt->errorInfo()[2];
}

$stmt// PDO connection closes automatically;
$conn// PDO connection closes automatically;
?>
