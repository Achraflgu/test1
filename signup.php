<?php
// Start output buffering to prevent header issues
ob_start();
require_once('config/simple_database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $email = $_POST['signupEmail'];
    $password = $_POST['signupPassword'];
    $is_parent = isset($_POST['parentCheckbox']) ? 1 : 0;
    $number_of_kids = isset($_POST['numberOfKids']) ? $_POST['numberOfKids'] : 0;

    // Insert user information using simple query
    $is_parent_bool = $is_parent ? 'true' : 'false';
    $insertUserSql = "INSERT INTO users (username, email, password, is_parent, number_of_kids) VALUES ('" . addslashes($email) . "', '" . addslashes($email) . "', '" . addslashes($password) . "', " . $is_parent_bool . ", " . intval($number_of_kids) . ")";

    try {
        $result = simpleExecute($insertUserSql);
        
        if ($result) {
            // Get the ID of the newly inserted user
            $last_id = simpleGetLastId();

            // Insert information for each child
            for ($i = 1; $i <= $number_of_kids; $i++) {
                $kidGender = $_POST["kidGender$i"];
                $kidName = $_POST["kidName$i"];
                $kidAge = $_POST["kidAge$i"];

                // File upload for kid photo
                $targetDirectory = "uploads/";
                $targetFile = $targetDirectory . basename($_FILES["kidPhoto$i"]["name"]);
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

                // Check if file already exists
                if (file_exists($targetFile)) {
                    error_log("File already exists: $targetFile");
                    $uploadOk = 0;
                }

                // Check file size
                if ($_FILES["kidPhoto$i"]["size"] > 500000) {
                    error_log("File too large: " . $_FILES["kidPhoto$i"]["name"]);
                    $uploadOk = 0;
                }

                // Allow certain file formats
                $allowedFileTypes = ["jpg", "jpeg", "png", "gif"];
                if (!in_array($imageFileType, $allowedFileTypes)) {
                    error_log("Invalid file type: $imageFileType");
                    $uploadOk = 0;
                }

                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    $defaultPhoto = ($kidGender == 'male') ? 'uploads/defaultmale.jpg' : 'uploads/defaultfemale.jpg';
                    $targetFile = $defaultPhoto;
                } else {
                    if (move_uploaded_file($_FILES["kidPhoto$i"]["tmp_name"], $targetFile)) {
                        error_log("File uploaded successfully: " . basename($_FILES["kidPhoto$i"]["name"]));
                    } else {
                        error_log("Error uploading file: " . basename($_FILES["kidPhoto$i"]["name"]));
                    }
                }

                // Insert child information using simple query
                $insertChildSql = "INSERT INTO children (user_id, kid_gender, kid_name, kid_age, kid_photo) VALUES (" . intval($last_id) . ", '" . addslashes($kidGender) . "', '" . addslashes($kidName) . "', " . intval($kidAge) . ", '" . addslashes($targetFile) . "')";

                try {
                    simpleExecute($insertChildSql);
                } catch (Exception $e) {
                    error_log("Error inserting child information: " . $e->getMessage());
                }
            }

                    // Auto-login after successful signup
                    session_start();
                    $_SESSION['user_id'] = $last_id;
                    $_SESSION['email'] = $email;
                    $_SESSION['is_parent'] = $is_parent;
                    
                    // Redirect to login.php for auto-login processing
                    header("Location: login.php?auto_login=1&email=" . urlencode($email) . "&password=" . urlencode($password));
                    exit();
        } else {
            error_log("Error inserting user information");
            header("Location: signup.php?error=user_insert_failed");
            exit();
        }
    } catch (Exception $e) {
        error_log("Error: " . $e->getMessage());
        header("Location: signup.php?error=signup_failed");
        exit();
    }
}
?>
