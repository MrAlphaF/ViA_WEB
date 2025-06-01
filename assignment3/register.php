<<<<<<< HEAD:assignment1_project_name/register.php
<?php
// Include the database connection file
require_once 'includes/db.php'; // Assuming db.php is in the includes folder

// Initialize variables to store form data and errors
$username = $password = $confirm_password = $email = "";
$username_err = $password_err = $confirm_password_err = $email_err = "";
$registration_success = false;

// Process form data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ... (rest of your form processing and validation code from the previous register.php) ...
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
    <title>Sign Up</title>
    <style>
        .wrapper{ width: 360px; padding: 20px; margin: 0 auto; }
        .error{ color: red; }
        .success{ color: green; }
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
            <h2>Sign Up</h2>
            <p>Please fill this form to create an account.</p>
            <?php if ($registration_success): ?>
                <p class="success">Registration successful! <a href="login.php">Login here</a></p>
            <?php else: ?>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                        <span class="error"><?php echo $username_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                        <span class="error"><?php echo $email_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                        <span class="error"><?php echo $password_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                        <span class="error"><?php echo $confirm_password_err; ?></span>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <input type="reset" class="btn btn-secondary ml-2" value="Reset">
                    </div>
                    <p>Already have an account? <a href="login.php">Login here</a>.</p>
                </form>
            <?php endif; ?>
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
// Start session at the very beginning of the script
session_start();

// Include your database connection file
require_once 'includes/db.php'; // Using require_once for critical dependencies
// No need to include setup.php here, it's for table creation, not application logic

// Initialize variables to store form data and error messages
$username = '';
$email = '';
$password = '';
$confirm_password = '';
$errors = [];
$success_message = '';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Sanitize and retrieve form data
    $username = htmlspecialchars(trim($_POST['username'] ?? ''));
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? ''; // Passwords aren't sanitized here as we hash them
    $confirm_password = $_POST['confirm_password'] ?? '';

    // 2. Validate form data

    // Validate Username
    if (empty($username)) {
        $errors[] = "Username is required.";
    } elseif (strlen($username) < 3 || strlen($username) > 50) {
        $errors[] = "Username must be between 3 and 50 characters.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        $errors[] = "Username can only contain letters, numbers, and underscores.";
    }

    // Validate Email
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    // Validate Password
    if (empty($password)) {
        $errors[] = "Password is required.";
    } elseif (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long.";
    } elseif ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    // If no validation errors, proceed to database checks
    if (empty($errors)) {
        try {
            // Check if username or email already exists
            $stmt = $dbh->prepare("SELECT COUNT(*) FROM users WHERE username = :username OR email = :email");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $count = $stmt->fetchColumn();

            if ($count > 0) {
                // If count is > 0, either username or email already exists
                $stmt_user = $dbh->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
                $stmt_user->bindParam(':username', $username);
                $stmt_user->execute();
                if ($stmt_user->fetchColumn() > 0) {
                    $errors[] = "Username already exists. Please choose a different one.";
                }

                $stmt_email = $dbh->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
                $stmt_email->bindParam(':email', $email);
                $stmt_email->execute();
                if ($stmt_email->fetchColumn() > 0) {
                    $errors[] = "Email already exists. Please use a different one or log in.";
                }
            } else {
                // Hash the password securely
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Insert new user into the database
                $stmt = $dbh->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password_hash)");
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password_hash', $hashed_password);

                if ($stmt->execute()) {
                    $success_message = "Registration successful! You can now <a href='login.php'>log in</a>.";
                    // Clear form fields on successful registration
                    $username = '';
                    $email = '';
                    $password = '';
                    $confirm_password = '';
                } else {
                    $errors[] = "Registration failed. Please try again.";
                }
            }
        } catch (PDOException $e) {
            $errors[] = "Database error: " . $e->getMessage();
            // In a production environment, log the error, don't show it to the user.
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
    <title>Register</title>
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
                    <h1 class="display-4">User Registration</h1>

                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger" role="alert">
                            <ul>
                                <?php foreach ($errors as $error): ?>
                                    <li><?php echo htmlspecialchars($error); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($success_message)): ?>
                        <div class="alert alert-success" role="alert">
                            <p><?php echo $success_message; ?></p>
                        </div>
                    <?php endif; ?>

                    <form action="register.php" method="POST" class="mt-4">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username:</label>
                            <input type="text" id="username" name="username" class="form-control" value="<?php echo htmlspecialchars($username); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password:</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password:</label>
                            <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Register</button>
                    </form>
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
>>>>>>> release/1.3:assignment3/register.php
</html>