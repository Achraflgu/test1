<?php
// Include the database connection file
include('connexion.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the action is to add a child
    if ($_POST['action'] === 'add_child') {
        // Retrieve data from the form
        $childUserId = $_POST['childUserId'];
        $childName = $_POST['childName'];
        $childGender = $_POST['childGender'];
        $childAge = $_POST['childAge'];

        // Validate the data (you can add more validation as needed)

        // Insert the child data into the database
        $stmt = $conn->prepare("INSERT INTO children (user_id, kid_name, kid_gender, kid_age) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $childUserId, $childName, $childGender, $childAge);

        // Count the number of children for the given user ID
        $countChildrenQuery = $conn->prepare("SELECT COUNT(*) FROM children WHERE user_id = ?");
        $countChildrenQuery->bind_param("i", $childUserId);
        $countChildrenQuery->execute();
        $countChildrenQuery->bind_result($numberOfKids);
        $countChildrenQuery->fetch();
        $countChildrenQuery->close();

        // Update the number_of_kids for the user
        $updateUserQuery = $conn->prepare("UPDATE users SET number_of_kids = ? WHERE id = ?");
        $updateUserQuery->bind_param("ii", $numberOfKids, $childUserId);
        $updateUserQuery->execute();
        $updateUserQuery->close();

        if ($stmt->execute()) {
            // Child added successfully
            echo "Child added successfully!";
        } else {
            // Error adding child
            echo "Error adding child: " . $stmt->error;
        }

        $stmt->close();
    }
}

// Close the database connection
$conn->close();
?>
