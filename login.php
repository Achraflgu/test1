<?php
session_start();

require_once('config/simple_database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $enteredEmail = $_POST['loginEmail'];
    $enteredPassword = trim($_POST['loginPassword']);

    // Use simple query without prepared statements
    $sql = "SELECT * FROM users WHERE email = '" . addslashes($enteredEmail) . "'";
    $result = simpleQuery($sql);

    if (count($result) > 0) {
        $row = $result[0];
        if ($enteredPassword == $row['password']) {
            if (isset($row['isAdmin']) && $row['isAdmin'] == 1) {
                // Admin user, redirect to the admin page
                header("Location: admin.php");
                exit();
            } else {
                // Fetch information about children from the 'children' table
                $_SESSION['user_id'] = $row['id'];
                $userId = $row['id'];
                
                // Use simple query for children
                $childrenSql = "SELECT * FROM children WHERE user_id = " . intval($userId);
                $childrenResult = simpleQuery($childrenSql);

                // Check if there are children
                if (count($childrenResult) > 0) {
                    echo '<div class="container mt-10">';
                    echo '<div class="row justify-content-center align-items-center">';
                    echo '<div class="col-lg-10 col-md-12 text-center">';
                    echo '<h2 class=" " style="font-weight: bold; text-align: center; ">Select a Child Profile</h2>';

                    echo '<form id="profileForm" method="post" action="gender.php">';
                    echo '<div class="custom-radio d-flex justify-content-center">';
                
                    foreach ($childrenResult as $kidRow) {
                        $kidGender = $kidRow["kid_gender"];
                        $kidName = $kidRow["kid_name"];
                        $kidPhoto = $kidRow["kid_photo"];
                        $kidId = $kidRow['id'];
                
                        $sanitizedKidName = urlencode(sanitizeKidName($kidName));
                        $genderClass = ($kidGender === 'female') ? ' card-female' : ' card-male';
                
                        echo '<div class="card' . $genderClass . ' mx-2 mb-4" style="flex: 0 0 auto; width: 200px; min-height: 350px; text-align: center;">';
                        echo '<input type="radio" name="kidSelect" id="kid' . $kidId . '" value="' . $kidGender . '|' . $sanitizedKidName . '|' . $kidId . '" class="form-check-input">';
                        echo '<label class="form-check-label" for="kid' . $kidId . '">';
                        echo '<img src="' . $kidPhoto . '" class="card-img-top" alt="' . $kidName . '" style="width: 100%; height: 200px; object-fit: cover; border-radius: 10px;">';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">' . $kidName . '</h5>';
                        echo '</div>';
                        echo '</label>';
                        echo '</div>';
                    }
                
                    echo '</div>';
                    echo '</form>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
        
                    // Loading overlay and spinner
                    echo '<div class="overlay" id="overlay"></div>';
                    echo '<div class="loading-spinner loading-spinner-female" id="loadingSpinnerFemale">';
                    echo '<div class="spinner-border" role="status">';
                    echo '<span class="sr-only">Loading...</span>';
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="loading-spinner loading-spinner-male" id="loadingSpinnerMale">';
                    echo '<div class="spinner-border" role="status">';
                    echo '<span class="sr-only">Loading...</span>';
                    echo '</div>';
                    echo '</div>';
                } else {
                    // If there are no children, show add child option
                    echo '<div class="container mt-10">';
                    echo '<div class="row justify-content-center align-items-center">';
                    echo '<div class="col-lg-10 col-md-12 text-center">';
                    echo '<h2 class=" " style="font-weight: bold; text-align: center; ">No Child Profiles Found</h2>';
                    echo '<p style="font-size: 18px; color: #666; margin-bottom: 30px;">You don\'t have any child profiles yet. Add your first child to get started!</p>';
                    echo '<div class="text-center">';
                    echo '<a href="add_child_new.html?userId=' . $userId . '" class="btn btn-primary btn-lg" style="background-color: #5f2a72; border: none; padding: 15px 30px; font-size: 18px;">';
                    echo '<i class="fas fa-user-plus"></i> Add Your First Child';
                    echo '</a>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            }
        } else {
            // Password is incorrect
            echo "Incorrect password!";
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['userId'])) {
    $userId = $_GET['userId'];
    $childrenSql = "SELECT * FROM children WHERE user_id = " . intval($userId);
    $childrenResult = simpleQuery($childrenSql);

    if (count($childrenResult) > 0) {
        echo '<div class="container mt-5">';
        echo '<div class="row justify-content-center align-items-center">';
        echo '<div class="col-lg-10 col-md-12 text-center">';
        echo '<h2 class=" " style="font-weight: bold; text-align: center;">Select a Child Profile</h2>';
        echo '<form id="profileForm" method="post" action="gender.php">';
        echo '<div class="custom-radio d-flex justify-content-center">';
    
        foreach ($childrenResult as $kidRow) {
            $kidGender = $kidRow["kid_gender"];
            $kidName = $kidRow["kid_name"];
            $kidPhoto = $kidRow["kid_photo"];
            $kidId = $kidRow['id'];
    
            $sanitizedKidName = urlencode(sanitizeKidName($kidName));
            $genderClass = ($kidGender === 'female') ? ' card-female' : ' card-male';
    
            echo '<div class="card' . $genderClass . ' mx-2 mb-4" style="flex: 0 0 auto; width: 200px; min-height: 350px; text-align: center;">';
            echo '<input type="radio" name="kidSelect" id="kid' . $kidId . '" value="' . $kidGender . '|' . $sanitizedKidName . '|' . $kidId . '" class="form-check-input">';
            echo '<label class="form-check-label" for="kid' . $kidId . '">';
            echo '<img src="' . $kidPhoto . '" class="card-img-top" alt="' . $kidName . '" style="width: 100%; height: 200px; object-fit: cover; border-radius: 10px;">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . $kidName . '</h5>';
            echo '</div>';
            echo '</label>';
            echo '</div>';
        }
    
        echo '</div>';
        echo '</form>';
        echo '</div>';
        echo '</div>';
        echo '</div>';

        // Loading overlay and spinner
        echo '<div class="overlay" id="overlay"></div>';
        echo '<div class="loading-spinner loading-spinner-female" id="loadingSpinnerFemale">';
        echo '<div class="spinner-border" role="status">';
        echo '<span class="sr-only">Loading...</span>';
        echo '</div>';
        echo '</div>';
        echo '<div class="loading-spinner loading-spinner-male" id="loadingSpinnerMale">';
        echo '<div class="spinner-border" role="status">';
        echo '<span class="sr-only">Loading...</span>';
        echo '</div>';
        echo '</div>';
    } else {
        echo "No children found for the user.";
    }
}

function sanitizeKidName($kidName)
{
    return preg_replace("/[^a-zA-Z0-9]/", "", $kidName);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-xxx" crossorigin="anonymous" />

    <style>
     body {
    font-family: 'Poppins', sans-serif;
    background-color: #f8f9fa;
    background-image: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)), url('images/bg_login_1.png');
    background-size: cover;
    background-position: center;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background-image 0.5s ease, background-size 0.5s ease, background-position 0.5s ease, box-shadow 0.5s ease, transform 0.5s ease;
    animation: slideUp 1s ease-in-out;
}

@keyframes slideUp {
    from {
        transform: translateY(100%);
    }
    to {
        transform: translateY(0);
    }
}

      h2 {
    color: #5f2a72;
    text-align: center;
    margin-bottom: 30px;
    font-family: 'Poppins', sans-serif;
    font-size: 36px;
    opacity: 0;
    transform: translateY(20px);
    animation: fadeInUp 1s ease-out forwards;
}

@keyframes fadeInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.card-img-top {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 10px;
    transition: transform 0.5s ease-in-out;
    animation: scaleUp 0.5s ease-in-out;
}

.card-img-top:hover {
    transform: scale(1.1);
}

@keyframes scaleUp {
    0% {
        transform: scale(0.8);
    }
    100% {
        transform: scale(1);
    }
}

      .custom-radio input[type="radio"] {
         display: none;
      }

      .custom-radio label {
         cursor: pointer;
         position: relative;
         transition: transform 0.3s ease-in-out;
      }

      .custom-radio img {
         width: 300px;
         height: 300px;
         object-fit: cover;
         border-radius: 10px;
      }

      .custom-radio .card {
         margin-top: 15px;
         padding: 0;
         margin: 0;
         background: none !important;
         box-shadow: none !important;
         border: none;
      }

      .custom-radio .card-female label:hover img {
    border: 5px solid #ff69b4;
    transform: scale(1.05);
}

.custom-radio .card-male label:hover img {
    border: 5px solid #007bff;
    transform: scale(1.05);
}

      .overlay {
         display: none;
         position: fixed;
         top: 0;
         left: 0;
         width: 100%;
         height: 100%;
         background: rgba(0, 0, 0, 0.5);
         z-index: 1000;
      }

      .loading-spinner {
         display: none;
         position: fixed;
         top: 50%;
         left: 50%;
         transform: translate(-50%, -50%);
         z-index: 1001;
      }

      .loading-spinner-female {
         color: #ff69b4;
      }

      .loading-spinner-male {
         color: #007bff;
      }

      .logo {
    position: absolute;
    top: 30px;
    left: 48%;
    right: 50%;
    transform: translateX(-50%);
    width: 350px;
    transform-origin: center bottom;
    transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
}

.logo:hover {
    transform: translateX(-50%) scale(1.2);
    opacity: 0.8;
}

      .logo img {
         max-width: 400px;
      }

      .add-profile-btn {
         position: fixed;
         bottom: 20px;
         right: 20px;
         background-color: #5f2a72;
         color: #fff;
         border: none;
         width: 60px;
         height: 60px;
         border-radius: 50%;
         font-size: 20px;
         cursor: pointer;
         display: flex;
         align-items: center;
         justify-content: center;
         box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
         transition: background-color 0.3s ease-in-out, transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
         z-index: 1002;
      }

      .add-profile-btn i {
         margin-right: 0;
      }

      .add-profile-btn:hover {
         background-color: #5f2a72;
         transform: scale(1.05);
         box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2);
      }

      .modal-header{
        background-color: rgba(192, 121, 15, 0.8);
        font-family: 'Poppins', sans-serif;
        font-size: 36px;
        color: #fff;
      }
      .btn {
  background-color: rgba(192, 121, 15, 0.8);
  color: #fff;
}
.modal-body {
    animation: fadeInUp 0.5s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

h2{
    padding-top: 40px;
    margin-top: 40px;
    font-weight: bold;
}
      
   </style>
</head>

<body>
<div class="logo">
        <img src="./images/logo_1.png" alt="Your Logo">
</div>

<!-- Add Profile button -->
<button class="btn btn-primary add-profile-btn" id="addProfileBtn" data-toggle="modal" data-target="#addProfileModal">
    <i class="fas fa-user-plus"></i></button>
<!-- Add Profile Modal -->

    <div class="modal" id="addProfileModal" tabindex="-1" role="dialog" aria-labelledby="addProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="modal-title" id="addProfileModalLabel">Add Profile</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form for adding a new profile -->
                <form id="addProfileForm" method="post" action="add_profile.php" enctype="multipart/form-data">
                    <!-- Replace with your actual form fields -->
                    <input type="hidden" name="user_id" id="modalUserId" value="<?php echo isset($userId) ? $userId : ''; ?>">
                    
                    <div class="form-group">
                        <label for="newKidName"><i class="fas fa-user"></i> Kid Name:</label>
                        <input type="text" class="form-control" id="newKidName" name="newKidName" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="newKidGender"><i class="fas fa-venus-mars"></i> Kid Gender:</label>
                        <select class="form-control" id="newKidGender" name="newKidGender" required>
                            <option value="" selected disabled>Choose the gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="newKidAge"><i class="fas fa-birthday-cake"></i> Kid Age:</label>
                        <input type="number" class="form-control" id="newKidAge" name="newKidAge" max="6" min="3" required>
                    </div>

                    <div class="form-group">
                        <label for="newKidPhoto"><i class="fas fa-camera"></i> Kid Photo:</label>
                        <input type="file" class="form-control-file" id="newKidPhoto" name="newKidPhoto" accept="image/*" onchange="previewKidPhoto()">
                        <img id="kidPhotoPreview" src="#" alt="Kid Photo" style="display: none; max-width: 100%; margin-top: 10px;">
                    </div>

                    <button type="submit" class="btn"><i class="fas fa-plus"></i> Add Profile</button>
                </form>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
         function previewKidPhoto() {
        var input = document.getElementById('newKidPhoto');
        var preview = document.getElementById('kidPhotoPreview');

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
        $(document).ready(function () {
            $(".custom-radio label").hover(
                function () {
                    $(this).css("transform", "scale(1.05)");
                },
                function () {
                    $(this).css("transform", "scale(1)");
                }
            );

            $("input[name='kidSelect']").change(function () {
                var gender = $("input[name='kidSelect']:checked").val().split('|')[0];

                // Show the appropriate spinner based on gender
                if (gender === 'female') {
                    $("#loadingSpinnerFemale").show();
                    $("#overlay").show();
                    $("#loadingSpinnerMale").hide();
                } else if (gender === 'male') {
                    $("#loadingSpinnerMale").show();
                    $("#overlay").show();
                    $("#loadingSpinnerFemale").hide();
                }

                setTimeout(function () {
                    $("#profileForm").submit();
                }, 1000); // 3000 milliseconds = 3 seconds
            });

            $("#addProfileBtn").click(function () {
                $("#addProfileModal").modal('show');
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

</body>

</html>
