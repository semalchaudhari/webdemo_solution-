<?php
require_once "../config/auth.php";

$page = 'services';

require_once "../config/dbconn.php";


/*
|--------------------------------------------------------------------------
| Get Service ID
|--------------------------------------------------------------------------
*/

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    header("Location: index.php");
    exit;
}


/*
|--------------------------------------------------------------------------
| Fetch Service
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare(
    "SELECT id, image
     FROM services
     WHERE id = ?"
);

$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();


/*
|--------------------------------------------------------------------------
| Service Not Found
|--------------------------------------------------------------------------
*/

if ($result->num_rows === 0) {

    $stmt->close();

    header("Location: index.php");
    exit;
}


$service = $result->fetch_assoc();

$stmt->close();


/*
|--------------------------------------------------------------------------
| Delete Image
|--------------------------------------------------------------------------
*/

if (!empty($service['image'])) {

    $imagePath = "../../uploads/services/" . $service['image'];

    if (file_exists($imagePath)) {
        unlink($imagePath);
    }
}


/*
|--------------------------------------------------------------------------
| Delete Service From Database
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare(
    "DELETE FROM services
     WHERE id = ?"
);

$stmt->bind_param("i", $id);


if ($stmt->execute()) {

    /*
    |--------------------------------------------------------------------------
    | Successfully Deleted
    |--------------------------------------------------------------------------
    */

    $stmt->close();

    header("Location: index.php");
    exit;

} else {

    /*
    |--------------------------------------------------------------------------
    | Failed
    |--------------------------------------------------------------------------
    */

    $stmt->close();

    die("Failed to delete service.");
}