<?php
require_once('config/simple_database.php');


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $category = $_GET['category'];
    $kidId = isset($_GET['kidId']) ? $_GET['kidId'] : null;

    // Initialize $condition
    $condition = '';

    // If the category is not 'all', fetch activities only for the selected category
    if ($category !== 'all') {
        // Fetch hidden categories for the selected kid
        $sqlHiddenCategories = "SELECT hidden_activities_categories FROM children WHERE id = " . intval($kidId);
        $resultHiddenCategories = $result = simpleQuery($sqlHiddenCategories);

        $hiddenCategories = [];

        if (count($result) > 0) {
            $rowHiddenCategories = $result[0];
            $hiddenCategories = explode(',', $rowHiddenCategories['hidden_activities_categories']);
        }

        // Only include the category if it's not hidden
        if (!in_array($category, $hiddenCategories)) {
            $condition = "WHERE category = '$category'";
        } else {
            echo '<p>No activities found for the selected category.</p>';
            exit(); // Stop further execution if the category is hidden
        }
    }

    // If the category is 'all', exclude activities with hidden categories
    if ($category === 'all') {
        // Fetch all hidden categories for the selected kid
        $sqlAllHiddenCategories = "SELECT hidden_activities_categories FROM children WHERE id = " . intval($kidId);
        $resultAllHiddenCategories = simpleQuery($sqlAllHiddenCategories);

        $allHiddenCategories = [];

        if (count($resultAllHiddenCategories) > 0) {
            $rowAllHiddenCategories = $resultAllHiddenCategories[0];
            $hiddenCategoriesString = $rowAllHiddenCategories['hidden_activities_categories'] ?? '';
            $allHiddenCategories = !empty($hiddenCategoriesString) ? explode(',', $hiddenCategoriesString) : [];
        }

        if (!empty($allHiddenCategories)) {
            $condition = "WHERE category IS NULL OR category NOT IN ('" . implode("','", $allHiddenCategories) . "')";
        }
    }

    $activitiesSql = "SELECT * FROM activities $condition";
    $activitiesResult = simpleQuery($activitiesSql);

    if ($activitiesResult === false) {
        // Handle the SQL error
        die('Error executing query');
    }

    if (count($activitiesResult) > 0) {
        foreach ($activitiesResult as $activityRow) {
           
            echo '<style>';
echo '.activity-card { display: flex; flex-direction: column; height: 100%; max-height: 480px; }'; // Adjust the height as needed
echo '.card-img-top { flex: 1; object-fit: cover; }';
echo '.card-body { overflow: hidden; text-overflow: ellipsis; }';
echo '</style>';

echo '<div class="col-md-4 mb-3">';
echo '<div class="card activity-card" data-activity-id="' . $activityRow['id'] . '">';
echo '<img src="' . $activityRow['photo'] . '" class="card-img-top" alt="Activity Image">';
echo '<div class="card-body">';
echo '<h5 class="card-title">' . $activityRow['activity_title'] . '</h5>';
echo '<p class="card-text">' . $activityRow['description'] . '</p>';
echo '</div>';
echo '</div>';
echo '</div>';
            
            
        }
    } else {
        echo '<p>No activities found for the selected category.</p>';
    }
}
?>
