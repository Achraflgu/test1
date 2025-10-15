<?php
// verify_password.php

// Include your database connection
include('connexion.php');

// Assuming you have the user's ID and password passed as POST parameters
$userId = $_POST['userId']; // Replace with the actual parameter name
$password = $_POST['password']; // Replace with the actual parameter name

// Fetch user information from the database based on the user ID
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
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
$stmt->close();
$conn->close();
?>
