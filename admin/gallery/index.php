<?php
require_once "../config/auth.php";

$page = 'gallery';

require_once "../config/dbconn.php";

/*
|--------------------------------------------------------------------------
| Fetch all gallery items
|--------------------------------------------------------------------------
*/
$sql = "SELECT id, title, image, created_at FROM gallery ORDER BY id DESC";
$result = $conn->query($sql);

if (!$result) {
    die("Failed to fetch gallery items.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery</title>
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="../css/service.css">
</head>
<body>

    <?php include "../includes/sidebar.php"; ?>

    <main class="admin-main">
        <div class="page-header">
            <div>
                <h1>Gallery</h1>
                <p>Manage the gallery items displayed on your website.</p>
            </div>
            <a href="add.php" class="add-btn">
                <i class="fa-solid fa-plus"></i> Add Gallery Item
            </a>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($item = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['id']) ?></td>
                                <td>
                                    <?php if (!empty($item['image'])): ?>
                                        <img src="../../upload/gallery/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['title']) ?>" class="service-image">
                                    <?php else: ?>
                                        <div class="no-image"><i class="fa-regular fa-image"></i></div>
                                    <?php endif; ?>
                                </td>
                                <td><strong><?= htmlspecialchars($item['title']) ?></strong></td>
                                <td><?= date('d M Y', strtotime($item['created_at'])) ?></td>
                                <td>
                                    <div class="actions">
                                        <a href="view.php?id=<?= $item['id'] ?>" class="action-btn view-btn" title="View"><i class="fa-solid fa-eye"></i></a>
                                        <a href="edit.php?id=<?= $item['id'] ?>" class="action-btn edit-btn" title="Edit"><i class="fa-solid fa-pen"></i></a>
                                        <a href="delete.php?id=<?= $item['id'] ?>" class="action-btn delete-btn" title="Delete" onclick="return confirm('Are you sure you want to delete this gallery item?');"><i class="fa-solid fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="empty-state">
                                <div class="empty-icon"><i class="fa-solid fa-images"></i></div>
                                <h3>No Gallery Items Found</h3>
                                <p>You haven't added any images to the gallery yet.</p>
                                <a href="add.php" class="add-btn"><i class="fa-solid fa-plus"></i> Add Your First Image</a>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

</body>
</html>