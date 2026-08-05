<?php

$page = 'contact';
$page_title = 'Contact Us | WebDemo Solutions';

require_once "./config/dbconn.php";

$success = "";
$error = "";


/* =========================
   FORM SUBMISSION
========================= */

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST['name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $message = trim($_POST['message'] ?? '');


    /* =========================
       VALIDATION
    ========================= */

    if ($name === "" || $phone === "" || $message === "") {

        $error = "Please fill in all fields.";

    } elseif (!preg_match("/^[0-9+\-\s]{10,15}$/", $phone)) {

        $error = "Please enter a valid phone number.";

    } else {

        /* =========================
           INSERT MESSAGE
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

            $success = "Thank you! Your message has been sent successfully.";

            $name = "";
            $phone = "";
            $message = "";

        } else {

            $error = "Something went wrong. Please try again.";

        }

        $stmt->close();
    }
}


include "includes/header.php";

?>


<main class="contact-page">

<link rel="stylesheet" href="/demoweb/user/css/contact.css">


    <!-- =========================
         CONTACT HERO
    ========================== -->

    <section class="contact-hero">

        <div class="contact-hero-content">

            <span class="contact-label">
                GET IN TOUCH
            </span>

            <h1>
                Let's Talk About
                <span>Your Requirements.</span>
            </h1>

            <p>
                Have a question or need a technology solution?
                Send us a message and our team will get back to you.
            </p>

        </div>

    </section>


    <!-- =========================
         CONTACT SECTION
    ========================== -->

    <section class="contact-section">

        <div class="contact-container">


            <!-- =========================
                 CONTACT INFORMATION
            ========================== -->

            <div class="contact-info">

                <span class="section-label">
                    CONTACT US
                </span>

                <h2>
                    We're Here To
                    <span>Help.</span>
                </h2>

                <p class="contact-description">
                    Whether you have a question about our services,
                    products or anything else, feel free to contact us.
                </p>


                <div class="contact-info-list">


                    <!-- PHONE -->

                    <div class="contact-info-item">

                        <div class="contact-icon">

                            <i class="fa-solid fa-phone"></i>

                        </div>

                        <div>

                            <span>
                                Phone
                            </span>

                            <h3>
                                +91 98765 43210
                            </h3>

                        </div>

                    </div>


                    <!-- EMAIL -->

                    <div class="contact-info-item">

                        <div class="contact-icon">

                            <i class="fa-solid fa-envelope"></i>

                        </div>

                        <div>

                            <span>
                                Email
                            </span>

                            <h3>
                                info@webdemo.com
                            </h3>

                        </div>

                    </div>


                    <!-- ADDRESS -->

                    <div class="contact-info-item">

                        <div class="contact-icon">

                            <i class="fa-solid fa-location-dot"></i>

                        </div>

                        <div>

                            <span>
                                Address
                            </span>

                            <h3>
                                Your Business Address
                            </h3>

                        </div>

                    </div>

                </div>

            </div>


            <!-- =========================
                 CONTACT FORM
            ========================== -->

            <div class="contact-form-card">

                <div class="form-heading">

                    <h2>
                        Send Us A Message
                    </h2>

                    <p>
                        Fill in the details below and we'll get back
                        to you as soon as possible.
                    </p>

                </div>


                <?php if ($success): ?>

                    <div class="alert success-alert">

                        <i class="fa-solid fa-circle-check"></i>

                        <?= htmlspecialchars($success) ?>

                    </div>

                <?php endif; ?>


                <?php if ($error): ?>

                    <div class="alert error-alert">

                        <i class="fa-solid fa-circle-exclamation"></i>

                        <?= htmlspecialchars($error) ?>

                    </div>

                <?php endif; ?>


                <form
                    method="POST"
                    action=""
                    class="contact-form">


                    <!-- NAME -->

                    <div class="form-group">

                        <label for="name">
                            Name
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            placeholder="Enter your name"
                            value="<?= htmlspecialchars($name ?? '') ?>"
                            required>

                    </div>


                    <!-- PHONE -->

                    <div class="form-group">

                        <label for="phone">
                            Phone Number
                        </label>

                        <input
                            type="tel"
                            id="phone"
                            name="phone"
                            placeholder="Enter your phone number"
                            value="<?= htmlspecialchars($phone ?? '') ?>"
                            required>

                    </div>


                    <!-- MESSAGE -->

                    <div class="form-group">

                        <label for="message">
                            Message
                        </label>

                        <textarea
                            id="message"
                            name="message"
                            rows="6"
                            placeholder="Write your message..."
                            required><?= htmlspecialchars($message ?? '') ?></textarea>

                    </div>


                    <!-- SUBMIT -->

                    <button
                        type="submit"
                        class="contact-submit">

                        Send Message

                        <i class="fa-solid fa-paper-plane"></i>

                    </button>

                </form>

            </div>

        </div>

    </section>


</main>


<?php include "includes/footer.php"; ?>