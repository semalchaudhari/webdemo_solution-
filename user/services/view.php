<?php

$page = 'services';
$page_title = 'Service | WebDemo Solutions';

require_once "../../admin/config/dbconn.php";

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    die("Invalid service.");
}

$stmt = $conn->prepare("
    SELECT id, title, description, image, created_at
    FROM services
    WHERE id = ?
");

$stmt->bind_param("i", $id);

$stmt->execute();

$result = $stmt->get_result();

$service = $result->fetch_assoc();

if (!$service) {
    die("Service not found.");
}

$page_title = $service['title'] . ' | WebDemo Solutions';

include "../includes/header.php";

?>

<link rel="stylesheet" href="/demoweb/user/css/service-view.css">


<main class="service-view-page">

    <section class="service-detail">

        <div class="service-detail-container">

            <a href="index.php" class="back-link">
                <i class="fa-solid fa-arrow-left"></i>
                Back to Services
            </a>


            <div class="service-detail-card">

                <?php if (!empty($service['image'])): ?>

                    <img
                        src="../../upload/services/<?= htmlspecialchars($service['image']) ?>"
                        alt="<?= htmlspecialchars($service['title']) ?>">

                <?php endif; ?>


                <div class="service-detail-content">

                    <span>
                        OUR SERVICE
                    </span>

                    <h1>
                        <?= htmlspecialchars($service['title']) ?>
                    </h1>

                    <div class="service-description">

                        <?= nl2br(
                            htmlspecialchars($service['description'])
                        ) ?>

                    </div>

                    <a href="#contact" class="primary-btn">
                        Contact Us
                    </a>

                </div>

            </div>

        </div>

    </section>

</main>

<?php include "../includes/footer.php"; ?>