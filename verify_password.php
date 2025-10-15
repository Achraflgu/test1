<?php
// verify_password.php

// Include your database connection
require_once('config/simple_database.php');
$database = new Database();
$conn = $database->getConnection();

// Assuming you have the user's ID and password passed as POST parameters
$userId = $_POST['userId']; // Replace with the actual parameter name
$password = $_POST['password']; // Replace with the actual parameter name

// Fetch user information from the database based on the user ID
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);

simpleExecute($sql);
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $row = simpleFetchAll($result)[0];
    $userPasswordHash = $row['password']; // Replace with the actual column name

    // Check if the entered password matches the one in the database
    if ($password === $userPasswordHash) {
        echo "Password is correct! ";
    } else {
        echo "Incorrect password. Please try again.";
    }
} else {
    // Handle the case where the user ID is not valid
    echo "Invalid user ID!";
}

// Close the database connection
$stmt// PDO connection closes automatically;
$conn// PDO connection closes automatically;
?>
