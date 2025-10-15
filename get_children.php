<?php
include('connexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the user ID from the POST data
    $userId = $_POST['user_id'];

    // Fetch children information for the selected user
    $getChildrenSql = "SELECT * FROM children WHERE user_id = $userId";
    $childrenResult = $conn->query($getChildrenSql);

    // Fetch the result as an associative array
    $childrenData = [];
    while ($child = $childrenResult->fetch_assoc()) {
        $childrenData[] = [
            'id' => $child['id'],
            'name' => $child['kid_name'],
            'age' => $child['kid_age'],
        ];
    }

    // Convert the array to JSON and echo the result
    echo json_encode($childrenData);
}
?>
