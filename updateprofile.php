<?php
// updateprofile.php

// Include your database connection
require_once('config/simple_database.php');
$database = new Database();
$conn = $database->getConnection();

// Assuming you have the user's selected kid ID passed as URL parameter
$selectedKidId = $_POST['kidId']; // Use $_POST instead of $_GET for security

// Fetch kid information from the database based on the selected ID
$sql = "SELECT * FROM children WHERE id = $selectedKidId";
simpleQuery($sql);

if ($result && $result->num_rows > 0) {
    $row = simpleFetchAll($result)[0];
    $selectedKidName = $row['kid_name'];
    $selectedKidAge = $row['kid_age'];
    $selectedKidPhoto = $row['kid_photo'];

    // Fetch user input
    $newKidName = $_POST['kidName'];
    $newKidAge = $_POST['kidAge'];
    // Add more variables if needed

    // Password validation (you should use a secure method for password verification)
    $password = $_POST['password'];
    $userPassword = ''; // Retrieve the user's password from the database based on $selectedUserId

    // Your password validation logic here

    // Update kid information if password is correct
    if ($password === $userPassword) {
        $updateSql = "UPDATE children SET kid_name = '$newKidName', kid_age = '$newKidAge' WHERE id = $selectedKidId";
        if ($conn->query($updateSql) === TRUE) {
            echo "Kid information updated successfully!";
        } else {
            echo "Error updating kid information: " . $conn->errorInfo()[2];
        }
    } else {
        echo "Password is incorrect!";
    }
} else {
    // Handle the case where the selected kid ID is not valid
    echo "Invalid kid ID!";
}

// Close the database connection
$conn// PDO connection closes automatically;
?>
