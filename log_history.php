<?php
// log_history.php

// Ensure $selectedKidId and $pageName are set
$selectedKidId = isset($_POST['kidId']) ? intval($_POST['kidId']) : 0;
$pageName = isset($_POST['pageName']) ? $_POST['pageName'] : '';

// Include your database connection
require_once('config/simple_database.php');

// Get the current date and time
$dateTime = date("Y-m-d H:i:s");

// Insert data into the historic_data table using simple query
$sql = "INSERT INTO historic_data (kid_id, date_time, page_name) VALUES (" . intval($selectedKidId) . ", '" . addslashes($dateTime) . "', '" . addslashes($pageName) . "')";

// Execute the query
try {
    simpleExecute($sql);
} catch (Exception $e) {
    error_log("Error logging historical data: " . $e->getMessage());
}
?>
