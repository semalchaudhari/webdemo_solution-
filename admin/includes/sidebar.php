

<?php
// If no page is defined, use an empty value
$page = $page ?? '';
?>

<aside class="sidebar" id="sidebar">

    <div class="logo">
        <div class="logo-icon">W</div>
        <span>webdemo</span>
    </div>

    <nav class="sidebar-nav">

        <!-- MAIN -->
        <div class="nav-section">
            <p class="section-title">MAIN</p>

            <a href="/demoweb/admin/dashboard.php"
               class="nav-link <?= $page === 'dashboard' ? 'active' : '' ?>">
                <i class="fa-solid fa-house"></i>
                <span>Dashboard</span>
            </a>
        </div>


        <!-- CONTENT -->
        <div class="nav-section">

            <p class="section-title">CONTENT</p>

            <a href="/demoweb/admin/gallery/index.php"
               class="nav-link <?= $page === 'gallery' ? 'active' : '' ?>">
                <i class="fa-solid fa-image"></i>
                <span>Gallery</span>

            </a>

            <a href="/demoweb/admin/sliders/index.php"
               class="nav-link <?= $page === 'sliders' ? 'active' : '' ?>">
                <i class="fa-solid fa-sliders"></i>
                <span>Sliders</span>
            </a>

            <a href="/demoweb/admin/services/index.php"
               class="nav-link <?= $page === 'services' ? 'active' : '' ?>">
                <i class="fa-solid fa-briefcase"></i>
                <span>Services</span>
            </a>

            <a href="/demoweb/admin/brands/index.php"
               class="nav-link <?= $page === 'brands' ? 'active' : '' ?>">
                <i class="fa-solid fa-tags"></i>
                <span>Brands</span>
            </a>

            <a href="/demoweb/admin/reviews/index.php"
               class="nav-link <?= $page === 'reviews' ? 'active' : '' ?>">
                <i class="fa-solid fa-star"></i>
                <span>Reviews</span>
            </a>

            <a href="/demoweb/admin/messages/index.php"
               class="nav-link <?= $page === 'messages' ? 'active' : '' ?>">
                <i class="fa-solid fa-envelope"></i>
                <span>Messages</span>

            </a>

        </div>


        <!-- SYSTEM -->
        <div class="nav-section">

            <p class="section-title">SYSTEM</p>

            <a href="/demoweb/admin/logout.php" class="nav-link">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>Logout</span>
            </a>

        </div>

    </nav>

</aside>
