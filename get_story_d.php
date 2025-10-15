<?php
// Include the database connection file
include('connexion.php');

// Check if the story ID is provided
if (isset($_GET['storyId'])) {
    $storyId = $_GET['storyId'];

    // Prepare and execute the SQL query to fetch story details
    $query = "SELECT * FROM stories WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $storyId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the query was successful
    if ($result) {
        // Fetch the story details as an associative array
        $storyDetails = $result->fetch_assoc();

        // Return the story details as JSON
        header('Content-Type: application/json');
        echo json_encode($storyDetails);
    } else {
        // Handle the error (e.g., log or return an error response)
        echo json_encode(['error' => 'Failed to fetch story details']);
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
} else {
    // Handle the case where the story ID is not provided
    echo json_encode(['error' => 'Story ID not provided']);
}
?>
