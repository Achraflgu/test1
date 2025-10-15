<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Control Panel - Activities</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <style>
        body{
            background-color: rgba(0, 0, 0, 0);
        }
        table {
    background-color: white;
}
    </style>
</head>

<body>
    <!-- Activities Section -->
    <div id="activities" class="section">
        <!-- Activity management content goes here -->
        <div class="container mt-5">

            <!-- Activity Table -->
            <div class="activity-management-container" style="max-height: 500px; overflow-y: auto;">
    <table class="table table-bordered table-striped">
        <thead class="thead-dark" style="position: sticky; top: 0; background-color: white; z-index: 1;">
            <tr>
                <th>ID</th>
                <th>ActivityTitle</th>
                <th>Description</th>
                <th>Category</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require_once('config/database.php');
            $database = new Database();
            $conn = $database->getConnection();
            $activitiesSql = "SELECT * FROM activities";
            $stmt = $conn->prepare($activitiesSql);
            $stmt->execute();
            $activitiesResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($activitiesResult as $activityRow) {
                echo '<tr>';
                echo '<td>' . $activityRow['id'] . '</td>';
                echo '<td>' . $activityRow['activity_title'] . '</td>';
                echo '<td>' . $activityRow['description'] . '</td>';
                echo '<td>' . $activityRow['category'] . '</td>';
                echo '<td>
                <div class="btn-group" role="group">
                        <button class="btn btn-info modifyActivityBtn" data-activity-id="' . $activityRow['id'] . '"><i class="fas fa-edit"></i> Modify</button>
                        <button class="btn btn-danger deleteActivityBtn" data-activity-id="' . $activityRow['id'] . '"><i class="fas fa-trash-alt"></i> Delete</button>
                        </div>
                        </td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
</div>



            <!-- Add this script after including jQuery -->
<script>
    $(document).ready(function () {
        // Event listener for allow activity button
        $('.allowActivityBtn').click(function () {
            var activityId = $(this).data('activity-id');
            // Implement logic to allow the activity via AJAX
            console.log('Allow activity with ID:', activityId);
        });

        // Event listener for hide activity button
        $('.hideActivityBtn').click(function () {
            var activityId = $(this).data('activity-id');
            // Implement logic to hide the activity via AJAX
            console.log('Hide activity with ID:', activityId);
        });

        // Event listener for modify activity button
        $('.modifyActivityBtn').click(function () {
            var activityId = $(this).data('activity-id');

            // Fetch activity details via AJAX and populate the modal form
            $.ajax({
                type: 'GET',
                url: 'get_activity_d.php', // Create this PHP page to fetch activity details
                data: {
                    activityId: activityId
                },
                success: function (response) {
                    // Display the modal with the form and populated data
                    $('#modifyActivityModal').modal('show');
                    $('#activityIdModal').val(activityId);
                    $('#activityTitleModal').val(response.activity_title);
                    $('#activityDescriptionModal').val(response.description); // Add this line
                    $('#activityLinkModal').val(response.link_of_activities); // Add this line
                    $('#activityPhotoModal').val(response.photo); // Add this line
                    $('#activityCategoryModal').val(response.category); // Add this line
                    // Populate other form fields as needed
                },
                error: function (error) {
                    console.error('Error fetching activity details:', error);
                }
            });
        });
        $('#activityCategoryModal').change(function() {
                        // When the category dropdown changes
                        var selectedCategory = $(this).val();

                        // If the selected category is "Other", show the input field; otherwise, hide it
                        if (selectedCategory === 'Other') {
                            $('#otherCategoryInput').show();
                        } else {
                            $('#otherCategoryInput').hide();
                        }
                    });

        // Additional code for form submission if needed
        $('#modifyActivityFormModal').submit(function (e) {
            e.preventDefault();
            var activityId = $('#activityIdModal').val();
            var newTitle = $('#activityTitleModal').val();
            var newDescription = $('#activityDescriptionModal').val();
            var newLink = $('#activityLinkModal').val();
            var newPhoto = $('#activityPhotoModal').val();
            var newCategory = $('#activityCategoryModal').val();

            if (newCategory === 'Other') {
                            newCategory = $('#otherCategory').val(); // Get the value from the input field
                        }

            // Implement logic to update the activity via AJAX
            $.ajax({
                type: 'POST',
                url: 'update_activity.php', // Create this PHP page for handling activity modification
                data: {
                    activityId: activityId,
                    newTitle: newTitle,
                    newDescription: newDescription,
                    newLink: newLink,
                    newPhoto: newPhoto,
                    newCategory: newCategory
                    // Include other fields as needed for activity modification
                },
                success: function (response) {
                    // Update the table or perform any necessary actions
                    console.log('Activity updated successfully:', response);
                    // Optionally, close the modal
                    $('#modifyActivityModal').modal('hide');
                    location.reload();
                },
                error: function (error) {
                    console.error('Error updating activity:', error);
                }
            });
        });

        // Event listener for delete activity button
        $('.deleteActivityBtn').click(function () {
            var activityId = $(this).data('activity-id');

            // Ask for confirmation before deleting
            var confirmation = confirm("Are you sure you want to delete this activity?");

            // If the user clicks "OK" in the confirmation dialog
            if (confirmation) {
                // Implement logic to delete the activity via AJAX
                $.ajax({
                    type: 'POST',
                    url: 'delete_activity.php', // Create this PHP page for handling activity deletion
                    data: {
                        activityId: activityId
                    },
                    success: function (response) {
                        // Update the table or perform any necessary actions
                        console.log('Activity deleted successfully:', response);
                        // Optionally, refresh the page or update the table
                        location.reload();
                    },
                    error: function (error) {
                        console.error('Error deleting activity:', error);
                    }
                });
            }
        });

        // Event listener for category dropdown change
        $('#addActivityCategoryModal').change(function () {
            var selectedCategory = $(this).val();
            if (selectedCategory === 'Other') {
                // If "Other" is selected, show the additional input field
                $('#otherAddCategoryInput').show();
            } else {
                // If any other category is selected, hide the additional input field
                $('#otherAddCategoryInput').hide();
            }
        });

        // Event listener for submitting the new activity form
        $('#addActivityFormModal').submit(function (e) {
            e.preventDefault();

            // Get values from the form, including the new category if "Other" is selected
            var newTitle = $('#addActivityTitleModal').val();
            var newDescription = $('#addActivityDescriptionModal').val();
            var newLink = $('#addActivityLinkModal').val();
            var newPhoto = $('#addActivityPhotoModal').val();
            var selectedCategory = $('#addActivityCategoryModal').val();
            var newCategory = (selectedCategory === 'Other') ? $('#AddotherCategory').val() : selectedCategory;

            // Implement logic to add the activity via AJAX
            $.ajax({
                type: 'POST',
                url: 'add_activity.php', // Adjust the URL as needed
                data: {
                    newTitle: newTitle,
                    newDescription: newDescription,
                    newLink: newLink,
                    newPhoto: newPhoto,
                    newCategory: newCategory
                },
                success: function (response) {
                    // Handle the success response as needed
                    console.log(response);
                    location.reload();
                },
                error: function (error) {
                    // Handle the error as needed
                    console.error(error);
                }
            });
        });
    });
</script>


<!-- Modify Activity Modal -->
<div class="modal fade" id="modifyActivityModal" tabindex="-1" role="dialog" aria-labelledby="modifyActivityModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modifyActivityModalLabel">Modify Activity</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form for modifying an activity -->
                <form id="modifyActivityFormModal">
                    <input type="hidden" id="activityIdModal" name="activity_id">
                    <div class="mb-3">
                        <label for="activityTitleModal" class="form-label">Activity Title</label>
                        <input type="text" class="form-control" id="activityTitleModal" name="newTitle" required>
                    </div>
                    <div class="mb-3">
                        <label for="activityDescriptionModal" class="form-label">Description of The Activity</label>
                        <textarea class="form-control" id="activityDescriptionModal" name="newDescription" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="activityLinkModal" class="form-label">Link of The Activity</label>
                        <input type="text" class="form-control" id="activityLinkModal" name="newLink" required>
                    </div>
                    <div class="mb-3">
                        <label for="activityPhotoModal" class="form-label">Photo of The Activity</label>
                        <input type="text" class="form-control" id="activityPhotoModal" name="newPhoto" required>
                    </div>
                    <div class="mb-3">
                        <label for="activityCategoryModal" class="form-label">Category</label>
                        <select class="form-select" id="activityCategoryModal" name="newCategory" required>
                            <!-- Fetch categories dynamically from the database -->
                            <?php
                            require_once('config/database.php');
            $database = new Database();
            $conn = $database->getConnection();
                            $categoriesSql = "SELECT DISTINCT category FROM activities";
                            $stmt = $conn->prepare($categoriesSql);
                            $stmt->execute();
                            $categoriesResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($categoriesResult as $categoryRow) {
                                echo '<option value="' . $categoryRow['category'] . '">' . $categoryRow['category'] . '</option>';
                            }
                            ?>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="mb-3" id="otherCategoryInput" style="display: none;">
                        <label for="otherCategory" class="form-label">New Category</label>
                        <input type="text" class="form-control" id="otherCategory" name="otherCategory">
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Add Activity Button -->
<button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addActivityModal">Add Activity</button>

<!-- Add Activity Modal -->
<div class="modal fade" id="addActivityModal" tabindex="-1" role="dialog" aria-labelledby="addActivityModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addActivityModalLabel">Add New Activity</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form for adding a new activity -->
                <form id="addActivityFormModal">
                    <div class="mb-3">
                        <label for="activityTitleModal" class="form-label">Activity Title</label>
                        <input type="text" class="form-control" id="addActivityTitleModal" name="newTitle" required>
                    </div>
                    <div class="mb-3">
                        <label for="activityDescriptionModal" class="form-label">Description of The Activity</label>
                        <textarea class="form-control" id="addActivityDescriptionModal" name="newDescription" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="addActivityLinkModal" class="form-label">Link of The Activity</label>
                        <input type="text" class="form-control" id="addActivityLinkModal" name="newLink" required>
                    </div>
                    <div class="mb-3">
                        <label for="addActivityPhotoModal" class="form-label">Photo of The Activity</label>
                        <input type="text" class="form-control" id="addActivityPhotoModal" name="newPhoto" required>
                    </div>
                    <div class="mb-3">
                        <label for="addActivityCategoryModal" class="form-label">Category</label>
                        <select class="form-select" id="addActivityCategoryModal" name="newCategory" required>
                            <!-- Fetch categories dynamically from the database -->
                            <?php
                            require_once('config/database.php');
            $database = new Database();
            $conn = $database->getConnection();
                            $categoriesSql = "SELECT DISTINCT category FROM activities";
                            $stmt = $conn->prepare($categoriesSql);
                            $stmt->execute();
                            $categoriesResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($categoriesResult as $categoryRow) {
                                echo '<option value="' . $categoryRow['category'] . '">' . $categoryRow['category'] . '</option>';
                            }
                            ?>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="mb-3" id="otherAddCategoryInput" style="display: none;">
                        <label for="AddotherCategory" class="form-label">New Category</label>
                        <input type="text" class="form-control" id="AddotherCategory" name="AddotherCategory">
                    </div>
                    <button type="submit" class="btn btn-primary">Add Activity</button>
                </form>
            </div>
        </div>
    </div>
</div>



        </div>
    </div>
</body>

</html>
