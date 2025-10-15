<!-- process_form.php -->

<?php
require_once('config/database.php');
$database = new Database();
$conn = $database->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_GET['action'];
    $type = $_GET['type'];

    switch ($action) {
        case 'add':
            if ($type == 'user') {
                // Handle user addition logic
                $email = $_POST['email'];
                $password = $_POST['password'];

                // Add user to the database
                $addUserSql = "INSERT INTO users (email, password) VALUES ('$email', '$password')";
                $conn->query($addUserSql);
            } elseif ($type == 'child') {
                // Handle child addition logic
                $email = $_POST['email'];
                $password = $_POST['password'];
                $gender = $_POST['gender'];
                $name = $_POST['name'];
                $age = $_POST['age'];

                // Add child to the database
                $addChildSql = "INSERT INTO children (user_id, kid_gender, kid_name, kid_age) VALUES ('$userId', '$gender', '$name', $age)";
                $conn->query($addChildSql);
            }
            break;

        case 'edit':
            // Handle edit logic (similar to add logic but with UPDATE queries)
            break;

        default:
            echo "Invalid action.";
    }
}

// Close the database connection
$conn// PDO connection closes automatically;
?>
