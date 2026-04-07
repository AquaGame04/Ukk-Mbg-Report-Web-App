# Mermaid Flowchart Diagrams - MBG Report System

Berikut adalah flowchart dalam format Mermaid yang dapat dilihat di GitHub dan platform lain yang mendukung Mermaid.

---

## 1. ALUR KERJA USER (Publik)

```mermaid
flowchart TD
    Start([Mulai])
    Home["📱 Halaman Utama<br/>MBG Report"]
    Choice{Pilih Aksi}
    
    MenuToday["📅 Lihat Menu Hari Ini"]
    MenuHistory["📊 Lihat Riwayat Menu"]
    ViewSPPG["👥 Lihat Tim SPPG"]
    CreateComplaint["📝 Buat Pengaduan"]
    ViewComplaints["📋 Lihat Daftar Pengaduan"]
    
    ComplaintForm["Isi Form Pengaduan"]
    UploadEvidence["📸 Upload Bukti Foto"]
    ComplaintSuccess["✅ Pengaduan Terkirim"]
    
    ViewData["📊 Tampilkan Data"]
    
    Continue{Lanjut Aksi Lain?}
    End([Selesai])
    
    Start --> Home
    Home --> Choice
    
    Choice -->|Opsi 1| MenuToday
    Choice -->|Opsi 2| MenuHistory
    Choice -->|Opsi 3| ViewSPPG
    Choice -->|Opsi 4| CreateComplaint
    Choice -->|Opsi 5| ViewComplaints
    
    MenuToday --> ViewData
    MenuHistory --> ViewData
    ViewSPPG --> ViewData
    ViewComplaints --> ViewData
    
    CreateComplaint --> ComplaintForm
    ComplaintForm --> UploadEvidence
    UploadEvidence --> ComplaintSuccess
    
    ViewData --> Continue
    ComplaintSuccess --> Continue
    
    Continue -->|Ya| Choice
    Continue -->|Tidak| End
    
    style Start fill:#4CAF50,color:#fff
    style End fill:#F44336,color:#fff
    style Home fill:#2196F3,color:#fff
    style MenuToday fill:#2196F3,color:#fff
    style MenuHistory fill:#2196F3,color:#fff
    style ViewSPPG fill:#2196F3,color:#fff
    style CreateComplaint fill:#2196F3,color:#fff
    style ViewComplaints fill:#2196F3,color:#fff
    style ComplaintForm fill:#9C27B0,color:#fff
    style UploadEvidence fill:#9C27B0,color:#fff
    style ComplaintSuccess fill:#4CAF50,color:#fff
    style ViewData fill:#00BCD4,color:#fff
    style Choice fill:#FF9800
    style Continue fill:#F44336
```

---

## 2. ALUR KERJA ADMIN

```mermaid
flowchart TD
    Start([Mulai])
    Login["🔐 Login Admin"]
    Dashboard["📊 Dashboard Admin"]
    MainMenu{Pilih Menu Utama}
    
    ManageUsers["👤 Kelola User"]
    ManageSchools["🏫 Kelola Sekolah"]
    ManageSPPG["👥 Kelola Tim SPPG"]
    ManageMenu["🍽️ Input Menu & Gizi"]
    ManageComplaints["📋 Kelola Pengaduan"]
    
    UserActions["✏️ Tambah/Edit/Hapus User"]
    SchoolActions["✏️ Tambah/Edit/Hapus Sekolah"]
    SPPGActions["✏️ Tambah/Edit/Hapus SPPG"]
    MenuActions["✏️ Tambah/Edit/Hapus Menu"]
    ComplaintActions["✏️ Update Status & Catatan"]
    
    Saved["✅ Data Tersimpan"]
    Continue{Lanjut?}
    Logout["🚪 Logout"]
    End([Selesai])
    
    Start --> Login
    Login --> Dashboard
    Dashboard --> MainMenu
    
    MainMenu -->|1| ManageUsers
    MainMenu -->|2| ManageSchools
    MainMenu -->|3| ManageSPPG
    MainMenu -->|4| ManageMenu
    MainMenu -->|5| ManageComplaints
    
    ManageUsers --> UserActions
    ManageSchools --> SchoolActions
    ManageSPPG --> SPPGActions
    ManageMenu --> MenuActions
    ManageComplaints --> ComplaintActions
    
    UserActions --> Saved
    SchoolActions --> Saved
    SPPGActions --> Saved
    MenuActions --> Saved
    ComplaintActions --> Saved
    
    Saved --> Continue
    Continue -->|Ya| MainMenu
    Continue -->|Tidak| Logout
    Logout --> End
    
    style Start fill:#4CAF50,color:#fff
    style End fill:#F44336,color:#fff
    style Login fill:#2196F3,color:#fff
    style Dashboard fill:#2196F3,color:#fff
    style ManageUsers fill:#9C27B0,color:#fff
    style ManageSchools fill:#9C27B0,color:#fff
    style ManageSPPG fill:#9C27B0,color:#fff
    style ManageMenu fill:#9C27B0,color:#fff
    style ManageComplaints fill:#9C27B0,color:#fff
    style UserActions fill:#00BCD4,color:#fff
    style SchoolActions fill:#00BCD4,color:#fff
    style SPPGActions fill:#00BCD4,color:#fff
    style MenuActions fill:#00BCD4,color:#fff
    style ComplaintActions fill:#00BCD4,color:#fff
    style Saved fill:#4CAF50,color:#fff
    style Logout fill:#FF5722,color:#fff
    style MainMenu fill:#FF9800
    style Continue fill:#F44336
```

---

## 3. ALUR KERJA PETUGAS GIZI

```mermaid
flowchart TD
    Start([Mulai])
    Login["🔐 Login Petugas Gizi"]
    Dashboard["📊 Dashboard Petugas Gizi"]
    MainMenu{Pilih Aksi}
    
    InputSchool["🏫 Input Sekolah"]
    InputMenu["🍽️ Input Menu Harian"]
    InputNutrition["💪 Input Data Gizi"]
    ViewHistory["📊 Lihat Riwayat Menu"]
    
    SchoolForm["📋 Isi Form Sekolah"]
    MenuForm["📋 Isi Form Menu"]
    UploadPhoto["📸 Upload Foto Menu"]
    NutritionForm["📋 Input Kalori/Protein/Lemak"]
    
    Saved["✅ Data Tersimpan"]
    Continue{Lanjut?}
    Logout["🚪 Logout"]
    End([Selesai])
    
    Start --> Login
    Login --> Dashboard
    Dashboard --> MainMenu
    
    MainMenu -->|1| InputSchool
    MainMenu -->|2| InputMenu
    MainMenu -->|3| InputNutrition
    MainMenu -->|4| ViewHistory
    
    InputSchool --> SchoolForm
    InputMenu --> MenuForm
    MenuForm --> UploadPhoto
    InputNutrition --> NutritionForm
    
    SchoolForm --> Saved
    UploadPhoto --> Saved
    NutritionForm --> Saved
    ViewHistory -.->|Info Only| Saved
    
    Saved --> Continue
    Continue -->|Ya| MainMenu
    Continue -->|Tidak| Logout
    Logout --> End
    
    style Start fill:#4CAF50,color:#fff
    style End fill:#F44336,color:#fff
    style Login fill:#2196F3,color:#fff
    style Dashboard fill:#2196F3,color:#fff
    style InputSchool fill:#9C27B0,color:#fff
    style InputMenu fill:#9C27B0,color:#fff
    style InputNutrition fill:#9C27B0,color:#fff
    style ViewHistory fill:#9C27B0,color:#fff
    style SchoolForm fill:#00BCD4,color:#fff
    style MenuForm fill:#00BCD4,color:#fff
    style UploadPhoto fill:#00BCD4,color:#fff
    style NutritionForm fill:#00BCD4,color:#fff
    style Saved fill:#4CAF50,color:#fff
    style Logout fill:#FF5722,color:#fff
    style MainMenu fill:#FF9800
    style Continue fill:#F44336
```

---

## 4. ALUR KERJA PETUGAS PENGADUAN

```mermaid
flowchart TD
    Start([Mulai])
    Login["🔐 Login Petugas Pengaduan"]
    Dashboard["📊 Dashboard Petugas Pengaduan"]
    ViewComplaints["📋 Lihat Daftar Pengaduan"]
    FilterChoice{Cari Berdasarkan<br/>Status?}
    
    ApplyFilter["🔍 Filter: Pending/<br/>Diproses/Selesai"]
    SelectComplaint["📌 Pilih Pengaduan"]
    ViewDetail["📖 Lihat Detail Pengaduan"]
    
    UpdateStatus["🔄 Update Status"]
    AddNotes["📝 Tambah Catatan Petugas"]
    SaveChanges["💾 Simpan Perubahan"]
    
    UpdateComplete["✅ Update Selesai"]
    ContinueChoice{Lihat Pengaduan<br/>Lain?}
    Logout["🚪 Logout"]
    End([Selesai])
    
    Start --> Login
    Login --> Dashboard
    Dashboard --> ViewComplaints
    ViewComplaints --> FilterChoice
    
    FilterChoice -->|Ya| ApplyFilter
    FilterChoice -->|Tidak| SelectComplaint
    ApplyFilter --> SelectComplaint
    
    SelectComplaint --> ViewDetail
    ViewDetail --> UpdateStatus
    ViewDetail --> AddNotes
    UpdateStatus --> SaveChanges
    AddNotes --> SaveChanges
    SaveChanges --> UpdateComplete
    
    UpdateComplete --> ContinueChoice
    ContinueChoice -->|Ya| ViewComplaints
    ContinueChoice -->|Tidak| Logout
    Logout --> End
    
    style Start fill:#4CAF50,color:#fff
    style End fill:#F44336,color:#fff
    style Login fill:#2196F3,color:#fff
    style Dashboard fill:#2196F3,color:#fff
    style ViewComplaints fill:#9C27B0,color:#fff
    style SelectComplaint fill:#9C27B0,color:#fff
    style ViewDetail fill:#00BCD4,color:#fff
    style UpdateStatus fill:#00BCD4,color:#fff
    style AddNotes fill:#00BCD4,color:#fff
    style SaveChanges fill:#00BCD4,color:#fff
    style UpdateComplete fill:#4CAF50,color:#fff
    style ApplyFilter fill:#00BCD4,color:#fff
    style Logout fill:#FF5722,color:#fff
    style FilterChoice fill:#FF9800
    style ContinueChoice fill:#F44336
```

---

## Referensi Penggunaan Fitur

### User (Publik)
- Akses bebas tanpa login
- 5 menu utama untuk browsing informasi
- Dapat membuat laporan pengaduan dengan foto bukti

### Admin
- Full access ke semua fitur
- Manajemen user, sekolah, tim SPPG
- Input menu & data gizi
- Overview semua pengaduan

### Petugas Gizi
- Input data sekolah yang berpartisipasi
- Input menu harian dengan foto
- Input data nutrisi (kalori, protein, dll)
- Lihat riwayat menu yang telah diinput

### Petugas Pengaduan
- Melihat semua pengaduan masuk
- Filter berdasarkan status (Pending, Diproses, Selesai)
- Update status pengaduan
- Tambah catatan tindak lanjut
- Tracking pengaduan dari awal hingga selesai

---

## Dokumen Pendukung

- **FLOWCHART_README.md** - Dokumentasi lengkap flowchart
- **flowchart_user.xml** - XML draw.io untuk User
- **flowchart_admin.xml** - XML draw.io untuk Admin
- **flowchart_petugas_gizi.xml** - XML draw.io untuk Petugas Gizi
- **flowchart_petugas_pengaduan.xml** - XML draw.io untuk Petugas Pengaduan
- **FLOWCHART_MERMAID.md** - Diagram Mermaid (file ini)

---

**Created:** 7 April 2026  
**Version:** 1.0  
**Format:** Mermaid Diagram Syntax
