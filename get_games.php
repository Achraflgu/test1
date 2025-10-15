<?php
require_once('config/simple_database.php');
$database = new Database();
$conn = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $category = $_GET['category'];
    $kidId = isset($_GET['kidId']) ? $_GET['kidId'] : null;

    // Initialize $condition
    $condition = '';

    // If the category is not 'all', fetch games only for the selected category
    if ($category !== 'all') {
        // Fetch hidden categories for the selected kid
        $sqlHiddenCategories = "SELECT hidden_games_categories FROM children WHERE id = $kidId";
        $resultHiddenCategories = $conn->query($sqlHiddenCategories);

        $hiddenCategories = [];

        if ($resultHiddenCategories && $resultHiddenCategories->num_rows > 0) {
            $rowHiddenCategories = $resultHiddenCategories->fetch_assoc();
            $hiddenCategories = explode(',', $rowHiddenCategories['hidden_games_categories']);
        }

        // Only include the category if it's not hidden
        if (!in_array($category, $hiddenCategories)) {
            $condition = "WHERE category = '$category'";
        } else {
            echo '<p>No games found for the selected category.</p>';
            exit(); // Stop further execution if the category is hidden
        }
    }

    // If the category is 'all', exclude games with hidden categories
    if ($category === 'all') {
        // Fetch all hidden categories for the selected kid
        $sqlAllHiddenCategories = "SELECT hidden_games_categories FROM children WHERE id = $kidId";
        $resultAllHiddenCategories = $conn->query($sqlAllHiddenCategories);

        $allHiddenCategories = [];

        if ($resultAllHiddenCategories && $resultAllHiddenCategories->num_rows > 0) {
            $rowAllHiddenCategories = $resultAllHiddenCategories->fetch_assoc();
            $allHiddenCategories = explode(',', $rowAllHiddenCategories['hidden_games_categories']);
        }

        if (!empty($allHiddenCategories)) {
            $condition = "WHERE category NOT IN ('" . implode("','", $allHiddenCategories) . "')";
        }
    }

    $gamesSql = "SELECT * FROM games $condition";
    $stmt = $conn->prepare($gamesSql);\nsimpleExecute($sql);\n$gamesResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($gamesResult === false) {
        // Handle the SQL error
        die('Error executing query: ' . $conn->errorInfo()[2]);
    }

    if ($gamesResult->num_rows > 0) {
        foreach ($gamesResult as $gameRow) {
           
            echo '<style>';
            echo '.game-card { display: flex; flex-direction: column; height: 100%; max-height: 480px; }'; // Adjust the height as needed
            echo '.card-img-top { flex: 1; object-fit: cover; }';
            echo '.card-body { overflow: hidden; text-overflow: ellipsis; }';
            echo '</style>';
            
            echo '<div class="col-md-4 mb-3">';
            echo '<div class="card game-card" data-game-id="' . $gameRow['id'] . '">';
            echo '<img src="' . $gameRow['photo'] . '" class="card-img-top" alt="Game Image">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . $gameRow['game_title'] . '</h5>';
            echo '<p class="card-text">' . $gameRow['description'] . '</p>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
           
            
        }
    } else {
        echo '<p>No games found for the selected category.</p>';
    }
}
?>
