<?php

require_once "../config/auth.php";
require_once "../config/dbconn.php";

$page = 'sliders';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    header("Location: index.php");
    exit;
}

$stmt = $conn->prepare(
    "SELECT id, title, description, image, created_at, updated_at
     FROM sliders
     WHERE id = ?"
);

$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: index.php");
    exit;
}

$slider = $result->fetch_assoc();

$stmt->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>View Slider</title>

<link rel="stylesheet" href="../css/sidebar.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

<link rel="stylesheet" href="../css/slider-view.css">

</head>

<body>

<?php include "../includes/sidebar.php"; ?>

<main class="admin-main">

    <div class="page-header">

        <div>
            <h1>Slider Details</h1>
            <p>View complete information about this slider.</p>
        </div>

        <a href="index.php" class="back-btn">
            <i class="fa-solid fa-arrow-left"></i>
            Back to Sliders
        </a>

    </div>


    <div class="slider-card">

        <div class="slider-image-section">

            <?php if (!empty($slider['image'])): ?>

                <img
                    src="../../upload/sliders/<?= htmlspecialchars($slider['image']) ?>"
                    alt="<?= htmlspecialchars($slider['title']) ?>">

            <?php endif; ?>

        </div>


        <div class="slider-details">

            <span class="detail-label">
                Slider Title
            </span>

            <h2>
                <?= htmlspecialchars($slider['title']) ?>
            </h2>


            <span class="detail-label">
                Description
            </span>

            <p class="description">
                <?= nl2br(htmlspecialchars($slider['description'])) ?>
            </p>


            <span class="detail-label">
                Created On
            </span>

            <p class="date">
                <i class="fa-regular fa-calendar"></i>

                <?= date(
                    'd M Y, h:i A',
                    strtotime($slider['created_at'])
                ) ?>
            </p>


            <span class="detail-label">
                Slider ID
            </span>

            <p>
                #<?= htmlspecialchars($slider['id']) ?>
            </p>

        </div>

    </div>


    <div class="actions">

        <a href="edit.php?id=<?= $slider['id'] ?>" class="edit-btn">
            <i class="fa-solid fa-pen"></i>
            Edit Slider
        </a>

        <a
            href="delete.php?id=<?= $slider['id'] ?>"
            class="delete-btn"
            onclick="return confirm('Are you sure you want to delete this slider?');">

            <i class="fa-solid fa-trash"></i>
            Delete Slider

        </a>

    </div>

</main>

</body>
</html>