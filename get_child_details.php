<?php
// get_child_details.php

include('connexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the child ID from the POST data
    $childId = $_POST['child_id'];

    // Fetch child details from the database
    $childDetailsSql = "SELECT * FROM children WHERE id = $childId";
    $childDetailsResult = $conn->query($childDetailsSql);

    if ($childDetailsResult) {
        $childDetails = $childDetailsResult->fetch_assoc();
        echo json_encode($childDetails);
    } else {
        echo "Error fetching child details: " . $conn->error;
    }
} else {
    echo "Invalid request method";
}
?>
