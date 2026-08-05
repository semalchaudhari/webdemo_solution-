<?php

require_once "../config/auth.php";

$page = 'brands';

require_once "../config/dbconn.php";


/*
|--------------------------------------------------------------------------
| Get Brand ID
|--------------------------------------------------------------------------
*/

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {

    header("Location: index.php");

    exit;
}


/*
|--------------------------------------------------------------------------
| Fetch Brand
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare(
    "SELECT id, logo
     FROM brands
     WHERE id = ?"
);

$stmt->bind_param("i", $id);

$stmt->execute();

$result = $stmt->get_result();


/*
|--------------------------------------------------------------------------
| Brand Not Found
|--------------------------------------------------------------------------
*/

if ($result->num_rows === 0) {

    $stmt->close();

    header("Location: index.php");

    exit;
}


$brand = $result->fetch_assoc();

$stmt->close();


/*
|--------------------------------------------------------------------------
| Delete Logo
|--------------------------------------------------------------------------
*/

if (!empty($brand['logo'])) {

    $logoPath = "../../uploads/brands/" . $brand['logo'];


    if (file_exists($logoPath)) {

        unlink($logoPath);
    }
}


/*
|--------------------------------------------------------------------------
| Delete Brand
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare(
    "DELETE FROM brands
     WHERE id = ?"
);

$stmt->bind_param("i", $id);


if ($stmt->execute()) {

    $stmt->close();

    header("Location: index.php");

    exit;

} else {

    $stmt->close();

    die("Failed to delete brand.");
}