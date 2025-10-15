
<?php
// Include the database connection file
require_once('config/database.php');
$database = new Database();
$conn = $database->getConnection();

// Initialize variables
$userEmail = "";

// Check if user ID is provided in the URL
if (isset($_GET['userId'])) {
    $selectedUserId = $_GET['userId'];

    // Fetch user's email using the user ID
    $getUserEmailSql = "SELECT email FROM users WHERE id = " . intval($selectedUserId);
    
    // Get user email using simple query
    $userResult = simpleQuery($getUserEmailSql);
    
    if ($userResult && count($userResult) > 0) {
        $userEmail = $userResult[0]['email'];
    }
    
    // PDO connection closes automatically
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Rating Form</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    
    <style>
      body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)),
                url('./images/bg_login_1.png') no-repeat center center fixed;
                background-size: cover;
            background-position: center;
    padding: 10px 8%;
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 88vh; /* Set the body height to the full viewport height */
    margin: 0;
    font-family: 'Poppins', sans-serif;
    overflow: hidden;
    }

    .main-block {
    text-align: center;
    width: 90%;
    max-width: 600px;
    padding: 20px;
    border-radius: 10px;
    transition: transform 0.3s ease-in-out;
    margin-top: auto;
    background-color: rgba(255, 255, 255, 0.88);
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px; /* Add some space between the containers */
    padding: 20px;
    transition: transform 0.3s ease-in-out;
    animation: slideInRight 0.5s ease-out;
}


@keyframes slideInRight {
    from {
        transform: translateX(100%); /* Start from the right */
    }
    to {
        transform: translateX(0); /* Move in to the normal position */
    }
}



      h1 {
        font-size: 32px;
        color: #333;
            text-align: center;
            margin-bottom: 30px;
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

      form {
        width: 100%;
      }

      .info-item {
        margin-bottom: 20px;
        position: relative;
      }

      label.icon {
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        background: #666;
        color: #fff;
        padding: 10px;
        border-radius: 5px 0 0 5px;
      }

      input {
        width: calc(100% - 40px);
        height: 36px;
        padding-left: 40px;
        border-radius: 0 5px 5px 0;
        border: solid 1px #ccc;
        box-shadow: 1px 2px 5px rgba(0, 0, 0, 0.1);
        background: #fff;
        transition: border-color 0.3s ease-in-out;
      }

      input:focus {
        border-color: #8ebf42;
      }

      .grade-type div {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        margin-bottom: 20px;
      }

      input[type="radio"] {
        display: none;
      }

      label.radio {
        position: relative;
        display: inline-block;
        margin-right: 15px;
        cursor: pointer;
        padding-left: 30px;
      }

      label.radio:before {
        content: "";
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 18px;
        height: 18px;
        border-radius: 50%;
        border: 0.5px solid #8ebf42;
        background: #fff;
        transition: background 0.3s ease-in-out;
      }

      input[type="radio"]:checked + label.radio:before {
        background: #8ebf42;
      }

      h3 {
        margin-top: 20px;
        font-size: 24px;
        color: #333;
      }

      textarea {
        width: 100%;
        height: 80px;
        margin-bottom: 20px;
        border-radius: 5px;
        border: solid 1px #ccc;
        box-shadow: 1px 2px 5px rgba(0, 0, 0, 0.1);
        resize: none;
        transition: border-color 0.3s ease-in-out;
        margin-right: 50px;
      }

      textarea:focus {
        border-color: #8ebf42;
      }

      button {
        width: 100%;
        padding: 10px;
        border-radius: 5px;
        border: none;
        background: #8ebf42;
        font-size: 18px;
        font-weight: 600;
        color: #fff;
        cursor: pointer;
        transition: background 0.3s ease-in-out;
      }

      button:hover {
        background: #82b534;
      }

      @media (max-width: 768px) {
        .main-block {
          transform: scale(0.9);
        }
      }
      .grade-type div {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
      }

      .radio {
        display: flex;
        align-items: center;
        cursor: pointer;
      }

      .radio i {
        margin-right: 10px;
      }
    </style>
  </head>
  <body>
  <div id="notification" class="notification"></div>
    <div class="main-block">
      <h1>FEEDBACK</h1>
      <form action="" method="post">
        <div class="info">
          <div class="info-item">
            <label class="icon" for="name"><i class="fas fa-user"></i></label>
            <input type="text" name="name" id="name" placeholder="Name" required/>
          </div>
          <div class="info-item">
            <label class="icon" for="age"><i class="fas fa-calendar"></i></label>
            <input type="text" name="age" id="age" placeholder="Age" required/>
          </div>
          <div class="info-item">
            <label class="icon" for="email"><i class="fas fa-envelope"></i></label>
            <input type="text" name="email" id="email" placeholder="Email" value="<?php echo $userEmail; ?>" readonly/>
          </div>
          <div class="info-item">
            <label class="icon" for="phone"><i class="fas fa-phone"></i></label>
            <input type="text" name="phone" id="phone" placeholder="Phone" required/>
          </div>
        </div>
        <div class="grade-type">
      <h3>Rate Our Website</h3>
      <div>
        <input type="radio" value="Excellent" id="radioOne" name="grade" checked/>
        <label for="radioOne" class="radio"><i class="fas fa-star"></i> Excellent</label>
      </div>
      <div>
        <input type="radio" value="Very Good" id="radioTwo" name="grade" />
        <label for="radioTwo" class="radio"><i class="fas fa-thumbs-up"></i> Very Good</label>
      </div>
      <div>
        <input type="radio" value="Good" id="radioThree" name="grade" />
        <label for="radioThree" class="radio"><i class="fas fa-smile"></i> Good</label>
      </div>
      <div>
        <input type="radio" value="Bad" id="radioFour" name="grade" />
        <label for="radioFour" class="radio"><i class="fas fa-frown"></i> Bad</label>
      </div>
      <div>
        <input type="radio" value="Very Bad" id="radioFive" name="grade" />
        <label for="radioFive" class="radio"><i class="fas fa-thumbs-down"></i> Very Bad</label>
      </div>
    </div>
        <h3>Please Comment on Your Rating</h3>
        <textarea name="comments" rows="4"></textarea>
        <button type="submit">Submit</button>
      </form>
    </div>
    </body>

<style>
    .notification {
        display: none;
        position: fixed;
        bottom: 100px;
        right: 40px;
        padding: 15px;
        background-color: #333;
        color: #fff;
        border-radius: 5px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
        z-index: 9999;

    }

    .notification.danger {
        background-color: #e74c3c; /* Danger color */
        color: #fff;
    }

    .notification.warning {
        background-color: #f39c12; /* Warning color */
        color: #fff;
    }

    .notification.success {
        background-color: #2ecc71; /* Success color */
        color: #fff;
    }

    .notification.info {
        background-color: #3498db; /* Default info color */
        color: #fff;
    }

    .notification i {
        margin-right: 10px;
    }
</style>

<script>
    function showNotification(message, type = 'info') {
        var notification = document.getElementById("notification");
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

        notification.innerHTML = '<i class="' + iconClass + '"></i>' + message;
        notification.className = 'notification ' + type;
        notification.style.display = 'block';

        setTimeout(function () {
            notification.style.display = 'none';
        }, 5000); // 5 seconds
    }
</script>

<?php
// Include the database connection file
require_once('config/database.php');
$database = new Database();
$conn = $database->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $rating = mysqli_real_escape_string($conn, $_POST['grade']);
    $comments = mysqli_real_escape_string($conn, $_POST['comments']);

    // Insert data into feedback table using prepared statement
    $sql = "INSERT INTO feedback (name, age, email, phone, rating, comments) VALUES (?, ?, ?, ?, ?, ?)";

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sissss", $name, $age, $email, $phone, $rating, $comments);

    // Check if the query is executed successfully
    if ($stmt->execute()) {
        echo '<script>showNotification("Feedback submitted successfully", "success");</script>';
    } else {
        echo '<script>showNotification("Error: ' . $stmt->errorInfo()[2] . '", "danger");</script>';
        error_log("Error: " . $stmt->errorInfo()[2]);
    }

    // PDO connection closes automatically
}

// PDO connection closes automatically
?>
</html>

