<?php
require_once "../config/auth.php";

$page = 'services';

require_once "../config/dbconn.php";



/*
|--------------------------------------------------------------------------
| Fetch all services
|--------------------------------------------------------------------------
*/

$sql = "SELECT id, title, description, image, created_at
        FROM services";

$result = $conn->query($sql);

if (!$result) {
    die("Failed to fetch services.");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Services</title>

    <link rel="stylesheet" href="../css/sidebar.css">


    <!-- Font Awesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- Services CSS -->
    <link rel="stylesheet" href="../css/service.css">

</head>

<body>

    <?php include "../includes/sidebar.php"; ?>

    <!-- <style>
        .admin-main {
            margin-left: 250px !important;
            padding: 35px !important;
            width: calc(100% - 250px) !important;
            min-height: 100vh;
            background: #f5f7fb;
        }
    </style> -->

    <main class="admin-main">

        <div class="page-header">

            <div>
                <h1>Services</h1>

                <p>
                    Manage the services displayed on your website.
                </p>
            </div>

            <a href="add.php" class="add-btn">
                <i class="fa-solid fa-plus"></i>
                Add Service
            </a>

        </div>

        <div class="table-container">

            <table>

                <thead>

                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Service Name</th>
                        <th>Description</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>

                </thead>


                <tbody>

                    <?php if ($result->num_rows > 0): ?>

                        <?php while ($service = $result->fetch_assoc()): ?>

                            <tr>

                                <!-- ID -->

                                <td>
                                    <?= htmlspecialchars($service['id']) ?>
                                </td>


                                <!-- IMAGE -->

                                <td>

                                    <?php if (!empty($service['image'])): ?>

                                        <img
                                            src="../../upload/services/<?= htmlspecialchars($service['image']) ?>"
                                            alt="<?= htmlspecialchars($service['title']) ?>"
                                            class="service-image">

                                    <?php else: ?>

                                        <div class="no-image">
                                            <i class="fa-regular fa-image"></i>
                                        </div>

                                    <?php endif; ?>

                                </td>


                                <!-- SERVICE NAME -->

                                <td>

                                    <strong>
                                        <?= htmlspecialchars($service['title']) ?>
                                    </strong>

                                </td>


                                <!-- DESCRIPTION -->

                                <td>

                                    <p class="description">

                                        <?= htmlspecialchars(
                                            mb_strimwidth(
                                                $service['description'],
                                                0,
                                                80,
                                                '...'
                                            )
                                        ) ?>

                                    </p>

                                </td>


                                <!-- CREATED DATE -->

                                <td>

                                    <?= date(
                                        'd M Y',
                                        strtotime($service['created_at'])
                                    ) ?>

                                </td>


                                <!-- ACTIONS -->

                                <td>

                                    <div class="actions">

                                        <!-- VIEW -->

                                        <a
                                            href="view.php?id=<?= $service['id'] ?>"
                                            class="action-btn view-btn"
                                            title="View">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>


                                        <!-- EDIT -->

                                        <a
                                            href="edit.php?id=<?= $service['id'] ?>"
                                            class="action-btn edit-btn"
                                            title="Edit">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>


                                        <!-- DELETE -->

                                        <a
                                            href="delete.php?id=<?= $service['id'] ?>"
                                            class="action-btn delete-btn"
                                            title="Delete"
                                            onclick="return confirm('Are you sure you want to delete this service?');">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>

                                    </div>

                                </td>

                            </tr>

                        <?php endwhile; ?>

                    <?php else: ?>

                        <tr>

                            <td colspan="6" class="empty-state">

                                <div class="empty-icon">
                                    <i class="fa-solid fa-briefcase"></i>
                                </div>

                                <h3>No Services Found</h3>

                                <p>
                                    You haven't added any services yet.
                                </p>

                                <a href="add.php" class="add-btn">
                                    <i class="fa-solid fa-plus"></i>
                                    Add Your First Service
                                </a>

                            </td>

                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>


        </div>

    </main>

</body>

</html>