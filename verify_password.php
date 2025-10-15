<?php
// verify_password.php

// Include your database connection
require_once('config/simple_database.php');

// Assuming you have the user's ID and password passed as POST parameters
$userId = intval($_POST['userId']);
$password = $_POST['password'];

// Fetch user information from the database based on the user ID
$sql = "SELECT * FROM users WHERE id = " . $userId;
$result = simpleQuery($sql);

if ($result && count($result) > 0) {
    $row = $result[0];
    $userPasswordHash = $row['password'];

    // Check if the entered password matches the one in the database
    if ($password === $userPasswordHash) {
        echo "Password is correct!";
    } else {
        echo "Incorrect password. Please try again.";
    }
} else {
    // Handle the case where the user ID is not valid
    echo "Invalid user ID!";
}

// PDO connection closes automatically
?>
