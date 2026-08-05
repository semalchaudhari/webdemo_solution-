<?php
$page = $page ?? '';
$page_title = $page_title ?? 'WebDemo Solutions';
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($page_title) ?></title>

    <!-- Font Awesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- Header CSS -->
    <link rel="stylesheet" href="/demoweb/user/css/header.css">

</head>

<body>

<header class="site-header">

    <nav class="navbar">

        <a href="/demoweb/user/index.php" class="brand-logo">

            <div class="brand-logo-icon">
                W
            </div>

            <span>webdemo</span>

        </a>


        <div class="nav-menu">

            <a
                href="/demoweb/user/index.php"
                class="<?= $page === 'home' ? 'active' : '' ?>">
                Home
            </a>

            <a
                href="/demoweb/user/services/index.php"
                class="<?= $page === 'services' ? 'active' : '' ?>">
                Services
            </a>

            <a
                href="/demoweb/user/brands/index.php"
                class="<?= $page === 'brands' ? 'active' : '' ?>">
                Brands
            </a>

            <a
                href="/demoweb/user/reviews/index.php"
                class="<?= $page === 'reviews' ? 'active' : '' ?>">
                Reviews
            </a>

            <a
                href="/demoweb/user/gallery/index.php"
                class="<?= $page === 'gallery' ? 'active' : '' ?>">
                Gallery
            </a>

            <a href="/demoweb/user/about.php"
                class="<?= $page === 'about' ? 'active' : '' ?>">
                About
            </a>

        </div>


        <a href="/demoweb/user/contact.php" class="nav-contact">
            Contact Us
        </a>

    </nav>

</header>