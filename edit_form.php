<!-- edit_form.php -->

<?php
// Assume you have the user or child details to pre-fill the form
$existingEmail = "existing_email";
$existingPassword = "existing_password";
?>

<h4>Edit <?php echo ($type == 'user') ? 'User' : 'Child'; ?></h4>
<form action="process_form.php?action=edit&type=<?php echo $type; ?>" method="post">
    <label>Email:</label>
    <input type="text" name="email" value="<?php echo $existingEmail; ?>" required>

    <label>Password:</label>
    <input type="password" name="password" value="<?php echo $existingPassword; ?>" required>

    <?php if ($type == 'child'): ?>
        <!-- Add fields for editing child details -->
    <?php endif; ?>

    <button type="submit" class="btn btn-primary">Save Changes</button>
</form>
