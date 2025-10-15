<?php
// Replace these with your database connection details
require_once('config/simple_database.php');

// Check if the ID parameter is set in the URL
if (isset($_GET['id'])) {
    // Create connection
    

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get the ID parameter from the URL
    $feedback_id = $_GET['id'];

    // Prepare and execute the SQL statement to delete the feedback
    $sql = "DELETE FROM feedback WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    simpleExecute($sql);

    // Check if the deletion was successful
    if (simpleAffectedRows() > 0) {
        echo "Feedback deleted successfully.";
    } else {
        echo "Error deleting feedback: " . $stmt->error;
    }

    // Close statement and connection
    
    
} else {
    echo "Invalid request. Please provide a valid feedback ID.";
}
?>
