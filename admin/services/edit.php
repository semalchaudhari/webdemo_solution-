<?php
require_once "../config/auth.php";

$page = 'services';

require_once "../config/dbconn.php";

$message = '';
$messageType = '';
$uploadDir ="../../upload/services/";

/*
|--------------------------------------------------------------------------
| Get Service ID
|--------------------------------------------------------------------------
*/

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    header("Location: index.php");
    exit;
}


/*
|--------------------------------------------------------------------------
| Fetch Existing Service
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare(
    "SELECT id, title, description, image, created_at
     FROM services
     WHERE id = ?"
);

$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 0) {

    $stmt->close();

    header("Location: index.php");
    exit;
}

$service = $result->fetch_assoc();

$stmt->close();


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
    | Validation
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
        | Existing Image
        |--------------------------------------------------------------------------
        */

        $oldImage = $service['image'];

        $newImage = $oldImage;

        $newImageUploaded = false;

        


        /*
        |--------------------------------------------------------------------------
        | Handle New Image
        |--------------------------------------------------------------------------
        */

        if (
            isset($_FILES['image']) &&
            $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE
        ) {

            if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {

                $file = $_FILES['image'];

                $allowedTypes = [
                    'image/jpeg',
                    'image/png',
                    'image/webp'
                ];


                /*
                | Validate file type
                */

                if (!in_array($file['type'], $allowedTypes)) {

                    $message = "Only JPG, PNG and WEBP images are allowed.";
                    $messageType = "error";

                /*
                | Validate file size
                */

                } elseif ($file['size'] > 2 * 1024 * 1024) {

                    $message = "Image size must be less than 2MB.";
                    $messageType = "error";

                } else {

                    /*
                    |--------------------------------------------------------------------------
                    | Create Upload Directory
                    |--------------------------------------------------------------------------
                    */

                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Generate New Image Name
                    |--------------------------------------------------------------------------
                    */

                    $extension = strtolower(
                        pathinfo($file['name'], PATHINFO_EXTENSION)
                    );

                    $newImage = uniqid('service_', true) . '.' . $extension;

                    $uploadPath = $uploadDir . $newImage;


                    /*
                    |--------------------------------------------------------------------------
                    | Move Uploaded Image
                    |--------------------------------------------------------------------------
                    */

                    if (move_uploaded_file(
                        $file['tmp_name'],
                        $uploadPath
                    )) {

                        $newImageUploaded = true;

                    } else {

                        $message = "Failed to upload the new image.";
                        $messageType = "error";
                    }
                }

            } else {

                $message = "There was an error uploading the image.";
                $messageType = "error";
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Update Database
        |--------------------------------------------------------------------------
        */

        if ($message === '') {

            $stmt = $conn->prepare(
                "UPDATE services
                 SET title = ?, description = ?, image = ?
                 WHERE id = ?"
            );

            if ($stmt) {

                $stmt->bind_param(
                    "sssi",
                    $title,
                    $description,
                    $newImage,
                    $id
                );


                if ($stmt->execute()) {

                    /*
                    |--------------------------------------------------------------------------
                    | Delete Old Image
                    |--------------------------------------------------------------------------
                    */

                    if (
                        $newImageUploaded &&
                        !empty($oldImage)
                    ) {

                        $oldImagePath = $uploadDir . $oldImage;

                        if (file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Redirect
                    |--------------------------------------------------------------------------
                    */

                    header("Location: view.php?id=" . $id);
                    exit;

                } else {

                    /*
                    | If DB update fails, delete newly uploaded image
                    */

                    if (
                        $newImageUploaded &&
                        file_exists($uploadDir . $newImage)
                    ) {

                        unlink($uploadDir . $newImage);
                    }

                    $message = "Failed to update service.";
                    $messageType = "error";
                }

                $stmt->close();

            } else {

                $message = "Database error.";
                $messageType = "error";
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Keep submitted values in form if validation fails
    |--------------------------------------------------------------------------
    */

    $service['title'] = $title;
    $service['description'] = $description;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>
        Edit <?= htmlspecialchars($service['title']) ?>
    </title>


    <!-- Sidebar CSS -->

    <link
        rel="stylesheet"
        href="../css/sidebar.css">


    <!-- Font Awesome -->

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">


    <!-- Edit Service CSS -->

    <link
        rel="stylesheet"
        href="../css/service-edit.css">

</head>


<body>


    <?php include "../includes/sidebar.php"; ?>


    <main class="admin-main">


        <!-- =========================
             PAGE HEADER
        ========================== -->

        <div class="page-header">

            <div>

                <h1>
                    Edit Service
                </h1>

                <p>
                    Update the information for this service.
                </p>

            </div>


            <a
                href="view.php?id=<?= $service['id'] ?>"
                class="back-btn">

                <i class="fa-solid fa-arrow-left"></i>

                Back to Service

            </a>

        </div>


        <!-- =========================
             ALERT
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
                        value="<?= htmlspecialchars($service['title']) ?>"
                        placeholder="Enter service name"
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
                        required><?= htmlspecialchars($service['description']) ?></textarea>

                    <small>
                        Update the description of this service.
                    </small>

                </div>


                <!-- =========================
                     CURRENT IMAGE
                ========================== -->

                <div class="form-group">

                    <label>
                        Current Image
                    </label>


                    <?php if (!empty($service['image'])): ?>

                        <div class="current-image">

                            <img
                                src="../../upload/services/<?= htmlspecialchars($service['image']) ?>"
                                alt="<?= htmlspecialchars($service['title']) ?>">

                        </div>

                    <?php else: ?>

                        <div class="no-image">

                            <i class="fa-regular fa-image"></i>

                            <span>
                                No image uploaded
                            </span>

                        </div>

                    <?php endif; ?>

                </div>


                <!-- =========================
                     NEW IMAGE
                ========================== -->

                <div class="form-group">

                    <label for="image">
                        Change Image
                    </label>

                    <div class="upload-box">

                        <i class="fa-regular fa-image"></i>

                        <p>
                            Select a new image
                        </p>

                        <small>
                            Leave empty to keep the current image.
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
                        href="view.php?id=<?= $service['id'] ?>"
                        class="cancel-btn">

                        Cancel

                    </a>


                    <button
                        type="submit"
                        class="submit-btn">

                        <i class="fa-solid fa-floppy-disk"></i>

                        Save Changes

                    </button>

                </div>


            </form>

        </div>


    </main>


</body>

</html>