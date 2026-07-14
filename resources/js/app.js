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

/* 
   PHASE 6 ADDITIONS — append everything below to the end of your
   existing resources/js/app.js. Independent DOMContentLoaded block, safe
   to paste after the Phase 1–5 code already in that file.
    */

document.addEventListener("DOMContentLoaded", function () {
    /*
       Live disease photo preview on the Admin Add/Edit Disease forms
     */
    const diseaseImageInput = document.getElementById("image");
    const diseaseImagePreview = document.getElementById("diseaseImagePreview");
    const diseaseImagePlaceholder = document.getElementById(
        "diseaseImagePlaceholder",
    );

    if (diseaseImageInput && diseaseImagePreview && diseaseImagePlaceholder) {
        diseaseImageInput.addEventListener("change", function (event) {
            const file = event.target.files[0];
            if (!file) {
                return;
            }

            const reader = new FileReader();
            reader.onload = function (readerEvent) {
                diseaseImagePreview.src = readerEvent.target.result;
                diseaseImagePreview.classList.remove("hidden");
                diseaseImagePlaceholder.classList.add("hidden");
            };
            reader.readAsDataURL(file);
        });
    }

    /*
       Admin — Delete Disease confirmation modal
     */
    const deleteDiseaseModal = document.getElementById("deleteDiseaseModal");
    const deleteDiseaseForm = document.getElementById("deleteDiseaseForm");
    const cancelDeleteDiseaseBtn = document.getElementById(
        "cancelDeleteDisease",
    );

    if (deleteDiseaseModal && deleteDiseaseForm) {
        document
            .querySelectorAll("[data-open-delete-modal]")
            .forEach(function (button) {
                button.addEventListener("click", function () {
                    deleteDiseaseForm.setAttribute(
                        "action",
                        button.dataset.deleteUrl,
                    );
                    deleteDiseaseModal.classList.remove("hidden");
                });
            });

        if (cancelDeleteDiseaseBtn) {
            cancelDeleteDiseaseBtn.addEventListener("click", function () {
                deleteDiseaseModal.classList.add("hidden");
            });
        }

        deleteDiseaseModal.addEventListener("click", function (event) {
            if (event.target === deleteDiseaseModal) {
                deleteDiseaseModal.classList.add("hidden");
            }
        });
    }

    /*
       Farmer-facing Disease Alerts — search + crop filter + level filter
     */
    const diseaseGrid = document.getElementById("diseaseGrid");

    if (diseaseGrid) {
        const diseaseSearch = document.getElementById("diseaseSearch");
        const diseaseCropFilter = document.getElementById("diseaseCropFilter");
        const diseaseLevelButtons = document.querySelectorAll(
            "#diseaseLevelFilter .filter-btn",
        );
        const diseaseNoMatches = document.getElementById("diseaseNoMatches");
        let currentLevel = "all";

        function applyDiseaseFilters() {
            const query = (diseaseSearch ? diseaseSearch.value : "")
                .toLowerCase()
                .trim();
            const cropValue = diseaseCropFilter
                ? diseaseCropFilter.value
                : "all";
            const cards = diseaseGrid.querySelectorAll(".disease-card");
            let visibleCount = 0;

            cards.forEach(function (card) {
                const matchesSearch = card.dataset.title.includes(query);
                const matchesCrop =
                    cropValue === "all" || card.dataset.crop === cropValue;
                const matchesLevel =
                    currentLevel === "all" ||
                    card.dataset.level === currentLevel;
                const shouldShow = matchesSearch && matchesCrop && matchesLevel;

                card.style.display = shouldShow ? "" : "none";
                if (shouldShow) {
                    visibleCount++;
                }
            });

            if (diseaseNoMatches) {
                diseaseNoMatches.classList.toggle("hidden", visibleCount !== 0);
            }
        }

        if (diseaseSearch) {
            diseaseSearch.addEventListener("input", applyDiseaseFilters);
        }

        if (diseaseCropFilter) {
            diseaseCropFilter.addEventListener("change", applyDiseaseFilters);
        }

        diseaseLevelButtons.forEach(function (btn) {
            btn.addEventListener("click", function () {
                diseaseLevelButtons.forEach(function (b) {
                    b.classList.remove("active");
                });
                btn.classList.add("active");
                currentLevel = btn.dataset.level;
                applyDiseaseFilters();
            });
        });
    }
});

/*
   PHASE 8 ADDITIONS — append everything below to the end of your
   existing resources/js/app.js. Independent DOMContentLoaded block, safe
   to paste after the Phase 1–7 code already in that file.
 */

document.addEventListener("DOMContentLoaded", function () {
    /*
       Notification bell dropdown
     */
    const notificationTrigger = document.getElementById("notificationTrigger");
    const notificationDropdown = document.getElementById(
        "notificationDropdown",
    );

    if (notificationTrigger && notificationDropdown) {
        notificationTrigger.addEventListener("click", function (event) {
            event.stopPropagation();
            notificationDropdown.classList.toggle("open");
        });

        document.addEventListener("click", function (event) {
            if (
                !notificationDropdown.contains(event.target) &&
                !notificationTrigger.contains(event.target)
            ) {
                notificationDropdown.classList.remove("open");
            }
        });
    }

    /*
       Live tip photo preview on the Admin Add/Edit Tip forms
     */
    const tipImageInput = document.getElementById("image");
    const tipImagePreview = document.getElementById("tipImagePreview");
    const tipImagePlaceholder = document.getElementById("tipImagePlaceholder");

    if (tipImageInput && tipImagePreview && tipImagePlaceholder) {
        tipImageInput.addEventListener("change", function (event) {
            const file = event.target.files[0];
            if (!file) {
                return;
            }

            const reader = new FileReader();
            reader.onload = function (readerEvent) {
                tipImagePreview.src = readerEvent.target.result;
                tipImagePreview.classList.remove("hidden");
                tipImagePlaceholder.classList.add("hidden");
            };
            reader.readAsDataURL(file);
        });
    }

    /*
       Admin — Delete Tip confirmation modal
     */
    const deleteTipModal = document.getElementById("deleteTipModal");
    const deleteTipForm = document.getElementById("deleteTipForm");
    const cancelDeleteTipBtn = document.getElementById("cancelDeleteTip");

    if (deleteTipModal && deleteTipForm) {
        document
            .querySelectorAll("[data-open-delete-modal]")
            .forEach(function (button) {
                button.addEventListener("click", function () {
                    deleteTipForm.setAttribute(
                        "action",
                        button.dataset.deleteUrl,
                    );
                    deleteTipModal.classList.remove("hidden");
                });
            });

        if (cancelDeleteTipBtn) {
            cancelDeleteTipBtn.addEventListener("click", function () {
                deleteTipModal.classList.add("hidden");
            });
        }

        deleteTipModal.addEventListener("click", function (event) {
            if (event.target === deleteTipModal) {
                deleteTipModal.classList.add("hidden");
            }
        });
    }

    /*
       Admin — "Who liked this tip" modal (AJAX-loaded)
     */
    const tipLikersModal = document.getElementById("tipLikersModal");
    const tipLikersModalTitle = document.getElementById("tipLikersModalTitle");
    const tipLikersList = document.getElementById("tipLikersList");
    const tipLikersSearch = document.getElementById("tipLikersSearch");
    const closeTipLikersModalBtn = document.getElementById(
        "closeTipLikersModal",
    );
    let currentLikers = [];

    function renderLikers(likers) {
        if (likers.length === 0) {
            tipLikersList.innerHTML =
                '<p class="likers-empty">No farmers have liked this tip yet.</p>';
            return;
        }

        tipLikersList.innerHTML = likers
            .map(function (farmer) {
                const avatar = farmer.photo_url
                    ? '<img src="' +
                      farmer.photo_url +
                      '" alt="' +
                      farmer.name +
                      '" class="liker-avatar">'
                    : '<div class="liker-avatar">🧑‍🌾</div>';

                return (
                    '<div class="liker-row">' +
                    avatar +
                    '<div class="liker-info"><strong>' +
                    farmer.name +
                    "</strong><span>" +
                    farmer.address +
                    "</span></div>" +
                    "</div>"
                );
            })
            .join("");
    }

    if (tipLikersModal) {
        document
            .querySelectorAll(".likes-count-btn")
            .forEach(function (button) {
                button.addEventListener("click", function () {
                    tipLikersModalTitle.textContent =
                        'Farmers who liked "' + button.dataset.tipTitle + '"';
                    tipLikersList.innerHTML =
                        '<p class="likers-loading">Loading...</p>';
                    tipLikersModal.classList.remove("hidden");
                    if (tipLikersSearch) tipLikersSearch.value = "";

                    fetch(button.dataset.likersUrl, {
                        headers: { Accept: "application/json" },
                    })
                        .then(function (response) {
                            return response.json();
                        })
                        .then(function (data) {
                            currentLikers = data.likers || [];
                            renderLikers(currentLikers);
                        })
                        .catch(function () {
                            tipLikersList.innerHTML =
                                '<p class="likers-empty">Could not load likers. Please try again.</p>';
                        });
                });
            });

        if (tipLikersSearch) {
            tipLikersSearch.addEventListener("input", function () {
                const query = tipLikersSearch.value.toLowerCase().trim();
                const filtered = currentLikers.filter(function (farmer) {
                    return farmer.name.toLowerCase().includes(query);
                });
                renderLikers(filtered);
            });
        }

        if (closeTipLikersModalBtn) {
            closeTipLikersModalBtn.addEventListener("click", function () {
                tipLikersModal.classList.add("hidden");
            });
        }

        tipLikersModal.addEventListener("click", function (event) {
            if (event.target === tipLikersModal) {
                tipLikersModal.classList.add("hidden");
            }
        });
    }

    /*
       Farmer-facing — AJAX Like toggle (Tips index grid)
     */
    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        ?.getAttribute("content");

    function toggleTipLike(url) {
        return fetch(url, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
                Accept: "application/json",
            },
        }).then(function (response) {
            if (!response.ok) throw new Error("Request failed");
            return response.json();
        });
    }

    document
        .querySelectorAll(".tip-like-btn[data-like-url]")
        .forEach(function (button) {
            // Skip the single big button on the tip detail page — handled separately below.
            if (button.id === "tipShowLikeBtn") return;

            button.addEventListener("click", function () {
                toggleTipLike(button.dataset.likeUrl)
                    .then(function (data) {
                        button.classList.toggle(
                            "tip-like-btn-active",
                            data.liked,
                        );
                        button.querySelector(".tip-like-icon").textContent =
                            data.liked ? "❤️" : "🤍";
                        button.querySelector(".tip-like-count").textContent =
                            data.likes_count;
                    })
                    .catch(function () {
                        alert("Could not update your like. Please try again.");
                    });
            });
        });

    /*
       Farmer-facing — AJAX Like toggle (Tip detail page)
     */
    const tipShowLikeBtn = document.getElementById("tipShowLikeBtn");

    if (tipShowLikeBtn) {
        tipShowLikeBtn.addEventListener("click", function () {
            toggleTipLike(tipShowLikeBtn.dataset.likeUrl)
                .then(function (data) {
                    tipShowLikeBtn.classList.toggle(
                        "tip-like-btn-active",
                        data.liked,
                    );
                    tipShowLikeBtn.querySelector(".tip-like-icon").textContent =
                        data.liked ? "❤️" : "🤍";
                    tipShowLikeBtn.querySelector(
                        "span:last-child",
                    ).textContent = data.liked ? "Liked" : "Like this tip";

                    const countEl = document.getElementById("tipShowLikeCount");
                    if (countEl) countEl.textContent = data.likes_count;
                })
                .catch(function () {
                    alert("Could not update your like. Please try again.");
                });
        });
    }
});

/*
   PHASE 9 ADDITIONS — append everything below to the end of your
   existing resources/js/app.js. Independent DOMContentLoaded block, safe
   to paste after the Phase 1–8 code already in that file.
 */

document.addEventListener("DOMContentLoaded", function () {
    /*
       Live crop photo preview on the Admin Add/Edit Price forms
     */
    const priceImageInput = document.getElementById("crop_image");
    const priceImagePreview = document.getElementById("priceImagePreview");
    const priceImagePlaceholder = document.getElementById(
        "priceImagePlaceholder",
    );

    if (priceImageInput && priceImagePreview && priceImagePlaceholder) {
        priceImageInput.addEventListener("change", function (event) {
            const file = event.target.files[0];
            if (!file) {
                return;
            }

            const reader = new FileReader();
            reader.onload = function (readerEvent) {
                priceImagePreview.src = readerEvent.target.result;
                priceImagePreview.classList.remove("hidden");
                priceImagePlaceholder.classList.add("hidden");
            };
            reader.readAsDataURL(file);
        });
    }

    /*
       Admin — Delete Price confirmation modal
     */
    const deletePriceModal = document.getElementById("deletePriceModal");
    const deletePriceForm = document.getElementById("deletePriceForm");
    const cancelDeletePriceBtn = document.getElementById("cancelDeletePrice");

    if (deletePriceModal && deletePriceForm) {
        document
            .querySelectorAll("[data-open-delete-modal]")
            .forEach(function (button) {
                button.addEventListener("click", function () {
                    deletePriceForm.setAttribute(
                        "action",
                        button.dataset.deleteUrl,
                    );
                    deletePriceModal.classList.remove("hidden");
                });
            });

        if (cancelDeletePriceBtn) {
            cancelDeletePriceBtn.addEventListener("click", function () {
                deletePriceModal.classList.add("hidden");
            });
        }

        deletePriceModal.addEventListener("click", function (event) {
            if (event.target === deletePriceModal) {
                deletePriceModal.classList.add("hidden");
            }
        });
    }

    /*
       Farmer-facing — search + market filter + sort
     */
    const priceGrid = document.getElementById("priceGrid");

    if (priceGrid) {
        const priceSearch = document.getElementById("priceSearch");
        const priceMarketFilter = document.getElementById("priceMarketFilter");
        const priceSortSelect = document.getElementById("priceSortSelect");
        const priceNoMatches = document.getElementById("priceNoMatches");

        function applyPriceFilters() {
            const query = (priceSearch ? priceSearch.value : "")
                .toLowerCase()
                .trim();
            const marketValue = priceMarketFilter
                ? priceMarketFilter.value
                : "all";
            const cards = priceGrid.querySelectorAll(".price-card");
            let visibleCount = 0;

            cards.forEach(function (card) {
                const matchesSearch = card.dataset.title.includes(query);
                const matchesMarket =
                    marketValue === "all" ||
                    card.dataset.market === marketValue;
                const shouldShow = matchesSearch && matchesMarket;

                card.style.display = shouldShow ? "" : "none";
                if (shouldShow) {
                    visibleCount++;
                }
            });

            if (priceNoMatches) {
                priceNoMatches.classList.toggle("hidden", visibleCount !== 0);
            }
        }

        function applySorting() {
            const sortValue = priceSortSelect
                ? priceSortSelect.value
                : "recent";
            const cards = Array.from(priceGrid.querySelectorAll(".price-card"));

            cards.sort(function (a, b) {
                switch (sortValue) {
                    case "az":
                        return a.dataset.title.localeCompare(b.dataset.title);
                    case "price_high":
                        return (
                            parseFloat(b.dataset.price) -
                            parseFloat(a.dataset.price)
                        );
                    case "price_low":
                        return (
                            parseFloat(a.dataset.price) -
                            parseFloat(b.dataset.price)
                        );
                    case "recent":
                    default:
                        return (
                            parseInt(b.dataset.updated, 10) -
                            parseInt(a.dataset.updated, 10)
                        );
                }
            });

            cards.forEach(function (card) {
                priceGrid.appendChild(card);
            });
        }

        if (priceSearch) {
            priceSearch.addEventListener("input", applyPriceFilters);
        }

        if (priceMarketFilter) {
            priceMarketFilter.addEventListener("change", applyPriceFilters);
        }

        if (priceSortSelect) {
            priceSortSelect.addEventListener("change", applySorting);
        }
    }
});
/*
   PHASE 10 ADDITIONS — append everything below to the end of your
   existing resources/js/app.js. Independent DOMContentLoaded block, safe
   to paste after the Phase 1–9 code already in that file.
 */

document.addEventListener("DOMContentLoaded", function () {
    /*
       Live photo preview when attaching an image to a question
     */
    const questionImageInput = document.getElementById("image");
    const questionImagePreview = document.getElementById(
        "questionImagePreview",
    );
    const questionImagePlaceholder = document.getElementById(
        "questionImagePlaceholder",
    );

    if (
        questionImageInput &&
        questionImagePreview &&
        questionImagePlaceholder
    ) {
        questionImageInput.addEventListener("change", function (event) {
            const file = event.target.files[0];
            if (!file) {
                return;
            }

            const reader = new FileReader();
            reader.onload = function (readerEvent) {
                questionImagePreview.src = readerEvent.target.result;
                questionImagePreview.classList.remove("hidden");
                questionImagePlaceholder.classList.add("hidden");
            };
            reader.readAsDataURL(file);
        });
    }

    /*
       AJAX like/unlike toggle for answers
     */
    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        ?.getAttribute("content");

    document.querySelectorAll(".answer-like-btn").forEach(function (button) {
        button.addEventListener("click", function () {
            fetch(button.dataset.likeUrl, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                    Accept: "application/json",
                },
            })
                .then(function (response) {
                    if (!response.ok) throw new Error("Request failed");
                    return response.json();
                })
                .then(function (data) {
                    button.classList.toggle(
                        "answer-like-btn-active",
                        data.liked,
                    );
                    button.querySelector(".answer-like-icon").textContent =
                        data.liked ? "👍" : "👍🏻";
                    button.querySelector(".answer-like-count").textContent =
                        data.likes_count;
                })
                .catch(function () {
                    alert("Could not update your like. Please try again.");
                });
        });
    });

    /*
       Admin — Q&A search + status filter
     */
    const qaAdminList = document.getElementById("qaAdminList");

    if (qaAdminList) {
        const qaSearch = document.getElementById("qaSearch");
        const qaStatusButtons = document.querySelectorAll(
            "#qaStatusFilter .filter-btn",
        );
        const qaNoMatches = document.getElementById("qaNoMatches");
        let currentStatus = "all";

        function applyQaFilters() {
            const query = (qaSearch ? qaSearch.value : "").toLowerCase().trim();
            const rows = qaAdminList.querySelectorAll(".qa-admin-row");
            let visibleCount = 0;

            rows.forEach(function (row) {
                const matchesSearch = row.dataset.title.includes(query);
                const matchesStatus =
                    currentStatus === "all" ||
                    row.dataset.status === currentStatus;
                const shouldShow = matchesSearch && matchesStatus;

                row.style.display = shouldShow ? "" : "none";
                if (shouldShow) {
                    visibleCount++;
                }
            });

            if (qaNoMatches) {
                qaNoMatches.classList.toggle("hidden", visibleCount !== 0);
            }
        }

        if (qaSearch) {
            qaSearch.addEventListener("input", applyQaFilters);
        }

        qaStatusButtons.forEach(function (btn) {
            btn.addEventListener("click", function () {
                qaStatusButtons.forEach(function (b) {
                    b.classList.remove("active");
                });
                btn.classList.add("active");
                currentStatus = btn.dataset.status;
                applyQaFilters();
            });
        });
    }
});

/*
   PHASE 11 ADDITIONS — append everything below to the end of your
   existing resources/js/app.js. Independent DOMContentLoaded block, safe
   to paste after the Phase 1–10 code already in that file.
 */

document.addEventListener("DOMContentLoaded", function () {
    /*
       Live photo preview on the Admin Add/Edit News forms
     */
    const newsImageInput = document.getElementById("image");
    const newsImagePreview = document.getElementById("newsImagePreview");
    const newsImagePlaceholder = document.getElementById(
        "newsImagePlaceholder",
    );

    if (newsImageInput && newsImagePreview && newsImagePlaceholder) {
        newsImageInput.addEventListener("change", function (event) {
            const file = event.target.files[0];
            if (!file) {
                return;
            }

            const reader = new FileReader();
            reader.onload = function (readerEvent) {
                newsImagePreview.src = readerEvent.target.result;
                newsImagePreview.classList.remove("hidden");
                newsImagePlaceholder.classList.add("hidden");
            };
            reader.readAsDataURL(file);
        });
    }

    /*
       Admin — Delete News confirmation modal
     */
    const deleteNewsModal = document.getElementById("deleteNewsModal");
    const deleteNewsForm = document.getElementById("deleteNewsForm");
    const cancelDeleteNewsBtn = document.getElementById("cancelDeleteNews");

    if (deleteNewsModal && deleteNewsForm) {
        document
            .querySelectorAll("[data-open-delete-modal]")
            .forEach(function (button) {
                button.addEventListener("click", function () {
                    deleteNewsForm.setAttribute(
                        "action",
                        button.dataset.deleteUrl,
                    );
                    deleteNewsModal.classList.remove("hidden");
                });
            });

        if (cancelDeleteNewsBtn) {
            cancelDeleteNewsBtn.addEventListener("click", function () {
                deleteNewsModal.classList.add("hidden");
            });
        }

        deleteNewsModal.addEventListener("click", function (event) {
            if (event.target === deleteNewsModal) {
                deleteNewsModal.classList.add("hidden");
            }
        });
    }

    /*
       Farmer-facing — search + category filter + sort
     */
    const newsGrid = document.getElementById("newsGrid");

    if (newsGrid) {
        const newsSearch = document.getElementById("newsSearch");
        const newsCategoryButtons = document.querySelectorAll(
            "#newsCategoryFilter .filter-btn",
        );
        const newsSortSelect = document.getElementById("newsSortSelect");
        const newsNoMatches = document.getElementById("newsNoMatches");
        let currentCategory = "all";

        function applyNewsFilters() {
            const query = (newsSearch ? newsSearch.value : "")
                .toLowerCase()
                .trim();
            const cards = newsGrid.querySelectorAll(".news-card");
            let visibleCount = 0;

            cards.forEach(function (card) {
                const matchesSearch = card.dataset.title.includes(query);
                const matchesCategory =
                    currentCategory === "all" ||
                    card.dataset.category === currentCategory;
                const shouldShow = matchesSearch && matchesCategory;

                card.style.display = shouldShow ? "" : "none";
                if (shouldShow) {
                    visibleCount++;
                }
            });

            if (newsNoMatches) {
                newsNoMatches.classList.toggle("hidden", visibleCount !== 0);
            }
        }

        function applyNewsSorting() {
            const sortValue = newsSortSelect ? newsSortSelect.value : "recent";
            const cards = Array.from(newsGrid.querySelectorAll(".news-card"));

            cards.sort(function (a, b) {
                if (sortValue === "az") {
                    return a.dataset.title.localeCompare(b.dataset.title);
                }
                return (
                    parseInt(b.dataset.published, 10) -
                    parseInt(a.dataset.published, 10)
                );
            });

            cards.forEach(function (card) {
                newsGrid.appendChild(card);
            });
        }

        if (newsSearch) {
            newsSearch.addEventListener("input", applyNewsFilters);
        }

        newsCategoryButtons.forEach(function (btn) {
            btn.addEventListener("click", function () {
                newsCategoryButtons.forEach(function (b) {
                    b.classList.remove("active");
                });
                btn.classList.add("active");
                currentCategory = btn.dataset.category;
                applyNewsFilters();
            });
        });

        if (newsSortSelect) {
            newsSortSelect.addEventListener("change", applyNewsSorting);
        }
    }
});

/*
   PHASE 12 ADDITIONS — append everything below to the end of your
   existing resources/js/app.js. Independent DOMContentLoaded block, safe
   to paste after the Phase 1–11 code already in that file.
 */

document.addEventListener("DOMContentLoaded", function () {
    /*
       Interactive star rating — click to select, hover to preview
     */
    const starRating = document.getElementById("starRating");
    const ratingInput = document.getElementById("ratingInput");

    if (starRating && ratingInput) {
        const stars = Array.from(starRating.querySelectorAll(".star"));

        function paintStars(upToValue) {
            stars.forEach(function (star) {
                star.classList.toggle(
                    "star-active",
                    parseInt(star.dataset.value, 10) <= upToValue,
                );
            });
        }

        // Paint the initial state (e.g. after a validation error redisplay).
        paintStars(parseInt(ratingInput.value, 10) || 0);

        stars.forEach(function (star) {
            star.addEventListener("click", function () {
                ratingInput.value = star.dataset.value;
                paintStars(parseInt(star.dataset.value, 10));
            });

            star.addEventListener("mouseenter", function () {
                paintStars(parseInt(star.dataset.value, 10));
            });
        });

        starRating.addEventListener("mouseleave", function () {
            paintStars(parseInt(ratingInput.value, 10) || 0);
        });
    }

    /*
       Edit-in-place for the farmer's own feedback (same pattern as
       the Reminder Calendar's sidebar form from Phase 5)
     */
    const feedbackForm = document.getElementById("feedbackForm");

    if (feedbackForm) {
        const feedbackFormTitle = document.getElementById("feedbackFormTitle");
        const feedbackFormMethod =
            document.getElementById("feedbackFormMethod");
        const feedbackSubmitBtn = document.getElementById("feedbackSubmitBtn");
        const cancelEditFeedbackBtn =
            document.getElementById("cancelEditFeedback");
        const commentInput = document.getElementById("comment");

        function enterFeedbackEditMode(rating, comment, updateUrl) {
            ratingInput.value = rating;
            commentInput.value = comment || "";
            document
                .querySelectorAll("#starRating .star")
                .forEach(function (star) {
                    star.classList.toggle(
                        "star-active",
                        parseInt(star.dataset.value, 10) <=
                            parseInt(rating, 10),
                    );
                });

            feedbackForm.setAttribute("action", updateUrl);
            feedbackFormMethod.value = "PUT";
            feedbackFormTitle.textContent = "Edit Your Feedback";
            feedbackSubmitBtn.textContent = "Save Changes";
            cancelEditFeedbackBtn.classList.remove("hidden");

            document
                .getElementById("feedbackFormCard")
                .scrollIntoView({ behavior: "smooth", block: "start" });
        }

        function exitFeedbackEditMode() {
            ratingInput.value = 0;
            commentInput.value = "";
            document
                .querySelectorAll("#starRating .star")
                .forEach(function (star) {
                    star.classList.remove("star-active");
                });

            feedbackForm.setAttribute("action", feedbackForm.dataset.storeUrl);
            feedbackFormMethod.value = "POST";
            feedbackFormTitle.textContent = "Share Your Experience";
            feedbackSubmitBtn.textContent = "Submit Feedback";
            cancelEditFeedbackBtn.classList.add("hidden");
        }

        document.querySelectorAll(".feedback-edit-btn").forEach(function (btn) {
            btn.addEventListener("click", function () {
                enterFeedbackEditMode(
                    btn.dataset.rating,
                    btn.dataset.comment,
                    btn.dataset.updateUrl,
                );
            });
        });

        if (cancelEditFeedbackBtn) {
            cancelEditFeedbackBtn.addEventListener(
                "click",
                exitFeedbackEditMode,
            );
        }
    }

    /*
       Delete confirmation modal (farmer's own feedback)
     */
    const deleteFeedbackModal = document.getElementById("deleteFeedbackModal");
    const deleteFeedbackForm = document.getElementById("deleteFeedbackForm");
    const cancelDeleteFeedbackBtn = document.getElementById(
        "cancelDeleteFeedback",
    );

    if (deleteFeedbackModal && deleteFeedbackForm) {
        document
            .querySelectorAll(".feedback-delete-btn")
            .forEach(function (button) {
                button.addEventListener("click", function () {
                    deleteFeedbackForm.setAttribute(
                        "action",
                        button.dataset.deleteUrl,
                    );
                    deleteFeedbackModal.classList.remove("hidden");
                });
            });

        if (cancelDeleteFeedbackBtn) {
            cancelDeleteFeedbackBtn.addEventListener("click", function () {
                deleteFeedbackModal.classList.add("hidden");
            });
        }

        deleteFeedbackModal.addEventListener("click", function (event) {
            if (event.target === deleteFeedbackModal) {
                deleteFeedbackModal.classList.add("hidden");
            }
        });
    }

    /*
       Admin — Feedback search + rating filter + status filter + sort
     */
    const feedbackAdminList = document.getElementById("feedbackAdminList");

    if (feedbackAdminList) {
        const feedbackSearch = document.getElementById("feedbackSearch");
        const feedbackRatingFilter = document.getElementById(
            "feedbackRatingFilter",
        );
        const feedbackStatusButtons = document.querySelectorAll(
            "#feedbackStatusFilter .filter-btn",
        );
        const feedbackSortSelect =
            document.getElementById("feedbackSortSelect");
        const feedbackNoMatches = document.getElementById("feedbackNoMatches");
        let currentStatus = "all";

        function applyFeedbackFilters() {
            const query = (feedbackSearch ? feedbackSearch.value : "")
                .toLowerCase()
                .trim();
            const ratingValue = feedbackRatingFilter
                ? feedbackRatingFilter.value
                : "all";
            const cards = feedbackAdminList.querySelectorAll(
                ".feedback-admin-card",
            );
            let visibleCount = 0;

            cards.forEach(function (card) {
                const matchesSearch = card.dataset.title.includes(query);
                const matchesRating =
                    ratingValue === "all" ||
                    card.dataset.rating === ratingValue;
                const matchesStatus =
                    currentStatus === "all" ||
                    card.dataset.status === currentStatus;
                const shouldShow =
                    matchesSearch && matchesRating && matchesStatus;

                card.style.display = shouldShow ? "" : "none";
                if (shouldShow) {
                    visibleCount++;
                }
            });

            if (feedbackNoMatches) {
                feedbackNoMatches.classList.toggle(
                    "hidden",
                    visibleCount !== 0,
                );
            }
        }

        function applyFeedbackSorting() {
            const sortValue = feedbackSortSelect
                ? feedbackSortSelect.value
                : "recent";
            const cards = Array.from(
                feedbackAdminList.querySelectorAll(".feedback-admin-card"),
            );

            cards.sort(function (a, b) {
                switch (sortValue) {
                    case "highest":
                        return (
                            parseInt(b.dataset.rating, 10) -
                            parseInt(a.dataset.rating, 10)
                        );
                    case "lowest":
                        return (
                            parseInt(a.dataset.rating, 10) -
                            parseInt(b.dataset.rating, 10)
                        );
                    case "recent":
                    default:
                        return (
                            parseInt(b.dataset.created, 10) -
                            parseInt(a.dataset.created, 10)
                        );
                }
            });

            cards.forEach(function (card) {
                feedbackAdminList.appendChild(card);
            });
        }

        if (feedbackSearch) {
            feedbackSearch.addEventListener("input", applyFeedbackFilters);
        }

        if (feedbackRatingFilter) {
            feedbackRatingFilter.addEventListener(
                "change",
                applyFeedbackFilters,
            );
        }

        feedbackStatusButtons.forEach(function (btn) {
            btn.addEventListener("click", function () {
                feedbackStatusButtons.forEach(function (b) {
                    b.classList.remove("active");
                });
                btn.classList.add("active");
                currentStatus = btn.dataset.status;
                applyFeedbackFilters();
            });
        });

        if (feedbackSortSelect) {
            feedbackSortSelect.addEventListener("change", applyFeedbackSorting);
        }
    }
});
/*
   PHASE 13 ADDITIONS — append everything below to the end of your
   existing resources/js/app.js. Independent DOMContentLoaded block, safe
   to paste after the Phase 1–12 code already in that file.
 */

document.addEventListener("DOMContentLoaded", function () {
    /*
       Live crop photo preview on the Admin Add/Edit Fertilizer forms
     */
    const fertilizerImageInput = document.getElementById("crop_image");
    const fertilizerImagePreview = document.getElementById(
        "fertilizerImagePreview",
    );
    const fertilizerImagePlaceholder = document.getElementById(
        "fertilizerImagePlaceholder",
    );

    if (
        fertilizerImageInput &&
        fertilizerImagePreview &&
        fertilizerImagePlaceholder
    ) {
        fertilizerImageInput.addEventListener("change", function (event) {
            const file = event.target.files[0];
            if (!file) {
                return;
            }

            const reader = new FileReader();
            reader.onload = function (readerEvent) {
                fertilizerImagePreview.src = readerEvent.target.result;
                fertilizerImagePreview.classList.remove("hidden");
                fertilizerImagePlaceholder.classList.add("hidden");
            };
            reader.readAsDataURL(file);
        });
    }

    /*
       Admin — Delete Fertilizer confirmation modal
     */
    const deleteFertilizerModal = document.getElementById(
        "deleteFertilizerModal",
    );
    const deleteFertilizerForm = document.getElementById(
        "deleteFertilizerForm",
    );
    const cancelDeleteFertilizerBtn = document.getElementById(
        "cancelDeleteFertilizer",
    );

    if (deleteFertilizerModal && deleteFertilizerForm) {
        document
            .querySelectorAll("[data-open-delete-modal]")
            .forEach(function (button) {
                button.addEventListener("click", function () {
                    deleteFertilizerForm.setAttribute(
                        "action",
                        button.dataset.deleteUrl,
                    );
                    deleteFertilizerModal.classList.remove("hidden");
                });
            });

        if (cancelDeleteFertilizerBtn) {
            cancelDeleteFertilizerBtn.addEventListener("click", function () {
                deleteFertilizerModal.classList.add("hidden");
            });
        }

        deleteFertilizerModal.addEventListener("click", function (event) {
            if (event.target === deleteFertilizerModal) {
                deleteFertilizerModal.classList.add("hidden");
            }
        });
    }

    /*
       Farmer-facing — live search by crop name
     */
    const fertilizerGrid = document.getElementById("fertilizerGrid");

    if (fertilizerGrid) {
        const fertilizerSearch = document.getElementById("fertilizerSearch");
        const fertilizerNoMatches = document.getElementById(
            "fertilizerNoMatches",
        );

        function applyFertilizerSearch() {
            const query = (fertilizerSearch ? fertilizerSearch.value : "")
                .toLowerCase()
                .trim();
            const cards = fertilizerGrid.querySelectorAll(".fertilizer-card");
            let visibleCount = 0;

            cards.forEach(function (card) {
                const shouldShow = card.dataset.title.includes(query);
                card.style.display = shouldShow ? "" : "none";
                if (shouldShow) {
                    visibleCount++;
                }
            });

            if (fertilizerNoMatches) {
                fertilizerNoMatches.classList.toggle(
                    "hidden",
                    visibleCount !== 0,
                );
            }
        }

        if (fertilizerSearch) {
            fertilizerSearch.addEventListener("input", applyFertilizerSearch);
        }
    }
});

/*
   PHASE 14 ADDITIONS — append everything below to the end of your
   existing resources/js/app.js. Independent DOMContentLoaded block, safe
   to paste after the Phase 1–13 code already in that file.
 */

document.addEventListener("DOMContentLoaded", function () {
    const searchTrigger = document.getElementById("searchTrigger");
    const searchPanel = document.getElementById("searchPanel");
    const searchInput = document.getElementById("globalSearchInput");

    // Everything below only applies where the search panel exists
    // (i.e. any authenticated page, since it lives in the navbar).
    if (!searchTrigger || !searchPanel || !searchInput) {
        return;
    }

    const searchUrl = searchInput.dataset.searchUrl;
    const clearBtn = document.getElementById("clearSearchBtn");
    const loadingSpinner = document.getElementById("searchLoadingSpinner");
    const categoryFilter = document.getElementById("searchCategoryFilter");
    const sortSelect = document.getElementById("searchSortSelect");
    const resultsList = document.getElementById("searchResultsList");
    const emptyState = document.getElementById("searchEmptyState");
    const emptyQuerySpan = document.getElementById("searchEmptyQuery");
    const searchHint = document.getElementById("searchHint");
    const recentWrap = document.getElementById("searchRecentWrap");
    const recentChips = document.getElementById("searchRecentChips");

    const CATEGORY_ORDER = [
        "crops",
        "tips",
        "saved_tips",
        "questions",
        "prices",
        "news",
        "diseases",
        "fertilizers",
        "reminders",
        "feedback",
    ];
    const RECENT_KEY = "krishiBondhuRecentSearches";
    const DEBOUNCE_MS = 350;

    let debounceTimer = null;
    let currentResults = null;
    let lastQuery = "";

    /*
       Open / close the panel
     */
    function openPanel() {
        searchPanel.classList.add("open");
        searchInput.focus();
        renderRecentSearches();
    }

    function closePanel() {
        searchPanel.classList.remove("open");
    }

    searchTrigger.addEventListener("click", function (event) {
        event.stopPropagation();
        searchPanel.classList.contains("open") ? closePanel() : openPanel();
    });

    document.addEventListener("click", function (event) {
        if (
            !searchPanel.contains(event.target) &&
            !searchTrigger.contains(event.target)
        ) {
            closePanel();
        }
    });

    document.addEventListener("keydown", function (event) {
        if (event.key === "Escape") {
            closePanel();
        }
    });

    /*
       Recent searches (sessionStorage — clears when the tab closes,
       matching the spec's "during the current session" wording)
     */
    function getRecentSearches() {
        try {
            return JSON.parse(sessionStorage.getItem(RECENT_KEY) || "[]");
        } catch (e) {
            return [];
        }
    }

    function rememberSearch(query) {
        let recent = getRecentSearches().filter(function (item) {
            return item !== query;
        });
        recent.unshift(query);
        recent = recent.slice(0, 6);
        sessionStorage.setItem(RECENT_KEY, JSON.stringify(recent));
    }

    function renderRecentSearches() {
        const recent = getRecentSearches();

        if (recent.length === 0 || searchInput.value.trim() !== "") {
            recentWrap.classList.add("hidden");
            return;
        }

        recentChips.innerHTML = recent
            .map(function (term) {
                return (
                    '<button type="button" class="search-recent-chip" data-term="' +
                    escapeHtml(term) +
                    '">' +
                    escapeHtml(term) +
                    "</button>"
                );
            })
            .join("");

        recentWrap.classList.remove("hidden");

        recentChips
            .querySelectorAll(".search-recent-chip")
            .forEach(function (chip) {
                chip.addEventListener("click", function () {
                    searchInput.value = chip.dataset.term;
                    runSearch(chip.dataset.term);
                });
            });
    }

    /*
       Escaping + highlighting helpers
     */
    function escapeHtml(str) {
        const div = document.createElement("div");
        div.textContent = str;
        return div.innerHTML;
    }

    function highlight(text, query) {
        const escaped = escapeHtml(text);
        if (!query) {
            return escaped;
        }
        const escapedQuery = query.replace(/[.*+?^${}()|[\]\\]/g, "\\$&");
        const regex = new RegExp("(" + escapedQuery + ")", "gi");
        return escaped.replace(regex, "<mark>$1</mark>");
    }

    const CATEGORY_ICONS = {
        crops: "🌱",
        tips: "💡",
        saved_tips: "🔖",
        questions: "❓",
        prices: "💰",
        news: "📰",
        diseases: "🚨",
        fertilizers: "🧪",
        reminders: "📅",
        feedback: "⭐",
    };

    const CATEGORY_LABELS = {
        crops: "Crops",
        tips: "Farming Tips",
        saved_tips: "Saved Tips",
        questions: "Question & Answer",
        prices: "Crop Prices",
        news: "Agriculture News",
        diseases: "Disease Alerts",
        fertilizers: "Fertilizer Guide",
        reminders: "Reminders",
        feedback: "Feedback",
    };

    /*
       Sorting — flattens all results together, sorts them, then
       regroups by category so sorting can also change WHICH category
       appears first (e.g. "Newest" should surface the single most
       recent result overall, even if every category only has one item).
     */
    function flattenResults(data) {
        const flat = [];
        CATEGORY_ORDER.forEach(function (key) {
            const items = data.results[key];
            if (!items) {
                return;
            }
            items.forEach(function (item) {
                const copy = Object.assign({}, item);
                copy._category = key;
                flat.push(copy);
            });
        });
        return flat;
    }

    function sortFlatItems(flat, sortValue) {
        const copy = flat.slice();

        switch (sortValue) {
            case "newest":
                return copy.sort(function (a, b) {
                    return (b.timestamp || 0) - (a.timestamp || 0);
                });
            case "oldest":
                return copy.sort(function (a, b) {
                    return (a.timestamp || 0) - (b.timestamp || 0);
                });
            case "az":
                return copy.sort(function (a, b) {
                    return a.title.localeCompare(b.title);
                });
            case "relevance":
            default:
                return copy; // keep the default category-priority + backend order
        }
    }

    /*
       Rendering
     */
    function renderResults(data, query) {
        currentResults = data;
        const sortValue = sortSelect.value;

        if (data.total === 0) {
            resultsList.innerHTML = "";
            emptyQuerySpan.textContent = query;
            emptyState.classList.remove("hidden");
            searchHint.classList.add("hidden");
            recentWrap.classList.add("hidden");
            return;
        }

        emptyState.classList.add("hidden");
        searchHint.classList.add("hidden");
        recentWrap.classList.add("hidden");

        // Sort everything together first...
        const flat = flattenResults(data);
        const sorted = sortFlatItems(flat, sortValue);

        // ...then regroup by category, using the ORDER categories first
        // appear in the sorted list to decide which group renders first.
        const grouped = {};
        const categoryDisplayOrder = [];

        sorted.forEach(function (item) {
            if (!grouped[item._category]) {
                grouped[item._category] = [];
                categoryDisplayOrder.push(item._category);
            }
            grouped[item._category].push(item);
        });

        let html = "";

        categoryDisplayOrder.forEach(function (key) {
            const items = grouped[key];

            html += '<div class="search-category-group">';
            html +=
                '<div class="search-category-heading">' +
                CATEGORY_ICONS[key] +
                " " +
                CATEGORY_LABELS[key] +
                "</div>";

            items.forEach(function (item) {
                html +=
                    '<a href="' +
                    item.url +
                    '" class="search-result-item">' +
                    '<span class="search-result-icon">' +
                    item.icon +
                    "</span>" +
                    '<div class="search-result-body">' +
                    '<p class="search-result-title">' +
                    highlight(item.title, query) +
                    "</p>" +
                    '<p class="search-result-desc">' +
                    highlight(item.description || "", query) +
                    "</p>" +
                    "</div>" +
                    '<span class="search-result-date">' +
                    (item.date || "") +
                    "</span>" +
                    "</a>";
            });

            html += "</div>";
        });

        resultsList.innerHTML = html;
    }

    /*
       Fetching
     */
    function runSearch(query) {
        lastQuery = query;
        clearBtn.classList.toggle("hidden", query.length === 0);

        if (query.trim().length < 2) {
            resultsList.innerHTML = "";
            emptyState.classList.add("hidden");
            searchHint.classList.toggle("hidden", query.length === 0);
            renderRecentSearches();
            return;
        }

        searchHint.classList.add("hidden");
        recentWrap.classList.add("hidden");
        loadingSpinner.classList.remove("hidden");

        const params = new URLSearchParams({
            q: query,
            category: categoryFilter.value,
        });

        fetch(searchUrl + "?" + params.toString(), {
            headers: { Accept: "application/json" },
        })
            .then(function (response) {
                return response.json();
            })
            .then(function (data) {
                loadingSpinner.classList.add("hidden");
                renderResults(data, query);
                if (data.total > 0) {
                    rememberSearch(query);
                }
            })
            .catch(function () {
                loadingSpinner.classList.add("hidden");
                resultsList.innerHTML =
                    '<p class="search-hint">Something went wrong. Please try again.</p>';
            });
    }

    /*
       Event bindings
     */
    searchInput.addEventListener("input", function () {
        clearTimeout(debounceTimer);
        const query = searchInput.value;
        debounceTimer = setTimeout(function () {
            runSearch(query);
        }, DEBOUNCE_MS);
    });

    categoryFilter.addEventListener("change", function () {
        if (lastQuery.trim().length >= 2) {
            runSearch(lastQuery);
        }
    });

    sortSelect.addEventListener("change", function () {
        if (currentResults) {
            renderResults(currentResults, lastQuery);
        }
    });

    clearBtn.addEventListener("click", function () {
        searchInput.value = "";
        clearBtn.classList.add("hidden");
        resultsList.innerHTML = "";
        emptyState.classList.add("hidden");
        searchHint.classList.add("hidden");
        searchInput.focus();
        renderRecentSearches();
    });
});
