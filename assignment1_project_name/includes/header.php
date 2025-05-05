<?php
    session_start();
    include_once "setup.php";
    include_once "db.php";

    // Handle logout functionality
    if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
        session_unset();
        session_destroy();
        header("Location: index.php");
        exit;
    }

    // Fetch menu items from the database
    $menuItems = [];
    $sql = "SELECT link_name, url FROM menu_links ORDER BY sort_order";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $menuItems[] = $row;
        }
    }

    

    // Determine the link for the account/login section
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        $accountLink = '<a href="?logout=true"><img id="loginIcon" src="images/logout_icon.png"> Log Out</a>';
    } else {
        $accountLink = '<a href="login.php"><img id="loginIcon" src="images/login_icon.png"> Log In</a>';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) . ' - PC Fix & Build' : 'PC Fix & Build'; ?></title>
</head>
<body>
    <div class="grid-container">
        <div class="navbar navbar-expand-md">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapseNav" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div id="collapseNav" class="collapse navbar-collapse" onscroll="changeNavbarClasslist(this)">
                <nav id="navbarCollapsible" class="navbar navbar-expand-lg navbar-light">
                    <a class="navbar-brand" href="index.php">PC Fix & Build</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <?php foreach ($menuItems as $item): ?>
                                <li>
                                    <a class="nav-link" href="<?php echo htmlspecialchars($item['url']); ?>"><?php echo htmlspecialchars($item['link_name']); ?></a>
                                </li>
                            <?php endforeach; ?>
                            <li>
                                <a  href="register.php">Sign Up</a>
                            </li>
                            <li>
                                <?php echo $accountLink; ?>
                            </li>
                            <li>
                                <button id="darkmodebutton" class="nav-link" onclick="toggleDarkMode()"><img id="darkmodeicon" src="images/dark-mode.png"></button>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>