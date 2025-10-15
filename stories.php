<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Control Panel - Stories</title>
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
    <!-- Stories Section -->
    <div id="stories" class="section">
        <!-- Story management content goes here -->
        <div class="container mt-5">

            <!-- Story Table -->
            <div class="story-management-container" style="max-height: 500px; overflow-y: auto;">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark" style="position: sticky; top: 0; background-color: white; z-index: 1;">
                        <tr>
                            <th>ID</th>
                            <th>Story Title</th>
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
                        $storiesSql = "SELECT * FROM stories";
                        $stmt = $conn->prepare($storiesSql);
                        $stmt->execute();
                        $storiesResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($storiesResult as $storyRow) {
                            echo '<tr>';
                            echo '<td>' . $storyRow['id'] . '</td>';
                            echo '<td>' . $storyRow['story_title'] . '</td>';
                            echo '<td>' . $storyRow['description'] . '</td>';
                            echo '<td>' . $storyRow['category'] . '</td>';
                            echo '<td>
                            <div class="btn-group" role="group">
                                    <button class="btn btn-info modifyStoryBtn" data-story-id="' . $storyRow['id'] . '"><i class="fas fa-edit"></i> Modify</button>
                                    <button class="btn btn-danger deleteStoryBtn" data-story-id="' . $storyRow['id'] . '"><i class="fas fa-trash-alt"></i> Delete</button>
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
                $(document).ready(function() {
                    // Event listener for allow story button
                    $('.allowStoryBtn').click(function() {
                        var storyId = $(this).data('story-id');
                        // Implement logic to allow the story via AJAX
                        console.log('Allow story with ID:', storyId);
                    });

                    // Event listener for hide story button
                    $('.hideStoryBtn').click(function() {
                        var storyId = $(this).data('story-id');
                        // Implement logic to hide the story via AJAX
                        console.log('Hide story with ID:', storyId);
                    });

                    // Event listener for modify story button
                    $('.modifyStoryBtn').click(function() {
                        var storyId = $(this).data('story-id');

                        // Fetch story details via AJAX and populate the modal form
                        $.ajax({
                            type: 'GET',
                            url: 'get_story_d.php', // Create this PHP page to fetch story details
                            data: {
                                storyId: storyId
                            },
                            success: function(response) {
                                // Display the modal with the form and populated data
                                $('#modifyStoryModal').modal('show');
                                $('#storyIdModal').val(storyId);
                                $('#storyTitleModal').val(response.story_title);
                                $('#storyDescriptionModal').val(response.description); // Add this line
                                $('#storyLinkModal').val(response.link_of_stories); // Add this line
                                $('#storyPhotoModal').val(response.photo); // Add this line
                                $('#storyCategoryModal').val(response.category); // Add this line
                                // Populate other form fields as needed
                            },
                            error: function(error) {
                                console.error('Error fetching story details:', error);
                            }
                        });
                    });
                    $('#storyCategoryModal').change(function() {
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
                    $('#modifyStoryFormModal').submit(function(e) {
                        e.preventDefault();
                        var storyId = $('#storyIdModal').val();
                        var newTitle = $('#storyTitleModal').val();
                        var newDescription = $('#storyDescriptionModal').val();
                        var newLink = $('#storyLinkModal').val();
                        var newPhoto = $('#storyPhotoModal').val();
                        var newCategory = $('#storyCategoryModal').val();

                        if (newCategory === 'Other') {
                            newCategory = $('#otherCategory').val(); // Get the value from the input field
                        }

                        // Implement logic to update the story via AJAX
                        $.ajax({
                            type: 'POST',
                            url: 'update_story.php', // Create this PHP page for handling story modification
                            data: {
                                storyId: storyId,
                                newTitle: newTitle,
                                newDescription: newDescription,
                                newLink: newLink,
                                newPhoto: newPhoto,
                                newCategory: newCategory
                                // Include other fields as needed for story modification
                            },
                            success: function(response) {
                                // Update the table or perform any necessary actions
                                console.log('Story updated successfully:', response);
                                // Optionally, close the modal
                                $('#modifyStoryModal').modal('hide');
                                location.reload();
                            },
                            error: function(error) {
                                console.error('Error updating story:', error);
                            }
                        });
                    });

                    // Event listener for delete story button
                    $('.deleteStoryBtn').click(function() {
                        var storyId = $(this).data('story-id');

                        // Ask for confirmation before deleting
                        var confirmation = confirm("Are you sure you want to delete this story?");

                        // If the user clicks "OK" in the confirmation dialog
                        if (confirmation) {
                            // Implement logic to delete the story via AJAX
                            $.ajax({
                                type: 'POST',
                                url: 'delete_story.php', // Create this PHP page for handling story deletion
                                data: {
                                    storyId: storyId
                                },
                                success: function(response) {
                                    // Update the table or perform any necessary actions
                                    console.log('Story deleted successfully:', response);
                                    // Optionally, refresh the page or update the table
                                    location.reload();
                                },
                                error: function(error) {
                                    console.error('Error deleting story:', error);
                                }
                            });
                        }
                    });
                    // Event listener for category dropdown change
                    $('#addStoryCategoryModal').change(function() {
                        var selectedCategory = $(this).val();
                        if (selectedCategory === 'Other') {
                            // If "Other" is selected, show the additional input field
                            $('#otherAddCategoryInput').show();
                        } else {
                            // If any other category is selected, hide the additional input field
                            $('#otherAddCategoryInput').hide();
                        }
                    });

                    // Event listener for submitting the new story form
                    $('#addStoryFormModal').submit(function(e) {
                        e.preventDefault();

                        // Get values from the form, including the new category if "Other" is selected
                        var newTitle = $('#addStoryTitleModal').val();
                        var newDescription = $('#addStoryDescriptionModal').val();
                        var newLink = $('#addStoryLinkModal').val();
                        var newPhoto = $('#addStoryPhotoModal').val();
                        var selectedCategory = $('#addStoryCategoryModal').val();
                        var newCategory = (selectedCategory === 'Other') ? $('#AddotherCategory').val() : selectedCategory;

                        // Implement logic to add the story via AJAX
                        $.ajax({
                            type: 'POST',
                            url: 'add_story.php', // Adjust the URL as needed
                            data: {
                                newTitle: newTitle,
                                newDescription: newDescription,
                                newLink: newLink,
                                newPhoto: newPhoto,
                                newCategory: newCategory
                            },
                            success: function(response) {
                                // Handle the success response as needed
                                console.log(response);
                                location.reload();
                            },
                            error: function(error) {
                                // Handle the error as needed
                                console.error(error);
                            }
                        });
                    });
                });
            </script>


            <!-- Add this inside the body of your HTML -->
            <!-- Modify Story Modal -->
            <div class="modal fade" id="modifyStoryModal" tabindex="-1" role="dialog" aria-labelledby="modifyStoryModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modifyStoryModalLabel">Modify Story</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Form for modifying a story -->
                            <form id="modifyStoryFormModal">
                                <input type="hidden" id="storyIdModal" name="story_id">
                                <div class="mb-3">
                                    <label for="storyTitleModal" class="form-label">Story Title</label>
                                    <input type="text" class="form-control" id="storyTitleModal" name="newTitle" required>
                                </div>
                                <div class="mb-3">
                                    <label for="storyDescriptionModal" class="form-label">Description of The Story</label>
                                    <textarea class="form-control" id="storyDescriptionModal" name="newDescription" rows="3" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="storyLinkModal" class="form-label">Link of The Story</label>
                                    <input type="text" class="form-control" id="storyLinkModal" name="newLink" required>
                                </div>
                                <div class="mb-3">
                                    <label for="storyPhotoModal" class="form-label">Photo of The Story</label>
                                    <input type="text" class="form-control" id="storyPhotoModal" name="newPhoto" required>
                                </div>
                                <div class="mb-3">
                                    <label for="storyCategoryModal" class="form-label">Category</label>
                                    <select class="form-select" id="storyCategoryModal" name="newCategory" required>
                                        <!-- Fetch categories dynamically from the database -->
                                        <?php
                                        require_once('config/database.php');
                                        $database = new Database();
                                        $conn = $database->getConnection();
                                        $categoriesSql = "SELECT DISTINCT category FROM stories";
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


            <!-- Add Story Button -->
            <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addStoryModal">Add Story</button>



            <!-- Add Story Modal -->
            <!-- Add Story Modal -->
            <div class="modal fade" id="addStoryModal" tabindex="-1" role="dialog" aria-labelledby="addStoryModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addStoryModalLabel">Add New Story</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Form for adding a new story -->
                            <form id="addStoryFormModal">
                                <div class="mb-3">
                                    <label for="StoryTitleModal" class="form-label">Story Title</label>
                                    <input type="text" class="form-control" id="addStoryTitleModal" name="newTitle" required>
                                </div>
                                <div class="mb-3">
                                    <label for="StoryDescriptionModal" class="form-label">Description of The Story</label>
                                    <textarea class="form-control" id="addStoryDescriptionModal" name="newDescription" rows="3" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="addStoryLinkModal" class="form-label">Link of The Story</label>
                                    <input type="text" class="form-control" id="addStoryLinkModal" name="newLink" required>
                                </div>
                                <div class="mb-3">
                                    <label for="addStoryPhotoModal" class="form-label">Photo of The Story</label>
                                    <input type="text" class="form-control" id="addStoryPhotoModal" name="newPhoto" required>
                                </div>
                                <div class="mb-3">
                                    <label for="addStoryCategoryModal" class="form-label">Category</label>
                                    <select class="form-select" id="addStoryCategoryModal" name="newCategory" required>
                                        <!-- Fetch categories dynamically from the database -->
                                        <?php
                                        require_once('config/database.php');
                                        $database = new Database();
                                        $conn = $database->getConnection();
                                        $categoriesSql = "SELECT DISTINCT category FROM stories";
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
                                <button type="submit" class="btn btn-primary">Add Story</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>
</body>

</html>