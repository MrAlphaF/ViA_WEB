<<<<<<< HEAD:assignment1_project_name/contact.php
=======
<?php

session_start();

include_once "includes/setup.php";
include_once "includes/db.php";   


$alert_message_text_task6 = ''; 
$alert_message_type_task6 = ''; 
$server_errors_task6 = [];      
$form_name_task6 = '';
$form_email_task6 = '';
$form_message_task6 = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form_name_task6 = trim($_POST['name'] ?? '');
    $form_email_task6 = trim($_POST['email'] ?? '');
    $form_message_task6 = trim($_POST['message'] ?? '');

    if (empty($form_name_task6)) {
        $server_errors_task6[] = "Full Name is required.";
    }
    if (empty($form_email_task6)) {
        $server_errors_task6[] = "E-mail is required.";
    } elseif (!filter_var($form_email_task6, FILTER_VALIDATE_EMAIL)) {
        $server_errors_task6[] = "Invalid E-mail format.";
    }
    if (empty($form_message_task6)) {
        $server_errors_task6[] = "Message cannot be empty.";
    }

    if (!empty($server_errors_task6)) {
        $alert_message_text_task6 = "Please correct the following errors:<br>" . implode("<br>", $server_errors_task6);
        $alert_message_type_task6 = 'danger';
    }
}
?>
>>>>>>> release/1.3:assignment3/contact.php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
<<<<<<< HEAD:assignment1_project_name/contact.php

=======
    
>>>>>>> release/1.3:assignment3/contact.php
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>Contact Us</title>
</head>
<body>
        
    <?php
<<<<<<< HEAD:assignment1_project_name/contact.php
        include_once "includes/setup.php";
        include_once "includes/db.php";
=======
        
        // PHP Database Interaction for Task 6 
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($server_errors_task6)) {
            if (isset($conn) && $conn instanceof mysqli) {
                $query_task6 = "INSERT INTO messages (name, email, message) VALUES (?, ?, ?)";
                $stmt_task6 = $conn->prepare($query_task6);

                if ($stmt_task6) {
                    $stmt_task6->bind_param("sss", $form_name_task6, $form_email_task6, $form_message_task6);
                    if ($stmt_task6->execute()) {
                        $alert_message_text_task6 = "Thank you for your message! We'll get back to you soon.";
                        $alert_message_type_task6 = 'success';
                        $form_name_task6 = ''; // Clear for potential pre-fill 
                        $form_email_task6 = '';
                        $form_message_task6 = '';
                    } else {
                        $alert_message_text_task6 = "Sorry, there was an error sending your message. (DB Execute)";
                        $alert_message_type_task6 = 'danger';
                    }
                    $stmt_task6->close();
                } else {
                    $alert_message_text_task6 = "Sorry, there was an error sending your message. (DB Prepare)";
                    $alert_message_type_task6 = 'danger';
                }
            } else {
                $alert_message_text_task6 = "Database connection error. Message could not be sent.";
                $alert_message_type_task6 = 'danger';
            }
        }
>>>>>>> release/1.3:assignment3/contact.php
    ?>

    <div class="grid-container">
        <div class="navbar navbar-expand-md">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapseNav" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
<<<<<<< HEAD:assignment1_project_name/contact.php
            </button>
            <div id="collapseNav" class="collapse navbar-collapse">
=======
              </button>
            <div id="collapseNav" class="collapse navbar-collapse" onscroll="changeNavbarClasslist(this)">
>>>>>>> release/1.3:assignment3/contact.php
                <nav id="navbarCollapsible" class="navbar navbar-expand-lg navbar-light">
                    <a href="index.php">Home</a>
                    <a href="about.php">About Us</a>
                    <a href="services.php">Services</a>
                    <a href="contact.php">Contact Us</a>
<<<<<<< HEAD:assignment1_project_name/contact.php
                    <a href="register.php">Sign Up</a>
                    <a href="login.php"><img id="loginIcon" src="images/login_icon.png"> Log In</a>
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

>>>>>>> release/1.3:assignment3/contact.php
                    <button id="darkmodebutton" onclick="toggleDarkMode()"><img id="darkmodeicon" src="images/dark-mode.png"></button>
                </nav>
            </div>
        </div>
<<<<<<< HEAD:assignment1_project_name/contact.php
        <div class="contactForm">
            <h2>Contact Us</h2>
            <form id="contactForm"> <div id="errorContainer"></div> <label for="name">Full Name</label>
                <input class="form-control" type="text" id="name" name="name" required>
                <br><br>
                <label for="email">E-mail</label>
                <input class="form-control" type="email" id="email" name="email" required>
                <br><br>
                <label for="message">Message</label>
                <textarea class="form-control" id="message" name="message" required></textarea><br>
=======

        <?php // Bootstrap Alert Display for Task 6.4
        if (!empty($alert_message_text_task6)): ?>
            <div class="container mt-3 mb-3">
                <div class="alert alert-<?php echo htmlspecialchars($alert_message_type_task6); ?> alert-dismissible fade show" role="alert">
                    <?php echo $alert_message_text_task6; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        <?php endif; ?>

        <div class="contactForm">
            <h2>Contact Us</h2>
            <form id="contactFormTask6" action="contact.php" method="POST"> <div id="errorContainerTask6" style="color: red; margin-bottom: 15px; list-style-position: inside;"></div> <label for="name">Full Name</label>
                <input class="form-control" type="text" id="name" name="name" required value="<?php echo htmlspecialchars($form_name_task6);?>">
                <br><br>
                <label for="email">E-mail</label>
                <input class="form-control" type="email" id="email" name="email" required value="<?php echo htmlspecialchars($form_email_task6);?>">
                <br><br>
                <label for="message">Message</label>
                <textarea class="form-control" id="message" name="message" required><?php echo htmlspecialchars($form_message_task6);?></textarea><br>
>>>>>>> release/1.3:assignment3/contact.php
                <button class="btn btn-primary" type="submit">Submit</button>
            </form>
        </div>
        <div class="contactDetails">
            <h3>Our Contact Details</h3>
            <p>Email: support@pcfixbuild.com</p>
            <p>Phone: (123) 456-7890</p>
            <p>Address: 123 Tech Street, City, Country</p>
        </div>
        <div class="footer" onmouseover="footerMouseover(this)" onmouseleave="footerMouseleave(this)">
            © <span id="footerYear"></span> PC Fix & Build
        </div>
    </div>
    <script src="js/script.js"></script>
<<<<<<< HEAD:assignment1_project_name/contact.php
=======
    
    <?php // Client-side JavaScript for Task 6.2 ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const contactForm = document.getElementById('contactFormTask6');
            const errorContainer = document.getElementById('errorContainerTask6');
            
            const footerYearEl = document.getElementById('footerYear');
            if (footerYearEl) {
                footerYearEl.textContent = new Date().getFullYear();
            }

            if (contactForm) {
                contactForm.addEventListener('submit', function (event) {
                    const nameInput = contactForm.querySelector('#name'); // More specific selectors
                    const emailInput = contactForm.querySelector('#email');
                    const messageInput = contactForm.querySelector('#message');
                    let clientErrors = []; 

                    errorContainer.innerHTML = '';
                    nameInput.classList.remove('is-invalid');
                    emailInput.classList.remove('is-invalid');
                    messageInput.classList.remove('is-invalid');

                    if (nameInput.value.trim() === '') {
                        clientErrors.push('Full Name is required.');
                        nameInput.classList.add('is-invalid');
                    }

                    if (emailInput.value.trim() === '') {
                        clientErrors.push('E-mail is required.');
                        emailInput.classList.add('is-invalid');
                    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value.trim())) {
                        clientErrors.push('Please enter a valid E-mail address.');
                        emailInput.classList.add('is-invalid');
                    }

                    if (messageInput.value.trim() === '') {
                        clientErrors.push('Message cannot be empty.');
                        messageInput.classList.add('is-invalid');
                    }

                    if (clientErrors.length > 0) {
                        event.preventDefault(); 
                        let errorHTML = '<strong>Please correct the following:</strong><ul>';
                        clientErrors.forEach(function(error) {
                            errorHTML += '<li>' + error + '</li>';
                        });
                        errorHTML += '</ul>';
                        errorContainer.innerHTML = errorHTML;
                    }
                });
            }
        });
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
>>>>>>> release/1.3:assignment3/contact.php
</body>
</html>