<?php

require_once __DIR__ . '/classes/Service.php'; // Make sure Service class is available

/
$serviceManager = null;
$services_result = null;
$searchTerm = null;

//Handle Search Term (if any) from URL for server-side filtering
if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
    $searchTerm = trim($_GET['search']);
}

// The actual fetching of services will happen after $conn is established.
?>
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
    <title>Services</title>
    <style>
       
        .dynamic-card-img {
            height: 200px; 
            object-fit: cover;
            width: 100%;
        }
         
        .service-card .card { /* Targeting existing .service-card */
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .service-card .card-body {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
    </style>
</head>
<body>
        
    <?php
        //these will define $conn
        include_once "includes/setup.php";
        include_once "includes/db.php"; 

        
        if (isset($conn)) { // Check if $conn is actually set
            $serviceManager = new Service($conn); // Pass the MySQLi connection
            $services_result = $serviceManager->readAll($searchTerm); // Fetch services
        } else {
            // Handle case where $conn is not set - critical error
            echo "<p class='text-danger text-center'>Error: Database connection not available. Service data cannot be loaded.</p>";
            // $services_result will remain null or false
        }
    ?>

    <div class="grid-container">
        <!-- Navbar -->
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
                    <a href="#"><img id="loginIcon" src="images/login_icon.png" alt="Login Icon"> Log In</a> {/* Added alt text */}
                    <button id="darkmodebutton" onclick="toggleDarkMode()"><img id="darkmodeicon" src="images/dark-mode.png" alt="Dark Mode Icon"></button> {/* Added alt text */}
                    
                    <!-- SERVER-SIDE SEARCH FORM  -->
                    <form class="form-inline my-2 my-lg-0" action="services.php" method="GET" style="margin-left: auto;"> {/* Bootstrap 4 style for right align within nav items */}
                        <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search Services" aria-label="Search" value="<?php echo htmlspecialchars($searchTerm ?? ''); ?>">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                    </form>
                </nav>
            </div>
        </div>

        <!-- New Section for Dropdown Above Services -->
        <div class="filter-section container text-center py-3">
            <h3>Filter Services</h3>
            <!-- Dropdown for Filtering -->
            <select id="serviceFilter" class="form-select" aria-label="Service Filter">
                <option value="">Select a Category</option>
                <option value="repair">PC & Laptop Repairs</option>
                <option value="build">Custom PC Builds</option>
                <option value="upgrade">Hardware & Software Upgrades</option>
            </select>
        </div>

        <!-- Services Section -->
        <div class="servicesSection">
            <h2>Our Services</h2>
            <?php if ($searchTerm && isset($conn)): // Show search term only if DB connection was available ?>
                <p class="lead text-center">Showing results for: <strong>"<?php echo htmlspecialchars($searchTerm); ?>"</strong></p>
            <?php endif; ?>
            <hr>
            <div class="row" id="servicesList">
                <?php if (isset($conn) && $services_result && $services_result->num_rows > 0): ?>
                    <?php while ($service = $services_result->fetch_assoc()): ?>
                        <?php
                            // Basic placeholder logic for data-category 
                            // For your client-side filter to work, services from DB need a way to map to these categories.
                            $data_category_attr = '';
                            if (stripos($service['title'], 'repair') !== false) { $data_category_attr = 'repair';}
                            elseif (stripos($service['title'], 'build') !== false) { $data_category_attr = 'build';}
                            elseif (stripos($service['title'], 'upgrade') !== false) { $data_category_attr = 'upgrade';}
                        ?>
                        <div class="col-12 col-md-4 service-card" data-category="<?php echo $data_category_attr; ?>">
                            <div class="card"> {/* Your existing card structure */}
                                <?php
                                    // Image display logic
                                    $image_to_display = "images/repair.jpg"; // Default image
                                    if (!empty($service['image']) && file_exists(__DIR__ . '/' . $service['image'])) {
                                        $image_to_display = htmlspecialchars($service['image']);
                                    }
                                ?>
                               
                                
                                <div class="card-body">
                                    <h3 class="card-title"><?php echo htmlspecialchars($service['title']); ?></h3>
                                    <p class="card-text">
                                        <?php
                                            $description_text = htmlspecialchars($service['description'] ?? ''); // Added null coalescing for safety
                                            echo strlen($description_text) > 120 ? substr($description_text, 0, 117) . '...' : $description_text;
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                    <?php $services_result->free(); ?>
                <?php elseif (isset($conn)): // Only show "no services" if DB connection was attempted ?>
                    <div class="col">
                        <p class="text-center alert alert-info">
                            <?php if ($searchTerm): ?>
                                No services found matching your search: "<?php echo htmlspecialchars($searchTerm); ?>".
                            <?php else: ?>
                                No services are currently available.
                            <?php endif; ?>
                        </p>
                    </div>
                <?php endif; ?>
                <?php if (!isset($conn)): ?>
                    {/* This message is now shown where $conn is checked earlier if it's more appropriate there */}
                <?php endif; ?>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer" onmouseover="footerMouseover(this)" onmouseleave="footerMouseleave(this)">
            <p>© <span id="footerYear"></span> PC Fix & Build</p>
        </div>
    </div>

    
    <script src="js/script.js"></script>

    <script>
        // client-side filter JavaScript
        document.addEventListener('DOMContentLoaded', function() { // Ensure DOM is ready
            const serviceFilter = document.getElementById('serviceFilter');
            // const servicesList = document.getElementById('servicesList'); // Not directly needed for this logic

            if (serviceFilter) {
                serviceFilter.addEventListener('change', function() {
                    const selectedCategory = serviceFilter.value;
                    const serviceCards = document.querySelectorAll('#servicesList .service-card'); // Target all cards

                    serviceCards.forEach(card => {
                        const category = card.getAttribute('data-category');
                        if (selectedCategory === "" || category === selectedCategory) {
                            card.style.display = "block";
                        } else {
                            card.style.display = "none";
                        }
                    });
                });
            }

            // Footer year 
            const footerYearEl = document.getElementById('footerYear');
            if (footerYearEl) {
                footerYearEl.textContent = new Date().getFullYear();
            }
        });
    </script>
</body>
</html>