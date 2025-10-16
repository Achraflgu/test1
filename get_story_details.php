<?php
require_once('config/simple_database.php');


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $storyId = $_GET['story_id'];

    $storySql = "SELECT * FROM stories WHERE id = " . intval($storyId);
    $storyResult = simpleQuery($storySql);

    if (count($storyResult) > 0) {
        $storyRow = $storyResult[0];

        echo '<h5 class="modal-title">' . $storyRow['story_title'] . '</h5>';
        echo '<p class="modal-text">' . $storyRow['description'] . '</p>';

        echo '<form id="linkForm">';
        echo '<div class="form-group">';
        echo '<label for="linkOfStories">Link of Stories:</label>';
        echo '<input type="text" class="form-control" id="linkOfStories" name="link_of_stories" value="' . $storyRow['link_of_stories'] . '">';
        echo '</div>';
        echo '<button type="button" class="btn btn-primary" onclick="updateLink()">Update Link</button>';
        echo '</form>';
    }
}
?>
