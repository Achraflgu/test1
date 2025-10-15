<?php
// Test database connection and queries
require_once('config/database.php');

echo "<h2>Database Connection Test</h2>";

try {
    // Test basic connection
    $conn = getDBConnection();
    echo "✅ Database connection successful<br>";
    
    // Test simple query
    $result = fetchAll("SELECT 1 as test");
    echo "✅ Basic query test successful<br>";
    
    // Test users table
    $users = fetchAll("SELECT COUNT(*) as count FROM users");
    echo "✅ Users table accessible - Count: " . $users[0]['count'] . "<br>";
    
    // Test children table
    $children = fetchAll("SELECT COUNT(*) as count FROM children");
    echo "✅ Children table accessible - Count: " . $children[0]['count'] . "<br>";
    
    // Test activities table
    $activities = fetchAll("SELECT COUNT(*) as count FROM activities");
    echo "✅ Activities table accessible - Count: " . $activities[0]['count'] . "<br>";
    
    echo "<br><strong>🎉 All database tests passed!</strong>";
    
} catch (Exception $e) {
    echo "❌ Database test failed: " . $e->getMessage();
    echo "<br><br>Please run the emergency cache clear script in Neon SQL Editor.";
}
?>
