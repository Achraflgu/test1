<?php
// delete_child.php

require_once('config/simple_database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the child ID from the POST data
    $childId = intval($_POST['child_id']);

    // Get the user ID associated with the child
    $getUserSql = "SELECT user_id FROM children WHERE id = " . $childId;
    $userResult = simpleQuery($getUserSql);

    if ($userResult && count($userResult) > 0) {
        $userData = $userResult[0];
        $userId = $userData['user_id'];

        // Delete the child from the database
        $deleteChildSql = "DELETE FROM children WHERE id = " . $childId;

        if (simpleExecute($deleteChildSql)) {
            // Decrement the number_of_kids for the user
            $updateUserSql = "UPDATE users SET number_of_kids = number_of_kids - 1 WHERE id = " . intval($userId);

            if (simpleExecute($updateUserSql)) {
                echo "Child deleted successfully";
            } else {
                echo "Error updating number_of_kids for user";
            }
        } else {
            echo "Error deleting child";
        }
    } else {
        echo "Error fetching user information";
    }
} else {
    echo "Invalid request method";
}
?>
