<?php
require_once('config/database.php');
$database = new Database();
$conn = $database->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $email = $_POST['signupEmail'];
    $password = $_POST['signupPassword'];
    $is_parent = isset($_POST['parentCheckbox']) ? 1 : 0;
    $number_of_kids = isset($_POST['numberOfKids']) ? $_POST['numberOfKids'] : 0;

    // Insert user information
    $insertUserSql = "INSERT INTO users (username, email, password, is_parent, number_of_kids) VALUES (:username, :email, :password, :is_parent, :number_of_kids)";

    $stmt = $conn->prepare($insertUserSql);
    $stmt->bindParam(':username', $email); // Use email as username for now
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':is_parent', $is_parent, PDO::PARAM_INT);
    $stmt->bindParam(':number_of_kids', $number_of_kids, PDO::PARAM_INT);

    if ($stmt->execute()) {
        // Get the ID of the newly inserted user
        $last_id = $conn->lastInsertId();

        // Insert information for each child
        for ($i = 1; $i <= $number_of_kids; $i++) {
            $kidGender = $_POST["kidGender$i"];
            $kidName = $_POST["kidName$i"];
            $kidAge = $_POST["kidAge$i"];

            // File upload for kid photo
            $targetDirectory = "uploads/";  // Update this path to your desired target directory
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

            // Insert child information
            $insertChildSql = "INSERT INTO children (user_id, kid_gender, kid_name, kid_age, kid_photo) VALUES (:user_id, :kid_gender, :kid_name, :kid_age, :kid_photo)";

            $childStmt = $conn->prepare($insertChildSql);
            $childStmt->bindParam(':user_id', $last_id, PDO::PARAM_INT);
            $childStmt->bindParam(':kid_gender', $kidGender);
            $childStmt->bindParam(':kid_name', $kidName);
            $childStmt->bindParam(':kid_age', $kidAge, PDO::PARAM_INT);
            $childStmt->bindParam(':kid_photo', $targetFile);

            if (!$childStmt->execute()) {
                echo "Error inserting child information: " . $childStmt->errorInfo()[2];
            }
        }

        // Redirect to login page or any other desired page after successful signup
        header("Location: login.html");
        exit();
    } else {
        echo "Error inserting user information: " . $stmt->errorInfo()[2];
    }
}
?>
