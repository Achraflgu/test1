<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Play Game</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <style>
        body {
            transition: background-color 0.5s;
        }

        body.male-background {
    background: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)),
                url(./images/bg_Stories_male.png) center bottom / cover no-repeat fixed; /* Fix the order of properties and adjust the background property */
    width: 100%;
    height: 100vh;
    padding: 10px 8% 0; /* Remove bottom padding to eliminate the white border */
    box-sizing: border-box; /* Ensure padding is included in the total height */
    position: relative;
    background-attachment: fixed; /* Add this property for fixed background attachment */
}


   
   
  

    body.female-background {
    background: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)),
                url(./images/bg_Stories_female.png) fixed no-repeat center bottom; /* Add "fixed" to make the background fixed */
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
        .embed-container {
            position: relative;
            overflow: hidden;
            padding-top: 56.25%;
            /* 16:9 aspect ratio */
        }

        .embed-container iframe,
        .embed-container embed,
        .embed-container object,
        .embed-container video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
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

        .more-games {
            margin-top: 30px;
        }

        .more-games h3 {
            color: #007bff;
            margin-bottom: 20px;
        }

        .more-games .game-card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            cursor: pointer;
            /* Add cursor pointer */
            transition: transform 0.3s ease-in-out;
            /* Add smooth transition */
        }

        .more-games .game-card:hover {
            transform: scale(1.05);
            /* Add hover effect */
        }

        .more-games img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .confirmation-dialog {
            display: none;
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
            $gameId = $_GET['game_id'];

            // Fetch current game details based on the provided game ID
            $gameSql = "SELECT * FROM games WHERE id = " . intval($gameId);
            $gameResult = simpleQuery($gameSql);

            if (count($gameResult) > 0) {
                $gameRow = $gameResult[0];

                echo '<h2 class="text-center">' . $gameRow['game_title'] . '</h2>';
                echo '<p class="text-center">' . $gameRow['description'] . '</p>';

                // Check if the link is a local file (assuming it starts with 'local:')
                if (strpos($gameRow['link_of_games'], 'local:') === 0) {
                    // Remove 'local:' prefix
                    $localFilePath = substr($gameRow['link_of_games'], 6);

                    // Display local game using the embed tag
                    echo '<div class="embed-container mx-auto">';
                    echo '<embed src="' . $localFilePath . '">';
                    echo '</div>';
                } else {
                    // Display the game link (assuming it's a direct link)
                    echo '<div class="embed-container mx-auto">';
                    echo '<iframe src="' . $gameRow['link_of_games'] . '" frameborder="0" allowfullscreen></iframe>';
                    echo '</div>';
                }

                // Fetch other games with the same category
                $category = $gameRow['category'];
                $otherGamesSql = "SELECT * FROM games WHERE category = '$category' AND id != $gameId LIMIT 4";
                $stmt = $conn->prepare($otherGamesSql);\nsimpleExecute($sql);\n$otherGamesResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if ($otherGamesResult->num_rows > 0) {
                    echo '<div class="more-games">';
                    echo '<h3>More Games :</h3>';
                    echo '<div class="row">';

                    foreach ($otherGamesResult as $otherGameRow) {

                        echo '<style>';
                        echo '.game-card { display: flex; flex-direction: column; height: 100%; max-height: 480px; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; cursor: pointer; transition: box-shadow 0.3s ease-in-out; }';
                        echo '.game-card:hover { box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }';
                        echo '.game-card img { flex: 1; height: 250px; object-fit: cover; width: 100%; border-radius: 5px; }';
                        echo '.game-card-content { padding: 10px; }';
                        echo '</style>';

                        echo '<div class="col-md-3">';
                        echo '<div class="game-card" onclick="showConfirmationDialog(' . $otherGameRow['id'] . ', \'' . $otherGameRow['game_title'] . '\')">';
                        echo '<img src="' . $otherGameRow['photo'] . '" alt="' . $otherGameRow['game_title'] . '" class="img-fluid">';
                        echo '<div class="game-card-content">';
                        echo '<h5>' . $otherGameRow['game_title'] . '</h5>';
                        echo '<p>' . $otherGameRow['description'] . '</p>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }

                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p class="text-center">Game not found.</p>';
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
                    <p>Are you sure you want to play another game?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary" onclick="playAnotherGame()">Yes</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
        // Define the getParameterByName function
        function getParameterByName(name, url) {
            if (!url) url = window.location.href;
            name = name.replace(/[\[\]]/g, "\\$&");
            var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, " "));
        }

        var selectedKidId = getParameterByName('kid_id');

        console.log('Selected Kid ID:', selectedKidId);

        function showConfirmationDialog(gameId, gameTitle) {
            // Set data attributes for the selected game
            $('#confirmationDialog').data('game-id', gameId);
            $('#confirmationDialog').data('game-title', gameTitle);

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

        function playAnotherGame() {
            // Get data attributes for the selected game
            const gameId = $('#confirmationDialog').data('game-id');
            const gameTitle = $('#confirmationDialog').data('game-title');

            // Log historical data
            var selectedKidId = getParameterByName('kid_id');
            var pageName = 'games - <span style="font-weight: bold;">' + gameTitle + '</span>';
            logHistoricalData(pageName, selectedKidId, gameId, gameTitle);

            // Redirect to the play game page for the selected game
            window.location.href = 'play_game.php?game_id=' + gameId;
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