<?php

require_once "../config/auth.php";

$page = 'brands';

require_once "../config/dbconn.php";

$message = '';
$messageType = '';


/*
|--------------------------------------------------------------------------
| Handle Form Submission
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

        $logoName = null;

        $uploadDir = "../../upload/brands/";


        /*
        |--------------------------------------------------------------------------
        | Handle Logo
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


                    $logoName = uniqid(
                        'brand_',
                        true
                    ) . '.' . $extension;


                    $uploadPath = $uploadDir . $logoName;


                    if (!move_uploaded_file(
                        $file['tmp_name'],
                        $uploadPath
                    )) {

                        $message = "Failed to upload the logo.";
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
        | Insert Brand
        |--------------------------------------------------------------------------
        */

        if ($message === '') {

            $stmt = $conn->prepare(
                "INSERT INTO brands (name, logo)
                 VALUES (?, ?)"
            );


            if ($stmt) {

                $stmt->bind_param(
                    "ss",
                    $name,
                    $logoName
                );


                if ($stmt->execute()) {

                    $brandId = $stmt->insert_id;

                    $stmt->close();

                    header(
                        "Location: view.php?id=" . $brandId
                    );

                    exit;

                } else {

                    /*
                    | Delete uploaded logo if DB insert fails
                    */

                    if (
                        $logoName !== null &&
                        file_exists($uploadDir . $logoName)
                    ) {

                        unlink($uploadDir . $logoName);
                    }


                    $message = "Failed to add brand.";
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

    <title>Add Brand</title>


    <link
        rel="stylesheet"
        href="../css/sidebar.css">


    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">


    <link
        rel="stylesheet"
        href="../css/brand-add.css">

</head>

<body>


<?php include "../includes/sidebar.php"; ?>


<main class="admin-main">


    <div class="page-header">

        <div>

            <h1>Add Brand</h1>

            <p>
                Add a new brand to your website.
            </p>

        </div>


        <a
            href="index.php"
            class="back-btn">

            <i class="fa-solid fa-arrow-left"></i>

            Back to Brands

        </a>

    </div>


    <?php if ($message !== ''): ?>

        <div class="alert <?= $messageType ?>">

            <i class="fa-solid fa-circle-exclamation"></i>

            <?= htmlspecialchars($message) ?>

        </div>

    <?php endif; ?>


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
                    value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"
                    placeholder="Enter brand name"
                    required>

            </div>


            <!-- LOGO -->

            <div class="form-group">

                <label for="logo">

                    Brand Logo

                </label>


                <div class="upload-box">

                    <i class="fa-regular fa-image"></i>


                    <p>
                        Upload brand logo
                    </p>


                    <small>
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
                    href="index.php"
                    class="cancel-btn">

                    Cancel

                </a>


                <button
                    type="submit"
                    class="submit-btn">

                    <i class="fa-solid fa-plus"></i>

                    Add Brand

                </button>


            </div>


        </form>

    </div>


</main>


</body>

</html>