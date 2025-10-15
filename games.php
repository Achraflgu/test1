<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Control Panel - Games</title>
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
    <!-- Games Section -->
    <div id="games" class="section">
        <!-- Game management content goes here -->
        <div class="container mt-5">

            <!-- Game Table -->
            <div class="game-management-container" style="max-height: 500px; overflow-y: auto;">
    <table class="table table-bordered table-striped">
        <thead class="thead-dark" style="position: sticky; top: 0; background-color: white; z-index: 1;">
            <tr>
                <th>ID</th>
                <th>Game Title</th>
                <th>Description</th>
                <th>Category</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include('connexion.php');
            $gamesSql = "SELECT * FROM games";
            $gamesResult = $conn->query($gamesSql);

            while ($gameRow = $gamesResult->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $gameRow['id'] . '</td>';
                echo '<td>' . $gameRow['game_title'] . '</td>';
                echo '<td>' . $gameRow['description'] . '</td>';
                echo '<td>' . $gameRow['category'] . '</td>';
                echo '<td>
                <div class="btn-group" role="group">
                        <button class="btn btn-info modifyGameBtn" data-game-id="' . $gameRow['id'] . '"><i class="fas fa-edit"></i> Modify</button>
                        <button class="btn btn-danger deleteGameBtn" data-game-id="' . $gameRow['id'] . '"><i class="fas fa-trash-alt"></i> Delete</button>
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
                    // Event listener for allow game button
                    $('.allowGameBtn').click(function() {
                        var gameId = $(this).data('game-id');
                        // Implement logic to allow the game via AJAX
                        console.log('Allow game with ID:', gameId);
                    });

                    // Event listener for hide game button
                    $('.hideGameBtn').click(function() {
                        var gameId = $(this).data('game-id');
                        // Implement logic to hide the game via AJAX
                        console.log('Hide game with ID:', gameId);
                    });

                    // Event listener for modify game button
                    $('.modifyGameBtn').click(function() {
                        var gameId = $(this).data('game-id');

                        // Fetch game details via AJAX and populate the modal form
                        $.ajax({
                            type: 'GET',
                            url: 'get_game_d.php', // Create this PHP page to fetch game details
                            data: {
                                gameId: gameId
                            },
                            success: function(response) {
                                // Display the modal with the form and populated data
                                $('#modifyGameModal').modal('show');
                                $('#gameIdModal').val(gameId);
                                $('#gameTitleModal').val(response.game_title);
                                $('#gameDescriptionModal').val(response.description); // Add this line
                                $('#gameCategoryModal').val(response.category); // Add this line
                                $('#gamePhotoModal').val(response.photo); // Add this line
                                $('#gameLinkModal').val(response.link_of_games); // Add this line
                                // Populate other form fields as needed
                            },
                            error: function(error) {
                                console.error('Error fetching game details:', error);
                            }
                        });
                    });
                    $('#gameCategoryModal').change(function() {
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
                    $('#modifyGameFormModal').submit(function(e) {
                        e.preventDefault();
                        var gameId = $('#gameIdModal').val();
                        var newTitle = $('#gameTitleModal').val();
                        var newDescription = $('#gameDescriptionModal').val();
                        var newCategory = $('#gameCategoryModal').val();
                        var newPhoto = $('#gamePhotoModal').val();
                        var newLink = $('#gameLinkModal').val();

                        if (newCategory === 'Other') {
                            newCategory = $('#otherCategory').val(); // Get the value from the input field
                        }

                        // Implement logic to update the game via AJAX
                        $.ajax({
                            type: 'POST',
                            url: 'update_game.php', // Create this PHP page for handling game modification
                            data: {
                                gameId: gameId,
                                newTitle: newTitle,
                                newDescription: newDescription,
                                newCategory: newCategory,
                                newPhoto: newPhoto,
                                newLink: newLink
                                // Include other fields as needed for game modification
                            },
                            success: function(response) {
                                // Update the table or perform any necessary actions
                                console.log('Game updated successfully:', response);
                                // Optionally, close the modal
                                $('#modifyGameModal').modal('hide');
                                location.reload();
                            },
                            error: function(error) {
                                console.error('Error updating game:', error);
                            }
                        });
                    });

                    // Event listener for delete game button
                    $('.deleteGameBtn').click(function() {
                        var gameId = $(this).data('game-id');

                        // Ask for confirmation before deleting
                        var confirmation = confirm("Are you sure you want to delete this game?");

                        // If the user clicks "OK" in the confirmation dialog
                        if (confirmation) {
                            // Implement logic to delete the game via AJAX
                            $.ajax({
                                type: 'POST',
                                url: 'delete_game.php', // Create this PHP page for handling game deletion
                                data: {
                                    gameId: gameId
                                },
                                success

                                : function(response) {
                                    // Update the table or perform any necessary actions
                                    console.log('Game deleted successfully:', response);
                                    // Optionally, refresh the page or update the table
                                    location.reload();
                                },
                                error: function(error) {
                                    console.error('Error deleting game:', error);
                                }
                            });
                        }
                    });
                    // Event listener for category dropdown change
                    $('#addGameCategoryModal').change(function() {
                        var selectedCategory = $(this).val();
                        if (selectedCategory === 'Other') {
                            // If "Other" is selected, show the additional input field
                            $('#otherAddCategoryInput').show();
                        } else {
                            // If any other category is selected, hide the additional input field
                            $('#otherAddCategoryInput').hide();
                        }
                    });

                    // Event listener for submitting the new game form
                    $('#addGameFormModal').submit(function(e) {
                        e.preventDefault();

                        // Get values from the form, including the new category if "Other" is selected
                        var newTitle = $('#addGameTitleModal').val();
                        var newDescription = $('#addGameDescriptionModal').val();
                        var newLink = $('#addGameLinkModal').val();
                        var newPhoto = $('#addGamePhotoModal').val();
                        var selectedCategory = $('#addGameCategoryModal').val();
                        var newCategory = (selectedCategory === 'Other') ? $('#AddotherCategory').val() : selectedCategory;

                        // Implement logic to add the game via AJAX
                        $.ajax({
                            type: 'POST',
                            url: 'add_game.php', // Adjust the URL as needed
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

            <!-- Modify Game Modal -->
            <div class="modal fade" id="modifyGameModal" tabindex="-1" role="dialog" aria-labelledby="modifyGameModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modifyGameModalLabel">Modify Game</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Form for modifying a game -->
                            <form id="modifyGameFormModal">
                                <input type="hidden" id="gameIdModal" name="game_id">
                                <div class="mb-3">
                                    <label for="gameTitleModal" class="form-label">Game Title</label>
                                    <input type="text" class="form-control" id="gameTitleModal" name="newTitle" required>
                                </div>
                                <div class="mb-3">
                                    <label for="gameDescriptionModal" class="form-label">Description of The Game</label>
                                    <textarea class="form-control" id="gameDescriptionModal" name="newDescription" rows="3" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="gameLinkModal" class="form-label">Link of The Game</label>
                                    <input type="text" class="form-control" id="gameLinkModal" name="newLink" required>
                                </div>
                                <div class="mb-3">
                                    <label for="gamePhotoModal" class="form-label">Photo of The Game</label>
                                    <input type="text" class="form-control" id="gamePhotoModal" name="newPhoto" required>
                                </div>
                                <div class="mb-3">
                                    <label for="gameCategoryModal" class="form-label">Category</label>
                                    <select class="form-select" id="gameCategoryModal" name="newCategory" required>
                                        <!-- Fetch categories dynamically from the database -->
                                        <?php
                                        include('connexion.php');
                                        $categoriesSql = "SELECT DISTINCT category FROM games";
                                        $categoriesResult = $conn->query($categoriesSql);

                                        while ($categoryRow = $categoriesResult->fetch_assoc()) {
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

            <!-- Add Game Button -->
            <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addGameModal">Add Game</button>

            <!-- Add Game Modal -->
            <div class="modal fade" id="addGameModal" tabindex="-1" role="dialog" aria-labelledby="addGameModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addGameModalLabel">Add New Game</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Form for adding a new game -->
                            <form id="addGameFormModal">
                                <div class="mb-3">
                                    <label for="gameTitleModal" class="form-label">Game Title</label>
                                    <input type="text" class="form-control" id="addGameTitleModal" name="newTitle" required>
                                </div>
                                <div class="mb-3">
                                    <label for="gameDescriptionModal" class="form-label">Description of The Game</label>
                                    <textarea class="form-control" id="addGameDescriptionModal" name="newDescription" rows="3" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="addGameLinkModal" class="form-label">Link of The Game</label>
                                    <input type="text" class="form-control" id="addGameLinkModal" name="newLink" required>
                                </div>
                                <div class="mb-3">
                                    <label for="addGamePhotoModal" class="form-label">Photo of The Game</label>
                                    <input type="text" class="form-control" id="addGamePhotoModal" name="newPhoto" required>
                                </div>

                                <div class="form-group">
                                    <label for="addGameCategoryModal">Category</label>
                                    <select class="form-select" id="addGameCategoryModal" name="newCategory" required>
                                        <!-- Fetch categories dynamically from the database -->
                                        <?php
                                        include('connexion.php');
                                        $categoriesSql = "SELECT DISTINCT category FROM games";
                                        $categoriesResult = $conn->query($categoriesSql);

                                        while ($categoryRow = $categoriesResult->fetch_assoc()) {
                                            echo '<option value="' . $categoryRow['category'] . '">' . $categoryRow['category'] . '</option>';
                                        }
                                        ?>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>

                                <div class="form-group" id="otherAddCategoryInput" style="display: none;">
                                    <label for="AddotherCategory" class="form-label">New Category</label>
                                    <input type="text" class="form-control" id="AddotherCategory" name="AddotherCategory">
                                </div>

                                <button type="submit" class="btn btn-primary">Add Game</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>

</html>