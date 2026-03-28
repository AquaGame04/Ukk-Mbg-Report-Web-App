const filterSchool = document.getElementById('filter-school');
const resetBtn = document.getElementById('reset-filter');
const sppgContainer = document.getElementById('sppg-container');
const noResults = document.getElementById('no-results');
const filteredCount = document.getElementById('filtered-count');
const allCards = document.querySelectorAll('.sppg-team-card');

function filterSPPG() {
    const selectedSchool = filterSchool.value;
    let visibleCount = 0;

    allCards.forEach(card => {
        const cardSchool = card.dataset.school;

        if (!selectedSchool || cardSchool === selectedSchool) {
            card.style.display = '';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });

    noResults.style.display = visibleCount === 0 ? 'block' : 'none';
    filteredCount.textContent = visibleCount;
}

function resetFilter() {
    filterSchool.value = '';
    filterSPPG();
}

filterSchool.addEventListener('change', filterSPPG);
resetBtn.addEventListener('click', resetFilter);

const detailButtons = document.querySelectorAll('.btn-detail');
const overlay = document.getElementById('sppg-detail-overlay');
const overlayClose = document.getElementById('overlay-close');

const photoOverlay = document.getElementById('photo-preview-overlay');
const photoPreviewImage = document.getElementById('photo-preview-img');
const photoOverlayClose = document.getElementById('photo-preview-close');

function openPhotoOverlay(src, alt) {
    if (!photoOverlay || !photoPreviewImage) return;
    photoPreviewImage.src = src;
    photoPreviewImage.alt = alt || 'Foto Tim SPPG';
    photoOverlay.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closePhotoOverlay() {
    if (!photoOverlay) return;
    photoOverlay.classList.remove('active');
    photoPreviewImage.src = '';
    photoPreviewImage.alt = '';
    document.body.style.overflow = '';
}

function openOverlay(data) {
    document.getElementById('ov-id').textContent = data.id_sppg || '-';
    document.getElementById('ov-nama').textContent = data.nama_tim || '-';
    document.getElementById('ov-jabatan').textContent = data.jabatan || '-';
    document.getElementById('ov-ketua').textContent = data.ketua_nama || data.ketua_tim || '-';
    document.getElementById('ov-kontak-tim').textContent = data.kontak_tim || '-';

    const anggotaList = document.getElementById('ov-anggota');
    anggotaList.innerHTML = '';
    const anggotaText = data.anggota_nama || (data.anggota_tim ? data.anggota_tim : '-');

    if (anggotaText === '-') {
        const li = document.createElement('li');
        li.textContent = '-';
        anggotaList.appendChild(li);
    } else {
        anggotaText.split(',').forEach(item => {
            const trimmed = item.trim();
            if (trimmed.length > 0) {
                const li = document.createElement('li');
                li.textContent = trimmed;
                anggotaList.appendChild(li);
            }
        });
    }

    document.getElementById('ov-nama-sekolah').textContent = data.nama_sekolah || '-';
    document.getElementById('ov-alamat').textContent = data.alamat || '-';
    document.getElementById('ov-kontak-sekolah').textContent = data.kontak || '-';

    const ovPhoto = document.getElementById('ov-photo');
    ovPhoto.innerHTML = '';
    if (data.foto_tim) {
        const img = document.createElement('img');
        img.src = '../assets/uploads/sppg/' + data.foto_tim;
        img.alt = data.nama_tim || 'Foto Tim SPPG';
        img.style.cursor = 'pointer';
        img.addEventListener('click', (event) => {
            event.stopPropagation();
            openPhotoOverlay(img.src, img.alt);
        });
        ovPhoto.appendChild(img);
    } else {
        const noPhoto = document.createElement('div');
        noPhoto.className = 'no-photo';
        noPhoto.textContent = 'Foto tidak tersedia';
        ovPhoto.appendChild(noPhoto);
    }

    overlay.style.display = 'grid';
    document.body.style.overflow = 'hidden';
}

function closeOverlay() {
    overlay.style.display = 'none';
    document.body.style.overflow = '';
}

detailButtons.forEach(button => {
    button.addEventListener('click', () => {
        const card = button.closest('.sppg-team-card');
        if (!card) return;

        const raw = card.dataset.detail;
        if (!raw) return;

        let data;
        try {
            data = JSON.parse(raw);
        } catch (e) {
            console.error('Gagal parsing data detail SPPG', e);
            return;
        }

        openOverlay(data);
    });
});

overlayClose.addEventListener('click', closeOverlay);
overlay.addEventListener('click', e => {
    if (e.target === overlay) {
        closeOverlay();
    }
});

if (photoOverlayClose) {
    photoOverlayClose.addEventListener('click', closePhotoOverlay);
}

if (photoOverlay) {
    photoOverlay.addEventListener('click', e => {
        if (e.target === photoOverlay) {
            closePhotoOverlay();
        }
    });
}

const teamPhotos = document.querySelectorAll('.team-photo');
teamPhotos.forEach(img => {
    img.addEventListener('click', () => {
        openPhotoOverlay(img.src, img.alt || 'Foto Tim SPPG');
    });
});
