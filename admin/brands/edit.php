<?php

require_once "../config/auth.php";

$page = 'brands';

require_once "../config/dbconn.php";

$message = '';
$messageType = '';


/*
|--------------------------------------------------------------------------
| Get ID
|--------------------------------------------------------------------------
*/

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    header("Location: index.php");
    exit;
}


/*
|--------------------------------------------------------------------------
| Fetch Existing Brand
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare(
    "SELECT id, name, logo, created_at, updated_at
     FROM brands
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


$brand = $result->fetch_assoc();

$stmt->close();


/*
|--------------------------------------------------------------------------
| Handle Update
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name'] ?? '');


    /*
    |--------------------------------------------------------------------------
    | Validation
    |--------------------------------------------------------------------------
    */

    if ($name === '') {

        $message = "Brand name is required.";
        $messageType = "error";

    } else {

        $oldLogo = $brand['logo'];

        $newLogo = $oldLogo;

        $newLogoUploaded = false;

        $uploadDir = "../../upload/brands/";


        /*
        |--------------------------------------------------------------------------
        | New Logo
        |--------------------------------------------------------------------------
        */

        if (
            isset($_FILES['logo']) &&
            $_FILES['logo']['error'] !== UPLOAD_ERR_NO_FILE
        ) {

            if ($_FILES['logo']['error'] === UPLOAD_ERR_OK) {

                $file = $_FILES['logo'];

                $allowedTypes = [
                    'image/jpeg',
                    'image/png',
                    'image/webp'
                ];


                if (!in_array($file['type'], $allowedTypes)) {

                    $message = "Only JPG, PNG and WEBP images are allowed.";
                    $messageType = "error";

                } elseif ($file['size'] > 2 * 1024 * 1024) {

                    $message = "Logo size must be less than 2MB.";
                    $messageType = "error";

                } else {

                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }


                    $extension = strtolower(
                        pathinfo(
                            $file['name'],
                            PATHINFO_EXTENSION
                        )
                    );


                    $newLogo = uniqid(
                        'brand_',
                        true
                    ) . '.' . $extension;


                    $uploadPath = $uploadDir . $newLogo;


                    if (move_uploaded_file(
                        $file['tmp_name'],
                        $uploadPath
                    )) {

                        $newLogoUploaded = true;

                    } else {

                        $message = "Failed to upload the new logo.";
                        $messageType = "error";
                    }
                }

            } else {

                $message = "There was an error uploading the logo.";
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
                "UPDATE brands
                 SET name = ?, logo = ?
                 WHERE id = ?"
            );


            if ($stmt) {

                $stmt->bind_param(
                    "ssi",
                    $name,
                    $newLogo,
                    $id
                );


                if ($stmt->execute()) {


                    /*
                    |--------------------------------------------------------------------------
                    | Delete Old Logo
                    |--------------------------------------------------------------------------
                    */

                    if (
                        $newLogoUploaded &&
                        !empty($oldLogo)
                    ) {

                        $oldLogoPath = $uploadDir . $oldLogo;

                        if (file_exists($oldLogoPath)) {
                            unlink($oldLogoPath);
                        }
                    }


                    $stmt->close();


                    header(
                        "Location: view.php?id=" . $id
                    );

                    exit;

                } else {


                    /*
                    | Delete new logo if DB update fails
                    */

                    if (
                        $newLogoUploaded &&
                        file_exists($uploadDir . $newLogo)
                    ) {

                        unlink($uploadDir . $newLogo);
                    }


                    $message = "Failed to update brand.";
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
    | Keep Submitted Name
    |--------------------------------------------------------------------------
    */

    $brand['name'] = $name;
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
        Edit <?= htmlspecialchars($brand['name']) ?>
    </title>


    <link
        rel="stylesheet"
        href="../css/sidebar.css">


    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">


    <link
        rel="stylesheet"
        href="../css/brand-edit.css">

</head>

<body>


<?php include "../includes/sidebar.php"; ?>


<main class="admin-main">


    <!-- HEADER -->

    <div class="page-header">

        <div>

            <h1>
                Edit Brand
            </h1>

            <p>
                Update the information for this brand.
            </p>

        </div>


        <a
            href="view.php?id=<?= $brand['id'] ?>"
            class="back-btn">

            <i class="fa-solid fa-arrow-left"></i>

            Back to Brand

        </a>

    </div>


    <!-- ALERT -->

    <?php if ($message !== ''): ?>

        <div class="alert <?= $messageType ?>">

            <i class="fa-solid fa-circle-exclamation"></i>

            <span>
                <?= htmlspecialchars($message) ?>
            </span>

        </div>

    <?php endif; ?>


    <!-- FORM -->

    <div class="form-card">

        <form
            method="POST"
            enctype="multipart/form-data">


            <!-- NAME -->

            <div class="form-group">

                <label for="name">

                    Brand Name

                    <span>*</span>

                </label>


                <input
                    type="text"
                    id="name"
                    name="name"
                    value="<?= htmlspecialchars($brand['name']) ?>"
                    placeholder="Enter brand name"
                    required>

            </div>


            <!-- CURRENT LOGO -->

            <div class="form-group">

                <label>
                    Current Logo
                </label>


                <?php if (!empty($brand['logo'])): ?>

                    <div class="current-logo">

                        <img
                            src="../../upload/brands/<?= htmlspecialchars($brand['logo']) ?>"
                            alt="<?= htmlspecialchars($brand['name']) ?>">

                    </div>

                <?php else: ?>

                    <div class="no-logo">

                        <i class="fa-regular fa-image"></i>

                        <span>
                            No logo uploaded
                        </span>

                    </div>

                <?php endif; ?>

            </div>


            <!-- NEW LOGO -->

            <div class="form-group">

                <label for="logo">
                    Change Logo
                </label>


                <div class="upload-box">

                    <i class="fa-regular fa-image"></i>


                    <p>
                        Select a new logo
                    </p>


                    <small>
                        Leave empty to keep the current logo.
                        JPG, PNG or WEBP — Maximum 2MB
                    </small>


                    <input
                        type="file"
                        id="logo"
                        name="logo"
                        accept="image/jpeg,image/png,image/webp">

                </div>

            </div>


            <!-- ACTIONS -->

            <div class="form-actions">


                <a
                    href="view.php?id=<?= $brand['id'] ?>"
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