<?php

session_start();

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

if (!isset($_SESSION['id'])) {
    header("Location: /demoweb/admin/login.php");
    exit();
}

?>

<script>
    window.addEventListener("pageshow", function(event) {

        const backForward =
            event.persisted ||
            performance.getEntriesByType("navigation")[0]?.type === "back_forward";

        if (backForward) {
            location.reload();
        } else {
            document.body.style.visibility = "visible";
        }

    });
</script>