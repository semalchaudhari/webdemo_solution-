document.addEventListener("DOMContentLoaded", function () {

    /* =========================
       HERO SLIDER
    ========================= */

    const heroSlides = document.querySelectorAll(".hero-slide");

    const heroNext = document.querySelector(".hero-next");
    const heroPrev = document.querySelector(".hero-prev");

    let heroIndex = 0;

    function showHero(index) {

        if (heroSlides.length === 0) return;

        heroSlides.forEach(slide => {
            slide.classList.remove("active");
        });

        heroSlides[index].classList.add("active");
    }

    if (heroNext) {

        heroNext.addEventListener("click", function () {

            heroIndex++;

            if (heroIndex >= heroSlides.length) {
                heroIndex = 0;
            }

            showHero(heroIndex);

        });

    }

    if (heroPrev) {

        heroPrev.addEventListener("click", function () {

            heroIndex--;

            if (heroIndex < 0) {
                heroIndex = heroSlides.length - 1;
            }

            showHero(heroIndex);

        });

    }

    if (heroSlides.length > 1) {

        setInterval(function () {

            heroIndex++;

            if (heroIndex >= heroSlides.length) {
                heroIndex = 0;
            }

            showHero(heroIndex);

        }, 5000);

    }


    /* =========================
       HORIZONTAL SLIDER FUNCTION
    ========================= */

    function createSlider(containerId, prevSelector, nextSelector) {

    const container = document.getElementById(containerId);

    const prev = document.querySelector(prevSelector);
    const next = document.querySelector(nextSelector);

    if (!container) return;


    function slideNext() {

        const maxScroll =
            container.scrollWidth - container.clientWidth;

        if (container.scrollLeft >= maxScroll - 5) {

            container.scrollTo({
                left: 0,
                behavior: "smooth"
            });

        } else {

            container.scrollBy({
                left: 300,
                behavior: "smooth"
            });

        }
    }


    function slidePrevious() {

        if (container.scrollLeft <= 5) {

            container.scrollTo({
                left: 0,
                behavior: "smooth"
            });

        } else {

            container.scrollBy({
                left: -300,
                behavior: "smooth"
            });

        }
    }


    // NEXT BUTTON

    if (next) {

        next.addEventListener("click", function () {

            slideNext();

        });

    }


    // PREVIOUS BUTTON

    if (prev) {

        prev.addEventListener("click", function () {

            slidePrevious();

        });

    }


    // AUTO SLIDE

    let autoSlide = setInterval(function () {

        slideNext();

    }, 800);


    // PAUSE WHEN MOUSE IS OVER SLIDER

    container.addEventListener("mouseenter", function () {

        clearInterval(autoSlide);

    });


    // RESUME WHEN MOUSE LEAVES

    container.addEventListener("mouseleave", function () {

        autoSlide = setInterval(function () {

            slideNext();

        }, 800);

    });

}

    createSlider(
        "serviceSlider",
        ".service-prev",
        ".service-next"
    );


    createSlider(
        "brandSlider",
        ".brand-prev",
        ".brand-next"
    );


    /* =========================
       REVIEW SLIDER
    ========================= */

    const reviewSlider = document.getElementById("reviewSlider");

    const reviewNext = document.querySelector(".review-next");
    const reviewPrev = document.querySelector(".review-prev");

    if (reviewSlider) {

        if (reviewNext) {

            reviewNext.addEventListener("click", function () {

                reviewSlider.scrollBy({
                    left: reviewSlider.clientWidth,
                    behavior: "smooth"
                });

            });

        }

        if (reviewPrev) {

            reviewPrev.addEventListener("click", function () {

                reviewSlider.scrollBy({
                    left: -reviewSlider.clientWidth,
                    behavior: "smooth"
                });

            });

        }

    }

});