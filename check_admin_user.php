<?php
require_once('config/simple_database.php');

echo "<h2>Admin User Check</h2>";

// Check if admin user exists
$adminEmail = 'admin@example.com';
$sql = "SELECT * FROM users WHERE email = '" . addslashes($adminEmail) . "'";
$result = simpleQuery($sql);

if (count($result) > 0) {
    $user = $result[0];
    echo "<h3>Admin User Found:</h3>";
    echo "<table border='1' style='border-collapse: collapse;'>";
    echo "<tr><th>Field</th><th>Value</th><th>Type</th></tr>";
    
    foreach ($user as $field => $value) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($field) . "</td>";
        echo "<td>" . htmlspecialchars(var_export($value, true)) . "</td>";
        echo "<td>" . gettype($value) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Check admin status
    $isAdmin = false;
    if (isset($user['isAdmin'])) {
        $isAdmin = ($user['isAdmin'] == 1 || $user['isAdmin'] === true || $user['isAdmin'] === 'true' || $user['isAdmin'] === 't');
        echo "<p><strong>isAdmin field exists:</strong> YES</p>";
        echo "<p><strong>isAdmin value:</strong> " . var_export($user['isAdmin'], true) . "</p>";
        echo "<p><strong>isAdmin type:</strong> " . gettype($user['isAdmin']) . "</p>";
        echo "<p><strong>Will be treated as admin:</strong> " . ($isAdmin ? 'YES' : 'NO') . "</p>";
    } else {
        echo "<p><strong>isAdmin field exists:</strong> NO</p>";
        echo "<p><strong>Will be treated as admin:</strong> NO</p>";
    }
    
} else {
    echo "<h3>Admin User NOT Found</h3>";
    echo "<p>No user found with email: " . htmlspecialchars($adminEmail) . "</p>";
    
    // Show all users
    $allUsersSql = "SELECT id, email, isAdmin FROM users";
    $allUsers = simpleQuery($allUsersSql);
    
    echo "<h3>All Users in Database:</h3>";
    echo "<table border='1' style='border-collapse: collapse;'>";
    echo "<tr><th>ID</th><th>Email</th><th>isAdmin</th></tr>";
    
    foreach ($allUsers as $user) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($user['id']) . "</td>";
        echo "<td>" . htmlspecialchars($user['email']) . "</td>";
        echo "<td>" . htmlspecialchars(var_export($user['isAdmin'] ?? 'NULL', true)) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

// Check database schema
echo "<h3>Database Schema Check:</h3>";
$schemaSql = "SELECT column_name, data_type, is_nullable, column_default 
              FROM information_schema.columns 
              WHERE table_name = 'users' 
              ORDER BY ordinal_position";
$schema = simpleQuery($schemaSql);

echo "<table border='1' style='border-collapse: collapse;'>";
echo "<tr><th>Column</th><th>Type</th><th>Nullable</th><th>Default</th></tr>";

foreach ($schema as $column) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($column['column_name']) . "</td>";
    echo "<td>" . htmlspecialchars($column['data_type']) . "</td>";
    echo "<td>" . htmlspecialchars($column['is_nullable']) . "</td>";
    echo "<td>" . htmlspecialchars($column['column_default'] ?? 'NULL') . "</td>";
    echo "</tr>";
}
echo "</table>";
?>