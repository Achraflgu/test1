<!-- Notifications.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Notifications</title>
    <!-- Include necessary CSS and JS libraries -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <style>
        body{
            background-color: rgba(0, 0, 0, 0);
        }
        table {
    background-color: white;
}

    </style>
</head>

<body>
    <div class="container mt-3">
        <h2>Send Notification to All Users</h2>

        <!-- Notification form -->
        <form id="notificationForm">
            <div class="form-group">
                <label for="notificationMessage">Notification Message:</label>
                <textarea class="form-control" id="notificationMessage" name="notificationMessage" rows="3" required></textarea>
            </div>
            <button type="button" class="btn btn-primary" onclick="sendNotification()">Send Notification</button>
        </form>
    </div>

    <script>
        function sendNotification() {
            // Get the notification message from the form
            var notificationMessage = $('#notificationMessage').val();

            // Send the notification message to the server using AJAX
            jQuery.ajax({
                url: 'send_notification.php', // Replace with the actual server-side endpoint
                method: 'POST',
                data: { message: notificationMessage },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        alert('Notification sent successfully.');
                        // Clear the form
                        $('#notificationMessage').val('');
                    } else {
                        alert('Failed to send notification.');
                    }
                },
                error: function (error) {
                    console.error('Error sending notification:', error);
                }
            });
        }
    </script>
</body>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

</html>
