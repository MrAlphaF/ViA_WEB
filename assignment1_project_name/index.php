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
    <title>Home</title>
</head>
<body>

    <?php
        session_start();
        include_once "includes/setup.php";
        include_once "includes/db.php";

        $welcomeMessage = "";
        $loginError = "";

        // --- Login Form Processing (Simulated) ---
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            // --- Replace this with your actual authentication logic ---
            if ($username === 'exampleuser' && $password === 'password123') {
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;

                $lastVisitTime = time();
                $expiryTime = time() + (86400 * 30); // 30 days
                setcookie('last_visit', $lastVisitTime, $expiryTime, '/');

                // Redirect to the same page to see the welcome message
                header("Location: index.php");
                exit();
            } else {
                $loginError = "Invalid username or password.";
            }
        }

        // --- Welcome Message Display ---
        if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
            $welcomeMessage .= "Welcome, " . htmlspecialchars($username) . "! ";

            if (isset($_COOKIE['last_visit'])) {
                $lastVisitTimestamp = $_COOKIE['last_visit'];
                $lastVisitFormatted = date("Y-m-d H:i:s", $lastVisitTimestamp);
                $welcomeMessage .= "Last visit: " . htmlspecialchars($lastVisitFormatted);
            } else {
                $welcomeMessage .= "This is your first visit since login!";
            }
        } else {
            $welcomeMessage = "Welcome to our website! Please log in.";
        }
    ?>

    <div class="grid-container">
        <div class="navbar navbar-expand-md">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapseNav" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div id="collapseNav" class="collapse navbar-collapse" onscroll="changeNavbarClasslist(this)">
                <nav id="navbarCollapsible" class="navbar navbar-expand-lg navbar-light">
                    <a href="index.php">Home</a>
                    <a href="about.php">About Us</a>
                    <a href="services.php">Services</a>
                    <a href="contact.php">Contact Us</a>
                    <a href="register.php">Sign Up</a>
                    <a href="login.php"><img id="loginIcon" src="images/login_icon.png"> Log In</a>
                    <button id="darkmodebutton" onclick="toggleDarkMode()"><img id="darkmodeicon" src="images/dark-mode.png"></button>
                </nav>
            </div>
        </div>

        <div class="heroSection text-center py-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <h1 class="display-4"><?php echo $welcomeMessage; ?></h1>
                    <p class="lead">Your trusted partner in PC and laptop repair and custom builds.</p>
                    <a href="services.php" class="btn btn-primary mt-3">Discover Our Services</a>
                    <br><br>
                    <img src="images/repair.jpg" id="heroImage" class="img-fluid mt-3">
                </div>
            </div>
        </div>

        <div class="featuredSection text-center py-5">
            <h2>Why Choose Us?</h2>
            <p>We offer reliable, fast, and affordable PC and laptop repair solutions with custom build options.</p>
        </div>

        <div class="threeColumnSection container text-center">
            <div class="row">
                <div class="col-md-4">
                    <h3>Repair Services</h3>
                    <p>Hardware and software troubleshooting for all PC and laptop brands.</p>
                </div>
                <div class="col-md-4">
                    <h3>Custom Builds</h3>
                    <p>High-performance PCs tailored to your needs and budget.</p>
                </div>
                <div class="col-md-4">
                    <h3>Upgrades</h3>
                    <p>Boost your system's performance with RAM, SSD, and GPU upgrades.</p>
                </div>
            </div>
        </div>
        <?php if (!isset($_SESSION['loggedin'])): ?>
            <div class="container mt-4">
                <h2>Login</h2>
                <?php if ($loginError): ?>
                    <p style="color:red;"><?php echo htmlspecialchars($loginError); ?></p>
                <?php endif; ?>
                <form method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" class="form-control" id="username" name="username">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
            </div>
        <?php endif; ?>
        <div class="footer text-center py-4" onmouseover="footerMouseover(this)" onmouseleave="footerMouseleave(this)">
            <nav>
                <a href="#">Follow us on Social Media</a>
                <a href="#">© <span id="footerYear"></span> PC Fix & Build</a>
            </nav>
        </div>
    </div>
    <script src="js/script.js"></script>
</body>
</html>