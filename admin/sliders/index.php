<?php

require_once "../config/auth.php";
require_once "../config/dbconn.php";

$page = 'sliders';
$page_title = 'Sliders | WebDemo Solutions';

$sql = "
    SELECT id, title, description, image, created_at
    FROM sliders
    ORDER BY created_at DESC
";

$result = $conn->query($sql);

if (!$result) {
    die("Unable to load sliders.");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($page_title) ?></title>

    <link rel="stylesheet" href="../css/sidebar.css">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <link rel="stylesheet" href="../css/sliders.css">

</head>

<body>

<?php include "../includes/sidebar.php"; ?>


<main class="admin-main">

    <div class="page-header">

        <div>
            <h1>Sliders</h1>

            <p>
                Manage the sliders displayed on your website.
            </p>
        </div>

        <a href="add.php" class="add-btn">
            <i class="fa-solid fa-plus"></i>
            Add Slider
        </a>

    </div>


    <div class="table-container">

        <?php if ($result->num_rows > 0): ?>

            <table>

                <thead>

                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>

                </thead>

                <tbody>

                <?php $i = 1; ?>

                <?php while ($slider = $result->fetch_assoc()): ?>

                    <tr>

                        <td><?= $i++ ?></td>

                        <td>

                            <?php if (!empty($slider['image'])): ?>

                                <img
                                    src="../../upload/sliders/<?= htmlspecialchars($slider['image']) ?>"
                                    class="slider-image"
                                    alt="<?= htmlspecialchars($slider['title']) ?>">

                            <?php else: ?>

                                <div class="no-image">
                                    <i class="fa-regular fa-image"></i>
                                </div>

                            <?php endif; ?>

                        </td>

                        <td>
                            <strong>
                                <?= htmlspecialchars($slider['title']) ?>
                            </strong>
                        </td>

                        <td>
                            <div class="description">
                                <?= htmlspecialchars($slider['description']) ?>
                            </div>
                        </td>

                        <td>
                            <?= date(
                                'd M Y',
                                strtotime($slider['created_at'])
                            ) ?>
                        </td>

                        <td>

                            <div class="actions">

                                <a
                                    href="view.php?id=<?= $slider['id'] ?>"
                                    class="action-btn view-btn">

                                    <i class="fa-solid fa-eye"></i>

                                </a>

                                <a
                                    href="edit.php?id=<?= $slider['id'] ?>"
                                    class="action-btn edit-btn">

                                    <i class="fa-solid fa-pen"></i>

                                </a>

                                <a
                                    href="delete.php?id=<?= $slider['id'] ?>"
                                    class="action-btn delete-btn"
                                    onclick="return confirm('Are you sure you want to delete this slider?');">

                                    <i class="fa-solid fa-trash"></i>

                                </a>

                            </div>

                        </td>

                    </tr>

                <?php endwhile; ?>

                </tbody>

            </table>

        <?php else: ?>

            <div class="empty-state">

                <div class="empty-icon">
                    <i class="fa-solid fa-images"></i>
                </div>

                <h3>No Sliders Found</h3>

                <p>You haven't added any sliders yet.</p>

                <a href="add.php" class="add-btn">
                    <i class="fa-solid fa-plus"></i>
                    Add Your First Slider
                </a>

            </div>

        <?php endif; ?>

    </div>

</main>

</body>
</html>