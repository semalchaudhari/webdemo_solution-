<?php
require_once "../config/auth.php";

$page = 'gallery';

require_once "../config/dbconn.php";

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    header("Location: index.php");
    exit;
}

/*
| Fetch image name to delete file from disk
*/
$stmt = $conn->prepare("SELECT id, image FROM gallery WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $stmt->close();
    header("Location: index.php");
    exit;
}

$item = $result->fetch_assoc();
$stmt->close();

/*
| Delete file from directory
*/
if (!empty($item['image'])) {
    $imagePath = "../../upload/gallery/" . $item['image'];
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }
}

/*
| Delete record from DB
*/
$stmt = $conn->prepare("DELETE FROM gallery WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    $stmt->close();
    header("Location: index.php");
    exit;
} else {
    $stmt->close();
    die("Failed to delete gallery item.");
}