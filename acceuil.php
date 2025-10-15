<?php
require_once('config/simple_database.php');

if (!isset($_GET['kidId'])) {
    echo "Kid ID is not set!";
    exit();
}

$selectedKidId = $_GET['kidId'];

$sql = "SELECT * FROM children WHERE id = " . intval($selectedKidId);
$result = simpleQuery($sql);

if (count($result) > 0) {
    $row = $result[0];
    $selectedKidName = $row['kid_name'];
    $selectedKidPhoto = $row['kid_photo'];
    $selectedGender = $row['kid_gender'];

    $sql1 = "SELECT user_id FROM children WHERE kid_name = '$selectedKidName' AND id = $selectedKidId";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->execute();
    $result1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

    if (count($result1) > 0) {
        $row = $result1[0];
        $selectedUserId = $row['user_id'];
    }
} else {
    echo "Invalid kid ID!";
    exit();
}

function fetchRandomEntries($conn, $table, $limit = 5, $hiddenCategories = [])
{
    // Create a WHERE condition to exclude hidden categories
    $whereCondition = '';
    if (!empty($hiddenCategories)) {
        $hiddenCategoriesString = implode("','", $hiddenCategories);
        $whereCondition = "AND category NOT IN ('$hiddenCategoriesString')";
    }

    $sql = "SELECT * FROM $table WHERE 1 $whereCondition ORDER BY RAND() LIMIT $limit";
    $stmt = $conn->prepare($sql);
    simpleExecute($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $entries = [];
    if (count($result) > 0) {
        foreach ($result as $row) {
            $entries[] = $row;
        }
    }

    return $entries;
}

// Fetch hidden categories for the selected kid
$sqlHiddenCategories = "SELECT hidden_games_categories, hidden_stories_categories, hidden_activities_categories FROM children WHERE id = $selectedKidId";
$stmtHidden = $conn->prepare($sqlHiddenCategories);
$stmtHidden->execute();
$resultHiddenCategories = $stmtHidden->fetchAll(PDO::FETCH_ASSOC);

if (count($resultHiddenCategories) > 0) {
    $rowHiddenCategories = $resultHiddenCategories[0];
    $hiddenGamesCategories = explode(',', $rowHiddenCategories['hidden_games_categories']);
    $hiddenStoriesCategories = explode(',', $rowHiddenCategories['hidden_stories_categories']);
    $hiddenActivitiesCategories = explode(',', $rowHiddenCategories['hidden_activities_categories']);
} else {
    $hiddenGamesCategories = [];
    $hiddenStoriesCategories = [];
    $hiddenActivitiesCategories = [];
}

$randomGames = fetchRandomEntries($conn, 'games', 5, $hiddenGamesCategories);
$randomStories = fetchRandomEntries($conn, 'stories', 5, $hiddenStoriesCategories);
$randomActivities = fetchRandomEntries($conn, 'activities', 5, $hiddenActivitiesCategories);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome <?php echo $selectedKidName; ?></title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts - Use a playful font suitable for kids -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@500&display=swap">
    <!-- Custom CSS -->
    <style>
        /* Header styles */
        header {
            display: flex;
    align-items: center;
    justify-content: center;
        color: #333; /* Dark text for better contrast */
        font-family: 'Baloo 2', cursive;
        overflow: hidden; /* Hide overflowing content */
    }

    h1 {
        font-size: 2.5em; /* Larger font size for the welcome message */
        color: #333; /* Dark text for better contrast */
    }
    

    .profile-image {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid #ecf0f1;
        margin: 20px auto 10px; /* Adjusted margin for spacing */
        display: block;
        transition: transform 0.3s ease-in-out; /* Add a subtle scale transition */
    }

    .profile-image:hover {
        transform: scale(1.1); /* Scale up on hover for a playful effect */
    }
    .profile-image  {
    animation: bg 3s infinite;
}

@keyframes bg {
    100% {
        filter: hue-rotate(360deg);
    }
}

    /* Updated lead text styles with animation */
p.lead {
    overflow: hidden; /* Ensures the content is not revealed until the animation */
    white-space: nowrap; /* Keeps the content on a single line */
    margin: 0 auto; /* Center the text */
    letter-spacing: .15em; /* Adjust as needed */
    animation: typing 3.5s steps(40, end) infinite, blink-caret .75s step-end infinite;
}

/* The typing effect */
@keyframes typing {
    from { width: 0 }
    to { width: 100% }
}

/* The typewriter cursor effect */
@keyframes blink-caret {
    from, to { border-color: transparent }
    50% { border-color: #ecf0f1; }
}


        .header-content {
            animation: fadeIn 2s infinite; /* Run animation infinitely */
        }

        /* Profile image styles */
        .profile-image {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #ecf0f1;
            margin: 0 auto;
            display: block;
        }

        /* Customized category styles */
        .carousel-title {
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-family: 'Baloo 2', cursive;
            text-align: center;
        }

        .games-carousel {
            background-color: #2ecc71; /* Green */
            
        }

        .stories-carousel {
            background-color: #e74c3c; /* Red */
        }

        .activities-carousel {
            background-color: #3498db; /* Blue */
        }

        /* Additional styles for a cleaner design */
        body {
            animation: slideInFromRight 1.5s ease-in-out; /* Apply the slideInFromRight animation to the body */
        }

        .container1 {
    background-color: rgba(255, 255, 255, 0.4); /* Semi-transparent white container background */
    border-radius: 15px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    padding: 20px; /* Adjusted padding */
    margin-bottom: 20px;
    height: auto; /* Adjusted height */
    width:1200px;
    
}

.container1 h1 {
    font-size: 3rem; /* Adjusted font size for h1 */
    margin-bottom: 10px;
    margin-top:10px;
}

.container1 p {
    font-size: 1rem; /* Adjusted font size for p */
    margin-bottom: 15px;
}

.container1 img {
    width: 100px; /* Adjusted width for the image */
    height: 100px; /* Adjusted height for the image */
    object-fit: cover;
    border-radius: 50%;
    margin-bottom: 15px;
}




.container2 {
    background-color: rgba(255, 255, 255, 0.4);
    border-radius: 15px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    margin: 20px auto;
    height: 500px;
    width: 1200px;
}

.container2 h2 {
    font-family: 'Baloo 2', cursive;
    font-size: 2.5rem;
    color: #333;
    text-align: center;
    margin-bottom: 5px;
    animation: fadeIn 1.5s ease-in-out;
}

.carousel-item {
    text-align: center;
    padding: 20px;
    border-radius: 10px;
    height: auto;
    color: #333;
    transition: transform 0.5s ease-in-out;
}

.carousel-item:hover {
    transform: scale(1.1);
}

.carousel-item img {
    width: 100%;
    height: 350px; /* Set a fixed height for the images */
    object-fit: cover;
    border-radius: 10px;
    transition: filter 0.5s ease-in-out;
}

.carousel-item:hover img {
    filter: none; /* Remove the hue-rotate filter on hover */
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }

    to {
        opacity: 1;
    }
}


.container2 {
    background-color: rgba(255, 255, 255, 0.4);
    border-radius: 15px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    margin: 20px auto;
    height: 500px;
    width: 1200px;
    position: relative;
    overflow: hidden; /* Hide the overflow to clip the icons */
}

.carousel-control-prev,
.carousel-control-next {
    background-color: transparent; /* Set background color to transparent */
    border: none; /* Remove border */
    border-radius: 50%;
    filter: invert(1) drop-shadow(0 0 5px rgba(255, 255, 255, 0.7));
    width: 40px;
    height: 40px;
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    display: flex;
    justify-content: center;
    align-items: center;
    transition: filter 0.3s ease-in-out; /* Add a smooth transition effect for the hover effect */
}

.carousel-control-prev:hover,
.carousel-control-next:hover {
    filter: invert(1) drop-shadow(0 0 10px rgba(255, 255, 255, 0.9)); /* Adjust the glow on hover */
}

.carousel-control-prev-icon,
.carousel-control-next-icon {
    font-size: 1.5rem; /* Adjust the size of the icon */
    color: #333; /* Set the color of the icon */
}


.carousel-item h5 {
    background-color: rgba(255, 253, 208, 0.8); /* Cream color with some transparency */
    padding: 10px;
    border-radius: 30px;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2); /* Add a shadow for better readability */
    backdrop-filter: blur(8px); /* Apply a blur effect to the background */
    color: #333; /* Set a readable text color */
}





/* Add this to your existing styles */
body.female {
    background-image: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)), url(./images/bg_female1.png);
    background-size: cover;
    width: 100%;
    height: 100vh;
    padding: 10px 8% 0; /* Remove bottom padding to eliminate the white border */
    box-sizing: border-box; /* Ensure padding is included in the total height */
    position: relative;
    background-attachment: fixed; /* Add this property for fixed background attachment */
}

body.male {
    background-image: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)), url(./images/bg_male1.png);
    background-size: cover;
    width: 100%;
    height: 100vh;
    padding: 10px 8% 0; /* Remove bottom padding to eliminate the white border */
    box-sizing: border-box; /* Ensure padding is included in the total height */
    position: relative;
    background-attachment: fixed; /* Add this property for fixed background attachment */
}

/* Add this to your existing styles */
#notificationIcon {
    font-size: 2.5rem; /* Adjust the size of the icon */
    color: rgba(255, 253, 208, 0.8); /* Cream color with some transparency */
}



@keyframes popInFromTop {
    0% {
        transform: translateY(-100%);
        opacity: 0;
    }
    100% {
        transform: translateY(0);
        opacity: 1;
    }
}

@keyframes popInFromBottom {
    0% {
        transform: translateY(100%);
        opacity: 0;
    }
    100% {
        transform: translateY(0);
        opacity: 1;
    }
}

.container1 {
    animation: popInFromTop 1.5s ease-in-out; /* Apply the popInFromTop animation to container1 */
}

.container2 {
    animation: popInFromBottom 1.5s ease-in-out; /* Apply the popInFromBottom animation to container2 */
}
@media screen and (max-width: 768px) {
    html, body {
        height: 100%;
    }

    .container1, .container2 {
        width: 100%;
        height: auto; /* Adjusted height for containers to be based on content */
    }

    .carousel-item img {
        height: 250px; /* Adjusted height for smaller screens */
    }
}

    </style>

</head>

<body class="<?php echo $selectedGender; ?>">

<header class="text-center mb-1">
<div class="container1 text-center">
    <h1 class="display-4 mb-4">Welcome, <?php echo $selectedKidName; ?>!</h1>
    <img src="<?php echo $selectedKidPhoto; ?>" alt="<?php echo $selectedKidName; ?>"
        class="img-fluid profile-image rounded-circle shadow mb-3">
    <p class="lead">Get ready for fun and learning!</p>
</div>


</header>


<div class="container2">
        <div class="row">
            <div class="col-md-4">
                <!-- Stories Carousel -->
 <h2 class="carousel-title stories-carousel text-white mt-5 mt-md-0">Stories <i class="fas fa-book"></i></h2>
 <div id="storyCarousel" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        <?php
        if (!empty($randomStories)) {
            foreach ($randomStories as $index => $story) {
                $activeClass = $index === 0 ? 'active' : '';
                echo "<div class='carousel-item $activeClass' data-story-id='{$story['id']}'>";
                echo "<img src='{$story['photo']}' class='d-block w-100' alt='{$story['story_title']}'>";
                echo "<div class='carousel-caption d-none d-md-block mb-2'>";
                echo "<h5>{$story['story_title']}</h5>";
                // Remove the description
                echo "</div>";
                echo "</div>";
            }
        } else {
            // Display a special photo or message when no stories are available
            echo "<div class='carousel-item active'>";
            echo "<img src='images/hidden.png' class='d-block w-100' alt='Special Photo'>";
            echo "<div class='carousel-caption d-none d-md-block mb-2'>";
            echo "<h5>No stories available</h5>";
            echo "</div>";
            echo "</div>";
        }
        ?>
    </div>
                    <a class="carousel-control-prev" href="#storyCarousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#storyCarousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
<div class="col-md-4">
                <!-- Games Carousel -->
 <h2 class="carousel-title games-carousel text-white">Games <i class="fas fa-gamepad"></i></h2>
 <div id="gameCarousel" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        <?php
        if (!empty($randomGames)) {
            foreach ($randomGames as $index => $game) {
                $activeClass = $index === 0 ? 'active' : '';
                echo "<div class='carousel-item $activeClass' data-game-id='{$game['id']}'>";
                echo "<img src='{$game['photo']}' class='d-block w-100' alt='{$game['game_title']}'>";
                echo "<div class='carousel-caption d-none d-md-block mb-2'>";
                echo "<h5>{$game['game_title']}</h5>";
                // Remove the description
                echo "</div>";
                echo "</div>";
            }
        } else {
            // Display a special photo or message when no games are available
            echo "<div class='carousel-item active'>";
            echo "<img src='images/hidden.png' class='d-block w-100' alt='Special Photo'>";
            echo "<div class='carousel-caption d-none d-md-block mb-2'>";
            echo "<h5>No games available</h5>";
            echo "</div>";
            echo "</div>";
        }
        ?>
    </div>
                    <a class="carousel-control-prev" href="#gameCarousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#gameCarousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <!-- Activities Carousel -->
 <h2 class="carousel-title activities-carousel text-white mt-5 mt-md-0">Activities <i class="fas fa-cubes"></i></h2>
 <div id="activityCarousel" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        <?php
        if (!empty($randomActivities)) {
            foreach ($randomActivities as $index => $activity) {
                $activeClass = $index === 0 ? 'active' : '';
                echo "<div class='carousel-item $activeClass' data-activity-id='{$activity['id']}'>";
                echo "<img src='{$activity['photo']}' class='d-block w-100' alt='{$activity['activity_title']}'>";
                echo "<div class='carousel-caption d-none d-md-block mb-2'>";
                echo "<h5>{$activity['activity_title']}</h5>";
                // Remove the description
                echo "</div>";
                echo "</div>";
            }
        } else {
            // Display a special photo or message when no activities are available
            echo "<div class='carousel-item active'>";
            echo "<img src='images/hidden.png' class='d-block w-100' alt='Special Photo'>";
            echo "<div class='carousel-caption d-none d-md-block mb-2'>";
            echo "<h5>No activities available</h5>";
            echo "</div>";
            echo "</div>";
        }
        ?>
     </div>
                    <a class="carousel-control-prev" href="#activityCarousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#activityCarousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <!-- Font Awesome JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    <!-- Your additional scripts -->
    <!-- Add this script to your existing JavaScript -->
    <!-- acceuil.php -->
 <!-- acceuil.php -->
 <!-- Your additional scripts -->
 <!-- Add this script to your existing JavaScript -->
 <script>
    var selectedKidId; // Declare selectedKidId globally

    $(document).ready(function () {
        // Initialize carousels here
        $('#gameCarousel').carousel();
        $('#storyCarousel').carousel();
        $('#activityCarousel').carousel();

        // Function to log historical data
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
                success: function (response) {
                    // Handle success, if needed
                    console.log(response);
                },
                error: function (xhr, status, error) {
                    // Handle error, if needed
                    console.error(error);
                }
            });
        }

        // Add click event listeners to carousel items
        $('#storyCarousel .carousel-item').on('click', function () {
            var storyId = $(this).data('story-id');
            var storyName = $(this).find('.carousel-caption h5').text();
            var selectedKidId = getParameterByName('kidId');
            var pageName = 'stories - <span style="font-weight: bold; font-family: Arial, sans-serif;">' + storyName + '</span>';
            logHistoricalData(pageName, selectedKidId, storyId, storyName);

            if (storyId !== undefined && storyId !== null) {
                window.location.href = 'watch_story.php?story_id=' + storyId + '&kid_id=' + selectedKidId;
            }
        });

        $('#gameCarousel .carousel-item').on('click', function () {
            var gameId = $(this).data('game-id');
            var gameName = $(this).find('.carousel-caption h5').text();
            var selectedKidId = getParameterByName('kidId');
            var pageName = 'games - <span style="font-weight: bold; font-family: Arial, sans-serif;">' + gameName + '</span>';
            logHistoricalData(pageName, selectedKidId, gameId, gameName);

            if (gameId !== undefined && gameId !== null) {
                window.location.href = 'play_game.php?game_id=' + gameId + '&kid_id=' + selectedKidId; // Include 'kid_id' in the URL
            }
        });

        $('#activityCarousel .carousel-item').on('click', function () {
            var activityId = $(this).data('activity-id');
            var activityName = $(this).find('.carousel-caption h5').text();
            var selectedKidId = getParameterByName('kidId');
            var pageName = 'activities - <span style="font-weight: bold; font-family: Arial, sans-serif;">' + activityName + '</span>';
            logHistoricalData(pageName, selectedKidId, activityId, activityName);

            if (activityId !== undefined && activityId !== null) {
                window.location.href = 'view_activity.php?activity_id=' + activityId + '&kid_id=' + selectedKidId;            }
        });

        // Function to scroll to a specific section
        function scrollToSection(sectionId) {
            $('html, body').animate({
                scrollTop: $('#' + sectionId).offset().top - 50 // Adjust offset as needed
            }, 1000);
        }

        // Function to get query parameter by name
        function getParameterByName(name, url) {
            if (!url) url = window.location.href;
            name = name.replace(/[\[\]]/g, "\\$&");
            var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, " "));
        }
    });
</script>








</body>

</html>


