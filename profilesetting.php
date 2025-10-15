<?php
// profilesetting.php

// Include your database connection
require_once('config/simple_database.php');


// Check if kidId is set in the URL
if (isset($_GET['kidId'])) {
    // Assuming you have the user's selected kid ID passed as a URL parameter
    $selectedKidId = $_GET['kidId']; // Get the kid's ID from the URL

    // Fetch kid information from the database based on the selected ID
    $sql = "SELECT * FROM children WHERE id = $selectedKidId";
    $result = $result = simpleQuery($sql);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateProfile'])) {
        // Handle form submission (update profile)
        $newKidName = $_POST['kidName'];
        $newKidAge = $_POST['kidAge'];
        $fileError = false;
        $updateSql = ""; // Initialize the variable
    
        // Check if a new photo is provided
        if ($_FILES['newKidPhoto']['error'] == 0) {
            // File upload configuration
            $targetDir = 'uploads/'; // Change this to your desired directory
            $targetFile = $targetDir . basename($_FILES['newKidPhoto']['name']);
            
            // Check if the uploaded file is an image
            $check = getimagesize($_FILES["newKidPhoto"]["tmp_name"]);
            if ($check === false) {
                // Set the fileError variable to true
                $fileError = true;
                // Display an error message
                $alertMessage = '<div class="alert alert-danger" role="alert">Error: The uploaded file is not an image.</div>';
                echo $alertMessage;
            } else {
                // Move the uploaded file to the target directory
                if (move_uploaded_file($_FILES['newKidPhoto']['tmp_name'], $targetFile)) {
                    // Update the profile with the new photo path
                    $updateSql = "UPDATE children SET kid_name = '$newKidName', kid_age = '$newKidAge', kid_photo = '$targetFile' WHERE id = $selectedKidId";
                } else {
                    // Set the fileError variable to true
                    $fileError = true;
                    // Display an error message
                    $alertMessage = '<div class="alert alert-danger" role="alert">Error: There was an error uploading your file.</div>';
                    echo $alertMessage;
                }
            }
        } else {
            // Update the profile without changing the photo
            $updateSql = "UPDATE children SET kid_name = '$newKidName', kid_age = '$newKidAge' WHERE id = $selectedKidId";
        }
    
        // Execute the query only if $updateSql is defined
        if ($updateSql !== "") {
            $updateResult = simpleExecute($updateSql);
    
            if ($updateResult) {
                header("refresh:1;url=profilesetting.php?kidId=$selectedKidId");
                $alertMessage = '<div class="alert alert-success" role="alert">Profile updated successfully!</div>';
            } else {
                $alertMessage = '<div class="alert alert-danger" role="alert">Error updating profile</div>';
            }
        }}

    if ($result && count($result) > 0) {
        $row = $result[0];
        $selectedKidName = $row['kid_name'];
        $selectedKidAge = $row['kid_age'];
        $selectedKidPhoto = $row['kid_photo'];
        $selectedUserId = $row['user_id']; // assuming user_id is in the children table;
    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Settings</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">


    <!-- Add your additional CSS styles here -->
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
    height: 100vh; /* Set the body height to the full viewport height */
    margin: 0;
    font-family: 'Poppins', sans-serif;
    overflow: hidden;
    }
    


.table {
        margin-top: 30px;
    border-radius: 15px;
    border-radius: 10px;
    margin-bottom: 20px; /* Add some space between the containers */
    padding: 20px;
    height: 100%;
    transition: transform 0.3s ease-in-out;
    animation: popIn 0.5s ease-out;
    -webkit-animation:container .9s both;animation:container .9s both
    }
    .header-banner {
        background-color: #007bff;
        color: #fff;
        padding: 20px;
        text-align: center;
    }

    h4 {
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

    .container {
        margin-top: 50px;
    }

    form {
        max-width: 600px;
        margin: auto;
    }

    .form-group {
        margin-bottom: 20px;
    }
    .row-eq-height {
        display: flex;
        align-items: stretch;
    }

    /* Update the existing-info and hidden-categories styles */
    .existing-info,
    .hidden-categories {
        margin-top: auto;
    background-color: rgba(255, 255, 255, 0.88);
    border-radius: 15px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    margin-bottom: 20px; /* Add some space between the containers */
    padding: 20px;
    height: 100%;
    transition: transform 0.3s ease-in-out;
    animation: popIn 0.5s ease-out;
    -webkit-animation:container .9s both;animation:container .9s both
    }

    .existing-info:hover,
    .hidden-categories:hover {
    transform: scale(1.02);
    /* Slightly enlarge on hover */
    transition: transform 0.3s ease-in-out;
}

            @keyframes popIn {
                from {
                    transform: translateY(100%);
                    /* Start from the bottom */
                }

                to {
                    transform: translateY(0);
                    /* Move to the normal position */
                }
            }

            @-webkit-keyframes container {
                0% {
                    -webkit-transform: scale3d(1, 1, 1);
                    transform: scale3d(1, 1, 1);
                }

                30% {
                    -webkit-transform: scale3d(1.25, 0.75, 1);
                    transform: scale3d(1.25, 0.75, 1);
                }

                40% {
                    -webkit-transform: scale3d(0.75, 1.25, 1);
                    transform: scale3d(0.75, 1.25, 1);
                }

                50% {
                    -webkit-transform: scale3d(1.15, 0.85, 1);
                    transform: scale3d(1.15, 0.85, 1);
                }

                65% {
                    -webkit-transform: scale3d(0.95, 1.05, 1);
                    transform: scale3d(0.95, 1.05, 1);
                }

                75% {
                    -webkit-transform: scale3d(1.05, 0.95, 1);
                    transform: scale3d(1.05, 0.95, 1);
                }

                100% {
                    -webkit-transform: scale3d(1, 1, 1);
                    transform: scale3d(1, 1, 1);
                }
            }

            @keyframes container {
                0% {
                    -webkit-transform: scale3d(1, 1, 1);
                    transform: scale3d(1, 1, 1);
                }

                30% {
                    -webkit-transform: scale3d(1.25, 0.75, 1);
                    transform: scale3d(1.25, 0.75, 1);
                }

                40% {
                    -webkit-transform: scale3d(0.75, 1.25, 1);
                    transform: scale3d(0.75, 1.25, 1);
                }

                50% {
                    -webkit-transform: scale3d(1.15, 0.85, 1);
                    transform: scale3d(1.15, 0.85, 1);
                }

                65% {
                    -webkit-transform: scale3d(0.95, 1.05, 1);
                    transform: scale3d(0.95, 1.05, 1);
                }

                75% {
                    -webkit-transform: scale3d(1.05, 0.95, 1);
                    transform: scale3d(1.05, 0.95, 1);
                }

                100% {
                    -webkit-transform: scale3d(1, 1, 1);
                    transform: scale3d(1, 1, 1);
                }
            }


    /* Adjust the row and column styles */
    .row {
        margin-right: 0; /* Remove negative margin that Bootstrap adds */
        margin-left: 0;  /* Remove negative margin that Bootstrap adds */
    }

    .col-md-6 {
        flex: 0 0 50%; /* Equal width for both columns */
        max-width: 50%; /* Equal width for both columns */
    }

    img.img-thumbnail {
        max-width: 30%;
        height: auto;
        border-radius: 8px;
        cursor: pointer;
        transition: transform 0.3s ease;
        margin-top: 3%;
        margin-left: 3%;
    }

    img.img-thumbnail:hover {
        transform: scale(1.1);
    }

    .file-input-label {
        display: block;
        margin-top: 10px;
    }

    .file-input {
        display: none;
    }

    .custom-file-label {
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .category-group {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .checkbox-label {
        margin-bottom: 10px;
    }

    .checkbox-label input {
        margin-right: 10px;
    }

    .alert {
        margin-top: 20px;
    }

    .alert-success {
        background-color: #d4edda;
        border-color: #c3e6cb;
        color: #155724;
    }

    .alert-danger {
        background-color: #f8d7da;
        border-color: #f5c6cb;
        color: #721c24;
    }
    .category-icon {
        color: #3498db; /* Set icon color */
        font-size: 24px; /* Adjust icon size */
    }

    .category-toggle {
        vertical-align: middle; /* Align toggle in the middle */
    }

    .category-icon i:hover {
        transform: scale(1.2); /* Add a hover effect to icons */
    }

    .btn-primary {
        background-color: #2ecc71; /* Change button color */
        border: none;
    }

    .btn-primary:hover {
        background-color: #27ae60; /* Change button color on hover */
    }
    .category-selected {
    background-color: #dff0d8; /* Bootstrap success background color */
    color: #3c763d; /* Bootstrap success text color */
}

</style>


</head>
<body>

<div class="container">



    <div class="row row-eq-height">
        <!-- Your Kid Information on the left -->
<div class="col-md-6">
    <div class="existing-info">
        <h4 class="mb-4 text-center mb-2"><i class="fas fa-child"></i> Profile Settings</h4>
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user"></i>&nbsp;  Name :</span>
                    <input type="text" class="form-control" id="kidName" name="kidName" value="<?php echo $selectedKidName; ?>">
                </div>
            </div>
            <div class="mb-3">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-birthday-cake"></i>&nbsp; Age :&nbsp;&nbsp;&nbsp;</span>
                    <input type="number" class="form-control" id="kidAge" name="kidAge" max="6" min="3" value="<?php echo $selectedKidAge; ?>">
                </div>
            </div>

            <!-- Display existing kid photo and trigger file input on click -->
            <div id="existingPhotoContainer" class="mb-3">
                        <label for="kidPhoto" class="form-label">Existing Photo:</label>
                        <img src="<?php echo $selectedKidPhoto; ?>" alt="Existing Kid's Photo" accept="image/*" class="img-thumbnail" style="cursor: pointer;" onclick="triggerFileInput()">
                    </div>

                    <!-- Input for a new photo (initially hidden) -->
                    <div id="newPhotoContainer" class="mb-3" style="display: none;">
                        <label for="newKidPhoto" class="form-label">New Kid's Photo:</label>
                        <img id="newPhotoPreview" class="img-thumbnail" alt="New Kid's Photo">
                        <input type="file" accept="image/*" class="file-input form-control" id="newKidPhoto" name="newKidPhoto"  onchange="displayNewPhoto()">
                    </div>

            <button type="submit" class="btn btn-primary d-block mx-auto mt-3" name="updateProfile"><i class="fas fa-save"></i> Save Changes</button>
        </form>
    </div>
</div>


        <!-- Manage Hidden Categories on the right -->
        <div class="col-md-6">
            <div class="hidden-categories">
            <h4 class="mb-4 text-center mb-2"><i class="fas fa-cogs icon"></i> Manage Hidden Categories</h4>

                <form method="post">
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>Category</th>
                    <th>Toggle Visibility</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="category-cell">
                        <i class="bi bi-book category-icon"></i> Stories
                    </td>
                    <td class="toggle-cell">
                        <?php displayCategoryCheckboxes('stories', $selectedKidId); ?>
                    </td>
                </tr>
                <tr>
                    <td class="category-cell">
                        <i class="bi bi-controller category-icon"></i> Games
                    </td>
                    <td class="toggle-cell">
                        <?php displayCategoryCheckboxes('games', $selectedKidId); ?>
                    </td>
                </tr>
                <tr>
                    <td class="category-cell">
                        <i class="bi bi-trophy category-icon"></i> Activities
                    </td>
                    <td class="toggle-cell">
                        <?php displayCategoryCheckboxes('activities', $selectedKidId); ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <button type="submit" class="btn btn-primary d-block mx-auto mt-3" name="saveCategories">
        <i class="bi bi-save"></i> Save Hidden/Allowed Categories
    </button>
</form>






<?php
}
// Check if the form for managing hidden categories is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['saveCategories'])) { {
    // Handle form submission (update hidden categories)
    $hiddenStories = isset($_POST['hiddenstories']) ? implode(',', $_POST['hiddenstories']) : '';
    $hiddenGames = isset($_POST['hiddengames']) ? implode(',', $_POST['hiddengames']) : '';
    $hiddenActivities = isset($_POST['hiddenactivities']) ? implode(',', $_POST['hiddenactivities']) : '';

    // Update the hidden categories in the children table
    $updateHiddenCategoriesSql = "UPDATE children SET hidden_stories_categories = '$hiddenStories', 
                                                hidden_games_categories = '$hiddenGames', 
                                                hidden_activities_categories = '$hiddenActivities' 
                                  WHERE id = $selectedKidId";

    $updateHiddenCategoriesResult = simpleExecute($updateHiddenCategoriesSql);

    if ($updateHiddenCategoriesResult) {
        $alertMessageCategories = '<div class="alert alert-success" role="alert">Hidden categories updated successfully!</div>';
        echo '<script>
                setTimeout(function(){
                    window.location.href = "profilesetting.php?kidId=' . $selectedKidId . '";
                }, 1000);
              </script>';
    } else {
        $alertMessageCategories = '<div class="alert alert-danger" role="alert">Error updating hidden categories: ' . $conn->errorInfo()[2] . '</div>';
    }
}}
?>
    </div>
</div>
</div>
<?php
    // Combine both alert messages into a single variable
    $combinedAlertMessage = '';

    if (isset($alertMessage)) {
        $combinedAlertMessage .= $alertMessage;
    }

    if (isset($alertMessageCategories)) {
        $combinedAlertMessage .= $alertMessageCategories;
    }

    // Display the combined alert message
    echo $combinedAlertMessage;
    ?>
</div>

<!-- Add your additional scripts here -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script>
    function triggerFileInput() {
        // Trigger file input when clicking on the existing photo
        var fileInput = document.getElementById('newKidPhoto');
        fileInput.click();
    }

    function displayNewPhoto() {
    // Display the new photo when selected and hide the existing one
    var fileInput = document.getElementById('newKidPhoto');
    var existingPhotoContainer = document.getElementById('existingPhotoContainer');
    var newPhotoContainer = document.getElementById('newPhotoContainer');
    var newPhotoPreview = document.getElementById('newPhotoPreview');

    if (fileInput.files && fileInput.files[0]) {
        // Hide the existing photo container
        existingPhotoContainer.style.display = 'none';

        // Show the new photo container
        newPhotoContainer.style.display = 'block';

        // Display the new photo
        var reader = new FileReader();

        reader.onload = function (e) {
            newPhotoPreview.src = e.target.result;
        };

        reader.readAsDataURL(fileInput.files[0]);
    } else {
        // Show the existing photo container when no file is selected
        existingPhotoContainer.style.display = 'block';
        
        // Hide the new photo container when no file is selected
        newPhotoContainer.style.display = 'none';
    }
    document.getElementById('newPhotoContainer').addEventListener('click', triggerFileInput);
}
</script>


</body>
</html>

<?php
}else {
    // Handle the case where the selected kid ID is not valid
    echo "Invalid kid ID!";
}

// Function to display checkboxes for a category type
function displayCategoryCheckboxes($categoryType, $selectedKidId)
{
    echo '<div>';
    echo '<div class="category-title">';
    echo '</div>';

    // Adjust the query based on the correct column name for hidden categories
    $hiddenColumnName = "hidden_{$categoryType}_categories";

    // Get categories from the table
    $categoriesResult = simpleQuery("SELECT DISTINCT category FROM {$categoryType}");

    $hiddenCategories = getHiddenCategories($selectedKidId, $hiddenColumnName);

    foreach ($categoriesResult as $row) {
        echo '<li class="list-group-item">';
        echo '<input type="checkbox" class="form-check-checkbox m-1" name="hidden' . $categoryType . '[]" value="' . $row['category'] . '" ' .
            (in_array($row['category'], $hiddenCategories) ? 'checked' : '') . '>';
        echo $row['category'];
        echo '</li>';
    }

    echo '</div>';
}

// Function to get hidden categories from the database
function getHiddenCategories($selectedKidId, $hiddenColumnName)
{
    $result = simpleQuery("SELECT {$hiddenColumnName} FROM children WHERE id = " . intval($selectedKidId));

    if ($result && count($result) > 0) {
        $row = $result[0];
        $hiddenCategoriesString = $row[$hiddenColumnName] ?? '';
        $hiddenCategories = !empty($hiddenCategoriesString) ? explode(',', $hiddenCategoriesString) : [];
        return array_filter($hiddenCategories);
    }

    return [];
}

?>
