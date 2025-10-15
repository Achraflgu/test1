<?php
include('connexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $newEmail = $_POST['newEmail'];
    $newPassword = $_POST['newPassword'];  // Le mot de passe doit être haché avant la mise à jour
    $selectedUserId = $_POST['selectedUserId'];

    // Hacher le nouveau mot de passe

    // Mettre à jour l'email et le mot de passe de l'utilisateur dans la base de données
    $updateUserSql = "UPDATE users SET email = '$newEmail', password = '$newPassword' WHERE id = $selectedUserId";

    if ($conn->query($updateUserSql) === TRUE) {
        echo 'User updated successfully';
    } else {
        // Log any errors to the server logs
        error_log('Error updating user: ' . $conn->error);
        echo 'Error updating user: ' . $conn->error;
    }
}
?>
