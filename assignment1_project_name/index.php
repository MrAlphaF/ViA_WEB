<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Project's custom CSS file overriding Bootstrap -->
    <link rel="stylesheet" href="css/styles.css">
    
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>Home</title>
</head>
<body>
        
    <?php
        include_once "includes/setup.php";
        include_once "includes/db.php";
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
                    <a href="#"><img id="loginIcon" src="images/login_icon.png"> Log In</a>
                    <button id="darkmodebutton" onclick="toggleDarkMode()"><img id="darkmodeicon" src="images/dark-mode.png"></button>
                </nav>
            </div>
        </div>

        <!-- Hero Section -->
        <div class="heroSection text-center py-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <h1 class="display-4">Welcome to PC Fix & Build</h1>
                    <p class="lead">Your trusted partner in PC and laptop repair and custom builds.</p>
                    <a href="services.php" class="btn btn-primary mt-3">Discover Our Services</a>
                    <br><br>
                    <img src="images/repair.jpg" id="heroImage" class="img-fluid mt-3">
                </div>
            </div>
        </div>

        <!-- Featured Section -->
        <div class="featuredSection text-center py-5">
            <h2>Why Choose Us?</h2>
            <p>We offer reliable, fast, and affordable PC and laptop repair solutions with custom build options.</p>
        </div>

        <!-- Three Column Section -->
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