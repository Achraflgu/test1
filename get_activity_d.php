<?php
// Include the database connection file
require_once('config/database.php');
$database = new Database();
$conn = $database->getConnection();

// Check if the activity ID is provided
if (isset($_GET['activityId'])) {
    $activityId = $_GET['activityId'];

    // Prepare and execute the SQL query to fetch activity details
    $query = "SELECT * FROM activities WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $activityId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the query was successful
    if ($result) {
        // Fetch the activity details as an associative array
        $activityDetails = $result->fetch_assoc();

        // Return the activity details as JSON
        header('Content-Type: application/json');
        echo json_encode($activityDetails);
    } else {
        // Handle the error (e.g., log or return an error response)
        echo json_encode(['error' => 'Failed to fetch activity details']);
    }

    // Close the database connection
    $stmt// PDO connection closes automatically;
    $conn// PDO connection closes automatically;
} else {
    // Handle the case where the activity ID is not provided
    echo json_encode(['error' => 'Activity ID not provided']);
}
?>
