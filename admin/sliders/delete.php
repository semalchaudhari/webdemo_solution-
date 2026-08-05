<?php

require_once "../config/auth.php";
require_once "../config/dbconn.php";

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    header("Location: index.php");
    exit;
}


/* GET IMAGE */

$stmt = $conn->prepare(
    "SELECT image FROM sliders WHERE id = ?"
);

$stmt->bind_param("i", $id);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 0) {

    header("Location: index.php");
    exit;

}

$slider = $result->fetch_assoc();

$stmt->close();


/* DELETE */

$stmt = $conn->prepare(
    "DELETE FROM sliders WHERE id = ?"
);

$stmt->bind_param("i", $id);

if ($stmt->execute()) {

    if (
        !empty($slider['image']) &&
        file_exists("../../upload/sliders/" . $slider['image'])
    ) {

        unlink(
            "../../upload/sliders/" . $slider['image']
        );

    }

}

$stmt->close();

header("Location: index.php");
exit;