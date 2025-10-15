<?php
include('connexion.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Assuming you have an 'email' and 'password' column in your 'users' table
    $email = $_POST['newUserEmail'];
    $password = $_POST['newUserPassword'];

    // Insert new user
    $query = $conn->prepare("INSERT INTO users (email, password, number_of_kids) VALUES (?, ?, ?)");
    $initialNumberOfKids = isset($_POST['childrenData']) ? count(json_decode($_POST['childrenData'], true)) : 0;
    $query->bind_param("ssi", $email, $password, $initialNumberOfKids);

    if ($query->execute()) {
        // Get the ID of the newly inserted user
        $userId = $conn->insert_id;

        // Check if there are children
        if (isset($_POST['childrenData'])) {
            $childrenData = json_decode($_POST['childrenData'], true);

            // Insert children information
            foreach ($childrenData as $child) {
                $childGender = $child['gender'];
                $childName = $child['name'];
                $childAge = $child['age'];

                $childQuery = $conn->prepare("INSERT INTO children (user_id, kid_gender, kid_name, kid_age) VALUES (?, ?, ?, ?)");
                $childQuery->bind_param("isss", $userId, $childGender, $childName, $childAge);
                $childQuery->execute();
                $childQuery->close();
            }

            // Update the number_of_kids for the user
            $updateUserQuery = $conn->prepare("UPDATE users SET number_of_kids = ? WHERE id = ?");
            $numberOfKids = count($childrenData);
            $updateUserQuery->bind_param("ii", $numberOfKids, $userId);
            $updateUserQuery->execute();
            $updateUserQuery->close();
        }

        echo "User added successfully.";
    } else {
        echo "Error adding user: " . $conn->error;
    }

    $query->close();
    $conn->close();
}
?>
