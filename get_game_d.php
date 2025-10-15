<?php
include('connexion.php');

if (isset($_GET['gameId'])) {
    $gameId = $_GET['gameId'];

    // Prepare and execute the SQL query to fetch game details
    $query = "SELECT * FROM games WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $gameId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the query was successful
    if ($result) {
        // Fetch the game details as an associative array
        $gameDetails = $result->fetch_assoc();

        // Return the game details as JSON
        header('Content-Type: application/json');
        echo json_encode($gameDetails);
    } else {
        // Handle the error (e.g., log or return an error response)
        echo json_encode(['error' => 'Failed to fetch game details']);
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
} else {
    // Handle the case where the game ID is not provided
    echo json_encode(['error' => 'Game ID not provided']);
}
?>
