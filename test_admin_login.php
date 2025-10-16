<?php
session_start();
require_once('config/simple_database.php');

echo "<h2>Admin Login Test</h2>";

$adminEmail = 'admin@example.com';
$adminPassword = 'admin123';

echo "<p>Testing admin login with:</p>";
echo "<p>Email: " . htmlspecialchars($adminEmail) . "</p>";
echo "<p>Password: " . htmlspecialchars($adminPassword) . "</p>";

// Test the exact same query as login.php
$sql = "SELECT * FROM users WHERE email = '" . addslashes($adminEmail) . "'";
$result = simpleQuery($sql);

echo "<h3>Database Query Result:</h3>";
if (count($result) > 0) {
    $row = $result[0];
    echo "<p style='color: green;'>✅ User found in database</p>";
    
    echo "<h4>User Data:</h4>";
    echo "<table border='1' style='border-collapse: collapse;'>";
    echo "<tr><th>Field</th><th>Value</th><th>Type</th></tr>";
    foreach ($row as $field => $value) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($field) . "</td>";
        echo "<td>" . htmlspecialchars(var_export($value, true)) . "</td>";
        echo "<td>" . gettype($value) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Test password
    if ($adminPassword == $row['password']) {
        echo "<p style='color: green;'>✅ Password matches</p>";
        
        // Test admin check (same logic as login.php)
        $isAdmin = false;
        if (isset($row['isAdmin'])) {
            $isAdmin = ($row['isAdmin'] == 1 || $row['isAdmin'] === true || $row['isAdmin'] === 'true' || $row['isAdmin'] === 't');
            echo "<p>isAdmin field exists: YES</p>";
            echo "<p>isAdmin value: " . var_export($row['isAdmin'], true) . "</p>";
            echo "<p>isAdmin type: " . gettype($row['isAdmin']) . "</p>";
        } elseif (isset($row['is_admin'])) {
            $isAdmin = ($row['is_admin'] == 1 || $row['is_admin'] === true || $row['is_admin'] === 'true' || $row['is_admin'] === 't');
            echo "<p>is_admin field exists: YES</p>";
            echo "<p>is_admin value: " . var_export($row['is_admin'], true) . "</p>";
        } elseif (isset($row['admin'])) {
            $isAdmin = ($row['admin'] == 1 || $row['admin'] === true || $row['admin'] === 'true' || $row['admin'] === 't');
            echo "<p>admin field exists: YES</p>";
            echo "<p>admin value: " . var_export($row['admin'], true) . "</p>";
        } else {
            echo "<p style='color: red;'>❌ No admin field found (isAdmin, is_admin, or admin)</p>";
        }
        
        echo "<p><strong>Will be treated as admin:</strong> " . ($isAdmin ? '✅ YES' : '❌ NO') . "</p>";
        
        if ($isAdmin) {
            echo "<p style='color: green; font-size: 18px;'><strong>🎉 Admin login should work! Should redirect to admin.php</strong></p>";
        } else {
            echo "<p style='color: red; font-size: 18px;'><strong>⚠️ Admin login will NOT work. User will be treated as regular user.</strong></p>";
        }
        
    } else {
        echo "<p style='color: red;'>❌ Password does NOT match</p>";
        echo "<p>Stored password: " . htmlspecialchars($row['password']) . "</p>";
        echo "<p>Expected password: " . htmlspecialchars($adminPassword) . "</p>";
    }
    
} else {
    echo "<p style='color: red;'>❌ User NOT found in database</p>";
    
    // Show all users
    $allUsersSql = "SELECT id, email, isAdmin FROM users";
    $allUsers = simpleQuery($allUsersSql);
    
    echo "<h4>All Users in Database:</h4>";
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

echo "<hr>";
echo "<h3>Quick Fix:</h3>";
echo "<p>If the admin user doesn't exist or isAdmin is not set correctly, click this button:</p>";
echo "<form method='post'>";
echo "<input type='hidden' name='fix_admin' value='1'>";
echo "<button type='submit' style='background: green; color: white; padding: 10px; border: none; border-radius: 5px;'>Fix Admin User</button>";
echo "</form>";

if (isset($_POST['fix_admin'])) {
    echo "<h4>Fixing Admin User...</h4>";
    
    // Check if admin user exists
    $checkSql = "SELECT * FROM users WHERE email = '" . addslashes($adminEmail) . "'";
    $checkResult = simpleQuery($checkSql);
    
    if (count($checkResult) > 0) {
        // Update existing user
        $userId = $checkResult[0]['id'];
        $updateSql = "UPDATE users SET 
                      password = '" . addslashes($adminPassword) . "', 
                      isAdmin = true,
                      is_parent = false
                      WHERE id = " . intval($userId);
        
        try {
            simpleExecute($updateSql);
            echo "<p style='color: green;'>✅ Admin user updated successfully!</p>";
        } catch (Exception $e) {
            echo "<p style='color: red;'>❌ Error updating admin user: " . $e->getMessage() . "</p>";
        }
        
    } else {
        // Create new admin user
        $insertSql = "INSERT INTO users (username, email, password, is_parent, isAdmin) 
                      VALUES ('admin', '" . addslashes($adminEmail) . "', '" . addslashes($adminPassword) . "', false, true)";
        
        try {
            simpleExecute($insertSql);
            echo "<p style='color: green;'>✅ Admin user created successfully!</p>";
        } catch (Exception $e) {
            echo "<p style='color: red;'>❌ Error creating admin user: " . $e->getMessage() . "</p>";
        }
    }
    
    echo "<p><a href='test_admin_login.php'>Refresh to test again</a></p>";
}
?>
