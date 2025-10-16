<?php
// get_child_details.php

require_once('config/simple_database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the child ID from the POST data
    $childId = $_POST['child_id'];

    // Fetch child details from the database
    $childDetailsSql = "SELECT * FROM children WHERE id = " . intval($childId);
    $childDetailsResult = simpleQuery($childDetailsSql);

    if (count($childDetailsResult) > 0) {
        $childDetails = $childDetailsResult[0];
        echo json_encode($childDetails);
    } else {
        echo "Error fetching child details: Child not found";
    }
} else {
    echo "Invalid request method";
}
?>
