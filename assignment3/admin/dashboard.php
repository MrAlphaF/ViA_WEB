<?php
session_start();

if ($_SESSION['username'] <> 'admin') {
    header("Location: ../index.php");
    exit();
}

require_once __DIR__ . '/../includes/setup.php'; // Provides $conn (MySQLi connection)
require_once __DIR__ . '/../classes/Service.php'; // Provides the Service class


$serviceManager = new Service($conn); // Pass the MySQLi connection

$message = ''; 
$message_type = ''; 

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $service_id_to_delete = (int)$_GET['id'];
    if ($serviceManager->delete($service_id_to_delete)) {
        $message = "Service deleted successfully.";
        $message_type = 'success';
        
    } else {
        $message = "Failed to delete service. It might not exist or there was a database error.";
        $message_type = 'danger';
    }
}


$services_result = $serviceManager->readAll(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Services</title>
  
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
                <li class="nav-item active">
                    <a class="nav-link" href="dashboard.php">Services Dashboard <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="add_service.php">Add New Service</a>
                </li>
                
            </ul>
            <ul class="navbar-nav">
                 <li class="nav-item"><a class="nav-link" href="../index.php">View Site</a></li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Manage Services</h2>
            <a href="add_service.php" class="btn btn-success">Add New Service</a>
        </div>

        <?php if ($message): ?>
            <div class="alert alert-<?php echo htmlspecialchars($message_type); ?> alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($message); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        <?php endif; ?>
        


        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Description (excerpt)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($services_result && $services_result->num_rows > 0): ?>
                    <?php while ($row = $services_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td>
                                <?php if (!empty($row['image']) && file_exists(__DIR__ . '/../' . $row['image'])): ?>
                                    <img src="../<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>" style="width: 100px; height: auto; object-fit: cover;">
                                <?php else: ?>
                                    N/A
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($row['title']); ?></td>
                            <td><?php echo htmlspecialchars(substr($row['description'], 0, 100)) . (strlen($row['description']) > 100 ? '...' : ''); ?></td>
                            <td>
                                <a href="edit_service.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                                <a href="dashboard.php?action=delete&id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this service? This action cannot be undone.');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    <?php $services_result->free();  ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No services found. <a href="add_service.php">Add one now!</a></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <footer class="text-center mt-5 py-3 bg-light">
        <p>© <?php echo date("Y"); ?> PC Fix & Build - Admin Panel</p>
    </footer>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>