// resources/js/report.js

document.addEventListener("DOMContentLoaded", () => {

    const modal = document.getElementById('reportModal');
    const modalContent = document.getElementById('reportModalContent');
    const openBtn = document.getElementById('openReportBtn');
    const closeBtn = document.getElementById('closeReportBtn');

    // ---------- MODAL OPEN ----------
    if (openBtn) {
        openBtn.addEventListener('click', () => {
            modal.classList.remove('invisible');
            modal.classList.add('opacity-100');
            modalContent.classList.remove('scale-95');
            modalContent.classList.add('scale-100');
            document.body.classList.add('overflow-hidden');
        });
    }

    // ---------- MODAL CLOSE ----------
    if (closeBtn) {
        closeBtn.addEventListener('click', closeModal);
    }

    if (modal) {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeModal();
            }
        });
    }

    function closeModal() {
        modal.classList.remove('opacity-100');
        modal.classList.add('opacity-0');
        modalContent.classList.remove('scale-100');
        modalContent.classList.add('scale-95');

        setTimeout(() => {
            modal.classList.add('invisible');
        }, 300);

        document.body.classList.remove('overflow-hidden');
    }

    // ---------- IMAGE PREVIEW ----------
    const imageInput = document.getElementById('image');
    const preview = document.getElementById('imagePreview');
    const placeholder = document.getElementById('uploadPlaceholder');

    if (imageInput && preview && placeholder) {
        imageInput.addEventListener('change', (event) => {
            const file = event.target.files[0];

            if (!file) return;

            const reader = new FileReader();

            reader.onload = (e) => {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            };

            reader.readAsDataURL(file);
        });
    }

});

// SUCCESS MODAL ANIMATION
document.addEventListener("DOMContentLoaded", () => {

    const successModal = document.getElementById('successModal');
    const successContent = document.getElementById('successModalContent');
    const closeBtn = document.getElementById('closeSuccessModal');

    if (successModal && successContent) {

        // Animate open
        setTimeout(() => {
            successContent.classList.remove('scale-95', 'opacity-0');
            successContent.classList.add('scale-100', 'opacity-100');
        }, 50);

        // Close button
        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                successModal.remove();
            });
        }

        // Click outside
        successModal.addEventListener('click', (e) => {
            if (e.target === successModal) {
                successModal.remove();
            }
        });
    }
});