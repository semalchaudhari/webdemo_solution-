<?php

$page = 'messages';
require_once "../config/auth.php";

require_once "../config/dbconn.php";


/*
|--------------------------------------------------------------------------
| Get Message ID
|--------------------------------------------------------------------------
*/

$id = isset($_GET['id'])
    ? (int) $_GET['id']
    : 0;


if ($id <= 0) {
    die("Invalid message.");
}


/*
|--------------------------------------------------------------------------
| Fetch Message
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("
    SELECT id, name, phone, message, created_at
    FROM contact_messages
    WHERE id = ?
");

$stmt->bind_param("i", $id);

$stmt->execute();

$result = $stmt->get_result();

$message = $result->fetch_assoc();


if (!$message) {
    die("Message not found.");
}

$stmt->close();

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>View Message</title>

    <!-- Sidebar -->
    <link rel="stylesheet" href="../css/sidebar.css">

    <!-- View Message CSS -->
    <link rel="stylesheet" href="../css/message-view.css">

    <!-- Font Awesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>


<?php include "../includes/sidebar.php"; ?>


<main class="admin-main">


    <!-- =========================
         PAGE HEADER
    ========================== -->

    <div class="page-header">

        <div>

            <h1>
                View Message
            </h1>

            <p>
                Customer enquiry details.
            </p>

        </div>


        <a
            href="index.php"
            class="back-btn">

            <i class="fa-solid fa-arrow-left"></i>

            Back to Messages

        </a>

    </div>


    <!-- =========================
         MESSAGE CARD
    ========================== -->

    <div class="message-card">


        <!-- NAME -->

        <div class="message-row">

            <div class="message-label">

                <i class="fa-solid fa-user"></i>

                Name

            </div>

            <div class="message-value">

                <?= htmlspecialchars($message['name']) ?>

            </div>

        </div>


        <!-- PHONE -->

        <div class="message-row">

            <div class="message-label">

                <i class="fa-solid fa-phone"></i>

                Phone

            </div>

            <div class="message-value">

                <?= htmlspecialchars($message['phone']) ?>

            </div>

        </div>


        <!-- DATE -->

        <div class="message-row">

            <div class="message-label">

                <i class="fa-regular fa-calendar"></i>

                Received

            </div>

            <div class="message-value">

                <?= date(
                    'd M Y, h:i A',
                    strtotime($message['created_at'])
                ) ?>

            </div>

        </div>


        <!-- MESSAGE -->

        <div class="message-content">

            <div class="message-label">

                <i class="fa-regular fa-message"></i>

                Message

            </div>


            <div class="message-text">

                <?= nl2br(
                    htmlspecialchars($message['message'])
                ) ?>

            </div>

        </div>


    </div>


</main>


</body>

</html>