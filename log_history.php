<?php
// log_history.php

// Ensure $selectedKidId and $pageName are set
$selectedKidId = isset($_POST['kidId']) ? intval($_POST['kidId']) : 0;
$pageName = isset($_POST['pageName']) ? $_POST['pageName'] : '';

// Include your database connection
require_once('connexion.php');

// Get the current date and time
$dateTime = date("Y-m-d H:i:s");

// Escape values to prevent SQL injection
$selectedKidId = mysqli_real_escape_string($conn, $selectedKidId);
$dateTime = mysqli_real_escape_string($conn, $dateTime);
$pageName = mysqli_real_escape_string($conn, $pageName);

// Insert data into the historic_data table
$sql = "INSERT INTO historic_data (kid_id, date_time, page_name) VALUES ('$selectedKidId', '$dateTime', '$pageName')";

// Check for errors in the query execution
if ($conn->query($sql)) {
} else {
    echo "Error logging historical data: " . $conn->errorInfo()[2];
}

// Close the database connection
$conn// PDO connection closes automatically;
?>
