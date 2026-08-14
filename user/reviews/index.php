<?php

$page = 'reviews';
$page_title = 'Reviews | WebDemo Solutions';

require_once "../../admin/config/dbconn.php";

$sql = "
    SELECT id, customer_name, review, rating
    FROM reviews
    ORDER BY created_at DESC
";

$result = $conn->query($sql);

include "../includes/header.php";

?>

<link rel="stylesheet" href="/demoweb/user/css/review.css">
<link rel="stylesheet" href="/demoweb/user/css/footer.css">


<main>

    <section class="reviews-banner">

        <div>

            <span>CUSTOMER FEEDBACK</span>

            <h1>What Our Customers Say</h1>

            <p>
                See what our customers have to say about our services.
            </p>

        </div>

    </section>


    <section class="reviews-page">

        <div class="reviews-container">

            <div class="reviews-grid">

                <?php while ($review = $result->fetch_assoc()): ?>

                    <article class="review-page-card">

                        <div class="review-stars">

                            <?php for ($i = 1; $i <= 5; $i++): ?>

                                <i class="fa-solid fa-star
                                    <?= $i <= $review['rating'] ? 'filled' : '' ?>">
                                </i>

                            <?php endfor; ?>

                        </div>

                        <p>
                            "<?= htmlspecialchars($review['review']) ?>"
                        </p>

                        <h3>
                            <?= htmlspecialchars($review['customer_name']) ?>
                        </h3>

                    </article>

                <?php endwhile; ?>

            </div>

        </div>

    </section>

</main>

<?php include "../includes/footer.php"; ?>