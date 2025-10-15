<?php
session_start();
require_once('config/simple_database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming user ID is stored in the session
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];

        $kidName = $_POST['newKidName'];
        $gender = $_POST['newKidGender'];
        $age = $_POST['newKidAge'];

        // Process the uploaded photo
        $targetDir = "uploads/";
        $targetFile = ""; // Initialize targetFile
        $sql = ""; // Initialize sql

        // Check if a photo is uploaded
        if (!empty($_FILES["newKidPhoto"]["name"])) {
            $targetFile = $targetDir . basename($_FILES["newKidPhoto"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            // Check if the image file is a real image or fake image
            $check = getimagesize($_FILES["newKidPhoto"]["tmp_name"]);
            if ($check === false) {
                echo "File is not an image.";
                $uploadOk = 0;
            }

            // Check file size
            if ($_FILES["newKidPhoto"]["size"] > 500000) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }

            // Allow certain file formats
            $allowedFormats = ["jpg", "jpeg", "png", "gif"];
            if (!in_array($imageFileType, $allowedFormats)) {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
            } else {
                // Move the uploaded file to the target directory
                if (move_uploaded_file($_FILES["newKidPhoto"]["tmp_name"], $targetFile)) {
                    // Insert data into the 'children' table with user_id
                    $sql = "INSERT INTO children (user_id, kid_gender, kid_name, kid_age, kid_photo) VALUES (" . intval($userId) . ", '" . addslashes($gender) . "', '" . addslashes($kidName) . "', " . intval($age) . ", '" . addslashes($targetFile) . "')";
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        } else {
            // No photo uploaded, set default photo based on gender
            $defaultPhoto = ($gender == 'male') ? 'defaultmale.jpg' : 'defaultfemale.jpg';
            $targetFile = $targetDir . $defaultPhoto;

            // Insert data into the 'children' table with user_id
            $sql = "INSERT INTO children (user_id, kid_gender, kid_name, kid_age, kid_photo) VALUES (" . intval($userId) . ", '" . addslashes($gender) . "', '" . addslashes($kidName) . "', " . intval($age) . ", '" . addslashes($targetFile) . "')";
        }

        // Only execute if we have a valid SQL statement
        if (!empty($sql)) {
            try {
                $result = simpleExecute($sql);
                if ($result) {
                // Check if userId is already present in the URL
                $referer = $_SERVER['HTTP_REFERER'];
                if (strpos($referer, 'userId') === false) {
                    // If userId is not present, append it to the URL
                    $referer .= (strpos($referer, '?') !== false ? '&' : '?') . "userId=$userId";
                }

                    // Redirect back to the referring page with or without userId parameter
                    header("Location: " . $referer);
                    exit();
                } else {
                    echo "Error: Failed to insert child profile";
                }
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo "Error: No SQL statement generated";
        }
    } else {
        echo "User ID not set in the session.";
    }
}

// Close the database connection
$conn// PDO connection closes automatically;
?>
