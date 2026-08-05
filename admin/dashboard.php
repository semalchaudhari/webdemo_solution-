<?php

require_once './config/auth.php';


require_once "./config/dbconn.php";

include "./includes/sidebar.php";

$services = $conn->query("SELECT COUNT(*) AS total FROM services")
    ->fetch_assoc()['total'];

$brands = $conn->query("SELECT COUNT(*) AS total FROM brands")
    ->fetch_assoc()['total'];

$reviews = $conn->query("SELECT COUNT(*) AS total FROM reviews")
    ->fetch_assoc()['total'];

$sliders = $conn->query("SELECT COUNT(*) AS total FROM sliders")
    ->fetch_assoc()['total'];

$gallery = $conn->query("SELECT COUNT(*) AS total FROM gallery")
    ->fetch_assoc()['total'];

$messages = $conn->query("SELECT COUNT(*) AS total FROM contact_messages")
    ->fetch_assoc()['total'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Dashboard</title>

    <link rel="stylesheet" href="dashboard.css">

    <link rel="stylesheet" href="./css/sidebar.css">

    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <script>
        window.addEventListener("pageshow", function(event) {

            const backForward =
                event.persisted ||
                performance.getEntriesByType("navigation")[0]?.type === "back_forward";

            if (backForward) {
                location.reload();
            } else {
                document.body.style.visibility = "visible";
            }

        });
    </script>
</head>

<body>

    <div class="dashboard">

        <!-- ================= SIDEBAR ================= -->
        <!-- 
        <aside class="sidebar" id="sidebar">

            <div class="logo">
                <div class="logo-icon">W</div>
                <span>webdemo</span>
            </div>

            <nav class="sidebar-nav">

                <div class="nav-section">
                    <p class="section-title">MAIN</p>

                    <a href="#" class="nav-link active">
                        <i class="fa-solid fa-house"></i>
                        <span>Dashboard</span>
                    </a>
                </div>

                <div class="nav-section">

                    <p class="section-title">CONTENT</p>

                    <a href="./services/index.php" class="nav-link">
                        <i class="fa-solid fa-briefcase"></i>
                        <span>Services</span>
                    </a>

                    <a href="#" class="nav-link">
                        <i class="fa-solid fa-tags"></i>
                        <span>Brands</span>
                    </a>

                    <a href="#" class="nav-link">
                        <i class="fa-solid fa-star"></i>
                        <span>Reviews</span>
                    </a>
                </div>

                <div class="nav-section">

                    <p class="section-title">SYSTEM</p>

                    <a href="logout.php" class="nav-link">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Logout</span>
                    </a>

                </div>

            </nav>

        </aside> -->


        <!-- ================= MAIN ================= -->

        <div class="main-content">

            <!-- TOP NAVBAR -->

            <header class="topbar">

                <div class="topbar-left">

                    <button class="menu-btn" id="menuBtn">
                        <i class="fa-solid fa-bars"></i>
                    </button>

                </div>


                <div class="topbar-right">

                    <button class="icon-btn">
                        <i class="fa-regular fa-bell"></i>
                    </button>

                    <div class="admin-profile">

                        <div class="profile-image">
                            <img src="../upload/admin.jpg" alt="Admin Profile">
                        </div>

                        <div class="profile-info">
                            <span class="admin-name"><?php echo htmlspecialchars($_SESSION['name']); ?></span>
                        </div>

                        <!-- <i class="fa-solid fa-chevron-down profile-arrow"></i> -->

                    </div>

                </div>

            </header>


            <!-- ================= PAGE CONTENT ================= -->

            <main class="content">

                <div class="page-header">

                    <div>
                        <h1>Dashboard</h1>
                        <p>Welcome back, <?php echo htmlspecialchars($_SESSION['name']); ?></p>
                    </div>

                </div>


                <!-- ================= STAT CARDS ================= -->

                <section class="stats-grid">

                    <div class="stat-card">

                        <div class="stat-content">

                            <p>Total photos</p>

                            <h2 id="serviceCount"><?php echo $gallery; ?></h2>

                            <!-- <a href="#">
                                Manage Services
                                <i class="fa-solid fa-arrow-right"></i>
                            </a> -->

                        </div>

                        <div class="stat-icon services-icon">
                            <i class="fa-solid fa-image"></i>
                        </div>

                    </div>

                    <div class="stat-card">

                        <div class="stat-content">

                            <p>Total sliders</p>

                            <h2 id="serviceCount"><?php echo $sliders; ?></h2>

                            <!-- <a href="#">
                                Manage Services
                                <i class="fa-solid fa-arrow-right"></i>
                            </a> -->

                        </div>

                        <div class="stat-icon services-icon">

                            <i class="fa-solid fa-sliders"></i>
                        </div>

                    </div>



                    <!-- SERVICES -->

                    <div class="stat-card">

                        <div class="stat-content">

                            <p>Total Services</p>

                            <h2 id="serviceCount"><?php echo $services; ?></h2>

                            <!-- <a href="#">
                                Manage Services
                                <i class="fa-solid fa-arrow-right"></i>
                            </a> -->

                        </div>

                        <div class="stat-icon services-icon">
                            <i class="fa-solid fa-briefcase"></i>
                        </div>

                    </div>


                    <!-- BRANDS -->

                    <div class="stat-card">

                        <div class="stat-content">

                            <p>Total Brands</p>

                            <h2 id="brandCount"><?php echo $brands; ?></h2>

                            <!-- <a href="#">
                                Manage Brands
                                <i class="fa-solid fa-arrow-right"></i>
                            </a> -->

                        </div>

                        <div class="stat-icon brands-icon">
                            <i class="fa-solid fa-tags"></i>
                        </div>

                    </div>


                    <!-- REVIEWS -->

                    <div class="stat-card">

                        <div class="stat-content">

                            <p>Total Reviews</p>

                            <h2 id="reviewCount"><?php echo $reviews; ?></h2>

                            <!-- <a href="#">
                                Manage Reviews
                                <i class="fa-solid fa-arrow-right"></i>
                            </a> -->

                        </div>

                        <div class="stat-icon reviews-icon">
                            <i class="fa-solid fa-star"></i>
                        </div>

                    </div>

                    <!-- MESSAGES -->   

                    <div class="stat-card">

                        <div class="stat-content">

                            <p>Total Messages</p>

                            <h2 id="messageCount"><?php echo $messages; ?></h2>

                           

                        </div>

                        <div class="stat-icon messages-icon">
                            <i class="fa-solid fa-envelope"></i>
                        </div>

                    


                    <!-- SUBSCRIBERS -->

                    <!-- <div class="stat-card">

                        <div class="stat-content">

                            <p>Total Subscribers</p>

                            <h2 id="subscriberCount">150</h2>

                            <a href="#">
                                View Subscribers
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>

                        </div>

                        <div class="stat-icon subscribers-icon">
                            <i class="fa-solid fa-envelope"></i>
                        </div>

                    </div> -->

                </section>


                <!-- ================= QUICK ACTIONS ================= -->

                <section class="dashboard-grid">

                    <div class="panel">

                        <div class="panel-header">

                            <div>
                                <h2>Quick Actions</h2>
                                <p>Manage your website content</p>
                            </div>

                        </div>


                        <div class="quick-actions">

                            <a href="./services/add.php" class="action-card">

                                <div class="action-icon">
                                    <i class="fa-solid fa-plus"></i>
                                </div>

                                <div>
                                    <h3>Add Service</h3>
                                    <p>Create a new service</p>
                                </div>

                                <i class="fa-solid fa-chevron-right action-arrow"></i>

                            </a>


                            <a href="./brands/add.php" class="action-card">

                                <div class="action-icon">
                                    <i class="fa-solid fa-plus"></i>
                                </div>

                                <div>
                                    <h3>Add Brand</h3>
                                    <p>Add a brand you deal with</p>
                                </div>

                                <i class="fa-solid fa-chevron-right action-arrow"></i>

                            </a>


                            <a href="./reviews/add.php" class="action-card">

                                <div class="action-icon">
                                    <i class="fa-solid fa-plus"></i>
                                </div>

                                <div>
                                    <h3>Add Review</h3>
                                    <p>Add a customer review</p>
                                </div>

                                <i class="fa-solid fa-chevron-right action-arrow"></i>

                            </a>

                            <a href="./sliders/add.php" class="action-card">
                                <div class="action-icon">
                                    <i class="fa-solid fa-plus"></i>
                                </div>

                                <div>
                                    <h3>Add Slider</h3>
                                    <p>Add a new slider image</p>
                                </div>

                                <i class="fa-solid fa-chevron-right action-arrow"></i>
                            </a>

                            <a href="./gallery/add.php" class="action-card">
                                <div class="action-icon">
                                    <i class="fa-solid fa-plus"></i>
                                </div>

                                <div>
                                    <h3>Add Gallery Image</h3>
                                    <p>Add an image to the gallery</p>
                                </div>

                                <i class="fa-solid fa-chevron-right action-arrow"></i>
                            </a>

                        </div>

                    </div>


                    <!-- WEBSITE OVERVIEW -->

                    <!-- <div class="panel overview-panel">

                        <div class="panel-header">

                            <div>
                                <h2>Website Overview</h2>
                                <p>Quick information</p>
                            </div>

                        </div>

                        <div class="overview-list">

                            <div class="overview-item">

                                <div class="overview-left">
                                    <div class="small-icon">
                                        <i class="fa-solid fa-briefcase"></i>
                                    </div>

                                    <span>Services</span>
                                </div>

                                <strong id="overviewServices"><?php echo $services; ?></strong>

                            </div>


                            <div class="overview-item">

                                <div class="overview-left">
                                    <div class="small-icon">
                                        <i class="fa-solid fa-tags"></i>
                                    </div>

                                    <span>Brands</span>
                                </div>

                                <strong id="overviewBrands"><?php echo $brands; ?></strong>

                            </div>


                            <div class="overview-item">

                                <div class="overview-left">
                                    <div class="small-icon">
                                        <i class="fa-solid fa-star"></i>
                                    </div>

                                    <span>Reviews</span>
                                </div>

                                <strong id="overviewReviews"><?php echo $reviews; ?></strong>

                            </div>


                        </div>

                    </div> -->

                </section>

            </main>

        </div>

    </div>


    <script src="dashboard.js"></script>

</body>

</html>