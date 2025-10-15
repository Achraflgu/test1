<?php
require_once('config/simple_database.php');
$database = new Database();
$conn = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $category = $_GET['category'];
    $kidId = isset($_GET['kidId']) ? $_GET['kidId'] : null;

    // Initialize $condition
    $condition = '';

    // If the category is not 'all', fetch stories only for the selected category
    if ($category !== 'all') {
        $sqlHiddenCategories = "SELECT hidden_stories_categories FROM children WHERE id = $kidId";
        $resultHiddenCategories = $conn->query($sqlHiddenCategories);

        $hiddenCategories = [];

        if ($resultHiddenCategories && $resultHiddenCategories->num_rows > 0) {
            $rowHiddenCategories = $resultHiddenCategories->fetch_assoc();
            $hiddenCategories = explode(',', $rowHiddenCategories['hidden_stories_categories']);
        }

        // Only include the category if it's not hidden
        if (!in_array($category, $hiddenCategories)) {
            $condition = "WHERE category = '$category'";
        } else {
            echo '<p>No stories found for the selected category.</p>';
            exit(); // Stop further execution if the category is hidden
        }
    }

    // If the category is 'all', exclude stories with hidden categories
    if ($category === 'all') {
        $sqlAllHiddenCategories = "SELECT hidden_stories_categories FROM children WHERE id = $kidId";
        $resultAllHiddenCategories = $conn->query($sqlAllHiddenCategories);

        $allHiddenCategories = [];

        if ($resultAllHiddenCategories && $resultAllHiddenCategories->num_rows > 0) {
            $rowAllHiddenCategories = $resultAllHiddenCategories->fetch_assoc();
            $allHiddenCategories = explode(',', $rowAllHiddenCategories['hidden_stories_categories']);
        }

        if (!empty($allHiddenCategories)) {
            $condition = "WHERE category NOT IN ('" . implode("','", $allHiddenCategories) . "')";
        }
    }

    $storiesSql = "SELECT * FROM stories $condition";
    $stmt = $conn->prepare($storiesSql);\nsimpleExecute($sql);\n$storiesResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($storiesResult === false) {
        die('Error executing query: ' . $conn->errorInfo()[2]);
    }

    if ($storiesResult->num_rows > 0) {
        foreach ($storiesResult as $storyRow) {
echo '<style>';
echo '.story-card { display: flex; flex-direction: column; height: 100%; max-height: 480px; }'; // Adjust the height as needed
echo '.card-img-top { flex: 1; object-fit: cover; }';
echo '.card-body { overflow: hidden; text-overflow: ellipsis; }';
echo '</style>';

echo '<div class="col-md-4 mb-3">';
echo '<div class="card story-card" data-story-id="' . $storyRow['id'] . '">';
echo '<img src="' . $storyRow['photo'] . '" class="card-img-top" alt="Story Image">';
echo '<div class="card-body">';
echo '<h5 class="card-title">' . $storyRow['story_title'] . '</h5>';
echo '<p class="card-text">' . $storyRow['description'] . '</p>';
echo '</div>';
echo '</div>';
echo '</div>';

        }
    } else {
        echo '<p>No stories found for the selected category.</p>';
    }
}
?>
