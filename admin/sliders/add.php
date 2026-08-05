<?php

require_once "../config/auth.php";
require_once "../config/dbconn.php";

$page = 'sliders';

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $title = trim($_POST['title'] ?? "");
    $description = trim($_POST['description'] ?? "");

    if ($title === "" || $description === "") {

        $error = "Please fill all required fields.";

    } elseif (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {

        $error = "Please select a slider image.";

    } else {

        $image = $_FILES['image'];

        $allowed = ['jpg', 'jpeg', 'png', 'webp'];

        $extension = strtolower(
            pathinfo($image['name'], PATHINFO_EXTENSION)
        );

        if (!in_array($extension, $allowed)) {

            $error = "Only JPG, JPEG, PNG and WEBP images are allowed.";

        } else {

            $newName = uniqid("slider_", true) . "." . $extension;

            $uploadDir = "../../upload/sliders/";

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            if (move_uploaded_file(
                $image['tmp_name'],
                $uploadDir . $newName
            )) {

                $stmt = $conn->prepare(
                    "INSERT INTO sliders
                    (title, description, image)
                    VALUES (?, ?, ?)"
                );

                $stmt->bind_param(
                    "sss",
                    $title,
                    $description,
                    $newName
                );

                if ($stmt->execute()) {

                    header("Location: index.php");
                    exit;

                } else {

                    $error = "Unable to add slider.";

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

<title>Add Slider</title>

<link rel="stylesheet" href="../css/sidebar.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

<link rel="stylesheet" href="../css/slider-add.css">

</head>

<body>

<?php include "../includes/sidebar.php"; ?>

<main class="admin-main">

    <div class="page-header">

        <div>
            <h1>Add Slider</h1>
            <p>Create a new homepage slider.</p>
        </div>

        <a href="index.php" class="back-btn">
            <i class="fa-solid fa-arrow-left"></i>
            Back to Sliders
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

                <label>
                    Slider Title
                </label>

                <input
                    type="text"
                    name="title"
                    placeholder="Enter slider title"
                    required>

            </div>


            <div class="form-group">

                <label>
                    Description
                </label>

                <textarea
                    name="description"
                    rows="5"
                    placeholder="Enter slider description"
                    required></textarea>

            </div>


            <div class="form-group">

                <label>
                    Slider Image
                </label>

                <input
                    type="file"
                    name="image"
                    accept=".jpg,.jpeg,.png,.webp"
                    required>

                <small>
                    Recommended: large landscape image.
                </small>

            </div>


            <div class="form-actions">

                <a href="index.php" class="cancel-btn">
                    Cancel
                </a>

                <button type="submit" class="save-btn">
                    <i class="fa-solid fa-plus"></i>
                    Add Slider
                </button>

            </div>

        </form>

    </div>

</main>

</body>
</html>