<?php

require_once "../config/auth.php";
require_once "../config/dbconn.php";

$page = 'sliders';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    header("Location: index.php");
    exit;
}


/* GET CURRENT SLIDER */

$stmt = $conn->prepare(
    "SELECT id, title, description, image
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

$error = "";


/* UPDATE */

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $title = trim($_POST['title'] ?? "");
    $description = trim($_POST['description'] ?? "");

    if ($title === "" || $description === "") {

        $error = "Please fill all required fields.";

    } else {

        $imageName = $slider['image'];

        if (
            isset($_FILES['image']) &&
            $_FILES['image']['error'] === UPLOAD_ERR_OK
        ) {

            $allowed = ['jpg', 'jpeg', 'png', 'webp'];

            $extension = strtolower(
                pathinfo(
                    $_FILES['image']['name'],
                    PATHINFO_EXTENSION
                )
            );

            if (!in_array($extension, $allowed)) {

                $error = "Invalid image format.";

            } else {

                $newName =
                    uniqid("slider_", true)
                    . "."
                    . $extension;

                $uploadDir = "../../upload/sliders/";

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                if (move_uploaded_file(
                    $_FILES['image']['tmp_name'],
                    $uploadDir . $newName
                )) {

                    if (
                        !empty($slider['image']) &&
                        file_exists($uploadDir . $slider['image'])
                    ) {
                        unlink($uploadDir . $slider['image']);
                    }

                    $imageName = $newName;

                } else {

                    $error = "Unable to upload new image.";

                }
            }
        }


        if ($error === "") {

            $stmt = $conn->prepare(
                "UPDATE sliders
                 SET title = ?, description = ?, image = ?
                 WHERE id = ?"
            );

            $stmt->bind_param(
                "sssi",
                $title,
                $description,
                $imageName,
                $id
            );

            if ($stmt->execute()) {

                header("Location: view.php?id=" . $id);
                exit;

            } else {

                $error = "Unable to update slider.";

            }

            $stmt->close();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Edit Slider</title>

<link rel="stylesheet" href="../css/sidebar.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

<link rel="stylesheet" href="../css/slider-edit.css">

</head>

<body>

<?php include "../includes/sidebar.php"; ?>

<main class="admin-main">

    <div class="page-header">

        <div>
            <h1>Edit Slider</h1>
            <p>Update slider information.</p>
        </div>

        <a href="view.php?id=<?= $id ?>" class="back-btn">
            <i class="fa-solid fa-arrow-left"></i>
            Back
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

                <label>Slider Title</label>

                <input
                    type="text"
                    name="title"
                    value="<?= htmlspecialchars($slider['title']) ?>"
                    required>

            </div>


            <div class="form-group">

                <label>Description</label>

                <textarea
                    name="description"
                    rows="6"
                    required><?= htmlspecialchars($slider['description']) ?></textarea>

            </div>


            <div class="form-group">

                <label>Current Image</label>

                <?php if (!empty($slider['image'])): ?>

                    <img
                        class="current-image"
                        src="../../upload/sliders/<?= htmlspecialchars($slider['image']) ?>"
                        alt="Current slider">

                <?php endif; ?>

            </div>


            <div class="form-group">

                <label>Replace Image</label>

                <input
                    type="file"
                    name="image"
                    accept=".jpg,.jpeg,.png,.webp">

            </div>


            <div class="form-actions">

                <a href="view.php?id=<?= $id ?>" class="cancel-btn">
                    Cancel
                </a>

                <button type="submit" class="save-btn">
                    <i class="fa-solid fa-check"></i>
                    Update Slider
                </button>

            </div>

        </form>

    </div>

</main>

</body>
</html>