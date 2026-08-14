<?php

$page = 'about';
$page_title = 'About Us | WebDemo Solutions';

include "includes/header.php";
require_once "../user/config/dbconn.php";

?>

<main class="about-page">

    <!-- =========================
         ABOUT HERO
    ========================== -->
    <link rel="stylesheet" href="/demoweb/user/css/about.css">
    <link rel="stylesheet" href="/demoweb/user/css/footer.css">

    <section class="about-hero">

        <div class="about-hero-content">

            <span class="about-label">
                ABOUT US
            </span>

            <h1>
                Technology Solutions
                <br>
                You Can <span>Trust.</span>
            </h1>

            <p>
                We provide reliable technology solutions and professional
                services designed to help businesses work smarter and grow
                with confidence.
            </p>

        </div>

    </section>


    <!-- =========================
         INTRODUCTION
    ========================== -->

    <section class="about-intro">

        <div class="about-container">

            <div class="about-intro-text">

                <span class="section-label">
                    WHO WE ARE
                </span>

                <h2>
                    Helping Businesses
                    <span>Grow With Technology</span>
                </h2>

                <p>
                    WebDemo Solutions is focused on providing dependable
                    technology products and services for businesses and
                    organizations.
                </p>

                <p>
                    From technology solutions to professional support,
                    our goal is to make technology simple, reliable and
                    useful for our customers.
                </p>

            </div>


            <div class="about-intro-card">

                <div class="about-card-icon">
                    <i class="fa-solid fa-building"></i>
                </div>

                <h3>
                    Professional Solutions
                </h3>

                <p>
                    Quality products, trusted brands and services
                    designed around your needs.
                </p>

            </div>

        </div>

    </section>


    <!-- =========================
         WHAT WE DO
    ========================== -->

    <section class="about-services">

        <div class="about-container">

            <div class="section-heading">

                <span class="section-label">
                    WHAT WE DO
                </span>

                <h2>
                    Our Approach
                </h2>

                <p>
                    We focus on providing practical technology solutions
                    with dependable service and customer support.
                </p>

            </div>


            <div class="approach-grid">

                <div class="approach-card">

                    <div class="approach-icon">
                        <i class="fa-solid fa-lightbulb"></i>
                    </div>

                    <h3>
                        Smart Solutions
                    </h3>

                    <p>
                        We help customers find technology solutions
                        that match their actual requirements.
                    </p>

                </div>


                <div class="approach-card">

                    <div class="approach-icon">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>

                    <h3>
                        Reliable Service
                    </h3>

                    <p>
                        We believe in dependable products and services
                        that customers can trust.
                    </p>

                </div>


                <div class="approach-card">

                    <div class="approach-icon">
                        <i class="fa-solid fa-headset"></i>
                    </div>

                    <h3>
                        Customer Support
                    </h3>

                    <p>
                        Our focus is on providing helpful support
                        before and after the service.
                    </p>

                </div>

            </div>

        </div>

    </section>


    <!-- =========================
         WHY CHOOSE US
    ========================== -->

    <section class="why-us">

        <div class="about-container why-grid">

            <div>

                <span class="section-label">
                    WHY CHOOSE US
                </span>

                <h2>
                    Built Around
                    <span>Your Needs</span>
                </h2>

                <p>
                    We understand that every business has different
                    requirements. That's why we focus on providing
                    solutions that are practical, reliable and easy
                    to use.
                </p>

            </div>


            <div class="why-list">

                <div class="why-item">

                    <i class="fa-solid fa-circle-check"></i>

                    <div>
                        <h3>
                            Trusted Technology
                        </h3>

                        <p>
                            We work with established technology brands.
                        </p>
                    </div>

                </div>


                <div class="why-item">

                    <i class="fa-solid fa-circle-check"></i>

                    <div>
                        <h3>
                            Quality Services
                        </h3>

                        <p>
                            Professional services focused on quality
                            and customer satisfaction.
                        </p>
                    </div>

                </div>


                <div class="why-item">

                    <i class="fa-solid fa-circle-check"></i>

                    <div>
                        <h3>
                            Customer First
                        </h3>

                        <p>
                            We put customer requirements at the center
                            of our solutions.
                        </p>
                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- =========================
         CTA
    ========================== -->

    <section class="about-cta">

        <div class="about-cta-content">

            <span class="section-label">
                LET'S WORK TOGETHER
            </span>

            <h2>
                Looking For The Right
                Technology Solution?
            </h2>

            <p>
                Explore our services and discover how we can help
                your business.
            </p>

            <a href="services/index.php" class="cta-btn">
                Explore Services
                <i class="fa-solid fa-arrow-right"></i>
            </a>

        </div>

    </section>

</main>


<?php include "includes/footer.php"; ?>