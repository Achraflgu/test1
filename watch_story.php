<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Watch Story</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            transition: background-color 0.5s;
        }

        body.male-background {
    background: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)),
                url(./images/bg_games_male.png) center bottom / cover no-repeat fixed; /* Fix the order of properties and adjust the background property */
    width: 100%;
    height: 100vh;
    padding: 10px 8% 0; /* Remove bottom padding to eliminate the white border */
    box-sizing: border-box; /* Ensure padding is included in the total height */
    position: relative;
    background-attachment: fixed; /* Add this property for fixed background attachment */
}


   
   
  

    body.female-background {
    background: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)),
                url(./images/bg_games_female3.png) fixed no-repeat center bottom; /* Add "fixed" to make the background fixed */
    background-size: cover;
    width: 100%;
    height: 100vh;
    padding: 10px 8% 0; /* Remove bottom padding to eliminate the white border */
    box-sizing: border-box; /* Ensure padding is included in the total height */
    background-attachment: fixed; /* Add this property for fixed background attachment */
}

        .container {
            background-color: rgba(255, 255, 255, 0.4); /* Semi-transparent white container background */
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 50px;
            animation: fadeIn 0.5s ease-in-out;
            position: relative;
            z-index: 1;
        }

        h2 {
            text-align: center;
            
            font-family: 'Poppins', sans-serif;
    animation: coolAnimation 2s ease-in-out infinite; /* Add animation property */
    transform-origin: center; /* Set the transformation origin to the center */
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3); /* Add a subtle text shadow */
    margin-bottom: 50px;
    
        }
        @keyframes coolAnimation {
    0%, 100% {
        transform: scale3d(1, 1, 1); /* Initial and final state */
    }
    50% {
        transform: scale3d(1.2, 1.2, 1.2); /* Scale up in the middle of the animation */
    }
}
        p {
            text-align: center;
        }

        video,
        iframe {
            width: 100%;
            height: 700px;
        }

        .related-stories {
            margin-top: 30px;
        }

        .related-stories h3 {
            color: #007bff;
            margin-bottom: 20px;
        }

        .story-card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            cursor: pointer;
            transition: transform 0.3s ease-in-out;
        }

        .story-card:hover {
            transform: scale(1.05);
        }

        .confirmation-dialog {
            display: none;
        }

        .back-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007BFF;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s ease-in-out;
        }

        .back-button:hover {
            text-decoration: none;
            transform: translateY(-2px);
            box-shadow: 0px 6px 10px rgba(0, 0, 0, 0.2);
            color: #fff;
        }

        .back-button i {
            margin-right: 5px;
        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <a href="javascript:history.back()" class="back-button">
            <i class="fas fa-arrow-left"></i> Back
        </a>
        <?php
        require_once('config/simple_database.php');


        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $storyId = $_GET['story_id'];

            // Fetch story details based on the provided story ID
            $storySql = "SELECT * FROM stories WHERE id = 0";
            $stmt = $conn->prepare($storySql);\nsimpleExecute($sql);\n$storyResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($storyResult->num_rows > 0) {
                $storyRow = $storyResult->fetch_assoc();

                echo '<h2>' . $storyRow['story_title'] . '</h2>';
                echo '<p>' . $storyRow['description'] . '</p>';

                // Check if the link is a local file (assuming it starts with 'local:')
                if (strpos($storyRow['link_of_stories'], 'local:') === 0) {
                    // Remove 'local:' prefix
                    $localFilePath = substr($storyRow['link_of_stories'], 6);

                    // Display local video using the video tag
                    echo '<div>';
                    echo '<video width="100%" height="700px" controls>';
                    echo '<source src="' . $localFilePath . '" type="video/mp4">';
                    echo 'Your browser does not support the video tag.';
                    echo '</video>';
                    echo '</div>';
                } else {
                    // Display the embedded content (assuming it's a direct link)
                    echo '<div>';
                    echo '<iframe width="100%" height="700px" src="' . $storyRow['link_of_stories'] . '" frameborder="0" allowfullscreen></iframe>';
                    echo '</div>';
                }

                // Fetch other stories with the same category
                $category = $storyRow['category'];
                $otherStoriesSql = "SELECT * FROM stories WHERE category = '$category' AND id != $storyId LIMIT 4";
                $stmt = $conn->prepare($otherStoriesSql);\nsimpleExecute($sql);\n$otherStoriesResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if ($otherStoriesResult->num_rows > 0) {
                    echo '<div class="related-stories">';
                    echo '<h3>Related Stories :</h3>';
                    echo '<div class="row">';

                    foreach ($otherStoriesResult as $otherStoryRow) {

                        echo '<style>';
                        echo '.story-card { display: flex; flex-direction: column; height: 100%; max-height: 480px; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; cursor: pointer; transition: box-shadow 0.3s ease-in-out; }';
                        echo '.story-card:hover { box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }';
                        echo '.story-card img { flex: 1; height: 250px; object-fit: cover; width: 100%; border-radius: 5px;}';
                        echo '.story-card-content { padding: 10px; }';
                        echo '</style>';

                        echo '<div class="col-md-3">';
                        echo '<div class="story-card" onclick="showConfirmationDialog(' . $otherStoryRow['id'] . ', \'' . $otherStoryRow['story_title'] . '\')">';
                        echo '<img src="' . $otherStoryRow['photo'] . '" alt="' . $otherStoryRow['story_title'] . '" class="img-fluid">';
                        echo '<div class="story-card-content">';
                        echo '<h5>' . $otherStoryRow['story_title'] . '</h5>';
                        echo '<p>' . $otherStoryRow['description'] . '</p>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }

                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>Story not found.</p>';
            }
        }
        ?>
    </div>

    <!-- Confirmation Dialog -->
    <div class="modal fade" id="confirmationDialog" tabindex="-1" role="dialog" aria-labelledby="confirmationDialogLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationDialogLabel">Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to watch another story?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary" onclick="watchAnotherStory()">Yes</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
        function showConfirmationDialog(storyId, storyTitle) {
            // Set data attributes for the selected story
            $('#confirmationDialog').data('story-id', storyId);
            $('#confirmationDialog').data('story-title', storyTitle);

            // Show confirmation dialog
            $('#confirmationDialog').modal('show');
        }

        function logHistoricalData(pageName, kidId, itemId, itemName) {
            // Send an AJAX request to log historical data
            $.ajax({
                url: "log_history.php",
                method: "POST",
                data: {
                    kidId: kidId,
                    pageName: pageName,
                    itemId: itemId,
                    itemName: itemName
                },
                success: function(response) {
                    // Handle success, if needed
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    // Handle error, if needed
                    console.error(error);
                }
            });
        }

        function watchAnotherStory() {
            // Get data attributes for the selected story
            const storyId = $('#confirmationDialog').data('story-id');
            const storyTitle = $('#confirmationDialog').data('story-title');

            // Log historical data
            var selectedKidId = getParameterByName('kid_id');
            var pageName = 'stories - <span style="font-weight: bold;">' + storyTitle + '</span>';
            logHistoricalData(pageName, selectedKidId, storyId, storyTitle);

            // Redirect to the watch story page for the selected story
            window.location.href = 'watch_story.php?story_id=' + storyId;
        }

        // Function to get query parameters from the URL
        function getParameterByName(name, url) {
            if (!url) url = window.location.href;
            name = name.replace(/[\[\]]/g, "\\$&");
            var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, " "));
        }
        // Assuming you have the selectedKidId available
        var selectedKidId = <?php echo isset($_GET['kid_id']) ? $_GET['kid_id'] : 0; ?>;
        var bodyElement = document.querySelector('body');

        // Fetch kid's genre and apply background color
        if (selectedKidId > 0) {
            fetch('get_kid_genre.php?kidId=' + selectedKidId)
                .then(response => response.json())
                .then(data => {
                    if (data.hasOwnProperty('kidGenre')) {
                        var kidGenre = data.kidGenre.toLowerCase();
                        bodyElement.classList.add(kidGenre + '-background');
                    }
                })
                .catch(error => console.error(error));
        }
    </script>

</body>

</html>