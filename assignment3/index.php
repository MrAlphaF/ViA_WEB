<<<<<<< HEAD:assignment1_project_name/index.php
=======
<?php
session_start();

include_once "includes/setup.php";
include_once "includes/db.php";

$welcome_message = "";
$last_visit_message = "";
$current_time = date("F j, Y, g:i a");

// A. Handle Logged-in Users
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    $username = htmlspecialchars($_SESSION['username']);
    $welcome_message = "Welcome, " . $username . "!";

    // Update 'last_username' cookie to the current logged-in user's name
    // This makes sure if they log out, we still have their name for "Welcome back"
    // This line was already present in login.php, but it's good to ensure it's here too
    // in case they visit index.php directly after login via other means (not redirect)
    setcookie('last_username', $username, time() + (86400 * 30), "/"); // Expires in 30 days

    // Set/Update last visit time for logged-in user
    if (isset($_COOKIE['last_visit'])) {
        $last_visit_message = "Your last visit was on " . htmlspecialchars($_COOKIE['last_visit']) . ".";
    }
    // Always update last_visit cookie to current time for active users
    setcookie('last_visit', $current_time, time() + (86400 * 30), "/"); // Expires in 30 days

} else { // B. Handle Non-Logged-in Users (Returning vs. First-time)
    // Check for 'last_username' cookie for returning visitors
    if (isset($_COOKIE['last_username'])) {
        $last_username = htmlspecialchars($_COOKIE['last_username']);
        $welcome_message = "Welcome back, " . $last_username . "!";

        // Check for 'last_visit' cookie for returning visitors
        if (isset($_COOKIE['last_visit'])) {
            $last_visit_message = "Your last visit was on " . htmlspecialchars($_COOKIE['last_visit']) . ".";
        }
        // Always update last_visit cookie for every visit
        setcookie('last_visit', $current_time, time() + (86400 * 30), "/"); // Expires in 30 days
    } else {
        // C. First-time Visitor
        $welcome_message = "Welcome to our site!";
        // Set the 'last_visit' cookie for the first time
        setcookie('last_visit', $current_time, time() + (86400 * 30), "/"); // Expires in 30 days
        // No 'last_username' cookie is set yet as they haven't logged in before.
    }
}
?>

>>>>>>> release/1.3:assignment3/index.php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<<<<<<< HEAD:assignment1_project_name/index.php
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">

=======
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Project's custom CSS file overriding Bootstrap -->
    <link rel="stylesheet" href="css/styles.css">
    
>>>>>>> release/1.3:assignment3/index.php
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>Home</title>
</head>
<body>

<<<<<<< HEAD:assignment1_project_name/index.php
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

=======
>>>>>>> release/1.3:assignment3/index.php
    <div class="grid-container">
        <div class="navbar navbar-expand-md">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapseNav" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
<<<<<<< HEAD:assignment1_project_name/index.php
            </button>
=======
              </button>
>>>>>>> release/1.3:assignment3/index.php
            <div id="collapseNav" class="collapse navbar-collapse" onscroll="changeNavbarClasslist(this)">
                <nav id="navbarCollapsible" class="navbar navbar-expand-lg navbar-light">
                    <a href="index.php">Home</a>
                    <a href="about.php">About Us</a>
                    <a href="services.php">Services</a>
                    <a href="contact.php">Contact Us</a>
<<<<<<< HEAD:assignment1_project_name/index.php
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
=======
                    
                    
                    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                        <?php if ($_SESSION['username'] == 'admin') 
                        echo "<a href='admin/dashboard.php'>Admin dashboard</a>";
                        ?>
                        <a href="logout.php"><img id="loginIcon" src="images/login_icon.png"> Logout (<?php echo htmlspecialchars($_SESSION['username']); ?>)</a>
                    <?php else: ?>
                        <a href="login.php"><img id="loginIcon" src="images/login_icon.png"> Log In</a>
                        <a href="register.php">Register</a>
                    <?php endif; ?>

                    <button id="darkmodebutton" onclick="toggleDarkMode()"><img id="darkmodeicon" src="images/dark-mode.png"></button>
                </nav>
            </div>
            <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                <?php echo "<p id=\"lastLogin\">Welcome back, ".$username."! ".$last_visit_message."</p>"; ?>
            <?php endif; ?>
        </div>

        <!-- Hero Section -->
        <div class="heroSection text-center py-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <h1 class="display-4">Welcome to PC Fix & Build</h1>
>>>>>>> release/1.3:assignment3/index.php
                    <p class="lead">Your trusted partner in PC and laptop repair and custom builds.</p>
                    <a href="services.php" class="btn btn-primary mt-3">Discover Our Services</a>
                    <br><br>
                    <img src="images/repair.jpg" id="heroImage" class="img-fluid mt-3">
                </div>
            </div>
        </div>

<<<<<<< HEAD:assignment1_project_name/index.php
=======
        <!-- Featured Section -->
>>>>>>> release/1.3:assignment3/index.php
        <div class="featuredSection text-center py-5">
            <h2>Why Choose Us?</h2>
            <p>We offer reliable, fast, and affordable PC and laptop repair solutions with custom build options.</p>
        </div>

<<<<<<< HEAD:assignment1_project_name/index.php
=======
        <!-- Three Column Section -->
>>>>>>> release/1.3:assignment3/index.php
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
<<<<<<< HEAD:assignment1_project_name/index.php
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
=======
>>>>>>> release/1.3:assignment3/index.php
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