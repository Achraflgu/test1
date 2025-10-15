<?php
// Replace these with your database connection details
include('connexion.php');

// Check if the ID parameter is set in the URL
if (isset($_GET['id'])) {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get the ID parameter from the URL
    $feedback_id = $_GET['id'];

    // Prepare and execute the SQL statement to delete the feedback
    $sql = "DELETE FROM feedback WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $feedback_id);
    $stmt->execute();

    // Check if the deletion was successful
    if ($stmt->affected_rows > 0) {
        echo "Feedback deleted successfully.";
    } else {
        echo "Error deleting feedback: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request. Please provide a valid feedback ID.";
}
?>
