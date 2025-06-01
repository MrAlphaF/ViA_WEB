<<<<<<< HEAD:assignment1_project_name/login.php
<?php
// Start the session
session_start();

// Check if the user is already logged in, if yes then redirect them to a protected page (e.g., dashboard)
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index.php"); // Or your dashboard page
    exit;
}

// Include the database connection file
require_once 'includes/db.php';

// Initialize variables to store form data and errors
$username = $password = "";
$username_err = $password_err = "";

// Process form data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter your username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";

        if ($stmt = $conn->prepare($sql)) {
            // Bind parameters
            $stmt->bind_param("s", $param_username);

            // Set parameters
            $param_username = $username;

            // Execute the statement
            if ($stmt->execute()) {
                // Store result
                $stmt->store_result();

                // Check if username exists, if yes then verify password
                if ($stmt->num_rows == 1) {
                    // Bind result variables
                    $stmt->bind_result($id, $username, $hashed_password);
                    if ($stmt->fetch()) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;

                            // Set a cookie to store the username for the "Welcome back" message (Task 3.3)
                            setcookie("username", $username, time() + (86400 * 30), "/"); // Cookie expires in 30 days

                            // Redirect user to a protected page (e.g., dashboard)
                            header("location: index.php"); // Or your dashboard page
                        } else {
                            // Password is incorrect
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else {
                    // Username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Close connection
    $conn->close();
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
    <title>Log In</title>
    <style>
        .wrapper{ width: 360px; padding: 20px; margin: 0 auto; }
        .error{ color: red; }
    </style>
</head>
<body>
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

        <div class="wrapper">
            <h2>Log In</h2>
            <p>Please fill in your credentials to log in.</p>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                    <span class="error"><?php echo $username_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                    <span class="error"><?php echo $password_err; ?></span>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Log In">
                </div>
                <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
            </form>
        </div>

        <div class="footer text-center py-4" onmouseover="footerMouseover(this)" onmouseleave="footerMouseleave(this)">
            <nav>
                <a href="#">Follow us on Social Media</a>
                <a href="#">© <span id="footerYear"></span> PC Fix & Build</a>
            </nav>
        </div>
    </div>
    <script src="js/script.js"></script>
</body>
=======
<?php
session_start();

// Redirect if already logged in
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header('Location: index.php');
    exit();
}

require_once 'includes/db.php'; // Using require_once for critical dependencies

// Initialize variables to store form data and error messages
$username_or_email = '';
$password = '';
$errors = [];

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username_or_email = htmlspecialchars(trim($_POST['username_or_email'] ?? ''));
    $password = $_POST['password'] ?? '';

    if (empty($username_or_email)) {
        $errors[] = "Username or Email is required.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    if (empty($errors)) {
        try {
            $stmt = $dbh->prepare("SELECT id, username, password FROM users WHERE username = :username OR email = :email");
            $stmt->bindParam(':username', $username_or_email);
            $stmt->bindParam(':email', $username_or_email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Check if user exists and password is correct
            if ($user && password_verify($password, $user['password'])) {

                // Store user data in session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['logged_in'] = true;

                // Set "Welcome back" cookie for the username 
                // Cookie will expire in 30 days
                setcookie('last_username', $user['username'], time() + (86400 * 30), "/");

                $current_time = date("F j, Y, g:i a");
                setcookie('last_visit', $current_time, time() + (86400 * 30), "/");

                header('Location: index.php');
                exit();
            } else {
                $errors[] = "Invalid username/email or password.";
            }
        } catch (PDOException $e) {
            $errors[] = "Database error: " . $e->getMessage();
        }
    }
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
    <title>Login</title>
</head>
<body>
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

                    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                        <a href="logout.php"><img id="loginIcon" src="images/login_icon.png"> Logout (<?php echo htmlspecialchars($_SESSION['username']); ?>)</a>
                    <?php else: ?>
                        <a href="login.php"><img id="loginIcon" src="images/login_icon.png"> Log In</a>
                        <a href="register.php">Register</a>
                    <?php endif; ?>

                    <button id="darkmodebutton" onclick="toggleDarkMode()"><img id="darkmodeicon" src="images/dark-mode.png"></button>
                </nav>
            </div>
        </div>

        <div class="heroSection text-center py-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <h1 class="display-4">User Login</h1>

                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger" role="alert">
                            <ul>
                                <?php foreach ($errors as $error): ?>
                                    <li><?php echo htmlspecialchars($error); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="login.php" method="POST" class="mt-4">
                        <div class="mb-3">
                            <label for="username_or_email" class="form-label">Username or Email:</label>
                            <input type="text" id="username_or_email" name="username_or_email" class="form-control" value="<?php echo htmlspecialchars($username_or_email); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password:</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Login</button>
                    </form>
                    <p class="mt-3">Don't have an account? <a href="register.php">Register here</a>.</p>
                </div>
            </div>
        </div>

        <div class="featuredSection text-center py-5">
        </div>

        <div class="threeColumnSection container text-center">
            <div class="row">
            </div>
        </div>

        <div class="footer text-center py-4" onmouseover="footerMouseover(this)" onmouseleave="footerMouseleave(this)">
            <nav>
                <a href="#">Follow us on Social Media</a>
                <a href="#">© <span id="footerYear"></span> PC Fix & Build</a>
            </nav>
        </div>
    </div>
    <script src="js/script.js"></script>
</body>
>>>>>>> release/1.3:assignment3/login.php
</html>