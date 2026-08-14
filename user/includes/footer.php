<?php



$sql = "
    SELECT email, mobile, whatsapp, location
    FROM company_info
    LIMIT 1
";

$result = $conn->query($sql)->fetch_assoc();


?>

<footer class="site-footer">

    <div class="footer-container">

        <div class="footer-brand">

            <div class="brand-logo">

                <div class="brand-logo-icon">
                    W
                </div>

                <span>webdemo</span>

            </div>

            <p>
                We provide reliable technology solutions
                for businesses and organizations.
            </p>

        </div>


        <div class="footer-links">

            <h3>Quick Links</h3>

            <a href="/demoweb/user/index.php">
                Home
            </a>

            <a href="/demoweb/user/services/index.php">
                Services
            </a>

            <a href="/demoweb/user/brands/index.php">
                Brands
            </a>

            <a href="/demoweb/user/gallery/index.php">
                Gallery
            </a>

        </div>


        <div class="footer-links">

            <h3>Contact</h3>

            <p>
                <i class="fa-solid fa-envelope"></i>
                <?= $result['email'] ?>
            </p>

            <p>
                <i class="fa-solid fa-phone"></i>
                <?= $result['mobile'] ?>
            </p>

            <p>
                <i class="fa-brands fa-whatsapp"></i>
                <?= $result['whatsapp'] ?>

            <p>
                <i class="fa-solid fa-location-dot"></i>
                <?= $result['location'] ?>
            </p>

        </div>

    </div>


    <div class="footer-bottom">

        <p>
            © <?= date('Y') ?> WebDemo Solutions.
            All rights reserved.
        </p>

    </div>

    <a href="https://wa.me/91<?= preg_replace('/\D/', '', $result['whatsapp']) ?>"
        class="whatsapp-float"
        target="_blank">
        <i class="fa-brands fa-whatsapp"></i>
    </a>

</footer>

</body>

</html>