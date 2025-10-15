<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Activity</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
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

        embed,
        iframe {
            width: 100%;
            height: 700px;
        }

        .related-activities {
            margin-top: 30px;
        }

        .related-activities h3 {
            color: #007bff;
            margin-bottom: 20px;
        }

        .activity-card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            cursor: pointer;
            transition: transform 0.3s ease-in-out;
        }

        .activity-card:hover {
            transform: scale(1.05);
        }

        .activity-card img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
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
        </a> <?php
                require_once('config/simple_database.php');


                if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                    $activityId = $_GET['activity_id'];

                    // Fetch activity details based on the provided activity ID
                    $activitySql = "SELECT * FROM activities WHERE id = " . intval($activityId);
                    $activityResult = simpleQuery($activitySql);

                    if (count($activityResult) > 0) {
                        $activityRow = $activityResult[0];

                        echo '<h2>' . $activityRow['activity_title'] . '</h2>';
                        echo '<p>' . $activityRow['description'] . '</p>';

                        // Check if the link is a local file (assuming it starts with 'local:')
                        if (strpos($activityRow['link_of_activities'], 'local:') === 0) {
                            // Remove 'local:' prefix
                            $localFilePath = substr($activityRow['link_of_activities'], 6);

                            // Display local activity using the embed tag
                            echo '<div>';
                            echo '<embed src="' . $localFilePath . '" width="100%" height="700px">';
                            echo '</div>';
                        } else {
                            // Display the activity link (assuming it's a direct link)
                            echo '<div>';
                            echo '<iframe width="100%" height="700px" src="' . $activityRow['link_of_activities'] . '" frameborder="0" allowfullscreen></iframe>';
                            echo '</div>';
                        }

                        // Fetch other activities with the same category
                        $category = $activityRow['category'];
                        $otherActivitiesSql = "SELECT * FROM activities WHERE category = '$category' AND id != $activityId LIMIT 4";
                        $stmt = $conn->prepare($otherActivitiesSql);\nsimpleExecute($sql);\n$otherActivitiesResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        if ($otherActivitiesResult->num_rows > 0) {
                            echo '<div class="related-activities">';
                            echo '<h3>Related Activities :</h3>';
                            echo '<div class="row">';

                            foreach ($otherActivitiesResult as $otherActivityRow) {

                                echo '<style>';
                                echo '.activity-card { display: flex; flex-direction: column; height: 100%; max-height: 480px; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; cursor: pointer; transition: box-shadow 0.3s ease-in-out; }';
                                echo '.activity-card:hover { box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }';
                                echo '.activity-card img { flex: 1; height: 250px; object-fit: cover; width: 100%; border-radius: 5px; }';
                                echo '.activity-card-content { padding: 10px; }';
                                echo '</style>';

                                echo '<div class="col-md-3">';
                                echo '<div class="activity-card" onclick="showConfirmationDialog(' . $otherActivityRow['id'] . ', \'' . $otherActivityRow['activity_title'] . '\')">';
                                echo '<img src="' . $otherActivityRow['photo'] . '" alt="' . $otherActivityRow['activity_title'] . '" class="img-fluid">';
                                echo '<div class="activity-card-content">';
                                echo '<h5>' . $otherActivityRow['activity_title'] . '</h5>';
                                echo '<p>' . $otherActivityRow['description'] . '</p>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                            }

                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p>Activity not found.</p>';
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
                    <p>Are you sure you want to view another activity?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary" onclick="viewAnotherActivity()">Yes</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
        function showConfirmationDialog(activityId, activityTitle) {
            // Set data attributes for the selected activity
            $('#confirmationDialog').data('activity-id', activityId);
            $('#confirmationDialog').data('activity-title', activityTitle);

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

        function viewAnotherActivity() {
            // Get data attributes for the selected activity
            const activityId = $('#confirmationDialog').data('activity-id');
            const activityTitle = $('#confirmationDialog').data('activity-title');

            // Log historical data
            var selectedKidId = getParameterByName('kid_id');
            var pageName = 'activities - <span style="font-weight: bold;">' + activityTitle + '</span>';
            logHistoricalData(pageName, selectedKidId, activityId, activityTitle);

            // Redirect to the view activity page for the selected activity
            window.location.href = 'view_activity.php?activity_id=' + activityId;
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