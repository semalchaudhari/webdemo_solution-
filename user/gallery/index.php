<?php

$page = 'gallery';
$page_title = 'Gallery | WebDemo Solutions';

require_once "../../admin/config/dbconn.php";

$sql = "
    SELECT id, title, image
    FROM gallery
    ORDER BY created_at DESC
";

$result = $conn->query($sql);

include "../includes/header.php";

?>

<link rel="stylesheet" href="/demoweb/user/css/gallery.css">


<main>

    <section class="gallery-banner">

        <div>

            <span>OUR WORK</span>

            <h1>Gallery</h1>

            <p>
                Explore our work, projects and activities.
            </p>

        </div>

    </section>


    <section class="gallery-page">

        <div class="gallery-container">

            <div class="gallery-grid">

                <?php while ($photo = $result->fetch_assoc()): ?>

                    <article class="gallery-item">

                        <img
                            src="../../upload/gallery/<?= htmlspecialchars($photo['image']) ?>"
                            alt="<?= htmlspecialchars($photo['title']) ?>">

                        <div class="gallery-item-overlay">

                            <i class="fa-solid fa-expand"></i>

                            <h3>
                                <?= htmlspecialchars($photo['title']) ?>
                            </h3>

                        </div>

                    </article>

                <?php endwhile; ?>

            </div>

        </div>

    </section>

</main>

<?php include "../includes/footer.php"; ?>