# 📊 RINGKASAN FLOWCHART MBG REPORT SYSTEM

Tanggal: 7 April 2026  
Dibuat untuk: Dokumentasi Alur Kerja Sistem MBG Report App

---

## ✅ YANG TELAH DIBUAT

### 1. File Flowchart Format XML (draw.io compatible)

Empat file XML yang dapat **langsung diimport ke draw.io**:

| File | Untuk Role | Deskripsi |
|------|-----------|-----------|
| `flowchart_user.xml` | **User/Publik** | Alur browsing menu, SPPG, dan pengaduan tanpa login |
| `flowchart_admin.xml` | **Admin** | Alur manajemen penuh sistem (user, sekolah, menu, SPPG, pengaduan) |
| `flowchart_petugas_gizi.xml` | **Petugas Gizi** | Alur input sekolah, menu harian, dan data nutrisi |
| `flowchart_petugas_pengaduan.xml` | **Petugas Pengaduan** | Alur manajemen pengaduan (view, filter, update status, catatan) |

### 2. File Dokumentasi

- **`FLOWCHART_README.md`** - Dokumentasi lengkap dalam Bahasa Indonesia
  - Penjelasan detail setiap flowchart
  - Cara import ke draw.io
  - Keterangan warna dan simbol
  - Database schema terkait
  - Troubleshooting

- **`FLOWCHART_MERMAID.md`** - Diagram dalam format Mermaid
  - Dapat langsung dilihat di GitHub
  - Format tekstual yang mudah diedit
  - Semua 4 flowchart dalam satu file

---

## 🎯 KEEMPAT FLOWCHART

### 1️⃣ USER (Publik) - `flowchart_user.xml`

**Deskripsi:** Alur kerja pengguna tanpa login

**5 Menu Utama:**
1. 📅 **Lihat Menu Hari Ini** - Browsing menu dari berbagai sekolah
2. 📊 **Lihat Riwayat Menu** - Melihat histori menu mingguan
3. 👥 **Lihat Tim SPPG** - Berkenalan dengan tim profesional
4. 📝 **Buat Pengaduan** - Submit laporan dengan upload foto bukti
5. 📋 **Lihat Daftar Pengaduan** - Tracking status pengaduan

**Status Pengaduan yang Bisa Dilihat:**
- Pending (baru masuk)
- Diproses (sedang ditangani)
- Selesai (sudah ditutup)

---

### 2️⃣ ADMIN - `flowchart_admin.xml`

**Deskripsi:** Alur kerja administrator dengan akses penuh

**5 Menu Utama:**

1. 👤 **Kelola User**
   - Tambah user baru (Admin, Petugas Gizi, Petugas Pengaduan)
   - Edit data user
   - Hapus user
   - Verifikasi role dan sekolah

2. 🏫 **Kelola Sekolah**
   - Tambah data sekolah
   - Edit info sekolah (nama, alamat, kontak, koordinat)
   - Hapus sekolah

3. 👥 **Kelola Tim SPPG**
   - Tambah tim SPPG (Survei Penyelenggaraan Program Gizi)
   - Kelola data ketua tim, anggota, kontak
   - Upload foto tim
   - Hapus tim

4. 🍽️ **Input Menu & Gizi**
   - Input menu harian per sekolah
   - Upload foto menu
   - Input data nutrisi lengkap:
     - Kalori
     - Protein
     - Karbohidrat
     - Lemak
     - Serat
     - Energi

5. 📋 **Kelola Pengaduan**
   - Review semua pengaduan masuk
   - Lihat detail pengaduan
   - Update status pengaduan
   - Tambah catatan tindak lanjut

---

### 3️⃣ PETUGAS GIZI - `flowchart_petugas_gizi.xml`

**Deskripsi:** Alur kerja petugas gizi untuk input data nutrisi

**4 Menu Utama:**

1. 🏫 **Input Sekolah**
   - Menambahkan sekolah baru ke program
   - Data: nama, alamat, kontak, koordinat

2. 🍽️ **Input Menu Harian**
   - Input menu makan hari ini
   - Upload foto menu (dokumentasi visual)
   - Nama menu dan deskripsi

3. 💪 **Input Data Gizi**
   - Masukkan nilai nutrisi menu:
     - Kalori total
     - Protein (gram)
     - Karbohidrat (gram)
     - Lemak (gram)
     - Serat (gram)
     - Energi (kkal)

4. 📊 **Lihat Riwayat Menu**
   - Melihat semua menu yang sudah diinput
   - Tracking data gizi historis
   - Verifikasi data

---

### 4️⃣ PETUGAS PENGADUAN - `flowchart_petugas_pengaduan.xml`

**Deskripsi:** Alur kerja petugas pengaduan untuk manajemen laporan

**Proses Utama:**

1. 📋 **Lihat Daftar Pengaduan**
   - Mengakses semua laporan yang masuk
   - Data: tanggal, pelapor, sekolah, kontak

2. 🔍 **Filter Status (Optional)**
   - Pending - Laporan baru yang belum ditangani
   - Diproses - Laporan sedang dalam penanganan
   - Selesai - Laporan sudah ditutup

3. 📌 **Pilih Pengaduan**
   - Memilih satu laporan dari daftar

4. 📖 **Lihat Detail**
   - Nama pelapor
   - Kontak pelapor
   - Sekolah terkait
   - Isi lengkap pengaduan
   - Foto bukti (jika ada)
   - Status saat ini

5. 🔄 **Update Status**
   - Ubah dari Pending → Diproses
   - Atau Diproses → Selesai
   - Tracking progress penanganan

6. 📝 **Tambah Catatan**
   - Dokumentasi tindakan yang diambil
   - Progress penanganan
   - Hasil investigasi
   - Rekomendasi

7. 💾 **Simpan Perubahan**
   - Menyimpan update ke database
   - Notifikasi tersimpan

8. 🔁 **Lihat Pengaduan Lain**
   - Melanjutkan ke pengaduan berikutnya
   - Loop sampai selesai semua

---

## 📥 CARA MENGGUNAKAN FLOWCHART

### Di Draw.io (Recommended)

**Langkah 1:** Buka https://app.diagrams.net/

**Langkah 2:** Import file
- Klik **File → Open From → Device**
- Cari dan pilih file XML yang diinginkan
- ATAU drag & drop file ke canvas

**Langkah 3:** Lihat & Edit
- Flowchart akan tampil di canvas
- Dapat di-edit, warna diubah, layout disesuaikan
- Tambah/hapus elemen sesuai kebutuhan

**Langkah 4:** Export/Share
- **PNG/JPG**: Untuk presentasi, dokumentasi cetak
- **SVG**: Untuk publish di web
- **PDF**: Untuk laporan
- **XML**: Untuk disimpan dan diedit ulang

---

### Di GitHub (Mermaid)

File `FLOWCHART_MERMAID.md` dapat langsung dilihat:
- Buka file di GitHub
- Diagram akan ter-render otomatis
- Format mudah dibaca dan diedit
- Cocok untuk dokumentasi online

---

## 🎨 SISTEM WARNA FLOWCHART

```
🟢 HIJAU (#4CAF50)     = Start, End, Sukses, Data Tersimpan
🔵 BIRU (#2196F3)      = Proses Utama, Dashboard, Tampilan
🟣 UNGU (#9C27B0)      = Menu Utama, Aksi, Form Input
🟠 ORANGE (#FF9800)    = Filter, Pilihan, Keputusan
🔴 MERAH (#F44336)     = Decision Node, Logout, End
🔷 CYAN (#00BCD4)      = Sub-proses, Detail Aksi
🔴 RED (#FF5722)       = Logout Process
```

---

## 📋 CHECKLIST IMPLEMENTASI

- ✅ User Flow - Menu publik tanpa login
- ✅ Admin Flow - Manajemen penuh sistem
- ✅ Petugas Gizi Flow - Input menu & nutrisi
- ✅ Petugas Pengaduan Flow - Manajemen pengaduan
- ✅ Format XML draw.io kompatibel
- ✅ Format Mermaid untuk GitHub
- ✅ Dokumentasi lengkap Bahasa Indonesia
- ✅ Keterangan warna & simbol
- ✅ Database schema terkait
- ✅ Cara import & export

---

## 📂 STRUKTUR FILE

```
MBG-Report-App/
├── flowchart_user.xml                 ← XML untuk User
├── flowchart_admin.xml                ← XML untuk Admin
├── flowchart_petugas_gizi.xml         ← XML untuk Petugas Gizi
├── flowchart_petugas_pengaduan.xml    ← XML untuk Petugas Pengaduan
├── FLOWCHART_README.md                ← Dokumentasi lengkap
├── FLOWCHART_MERMAID.md               ← Diagram Mermaid
└── FLOWCHART_SUMMARY.md               ← File ini
```

---

## 🔗 LINK PENTING

- **Draw.io Online**: https://app.diagrams.net/
- **Draw.io Desktop**: https://github.com/jgraph/drawio-desktop
- **Mermaid Docs**: https://mermaid.js.org/
- **Project Database**: Project-DB.sql

---

## 📌 CATATAN PENTING

1. **Format XML** yang dibuat sudah **100% kompatibel dengan draw.io**
   - Bisa langsung dibuka di aplikasi
   - Tidak perlu konversi tambahan

2. **Semua role sudah tercakup:**
   - User (publik)
   - Admin (full control)
   - Petugas Gizi (nutrition data)
   - Petugas Pengaduan (complaint management)

3. **Flowchart sudah sesuai dengan struktur kode:**
   - Menu items sesuai dengan routing
   - Aksi sesuai dengan database schema
   - Status sesuai dengan enum di database

4. **Dapat dikembangkan lebih lanjut:**
   - Tambahkan role baru dengan flowchart baru
   - Ubah layout sesuai preferensi
   - Sinkronkan dengan developer guidelines

---

## ✉️ INFORMASI PEMBUATAN

**Dibuat:** 7 April 2026  
**Format:** 
- XML (draw.io compatible)
- Markdown (Mermaid syntax)

**Total File**: 6 file
- 4 file XML flowchart
- 1 file dokumentasi README
- 1 file Mermaid diagram

**Status**: ✅ Complete dan siap digunakan

---

## 🚀 NEXT STEPS

1. ✅ **Review flowchart** bersama tim
2. ✅ **Import ke draw.io** untuk customisasi final
3. ✅ **Share dengan team development** untuk referensi
4. ✅ **Update dokumentasi** jika ada perubahan sistem
5. ✅ **Export dalam berbagai format** untuk presentasi

---

Terima kasih telah menggunakan dokumentasi flowchart MBG Report!

Jika ada pertanyaan atau perlu modifikasi, silakan hubungi tim development.

**Happy Documentation! 📚✨**
