<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Control Panel</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <style>
        body{
            background-color: rgba(0, 0, 0, 0);
        }
        table {
    background-color: white;
}
    </style>
</head>

<body>
<!-- Users Section -->
<div id="users" class="section">
    <!-- User management content goes here -->
    <div class="container mt-5">

        <!-- User Table -->
        <div class="user-management-container" style="max-height: 500px; overflow-y: auto;">
    <table class="table table-bordered table-striped">
        <thead class="thead-dark" style="position: sticky; top: 0; background-color: white; z-index: 1;">
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Number of Kids</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include('connexion.php');
            $usersSql = "SELECT * FROM users";
            $usersResult = $conn->query($usersSql);

            while ($userRow = $usersResult->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $userRow['id'] . '</td>';
                echo '<td>' . $userRow['email'] . '</td>';
                echo '<td>' . $userRow['number_of_kids'] . '</td>';
                echo '<td>
                <div class="btn-group" role="group">
                        <button class="btn btn-danger deleteUserBtn" data-user-id="' . $userRow['id'] . '"><i class="fas fa-trash-alt"></i> Delete</button>
                        </div>
                        </td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
</div>

    </div>
</div>




    <script>
        $(document).ready(function () {
            // Event listener for delete user button
            $('.deleteUserBtn').click(function () {
                // Get the user ID
                var userId = $(this).data('user-id');

                // Ask for confirmation before deleting
                var confirmation = confirm("Are you sure you want to delete this user?");

                // If the user clicks "OK" in the confirmation dialog
                if (confirmation) {
                    // Perform the deletion
                    $.ajax({
                        type: 'POST',
                        url: 'delete_user.php',
                        data: { user_id: userId },
                        success: function (response) {
                            alert(response);
                            // Update the user table or perform other actions as needed
                            // Example: Reload the page to reflect the changes
                            location.reload();
                        },
                        error: function (xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>
