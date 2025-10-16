<?php
require_once('config/simple_database.php');

echo "<h2>Database Admin User Check</h2>";

// Check if admin user exists
$adminSql = "SELECT * FROM users WHERE email = 'admin@example.com'";
$adminResult = simpleQuery($adminSql);

if (count($adminResult) > 0) {
    $admin = $adminResult[0];
    echo "<h3>Admin User Found:</h3>";
    echo "<pre>";
    print_r($admin);
    echo "</pre>";
    
    echo "<h3>Available Columns:</h3>";
    echo "<ul>";
    foreach (array_keys($admin) as $column) {
        echo "<li>$column</li>";
    }
    echo "</ul>";
    
    // Check admin status
    $isAdmin = false;
    if (isset($admin['isAdmin'])) {
        $isAdmin = ($admin['isAdmin'] == 1 || $admin['isAdmin'] === true || $admin['isAdmin'] === 'true' || $admin['isAdmin'] === 't');
        echo "<p><strong>isAdmin field:</strong> " . var_export($admin['isAdmin'], true) . " (type: " . gettype($admin['isAdmin']) . ") - Admin: " . ($isAdmin ? 'YES' : 'NO') . "</p>";
    } elseif (isset($admin['is_admin'])) {
        $isAdmin = ($admin['is_admin'] == 1 || $admin['is_admin'] === true || $admin['is_admin'] === 'true' || $admin['is_admin'] === 't');
        echo "<p><strong>is_admin field:</strong> " . var_export($admin['is_admin'], true) . " (type: " . gettype($admin['is_admin']) . ") - Admin: " . ($isAdmin ? 'YES' : 'NO') . "</p>";
    } elseif (isset($admin['admin'])) {
        $isAdmin = ($admin['admin'] == 1 || $admin['admin'] === true || $admin['admin'] === 'true' || $admin['admin'] === 't');
        echo "<p><strong>admin field:</strong> " . var_export($admin['admin'], true) . " (type: " . gettype($admin['admin']) . ") - Admin: " . ($isAdmin ? 'YES' : 'NO') . "</p>";
    } else {
        echo "<p><strong>No admin field found!</strong></p>";
    }
    
} else {
    echo "<h3>Admin User NOT Found!</h3>";
    echo "<p>Creating admin user...</p>";
    
    // Create admin user
    $createAdminSql = "INSERT INTO users (username, email, password, is_parent, isAdmin) VALUES ('admin', 'admin@example.com', 'admin123', false, true)";
    try {
        simpleExecute($createAdminSql);
        echo "<p style='color: green;'>Admin user created successfully!</p>";
    } catch (Exception $e) {
        echo "<p style='color: red;'>Error creating admin user: " . $e->getMessage() . "</p>";
    }
}

echo "<h3>All Users:</h3>";
$allUsersSql = "SELECT id, email, isAdmin, is_admin, admin FROM users";
$allUsers = simpleQuery($allUsersSql);

echo "<table border='1' style='border-collapse: collapse;'>";
echo "<tr><th>ID</th><th>Email</th><th>isAdmin</th><th>is_admin</th><th>admin</th></tr>";
foreach ($allUsers as $user) {
    echo "<tr>";
    echo "<td>" . $user['id'] . "</td>";
    echo "<td>" . $user['email'] . "</td>";
    echo "<td>" . (isset($user['isAdmin']) ? var_export($user['isAdmin'], true) : 'NULL') . "</td>";
    echo "<td>" . (isset($user['is_admin']) ? var_export($user['is_admin'], true) : 'NULL') . "</td>";
    echo "<td>" . (isset($user['admin']) ? var_export($user['admin'], true) : 'NULL') . "</td>";
    echo "</tr>";
}
echo "</table>";

echo "<h3>SQL Commands to Fix Admin User:</h3>";
echo "<pre>";
echo "-- Option 1: Add isAdmin column if it doesn't exist
ALTER TABLE users ADD COLUMN IF NOT EXISTS isAdmin BOOLEAN DEFAULT FALSE;

-- Option 2: Update existing admin user
UPDATE users SET isAdmin = true WHERE email = 'admin@example.com';

-- Option 3: Create admin user if it doesn't exist
INSERT INTO users (username, email, password, is_parent, isAdmin) 
VALUES ('admin', 'admin@example.com', 'admin123', false, true)
ON CONFLICT (email) 
DO UPDATE SET isAdmin = true;
";
echo "</pre>";
?>
