// Reset modals on page load
document.addEventListener('DOMContentLoaded', function() {
    // Ensure modal is closed and body overflow is reset
    const modal = document.getElementById('menuModal');
    if (modal) {
        modal.style.display = 'none';
    }
    document.body.style.overflow = 'auto';
});

function openMenuDetail(menuId) {
    // Fetch menu data from server
    fetch(`../../../api/menu_detail.php?id=${menuId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const menu = data.menu;
                const gizi = data.gizi || {};
                
                // Set image
                document.getElementById('menuDetailImage').src = `../../../assets/uploads/menu/${menu.foto_url}`;
                
                // Set basic info
                document.getElementById('menuDetailName').textContent = menu.nama_menu;
                document.getElementById('menuDetailDate').textContent = formatDate(menu.tanggal);
                document.getElementById('menuDetailSchool').textContent = menu.nama_sekolah;
                
                // Set nutrition info
                document.getElementById('menuDetailKalori').textContent = gizi.kalori || '-';
                document.getElementById('menuDetailEnergi').textContent = gizi.energi || '-';
                document.getElementById('menuDetailProtein').textContent = gizi.protein || '-';
                document.getElementById('menuDetailKarbohidrat').textContent = gizi.karbohidrat || '-';
                document.getElementById('menuDetailLemak').textContent = gizi.lemak || '-';
                document.getElementById('menuDetailSerat').textContent = gizi.serat || '-';
                
                // Show modal
                document.getElementById('menuModal').style.display = 'block';
                document.body.style.overflow = 'hidden';
            }
        })
        .catch(error => console.error('Error:', error));
}

function closeMenuDetail() {
    document.getElementById('menuModal').style.display = 'none';
    document.body.style.overflow = 'auto';
}

function formatDate(dateString) {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('id-ID', options);
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('menuModal');
    if (modal && event.target == modal) {
        closeMenuDetail();
    }
}

// Close modal with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeMenuDetail();
    }
});
