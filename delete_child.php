<?php
// delete_child.php

require_once('config/database.php');
$database = new Database();
$conn = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the child ID from the POST data
    $childId = $_POST['child_id'];

    // Get the user ID associated with the child
    $getUserSql = "SELECT user_id FROM children WHERE id = $childId";
    $stmt = $conn->prepare($getUserSql);\n$stmt->execute();\n$userResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($userResult && $userResult->num_rows > 0) {
        $userData = $userResult->fetch_assoc();
        $userId = $userData['user_id'];

        // Delete the child from the database
        $deleteChildSql = "DELETE FROM children WHERE id = $childId";

        if ($conn->query($deleteChildSql)) {
            // Decrement the number_of_kids for the user
            $updateUserSql = "UPDATE users SET number_of_kids = number_of_kids - 1 WHERE id = $userId";

            if ($conn->query($updateUserSql)) {
                echo "Child deleted successfully";
            } else {
                echo "Error updating number_of_kids for user: " . $conn->errorInfo()[2];
            }
        } else {
            echo "Error deleting child: " . $conn->errorInfo()[2];
        }
    } else {
        echo "Error fetching user information: " . $conn->errorInfo()[2];
    }
} else {
    echo "Invalid request method";
}
?>
