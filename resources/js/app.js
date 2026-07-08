document.addEventListener("DOMContentLoaded", function () {
    /* 
       Profile dropdown (navbar top-right)
    */
    const profileTrigger = document.getElementById("profileTrigger");
    const profileDropdown = document.getElementById("profileDropdown");

    if (profileTrigger && profileDropdown) {
        profileTrigger.addEventListener("click", function (event) {
            event.stopPropagation();
            profileDropdown.classList.toggle("open");
        });

        document.addEventListener("click", function (event) {
            if (
                !profileDropdown.contains(event.target) &&
                !profileTrigger.contains(event.target)
            ) {
                profileDropdown.classList.remove("open");
            }
        });
    }

    /* 
       Mobile hamburger menu
    */
    const navbarToggle = document.getElementById("navbarToggle");
    const navbarMenu = document.getElementById("navbarMenu");

    if (navbarToggle && navbarMenu) {
        navbarToggle.addEventListener("click", function () {
            navbarMenu.classList.toggle("open");
        });
    }

    /* 
       Live profile photo preview on the Edit Profile page
    */
    const photoInput = document.getElementById("photo");
    const photoPreview = document.getElementById("photoPreview");
    const photoPlaceholder = document.getElementById("photoPlaceholder");

    if (photoInput && photoPreview && photoPlaceholder) {
        photoInput.addEventListener("change", function (event) {
            const file = event.target.files[0];
            if (!file) {
                return;
            }

            const reader = new FileReader();
            reader.onload = function (readerEvent) {
                photoPreview.src = readerEvent.target.result;
                photoPreview.classList.remove("hidden");
                photoPlaceholder.classList.add("hidden");
            };
            reader.readAsDataURL(file);
        });
    }

    /* 
       Delete Account confirmation modal
     */
    const openDeleteModalBtn = document.getElementById(
        "openDeleteAccountModal",
    );
    const deleteModal = document.getElementById("deleteAccountModal");
    const cancelDeleteBtn = document.getElementById("cancelDeleteAccount");

    if (openDeleteModalBtn && deleteModal && cancelDeleteBtn) {
        openDeleteModalBtn.addEventListener("click", function () {
            deleteModal.classList.remove("hidden");
        });

        cancelDeleteBtn.addEventListener("click", function () {
            deleteModal.classList.add("hidden");
        });

        deleteModal.addEventListener("click", function (event) {
            if (event.target === deleteModal) {
                deleteModal.classList.add("hidden");
            }
        });
    }
});
/*
   PHASE 2 
 */

document.addEventListener("DOMContentLoaded", function () {
    /* 
       Hero banner slider — auto-rotate + manual prev/next/dots
    */
    const heroSlider = document.getElementById("heroSlider");

    if (heroSlider) {
        const slides = heroSlider.querySelectorAll(".hero-slide");
        const indicators = heroSlider.querySelectorAll(".hero-indicator");
        const prevBtn = document.getElementById("heroPrev");
        const nextBtn = document.getElementById("heroNext");

        let currentSlide = 0;
        const totalSlides = slides.length;
        const AUTO_ROTATE_MS = 6000;
        let autoRotateTimer = null;

        function goToSlide(index) {
            slides[currentSlide].classList.remove("active");
            indicators[currentSlide].classList.remove("active");

            currentSlide = (index + totalSlides) % totalSlides;

            slides[currentSlide].classList.add("active");
            indicators[currentSlide].classList.add("active");
        }

        function startAutoRotate() {
            autoRotateTimer = setInterval(function () {
                goToSlide(currentSlide + 1);
            }, AUTO_ROTATE_MS);
        }

        function resetAutoRotate() {
            clearInterval(autoRotateTimer);
            startAutoRotate();
        }

        if (prevBtn) {
            prevBtn.addEventListener("click", function () {
                goToSlide(currentSlide - 1);
                resetAutoRotate();
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener("click", function () {
                goToSlide(currentSlide + 1);
                resetAutoRotate();
            });
        }

        indicators.forEach(function (dot, index) {
            dot.addEventListener("click", function () {
                goToSlide(index);
                resetAutoRotate();
            });
        });

        startAutoRotate();
    }

    /* 
       Animated stat counters — count up once when scrolled into view
        */
    const statNumbers = document.querySelectorAll(".stat-number");

    if (statNumbers.length > 0 && "IntersectionObserver" in window) {
        const COUNT_DURATION_MS = 1500;

        const counterObserver = new IntersectionObserver(
            function (entries, observer) {
                entries.forEach(function (entry) {
                    if (!entry.isIntersecting) {
                        return;
                    }

                    const el = entry.target;
                    const target = parseInt(el.dataset.count, 10) || 0;
                    const startTime = performance.now();

                    function step(now) {
                        const progress = Math.min(
                            (now - startTime) / COUNT_DURATION_MS,
                            1,
                        );
                        el.textContent = Math.floor(progress * target);

                        if (progress < 1) {
                            requestAnimationFrame(step);
                        } else {
                            el.textContent = target;
                        }
                    }

                    requestAnimationFrame(step);
                    observer.unobserve(el);
                });
            },
            { threshold: 0.4 },
        );

        statNumbers.forEach(function (el) {
            counterObserver.observe(el);
        });
    }

    /* 
       Scroll-reveal animation for service cards / contact cards
        */ /*
    const revealTargets = document.querySelectorAll(
        ".service-card, .contact-info-card, .contact-form-card",
    );

    if (revealTargets.length > 0 && "IntersectionObserver" in window) {
        const revealObserver = new IntersectionObserver(
            function (entries, observer) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add("in-view");
                        observer.unobserve(entry.target);
                    }
                });
            },
            { threshold: 0.15 },
        );

        revealTargets.forEach(function (el) {
            revealObserver.observe(el);
        });
    }
*/
    const revealTargets = document.querySelectorAll(
        ".service-card, .contact-info-card, .contact-form-card",
    );

    const revealObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("in-view");
                } else {
                    entry.target.classList.remove("in-view");
                }
            });
        },
        {
            threshold: 0.15,
        },
    );

    revealTargets.forEach((el) => {
        revealObserver.observe(el);
    });

    /*
       Back-to-top button
     */
    const backToTopBtn = document.getElementById("backToTopBtn");

    if (backToTopBtn) {
        window.addEventListener("scroll", function () {
            if (window.scrollY > 400) {
                backToTopBtn.classList.add("visible");
            } else {
                backToTopBtn.classList.remove("visible");
            }
        });

        backToTopBtn.addEventListener("click", function () {
            window.scrollTo({ top: 0, behavior: "smooth" });
        });
    }
});
/*
   PHASE 4 ADDITIONS 
 */

document.addEventListener("DOMContentLoaded", function () {
    /*
       Live crop photo preview on the Add/Edit Crop forms
     */
    const cropImageInput = document.getElementById("image");
    const cropImagePreview = document.getElementById("cropImagePreview");
    const cropImagePlaceholder = document.getElementById(
        "cropImagePlaceholder",
    );

    if (cropImageInput && cropImagePreview && cropImagePlaceholder) {
        cropImageInput.addEventListener("change", function (event) {
            const file = event.target.files[0];
            if (!file) {
                return;
            }

            const reader = new FileReader();
            reader.onload = function (readerEvent) {
                cropImagePreview.src = readerEvent.target.result;
                cropImagePreview.classList.remove("hidden");
                cropImagePlaceholder.classList.add("hidden");
            };
            reader.readAsDataURL(file);
        });
    }

    /*
       Shared "Delete Crop" confirmation modal.
       Any button with [data-open-delete-modal] + [data-delete-url]
       opens #deleteCropModal and points its form at that crop's URL.
     */
    const deleteCropModal = document.getElementById("deleteCropModal");
    const deleteCropForm = document.getElementById("deleteCropForm");
    const cancelDeleteCropBtn = document.getElementById("cancelDeleteCrop");

    if (deleteCropModal && deleteCropForm) {
        document
            .querySelectorAll("[data-open-delete-modal]")
            .forEach(function (button) {
                button.addEventListener("click", function () {
                    deleteCropForm.setAttribute(
                        "action",
                        button.dataset.deleteUrl,
                    );
                    deleteCropModal.classList.remove("hidden");
                });
            });

        if (cancelDeleteCropBtn) {
            cancelDeleteCropBtn.addEventListener("click", function () {
                deleteCropModal.classList.add("hidden");
            });
        }

        deleteCropModal.addEventListener("click", function (event) {
            if (event.target === deleteCropModal) {
                deleteCropModal.classList.add("hidden");
            }
        });
    }
});
