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
