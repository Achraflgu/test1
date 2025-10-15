<?php
require_once('config/database.php');
$database = new Database();
$conn = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer l'ID de l'utilisateur à supprimer
    $selectedUserId = $_POST['user_id'];

    // Supprimer les enfants associés à l'utilisateur
    $deleteChildrenSql = "DELETE FROM children WHERE user_id = $selectedUserId";
    $conn->query($deleteChildrenSql);

    // Supprimer l'utilisateur
    $deleteUserSql = "DELETE FROM users WHERE id = $selectedUserId";

    if ($conn->query($deleteUserSql) === TRUE) {
        echo 'User deleted successfully';
    } else {
        // Log any erreurs to the server logs
        error_log('Error deleting user: ' . $conn->errorInfo()[2]);
        echo 'Error deleting user: ' . $conn->errorInfo()[2];
    }
}
?>
