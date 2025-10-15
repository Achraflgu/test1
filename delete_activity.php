<?php
// delete_activity.php

include('connexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $activityId = $_POST['activityId'];

    // Implement logic to delete the activity from the database
    $deleteSql = "DELETE FROM activities WHERE id = $activityId";

    if ($conn->query($deleteSql) === TRUE) {
        echo json_encode(['success' => 'Activity deleted successfully']);
    } else {
        echo json_encode(['error' => 'Error deleting activity']);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}
?>
