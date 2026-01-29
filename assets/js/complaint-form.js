// Handle complaint form submission with AJAX
document.getElementById('complaint-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    formData.append('kirim_aduan', '1');
    
    fetch('process/pengaduan/pengaduan_add_process.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        // Check if response is ok
        if (!response.ok) {
            throw new Error('Network response was not ok: ' + response.status);
        }
        return response.text();
    })
    .then(text => {
        // Try to parse JSON, if it fails log the text
        try {
            return JSON.parse(text);
        } catch (e) {
            console.error('Failed to parse JSON:', text);
            throw new Error('Invalid response from server');
        }
    })
    .then(data => {
        const alertContainer = document.getElementById('alert-container');
        const alertType = data.success ? 'success' : 'error';
        const alertIcon = data.success ? '✓' : '⚠';
        
        let alertHTML = `
            <div class="alert alert-${alertType}">
                <span class="alert-icon">${alertIcon}</span>
                <div class="alert-message">
                    <span>${data.message}</span>
        `;
        
        if (data.success) {
            alertHTML += `<span class="ticket-info">Simpan nomor referensi untuk melacak pengaduan Anda: <strong>#${data.id_pengaduan}</strong></span>`;
        }
        
        alertHTML += `</div></div>`;
        
        alertContainer.innerHTML = alertHTML;
        
        // Scroll to alert
        alertContainer.scrollIntoView({ behavior: 'smooth' });
        
        // Reset form if success
        if (data.success) {
            document.getElementById('complaint-form').reset();
            
            // Hide alert after 5 seconds
            setTimeout(() => {
                alertContainer.innerHTML = '';
            }, 5000);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        const alertContainer = document.getElementById('alert-container');
        alertContainer.innerHTML = `
            <div class="alert alert-error">
                <span class="alert-icon">⚠</span>
                <span class="alert-message">Terjadi kesalahan: ${error.message}</span>
            </div>
        `;
    });
});
