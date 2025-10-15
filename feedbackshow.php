<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Show</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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

<div class="container mt-5">
    <div class="feedback-management-container" style="max-height: 500px; overflow-y: auto;">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark" style="position: sticky; top: 0; background-color: white; z-index: 1;">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Rating</th>
                    <th>Comments</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Replace these with your database connection details
                require_once('config/database.php');
$database = new Database();
$conn = $database->getConnection();

                // Fetch feedback data
                $sql = "SELECT * FROM feedback";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["name"] . "</td>";
                        echo "<td>" . $row["age"] . "</td>";
                        echo "<td>" . $row["email"] . "</td>";
                        echo "<td>" . $row["phone"] . "</td>";
                        echo "<td>" . $row["rating"] . "</td>";
                        echo "<td>" . $row["comments"] . "</td>";
                        echo "<td>
                                <a href='delete_feedback.php?id=" . $row["id"] . "' class='btn btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Delete</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No feedbacks found</td></tr>";
                }

                // Close connection
                $conn// PDO connection closes automatically;
                ?>
            </tbody>
        </table>
    </div>
</div>


<!-- Bootstrap JS and dependencies (add at the end of the body) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
