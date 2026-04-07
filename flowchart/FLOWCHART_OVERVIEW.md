# 📊 SYSTEM FLOWCHART OVERVIEW - MBG REPORT APP

**Dokumentasi Lengkap Alur Kerja Sistem**  
**Dibuat: 7 April 2026**

---

## 🎯 VISI DOKUMENTASI

Dokumentasi flowchart ini dibuat untuk:
✅ Memberikan visualisasi jelas tentang alur kerja setiap role  
✅ Memudahkan onboarding user baru dan developer  
✅ Sebagai referensi teknis untuk pengembangan lebih lanjut  
✅ Dokumentasi proses bisnis sistem MBG Report  

---

## 📦 DELIVERABLES

### File Flowchart (Format XML - Draw.io Compatible)

| # | File | Role | Deskripsi | Ukuran |
|---|------|------|-----------|--------|
| 1 | `flowchart_user.xml` | User/Publik | Akses menu, menu history, SPPG, pengaduan | ~8 KB |
| 2 | `flowchart_admin.xml` | Admin | Manajemen user, sekolah, SPPG, menu, pengaduan | ~12 KB |
| 3 | `flowchart_petugas_gizi.xml` | Petugas Gizi | Input sekolah, menu, data gizi, history | ~10 KB |
| 4 | `flowchart_petugas_pengaduan.xml` | Petugas Pengaduan | Manajemen & tracking pengaduan | ~11 KB |

### File Dokumentasi (Markdown)

| # | File | Konten | Tujuan |
|---|------|--------|--------|
| 1 | `FLOWCHART_README.md` | Dokumentasi lengkap (6+ KB) | Referensi utama |
| 2 | `FLOWCHART_MERMAID.md` | 4 diagram Mermaid format | Viewing di GitHub |
| 3 | `FLOWCHART_SUMMARY.md` | Ringkasan & checklist | Overview cepat |
| 4 | `FLOWCHART_QUICK_REF.md` | Panduan cepat & shortcut | Quick reference |
| 5 | `FLOWCHART_OVERVIEW.md` | File ini | Index & navigasi |

---

## 🔄 ALUR SISTEM TERINTEGRASI

```
┌─────────────────────────────────────────────────────────────┐
│                  MBG REPORT SYSTEM                          │
├─────────────────────────────────────────────────────────────┤
│                                                             │
│  ┌──────────────┐    ┌──────────────┐    ┌──────────────┐ │
│  │   USER       │    │   ADMIN      │    │  PETUGAS     │ │
│  │   (Publik)   │    │ (Full Access)│    │   GIZI       │ │
│  └──────────────┘    └──────────────┘    └──────────────┘ │
│         │                   │                     │         │
│    Browse Info         Manage All            Input Data     │
│    Submit Report       Monitor System         Nutrition     │
│    Track Status                                             │
│                                                             │
│  ┌──────────────────────────────────────────────────────┐  │
│  │           PETUGAS PENGADUAN                          │  │
│  │        (Complaint Management)                       │  │
│  │  View → Filter → Update Status → Track Progress    │  │
│  └──────────────────────────────────────────────────────┘  │
│                                                             │
└─────────────────────────────────────────────────────────────┘
```

---

## 📑 PANDUAN NAVIGASI DOKUMENTASI

### Untuk Pengguna Awam
1. ⭐ Mulai dari: **FLOWCHART_QUICK_REF.md** (1 halaman)
2. Lalu: **FLOWCHART_SUMMARY.md** (visual overview)
3. Ekspor ke draw.io atau lihat Mermaid diagram

### Untuk Project Manager
1. ⭐ Baca: **FLOWCHART_SUMMARY.md** (checklist & scope)
2. Review: **FLOWCHART_README.md** (database schema)
3. Share: Export PNG dari draw.io untuk presentasi

### Untuk Developer
1. ⭐ Baca: **FLOWCHART_README.md** (dokumentasi lengkap)
2. Import: File XML ke draw.io untuk customisasi
3. Refer: Database schema untuk implementasi feature

### Untuk UX/UI Designer
1. ⭐ Lihat: **FLOWCHART_MERMAID.md** (visual flow)
2. Export: PNG dari draw.io untuk reference design
3. Iterate: Edit XML untuk improvements

---

## 🚀 QUICK START

### Setup 1 Menit

```bash
# 1. Download file XML
wget flowchart_*.xml

# 2. Buka Draw.io
https://app.diagrams.net/

# 3. Import File
File → Open From → Device → Pilih file XML

# 4. Done! Explore flowchart
```

### View di GitHub (Tanpa Download)

```
1. Buka repository
2. Klik FLOWCHART_MERMAID.md
3. Lihat diagram langsung (auto-render)
```

---

## 📋 FEATURE CHECKLIST

### ✅ Alur User (Publik)
- [x] Browse halaman utama
- [x] View menu hari ini
- [x] View riwayat menu
- [x] View tim SPPG
- [x] Submit pengaduan dengan foto
- [x] View status pengaduan
- [x] Filter pengaduan by status

### ✅ Alur Admin
- [x] Login dengan role verification
- [x] Dashboard overview
- [x] Kelola user (CRUD)
- [x] Kelola sekolah (CRUD)
- [x] Kelola SPPG (CRUD)
- [x] Input menu & gizi (CRUD)
- [x] View & manage pengaduan
- [x] Logout dengan konfirmasi

### ✅ Alur Petugas Gizi
- [x] Login dengan role verification
- [x] Dashboard overview
- [x] Input sekolah (CRUD)
- [x] Input menu harian dengan foto
- [x] Input data gizi lengkap
- [x] View riwayat menu
- [x] Logout dengan konfirmasi

### ✅ Alur Petugas Pengaduan
- [x] Login dengan role verification
- [x] Dashboard overview
- [x] View daftar pengaduan
- [x] Filter by status (Pending/Diproses/Selesai)
- [x] View detail pengaduan
- [x] Update status pengaduan
- [x] Add catatan tindak lanjut
- [x] Save & tracking
- [x] Logout dengan konfirmasi

---

## 🎮 INTERACTIVE FEATURES IN DRAW.IO

Setelah import file XML ke Draw.io, Anda dapat:

- 🔍 **Zoom** - Lihat detail lebih dekat
- 🎨 **Edit Warna** - Customize sesuai brand
- ✏️ **Edit Teks** - Update label/deskripsi
- ➕ **Tambah Elemen** - Extend flowchart
- 🔗 **Add Links** - Connect to documentation
- 📐 **Rearrange Layout** - Optimize view
- 💾 **Save Version** - Multiple versions
- 📤 **Export** - PNG, SVG, PDF, XML

---

## 📊 DATABASE ENTITIES

Flowchart telah disesuaikan dengan tabel-tabel berikut:

```
users (uid, nama, role, password, id_sekolah)
  ├─ Role: Admin, Petugas Gizi, Petugas Pengaduan
  └─ Linked to: sekolah

sekolah (id_sekolah, nama_sekolah, alamat, kontak, koordinat)
  ├─ Multiple users
  ├─ Multiple menu
  ├─ Multiple SPPG
  └─ Multiple pengaduan

menu_harian (id_menu, id_sekolah, nama_menu, foto_url, tanggal, riwayat)
  └─ Links to: gizi_menu

gizi_menu (id_gizi, id_menu, kalori, serat, energi, protein, karbohidrat, lemak)
  └─ Links to: menu_harian

pengaduan (id_pengaduan, nama_pelapor, kontak, id_sekolah, 
           isi_pengaduan, foto_bukti, status, catatan_petugas, tanggal)
  ├─ Status: Pending, Diproses, Selesai
  └─ Links to: sekolah

sppg (id_sppg, nama_tim, jabatan, ketua_tim, kontak_tim, 
      anggota_tim, foto_tim, id_sekolah)
  └─ Links to: sekolah
```

---

## 🔐 ROLE-BASED ACCESS CONTROL (RBAC)

```
┌────────────────┐
│     PUBLIC     │ NO LOGIN REQUIRED
├────────────────┤
│ • View Menu    │
│ • View SPPG    │
│ • Submit Issue │
│ • Track Status │
└────────────────┘

┌────────────────┐
│     ADMIN      │ FULL ACCESS
├────────────────┤
│ • Kelola User  │
│ • Kelola Data  │
│ • Monitor All  │
└────────────────┘

┌────────────────┐
│ PETUGAS GIZI   │ LIMITED ACCESS
├────────────────┤
│ • Input Menu   │
│ • Input Gizi   │
│ • View History │
└────────────────┘

┌────────────────┐
│ PETUGAS ADUAN  │ LIMITED ACCESS
├────────────────┤
│ • View Issues  │
│ • Update Info  │
│ • Track Status │
└────────────────┘
```

---

## 🛠️ MAINTENANCE & UPDATES

### Jika Ada Perubahan Fitur:

1. **Identifikasi perubahan** di flowchart mana
2. **Update XML file** via Draw.io
3. **Update Markdown** (FLOWCHART_MERMAID.md)
4. **Update dokumentasi** (FLOWCHART_README.md)
5. **Commit ke Git** dengan pesan yang jelas
6. **Share dengan team** untuk review

### Version Control

```
v1.0 - Initial release (7 April 2026)
     ├─ 4 roles documented
     ├─ XML draw.io format
     └─ Full markdown docs

v1.1 - TBD (after feedback)
v2.0 - Major UI/UX changes
```

---

## 📞 SUPPORT & CONTACT

### Jika Ada Pertanyaan:

1. ✅ Cek dokumentasi: START HERE!
   - FLOWCHART_README.md (lengkap)
   - FLOWCHART_QUICK_REF.md (cepat)

2. 📧 Email support@mbgreport.local
   - Domain: Attaching flowchart export
   - Subject: "[Flowchart] Pertanyaan tentang..."

3. 💬 Team Meeting
   - Diskusi perubahan workflow
   - Feedback dari user

4. 🐛 Bug Report
   - File issue di repository
   - Sertakan screenshot flowchart area

---

## 📈 DEPLOYMENT CHECKLIST

Sebelum go-live, pastikan:

- [x] Semua flowchart sudah direview
- [x] Database schema sesuai flowchart
- [x] Role & permission sudah dikonfigurasi
- [x] UI/UX sesuai flow yang didocumentasikan
- [x] Testing sesuai scenario di flowchart
- [x] User training based on flowchart
- [x] Dokumentasi diberikan ke end-user
- [x] Flowchart printed/digital copies ready

---

## 📚 RELATED DOCUMENTS

Inside Repository:
- `Project-DB.sql` - Database schema
- `README.md` - Project overview
- `auth/login_process.php` - Login implementation
- `pages/dashboard.php` - Dashboard referensi

Outside:
- Draw.io tutorials: https://app.diagrams.net/
- Mermaid docs: https://mermaid.js.org/
- UML standards: https://www.omg.org/spec/UML/

---

## 🎓 LEARNING PATH

### Beginner (Non-Technical)
```
1. FLOWCHART_QUICK_REF.md (5 min)
   ↓
2. View PNG export (5 min)
   ↓
3. Understand role basics (15 min)
   ↓
✅ Ready to use system (25 min total)
```

### Intermediate (Technical)
```
1. FLOWCHART_README.md (15 min)
   ↓
2. Import to Draw.io (5 min)
   ↓
3. Review database schema (10 min)
   ↓
4. Map code to flowchart (30 min)
   ↓
✅ Ready to implement (60 min total)
```

### Advanced (Developer)
```
1. All documentation (20 min)
   ↓
2. Deep dive into code (2+ hours)
   ↓
3. Propose improvements (30 min)
   ↓
4. Implementation & testing (varies)
   ↓
✅ Ready to extend (varies)
```

---

## ✨ SPECIAL FEATURES

### Beyond Standard Flowchart:
- ✅ Color-coded by role & action
- ✅ Database schema mapping
- ✅ RBAC explanation
- ✅ Multiple format support (XML, Mermaid, etc)
- ✅ Export-ready for presentations
- ✅ Editable & version-controllable
- ✅ Bilingual documentation (ID/EN)
- ✅ Quick reference included

---

## 🎉 CONCLUSION

Paket dokumentasi flowchart MBG Report ini menyediakan:

✅ **Visualisasi** - Gambar jelas alur setiap role  
✅ **Dokumentasi** - Penjelasan lengkap setiap proses  
✅ **Aksesibilitas** - Multiple format & platform  
✅ **Editabilitas** - Mudah di-customize & update  
✅ **Referensi** - Database schema & implementation guide  

---

**Status:** ✅ COMPLETE & READY FOR USE

**Created:** 7 April 2026  
**Version:** 1.0  
**Last Updated:** 7 April 2026

**Happy Documentation! 🚀📊**

---

## 📖 TABLE OF CONTENTS (Quick Links)

1. [README Lengkap](./FLOWCHART_README.md) - Start here untuk detail
2. [Mermaid Diagrams](./FLOWCHART_MERMAID.md) - View di GitHub
3. [Ringkasan](./FLOWCHART_SUMMARY.md) - Quick overview
4. [Quick Ref](./FLOWCHART_QUICK_REF.md) - Super cepat
5. [Overview](./FLOWCHART_OVERVIEW.md) - File ini

**Download XML files:**
- [User Flow](./flowchart_user.xml)
- [Admin Flow](./flowchart_admin.xml)
- [Petugas Gizi Flow](./flowchart_petugas_gizi.xml)
- [Petugas Pengaduan Flow](./flowchart_petugas_pengaduan.xml)
