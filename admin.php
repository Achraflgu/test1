<?php
session_start();
require_once('config/simple_database.php');

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// Check if user is admin
$userId = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = " . intval($userId);
$result = simpleQuery($sql);

if (count($result) == 0) {
    header("Location: login.html");
    exit();
}

$user = $result[0];
if (!isset($user['isAdmin']) || !($user['isAdmin'] == 1 || $user['isAdmin'] === true || $user['isAdmin'] === 'true')) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <style>
        body {
            padding-top: 56px;
            margin: 0;
            font-family: Arial, sans-serif;
            background-image: linear-gradient(rgba(0,0,0,0.2),rgba(0,0,0,0.2)), url(./images/bg-adminn.png);
        }

        #sidebar {
    height: 100%;
    width: 250px;
    position: fixed;
    top: 0;
    left: -250px; /* Start from the left (off-screen) */
    background-color: rgba(192, 121, 15, 0.8); /* Updated sidebar color with transparency */
    padding-top: 20px;
    backdrop-filter: blur(10px); /* Apply blur effect to the background */
    animation: slideIn 0.5s ease-out forwards; /* Animation for sliding in */
}

@keyframes slideIn {
    to {
        left: 0; /* Move to the final position */
    }
}

h2 {
    color: #5f2a72;
    text-align: center;
    margin-bottom: 30px;
    font-family: 'Luckiest Guy';
    font-size: 36px; /* Adjust the size as needed */
}
.titre-ad{
    
    text-align: left;
    margin-bottom: 30px;
    font-family: 'Luckiest Guy', cursive;
    font-size: 36px; /* Adjust the size as needed */

}
        
        #content {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s; /* Added smooth transition for content */
        }

        .section {
            display: none;
        }

        .section.active {
            display: block;
        }

        .nav-link {
            color: #fff; /* Updated text color */
            position: relative;
            padding-left: 20px;
            cursor: pointer;
            transition: color 0.3s; /* Added transition effect for color change */
        }

        .nav-link i {
            margin-right: 10px;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #5f2a72; /* Updated hover and active text color */
        }

        .logout-link {
            position: absolute;
            bottom: 0;
            width: 100%;
        }

        /* Creative Navigation Indicator */
        .nav-link:after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -5px;
            height: 3px;
            width: 0;
            background-color: #5f2a72;
            transition: width 0.3s ease-in-out;
        }

        .nav-link.active:after,
        .nav-link:hover:after {
            width: 100%;
        }
        
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div id="sidebar">
        <h2 class="text-center mb-4 text-light">Admin Panel</h2>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="#users"><i class="fas fa-users"></i> Users</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#games"><i class="fas fa-gamepad"></i> Games</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#stories"><i class="fas fa-book"></i> Stories</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#activities"><i class="fas fa-tasks"></i> Activities</a>
            </li>
            <!-- Add Notifications link -->
        <li class="nav-item">
            <a class="nav-link" href="#notifications"><i class="fas fa-bell"></i> Notifications</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="#feedback"><i class="fas fa-comments"></i> Feedbacks</a>
        </li>
        </ul>
        <!-- Logout Link -->
        <a class="nav-link text-light logout-link" href="#" onclick="logout()"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
    <script>
    function logout() {
        // Show loading message
        $('.nav-link.logout-link').html('<i class="fas fa-spinner fa-spin"></i> Logging out...');

        // Simulate a delay (you can remove this in a real application)
        setTimeout(function () {
            // Navigate to the login page after a delay
            window.location.href = "login.html";
        }, 3000); // 3000 milliseconds (3 seconds) delay - adjust as needed
    }
</script>
    <!-- Page Content -->
    <div id="content">
        <div class="container-fluid mt-1">

            <!-- Users Section -->
            <div id="users" class="section active">
                <h2>Manage Users</h2>
                <!-- User management content goes here -->
                <object type="text/php" data="users.php" width="100%" height="700px"></object>
            </div>

            <!-- Games Section -->
            <div id="games" class="section">
                <h2>Manage Games</h2>
                <!-- Game management content goes here -->
                <object type="text/php" data="games.php" width="100%" height="800px"></object>
            </div>

            <!-- Stories Section -->
            <div id="stories" class="section">
                <h2>Manage Stories</h2>
                <!-- Story management content goes here -->
                <object type="text/php" data="stories.php" width="100%" height="700px"></object>
            </div>

            <!-- Activities Section -->
            <div id="activities" class="section">
                <h2>Manage Activities</h2>
                <!-- Activity management content goes here -->
                <object type="text/php" data="activities.php" width="100%" height="700px"></object>
            </div>

            <!-- Notifications Section -->
            <div id="notifications" class="section">
                <h2>Notifications</h2>
                <object type="text/php" data="Notifications.php" width="100%" height="700px"></object>
            </div>
            <div id="feedback" class="section">
                <h2>Feedbacks</h2>
                <object type="text/php" data="feedbackshow.php" width="100%" height="700px"></object>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('.nav-link').click(function (e) {
                e.preventDefault();
                var target = $(this).attr('href');
                $('.section').removeClass('active');
                $(target).addClass('active');
                $('.nav-link').removeClass('active');
                $(this).addClass('active');
            });
        });
    </script>

</body>

</html>
