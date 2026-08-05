<?php

require_once "../config/auth.php";
require_once "../config/dbconn.php";

$page = 'gallery';

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $title = trim($_POST['title'] ?? "");

    if (
        !isset($_FILES['image']) ||
        $_FILES['image']['error'] !== UPLOAD_ERR_OK
    ) {

        $error = "Please select an image.";

    } else {

        $allowed = ['jpg', 'jpeg', 'png', 'webp'];

        $extension = strtolower(
            pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION)
        );

        if (!in_array($extension, $allowed)) {

            $error = "Only JPG, JPEG, PNG and WEBP images are allowed.";

        } else {

            $newName =
                uniqid("gallery_", true)
                . "."
                . $extension;

            $uploadDir = "../../upload/gallery/";

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            if (move_uploaded_file(
                $_FILES['image']['tmp_name'],
                $uploadDir . $newName
            )) {

                $stmt = $conn->prepare(
                    "INSERT INTO gallery (title, image)
                     VALUES (?, ?)"
                );

                $stmt->bind_param(
                    "ss",
                    $title,
                    $newName
                );

                if ($stmt->execute()) {

                    header("Location: index.php");
                    exit;

                }

                $stmt->close();

            } else {

                $error = "Unable to upload image.";

            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Add Gallery Photo</title>

<link rel="stylesheet" href="../css/sidebar.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

<link rel="stylesheet" href="../css/gallery-add.css">

</head>

<body>

<?php include "../includes/sidebar.php"; ?>

<main class="admin-main">

<div class="page-header">

    <div>
        <h1>Add Photo</h1>
        <p>Add a new photo to your gallery.</p>
    </div>

    <a href="index.php" class="back-btn">
        <i class="fa-solid fa-arrow-left"></i>
        Back to Gallery
    </a>

</div>

<?php if ($error): ?>

<div class="error-message">
    <?= htmlspecialchars($error) ?>
</div>

<?php endif; ?>

<div class="form-card">

<form method="POST" enctype="multipart/form-data">

    <div class="form-group">

        <label>Photo Title</label>

        <input
            type="text"
            name="title"
            placeholder="Optional photo title">

    </div>


    <div class="form-group">

        <label>Photo</label>

        <input
            type="file"
            name="image"
            accept=".jpg,.jpeg,.png,.webp"
            required>

        <small>
            JPG, JPEG, PNG or WEBP.
        </small>

    </div>


    <div class="form-actions">

        <a href="index.php" class="cancel-btn">
            Cancel
        </a>

        <button type="submit" class="save-btn">
            <i class="fa-solid fa-plus"></i>
            Add Photo
        </button>

    </div>

</form>

</div>

</main>

</body>
</html>