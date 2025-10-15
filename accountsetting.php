<?php
// accountSetting.php

// Include your database connection
require_once('config/simple_database.php');
$database = new Database();
$conn = $database->getConnection();

// Ensure userId is set
if (!isset($_GET['userId'])) {
    // Handle the case where userId is not set
    echo "User ID is not set!";
    exit();
}

$selectedUserId = $_GET['userId']; // Get the user's ID from the URL

// Fetch user information from the database based on the selected ID
$sql = "SELECT * FROM users WHERE id = $selectedUserId";
simpleQuery($sql);
$kidsSql = "SELECT * FROM children WHERE user_id = $selectedUserId";
$stmt = $conn->prepare($kidsSql);\nsimpleExecute($sql);\n$kidsResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($result && $result->num_rows > 0) {
    $row = simpleFetchAll($result)[0];
    $selectedUserEmail = $row['email'];
    $storedPassword = $row['password']; // Assuming password is stored in plain text

    // Handle password update logic
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['currentPassword']) && isset($_POST['newPassword'])) {
        $currentPassword = trim($_POST['currentPassword']);
        $newPassword = trim($_POST['newPassword']);
        $confirmPassword = trim($_POST['confirmPassword']);

        // Verify the current password
        if ($currentPassword === $storedPassword) {
            // Validate new passwords
            if ($newPassword != $confirmPassword) {
                $alertMessage = "New passwords do not match!";
                $alertClass = "alert-danger";
            } else {
                // Update password in the database
                $updateSql = "UPDATE users SET password = '$newPassword' WHERE id = $selectedUserId";
                if ($conn->query($updateSql) === TRUE) {
                    $alertMessage = "Password updated successfully!";
                    $alertClass = "alert-success";
                } else {
                    $alertMessage = "Error updating password: " . $conn->errorInfo()[2];
                    $alertClass = "alert-danger";
                }
            }
        } else {
            $alertMessage = "Current password is incorrect!";
            $alertClass = "alert-danger";
        }
    }

    // Display user's email and password modification form
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Account Settings</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
        <!-- Include your custom CSS if needed -->
        <style>
          body {
    background: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)),
                url('./images/bg-accountsetting.png') no-repeat center center fixed;
                background-size: cover;
            background-position: center;
    padding: 10px 8%;
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh; /* Set the body height to the full viewport height */
    margin: 0;
    overflow: hidden;
    font-family: 'Poppins', sans-serif;
}



.row {
    display: flex;
    justify-content: space-between;
}

.left-container,
.right-container {
    margin-top: auto;
    background-color: rgba(255, 255, 255, 0.88);
    border-radius: 15px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    margin-bottom: 20px; /* Add some space between the containers */
    padding: 20px;
    height: 100%;
    min-height: 600px;
    transition: transform 0.3s ease-in-out;
    animation: popIn 0.5s ease-out;
    -webkit-animation:container .9s both;animation:container .9s both
    
}

.container {
    margin-top: 20px;
    padding: 20px;
    border-radius: 15px;
    transition: transform 0.3s ease-in-out;
}

.left-container:hover,
.right-container:hover {
    transform: scale(1.02);
    /* Slightly enlarge on hover */
    transition: transform 0.3s ease-in-out;
}

            @keyframes popIn {
                from {
                    transform: translateY(100%);
                    /* Start from the bottom */
                }

                to {
                    transform: translateY(0);
                    /* Move to the normal position */
                }
            }

            @-webkit-keyframes container {
                0% {
                    -webkit-transform: scale3d(1, 1, 1);
                    transform: scale3d(1, 1, 1);
                }

                30% {
                    -webkit-transform: scale3d(1.25, 0.75, 1);
                    transform: scale3d(1.25, 0.75, 1);
                }

                40% {
                    -webkit-transform: scale3d(0.75, 1.25, 1);
                    transform: scale3d(0.75, 1.25, 1);
                }

                50% {
                    -webkit-transform: scale3d(1.15, 0.85, 1);
                    transform: scale3d(1.15, 0.85, 1);
                }

                65% {
                    -webkit-transform: scale3d(0.95, 1.05, 1);
                    transform: scale3d(0.95, 1.05, 1);
                }

                75% {
                    -webkit-transform: scale3d(1.05, 0.95, 1);
                    transform: scale3d(1.05, 0.95, 1);
                }

                100% {
                    -webkit-transform: scale3d(1, 1, 1);
                    transform: scale3d(1, 1, 1);
                }
            }

            @keyframes container {
                0% {
                    -webkit-transform: scale3d(1, 1, 1);
                    transform: scale3d(1, 1, 1);
                }

                30% {
                    -webkit-transform: scale3d(1.25, 0.75, 1);
                    transform: scale3d(1.25, 0.75, 1);
                }

                40% {
                    -webkit-transform: scale3d(0.75, 1.25, 1);
                    transform: scale3d(0.75, 1.25, 1);
                }

                50% {
                    -webkit-transform: scale3d(1.15, 0.85, 1);
                    transform: scale3d(1.15, 0.85, 1);
                }

                65% {
                    -webkit-transform: scale3d(0.95, 1.05, 1);
                    transform: scale3d(0.95, 1.05, 1);
                }

                75% {
                    -webkit-transform: scale3d(1.05, 0.95, 1);
                    transform: scale3d(1.05, 0.95, 1);
                }

                100% {
                    -webkit-transform: scale3d(1, 1, 1);
                    transform: scale3d(1, 1, 1);
                }
            }

            .form-control {
                background-color: #fff;
            }

            .input-group-text {
                background-color: #fff;
            }

            .input-group-text input:focus {
                border-color: #5f2a72;
                /* Change to your desired color */
            }

            


            h2 {
            text-align: center;
            margin-bottom: 30px;
            font-family: 'Poppins', sans-serif;
    animation: coolAnimation 2s ease-in-out infinite; /* Add animation property */
    transform-origin: center; /* Set the transformation origin to the center */
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3); /* Add a subtle text shadow */
    margin-bottom: 50px;
    
        }
        @keyframes coolAnimation {
    0%, 100% {
        transform: scale3d(1, 1, 1); /* Initial and final state */
    }
    50% {
        transform: scale3d(1.2, 1.2, 1.2); /* Scale up in the middle of the animation */
    }
}

            .form-group label {
                color: #007bff;
                font-weight: bold;
            }

            .btn-primary {
                background-color: #007bff;
                border-color: #007bff;
                width: 100%;
            }

            .btn-primary:hover {
                background-color: #0056b3;
                border-color: #0056b3;
            }

            .icon {
                font-size: 24px;
                margin-right: 10px;
            }

            .password-toggle {
                cursor: pointer;
            }

            .alert {
                margin-top: 20px;
            }

            .col-md-6 {
                height: 100%;
                height: auto;
            }
        </style>
    </head>

    <body>
        <div class="container mt-5">
            <div class="row">
                <!-- Left container for password modification -->
                <div class="col-md-6">
                    <div class="left-container">
                        <h2><i class="fas fa-cogs icon"></i> Account Settings</h2>
                        <?php if (isset($alertMessage) && isset($alertClass)) { ?>
                            <div class="alert <?php echo $alertClass; ?>" role="alert">
                                <?php echo $alertMessage; ?>
                            </div>
                        <?php } ?>
                        <form method="post" action="">
                            <div class="mb-3">
                                <label for="inputEmail" class="form-label"><i class="fas fa-at icon"></i> Email</label>
                                <input type="email" class="form-control" id="inputEmail" value="<?php echo $selectedUserEmail; ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="inputCurrentPassword" class="form-label"><i class="fas fa-key icon"></i> Current Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="inputCurrentPassword" name="currentPassword" required>
                                    <span class="input-group-text password-toggle" onclick="togglePassword('inputCurrentPassword')">
                                        <i class="fas fa-eye"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="inputNewPassword" class="form-label"><i class="fas fa-lock icon"></i> New Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="inputNewPassword" name="newPassword" required>
                                    <span class="input-group-text password-toggle" onclick="togglePassword('inputNewPassword')">
                                        <i class="fas fa-eye"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="confirmPassword" class="form-label"><i class="fas fa-check-circle icon"></i> Confirm Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                                    <span class="input-group-text password-toggle" onclick="togglePassword('confirmPassword')">
                                        <i class="fas fa-eye"></i>
                                    </span>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save icon"></i> Update Password</button>
                        </form>
                    </div>
                </div>
                <!-- Right container for kids' information -->
                <div class="col-md-6">
                    <div class="right-container">
                    <h2><i class="fas fa-users icon"></i> Kids Information</h2>
                        <div class="kids-management-container" style="max-height: 500px; overflow-y: auto;">
                            <table class="table table-bordered table-striped">
                                <thead class="thead-dark" style="position: sticky; top: 0; background-color: white; z-index: 1;">
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Photo</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($kidsResult as $kidRow) {
                                        echo "<tr>";
                                        echo "<td>" . $kidRow["id"] . "</td>";
                                        echo "<td>" . $kidRow["kid_name"] . "</td>";
                                        echo "<td><img src='" . $kidRow["kid_photo"] . "' alt='Kid Photo' style='max-width: 50px; max-height: 50px;'></td>";
                                        echo "<td><a href='delete_kid.php?id=" . $kidRow["id"] . "&userId=" . $selectedUserId . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this kid?\")'><i class='fas fa-trash-alt'></i> Delete</a></td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add your additional scripts here -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            function togglePassword(inputId) {
                var passwordInput = document.getElementById(inputId);
                var icon = passwordInput.nextElementSibling.querySelector('i');

                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            }
        </script>
    </body>

    </html>
<?php
} else {
    // Handle the case where the selected user ID is not valid
    echo "Invalid user ID!";
}
?>