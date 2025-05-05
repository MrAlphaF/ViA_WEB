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
    <title>About Us</title>
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
            <div id="collapseNav" class="collapse navbar-collapse">
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
        <div class="missionStatement">
            <h1>Our Mission</h1>
            <p>Providing expert PC and laptop repairs, custom builds, and performance upgrades with outstanding customer service.</p>
        </div>
        <div class="aboutPerson">
            <img src="images/img_avatar.png">
            <h2>Arturs Silins</h2>
            <h3>Role: Founder & Lead Technician</h3>
            <p>Over 10 years of experience in computer repair and custom PC building.</p>
        </div>
        <div class="aboutPerson">
            <img src="images/img_avatar.png">
            <h2>Eriks Ralfs Matulis</h2>
            <h3>Role: Customer Support</h3>
            <p>Ensuring a smooth customer experience and assisting with inquiries.</p>
        </div>
        <div class="aboutPerson">
            <img src="images/img_avatar.png">
            <h2>Alberts Plucis</h2>
            <h3>Role: Hardware Specialist</h3>
            <p>Expert in diagnosing and repairing complex hardware issues.</p>
        </div>
        <div class="companyTimeline">
            <h2>Our History</h2>
            <ul>
                <li>2024: Expanded to a full-service PC repair and build company.</li>
                <li>2019: Launched custom PC build services.</li>
                <li>2015: Founded as a local repair shop.</li>
            </ul>
        </div>
        <div class="footer" onmouseover="footerMouseover(this)" onmouseleave="footerMouseleave(this)">
            
            © <span id="footerYear"></span> PC Fix & Build</div>
    </div>
    <script src="js/script.js"></script>
</body>
</html>