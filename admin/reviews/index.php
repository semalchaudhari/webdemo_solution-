<?php

require_once "../config/auth.php";

$page = 'reviews';

require_once "../config/dbconn.php";

$sql = "SELECT id, customer_name, review, rating, created_at, updated_at
        FROM reviews
        ORDER BY created_at DESC";

$result = $conn->query($sql);

if (!$result) {
    die("Failed to fetch reviews.");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Reviews</title>

    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/reviews.css">

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>

<?php include "../includes/sidebar.php"; ?>


<main class="admin-main">

    <!-- HEADER -->

    <div class="page-header">

        <div>

            <h1>Reviews</h1>

            <p>
                Manage customer reviews displayed on your website.
            </p>

        </div>

        <a href="add.php" class="add-btn">

            <i class="fa-solid fa-plus"></i>

            Add Review

        </a>

    </div>


    <!-- TABLE -->

    <div class="table-container">

        <table>

            <thead>

                <tr>

                    <th>#</th>

                    <th>Customer</th>

                    <th>Review</th>

                    <th>Rating</th>

                    <th>Created</th>

                    <th>Actions</th>

                </tr>

            </thead>


            <tbody>

            <?php if ($result->num_rows > 0): ?>

                <?php while ($review = $result->fetch_assoc()): ?>

                    <tr>

                        <!-- ID -->

                        <td>
                            <?= htmlspecialchars($review['id']) ?>
                        </td>


                        <!-- CUSTOMER -->

                        <td>

                            <strong>
                                <?= htmlspecialchars($review['customer_name']) ?>
                            </strong>

                        </td>


                        <!-- REVIEW -->

                        <td>

                            <p class="review-text">

                                <?= htmlspecialchars(
                                    mb_strimwidth(
                                        $review['review'],
                                        0,
                                        100,
                                        '...'
                                    )
                                ) ?>

                            </p>

                        </td>


                        <!-- RATING -->

                        <td>

                            <div class="rating">

                                <?php for ($i = 1; $i <= 5; $i++): ?>

                                    <?php if ($i <= $review['rating']): ?>

                                        <i class="fa-solid fa-star"></i>

                                    <?php else: ?>

                                        <i class="fa-regular fa-star"></i>

                                    <?php endif; ?>

                                <?php endfor; ?>

                            </div>

                        </td>


                        <!-- CREATED -->

                        <td>

                            <?= date(
                                'd M Y',
                                strtotime($review['created_at'])
                            ) ?>

                        </td>


                        <!-- ACTIONS -->

                        <td>

                            <div class="actions">

                                <!-- VIEW -->

                                <a
                                    href="view.php?id=<?= $review['id'] ?>"
                                    class="action-btn view-btn"
                                    title="View">

                                    <i class="fa-solid fa-eye"></i>

                                </a>


                                <!-- EDIT -->

                                <a
                                    href="edit.php?id=<?= $review['id'] ?>"
                                    class="action-btn edit-btn"
                                    title="Edit">

                                    <i class="fa-solid fa-pen"></i>

                                </a>


                                <!-- DELETE -->

                                <a
                                    href="delete.php?id=<?= $review['id'] ?>"
                                    class="action-btn delete-btn"
                                    title="Delete"
                                    onclick="return confirm('Are you sure you want to delete this review?');">

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

                            <i class="fa-solid fa-star"></i>

                        </div>

                        <h3>No Reviews Found</h3>

                        <p>
                            You haven't added any reviews yet.
                        </p>

                        <a href="add.php" class="add-btn">

                            <i class="fa-solid fa-plus"></i>

                            Add Your First Review

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