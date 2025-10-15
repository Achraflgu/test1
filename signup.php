<?php
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
                    echo "Sorry, file already exists.";
                    $uploadOk = 0;
                }

                // Check file size
                if ($_FILES["kidPhoto$i"]["size"] > 500000) {
                    echo "Sorry, your file is too large.";
                    $uploadOk = 0;
                }

                // Allow certain file formats
                $allowedFileTypes = ["jpg", "jpeg", "png", "gif"];
                if (!in_array($imageFileType, $allowedFileTypes)) {
                    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    $uploadOk = 0;
                }

                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    $defaultPhoto = ($kidGender == 'male') ? 'uploads/defaultmale.jpg' : 'uploads/defaultfemale.jpg';
                    $targetFile = $defaultPhoto;
                } else {
                    if (move_uploaded_file($_FILES["kidPhoto$i"]["tmp_name"], $targetFile)) {
                        echo "The file " . basename($_FILES["kidPhoto$i"]["name"]) . " has been uploaded and saved.";
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                }

                // Insert child information using simple query
                $insertChildSql = "INSERT INTO children (user_id, kid_gender, kid_name, kid_age, kid_photo) VALUES (" . intval($last_id) . ", '" . addslashes($kidGender) . "', '" . addslashes($kidName) . "', " . intval($kidAge) . ", '" . addslashes($targetFile) . "')";

                try {
                    simpleExecute($insertChildSql);
                } catch (Exception $e) {
                    echo "Error inserting child information: " . $e->getMessage();
                }
            }

            // Redirect to login page or any other desired page after successful signup
            header("Location: login.html");
            exit();
        } else {
            echo "Error inserting user information.";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
