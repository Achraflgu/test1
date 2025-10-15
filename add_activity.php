<?php
// add_activity.php

include('connexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newTitle = $_POST['newTitle'];
    $newDescription = $_POST['newDescription'];
    $newLink = $_POST['newLink'];
    $newPhoto = $_POST['newPhoto'];
    $newCategory = $_POST['newCategory'];

    // Implement logic to add the new activity to the database
    $insertSql = "INSERT INTO activities (activity_title, description, link_of_activities, photo, category)
                  VALUES ('$newTitle', '$newDescription', '$newLink', '$newPhoto', '$newCategory')";

    if ($conn->query($insertSql) === TRUE) {
        echo json_encode(['success' => 'Activity added successfully']);
    } else {
        echo json_encode(['error' => 'Error adding activity']);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}
?>
