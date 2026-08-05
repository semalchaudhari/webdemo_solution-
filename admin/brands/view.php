<?php

require_once "../config/auth.php";

$page = 'brands';

require_once "../config/dbconn.php";


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
| Fetch Brand
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

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>
        <?= htmlspecialchars($brand['name']) ?>
    </title>


    <link
        rel="stylesheet"
        href="../css/sidebar.css">


    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">


    <link
        rel="stylesheet"
        href="../css/brand-view.css">

</head>

<body>


<?php include "../includes/sidebar.php"; ?>


<main class="admin-main">


    <!-- HEADER -->

    <div class="page-header">

        <div>

            <h1>
                Brand Details
            </h1>

            <p>
                View information about this brand.
            </p>

        </div>


        <a
            href="index.php"
            class="back-btn">

            <i class="fa-solid fa-arrow-left"></i>

            Back to Brands

        </a>

    </div>


    <!-- BRAND CARD -->

    <div class="brand-card">


        <!-- LOGO -->

        <div class="logo-section">

            <?php if (!empty($brand['logo'])): ?>

                <img
                    src="../../upload/brands/<?= htmlspecialchars($brand['logo'])?>"
                    alt="<?= htmlspecialchars($brand['name']) ?>"
                    class="brand-logo">

            <?php else: ?>

                <div class="no-logo">

                    <i class="fa-regular fa-image"></i>

                </div>

            <?php endif; ?>

        </div>


        <!-- DETAILS -->

        <div class="brand-details">


            <div class="detail-item">

                <span class="detail-label">
                    Brand Name
                </span>

                <strong>
                    <?= htmlspecialchars($brand['name']) ?>
                </strong>

            </div>


            <div class="detail-item">

                <span class="detail-label">
                    Brand ID
                </span>

                <span>
                    #<?= htmlspecialchars($brand['id']) ?>
                </span>

            </div>


            <div class="detail-item">

                <span class="detail-label">
                    Created At
                </span>

                <span>
                    <?= date(
                        'd M Y, h:i A',
                        strtotime($brand['created_at'])
                    ) ?>
                </span>

            </div>


            <div class="detail-item">

                <span class="detail-label">
                    Last Updated
                </span>

                <span>
                    <?= date(
                        'd M Y, h:i A',
                        strtotime($brand['updated_at'])
                    ) ?>
                </span>

            </div>


        </div>


        <!-- ACTIONS -->

        <div class="card-actions">


            <a
                href="edit.php?id=<?= $brand['id'] ?>"
                class="edit-btn">

                <i class="fa-solid fa-pen"></i>

                Edit Brand

            </a>


            <a
                href="delete.php?id=<?= $brand['id'] ?>"
                class="delete-btn"
                onclick="return confirm('Are you sure you want to delete this brand?');">

                <i class="fa-solid fa-trash"></i>

                Delete Brand

            </a>


        </div>


    </div>


</main>


</body>

</html>