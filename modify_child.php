<?php
require_once('config/simple_database.php');
$database = new Database();
$conn = $database->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $childId = $_POST['child_id'];
    $newName = $_POST['new_name'];
    $newAge = $_POST['new_age'];

    // Mettez à jour les détails de l'enfant dans la base de données
    $updateChildSql = "UPDATE children SET kid_name = '$newName', kid_age = '$newAge' WHERE id = '$childId'";
    if ($conn->query($updateChildSql) === TRUE) {
        echo "Child details updated successfully.";
    } else {
        echo "Error updating child details: " . $conn->errorInfo()[2];
    }
}

$conn// PDO connection closes automatically;
?>
