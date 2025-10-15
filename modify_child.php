<?php
include('connexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $childId = $_POST['child_id'];
    $newName = $_POST['new_name'];
    $newAge = $_POST['new_age'];

    // Mettez à jour les détails de l'enfant dans la base de données
    $updateChildSql = "UPDATE children SET kid_name = '$newName', kid_age = '$newAge' WHERE id = '$childId'";
    if ($conn->query($updateChildSql) === TRUE) {
        echo "Child details updated successfully.";
    } else {
        echo "Error updating child details: " . $conn->error;
    }
}

$conn->close();
?>
