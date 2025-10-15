<?php
include('connexion.php');

// Fetch unique categories from the stories table
$categoriesSql = "SELECT DISTINCT category FROM games";
$categoriesResult = $conn->query($categoriesSql);

$categories = array();

if ($categoriesResult->num_rows > 0) {
    while ($row = $categoriesResult->fetch_assoc()) {
        $categories[] = $row['category'];
    }
}

// Return the categories as a JSON array
header('Content-Type: application/json');
echo json_encode($categories);
?>
