<?php

require_once "../config/auth.php";

$page = 'services';

require_once "../config/dbconn.php";


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
| Fetch Service
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

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>
        <?= htmlspecialchars($service['title']) ?> - Service
    </title>


    <!-- Sidebar CSS -->

    <link
        rel="stylesheet"
        href="../css/sidebar.css">


    <!-- Font Awesome -->

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">


    <!-- View Service CSS -->

    <link
        rel="stylesheet"
        href="../css/service-view.css">

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
                    Service Details
                </h1>

                <p>
                    View complete information about this service.
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
             SERVICE CARD
        ========================== -->

        <div class="service-card">


            <!-- =========================
                 IMAGE
            ========================== -->

            <div class="service-image-section">

                <?php if (!empty($service['image'])): ?>

                    <img
                        src="../../upload/services/<?= htmlspecialchars($service['image']) ?>"
                        alt="<?= htmlspecialchars($service['title']) ?>"
                        class="service-image">

                <?php else: ?>

                    <div class="no-image">

                        <i class="fa-regular fa-image"></i>

                        <span>
                            No Image
                        </span>

                    </div>

                <?php endif; ?>

            </div>


            <!-- =========================
                 SERVICE INFORMATION
            ========================== -->

            <div class="service-details">


                <!-- TITLE -->

                <div class="detail-group">

                    <span class="detail-label">
                        Service Name
                    </span>

                    <h2>
                        <?= htmlspecialchars($service['title']) ?>
                    </h2>

                </div>


                <!-- DESCRIPTION -->

                <div class="detail-group">

                    <span class="detail-label">
                        Description
                    </span>

                    <p class="service-description">

                        <?= nl2br(
                            htmlspecialchars($service['description'])
                        ) ?>

                    </p>

                </div>


                <!-- CREATED DATE -->

                <div class="detail-group">

                    <span class="detail-label">
                        Created On
                    </span>

                    <p class="created-date">

                        <i class="fa-regular fa-calendar"></i>

                        <?= date(
                            'd M Y, h:i A',
                            strtotime($service['created_at'])
                        ) ?>

                    </p>

                </div>


                <!-- SERVICE ID -->

                <div class="detail-group">

                    <span class="detail-label">
                        Service ID
                    </span>

                    <p class="service-id">
                        #<?= htmlspecialchars($service['id']) ?>
                    </p>

                </div>


            </div>


        </div>


        <!-- =========================
             ACTIONS
        ========================== -->

        <div class="service-actions">


            <a
                href="edit.php?id=<?= $service['id'] ?>"
                class="edit-btn">

                <i class="fa-solid fa-pen"></i>

                Edit Service

            </a>


            <a
                href="delete.php?id=<?= $service['id'] ?>"
                class="delete-btn"
                onclick="return confirm('Are you sure you want to delete this service?');">

                <i class="fa-solid fa-trash"></i>

                Delete Service

            </a>


        </div>


    </main>


</body>

</html>