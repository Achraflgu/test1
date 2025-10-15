<?php
/**
 * Batch update script to convert all PHP files from MySQL to PostgreSQL
 */

// List of all PHP files that need updating
$files = [
    'add_child.php', 'add_profile.php', 'add_story.php', 'add_game.php', 'add_activity.php', 'add_user.php',
    'delete_user.php', 'delete_story.php', 'delete_game.php', 'delete_activity.php', 'delete_child.php', 'delete_kid.php',
    'modify_user.php', 'modify_child.php', 'update_story.php', 'update_game.php', 'update_activity.php', 'updateprofile.php',
    'get_stories.php', 'get_games.php', 'get_activities.php', 'get_children.php', 'get_story_details.php', 'get_game_d.php',
    'get_activity_d.php', 'get_child_details.php', 'get_categories.php', 'get_categories_games.php', 'get_categories_activities.php',
    'get_kid_genre.php', 'fetch_notifications.php', 'fetch_unread_notifications.php', 'mark_notifications_as_read.php',
    'mark_all_notifications_as_read.php', 'send_notification.php', 'feedback.php', 'feedbackshow.php', 'historic.php',
    'log_history.php', 'verify_password.php', 'accountsetting.php', 'profilesetting.php', 'display_children.php',
    'process_form.php', 'users.php', 'acceuil_male.php', 'acceuil_female.php', 'watch_story.php', 'view_activity.php', 'play_game.php'
];

echo "Starting batch update of " . count($files) . " PHP files...\n";

foreach ($files as $file) {
    if (file_exists($file)) {
        echo "Updating $file...\n";
        
        // Read file content
        $content = file_get_contents($file);
        
        // Replace MySQL connection with PostgreSQL
        $content = str_replace("include('connexion.php');", "require_once('config/database.php');\n\$database = new Database();\n\$conn = \$database->getConnection();", $content);
        $content = str_replace("include(\"connexion.php\");", "require_once('config/database.php');\n\$database = new Database();\n\$conn = \$database->getConnection();", $content);
        
        // Replace mysqli queries with PDO
        $content = preg_replace('/\$(\w+)Result = \$conn->query\(\$(\w+)Sql\);/', '$stmt = $conn->prepare($$2Sql);\n$stmt->execute();\n$$1Result = $stmt->fetchAll(PDO::FETCH_ASSOC);', $content);
        
        // Replace while loops with foreach
        $content = preg_replace('/while \(\$(\w+) = \$(\w+)Result->fetch_assoc\(\)\)/', 'foreach ($$2Result as $$1)', $content);
        
        // Replace mysqli error handling
        $content = str_replace('->error', '->errorInfo()[2]', $content);
        $content = str_replace('->close()', '// PDO connection closes automatically', $content);
        
        // Write updated content back to file
        file_put_contents($file, $content);
        echo "✓ Updated $file\n";
    } else {
        echo "✗ File $file not found\n";
    }
}

echo "\nBatch update completed!\n";
echo "Please review the changes and test the application.\n";
?>
