<?php
// acceuil_male.php
// Ensure kidId is set
if (!isset($_GET['kidId'])) {
    // Handle the case where kidId is not set
    echo "Kid ID is not set!";
    exit();
}

// Include your database connection
include('log_history.php');
include('connexion.php');

// Assuming you have the user's selected kid ID passed as URL parameter
$selectedKidId = $_GET['kidId']; // Get the kid's ID from the URL

// Fetch kid information from the database based on the selected ID
$sql = "SELECT * FROM children WHERE id = $selectedKidId";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $selectedKidName = $row['kid_name'];
    $selectedGender = $row['kid_gender'];
    $selectedKidPhoto = $row['kid_photo'];



    // Fetch user_id based on kid_name and id
    $sql1 = "SELECT user_id FROM children WHERE kid_name = '$selectedKidName' AND id = $selectedKidId";
    $result = $conn->query($sql1);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $selectedUserId = $row['user_id'];
    }
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Acceuil</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-U6ISDUK3CI3ZgM8mR5dUn8AiKtOWQ6lv1f8ZAtWFG3vIMqjMIS3E1Ov3BnWKtjc" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <!-- Add your additional CSS styles here -->
        <style>
            /* Custom styles */
            body {
                background-color: #f8f9fa;
                font-family: 'Poppins', sans-serif;
                margin: 0;
                padding: 0;
            }

            .container {
                width: 100%;
            }

            .profile-container {
                display: flex;
                align-items: center;
                margin-right: 10px;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            .profile-container:hover {
                transform: scale(1.1);
            }

            .profile-image {
                width: 40px;
                height: 40px;
                object-fit: cover;
                border-radius: 50%;
                margin-right: 10px;
            }

            .profile-name {
                font-size: 16px;
                font-weight: bold;
                color: #656d75;
                font-family: 'Poppins', sans-serif;
                transition: color 0.3s ease;
            }

            .profile-image:hover {
                -webkit-animation: profile-image 0.8s cubic-bezier(0.455, 0.030, 0.515, 0.955) both;
                animation: profile-image 0.8s cubic-bezier(0.455, 0.030, 0.515, 0.955) both;
            }

            @-webkit-keyframes profile-image {

                0%,
                100% {
                    -webkit-transform: translateY(0);
                    transform: translateY(0);
                }

                10%,
                30%,
                50%,
                70% {
                    -webkit-transform: translateY(-8px);
                    transform: translateY(-8px);
                }

                20%,
                40%,
                60% {
                    -webkit-transform: translateY(8px);
                    transform: translateY(8px);
                }

                80% {
                    -webkit-transform: translateY(6.4px);
                    transform: translateY(6.4px);
                }

                90% {
                    -webkit-transform: translateY(-6.4px);
                    transform: translateY(-6.4px);
                }
            }

            @keyframes profile-image {

                0%,
                100% {
                    -webkit-transform: translateY(0);
                    transform: translateY(0);
                }

                10%,
                30%,
                50%,
                70% {
                    -webkit-transform: translateY(-8px);
                    transform: translateY(-8px);
                }

                20%,
                40%,
                60% {
                    -webkit-transform: translateY(8px);
                    transform: translateY(8px);
                }

                80% {
                    -webkit-transform: translateY(6.4px);
                    transform: translateY(6.4px);
                }

                90% {
                    -webkit-transform: translateY(-6.4px);
                    transform: translateY(-6.4px);
                }
            }

            .profile-name:hover {
                -webkit-animation: profile-name 0.6s both;
                animation: profile-name 0.6s both;
            }

            @-webkit-keyframes profile-name {
                0% {
                    text-shadow: 0 0 #555555, 0 0 #555555, 0 0 #555555, 0 0 #555555, 0 0 #555555, 0 0 #555555, 0 0 #555555, 0 0 #555555;
                    -webkit-transform: translateX(0) translateY(0);
                    transform: translateX(0) translateY(0);
                }

                100% {
                    text-shadow: 1px -1px #555555, 2px -2px #555555, 3px -3px #555555, 4px -4px #555555, 5px -5px #555555, 6px -6px #555555, 7px -7px #555555, 8px -8px #555555;
                    -webkit-transform: translateX(-8px) translateY(8px);
                    transform: translateX(-8px) translateY(8px);
                }
            }

            @keyframes profile-name {
                0% {
                    text-shadow: 0 0 #555555, 0 0 #555555, 0 0 #555555, 0 0 #555555, 0 0 #555555, 0 0 #555555, 0 0 #555555, 0 0 #555555;
                    -webkit-transform: translateX(0) translateY(0);
                    transform: translateX(0) translateY(0);
                }

                100% {
                    text-shadow: 1px -1px #555555, 2px -2px #555555, 3px -3px #555555, 4px -4px #555555, 5px -5px #555555, 6px -6px #555555, 7px -7px #555555, 8px -8px #555555;
                    -webkit-transform: translateX(-8px) translateY(8px);
                    transform: translateX(-8px) translateY(8px);
                }
            }





            .account-menu {
                position: absolute;
                top: 70px;
                right: 0;
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                width: 200px;
                display: none;
                background-color: #ffffff;
                z-index: 1;
                transition: opacity 0.3s ease;
                opacity: 0;
                animation: fadeIn 0.5s ease;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(-10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .account-menu-bar {
                background-color: #007bff;
                color: #ffffff;
                padding: 10px;
                text-align: center;
                border-top-left-radius: 8px;
                border-top-right-radius: 8px;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .account-menu-item {
                color: #495057;
                font-size: 16px;
                cursor: pointer;
                padding: 10px;
                transition: color 0.3s ease;
                position: relative;
                text-align: left;
                display: flex;
                align-items: center;
            }

            .account-menu-item:hover {
                color: #007bff;
            }

            .underline {
                position: absolute;
                bottom: 0;
                left: 50%;
                height: 3px;
                width: 0;
                background-color: #007bff;
                transform-origin: bottom center;
                transition: transform 0.3s ease, width 0.3s ease;
            }

            .account-menu-item:hover .underline,
            .account-menu-item.active .underline {
                transform: translateX(-50%) scaleX(1);
                width: 100%;
            }

            .show-account-menu {
                opacity: 1;
                display: block;
            }

            .navbar {
                background-color: #fff;
                border-bottom: 5px solid #f39bbc;
                padding: 10px;
                border-radius: 0;
                padding-left: 0;
                transition: background-color 0.3s ease;
                display: flex;
                justify-content: space-between;
                align-items: center;
                width: 100%;
                height: 60px;
            }

            .navbar-toggler {
                border: none;
                background: transparent;
            }

            .navbar-toggler-icon {
                background-color: #ffffff;
            }

            .navbar-nav {
                padding-right: 108px;
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .nav-link {
                color: #656d75;
                font-family: 'Poppins', sans-serif;
                margin-right: 15px;
                font-size: 16px;
                transition: color 0.3s ease;
                position: relative;
                text-transform: uppercase;
            }

            .nav-link::before {
                content: '';
                position: absolute;
                width: 100%;
                height: 2px;
                bottom: 0;
                left: 0;
                background-color: #ffffff;
                transform: scaleX(0);
                transform-origin: bottom right;
                transition: transform 0.3s ease;
            }


            .nav-link:hover::before {
                transform: scaleX(1);
                transform-origin: bottom left;
                background-color: #495057;
            }


            .nav-link.active::before {
                transform: scaleX(1);
                transform-origin: bottom left;
                background-color: #495057;
                
                /* Change background color on active */
            }

            /* Profile section in navbar */
            .profile-section {
                position: absolute;
                top: 10px;
                right: 20px;
                display: flex;
                align-items: center;
                cursor: pointer;
                z-index: 2;
                transition: opacity 0.3s ease;
            }

            .navbar-logo {
                margin-left: 0;

                margin: 0px;
                padding: 0px;

            }

            .navbar-logo img {
                height: auto;
                max-width: 100%;
                max-height: 85px;
                /* Adjust the maximum height as needed */
                transition: transform 0.3s ease;
                /* Add a smooth transition effect */
            }

            .navbar-logo img:hover {
                transform: scale(1.1);
                /* Scale the logo by 10% on hover (adjust as needed) */
            }



            .account-menu-item:hover,
            .account-menu-item:focus {
                text-decoration: none;
            }

            .account-menu-item i {
                margin-right: 5px;
                /* Adjust the margin as needed */
            }

            .background-container {
                background-image: url('images/bg_maleA.png');
                /* Replace with your image path */
                background-size: cover;
                background-position: center;
                height: 100vh;
                /* Adjust the height as needed */
                display: flex;
                align-items: center;
                justify-content: center;
                transition: background-image 0.5s ease, background-size 0.5s ease, background-position 0.5s ease;
            }

            .options-btn-container {
                position: absolute;
                bottom: 300px;
                /* Adjusted the bottom value */
                left: 450px;
                display: flex;
                transform: translateX(-50%);
                z-index: 2;
                /* Ensure it's on top of the overlay */
            }

            .lets-start-btn {
                background-color: #007bff;
                color: #fff;
                border: none;
                padding: 20px 40px;
                /* Adjusted padding for height and width */
                font-size: 20px;
                /* Adjusted font size */
                cursor: pointer;
                transition: background-color 0.3s ease;
                margin-bottom: 10px;
            }

            .lets-start-btn:hover {
                background-color: #0056b3;
                transform: scale(1.1);
                /* Scale the button on hover */
            }


            .options-container {
                display: none;
                flex-direction: row;
                /* Change to row for horizontal layout */
                justify-content: space-around;
                /* Adjust as needed */
                align-items: center;
                /* Align items in the center */
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 90%;
                height: 90%;
                padding: 50px;
                margin-top: 30px;
                background-color: #e0f5ff;
                border: 1px solid #007bff;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                transition: transform 0.3s ease, opacity 0.3s ease;
                z-index: 1;
            }

            .options-container button {
                background-color: #fff;
                color: #007bff;
                border: none;
                padding: 10px 20px;
                font-size: 16px;
                cursor: pointer;
                transition: background-color 0.3s ease, color 0.3s ease;
                text-align: center;
                margin: 0 5px;
                /* Adjust as needed */
            }

            .options-container.show {
                display: flex;
                transform: translate(-50%, -50%) scale(1);
                opacity: 1;
            }



            .options-container button {
                /* Add styles for the content inside the options container */
                font-size: 27px;
                /* Adjust font size */
                padding: 70px;
                /* Adjust padding */
            }

            .options-container button:hover {
                background-color: #007bff;
                color: #fff;
            }
            @keyframes wiggle {
    0% { transform: rotate(0); }
    25% { transform: rotate(-5deg); }
    50% { transform: rotate(5deg); }
    75% { transform: rotate(-5deg); }
    100% { transform: rotate(0); }
}

#acceuilNavLink.hover,
#acceuilNavLink.active {
    animation: wiggle 0.5s ease; /* Add the wiggling animation on hover or click */
}
            #storiesNavLink.hover,
#storiesNavLink.active {
    color: red; /* Change the color for Stories on hover and when active/clicked */
    animation: wiggle 0.5s ease;
}

#gamesNavLink.hover,
#gamesNavLink.active {
    color: green; /* Change the color for Games on hover and when active/clicked */
    animation: wiggle 0.5s ease;
}

#activitiesNavLink.hover,
#activitiesNavLink.active {
    color: blue; /* Change the color for Activities on hover and when active/clicked */
    animation: wiggle 0.5s ease;
}
        </style>

    </head>

    <body>

        <nav class="navbar navbar-expand-sm d-flex justify-content-between fixed-top">
            <div class="container d-flex align-items-center">
                <div class="navbar-logo">
                <img src="images/logo_girl.png" alt="Logo" onclick="reloadPage()">

<script>
    function reloadPage() {
        location.reload();
    }
</script>
                </div>
                <button class="navbar-toggler mx-auto" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#" id="acceuilNavLink" data-target="acceuil">
                                <i class="fas fa-home"></i> Acceuil <span class="sr-only">(current)</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" id="storiesNavLink" data-target="stories">
                                <i class="fas fa-book"></i> Stories
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" id="gamesNavLink" data-target="games">
                                <i class="fas fa-gamepad"></i> Games
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" id="activitiesNavLink" data-target="activities">
                                <i class="fas fa-puzzle-piece"></i> Activities
                            </a>
                        </li>
                        <!-- Add more navigation items as needed -->
                    </ul>
                </div>


                <div class="profile-section" id="accountMenuToggle">
                    <!-- Display the selected kid's photo and name on the right top -->
                    <div class="profile-container">
                        <img id="accountToggle" class="profile-image" src="<?php echo $selectedKidPhoto; ?>" alt="<?php echo $selectedKidName; ?>">
                        <span id="accountToggle" class="profile-name"><?php echo $selectedKidName; ?></span>
                    </div>
                    <!-- Account menu items -->
                    <div class="account-menu" id="accountMenu">
                        <div class="account-menu-item border-bottom" id="chooseAnotherProfile"><i class="fas fa-user"></i> Choose Another Profile
                            <div class="underline"></div>
                        </div>
                        <div class="account-menu-item" id="ProfileSettings"><i class="fas fa-cog"></i> Profile Settings
                            <div class="underline"></div>
                        </div>
                        <div class="account-menu-item border-bottom" id="AccountSettings"><i class="fas fa-lock"></i> Account Settings
                            <div class="underline"></div>
                        </div>
                        <a class="account-menu-item" id="feedbackLink" target="_blank">
                            <i class="fas fa-comment"></i> Give Feedback
                            <div class="underline"></div>
                        </a>

                        <a id="aboutLink" class="account-menu-item" target="_blank">
                            <i class="fas fa-info-circle"></i> About
                            <div class="underline"></div>
                        </a>

                        <a id="supportLink" class="account-menu-item" target="_blank">
                            <i class="fas fa-question-circle"></i> Support
                            <div class="underline"></div>
                        </a>
                        <!-- Inside the account menu -->
                        <a class="account-menu-item" id="historicLink"><i class="fas fa-history"></i> Historic
                            <div class="underline"></div>
                        </a>


                        <div class="account-menu-item border-top border-5" id="logout"><i class="fas fa-sign-out-alt"></i> Logout
                            <div class="underline"></div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <div id="acceuil" class="content-section">
            <iframe id="acceuilIframe" src="acceuil.php?kidId=<?php echo $selectedKidId; ?>" width="100%" height="878px" frameborder="0" style="margin-top: 30px;"></iframe>
        </div>
        <div id="stories" class="content-section" style="display: none;">
            <!-- Pass selectedKidId to stories.html -->
            <iframe src="stories.html?kidId=<?php echo $selectedKidId; ?>" width="100%" height="900px" frameborder="0" style="margin-top: 30px;"></iframe>
        </div>
        <div id="games" class="content-section" style="display: none;">
            <!-- Your Games content goes here -->
            <iframe src="games.html?kidId=<?php echo $selectedKidId; ?>" width="100%" height="900px" frameborder="0" style="margin-top: 30px;"></iframe>
        </div>
        <div id="activities" class="content-section" style="display: none;">
            <iframe src="activities.html?kidId=<?php echo $selectedKidId; ?>" width="100%" height="900px" frameborder="0" style="margin-top: 30px;"></iframe>
        </div>
        <!-- Include jQuery and Bootstrap before your script -->
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <style>
            #notificationIcon i {
                animation: bounce 0.5s infinite alternate;
            }

            @keyframes bounce {
                from {
                    transform: translateY(0);
                }

                to {
                    transform: translateY(-5px);
                }
            }

            #notificationModal {
                position: fixed;
                bottom: 20px;
                right: 20px;
            }

            #notificationCount {
                position: absolute;
                top: -15px;
                right: -15px;
            }

            #notificationModal .modal-content {
                background-color: #f0f0f0;
                /* Light background color */
                color: #333;
                /* Dark text color */
                border-radius: 10px;
            }

            #notificationModal .modal-header {
                background-color: #ccc;
                /* Medium gray header background color */
                color: #333;
                border-radius: 10px 10px 0 0;
            }

            #notificationModal .modal-body {
                max-height: 300px;
                /* Set your desired max height */
                overflow-y: auto;
            }

            #notificationModal .modal-body::-webkit-scrollbar {
                width: 0 !important;
                display: none;
            }

            .notification-item {
                display: flex;
                justify-content: space-between;
                align-items: center;
                border: 1px solid #ddd;
                /* Light border color */
                border-radius: 8px;
                padding: 10px;
                background-color: #fff;
                transition: background-color 0.3s ease;
                margin-bottom: 10px;
            }

            .notification-item:hover {
                background-color: #f5f5f5;
            }

            .notification-content {
                flex-grow: 1;
            }

            .notification-actions {
                margin-left: 10px;
            }

            .modal-backdrop {
                background: none;
            }

            #notificationIcon.active i {
                color: #ff5733;
                /* Change to your desired color for the active state */
            }
        </style>


        <!-- Add this HTML at the bottom of your page -->
        <div id="notificationIcon" style="position: fixed; bottom: 20px; right: 20px; cursor: pointer;">
            <i class="fas fa-bell"></i>
            <span id="notificationCount" class="badge badge-danger" style="display: none;"></span>
        </div>
        <div id="notificationModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="notificationModalLabel" aria-hidden="true" data-backdrop="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-bottom" role="document" style="position: fixed; bottom: 80px; right: 20px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="notificationModalLabel">📢 Notifications</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="notificationBody">
                        <!-- Notification messages will be displayed here -->
                    </div>
                </div>
            </div>
        </div>

        <script>
            jQuery(document).ready(function($) {
                // Function to fetch and display notifications
                var displayedMessages = 3; // Number of messages initially displayed

                function displayNotifications() {
                    // Fetch all notifications for the current child ID
                    $.ajax({
                        url: 'fetch_notifications.php',
                        method: 'POST',
                        data: {
                            childId: <?php echo $selectedKidId; ?>
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                // Display notifications count
                                var notificationCount = countUnreadNotifications(response.notifications);

                                // Display notification messages in a modal
                                var modalBody = $('#notificationBody');
                                modalBody.empty(); // Clear existing notifications

                                // Add each notification message to the modal body
                                response.notifications.slice(-displayedMessages).forEach(function(notification) {
                                    // Calculate time since notification
                                    var timeSince = getTimeSince(notification.timestamp);

                                    // Append message to modal body
                                    var notificationItem = $('<div class="notification-item mb-3">' +
                                        '<div class="notification-content">' +
                                        '<p class="mb-1 text-dark"><strong>' + notification.message + '</strong></p>' +
                                        '<small class="text-muted">Sent ' + timeSince + ' ago</small>' +
                                        '</div>' +
                                        '</div>');

                                    // Add click event to mark notification as read
                                    notificationItem.click(function() {
                                        markNotificationAsRead(notification.notification_id);
                                    });

                                    modalBody.prepend(notificationItem);
                                });

                                // Show "More" button if there are more messages
                                if (response.notifications.length > displayedMessages) {
                                    var moreButton = $('<button>')
                                        .addClass('btn btn-outline-secondary mt-3 mx-auto d-block rounded-pill')
                                        .attr('id', 'moreButton')
                                        .html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Load More');
                                    moreButton.click(function() {
                                        displayedMessages += 3; // Display 3 more messages
                                        displayNotifications(); // Call the function again to update the display
                                    });
                                    modalBody.append(moreButton);
                                }

                                // Show the modal using Bootstrap syntax
                            } else {
                                console.error('Failed to fetch notifications.');
                            }
                        },
                        error: function(error) {
                            console.error('Error fetching notifications:', error);
                        }
                    });
                }

                function countUnreadNotifications() {
                    // Fetch unread notifications for the current child ID
                    $.ajax({
                        url: 'fetch_unread_notifications.php',
                        method: 'POST',
                        data: {
                            childId: <?php echo $selectedKidId; ?>
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                // Display count of unread notifications
                                var unreadCount = response.notifications.length;
                                $('#notificationCount').text(unreadCount).show();
                            } else {
                                console.error('Failed to fetch unread notifications.');
                            }
                        },
                        error: function(error) {
                            console.error('Error fetching unread notifications:', error);
                        }
                    });
                }




                // Function to calculate time since a timestamp
                function getTimeSince(timestamp) {
                    var now = new Date();
                    var sentTime = new Date(timestamp);
                    var timeDifference = now - sentTime;

                    // Calculate time units
                    var seconds = Math.floor(timeDifference / 1000);
                    var minutes = Math.floor(seconds / 60);
                    var hours = Math.floor(minutes / 60);
                    var days = Math.floor(hours / 24);

                    // Return formatted time
                    if (days > 0) {
                        return days + ' day(s)';
                    } else if (hours > 0) {
                        return hours + ' hour(s)';
                    } else if (minutes > 0) {
                        return minutes + ' minute(s)';
                    } else {
                        return seconds + ' second(s)';
                    }
                }

                // Function to mark all notifications as read
                function markAllNotificationsAsRead() {
                    $.ajax({
                        url: 'mark_all_notifications_as_read.php',
                        method: 'POST',
                        data: {
                            childId: <?php echo $selectedKidId; ?>
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                // Successfully marked all as read, refresh notifications
                                displayNotifications();
                                $('#notificationCount').hide();
                            } else {
                                console.error('Failed to mark all notifications as read.');
                            }
                        },
                        error: function(error) {
                            console.error('Error marking all notifications as read:', error);
                        }
                    });
                }

                // Automatically fetch and update notifications every 5 minutes
                setInterval(displayNotifications, 5 * 60 * 1000);

                // Display notifications count when the page loads
                displayNotifications();

                // Attach a click event to the notification icon
                $('#notificationIcon').click(function() {

                    $(this).toggleClass('active');
                    // Mark all notifications as read
                    markAllNotificationsAsRead();
                    // Call the function to display notifications
                    displayNotifications();
                    $('#notificationModal').modal('show');
                });
                $('#notificationModal .close').click(function() {
                    // Remove the "active" class when the modal is closed
                    $('#notificationIcon').removeClass('active');
                });

                // Update the icon state when the modal is opened or closed
                $('#notificationModal').on('shown.bs.modal', function() {
                    $('#notificationIcon').addClass('active');
                });

                $('#notificationModal').on('hidden.bs.modal', function() {
                    $('#notificationIcon').removeClass('active');
                });
            });
        </script>



        <style>
            @keyframes slideInOut {
                0% {
                    transform: translateX(-100%);
                }

                50% {
                    transform: translateX(0);
                }

                100% {
                    transform: translateX(100%);
                }
            }

            .timer {
                animation: slideInOut 5s infinite;
            }


            /* Add a pulse animation to the timer icon */
            #timerIcon i {
                animation: pulse 1.5s infinite;
            }

            @keyframes pulse {
                0% {
                    transform: scale(1);
                }

                50% {
                    transform: scale(1.2);
                }

                100% {
                    transform: scale(1);
                }
            }

            #timerIcon.clicked {
                color: #ff5733;
            }
        </style>
        <!-- Add this HTML at the bottom of your Acceuil page -->
        <div id="timerIcon" style="position: fixed; bottom: 20px; left: 20px; cursor: pointer;">
            <i class="fas fa-clock"><span class="timer ml-2"></span></i>
        </div>
        <div id="timerModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="timerModalLabel" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="timerModalLabel"><i class="fas fa-clock"></i> Set Timer</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="timerInput" class="font-weight-bold"><i class="fas fa-hourglass-start"></i> Set Timer (minutes):</label>
                            <input type="number" id="timerInput" class="form-control" min="1" value="10" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="startTimerBtn"><i class="fas fa-play"></i> Start Timer</button>
                        <button type="button" class="btn btn-secondary" id="cancelTimerBtn" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <style>
            .notification {
                display: none;
                position: fixed;
                bottom: 40px;
                right: 40px;
                padding: 15px;
                background-color: #333;
                color: #fff;
                border-radius: 5px;
                box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
                z-index: 9999;

            }

            .notification.danger {
                background-color: #e74c3c;
                /* Danger color */
                color: #fff;
            }

            .notification.warning {
                background-color: #f39c12;
                /* Warning color */
                color: #fff;
            }

            .notification.success {
                background-color: #2ecc71;
                /* Success color */
                color: #fff;
            }

            .notification.info {
                background-color: #3498db;
                /* Default info color */
                color: #fff;
            }

            .notification i {
                margin-right: 10px;
            }
        </style>

        <div id="notification" class="notification"></div>


        <!-- Include jQuery and Bootstrap before your script -->
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script>
            function togglePasswordVisibility() {
                var passwordInput = document.getElementById('passwordInput');
                var passwordToggle = document.querySelector('.password-toggle');

                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    passwordToggle.innerHTML = '<i class="fas fa-eye"></i>';
                } else {
                    passwordInput.type = 'password';
                    passwordToggle.innerHTML = '<i class="fas fa-eye-slash"></i>';
                }
            }

            function showNotification(message, type = 'info') {
                var notification = $("#notification");
                var iconClass = '';

                switch (type) {
                    case 'danger':
                        iconClass = 'fas fa-exclamation-circle'; // Danger icon
                        break;
                    case 'warning':
                        iconClass = 'fas fa-exclamation-triangle'; // Warning icon
                        break;
                    case 'success':
                        iconClass = 'fas fa-check-circle'; // Success icon
                        break;
                    case 'info':
                    default:
                        iconClass = 'fas fa-info-circle'; // Default info icon
                        break;
                }

                notification.html('<i class="' + iconClass + '"></i>' + message);
                notification.removeClass().addClass('notification ' + type);
                notification.fadeIn();

                setTimeout(function() {
                    notification.fadeOut();
                }, 5000); // 5 seconds
            }

            function verifyPasswordAndPerformAction(actionDetails) {
                var modal = $('<div class="modal fade" tabindex="-1" role="dialog">\
                    <div class="modal-dialog modal-dialog-top" role="document">\
                        <div class="modal-content">\
                            <div class="modal-header bg-primary text-white">\
                                <h5 class="modal-title"><i class="fas fa-lock"></i> Enter Your Password</h5>\
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">\
                                    <span aria-hidden="true">&times;</span>\
                                </button>\
                            </div>\
                            <div class="modal-body">\
                                <div class="form-group">\
                                    <label for="passwordInput" class="sr-only">Password:</label>\
                                    <div class="input-group">\
                                        <input type="password" class="form-control" id="passwordInput" placeholder="Enter your password" required>\
                                        <div class="input-group-append">\
                                            <span class="input-group-text password-toggle" onclick="togglePasswordVisibility()"><i class="fas fa-eye-slash"></i></span>\
                                        </div>\
                                    </div>\
                                </div>\
                            </div>\
                            <div class="modal-footer">\
                                <button type="button" class="btn btn-primary" id="confirmPassword"><i class="fas fa-check"></i> Confirm</button>\
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>\
                            </div>\
                        </div>\
                    </div>\
                </div>');

                // Make sure to include Bootstrap and Font Awesome libraries in your HTML file.


                modal.on('hidden.bs.modal', function() {
                    // Remove the modal from the DOM after it has been closed
                    modal.remove();
                    $("#timerIcon").removeClass('clicked');
                });

                $('body').append(modal);
                modal.modal('show');

                $("#confirmPassword").click(function() {
                    var enteredPassword = $("#passwordInput").val();

                    if (enteredPassword.trim() !== "") {
                        $.ajax({
                            url: "verify_password.php",
                            method: "POST",
                            data: {
                                userId: actionDetails.userId,
                                password: enteredPassword
                            },
                            success: function(response) {
                                if (response.trim() === "Password is correct!") {
                                    actionDetails.performAction();
                                } else {
                                    showNotification(actionDetails.errorMessage, 'danger');
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error(error);
                            }
                        });
                        modal.modal('hide');
                    } else {
                        showNotification("Please enter your password.", 'warning');
                    }
                });
            }
            jQuery(document).ready(function($) {
                var countdownTimer;
                var timerDuration;
                var timerStartTime;
                var localStorageKey = 'timerData';
                var warningsShown = {};

                // Attach a click event to the timer icon
                $("#timerIcon").click(function() {
                    var timerDetails = {
                        userId: <?php echo $selectedUserId; ?>,
                        performAction: function() {
                            // Code to show the timer
                            $('#timerModal').modal('show');
                        },
                        successMessage: "Password is correct! Opening timer...",
                        errorMessage: "Incorrect password. Please try again."
                    };

                    verifyPasswordAndPerformAction(timerDetails);

                    $(this).addClass('clicked');
                });
                $('#timerModal').on('hidden.bs.modal', function() {
                    // Remove the CSS class to revert to default color
                    $("#timerIcon").removeClass('clicked');
                });


                // Attach a click event to the Start Timer button
                $('#startTimerBtn').click(function() {
                    // Get the timer duration from the input
                    timerDuration = parseInt($('#timerInput').val());

                    if (!isNaN(timerDuration) && timerDuration > 0) {
                        // Cancel the existing timer if it's running
                        clearInterval(countdownTimer);

                        // Convert minutes to milliseconds
                        var countdownTime = timerDuration * 60 * 1000;

                        // Store timer data in local storage
                        saveTimerData(countdownTime);

                        // Hide the modal
                        $('#timerModal').modal('hide');

                        // Start the new countdown timer
                        startTimer(countdownTime);
                    } else {
                        showNotification('Please enter a valid timer duration.', 'warning');
                    }
                });

                // Attach a click event to the Cancel Timer button
                $('#cancelTimerBtn').click(function() {
                    // Cancel the existing timer
                    clearInterval(countdownTimer);
                    updateTimerDisplay(0);

                    // Remove timer data from local storage
                    localStorage.removeItem(localStorageKey);

                    // Reset warnings shown
                    warningsShown = {};

                    showNotification('Timer Are Canceled!', 'warning');

                    // Add a bounce animation to the timer icon when the timer is canceled
                    $('#timerIcon i').addClass('animated bounce');
                    setTimeout(function() {
                        $('#timerIcon i').removeClass('animated bounce');
                    }, 1000);
                });

                // Check for existing timer data in local storage on page load
                var savedTimerData = getSavedTimerData();
                if (savedTimerData && savedTimerData > Date.now()) {
                    // Resume the timer with the remaining time
                    startTimer(savedTimerData - Date.now());
                }

                function startTimer(duration) {
                    timerStartTime = Date.now();
                    var endTime = timerStartTime + duration;
                    showNotification('Timer Are Start .', 'success');

                    // Update the timer display every second
                    countdownTimer = setInterval(function() {
                        var remainingTime = endTime - Date.now();
                        if (remainingTime > 0) {
                            updateTimerDisplay(remainingTime);

                            // Check if it's time to display a warning notification
                            if (remainingTime <= 300000 || remainingTime <= 60000) {
                                var minutesRemaining = Math.floor(remainingTime / 60000);

                                // Show warning only once for each minute
                                if (!warningsShown[minutesRemaining]) {
                                    showNotification('Warning: ' + minutesRemaining + ' minutes remaining', 'warning');
                                    warningsShown[minutesRemaining] = true;
                                }
                            }
                        } else {
                            // Timer has reached zero
                            clearInterval(countdownTimer);
                            showLink();
                            // Remove timer data from local storage
                            localStorage.removeItem(localStorageKey);
                        }
                    }, 1000);
                }

                function updateTimerDisplay(remainingTime) {
                    var minutes = Math.floor(remainingTime / 60000);
                    var seconds = Math.floor((remainingTime % 60000) / 1000);

                    // Format minutes and seconds
                    var formattedTime = ('0' + minutes).slice(-2) + ':' + ('0' + seconds).slice(-2);
                    if (remainingTime <= 60000) {
                        showNotification('Warning: Time is running out!', 'warning');
                    }
                    if (remainingTime <= 0) {
                        // If remaining time is zero or less, hide the timer element
                        $('#timerIcon span').hide();
                    } else {
                        $('#timerIcon span').show();
                    }
                    // Update the timer icon with the remaining time
                    $('#timerIcon span').text(formattedTime);
                }

                function showLink() {
                    // Display a link or perform any other action when the timer reaches zero
                    showNotification('Time\'s up!', 'warning');
                    window.location.replace('404.html');
                }

                function saveTimerData(duration) {
                    var endTime = Date.now() + duration;
                    // Store only the endTime in local storage
                    localStorage.setItem(localStorageKey, endTime);
                }

                function getSavedTimerData() {
                    // Retrieve endTime from local storage
                    var endTime = localStorage.getItem(localStorageKey);
                    return endTime ? parseInt(endTime, 10) : null;
                }
            });
        </script>













        <!-- Add your additional scripts here -->
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script>
            $(document).ready(function() {
                // Extract the section parameter from the URL
                var section = new URLSearchParams(window.location.search).get('section');

                // Scroll to the corresponding section
                if (section) {
                    $('html, body').animate({
                        scrollTop: $('#' + section).offset().top
                    }, 1000);
                }
            });
        </script>
        <script>
            $(document).ready(function() {
                function logHistoricalData(pageName) {
                    // Assuming you have the selectedKidId available
                    var kidId = <?php echo $selectedKidId; ?>;

                    // Send an AJAX request to log historical data
                    $.ajax({
                        url: "log_history.php",
                        method: "POST",
                        data: {
                            kidId: kidId,
                            pageName: pageName
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

                var menuHovered = false;
                var timeoutId;

                // Show account menu on hover
                $("#accountMenuToggle").mouseenter(function() {
                    clearTimeout(timeoutId); // Clear any existing timeout
                    $("#accountMenu").addClass("show-account-menu");
                });

                // Set menuHovered to true when mouse enters the account menu
                $("#accountMenu").mouseenter(function() {
                    menuHovered = true;
                });

                // Set menuHovered to false when mouse leaves the account menu
                $("#accountMenu").mouseleave(function() {
                    menuHovered = false;
                    timeoutId = setTimeout(function() {
                        if (!menuHovered) {
                            $("#accountMenu").removeClass("show-account-menu");
                        }
                    }, 300);
                });

                // Close account menu on mouse leave if not hovered after 2 seconds
                $("#accountMenuToggle").mouseleave(function() {
                    timeoutId = setTimeout(function() {
                        if (!menuHovered) {
                            $("#accountMenu").removeClass("show-account-menu");
                        }
                    }, 200); // 2-second delay before hiding
                });

                // Close account menu on document click outside the menu
                $(document).click(function(event) {
                    if (!$(event.target).closest("#accountMenuToggle, #accountMenu").length) {
                        $("#accountMenu").removeClass("show-account-menu");
                    }
                });

                // Prevent hiding the menu if clicking inside it
                $("#accountMenu").click(function(event) {
                    event.stopPropagation();
                });
                $("#historicLink").click(function() {
                    // Open the Historic page in the iframe with a margin-top
                    var historicUrl = "historic.php?kidId=<?php echo $selectedKidId; ?>";
                    $(".content-section iframe").attr("src", historicUrl).css("margin-top", "50px");
                });

                // Close menu on close icon click
                $("#closeAccountMenu").click(function() {
                    $("#accountMenu").removeClass("show-account-menu");
                });

                $("#feedbackLink").click(function() {
                    // Open the feedback page in the iframe with a margin-top
                    var feedbackUrl = "feedback.php?userId=<?php echo $selectedUserId; ?>";
                    $(".content-section iframe").attr("src", feedbackUrl).css("margin-top", "50px");
                    var pageName = $(this).attr("id");
                    logHistoricalData(pageName);
                });

                $("#aboutLink").click(function() {
                    // Open the About page in the iframe with a margin-top
                    var aboutUrl = "About.html";
                    $(".content-section iframe").attr("src", aboutUrl).css("margin-top", "50px");
                    var pageName = $(this).attr("id");
                    logHistoricalData(pageName);
                });

                // Update the script to handle "Support" link click on any page
                $("#supportLink").click(function() {
                    // Open the Support page in the iframe with a margin-top
                    var supportUrl = "support.html";

                    // Update the iframe on all content sections, not just the "Acceuil" section
                    $(".content-section iframe").attr("src", supportUrl).css("margin-top", "50px");
                    var pageName = $(this).attr("id");
                    logHistoricalData(pageName);
                });

                function showNotification(message, type = 'info') {
                    var notification = $("#notification");
                    var iconClass = '';

                    switch (type) {
                        case 'danger':
                            iconClass = 'fas fa-exclamation-circle'; // Danger icon
                            break;
                        case 'warning':
                            iconClass = 'fas fa-exclamation-triangle'; // Warning icon
                            break;
                        case 'success':
                            iconClass = 'fas fa-check-circle'; // Success icon
                            break;
                        case 'info':
                        default:
                            iconClass = 'fas fa-info-circle'; // Default info icon
                            break;
                    }

                    notification.html('<i class="' + iconClass + '"></i>' + message);
                    notification.removeClass().addClass('notification ' + type);
                    notification.fadeIn();

                    setTimeout(function() {
                        notification.fadeOut();
                    }, 5000); // 5 seconds
                }

                function verifyPasswordAndPerformAction(actionDetails) {
                    var modal = $('<div class="modal fade" tabindex="-1" role="dialog">\
                    <div class="modal-dialog modal-dialog-top" role="document">\
                        <div class="modal-content">\
                            <div class="modal-header bg-primary text-white">\
                                <h5 class="modal-title"><i class="fas fa-lock"></i> Enter Your Password</h5>\
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">\
                                    <span aria-hidden="true">&times;</span>\
                                </button>\
                            </div>\
                            <div class="modal-body">\
                                <div class="form-group">\
                                    <label for="passwordInput" class="sr-only">Password:</label>\
                                    <div class="input-group">\
                                        <input type="password" class="form-control" id="passwordInput" placeholder="Enter your password" required>\
                                        <div class="input-group-append">\
                                            <span class="input-group-text password-toggle" onclick="togglePasswordVisibility()"><i class="fas fa-eye-slash"></i></span>\
                                        </div>\
                                    </div>\
                                </div>\
                            </div>\
                            <div class="modal-footer">\
                                <button type="button" class="btn btn-primary" id="confirmPassword"><i class="fas fa-check"></i> Confirm</button>\
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>\
                            </div>\
                        </div>\
                    </div>\
                </div>');

                    modal.on('hidden.bs.modal', function() {
                        // Remove the modal from the DOM after it has been closed
                        modal.remove();
                    });

                    $('body').append(modal);
                    modal.modal('show');

                    $("#confirmPassword").click(function() {
                        var enteredPassword = $("#passwordInput").val();

                        if (enteredPassword.trim() !== "") {
                            $.ajax({
                                url: "verify_password.php",
                                method: "POST",
                                data: {
                                    userId: actionDetails.userId,
                                    password: enteredPassword
                                },
                                success: function(response) {
                                    if (response.trim() === "Password is correct!") {
                                        actionDetails.performAction();
                                    } else {
                                        showNotification(actionDetails.errorMessage, 'danger');
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.error(error);
                                }
                            });
                            modal.modal('hide');
                        } else {
                            showNotification("Please enter your password.", 'warning');
                        }
                    });
                }


                $("#AccountSettings").click(function() {
                    var accountSettingsDetails = {
                        userId: <?php echo $selectedUserId; ?>,
                        performAction: function() {
                            var accountSettingUrl = "accountsetting.php?userId=<?php echo $selectedUserId; ?>";
                            $(".content-section iframe").attr("src", accountSettingUrl).css("margin-top", "50px");
                        },
                        successMessage: "Password is correct! Opening account settings...",
                        errorMessage: "Incorrect password. Please try again."
                    };

                    verifyPasswordAndPerformAction(accountSettingsDetails);
                    var pageName = $(this).attr("id");
                    logHistoricalData(pageName);
                });


                $("#ProfileSettings").click(function() {
                    var profileSettingsDetails = {
                        userId: <?php echo $selectedUserId; ?>,
                        performAction: function() {
                            var profileSettingUrl = "profilesetting.php?kidId=<?php echo $selectedKidId; ?>";
                            $(".content-section iframe").attr("src", profileSettingUrl).css("margin-top", "50px");
                        },
                        successMessage: "Password is correct! Opening profile settings...",
                        errorMessage: "Incorrect password. Please try again."
                    };

                    verifyPasswordAndPerformAction(profileSettingsDetails);
                    var pageName = $(this).attr("id");
                    logHistoricalData(pageName);
                });

                $("#chooseAnotherProfile").click(function() {
                    var chooseAnotherProfileDetails = {
                        userId: <?php echo $selectedUserId; ?>,
                        performAction: function() {
                            window.location.href = "login.php?userId=<?php echo $selectedUserId; ?>";
                        },
                        successMessage: "Password is correct! Redirecting to login...",
                        errorMessage: "Incorrect password. Please try again."
                    };

                    verifyPasswordAndPerformAction(chooseAnotherProfileDetails);
                    var pageName = $(this).attr("id");
                    logHistoricalData(pageName);
                });

                $("#logout").click(function() {
                    // Show loading spinner while waiting
                    $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Logging out...');

                    // Perform any logout logic here

                    // Redirect to login after 3 seconds
                    setTimeout(function() {
                        window.location.href = "login.html";
                    }, 3000);
                    var pageName = $(this).attr("id");
                    logHistoricalData(pageName);
                });




                // Add magic navigation menu indicator
                $(".account-menu-item").click(function() {
                    $(".account-menu-item").removeClass("active");
                    $(this).addClass("active");
                });
            });
        </script>

        <script>
            $(document).ready(function() {
                // Function to log historical data
                function logHistoricalData(pageName) {
                    // Assuming you have the selectedKidId available
                    var kidId = <?php echo $selectedKidId; ?>;

                    // Send an AJAX request to log historical data
                    $.ajax({
                        url: "log_history.php",
                        method: "POST",
                        data: {
                            kidId: kidId,
                            pageName: pageName
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


                // Handle click events on nav links
                $(".navbar-nav a").click(function(event) {
                    event.preventDefault(); // Prevent the default behavior

                    // Get the target and content section
                    var target = $(this).data("target");
                    var contentSection = $("#" + target);

                    // Define the mapping of target to PHP file
                    var targetToPhp = {
                        'acceuil': 'acceuil.php',
                        'stories': 'stories.html',
                        'games': 'games.html',
                        'activities': 'activities.html'
                        // Add more targets as needed
                    };

                    // Log historical data when a section is clicked
                    var pageName = target;
                    logHistoricalData(pageName);

                    // Update the iframe src based on the target
                    var phpFile = targetToPhp[target];
                    var iframeSrc = phpFile + '?kidId=<?php echo $selectedKidId; ?>';
                    contentSection.find('iframe').attr('src', iframeSrc);

                    // Hide other content sections
                    $(".content-section").not(contentSection).hide();

                    // Show the corresponding content section
                    contentSection.show();
                });
            });
        </script>

        <script>
            $(document).ready(function() {
                // Magic Navigation Menu Indicator
                $(".nav-link").click(function() {
                    $(".nav-link").removeClass("active");
                    $(this).addClass("active");
                });

                // Add "active" class to the "Acceuil" link on page load
                $("#acceuilNavLink").addClass("active");
            });
        </script>

    </body>

    </html>






<?php
} else {
    // Invalid kid ID
    echo "Invalid kid ID!";
}

?>