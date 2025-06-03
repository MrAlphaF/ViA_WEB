<?php
session_start();

include_once "../includes/db.php";

if ($_SESSION['username'] <> 'admin') {
    header("Location: ../index.php");
    exit();
}

$result = $dbh->query("SELECT page_name, view_count, last_viewed FROM stats ORDER BY view_count DESC;");

$xValues = [];      // Page name array
$yValues = [];      // Page visit count array
$lastVisit = [];    // Last page visit array

// Put each row's data in corresponding array to use in chart
foreach ($result as $row) {
    array_push($xValues, $row['page_name']);
    array_push($yValues, $row['view_count']);
    array_push($lastVisit, $row['last_viewed']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Add New Service</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Admin Panel</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#adminNavbar" aria-controls="adminNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="adminNavbar">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">Services Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="add_service.php">Add New Service <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="statistics.php">Site Statistics</a>
                </li>
            </ul>
             <ul class="navbar-nav">
                 <li class="nav-item"><a class="nav-link" href="../index.php">View Site</a></li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Page Statistics</h2>
        
        <canvas id="myChart" style="width:100%;max-width:700px"></canvas>

    </div>

    <footer class="text-center mt-5 py-3 bg-light">
        <p>© <?php echo date("Y"); ?> PC Fix & Build - Admin Panel</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    
    <script>
        var xValues = <?php echo json_encode($xValues); ?>;
        var yValues = <?php echo json_encode($yValues); ?>;
        var lastVisit = <?php echo json_encode($lastVisit); ?>;
        var barColors = ["red", "green","blue","orange","brown","fuchsia"];
        console.log("ummm hello???", xValues);
        console.log("umm yValues??", yValues);
        console.log("um last visit dates??", lastVisit);

        new Chart("myChart", {
            type: "bar",
            data: {
              labels: xValues,
              datasets: [{
                backgroundColor: barColors,
                data: yValues
              }]
            },
            options: {
              legend: {display: false},
              title: {
                display: true,
                text: "Number of times each page has been visited"
              }
  }
});

    </script>

</body>
</html>