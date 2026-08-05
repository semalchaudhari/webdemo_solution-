<?php

require_once "../config/auth.php";

$page = 'reviews';

require_once "../config/dbconn.php";

$error = "";

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
            "INSERT INTO reviews
            (customer_name, review, rating)
            VALUES (?, ?, ?)"
        );

        $stmt->bind_param(
            "ssi",
            $customer_name,
            $review,
            $rating
        );

        if ($stmt->execute()) {

            header("Location: index.php");

            exit;

        } else {

            $error = "Failed to add review.";
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

    <title>Add Review</title>

    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/review-add.css">

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>

<?php include "../includes/sidebar.php"; ?>


<main class="admin-main">

    <div class="page-header">

        <div>

            <h1>Add Review</h1>

            <p>
                Add a customer review to your website.
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


            <!-- CUSTOMER NAME -->

            <div class="form-group">

                <label for="customer_name">
                    Customer Name
                </label>

                <input
                    type="text"
                    id="customer_name"
                    name="customer_name"
                    placeholder="Enter customer name"
                    required>

            </div>


            <!-- RATING -->

            <div class="form-group">

                <label for="rating">
                    Rating
                </label>

                <select
                    id="rating"
                    name="rating"
                    required>

                    <option value="">Select Rating</option>

                    <option value="5">★★★★★ - 5 Stars</option>

                    <option value="4">★★★★☆ - 4 Stars</option>

                    <option value="3">★★★☆☆ - 3 Stars</option>

                    <option value="2">★★☆☆☆ - 2 Stars</option>

                    <option value="1">★☆☆☆☆ - 1 Star</option>

                </select>

            </div>


            <!-- REVIEW -->

            <div class="form-group">

                <label for="review">
                    Review
                </label>

                <textarea
                    id="review"
                    name="review"
                    rows="6"
                    placeholder="Enter customer review..."
                    required></textarea>

            </div>


            <!-- BUTTONS -->

            <div class="form-actions">

                <a href="index.php" class="cancel-btn">
                    Cancel
                </a>

                <button type="submit" class="save-btn">

                    <i class="fa-solid fa-check"></i>

                    Add Review

                </button>

            </div>

        </form>

    </div>

</main>

</body>

</html>