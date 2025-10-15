<?php
/**
 * Script to update all PHP files from MySQL to PostgreSQL
 * This script will be run once to update all files
 */

$files_to_update = [
    'admin.php',
    'gender.php', 
    'stories.php',
    'games.php',
    'activities.php',
    'acceuil.php',
    'add_child.php',
    'add_profile.php',
    'add_story.php',
    'add_game.php',
    'add_activity.php',
    'add_user.php',
    'delete_user.php',
    'delete_story.php',
    'delete_game.php',
    'delete_activity.php',
    'delete_child.php',
    'delete_kid.php',
    'modify_user.php',
    'modify_child.php',
    'update_story.php',
    'update_game.php',
    'update_activity.php',
    'updateprofile.php',
    'get_stories.php',
    'get_games.php',
    'get_activities.php',
    'get_children.php',
    'get_story_details.php',
    'get_game_d.php',
    'get_activity_d.php',
    'get_child_details.php',
    'get_categories.php',
    'get_categories_games.php',
    'get_categories_activities.php',
    'get_kid_genre.php',
    'fetch_notifications.php',
    'fetch_unread_notifications.php',
    'mark_notifications_as_read.php',
    'mark_all_notifications_as_read.php',
    'send_notification.php',
    'feedback.php',
    'feedbackshow.php',
    'historic.php',
    'log_history.php',
    'verify_password.php',
    'accountsetting.php',
    'profilesetting.php',
    'display_children.php',
    'process_form.php',
    'users.php',
    'acceuil_male.php',
    'acceuil_female.php',
    'watch_story.php',
    'view_activity.php',
    'play_game.php'
];

echo "Files to update: " . count($files_to_update) . "\n";
echo "This script lists all files that need to be updated from MySQL to PostgreSQL.\n";
echo "Each file needs:\n";
echo "1. Replace 'include(\"connexion.php\")' with PostgreSQL connection\n";
echo "2. Update mysqli queries to PDO queries\n";
echo "3. Update result handling from mysqli to PDO\n";
echo "4. Update error handling\n";
?>
