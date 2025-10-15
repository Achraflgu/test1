<?php
require_once('config/simple_database.php');


// Check if kidId is set
if (!isset($_GET['kidId'])) {
    echo "Kid ID is not set!";
    exit();
}

$selectedKidId = $_GET['kidId'];

// Prepare the SQL statement with a placeholder
$sql = "SELECT kid_gender FROM children WHERE id = ?";
$stmt = $conn->prepare($sql);

// Bind the parameter to the statement


// Execute the statement
simpleExecute($sql);

// Get the result
$result = $stmt->get_result();

// Check if the query was successful
if ($result && count($result) > 0) {
    $row = $result[0];
    $kidGenre = $row['kid_gender'];

    // Return kid's genre as JSON
    echo json_encode(['kidGenre' => $kidGenre]);
} else {
    // Handle error if kidId is invalid
    echo json_encode(['error' => 'Invalid kid ID']);
}

// Close the statement and the database connection
$stmt// PDO connection closes automatically;
$conn// PDO connection closes automatically;
?>
