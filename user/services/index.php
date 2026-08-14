<?php

$page = 'services';
$page_title = 'Services | WebDemo Solutions';

require_once "../../admin/config/dbconn.php";

$sql = "
    SELECT id, title, description, image
    FROM services
    ORDER BY created_at DESC
";

$result = $conn->query($sql);

if (!$result) {
    die("Unable to load services.");
}

include "../includes/header.php";

?>

<link rel="stylesheet" href="../css/service.css">
<link rel="stylesheet" href="/demoweb/user/css/footer.css">


<main class="services-page">


    <section class="page-banner">

        <div class="page-banner-content">

            <span>WHAT WE DO</span>

            <h1>Our Services</h1>

            <p>
                Professional technology solutions
                designed for your business.
            </p>

        </div>

    </section>


    <section class="all-services">

        <div class="user-container">

            <div class="section-heading">

                <span>
                    OUR EXPERTISE
                </span>

                <h2>
                    Explore Our Services
                </h2>

            </div>


            <div class="all-service-grid">

                <?php while ($service = $result->fetch_assoc()): ?>

                    <a
                        href="view.php?id=<?= $service['id'] ?>"
                        class="full-service-card">

                        <?php if (!empty($service['image'])): ?>

                            <img
                                src="../../upload/services/<?= htmlspecialchars($service['image']) ?>"
                                alt="<?= htmlspecialchars($service['title']) ?>">

                        <?php else: ?>

                            <div class="service-placeholder">
                                <i class="fa-solid fa-briefcase"></i>
                            </div>

                        <?php endif; ?>


                        <div class="full-service-content">

                            <h3>
                                <?= htmlspecialchars($service['title']) ?>
                            </h3>

                            <p>
                                <?= htmlspecialchars(
                                    mb_strimwidth(
                                        $service['description'],
                                        0,
                                        150,
                                        '...'
                                    )
                                ) ?>
                            </p>

                            <span>
                                Read More
                                <i class="fa-solid fa-arrow-right"></i>
                            </span>

                        </div>

                    </a>

                <?php endwhile; ?>

            </div>

        </div>

    </section>

</main>

<?php include "../includes/footer.php"; ?>