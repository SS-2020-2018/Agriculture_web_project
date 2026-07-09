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
/* 
   PHASE 5 ADDITIONS 
 */

document.addEventListener("DOMContentLoaded", function () {
    const reminderForm = document.getElementById("reminderForm");

    // Everything below only applies on the Reminder Calendar page.
    if (!reminderForm) {
        return;
    }

    const reminderFormCard = document.getElementById("reminderFormCard");
    const reminderFormTitle = document.getElementById("reminderFormTitle");
    const reminderFormMethod = document.getElementById("reminderFormMethod");
    const reminderTaskId = document.getElementById("reminderTaskId");
    const reminderSubmitBtn = document.getElementById("reminderSubmitBtn");
    const cancelEditBtn = document.getElementById("cancelEditReminder");
    const titleInput = document.getElementById("title");
    const dateInput = document.getElementById("reminder_date");
    const notesInput = document.getElementById("notes");

    /*
       Enter / exit "Edit Reminder" mode in the sidebar form
     */
    function enterEditMode(id, title, date, notes, updateUrl) {
        reminderTaskId.value = id;
        titleInput.value = title;
        dateInput.value = date;
        notesInput.value = notes || "";

        reminderForm.setAttribute("action", updateUrl);
        reminderFormMethod.value = "PUT";
        reminderFormTitle.textContent = "Edit Reminder";
        reminderSubmitBtn.textContent = "Save Changes";
        cancelEditBtn.classList.remove("hidden");

        reminderFormCard.scrollIntoView({ behavior: "smooth", block: "start" });
    }

    function exitEditMode() {
        reminderTaskId.value = "";
        titleInput.value = "";
        dateInput.value = "";
        notesInput.value = "";

        reminderForm.setAttribute("action", reminderForm.dataset.storeUrl);
        reminderFormMethod.value = "POST";
        reminderFormTitle.textContent = "Add Reminder";
        reminderSubmitBtn.textContent = "Add Reminder";
        cancelEditBtn.classList.add("hidden");
    }

    document.querySelectorAll(".reminder-edit-btn").forEach(function (btn) {
        btn.addEventListener("click", function () {
            enterEditMode(
                btn.dataset.id,
                btn.dataset.title,
                btn.dataset.date,
                btn.dataset.notes,
                btn.dataset.updateUrl,
            );
        });
    });

    cancelEditBtn.addEventListener("click", exitEditMode);

    // If the page reloaded after a validation error while editing, re-open
    // that same reminder's edit form so the error messages make sense.
    if (window.reopenEditReminderId) {
        const targetBtn = document.querySelector(
            '.reminder-edit-btn[data-id="' + window.reopenEditReminderId + '"]',
        );
        if (targetBtn) {
            enterEditMode(
                targetBtn.dataset.id,
                targetBtn.dataset.title,
                targetBtn.dataset.date,
                targetBtn.dataset.notes,
                targetBtn.dataset.updateUrl,
            );
        }
    }

    /*
       AJAX checkbox toggle — flips completed/pending instantly,
       no page reload, and refreshes the summary stat boxes.
     */
    function updateReminderStats(stats) {
        const totalEl = document.getElementById("reminderStatTotal");
        const pendingEl = document.getElementById("reminderStatPending");
        const completedEl = document.getElementById("reminderStatCompleted");
        const todayEl = document.getElementById("reminderStatToday");

        if (totalEl) totalEl.textContent = stats.total;
        if (pendingEl) pendingEl.textContent = stats.pending;
        if (completedEl) completedEl.textContent = stats.completed;
        if (todayEl) todayEl.textContent = stats.today;
    }

    document
        .querySelectorAll(".reminder-checkbox")
        .forEach(function (checkbox) {
            checkbox.addEventListener("change", function () {
                const url = checkbox.dataset.toggleUrl;
                const reminderItem = checkbox.closest(".reminder-item");
                const csrfToken = document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content");

                fetch(url, {
                    method: "PATCH",
                    headers: {
                        "X-CSRF-TOKEN": csrfToken,
                        Accept: "application/json",
                    },
                })
                    .then(function (response) {
                        if (!response.ok) {
                            throw new Error("Request failed");
                        }
                        return response.json();
                    })
                    .then(function (data) {
                        reminderItem.classList.toggle(
                            "reminder-completed",
                            data.is_completed,
                        );
                        reminderItem.dataset.status = data.is_completed
                            ? "completed"
                            : "pending";
                        updateReminderStats(data.stats);
                        applyReminderFilters();
                    })
                    .catch(function () {
                        // Revert the checkbox visually since the update failed.
                        checkbox.checked = !checkbox.checked;
                        alert(
                            "Could not update this reminder. Please try again.",
                        );
                    });
            });
        });

    /*
       Search + status filter (client-side, instant)
     */
    const searchInput = document.getElementById("reminderSearch");
    const filterButtons = document.querySelectorAll(".filter-btn");
    const noMatchesState = document.getElementById("reminderNoMatches");
    let currentFilter = "all";

    function applyReminderFilters() {
        const query = (searchInput ? searchInput.value : "")
            .toLowerCase()
            .trim();
        const items = document.querySelectorAll(".reminder-item");
        let visibleCount = 0;

        items.forEach(function (item) {
            const matchesSearch = item.dataset.title.includes(query);
            const matchesFilter =
                currentFilter === "all" ||
                item.dataset.status === currentFilter;
            const shouldShow = matchesSearch && matchesFilter;

            item.style.display = shouldShow ? "" : "none";
            if (shouldShow) {
                visibleCount++;
            }
        });

        if (noMatchesState) {
            noMatchesState.classList.toggle(
                "hidden",
                visibleCount !== 0 || items.length === 0,
            );
        }
    }

    if (searchInput) {
        searchInput.addEventListener("input", applyReminderFilters);
    }

    filterButtons.forEach(function (btn) {
        btn.addEventListener("click", function () {
            filterButtons.forEach(function (b) {
                b.classList.remove("active");
            });
            btn.classList.add("active");
            currentFilter = btn.dataset.filter;
            applyReminderFilters();
        });
    });

    /*
       Sort toggle — Newest first / Oldest first
     */
    const sortToggleBtn = document.getElementById("reminderSortToggle");
    let newestFirst = true;

    if (sortToggleBtn) {
        sortToggleBtn.addEventListener("click", function () {
            const list = document.getElementById("reminderList");
            const items = Array.from(list.querySelectorAll(".reminder-item"));

            items.sort(function (a, b) {
                const dateA = new Date(a.dataset.date);
                const dateB = new Date(b.dataset.date);
                return newestFirst ? dateB - dateA : dateA - dateB;
            });

            items.forEach(function (item) {
                list.appendChild(item);
            });

            newestFirst = !newestFirst;
            sortToggleBtn.textContent = newestFirst
                ? "Sort: Newest First ⬍"
                : "Sort: Oldest First ⬍";
        });
    }

    /*
       Delete confirmation modal (reminders)
     */
    const deleteReminderModal = document.getElementById("deleteReminderModal");
    const deleteReminderForm = document.getElementById("deleteReminderForm");
    const cancelDeleteReminderBtn = document.getElementById(
        "cancelDeleteReminder",
    );

    if (deleteReminderModal && deleteReminderForm) {
        document
            .querySelectorAll(".reminder-delete-btn")
            .forEach(function (button) {
                button.addEventListener("click", function () {
                    deleteReminderForm.setAttribute(
                        "action",
                        button.dataset.deleteUrl,
                    );
                    deleteReminderModal.classList.remove("hidden");
                });
            });

        if (cancelDeleteReminderBtn) {
            cancelDeleteReminderBtn.addEventListener("click", function () {
                deleteReminderModal.classList.add("hidden");
            });
        }

        deleteReminderModal.addEventListener("click", function (event) {
            if (event.target === deleteReminderModal) {
                deleteReminderModal.classList.add("hidden");
            }
        });
    }
});
