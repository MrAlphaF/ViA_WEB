<?php
session_start();

if ($_SESSION['username'] <> 'admin') {
    header("Location: ../index.php");
    exit();
}

require_once __DIR__ . '/../includes/setup.php'; // Provides $conn (MySQLi connection)
require_once __DIR__ . '/../classes/Service.php'; // Provides the Service class


$serviceManager = new Service($conn);

$message = ''; // For success/error messages
$message_type = ''; // For alert class
$service_data = null; // To store the fetched service data
$service_id = null;

// Get Service ID from URL and fetch existing data
if (isset($_GET['id'])) {
    $service_id = (int)$_GET['id'];
    $service_data = $serviceManager->readOne($service_id);

    if (!$service_data) {
       
        $message = "Service not found.";
        $message_type = 'danger';
    }
} else {
    // No ID provided, redirect
    header("Location: dashboard.php");
    exit;
}

//Handle Form Submission (POST request)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $service_data) { // Ensure service_data exists before processing POST
    // Get form data
    $form_title = trim($_POST['title'] ?? '');
    $form_description = trim($_POST['description'] ?? '');
    $new_image_filename_to_save = null; // Will hold new image path if uploaded

    // Basic server-side validation
    if (empty($form_title)) {
        $message = "Service title is required.";
        $message_type = 'danger';
    } else {
        // Image Upload Handling (if a new image is submitted)
        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK && !empty($_FILES['image']['name'])) {
            $target_dir = __DIR__ . "/../images/";
            if (!is_dir($target_dir)) {
                if (!mkdir($target_dir, 0755, true) && !is_dir($target_dir)) {
                     $message = "Failed to create image upload directory.";
                     $message_type = 'danger';
                }
            }

            if (empty($message)) {
                $original_filename = basename($_FILES["image"]["name"]);
                $image_file_type = strtolower(pathinfo($original_filename, PATHINFO_EXTENSION));
                $unique_filename = "service_img_" . time() . "_" . bin2hex(random_bytes(4)) . "." . $image_file_type;
                $target_file_path = $target_dir . $unique_filename;

                $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
                if (!in_array($image_file_type, $allowed_types)) {
                    $message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed for new images.";
                    $message_type = 'danger';
                } elseif ($_FILES["image"]["size"] > 5000000) { // 5MB
                    $message = "Sorry, your new image file is too large (max 5MB).";
                    $message_type = 'danger';
                } else {
                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file_path)) {
                        $new_image_filename_to_save = "images/" . $unique_filename; 

                        // Delete old image if it exists and a new one is uploaded
                        if (!empty($service_data['image']) && file_exists(__DIR__ . '/../' . $service_data['image'])) {
                            if ($service_data['image'] != $new_image_filename_to_save) { // Make sure it's not the same file path
                                @unlink(__DIR__ . '/../' . $service_data['image']);
                            }
                        }
                    } else {
                        $message = "Sorry, there was an error uploading your new image file.";
                        $message_type = 'danger';
                    }
                }
            }
        } elseif (isset($_FILES['image']) && $_FILES['image']['error'] != UPLOAD_ERR_NO_FILE && $_FILES['image']['error'] != UPLOAD_ERR_OK) {
            $message = "There was an error with the new image upload (Error code: " . $_FILES['image']['error'] . ").";
            $message_type = 'danger';
        }
        // If no new image is uploaded, $new_image_filename_to_save remains null,
        // and the Service::update() method will know not to change the image path.

        
        if (empty($message)) {
            // If $new_image_filename_to_save is null, the update method should preserve the old image.
            // If it has a value, it means a new image was successfully uploaded.
            if ($serviceManager->update($service_id, $form_title, $form_description, $new_image_filename_to_save)) {
                $message = "Service updated successfully!";
                $message_type = 'success';
                // Refresh service_data to show updated values in the form
                $service_data = $serviceManager->readOne($service_id);
             
            } else {
                $message = "Failed to update service in the database.";
                $message_type = 'danger';
                // If new image was uploaded but DB update failed, delete the newly uploaded image
                if ($new_image_filename_to_save && file_exists($target_dir . $unique_filename)) {
                    @unlink($target_dir . $unique_filename);
                }
            }
        }
    }

    // If there was an error in THIS POST:
    if (!empty($message) && $message_type === 'danger') {
        $service_data['title'] = $form_title; // Show what user just typed if error
        $service_data['description'] = $form_description; // Show what user just typed if error
    }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Edit Service</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
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
                    <a class="nav-link" href="add_service.php">Add New Service</a>
                </li>
            </ul>
             <ul class="navbar-nav">
                 <li class="nav-item"><a class="nav-link" href="../index.php">View Site</a></li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Edit Service</h2>

        <?php if ($message): ?>
            <div class="alert alert-<?php echo htmlspecialchars($message_type); ?> alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($message); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        <?php endif; ?>

        <?php if ($service_data): // Only show form if service data was found ?>
        <form action="edit_service.php?id=<?php echo htmlspecialchars($service_id); ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Service Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($service_data['title']); ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="5"><?php echo htmlspecialchars($service_data['description']); ?></textarea>
            </div>
            <div class="form-group">
                <label>Current Image</label>
                <div>
                    <?php if (!empty($service_data['image']) && file_exists(__DIR__ . '/../' . $service_data['image'])): ?>
                        <img src="../<?php echo htmlspecialchars($service_data['image']); ?>" alt="Current Image" style="max-width: 200px; max-height: 200px; margin-bottom: 10px;">
                    <?php elseif (!empty($service_data['image'])): ?>
                        <p class="text-danger">Current image file not found at: <?php echo htmlspecialchars($service_data['image']); ?></p>
                    <?php else: ?>
                        <p>No image currently uploaded for this service.</p>
                    <?php endif; ?>
                </div>
                <label for="image" class="mt-2">Upload New Image (optional, will replace current)</label>
                <input type="file" class="form-control-file" id="image" name="image">
                <small class="form-text text-muted">Allowed formats: JPG, JPEG, PNG, GIF. Max size: 5MB.</small>
            </div>
            <button type="submit" class="btn btn-primary">Update Service</button>
            <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
        </form>
        <?php elseif (empty($message)): // If no service data and no explicit "not found" message from GET handler ?>
            <div class="alert alert-warning">No service ID provided or service could not be loaded.</div>
        <?php endif; ?>
    </div>

    <footer class="text-center mt-5 py-3 bg-light">
        <p>© <?php echo date("Y"); ?> Your Company - Admin Panel</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>