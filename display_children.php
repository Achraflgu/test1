<?php
require_once('config/simple_database.php');

// Fonction pour afficher les enfants pour un ID utilisateur donné
function displayChildrenForUser($userId)
{
    $childrenSql = "SELECT * FROM children WHERE user_id = " . intval($userId);
    $childrenResult = simpleQuery($childrenSql);

    return $childrenResult;
}

// Traitement des requêtes AJAX
if (isset($_POST['action'])) {
    if ($_POST['action'] == 'get_users') {
        // Requête AJAX pour obtenir et afficher les utilisateurs
        $usersSql = "SELECT * FROM users";
        $usersResult = simpleQuery($usersSql);

        echo '<table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>Number of Kids</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($usersResult as $userRow) {
            echo '<tr>
                    <td>' . $userRow['id'] . '</td>
                    <td>' . $userRow['email'] . '</td>
                    <td>' . $userRow['number_of_kids'] . '</td>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input user-radio" type="radio" name="selected_user" value="' . $userRow['id'] . '">
                        </div>
                    </td>
                </tr>';
        }

        echo '</tbody></table>';
    } elseif ($_POST['action'] == 'get_children') {
        // Requête AJAX pour obtenir et afficher les enfants pour un utilisateur
        $userId = $_POST['user_id'];
        $children = displayChildrenForUser($userId);

        echo '<table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User ID</th>
                        <th>Gender</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($children as $childRow) {
            echo '<tr>
                    <td>' . $childRow['id'] . '</td>
                    <td>' . $childRow['user_id'] . '</td>
                    <td>' . $childRow['kid_gender'] . '</td>
                    <td id="childName_' . $childRow['id'] . '">' . $childRow['kid_name'] . '</td>
                    <td id="childAge_' . $childRow['id'] . '">' . $childRow['kid_age'] . '</td>
                    <td>
                        <button class="btn btn-warning btn-sm modifyChildBtn" data-child-id="' . $childRow['id'] . '">Modify</button>
                        <button class="btn btn-danger btn-sm deleteChildBtn" data-child-id="' . $childRow['id'] . '">Delete</button>
                    </td>
                </tr>';
        }

        echo '</tbody></table>';
    } elseif ($_POST['action'] == 'add_child') {
        // Requête AJAX pour ajouter un nouvel enfant
        $childUserId = $_POST['childUserId'];
        $childName = $_POST['childName'];

        // Perform the database insertion
        $insertChildSql = "INSERT INTO children (user_id, kid_name) VALUES (" . intval($childUserId) . ", '" . addslashes($childName) . "')";
        simpleExecute($insertChildSql);

        // Afficher la table mise à jour des enfants
        $children = displayChildrenForUser($childUserId);

        echo '<table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User ID</th>
                        <th>Gender</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($children as $childRow) {
            echo '<tr>
                    <td>' . $childRow['id'] . '</td>
                    <td>' . $childRow['user_id'] . '</td>
                    <td>' . $childRow['kid_gender'] . '</td>
                    <td id="childName_' . $childRow['id'] . '">' . $childRow['kid_name'] . '</td>
                    <td id="childAge_' . $childRow['id'] . '">' . $childRow['kid_age'] . '</td>
                    <td>
                        <button class="btn btn-warning btn-sm modifyChildBtn" data-child-id="' . $childRow['id'] . '">Modify</button>
                        <button class="btn btn-danger btn-sm deleteChildBtn" data-child-id="' . $childRow['id'] . '">Delete</button>
                    </td>
                </tr>';
        }

        echo '</tbody></table>';
    } elseif ($_POST['action'] == 'modify_child') {
        // Requête AJAX pour modifier un enfant
        $modifyChildId = $_POST['modifyChildId'];
        $modifyChildName = $_POST['modifyChildName'];
        $modifyChildAge = $_POST['modifyChildAge'];

        // Mettre à jour les données de l'enfant dans la base de données
        $updateChildSql = "UPDATE children SET kid_name = '" . addslashes($modifyChildName) . "', kid_age = " . intval($modifyChildAge) . " WHERE id = " . intval($modifyChildId);

        try {
            simpleExecute($updateChildSql);
            echo 'Child updated successfully';
        } catch (Exception $e) {
            error_log('Error updating child: ' . $e->getMessage());
            echo 'Error updating child: ' . $e->getMessage();
        }
    } elseif ($_POST['action'] == 'delete_child') {
        // Requête AJAX pour supprimer un enfant
        $deleteChildId = $_POST['deleteChildId'];

        // Supprimer l'enfant de la base de données
        $deleteChildSql = "DELETE FROM children WHERE id = " . intval($deleteChildId);

        try {
            simpleExecute($deleteChildSql);
            echo 'Child deleted successfully';
        } catch (Exception $e) {
            error_log('Error deleting child: ' . $e->getMessage());
            echo 'Error deleting child: ' . $e->getMessage();
        }
    }
}
?>
