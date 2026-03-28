// Reset modals on page load
document.addEventListener('DOMContentLoaded', function() {
    // Ensure all modals are closed and body overflow is reset
    const allModals = document.querySelectorAll('.modal, [id*="Modal"]');
    allModals.forEach(modal => {
        modal.style.display = 'none';
    });
    document.body.style.overflow = 'auto';
});

function openModal(imageSrc, imageName) {
    const modal = document.getElementById('imageModal');
    const modalImg = document.getElementById('modalImage');
    const captionText = document.getElementById('caption');
    
    modal.style.display = 'block';
    modalImg.src = imageSrc;
    captionText.innerHTML = imageName;
    
    // Prevent body scroll when modal is open
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    const modal = document.getElementById('imageModal');
    modal.style.display = 'none';
    
    // Restore body scroll
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside the image
window.onclick = function(event) {
    const modal = document.getElementById('imageModal');
    if (modal && event.target == modal) {
        closeModal();
    }
}

// Close modal with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeModal();
    }
});
