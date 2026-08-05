<?php

require_once "../config/auth.php";
require_once "../config/dbconn.php";

$page = 'gallery';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    header("Location: index.php");
    exit;
}

$stmt = $conn->prepare(
    "SELECT id, title, image, created_at, updated_at
     FROM gallery
     WHERE id = ?"
);

$stmt->bind_param("i", $id);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: index.php");
    exit;
}

$photo = $result->fetch_assoc();

$stmt->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>View Gallery Photo</title>

<link rel="stylesheet" href="../css/sidebar.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

<link rel="stylesheet" href="../css/gallery-view.css">

</head>

<body>

<?php include "../includes/sidebar.php"; ?>

<main class="admin-main">

<div class="page-header">

    <div>
        <h1>Photo Details</h1>
        <p>View gallery photo information.</p>
    </div>

    <a href="index.php" class="back-btn">
        <i class="fa-solid fa-arrow-left"></i>
        Back to Gallery
    </a>

</div>


<div class="photo-card">

    <div class="photo-section">

        <img
            src="../../upload/gallery/<?= htmlspecialchars($photo['image']) ?>"
            alt="<?= htmlspecialchars($photo['title'] ?? '') ?>">

    </div>


    <div class="photo-details">

        <span>Photo Title</span>

        <h2>
            <?= !empty($photo['title'])
                ? htmlspecialchars($photo['title'])
                : 'Untitled Photo' ?>
        </h2>


        <span>Created On</span>

        <p>
            <i class="fa-regular fa-calendar"></i>

            <?= date(
                'd M Y, h:i A',
                strtotime($photo['created_at'])
            ) ?>
        </p>


        <span>Photo ID</span>

        <p>
            #<?= htmlspecialchars($photo['id']) ?>
        </p>

    </div>

</div>


<div class="actions">

    <a
        href="edit.php?id=<?= $photo['id'] ?>"
        class="edit-btn">

        <i class="fa-solid fa-pen"></i>
        Edit Photo

    </a>

    <a
        href="delete.php?id=<?= $photo['id'] ?>"
        class="delete-btn"
        onclick="return confirm('Are you sure you want to delete this photo?');">

        <i class="fa-solid fa-trash"></i>
        Delete Photo

    </a>

</div>

</main>

</body>
</html>