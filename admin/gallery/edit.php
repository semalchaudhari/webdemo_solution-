<?php
require_once "../config/auth.php";

$page = 'gallery';

require_once "../config/dbconn.php";

$message = '';
$messageType = '';
$uploadDir = "../../upload/gallery/";

/*
|--------------------------------------------------------------------------
| Get Gallery ID
|--------------------------------------------------------------------------
*/

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    header("Location: index.php");
    exit;
}


/*
|--------------------------------------------------------------------------
| Fetch Existing Gallery Item
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare(
    "SELECT id, title, image, created_at
     FROM gallery
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

$gallery = $result->fetch_assoc();

$stmt->close();


/*
|--------------------------------------------------------------------------
| Handle Form Submission
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = trim($_POST['title'] ?? '');

    /*
    |--------------------------------------------------------------------------
    | Validation
    |--------------------------------------------------------------------------
    */

    if ($title === '') {

        $message = "Gallery title is required.";
        $messageType = "error";

    } else {

        /*
        |--------------------------------------------------------------------------
        | Existing Image
        |--------------------------------------------------------------------------
        */

        $oldImage = $gallery['image'];

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

                    $newImage = uniqid('gallery_', true) . '.' . $extension;

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
                "UPDATE gallery
                 SET title = ?, image = ?
                 WHERE id = ?"
            );

            if ($stmt) {

                $stmt->bind_param(
                    "ssi",
                    $title,
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

                    $message = "Failed to update gallery item.";
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

    $gallery['title'] = $title;
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
        Edit <?= htmlspecialchars($gallery['title']) ?>
    </title>


    <!-- Sidebar CSS -->

    <link
        rel="stylesheet"
        href="../css/sidebar.css">


    <!-- Font Awesome -->

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">


    <!-- Edit Gallery CSS -->

    <link
        rel="stylesheet"
        href="../css/gallery-edit.css">

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
                    Edit Gallery Item
                </h1>

                <p>
                    Update the information for this gallery item.
                </p>

            </div>


            <a
                href="view.php?id=<?= $gallery['id'] ?>"
                class="back-btn">

                <i class="fa-solid fa-arrow-left"></i>

                Back to Item

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
                     GALLERY TITLE
                ========================== -->

                <div class="form-group">

                    <label for="title">
                        Title
                        <span>*</span>
                    </label>

                    <input
                        type="text"
                        id="title"
                        name="title"
                        value="<?= htmlspecialchars($gallery['title']) ?>"
                        placeholder="Enter gallery title"
                        required>

                </div>


                <!-- =========================
                     CURRENT IMAGE
                ========================== -->

                <div class="form-group">

                    <label>
                        Current Image
                    </label>


                    <?php if (!empty($gallery['image'])): ?>

                        <div class="current-image">

                            <img
                                src="../../upload/gallery/<?= htmlspecialchars($gallery['image']) ?>"
                                alt="<?= htmlspecialchars($gallery['title']) ?>">

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
                        href="view.php?id=<?= $gallery['id'] ?>"
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