<?php

$page = "cms";
$page_title = "Website CMS";

require_once "../config/dbconn.php";
include "../config/auth.php";

$message = "";
$type = "";

/* =========================
   UPDATE
========================= */

if (isset($_POST['update'])) {

    $email = trim($_POST['email']);
    $mobile = trim($_POST['mobile']);
    $whatsapp = trim($_POST['whatsapp']);
    $location = trim($_POST['location']);

    // Validation

    if (
        empty($email) ||
        empty($mobile) ||
        empty($whatsapp) ||
        empty($location)
    ) {

        header("Location:index.php?status=empty");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        header("Location:index.php?status=email");
        exit;
    }

    if (
        !preg_match('/^[0-9]{10}$/', $mobile) ||
        !preg_match('/^[0-9]{10}$/', $whatsapp)
    ) {

        header("Location:index.php?status=phone");
        exit;
    }

    $result = $conn->query("SELECT id FROM company_info LIMIT 1");
    $cms = $result->fetch_assoc();

    $stmt = $conn->prepare("
        UPDATE company_info
        SET
            email=?,
            mobile=?,
            whatsapp=?,
            location=?
        WHERE id=?
    ");

    $stmt->bind_param(
        "ssssi",
        $email,
        $mobile,
        $whatsapp,
        $location,
        $cms['id']
    );

    if ($stmt->execute()) {

        header("Location:index.php?status=success");
        exit;
    } else {

        header("Location:index.php?status=error");
        exit;
    }
}


/* =========================
   FETCH DATA
========================= */

$result = $conn->query("SELECT * FROM company_info LIMIT 1");
$cms = $result->fetch_assoc();

include "../includes/sidebar.php";

?>


<main class="admin-main">
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/cms.css">

    <div class="page-header">

        <div>

            <h1>Website CMS</h1>

            <p>
                Manage website contact information.
            </p>

        </div>

    </div>


    <?php

    if (isset($_GET['status'])) {

        switch ($_GET['status']) {

            case "success":

                echo '
                <div class="alert success">
                    <i class="fa-solid fa-circle-check"></i>
                    Contact information updated successfully.
                </div>';

                break;

            case "empty":

                echo '
                <div class="alert error">
                    <i class="fa-solid fa-circle-xmark"></i>
                    Please fill all the fields.
                </div>';

                break;

            case "email":

                echo '
                <div class="alert error">
                    <i class="fa-solid fa-circle-xmark"></i>
                    Please enter a valid email address.
                </div>';

                break;

            case "phone":

                echo '
                <div class="alert error">
                    <i class="fa-solid fa-circle-xmark"></i>
                    Mobile and WhatsApp numbers must contain exactly 10 digits.
                </div>';

                break;

            default:

                echo '
                <div class="alert error">
                    <i class="fa-solid fa-circle-xmark"></i>
                    Something went wrong.
                </div>';
        }
    }

    ?>


    <form method="POST" class="cms-card">

        <div class="form-grid">

            <div class="form-group">

                <label>Email Address</label>

                <input
                    type="email"
                    name="email"
                    required
                    value="<?= htmlspecialchars($cms['email']) ?>">

            </div>


            <div class="form-group">

                <label>Mobile Number</label>

                <input
                    type="text"
                    name="mobile"
                    maxlength="10"
                    required
                    value="<?= htmlspecialchars($cms['mobile']) ?>">

            </div>


            <div class="form-group">

                <label>WhatsApp Number</label>

                <input
                    type="text"
                    name="whatsapp"
                    maxlength="10"
                    required
                    value="<?= htmlspecialchars($cms['whatsapp']) ?>">

            </div>


            <div class="form-group full">

                <label>Location</label>

                <textarea
                    name="location"
                    rows="4"
                    required><?= htmlspecialchars($cms['location']) ?></textarea>

            </div>

        </div>


        <div class="form-footer">

            <button
                type="submit"
                name="update"
                class="save-btn">

                <i class="fa-solid fa-floppy-disk"></i>

                Save Changes

            </button>

        </div>

    </form>

</main>

<script>
    setTimeout(function() {

        const alert = document.querySelector(".alert");

        if (alert) {

            alert.style.opacity = "0";

            setTimeout(function() {

                alert.remove();

            }, 400);

        }

    }, 3000);
</script>