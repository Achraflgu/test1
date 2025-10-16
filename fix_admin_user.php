<?php
require_once('config/simple_database.php');

echo "<h2>Fix Admin User</h2>";

$adminEmail = 'admin@example.com';
$adminPassword = 'admin123';

// Check if admin user exists
$checkSql = "SELECT * FROM users WHERE email = '" . addslashes($adminEmail) . "'";
$result = simpleQuery($checkSql);

if (count($result) > 0) {
    // Update existing user
    $userId = $result[0]['id'];
    echo "<p>Admin user exists with ID: " . $userId . "</p>";
    
    // Update to make sure isAdmin is true
    $updateSql = "UPDATE users SET 
                  password = '" . addslashes($adminPassword) . "', 
                  isAdmin = true,
                  is_parent = false
                  WHERE id = " . intval($userId);
    
    try {
        simpleExecute($updateSql);
        echo "<p style='color: green;'><strong>✅ Admin user updated successfully!</strong></p>";
    } catch (Exception $e) {
        echo "<p style='color: red;'><strong>❌ Error updating admin user: " . $e->getMessage() . "</strong></p>";
    }
    
} else {
    // Create new admin user
    echo "<p>Admin user does not exist. Creating new admin user...</p>";
    
    $insertSql = "INSERT INTO users (username, email, password, is_parent, isAdmin) 
                  VALUES ('admin', '" . addslashes($adminEmail) . "', '" . addslashes($adminPassword) . "', false, true)";
    
    try {
        simpleExecute($insertSql);
        echo "<p style='color: green;'><strong>✅ Admin user created successfully!</strong></p>";
    } catch (Exception $e) {
        echo "<p style='color: red;'><strong>❌ Error creating admin user: " . $e->getMessage() . "</strong></p>";
    }
}

// Verify the admin user
echo "<h3>Verification:</h3>";
$verifySql = "SELECT * FROM users WHERE email = '" . addslashes($adminEmail) . "'";
$verifyResult = simpleQuery($verifySql);

if (count($verifyResult) > 0) {
    $user = $verifyResult[0];
    echo "<p><strong>Email:</strong> " . htmlspecialchars($user['email']) . "</p>";
    echo "<p><strong>Password:</strong> " . htmlspecialchars($user['password']) . "</p>";
    echo "<p><strong>isAdmin:</strong> " . var_export($user['isAdmin'], true) . " (" . gettype($user['isAdmin']) . ")</p>";
    echo "<p><strong>is_parent:</strong> " . var_export($user['is_parent'], true) . "</p>";
    
    // Test admin check logic
    $isAdmin = false;
    if (isset($user['isAdmin'])) {
        $isAdmin = ($user['isAdmin'] == 1 || $user['isAdmin'] === true || $user['isAdmin'] === 'true' || $user['isAdmin'] === 't');
    }
    
    echo "<p><strong>Will be treated as admin:</strong> " . ($isAdmin ? '✅ YES' : '❌ NO') . "</p>";
    
    if ($isAdmin) {
        echo "<p style='color: green;'><strong>🎉 Admin login should work correctly!</strong></p>";
    } else {
        echo "<p style='color: red;'><strong>⚠️ Admin login may not work. Check the isAdmin value.</strong></p>";
    }
} else {
    echo "<p style='color: red;'><strong>❌ Admin user not found after creation/update!</strong></p>";
}
?>
