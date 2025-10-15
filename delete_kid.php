<?php
// delete_kid.php

require_once('config/database.php');
$database = new Database();
$conn = $database->getConnection();

if (!isset($_GET['id'])) {
    echo "Kid ID is not set!";
    exit();
}

$kidId = $_GET['id'];
$selectedUserId = $_GET['userId'];

// Disable foreign key checks temporarily
$conn->query("SET foreign_key_checks = 0");

// Proceed with deleting the child
$deleteChildSql = "DELETE FROM children WHERE id = $kidId";

if ($conn->query($deleteChildSql) === TRUE) {
    echo "Kid deleted successfully!";
    
    // Enable foreign key checks again
    $conn->query("SET foreign_key_checks = 1");
    
    // Open the login.php in a new window
    echo "<script>window.open('login.php?userId={$selectedUserId}', '_parent');</script>";
    
    // Redirect the current page
    echo "<script>window.location.href = '{$_SERVER['HTTP_REFERER']}'</script>";
} else {
    echo "Error deleting kid: " . $conn->errorInfo()[2];
}

$conn// PDO connection closes automatically;
?>
