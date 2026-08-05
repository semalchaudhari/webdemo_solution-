<?php

require_once "../config/auth.php";

$page = 'reviews';

require_once "../config/dbconn.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int) $_GET['id'];


// Fetch review

$stmt = $conn->prepare(
    "SELECT id, customer_name, review, rating
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

$reviewData = $result->fetch_assoc();

$stmt->close();


$error = "";


// Update

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $customer_name = trim($_POST['customer_name']);
    $review = trim($_POST['review']);
    $rating = (int) $_POST['rating'];


    if ($customer_name === "" || $review === "") {

        $error = "All fields are required.";

    } elseif ($rating < 1 || $rating > 5) {

        $error = "Rating must be between 1 and 5.";

    } else {

        $stmt = $conn->prepare(
            "UPDATE reviews
             SET customer_name = ?,
                 review = ?,
                 rating = ?
             WHERE id = ?"
        );

        $stmt->bind_param(
            "ssii",
            $customer_name,
            $review,
            $rating,
            $id
        );


        if ($stmt->execute()) {

            header("Location: view.php?id=" . $id);

            exit;

        } else {

            $error = "Failed to update review.";
        }

        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Review</title>

    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/review-edit.css">

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>

<?php include "../includes/sidebar.php"; ?>


<main class="admin-main">

    <div class="page-header">

        <div>

            <h1>Edit Review</h1>

            <p>
                Update customer review information.
            </p>

        </div>

        <a href="index.php" class="back-btn">

            <i class="fa-solid fa-arrow-left"></i>

            Back

        </a>

    </div>


    <div class="form-container">

        <?php if ($error): ?>

            <div class="error-message">
                <?= htmlspecialchars($error) ?>
            </div>

        <?php endif; ?>


        <form method="POST">


            <div class="form-group">

                <label for="customer_name">
                    Customer Name
                </label>

                <input
                    type="text"
                    id="customer_name"
                    name="customer_name"
                    value="<?= htmlspecialchars($reviewData['customer_name']) ?>"
                    required>

            </div>


            <div class="form-group">

                <label for="rating">
                    Rating
                </label>

                <select
                    id="rating"
                    name="rating"
                    required>

                    <option value="5" <?= $reviewData['rating'] == 5 ? 'selected' : '' ?>>
                        ★★★★★ - 5 Stars
                    </option>

                    <option value="4" <?= $reviewData['rating'] == 4 ? 'selected' : '' ?>>
                        ★★★★☆ - 4 Stars
                    </option>

                    <option value="3" <?= $reviewData['rating'] == 3 ? 'selected' : '' ?>>
                        ★★★☆☆ - 3 Stars
                    </option>

                    <option value="2" <?= $reviewData['rating'] == 2 ? 'selected' : '' ?>>
                        ★★☆☆☆ - 2 Stars
                    </option>

                    <option value="1" <?= $reviewData['rating'] == 1 ? 'selected' : '' ?>>
                        ★☆☆☆☆ - 1 Star
                    </option>

                </select>

            </div>


            <div class="form-group">

                <label for="review">
                    Review
                </label>

                <textarea
                    id="review"
                    name="review"
                    rows="7"
                    required><?= htmlspecialchars($reviewData['review']) ?></textarea>

            </div>


            <div class="form-actions">

                <a href="view.php?id=<?= $id ?>" class="cancel-btn">
                    Cancel
                </a>

                <button type="submit" class="save-btn">

                    <i class="fa-solid fa-check"></i>

                    Update Review

                </button>

            </div>

        </form>

    </div>

</main>

</body>

</html>