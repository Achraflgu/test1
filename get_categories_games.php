<?php
require_once('config/database.php');


// Fetch unique categories from the stories table
$categoriesSql = "SELECT DISTINCT category FROM games";
$stmt = $conn->prepare($categoriesSql);\n$stmt->execute();\n$categoriesResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

$categories = array();

if ($categoriesResult->num_rows > 0) {
    foreach ($categoriesResult as $row) {
        $categories[] = $row['category'];
    }
}

// Return the categories as a JSON array
header('Content-Type: application/json');
echo json_encode($categories);
?>
