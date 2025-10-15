<?php
// delete_child.php

include('connexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the child ID from the POST data
    $childId = $_POST['child_id'];

    // Get the user ID associated with the child
    $getUserSql = "SELECT user_id FROM children WHERE id = $childId";
    $userResult = $conn->query($getUserSql);

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
                echo "Error updating number_of_kids for user: " . $conn->error;
            }
        } else {
            echo "Error deleting child: " . $conn->error;
        }
    } else {
        echo "Error fetching user information: " . $conn->error;
    }
} else {
    echo "Invalid request method";
}
?>
