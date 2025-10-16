<?php
require_once('config/simple_database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the user ID from the POST data
    $userId = $_POST['user_id'];

    // Fetch children information for the selected user
    $getChildrenSql = "SELECT * FROM children WHERE user_id = " . intval($userId);
    $childrenResult = simpleQuery($getChildrenSql);

    // Fetch the result as an associative array
    $childrenData = [];
    foreach ($childrenResult as $child) {
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
