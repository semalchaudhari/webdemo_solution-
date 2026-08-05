<?php
require_once "../config/auth.php";

require_once "../config/dbconn.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {

    header("Location: index.php");

    exit;
}

$id = (int) $_GET['id'];


$stmt = $conn->prepare(
    "DELETE FROM reviews
     WHERE id = ?"
);

$stmt->bind_param("i", $id);


if ($stmt->execute()) {

    $stmt->close();

    header("Location: index.php");

    exit;

}


$stmt->close();

die("Failed to delete review.");

?>