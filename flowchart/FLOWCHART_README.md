# MBG Report Workflow Flowcharts

## Daftar File Flowchart

Repositori ini berisi 4 flowchart utama sistem MBG Report yang dapat diimport ke draw.io. Setiap file mewakili alur kerja untuk setiap peran pengguna dalam sistem.

### File-File Flowchart

1. **flowchart_user.xml** - Alur kerja pengguna publik
2. **flowchart_admin.xml** - Alur kerja administrator
3. **flowchart_petugas_gizi.xml** - Alur kerja petugas gizi
4. **flowchart_petugas_pengaduan.xml** - Alur kerja petugas pengaduan

---

## 1. ALUR KERJA USER (Publik)

**File:** `flowchart_user.xml`

### Akses Tanpa Login
User publik dapat:
- Melihat menu hari ini dari berbagai sekolah
- Melihat riwayat menu mingguan
- Melihat tim SPPG (Survei Penyelenggaraan Program Gizi)
- Membuat laporan pengaduan
- Melihat daftar pengaduan yang telah diproses

### Alur Proses:
```
Mulai → Halaman Utama → Pilih Aksi (5 opsi)
         ↓
    1. Lihat Menu Hari Ini → Tampilkan Data
    2. Lihat Riwayat Menu → Tampilkan Data
    3. Lihat Tim SPPG → Tampilkan Data
    4. Buat Pengaduan → Isi Form → Upload Bukti → Terkirim
    5. Lihat Daftar Pengaduan → Tampilkan Data
         ↓
    Lanjut? → Ya (kembali ke menu) / Tidak → Selesai
```

### Fitur Utama:
- Transparansi informasi menu makan bergizi
- Sistem pelaporan pengaduan terbuka
- Tracking status pengaduan

---

## 2. ALUR KERJA ADMIN

**File:** `flowchart_admin.xml`

### Hak Akses Penuh
Admin memiliki kontrol penuh terhadap semua modul sistem.

### Menu Utama Admin:
1. **Kelola User** - Tambah/Edit/Hapus pengguna sistem
2. **Kelola Sekolah** - Tambah/Edit/Hapus data sekolah
3. **Kelola Tim SPPG** - Tambah/Edit/Hapus tim profesional
4. **Input Menu & Gizi** - Tambah/Edit/Hapus data menu dan nutrisi
5. **Pengaduan List** - Review dan manage semua pengaduan

### Alur Proses:
```
Mulai → Login Admin → Dashboard Admin → Pilih Menu Utama
         ↓
    1. Kelola User → Tambah/Edit/Hapus → Data Tersimpan
    2. Kelola Sekolah → Tambah/Edit/Hapus → Data Tersimpan
    3. Kelola Tim SPPG → Tambah/Edit/Hapus → Data Tersimpan
    4. Input Menu & Gizi → Tambah/Edit/Hapus → Data Tersimpan
    5. Kelola Pengaduan → Update Status & Catatan → Data Tersimpan
         ↓
    Lanjut? → Ya (kembali ke menu) / Tidak → Logout → Selesai
```

### Akses ke Fitur:
- Manajemen pengguna dan role
- Manajemen data sekolah
- Manajemen tim SPPG
- Input dan manajemen menu harian & data gizi
- Monitoring dan management pengaduan

---

## 3. ALUR KERJA PETUGAS GIZI

**File:** `flowchart_petugas_gizi.xml`

### Hak Akses Terbatas
Petugas gizi fokus pada input dan monitoring data nutrisi.

### Menu Petugas Gizi:
1. **Input Sekolah** - Menambah sekolah yang mengikuti program
2. **Input Menu Harian** - Menginput menu makan hari ini
3. **Input Data Gizi** - Menginput data nilai gizi (kalori, protein, dll)
4. **Lihat Riwayat Menu** - Melihat histori menu yang sudah diinput

### Alur Proses:
```
Mulai → Login Petugas Gizi → Dashboard → Pilih Aksi
         ↓
    1. Input Sekolah → Isi Form Sekolah → Data Tersimpan
    2. Input Menu Harian → Isi Form Menu → Upload Foto → Data Tersimpan
    3. Input Data Gizi → Input Kalori/Protein/Lemak/dll → Data Tersimpan
    4. Lihat Riwayat Menu → Tampilkan Data Tersimpan → Data Tersimpan
         ↓
    Lanjut? → Ya (kembali ke menu) / Tidak → Logout → Selesai
```

### Data yang Diinput:
- Nama sekolah, alamat, kontak
- Menu harian + foto menu
- Data nutrisi: kalori, protein, karbohidrat, lemak, serat, energi

---

## 4. ALUR KERJA PETUGAS PENGADUAN

**File:** `flowchart_petugas_pengaduan.xml`

### Hak Akses Terbatas
Petugas pengaduan berfokus pada pengelolaan dan follow-up pengaduan masyarakat.

### Proses Management Pengaduan:
1. **Lihat Daftar Pengaduan** - Melihat semua pengaduan masuk
2. **Filter Berdasarkan Status** - Pending, Diproses, atau Selesai
3. **Pilih Pengaduan** - Memilih satu pengaduan untuk diproses
4. **Lihat Detail** - Melihat informasi lengkap pelapor dan isi pengaduan
5. **Update Status** - Mengubah status pengaduan
6. **Tambah Catatan** - Menambahkan catatan tindak lanjut
7. **Simpan Perubahan** - Menyimpan update ke database

### Alur Proses:
```
Mulai → Login Petugas Pengaduan → Dashboard → Lihat Daftar Pengaduan
         ↓
    Filter by Status?
         ↓
    Ya → Filter (Pending/Diproses/Selesai) ↘
    Tidak ←                                   ↓
         ↓                                    ↓
    Pilih Pengaduan ← (dari hasil filter) ←─┘
         ↓
    Lihat Detail Pengaduan
         ↓
    ┌─→ Update Status (Pending → Diproses → Selesai)
    │   Tambah Catatan Petugas
    └─→ Simpan Perubahan
         ↓
    Update Selesai
         ↓
    Lihat Pengaduan Lain? → Ya (ke Daftar) / Tidak → Logout → Selesai
```

### Status Pengaduan:
- **Pending** - Baru masuk, belum ditindaklanjuti
- **Diproses** - Sedang dalam proses penanganan
- **Selesai** - Sudah ditindaklanjuti/ditutup

---

## Cara Import Flowchart ke Draw.io

### Langkah-Langkah:

1. **Buka Draw.io**
   - Kunjungi https://app.diagrams.net/
   - Atau gunakan aplikasi desktop Draw.io

2. **Import File XML**
   - Pilih menu **File → Open From → Device**
   - Pilih file flowchart XML yang diinginkan
   - Atau drag & drop file ke canvas

3. **Edit & Customize (Optional)**
   - Ubah warna, layout, atau teks sesuai kebutuhan
   - Tambahkan elemen baru jika diperlukan
   - Export dalam berbagai format (PNG, SVG, PDF)

### Format Export Tersedia:
- PNG/JPG - Untuk presentasi
- SVG - Untuk web
- PDF - Untuk dokumentasi
- XML - Untuk edit lebih lanjut di Draw.io

---

## Keterangan Warna dalam Flowchart

| Warna | Arti |
|-------|------|
| 🟢 Hijau | Start/End, Data Tersimpan (Sukses) |
| 🔵 Biru | Proses Utama, Dashboard, Tampilan Data |
| 🟣 Ungu | Aksi/Menu Utama, Form Input |
| 🔴 Merah | Decision/Pilihan, Logout |
| 🟠 Orange | Filter/Pencarian |
| 🔷 Cyan | Sub-proses, Detail Aksi |

---

## Database Schema Terkait

### Tabel Users
- uid (username)
- nama
- password
- role (Admin, Petugas Gizi, Petugas Pengaduan)
- id_sekolah

### Tabel Menu Harian
- id_menu
- id_sekolah
- nama_menu
- foto_url
- tanggal
- riwayat (0 = aktual, 1 = arsip)

### Tabel Gizi Menu
- id_gizi
- id_menu
- kalori
- protein
- karbohidrat
- lemak
- serat
- energi

### Tabel Pengaduan
- id_pengaduan
- nama_pelapor
- kontak
- id_sekolah
- isi_pengaduan
- foto_bukti
- status (Pending, Diproses, Selesai)
- catatan_petugas
- tanggal

### Tabel Sekolah
- id_sekolah
- nama_sekolah
- alamat
- kontak
- koordinat

### Tabel SPPG
- id_sppg
- nama_tim
- jabatan
- ketua_tim
- kontak_tim
- anggota_tim
- foto_tim
- id_sekolah

---

## File Flowchart Alternatif (Mermaid)

Selain format XML draw.io, tersedia juga file `.md` yang berisi diagram dalam format Mermaid untuk viewing di GitHub dan platform yang mendukung Mermaid.

---

## Troubleshooting

### Masalah: File tidak terbuka di Draw.io
- **Solusi**: Pastikan file XML tidak corrupt. Coba download ulang atau import kembali.

### Masalah: Tampilan tidak sesuai
- **Solusi**: Gunakan fitur "Refresh" atau "Fit Page" di Draw.io menu.

### Masalah: Ingin menambah elemen
- **Solusi**: Edit file XML atau edit langsung di Draw.io dengan menambahkan shape baru.

---

## Kontak & Support

Untuk pertanyaan atau masalah terkait flowchart:
- Hubungi tim development
- Atau buka issue di repository

---

**Last Updated:** 7 April 2026  
**Version:** 1.0  
**Format:** XML (draw.io compatible)
