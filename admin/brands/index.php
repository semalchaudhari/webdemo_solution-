<?php

require_once "../config/auth.php";

$page = 'brands';

require_once "../config/dbconn.php";


/*
|--------------------------------------------------------------------------
| Fetch All Brands
|--------------------------------------------------------------------------
*/

$sql = "SELECT id, name, logo, created_at, updated_at
        FROM brands
        ORDER BY created_at DESC";

$result = $conn->query($sql);

if (!$result) {
    die("Failed to fetch brands.");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Brands</title>


    <!-- Sidebar CSS -->

    <link
        rel="stylesheet"
        href="../css/sidebar.css">


    <!-- Font Awesome -->

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">


    <!-- Brands CSS -->

    <link
        rel="stylesheet"
        href="../css/brands-page.css">

</head>

<body>


    <?php include "../includes/sidebar.php"; ?>


    <main class="admin-main">


        <!-- =========================
             PAGE HEADER
        ========================== -->

        <div class="page-header">

            <div>

                <h1>Brands</h1>

                <p>
                    Manage the brands displayed on your website.
                </p>

            </div>


            <a
                href="add.php"
                class="add-btn">

                <i class="fa-solid fa-plus"></i>

                Add Brand

            </a>

        </div>


        <!-- =========================
             BRANDS TABLE
        ========================== -->

        <div class="table-container">

            <table>

                <thead>

                    <tr>

                        <th>#</th>

                        <th>Logo</th>

                        <th>Brand Name</th>

                        <th>Created</th>

                        <th>Updated</th>

                        <th>Actions</th>

                    </tr>

                </thead>


                <tbody>


                    <?php if ($result->num_rows > 0): ?>


                        <?php while ($brand = $result->fetch_assoc()): ?>

                            <tr>


                                <!-- ID -->

                                <td>
                                    <?= htmlspecialchars($brand['id']) ?>
                                </td>


                                <!-- LOGO -->

                                <td>

                                    <?php if (!empty($brand['logo'])): ?>

                                        <img
                                            src="../../upload/brands/<?= htmlspecialchars($brand['logo']) ?>"
                                            alt="<?= htmlspecialchars($brand['name']) ?>"
                                            class="brand-logo">

                                    <?php else: ?>

                                        <div class="no-logo">

                                            <i class="fa-regular fa-image"></i>

                                        </div>

                                    <?php endif; ?>

                                </td>


                                <!-- NAME -->

                                <td>

                                    <strong>
                                        <?= htmlspecialchars($brand['name']) ?>
                                    </strong>

                                </td>


                                <!-- CREATED -->

                                <td>

                                    <?= date(
                                        'd M Y',
                                        strtotime($brand['created_at'])
                                    ) ?>

                                </td>


                                <!-- UPDATED -->

                                <td>

                                    <?= date(
                                        'd M Y',
                                        strtotime($brand['updated_at'])
                                    ) ?>

                                </td>


                                <!-- ACTIONS -->

                                <td>

                                    <div class="actions">


                                        <!-- VIEW -->

                                        <a
                                            href="view.php?id=<?= $brand['id'] ?>"
                                            class="action-btn view-btn"
                                            title="View">

                                            <i class="fa-solid fa-eye"></i>

                                        </a>


                                        <!-- EDIT -->

                                        <a
                                            href="edit.php?id=<?= $brand['id'] ?>"
                                            class="action-btn edit-btn"
                                            title="Edit">

                                            <i class="fa-solid fa-pen"></i>

                                        </a>


                                        <!-- DELETE -->

                                        <a
                                            href="delete.php?id=<?= $brand['id'] ?>"
                                            class="action-btn delete-btn"
                                            title="Delete"
                                            onclick="return confirm('Are you sure you want to delete this brand?');">

                                            <i class="fa-solid fa-trash"></i>

                                        </a>


                                    </div>

                                </td>

                            </tr>

                        <?php endwhile; ?>


                    <?php else: ?>


                        <tr>

                            <td
                                colspan="6"
                                class="empty-state">

                                <div class="empty-icon">

                                    <i class="fa-solid fa-tags"></i>

                                </div>


                                <h3>
                                    No Brands Found
                                </h3>


                                <p>
                                    You haven't added any brands yet.
                                </p>


                                <a
                                    href="add.php"
                                    class="add-btn">

                                    <i class="fa-solid fa-plus"></i>

                                    Add Your First Brand

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