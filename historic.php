<?php
// historic.php

// Ensure kidId is set and is an integer
$selectedKidId = isset($_GET['kidId']) ? intval($_GET['kidId']) : 0;

// Include your database connection
require_once('config/simple_database.php');


// Number of records per page
$recordsPerPage = 10;

// Current page number, default to 1 if not set
$pageNumber = isset($_GET['page']) ? intval($_GET['page']) : 1;

// Calculate the offset for the SQL query
$offset = ($pageNumber - 1) * $recordsPerPage;

// Fetch historic data based on the kid ID with pagination
$sql = "SELECT *, EXTRACT(EPOCH FROM (LEAD(date_time) OVER (PARTITION BY kid_id ORDER BY date_time) - date_time)) AS time_spent FROM historic_data WHERE kid_id = " . intval($selectedKidId) . " ORDER BY date_time DESC LIMIT 50";
$result = simpleQuery($sql);

// Check for errors in the query execution
if ($result === false) {
    die("Error in SQL query");
}

// Start HTML output
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Historic Data</title>
    <!-- Include Bootstrap CSS and Font Awesome CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <!-- Include your custom CSS if needed -->

    <style>
        /* Add your custom styles here */
        body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)),
                url('./images/bg_login_1.png') no-repeat center center fixed;
                background-size: cover;
            background-position: center;
    padding: 10px 8%;
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh; /* Set the body height to the full viewport height */
    margin: 0;
    font-family: 'Poppins', sans-serif;
    overflow: hidden;
    }

    .container {
    transition: transform 0.3s ease-in-out;
    animation: slideUp 0.5s ease-out;
}

.container:hover {
    transform: translateY(-10px); /* Move up on hover */
}

@keyframes slideUp {
    from {
        transform: translateY(100%); /* Start from the bottom */
    }
    to {
        transform: translateY(0); /* Move up to the normal position */
    }
}


        .table th, .table td {
            text-align: center;
        }

        .page-link {
            cursor: pointer;
        }
        .table th {
    background-color: #343a40;
    color: #ffffff;
}

.table-striped tbody tr:nth-of-type(odd) {
    background-color: #f8f9fa;
}
/* Additional Custom Styles */

/* Styling for the page header */
h2 {
            text-align: center;
            margin-bottom: 30px;
            font-family: 'Poppins', sans-serif;
    animation: coolAnimation 2s ease-in-out infinite; /* Add animation property */
    transform-origin: center; /* Set the transformation origin to the center */
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3); /* Add a subtle text shadow */
    margin-bottom: 50px;
    
        }
        @keyframes coolAnimation {
    0%, 100% {
        transform: scale3d(1, 1, 1); /* Initial and final state */
    }
    50% {
        transform: scale3d(1.2, 1.2, 1.2); /* Scale up in the middle of the animation */
    }
}

/* Styling for the table */
.table {
    margin-top: 20px;
    border: 2px solid #dee2e6;
}

/* Styling for table header cells */
.table th {
    background-color: #343a40;
    color: #ffffff;
}

/* Styling for table rows */
.table-striped tbody tr:nth-of-type(odd) {
    background-color: #f8f9fa;
}

/* Styling for pagination links */
.pagination {
    margin-top: 20px;
}

.page-link {
    color: #007bff; /* Blue color */
}

.page-item.active .page-link {
    background-color: #007bff; /* Blue color */
    border-color: #007bff;
}

.page-link:hover {
    background-color: #0056b3; /* Darker blue color on hover */
    color: #ffffff;
}

/* Styling for lead paragraph */
.lead {
    font-size: 1.25rem;
    color: #6c757d; /* Gray color */
}

/* Styling for loading spinner (if applicable) */
.spinner-border {
    color: #007bff; /* Blue color */
}

/* Additional styles as needed */

    </style>
</head>
<body>

<div class="container">
    <?php
    // Display historic data in a table
    if (count($result) > 0) {
        ?>
        <h2 class="mb-4">Ur Kid's history : <i class="fas fa-child"></i></h2>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                <tr>
                    <th>Date <i class="fas fa-calendar-day"></i></th>
                    <th>Time <i class="fas fa-clock"></i></th>
                    <th>Time Spent <i class="fas fa-stopwatch"></i></th>
                    <th>Page <i class="fas fa-file-alt"></i></th>
                </tr>
                </thead>
                <tbody>
                <?php
                while ($row = $result[0]) {
                    ?>
                    <tr>
                        <td><?php echo date('Y-m-d', strtotime($row['date_time'])); ?></td>
                        <td><?php echo date('H:i:s', strtotime($row['date_time'])); ?></td>
                        <td><?php echo $row['time_spent']; ?></td>
                        <td><?php echo $row['page_name']; ?></td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        <?php
        // Calculate the total number of pages
        $sqlCount = "SELECT COUNT(*) as count FROM historic_data WHERE kid_id = ?";
        $stmtCount = $conn->prepare($sqlCount);
        $stmtCount->bind_param("i", $selectedKidId);
        $stmtCount->execute();
        $resultCount = $stmtCount->get_result();
        $rowCount = $resultCount->fetch_assoc()['count'];
        $totalPages = ceil($rowCount / $recordsPerPage);

        // Determine the range of pages to display
        $range = 3;

        // Display "Previous" button
        if ($pageNumber > 1) {
            ?>
            <li class="page-item">
                <a class="page-link" href="?kidId=<?php echo $selectedKidId; ?>&page=<?php echo $pageNumber - 1; ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <?php
        }

        // Display ellipsis if needed
        if ($pageNumber > $range + 1) {
            ?>
            <li class="page-item disabled"><span class="page-link">...</span></li>
            <?php
        }

        // Render pagination links
        for ($i = max(1, $pageNumber - $range); $i <= min($pageNumber + $range, $totalPages); $i++) {
            ?>
            <li class="page-item <?php echo ($i == $pageNumber) ? 'active' : ''; ?>">
                <a class="page-link" href="?kidId=<?php echo $selectedKidId; ?>&page=<?php echo $i; ?>">
                    <?php echo $i; ?>
                </a>
            </li>
            <?php
        }

        // Display ellipsis if needed
        if ($pageNumber + $range < $totalPages) {
            ?>
            <li class="page-item disabled"><span class="page-link">...</span></li>
            <?php
        }

        // Display "Next" button
        if ($pageNumber < $totalPages) {
            ?>
            <li class="page-item">
                <a class="page-link" href="?kidId=<?php echo $selectedKidId; ?>&page=<?php echo $pageNumber + 1; ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
            <?php
        }
        ?>
    </ul>
</nav>

        <?php
    } else {
        ?>
        <p class="lead">No historic data available for Kid</p>
        <?php
    }

    // PDO connection closes automatically
    ?>
</div>

<!-- Include Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
