<?php

$page = 'brands';
$page_title = 'Brands | WebDemo Solutions';

require_once "../../admin/config/dbconn.php";

$sql = "
    SELECT id, name, logo
    FROM brands
    ORDER BY created_at DESC
";

$result = $conn->query($sql);

include "../includes/header.php";

?>

<link rel="stylesheet" href="/demoweb/user/css/brand.css">


<main>

    <section class="brands-banner">

        <div>

            <span>OUR PARTNERS</span>

            <h1>Brands We Deal With</h1>

            <p>
                We work with trusted technology brands
                to provide quality solutions.
            </p>

        </div>

    </section>


    <section class="brands-content">

        <div class="brands-container">

            <div class="brands-grid">

                <?php while ($brand = $result->fetch_assoc()): ?>

                    <article class="brand-card">

                        <div class="brand-card-logo">

                            <?php if (!empty($brand['logo'])): ?>

                                <img
                                    src="../../upload/brands/<?= htmlspecialchars($brand['logo']) ?>"
                                    alt="<?= htmlspecialchars($brand['name']) ?>">

                            <?php else: ?>

                                <i class="fa-solid fa-tag"></i>

                            <?php endif; ?>

                        </div>

                        <h3>
                            <?= htmlspecialchars($brand['name']) ?>
                        </h3>

                    </article>

                <?php endwhile; ?>

            </div>

        </div>

    </section>

</main>

<?php include "../includes/footer.php"; ?>