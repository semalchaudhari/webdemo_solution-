<?php

require_once "../config/auth.php";

$page = 'services';

require_once "../config/dbconn.php";

$message = '';
$messageType = '';
$uploadDir ="../../upload/services/";

/*
|--------------------------------------------------------------------------
| Handle Form Submission
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');

    /*
    |--------------------------------------------------------------------------
    | Basic Validation
    |--------------------------------------------------------------------------
    */

    if ($title === '') {

        $message = "Service title is required.";
        $messageType = "error";

    } elseif ($description === '') {

        $message = "Service description is required.";
        $messageType = "error";

    } else {

        /*
        |--------------------------------------------------------------------------
        | Handle Image Upload
        |--------------------------------------------------------------------------
        */

        $imageName = null;

        if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {

            if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {

                $file = $_FILES['image'];

                $allowedTypes = [
                    'image/jpeg',
                    'image/png',
                    'image/webp'
                ];

                if (!in_array($file['type'], $allowedTypes)) {

                    $message = "Only JPG, PNG and WEBP images are allowed.";
                    $messageType = "error";

                } elseif ($file['size'] > 2 * 1024 * 1024) {

                    $message = "Image size must be less than 2MB.";
                    $messageType = "error";

                } else {

                    /*
                    |--------------------------------------------------------------------------
                    | Create Upload Directory
                    |--------------------------------------------------------------------------
                    */

                    // $uploadDir = "../../upload/services/";

                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Generate Unique File Name
                    |--------------------------------------------------------------------------
                    */

                    $extension = strtolower(
                        pathinfo($file['name'], PATHINFO_EXTENSION)
                    );

                    $imageName = uniqid('service_', true) . '.' . $extension;

                    $uploadPath = $uploadDir . $imageName;

                    if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {

                        $message = "Failed to upload image.";
                        $messageType = "error";
                        $imageName = null;
                    }
                }

            } else {

                $message = "There was an error uploading the image.";
                $messageType = "error";
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Insert Service
        |--------------------------------------------------------------------------
        */

        if ($message === '') {

            $stmt = $conn->prepare(
                "INSERT INTO services (title, description, image)
                 VALUES (?, ?, ?)"
            );

            if ($stmt) {

                $stmt->bind_param(
                    "sss",
                    $title,
                    $description,
                    $imageName
                );

                if ($stmt->execute()) {

                    header("Location: index.php");
                    exit;

                } else {

                    /*
                    | Delete uploaded image if database insertion fails
                    */

                    if ($imageName && file_exists($uploadDir . $imageName)) {
                        unlink($uploadDir . $imageName);
                    }

                    $message = "Failed to add service.";
                    $messageType = "error";
                }

                $stmt->close();

            } else {

                $message = "Database error.";
                $messageType = "error";
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Add Service</title>

    <!-- Sidebar CSS -->
    <link
        rel="stylesheet"
        href="../css/sidebar.css">

    <!-- Font Awesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- Add Service CSS -->
    <link
        rel="stylesheet"
        href="../css/service-add.css">

</head>

<body>

    <?php include "../includes/sidebar.php"; ?>


    <main class="admin-main">

        <!-- =========================
             PAGE HEADER
        ========================== -->

        <div class="page-header">

            <div>

                <h1>Add Service</h1>

                <p>
                    Add a new service to your website.
                </p>

            </div>

            <a
                href="index.php"
                class="back-btn">

                <i class="fa-solid fa-arrow-left"></i>

                Back to Services

            </a>

        </div>


        <!-- =========================
             MESSAGE
        ========================== -->

        <?php if ($message !== ''): ?>

            <div class="alert <?= $messageType ?>">

                <i class="fa-solid fa-circle-exclamation"></i>

                <span>
                    <?= htmlspecialchars($message) ?>
                </span>

            </div>

        <?php endif; ?>


        <!-- =========================
             FORM CARD
        ========================== -->

        <div class="form-card">

            <form
                method="POST"
                enctype="multipart/form-data">


                <!-- =========================
                     SERVICE TITLE
                ========================== -->

                <div class="form-group">

                    <label for="title">
                        Service Name
                        <span>*</span>
                    </label>

                    <input
                        type="text"
                        id="title"
                        name="title"
                        placeholder="Enter service name"
                        value="<?= htmlspecialchars($_POST['title'] ?? '') ?>"
                        required>

                </div>


                <!-- =========================
                     DESCRIPTION
                ========================== -->

                <div class="form-group">

                    <label for="description">
                        Description
                        <span>*</span>
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        rows="7"
                        placeholder="Enter service description"
                        required><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>

                    <small>
                        Provide a short description of this service.
                    </small>

                </div>


                <!-- =========================
                     IMAGE
                ========================== -->

                <div class="form-group">

                    <label for="image">
                        Service Image
                    </label>

                    <div class="upload-box">

                        <i class="fa-regular fa-image"></i>

                        <p>
                            Choose an image for this service
                        </p>

                        <small>
                            JPG, PNG or WEBP — Maximum 2MB
                        </small>

                        <input
                            type="file"
                            id="image"
                            name="image"
                            accept="image/jpeg,image/png,image/webp">

                    </div>

                </div>


                <!-- =========================
                     BUTTONS
                ========================== -->

                <div class="form-actions">

                    <a
                        href="index.php"
                        class="cancel-btn">

                        Cancel

                    </a>

                    <button
                        type="submit"
                        class="submit-btn">

                        <i class="fa-solid fa-plus"></i>

                        Add Service

                    </button>

                </div>


            </form>

        </div>

    </main>

</body>

</html>