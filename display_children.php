<?php
include('connexion.php');

// Fonction pour afficher les enfants pour un ID utilisateur donné
function displayChildrenForUser($userId)
{
    global $conn;

    $childrenSql = "SELECT * FROM children WHERE user_id = $userId";
    $childrenResult = $conn->query($childrenSql);

    $childrenData = array();

    while ($childRow = $childrenResult->fetch_assoc()) {
        $childrenData[] = $childRow;
    }

    return $childrenData;
}

// Traitement des requêtes AJAX
if (isset($_POST['action'])) {
    if ($_POST['action'] == 'get_users') {
        // Requête AJAX pour obtenir et afficher les utilisateurs
        $usersSql = "SELECT * FROM users";
        $usersResult = $conn->query($usersSql);

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

        while ($userRow = $usersResult->fetch_assoc()) {
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

        // Perform the database insertion (replace this with your actual insertion code)
        $insertChildSql = "INSERT INTO children (user_id, kid_name) VALUES ('$childUserId', '$childName')";
        $conn->query($insertChildSql);

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
        $updateChildSql = "UPDATE children SET kid_name = '$modifyChildName', kid_age = '$modifyChildAge' WHERE id = $modifyChildId";

        if ($conn->query($updateChildSql) === TRUE) {
            echo 'Child updated successfully';
        } else {
            // Log any errors to the server logs
            error_log('Error updating child: ' . $conn->error);
            echo 'Error updating child: ' . $conn->error;
        }
    } elseif ($_POST['action'] == 'delete_child') {
        // Requête AJAX pour supprimer un enfant
        $deleteChildId = $_POST['deleteChildId'];

        // Supprimer l'enfant de la base de données
        $deleteChildSql = "DELETE FROM children WHERE id = $deleteChildId";

        if ($conn->query($deleteChildSql) === TRUE) {
            echo 'Child deleted successfully';
        } else {
            // Log any errors to the server logs
            error_log('Error deleting child: ' . $conn->error);
            echo 'Error deleting child: ' . $conn->error;
        }
    }
}
?>
