<?php

$page = 'home';
$page_title = 'WebDemo Solutions';

require_once "../user/config/dbconn.php";



// =========================
// MAIN SLIDER
// =========================

$slider_sql = "
    SELECT id, title, description, image
    FROM sliders
    ORDER BY created_at DESC
";

$sliders = $conn->query($slider_sql);


// =========================
// SERVICES
// =========================

$service_sql = "
    SELECT id, title, description, image
    FROM services
    ORDER BY created_at DESC
    LIMIT 3
";

$services = $conn->query($service_sql);


// =========================
// ALL SERVICES FOR SLIDER
// =========================

$service_slider_sql = "
    SELECT id, title, description, image
    FROM services
    ORDER BY created_at DESC
";

$service_slider = $conn->query($service_slider_sql);


// =========================
// BRANDS
// =========================

$brand_sql = "
    SELECT id, name, logo
    FROM brands
    ORDER BY created_at DESC
";

$brands = $conn->query($brand_sql);


// =========================
// REVIEWS
// =========================

$review_sql = "
    SELECT id, customer_name, review, rating
    FROM reviews
    ORDER BY created_at DESC
";

$reviews = $conn->query($review_sql);


// =========================
// GALLERY
// =========================

$gallery_sql = "
    SELECT id, title, image
    FROM gallery
    ORDER BY created_at DESC
    LIMIT 6
";

$gallery = $conn->query($gallery_sql);

    // =========================
    //inquiry form submission handling
    // =========================



$inquiry_success = "";
$inquiry_error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["inquiry_submit"])) {

    $name = trim($_POST["name"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $message = trim($_POST["message"] ?? "");


    /* =========================
       VALIDATION
    ========================= */

    if ($name === "" || $phone === "" || $message === "") {

        $inquiry_error = "Please fill in all the fields.";

    } elseif (strlen($name) < 2) {

        $inquiry_error = "Please enter a valid name.";

    } elseif (!preg_match("/^[0-9+\-\s]{10,15}$/", $phone)) {

        $inquiry_error = "Please enter a valid phone number.";

    } elseif (strlen($message) < 5) {

        $inquiry_error = "Please enter a valid message.";

    } else {

        /* =========================
           INSERT
        ========================= */

        $stmt = $conn->prepare("
            INSERT INTO contact_messages
            (name, phone, message)
            VALUES (?, ?, ?)
        ");

        $stmt->bind_param(
            "sss",
            $name,
            $phone,
            $message
        );

        if ($stmt->execute()) {

            $inquiry_success = "Your inquiry has been submitted successfully.";

        } else {

            $inquiry_error = "Unable to submit your inquiry. Please try again.";

        }

        $stmt->close();
    }
}


$page = "home";
$page_title = "Home";





include "includes/header.php";

?>

<link rel="stylesheet" href="/demoweb/user/css/home1.css">
<link rel="stylesheet" href="/demoweb/user/css/footer.css">
<link rel="stylesheet" href="/demoweb/user/css/inquiry.css">


<!-- ==================================================
     MAIN HERO SLIDER
================================================== -->

<section class="hero-slider">

    <?php if ($sliders && $sliders->num_rows > 0): ?>

        <?php $first = true; ?>

        <?php while ($slider = $sliders->fetch_assoc()): ?>

            <div class="hero-slide <?= $first ? 'active' : '' ?>">

                <img
                    src="../upload/sliders/<?= htmlspecialchars($slider['image']) ?>"
                    alt="<?= htmlspecialchars($slider['title']) ?>">

                <div class="hero-overlay">

                    <div class="hero-content">

                        <span class="section-label">
                            WEBDEMO SOLUTIONS
                        </span>

                        <h1>
                            <?= htmlspecialchars($slider['title']) ?>
                        </h1>

                        <p>
                            <?= htmlspecialchars($slider['description']) ?>
                        </p>

                        <a
                            href="./services/index.php"
                            class="primary-btn">
                            Explore Services
                        </a>

                    </div>

                </div>

            </div>

            <?php $first = false; ?>

        <?php endwhile; ?>

        <button class="hero-prev">
            <i class="fa-solid fa-chevron-left"></i>
        </button>

        <button class="hero-next">
            <i class="fa-solid fa-chevron-right"></i>
        </button>

    <?php else: ?>

        <div class="hero-empty">
            <h1>Welcome to WebDemo Solutions</h1>
            <p>Technology solutions for your business.</p>
        </div>

    <?php endif; ?>

</section>


<!-- ==================================================
     ABOUT
================================================== -->

<!-- <section class="about-section" id="about">

    <div class="home-container about-grid">

        <div class="about-content">

            <span class="section-label">
                ABOUT US
            </span>

            <h2>
                Technology That Helps Your Business Grow
            </h2>

            <p>
                We provide reliable technology solutions designed
                to help businesses work smarter, faster and more
                efficiently.
            </p>

            <p>
                From professional services to technology products,
                our goal is to provide quality solutions backed by
                trusted brands and excellent support.
            </p>

            <a href="#contact" class="primary-btn">
                Get In Touch
            </a>

        </div>

        <div class="about-box">

            <div>
                <i class="fa-solid fa-laptop-code"></i>
            </div>

            <h3>
                Reliable Technology Solutions
            </h3>

            <p>
                Professional solutions built around your business needs.
            </p>

        </div>

    </div>

</section> -->


<!-- ==================================================
     SERVICES - 3 CARDS
================================================== -->

<section class="services-section" id="services">

    <div class="home-container">

        <div class="section-heading">

            <span class="section-label">
                WHAT WE DO
            </span>

            <h2>
                Our Services
            </h2>

            <p>
                Explore the technology services we provide.
            </p>

        </div>


        <div class="service-cards">

            <?php if ($services && $services->num_rows > 0): ?>

                <?php while ($service = $services->fetch_assoc()): ?>

                    <a
                        href="services/view.php?id=<?= $service['id'] ?>"
                        class="service-card">

                        <?php if (!empty($service['image'])): ?>

                            <img
                                src="../upload/services/<?= htmlspecialchars($service['image']) ?>"
                                alt="<?= htmlspecialchars($service['title']) ?>">

                        <?php else: ?>

                            <div class="service-card-icon">
                                <i class="fa-solid fa-briefcase"></i>
                            </div>

                        <?php endif; ?>

                        <div class="service-card-content">

                            <h3>
                                <?= htmlspecialchars($service['title']) ?>
                            </h3>

                            <p>
                                <?= htmlspecialchars(
                                    mb_strimwidth(
                                        $service['description'],
                                        0,
                                        100,
                                        '...'
                                    )
                                ) ?>
                            </p>

                            <span class="read-more">
                                Read More
                                <i class="fa-solid fa-arrow-right"></i>
                            </span>

                        </div>

                    </a>

                <?php endwhile; ?>

            <?php endif; ?>

        </div>


        <div class="center-btn">

            <a
                href="services/index.php"
                class="secondary-btn">
                View All Services
            </a>

        </div>

    </div>

</section>


<!-- ==================================================
     SERVICES SLIDER
================================================== -->

<!-- <section class="services-slider-section">

    <div class="home-container">

        <div class="section-heading">

            <span class="section-label">
                OUR EXPERTISE
            </span>

            <h2>
                More Services
            </h2>

        </div>


        <div class="horizontal-slider-wrapper">

            <button
                class="slider-arrow service-prev">
                <i class="fa-solid fa-chevron-left"></i>
            </button>


            <div class="horizontal-slider" id="serviceSlider">

                <?php if ($service_slider): ?>

                    <?php while ($service = $service_slider->fetch_assoc()): ?>

                        <a
                            href="services/view.php?id=<?= $service['id'] ?>"
                            class="mini-service-card">

                            <div class="mini-service-icon">

                                <i class="fa-solid fa-briefcase"></i>

                            </div>

                            <h3>
                                <?= htmlspecialchars($service['title']) ?>
                            </h3>

                            <span>
                                Learn More
                                <i class="fa-solid fa-arrow-right"></i>
                            </span>

                        </a>

                    <?php endwhile; ?>

                <?php endif; ?>

            </div>


            <button
                class="slider-arrow service-next">

                <i class="fa-solid fa-chevron-right"></i>

            </button>

        </div>

    </div>

</section> -->


<!-- ==================================================
     BRANDS
================================================== -->

<section class="brands-section">

    <div class="home-container">

        <div class="section-heading">

            <span class="section-label">
                OUR PARTNERS
            </span>

            <h2>
                Brands We Deal With
            </h2>

        </div>


        <div class="horizontal-slider-wrapper">

            <button class="slider-arrow brand-prev">
                <i class="fa-solid fa-chevron-left"></i>
            </button>


            <div
                class="horizontal-slider brands-slider"
                id="brandSlider">

                <?php if ($brands): ?>

                    <?php while ($brand = $brands->fetch_assoc()): ?>

                        <div class="brand-item">

                            <div class="brand-logo-box">

                                <?php if (!empty($brand['logo'])): ?>

                                    <img
                                        src="../upload/brands/<?= htmlspecialchars($brand['logo']) ?>"
                                        alt="<?= htmlspecialchars($brand['name']) ?>">

                                <?php else: ?>

                                    <i class="fa-solid fa-tag"></i>

                                <?php endif; ?>

                            </div>

                            <h3>
                                <?= htmlspecialchars($brand['name']) ?>
                            </h3>

                        </div>

                    <?php endwhile; ?>

                <?php endif; ?>

            </div>


            <button class="slider-arrow brand-next">
                <i class="fa-solid fa-chevron-right"></i>
            </button>

        </div>

    </div>

</section>


<!-- ==================================================
     REVIEWS
================================================== -->

<section class="reviews-section">

    <div class="home-container">

        <div class="section-heading">

            <span class="section-label">
                CUSTOMER FEEDBACK
            </span>

            <h2>
                What Our Customers Say
            </h2>

        </div>


        <div class="review-slider-wrapper">

            <button class="review-arrow review-prev">
                <i class="fa-solid fa-chevron-left"></i>
            </button>


            <div class="review-slider" id="reviewSlider">

                <?php if ($reviews): ?>

                    <?php while ($review = $reviews->fetch_assoc()): ?>

                        <article class="review-card">

                            <div class="review-stars">

                                <?php for ($i = 1; $i <= 5; $i++): ?>

                                    <i
                                        class="fa-solid fa-star <?= $i <= $review['rating'] ? 'filled' : '' ?>">
                                    </i>

                                <?php endfor; ?>

                            </div>

                            <p>
                                "<?= htmlspecialchars($review['review']) ?>"
                            </p>

                            <h3>
                                <?= htmlspecialchars($review['customer_name']) ?>
                            </h3>

                        </article>

                    <?php endwhile; ?>

                <?php endif; ?>

            </div>


            <button class="review-arrow review-next">
                <i class="fa-solid fa-chevron-right"></i>
            </button>

        </div>

    </div>

</section>

<!-- =========================
     INQUIRY POPUP
========================== -->


<div
    class="inquiry-overlay <?= ($inquiry_success || $inquiry_error) ? 'show' : '' ?>"
    id="inquiryPopup">

    <div class="inquiry-box">


        <!-- CLOSE -->

        <button
            type="button"
            class="inquiry-close"
            id="closeInquiry">

            &times;

        </button>


        <!-- =========================
             HEADER
        ========================== -->

        <div class="inquiry-header">

            <span class="inquiry-label">
                GET IN TOUCH
            </span>

            <h2>
                Have an Inquiry?
            </h2>

            <p>
                Tell us what you need and we'll get back to you soon.
            </p>

        </div>


        <!-- =========================
             SUCCESS MESSAGE
        ========================== -->

        <?php if ($inquiry_success): ?>

            <div class="inquiry-message success">

                <i class="fa-solid fa-circle-check"></i>

                <span>
                    <?= htmlspecialchars($inquiry_success) ?>
                </span>

            </div>

        <?php endif; ?>


        <!-- =========================
             ERROR MESSAGE
        ========================== -->

        <?php if ($inquiry_error): ?>

            <div class="inquiry-message error">

                <i class="fa-solid fa-circle-exclamation"></i>

                <span>
                    <?= htmlspecialchars($inquiry_error) ?>
                </span>

            </div>

        <?php endif; ?>


        <!-- =========================
             FORM
        ========================== -->

        <?php if (!$inquiry_success): ?>

            <form
                method="POST"
                action=""
                class="inquiry-form">


                <!-- NAME -->

                <div class="form-group">

                    <label for="inquiry_name">
                        Name
                    </label>

                    <input
                        type="text"
                        id="inquiry_name"
                        name="name"
                        placeholder="Enter your name"
                        value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"
                        required>

                </div>


                <!-- PHONE -->

                <div class="form-group">

                    <label for="inquiry_phone">
                        Phone Number
                    </label>

                    <input
                        type="tel"
                        id="inquiry_phone"
                        name="phone"
                        placeholder="Enter your phone number"
                        value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>"
                        required>

                </div>


                <!-- MESSAGE -->

                <div class="form-group">

                    <label for="inquiry_message">
                        Message
                    </label>

                    <textarea
                        id="inquiry_message"
                        name="message"
                        rows="4"
                        placeholder="Write your inquiry..."
                        required><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>

                </div>


                <!-- SUBMIT -->

                <button
                    type="submit"
                    name="inquiry_submit"
                    class="inquiry-submit">

                    Send Inquiry

                    <i class="fa-solid fa-paper-plane"></i>

                </button>

            </form>

        <?php endif; ?>

    </div>

</div>


<script src="/demoweb/user/js/inquiry1.js"></script>

<script src="/demoweb/user/js/home2.js"></script>

<?php include "includes/footer.php"; ?>