<?php
// get_child_details.php

require_once('config/database.php');
$database = new Database();
$conn = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the child ID from the POST data
    $childId = $_POST['child_id'];

    // Fetch child details from the database
    $childDetailsSql = "SELECT * FROM children WHERE id = $childId";
    $stmt = $conn->prepare($childDetailsSql);\n$stmt->execute();\n$childDetailsResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($childDetailsResult) {
        $childDetails = $childDetailsResult->fetch_assoc();
        echo json_encode($childDetails);
    } else {
        echo "Error fetching child details: " . $conn->errorInfo()[2];
    }
} else {
    echo "Invalid request method";
}
?>
