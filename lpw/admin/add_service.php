<?php
session_start();

if ($_SESSION['username'] <> 'admin') {
    header("Location: ../index.php");
    exit();
}


require_once __DIR__ . '/../includes/setup.php'; 
require_once __DIR__ . '/../classes/Service.php'; 


$serviceManager = new Service($conn);

$message = ''; 
$message_type = ''; 
$form_title = '';
$form_description = '';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $form_title = trim($_POST['title'] ?? '');
    $form_description = trim($_POST['description'] ?? '');
    $image_filename_to_save = ''; 


    if (empty($form_title)) {
        $message = "Service title is required.";
        $message_type = 'danger';
    } else {
       
        // Check if an image file was uploaded
        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $target_dir = __DIR__ . "/../images/"; // Directory to save images (relative to project root)
          
        
            if (!is_dir($target_dir)) {
                if (!mkdir($target_dir, 0755, true) && !is_dir($target_dir)) { // Try to create it if it doesn't exist
                     $message = "Failed to create image upload directory. Please create 'images' folder in project root.";
                     $message_type = 'danger';
                }
            }

            if (empty($message)) { // Proceed if directory is okay
                $original_filename = basename($_FILES["image"]["name"]);
                $image_file_type = strtolower(pathinfo($original_filename, PATHINFO_EXTENSION));
                
                // Generate a unique filename to avoid conflicts
                $unique_filename = "service_img_" . time() . "_" . bin2hex(random_bytes(4)) . "." . $image_file_type;
                $target_file_path = $target_dir . $unique_filename; 

                // Allow certain file formats
                $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
                if (!in_array($image_file_type, $allowed_types)) {
                    $message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed for images.";
                    $message_type = 'danger';
                }
                // Check file size (e.g., 5MB maximum)
                elseif ($_FILES["image"]["size"] > 5000000) {
                    $message = "Sorry, your image file is too large (max 5MB).";
                    $message_type = 'danger';
                } else {
                    // Try to move the uploaded file to the target directory
                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file_path)) {
                        // File uploaded successfully, set the path to be stored in the database
                        $image_filename_to_save = "images/" . $unique_filename; 
                    } else {
                        $message = "Sorry, there was an error uploading your image file.";
                        $message_type = 'danger';
                    }
                }
            }
        } elseif (isset($_FILES['image']) && $_FILES['image']['error'] != UPLOAD_ERR_NO_FILE) {
            // An error occurred other than no file uploaded
            $message = "There was an error with the image upload (Error code: " . $_FILES['image']['error'] . ").";
            $message_type = 'danger';
        }
        // If no image was uploaded but it's not an error (UPLOAD_ERR_NO_FILE), $image_filename_to_save remains empty.
       

        if (empty($message)) {
            if ($serviceManager->create($form_title, $form_description, $image_filename_to_save)) {
                $message = "Service added successfully!";
                $message_type = 'success';
                // Clear form fields after successful submission
                $form_title = '';
                $form_description = '';
    
            } else {
                $message = "Failed to add service to the database.";
                $message_type = 'danger';
                // If image was uploaded but DB insert failed, you might want to delete the uploaded image
                if (!empty($image_filename_to_save) && file_exists($target_dir . $unique_filename)) {
                    @unlink($target_dir . $unique_filename);
                }
            }
        }
    }
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
                <li class="nav-item active">
                    <a class="nav-link" href="add_service.php">Add New Service <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="statistics.php">Site Statistics</a>
                </li>
            </ul>
             <ul class="navbar-nav">
                 <li class="nav-item"><a class="nav-link" href="../index.php">View Site</a></li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Add New Service</h2>

        <?php if ($message): ?>
            <div class="alert alert-<?php echo htmlspecialchars($message_type); ?> alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($message); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        <?php endif; ?>

        <form action="add_service.php" method="POST" enctype="multipart/form-data">
            <!-- enctype="multipart/form-data" is crucial for file uploads -->
            <div class="form-group">
                <label for="title">Service Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($form_title); ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="5"><?php echo htmlspecialchars($form_description); ?></textarea>
            </div>
            <div class="form-group">
                <label for="image">Service Image (optional)</label>
                <input type="file" class="form-control-file" id="image" name="image">
                <small class="form-text text-muted">Allowed formats: JPG, JPEG, PNG, GIF. Max size: 5MB.</small>
            </div>
            <button type="submit" class="btn btn-primary">Add Service</button>
            <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <footer class="text-center mt-5 py-3 bg-light">
        <p>© <?php echo date("Y"); ?> PC Fix & Build - Admin Panel</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>