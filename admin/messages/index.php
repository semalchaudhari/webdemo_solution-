<?php

$page = 'messages';

require_once "../config/auth.php";

require_once "../config/dbconn.php";




/*
|--------------------------------------------------------------------------
| Fetch Contact Messages
|--------------------------------------------------------------------------
*/

$sql = "
    SELECT id, name, phone, message, created_at
    FROM contact_messages
    ORDER BY created_at DESC
";

$result = $conn->query($sql);

if (!$result) {
    die("Unable to fetch contact messages.");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Messages</title>

    <!-- Sidebar CSS -->
    <link rel="stylesheet" href="../css/sidebar.css">

    <!-- Messages CSS -->
    <link rel="stylesheet" href="../css/messages.css">

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
                Messages
            </h1>

            <p>
                View messages and enquiries submitted by customers.
            </p>

        </div>

    </div>


    <!-- =========================
         MESSAGE TABLE
    ========================== -->

    <div class="table-container">

        <table>

            <thead>

                <tr>

                    <th>#</th>

                    <th>Name</th>

                    <th>Phone</th>

                    <th>Message</th>

                    <th>Received</th>

                    <th>Action</th>

                </tr>

            </thead>


            <tbody>


                <?php if ($result->num_rows > 0): ?>


                    <?php while ($message = $result->fetch_assoc()): ?>

                        <tr>


                            <!-- ID -->

                            <td>

                                <?= htmlspecialchars($message['id']) ?>

                            </td>


                            <!-- NAME -->

                            <td>

                                <strong>
                                    <?= htmlspecialchars($message['name']) ?>
                                </strong>

                            </td>


                            <!-- PHONE -->

                            <td>

                                <?= htmlspecialchars($message['phone']) ?>

                            </td>


                            <!-- MESSAGE -->

                            <td>

                                <p class="message-preview">

                                    <?= htmlspecialchars(
                                        mb_strimwidth(
                                            $message['message'],
                                            0,
                                            70,
                                            '...'
                                        )
                                    ) ?>

                                </p>

                            </td>


                            <!-- DATE -->

                            <td>

                                <?= date(
                                    'd M Y',
                                    strtotime($message['created_at'])
                                ) ?>

                            </td>


                            <!-- ACTION -->

                            <td>

                                <a
                                    href="view.php?id=<?= $message['id'] ?>"
                                    class="action-btn view-btn"
                                    title="View Message">

                                    <i class="fa-solid fa-eye"></i>

                                </a>

                            </td>


                        </tr>

                    <?php endwhile; ?>


                <?php else: ?>


                    <tr>

                        <td
                            colspan="6"
                            class="empty-state">

                            <div class="empty-icon">

                                <i class="fa-regular fa-envelope"></i>

                            </div>

                            <h3>
                                No Messages Found
                            </h3>

                            <p>
                                There are no customer enquiries yet.
                            </p>

                        </td>

                    </tr>


                <?php endif; ?>


            </tbody>

        </table>

    </div>


</main>

</body>

</html>