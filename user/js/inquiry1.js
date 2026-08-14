document.addEventListener("DOMContentLoaded", function () {

    const popup = document.getElementById("inquiryPopup");
    const closeButton = document.getElementById("closeInquiry");

    if (!popup || !closeButton) {
        return;
    }


    // Show after 5 seconds
    setTimeout(function () {

        if (sessionStorage.getItem("inquiryClosed") !== "true") {

            popup.classList.add("show");

        }

    }, 5000);


    // Close button
    closeButton.addEventListener("click", function () {

        popup.classList.remove("show");

        sessionStorage.setItem("inquiryClosed", "true");

    });


    // Click outside popup
    popup.addEventListener("click", function (event) {

        if (event.target === popup) {

            popup.classList.remove("show");

            sessionStorage.setItem("inquiryClosed", "true");

        }

    });

});