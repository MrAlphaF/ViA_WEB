<?php
session_start();

// Admin access check
if (!isset($_SESSION['username']) || $_SESSION['username'] <> 'admin') {
    header("Location: ../login.php"); // Redirect to login if not admin
    exit();
}

require_once __DIR__ . '/../includes/setup.php'; // Provides $conn (MySQLi connection)

$page_views_data = [];
$labels = [];
$counts = [];

if (isset($conn) && $conn instanceof mysqli) {
    $sql = "SELECT page_name, view_count FROM page_views ORDER BY view_count DESC";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $labels[] = $row['page_name'];
            $counts[] = (int)$row['view_count'];
        }
        $result->free();
    } else {
        // echo "No page view data found.";
    }
    // $conn->close(); 
} else {
    die("Database connection failed or not available.");
}

$pageTitle = "Page View Statistics";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - <?php echo $pageTitle; ?></title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Using styles.css from the root css folder if admin pages share it -->
    <link rel="stylesheet" href="../css/styles.css"> 
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .chart-container {
            width: 80%;
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="dashboard.php">Admin Panel</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#adminNavbar" aria-controls="adminNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="adminNavbar">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">Services Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="add_service.php">Add New Service</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="statistics.php"><?php echo $pageTitle; ?> <span class="sr-only">(current)</span></a>
                </li>
            </ul>
            <ul class="navbar-nav">
                 <li class="nav-item"><a class="nav-link" href="../index.php">View Site</a></li>
                 <li class="nav-item"><a class="nav-link" href="../logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2><?php echo $pageTitle; ?></h2>
        </div>

        <?php if (!empty($labels) && !empty($counts)): ?>
            <div class="chart-container">
                <canvas id="pageViewsChart"></canvas>
            </div>
        <?php else: ?>
            <div class="alert alert-info" role="alert">
                No page view data available to display. Start browsing the site to collect data.
            </div>
        <?php endif; ?>
    </div>

    <footer class="text-center mt-5 py-3 bg-light">
        <p>© <?php echo date("Y"); ?> PC Fix & Build - Admin Panel</p>
    </footer>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('pageViewsChart');
        if (ctx) { // Check if canvas element exists
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($labels); ?>,
                    datasets: [{
                        label: 'Page Views',
                        data: <?php echo json_encode($counts); ?>,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)', // Blue bars
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true, 
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1 // Or adjust based on expected counts
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Website Page Views'
                        }
                    }
                }
            });
        }
    });
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>