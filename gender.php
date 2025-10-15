<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['kidSelect'])) {
        // Assuming the selected value is in the format 'gender|kidId'
        $selectedValue = $_POST['kidSelect'];
        
        // Print out the received value for debugging
        echo "Received value: $selectedValue";

        // Check if the value contains the expected format
        // Validate and sanitize the input
// Validate and sanitize the input
if (preg_match('/^(male|female)\|(.+)\|(\d+)$/', $selectedValue, $matches)) {
    $selectedGender = $matches[1];
    $selectedKidName = urldecode($matches[2]);
    $selectedKidId = $matches[3]; // Get the kid ID

    // Redirect based on gender with URL parameters
    if ($selectedGender === 'male' || $selectedGender === 'female') {
        $redirectURL = "acceuil_{$selectedGender}.php?gender={$selectedGender}&kidName={$selectedKidName}&kidId={$selectedKidId}";
        header("Location: $redirectURL");
        exit();
    } else {
        // Handle other cases or show an error message
        echo "Invalid selection!";
    }
} else {
    // Show an error message for an invalid format
    echo "Invalid selection format!";
}

function sanitizeKidName($kidName) {
    // Remove non-alphanumeric characters
    return preg_replace("/[^a-zA-Z0-9]/", "", $kidName);
}

}}
?>