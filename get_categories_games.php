<?php
require_once('config/simple_database.php');

// Fetch unique categories from the games table
$categoriesSql = "SELECT DISTINCT category FROM games";
$categoriesResult = simpleQuery($categoriesSql);

$categories = array();

if (count($categoriesResult) > 0) {
    foreach ($categoriesResult as $row) {
        $categories[] = $row['category'];
    }
}

// Return the categories as a JSON array
header('Content-Type: application/json');
echo json_encode($categories);
?>
