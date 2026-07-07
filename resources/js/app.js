
document.addEventListener('DOMContentLoaded', function () {

    /* 
       Profile dropdown (navbar top-right)
    */
    const profileTrigger = document.getElementById('profileTrigger');
    const profileDropdown = document.getElementById('profileDropdown');

    if (profileTrigger && profileDropdown) {
        profileTrigger.addEventListener('click', function (event) {
            event.stopPropagation();
            profileDropdown.classList.toggle('open');
        });

        document.addEventListener('click', function (event) {
            if (!profileDropdown.contains(event.target) && !profileTrigger.contains(event.target)) {
                profileDropdown.classList.remove('open');
            }
        });
    }

    /* 
       Mobile hamburger menu
    */
    const navbarToggle = document.getElementById('navbarToggle');
    const navbarMenu = document.getElementById('navbarMenu');

    if (navbarToggle && navbarMenu) {
        navbarToggle.addEventListener('click', function () {
            navbarMenu.classList.toggle('open');
        });
    }

    /* 
       Live profile photo preview on the Edit Profile page
    */
    const photoInput = document.getElementById('photo');
    const photoPreview = document.getElementById('photoPreview');
    const photoPlaceholder = document.getElementById('photoPlaceholder');

    if (photoInput && photoPreview && photoPlaceholder) {
        photoInput.addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (!file) {
                return;
            }

            const reader = new FileReader();
            reader.onload = function (readerEvent) {
                photoPreview.src = readerEvent.target.result;
                photoPreview.classList.remove('hidden');
                photoPlaceholder.classList.add('hidden');
            };
            reader.readAsDataURL(file);
        });
    }

    /* 
       Delete Account confirmation modal
       */
    const openDeleteModalBtn = document.getElementById('openDeleteAccountModal');
    const deleteModal = document.getElementById('deleteAccountModal');
    const cancelDeleteBtn = document.getElementById('cancelDeleteAccount');

    if (openDeleteModalBtn && deleteModal && cancelDeleteBtn) {
        openDeleteModalBtn.addEventListener('click', function () {
            deleteModal.classList.remove('hidden');
        });

        cancelDeleteBtn.addEventListener('click', function () {
            deleteModal.classList.add('hidden');
        });

        deleteModal.addEventListener('click', function (event) {
            if (event.target === deleteModal) {
                deleteModal.classList.add('hidden');
            }
        });
    }

});
