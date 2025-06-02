<?php
    session_start();
    include_once "setup.php"; // Ensures $conn is available and tables are set up.
    include_once "db.php";   // Establishes $dbh (PDO), though $conn (MySQLi) will be used for tracking.

    
    if (isset($conn) && $conn instanceof mysqli) { // Check if $conn is a valid MySQLi connection
        $current_page = basename($_SERVER['PHP_SELF']);
        
       
        $trackable_pages = [
            'index.php', 
            'about.php', 
            'contact.php', 
            'services.php', 
            'login.php', 
            'register.php'
           
        ];

        // Check if the current page is in the trackable list and not an admin page via path
        if (in_array($current_page, $trackable_pages) && strpos($_SERVER['REQUEST_URI'], '/admin/') === false) {
            $stmt_track = $conn->prepare("INSERT INTO page_views (page_name, view_count) VALUES (?, 1) ON DUPLICATE KEY UPDATE view_count = view_count + 1");
            if ($stmt_track) {
                $stmt_track->bind_param("s", $current_page);
                $stmt_track->execute();
                $stmt_track->close();
            } else {
               
                // error_log("Failed to prepare page view tracking statement: " . $conn->error);
            }
        }
    }
    


    // Handle logout functionality (from your original header.php)
    if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
        session_unset();
        session_destroy();
        header("Location: index.php"); 
        exit;
    }

    // Fetch menu items from the database (from your original header.php)
    $menuItems = [];
    if (isset($conn) && $conn instanceof mysqli) {
        $sql = "SELECT link_name, url FROM menu_links ORDER BY sort_order"; // Assuming menu_links table
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $menuItems[] = $row;
            }
            $result->free();
        }
    }

    // Determine the link for the account/login section (from your original header.php)
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        $usernameForLink = isset($_SESSION["username"]) ? htmlspecialchars($_SESSION["username"]) : '';
        $accountLink = '<a class="nav-link" href="logout.php?logout=true"><img id="loginIcon" src="images/logout_icon.png" alt="Logout Icon" style="height: 20px; filter: invert(100%);"> Log Out (' . $usernameForLink . ')</a>';
    } else {
        $accountLink = '<a class="nav-link" href="login.php"><img id="loginIcon" src="images/login_icon.png" alt="Login Icon" style="height: 20px; filter: invert(100%);"> Log In</a>';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/chatbot.css"> 

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) . ' - PC Fix & Build' : 'PC Fix & Build'; ?></title>
</head>
<body>
    <div class="grid-container">
        <div class="navbar navbar-expand-md">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNav" aria-controls="collapseNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div id="collapseNav" class="collapse navbar-collapse">
                <nav id="navbarCollapsible" class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php foreach ($menuItems as $item): ?>
                        <a class="nav-link" href="<?php echo htmlspecialchars($item['url']); ?>"><?php echo htmlspecialchars($item['link_name']); ?></a>
                    <?php endforeach; ?>
                     <!-- Fallback static links if menu_links is empty or not used -->
                    <?php if (empty($menuItems)): ?>
                        <a class="nav-link" href="index.php">Home</a>
                        <a class="nav-link" href="about.php">About Us</a>
                        <a class="nav-link" href="services.php">Services</a>
                        <a class="nav-link" href="contact.php">Contact Us</a>
                    <?php endif; ?>
                </nav>
                <ul class="navbar-nav ms-auto">
                     <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && isset($_SESSION['username']) && $_SESSION['username'] == 'admin'): ?>
                        <li class="nav-item"><a class="nav-link" href="admin/dashboard.php">Admin</a></li>
                    <?php endif; ?>
                    <li class="nav-item">
                         <?php echo $accountLink; ?>
                    </li>
                    <?php if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="register.php">Sign Up</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <button id="darkmodebutton" class="nav-link btn btn-link" onclick="toggleDarkMode()" aria-label="Toggle Dark Mode">
                            <img id="darkmodeicon" src="images/dark-mode.png" alt="Dark Mode Icon" style="height:20px;">
                        </button>
                    </li>
                </ul>
            </div>
        </div>