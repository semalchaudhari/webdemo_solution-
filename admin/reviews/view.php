<?php

require_once "../config/auth.php";

$page = 'reviews';

require_once "../config/dbconn.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int) $_GET['id'];

$stmt = $conn->prepare(
    "SELECT id, customer_name, review, rating, created_at, updated_at
     FROM reviews
     WHERE id = ?"
);

$stmt->bind_param("i", $id);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: index.php");
    exit;
}

$review = $result->fetch_assoc();

$stmt->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>View Review</title>

    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/review-view.css">

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>

<?php include "../includes/sidebar.php"; ?>


<main class="admin-main">

    <div class="page-header">

        <div>

            <h1>Review Details</h1>

            <p>
                View complete review information.
            </p>

        </div>

        <a href="index.php" class="back-btn">

            <i class="fa-solid fa-arrow-left"></i>

            Back

        </a>

    </div>


    <div class="review-card">


        <div class="customer-section">

            <div class="customer-avatar">

                <?= strtoupper(
                    substr($review['customer_name'], 0, 1)
                ) ?>

            </div>


            <div>

                <h2>
                    <?= htmlspecialchars($review['customer_name']) ?>
                </h2>

                <div class="rating">

                    <?php for ($i = 1; $i <= 5; $i++): ?>

                        <?php if ($i <= $review['rating']): ?>

                            <i class="fa-solid fa-star"></i>

                        <?php else: ?>

                            <i class="fa-regular fa-star"></i>

                        <?php endif; ?>

                    <?php endfor; ?>

                    <span>
                        <?= $review['rating'] ?>/5
                    </span>

                </div>

            </div>

        </div>


        <div class="review-content">

            <h3>Review</h3>

            <p>
                <?= nl2br(
                    htmlspecialchars($review['review'])
                ) ?>
            </p>

        </div>


        <div class="review-meta">

            <div>

                <span>Review ID</span>

                <strong>
                    #<?= htmlspecialchars($review['id']) ?>
                </strong>

            </div>


            <div>

                <span>Created</span>

                <strong>
                    <?= date(
                        'd M Y, h:i A',
                        strtotime($review['created_at'])
                    ) ?>
                </strong>

            </div>


            <div>

                <span>Last Updated</span>

                <strong>
                    <?= date(
                        'd M Y, h:i A',
                        strtotime($review['updated_at'])
                    ) ?>
                </strong>

            </div>

        </div>


        <div class="review-actions">

            <a
                href="edit.php?id=<?= $review['id'] ?>"
                class="edit-btn">

                <i class="fa-solid fa-pen"></i>

                Edit Review

            </a>


            <a
                href="delete.php?id=<?= $review['id'] ?>"
                class="delete-btn"
                onclick="return confirm('Are you sure you want to delete this review?');">

                <i class="fa-solid fa-trash"></i>

                Delete Review

            </a>

        </div>

    </div>

</main>

</body>

</html>