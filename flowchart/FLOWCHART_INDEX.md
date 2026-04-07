# 📑 INDEX - MBG REPORT FLOWCHART DOCUMENTATION

**Panduan Navigasi Dokumentasi Flowchart**  
**Dibuat: 7 April 2026**

---

## 🎯 MULAI DARI SINI

### Jika Anda Ingin...

#### ⚡ "Cepat! Saya hanya butuh gambaran cepat"
👉 **Buka:** [`FLOWCHART_QUICK_REF.md`](./FLOWCHART_QUICK_REF.md)
- Membaca dalam **1-2 menit**
- Shortcut & panduan singkat
- Troubleshooting cepat

---

#### 📊 "Saya ingin melihat diagram visual"
👉 **Buka:** [`FLOWCHART_MERMAID.md`](./FLOWCHART_MERMAID.md)
- 4 flowchart dalam format Mermaid
- Auto-render di GitHub
- Mudah dibaca & diedit

---

#### 📖 "Saya butuh dokumentasi lengkap"
👉 **Buka:** [`FLOWCHART_README.md`](./FLOWCHART_README.md)
- Penjelasan detail untuk setiap role
- Database schema terkait
- Cara import & export
- Troubleshooting lengkap

---

#### 🎨 "Saya ingin edit di Draw.io"
👉 **Download file XML:**
- [`flowchart_user.xml`](./flowchart_user.xml) - User publik
- [`flowchart_admin.xml`](./flowchart_admin.xml) - Admin
- [`flowchart_petugas_gizi.xml`](./flowchart_petugas_gizi.xml) - Petugas gizi
- [`flowchart_petugas_pengaduan.xml`](./flowchart_petugas_pengaduan.xml) - Petugas pengaduan

**Langkah:**
1. Buka https://app.diagrams.net/
2. File → Open From → Device
3. Pilih file XML
4. Edit & customize sesuai kebutuhan

---

#### 📋 "Saya butuh overview system"
👉 **Baca:** [`FLOWCHART_SUMMARY.md`](./FLOWCHART_SUMMARY.md)
- Ringkasan alur kerja 4 role
- Checklist implementasi
- Struktur file
- Quick tips

---

#### 🔍 "Saya ingin memahami struktur lengkap"
👉 **Baca:** [`FLOWCHART_OVERVIEW.md`](./FLOWCHART_OVERVIEW.md)
- System overview terintegrasi
- Panduan navigasi dokumentasi
- Database entities mapping
- RBAC explanation

---

## 📁 DAFTAR FILE FLOWCHART

### Format XML (Draw.io Compatible) ✅

| File | Role | Fungsi | Ukuran |
|------|------|--------|--------|
| `flowchart_user.xml` | User/Publik | Browse menu dan submit pengaduan | ~8 KB |
| `flowchart_admin.xml` | Admin | Manajemen penuh sistem | ~12 KB |
| `flowchart_petugas_gizi.xml` | Petugas Gizi | Input menu dan nutrisi | ~10 KB |
| `flowchart_petugas_pengaduan.xml` | Petugas Pengaduan | Kelola pengaduan | ~11 KB |

**Total Size:** ~41 KB (semua file)

**Format:** XML 100% kompatibel dengan [Draw.io](https://app.diagrams.net/)

---

## 📚 DAFTAR DOKUMENTASI

### Dokumentasi Markdown (.md files)

| # | File | Tujuan | Panjang | Audience |
|---|------|--------|--------|----------|
| 1 | `FLOWCHART_QUICK_REF.md` | Quick reference & shortcut | 1 halaman | Semua orang |
| 2 | `FLOWCHART_README.md` | Dokumentasi lengkap & detail | 8+ halaman | Developer, PM |
| 3 | `FLOWCHART_SUMMARY.md` | Ringkasan & checklist | 5 halaman | PM, Manager |
| 4 | `FLOWCHART_MERMAID.md` | Diagram dalam format Mermaid | 6+ halaman | Visual learner |
| 5 | `FLOWCHART_OVERVIEW.md` | System overview | 8+ halaman | Technical lead |
| 6 | `FLOWCHART_INDEX.md` | File navigasi ini | 1-2 halaman | Semua orang |

---

## 🎯 QUICK START GUIDE

### Untuk End User

```
1. Baca: FLOWCHART_QUICK_REF.md (1-2 min)
2. Lihat: FLOWCHART_MERMAID.md (2-3 min)
3. Pahami: Role & menu Anda
4. Mulai menggunakan sistem!
```

**Estimasi:** 5-10 menit

### Untuk Project Manager

```
1. Baca: FLOWCHART_SUMMARY.md (5 min)
2. Review: Checklist implementasi
3. Hubungi: Developer untuk detail
4. Track: Progress implementasi
```

**Estimasi:** 10-15 menit

### Untuk Developer

```
1. Baca: FLOWCHART_README.md (20 min)
2. Download: File XML + import ke Draw.io (5 min)
3. Review: Database schema (10 min)
4. Map: Code ke flowchart (30 min+)
5. Implement: Feature sesuai flowchart
```

**Estimasi:** 1-2 jam

### Untuk Designer

```
1. Lihat: FLOWCHART_MERMAID.md (10 min)
2. Download: File XML + export PNG (5 min)
3. Use as reference: UI/UX design
4. Iterate: Dengan team development
```

**Estimasi:** 30-60 menit

---

## 🔄 ALUR KERJA 4 PERAN UTAMA

### 1️⃣ USER (Publik)
```
No Login → Halaman Utama → 5 Menu Utama → Lihat/Submit Pengaduan
```
📄 Lihat: `flowchart_user.xml` atau FLOWCHART_MERMAID.md (bagian 1)

### 2️⃣ ADMIN
```
Login → Dashboard → 5 Menu Manajemen → Data Tersimpan → Lanjut/Logout
```
📄 Lihat: `flowchart_admin.xml` atau FLOWCHART_MERMAID.md (bagian 2)

### 3️⃣ PETUGAS GIZI
```
Login → Dashboard → 4 Menu Input → Data Tersimpan → Lanjut/Logout
```
📄 Lihat: `flowchart_petugas_gizi.xml` atau FLOWCHART_MERMAID.md (bagian 3)

### 4️⃣ PETUGAS PENGADUAN
```
Login → View List → Filter → Select → Update → Save → Lanjut/Logout
```
📄 Lihat: `flowchart_petugas_pengaduan.xml` atau FLOWCHART_MERMAID.md (bagian 4)

---

## 📊 COMPARISON TABLE

| Aspek | User | Admin | Petugas Gizi | Petugas Pengaduan |
|-------|------|-------|--------------|------------------|
| **Login Diperlukan** | ❌ | ✅ | ✅ | ✅ |
| **Lihat Menu Harian** | ✅ | ✅ | ✅ | ❌ |
| **Input Menu** | ❌ | ✅ | ✅ | ❌ |
| **Kelola User** | ❌ | ✅ | ❌ | ❌ |
| **Kelola Pengaduan** | ❌ (view only) | ✅ | ❌ | ✅ |
| **Input Gizi Data** | ❌ | ✅ | ✅ | ❌ |
| **Lihat Dashboard** | ❌ | ✅ | ✅ | ✅ |

---

## 🛠️ TOOLS YANG DIGUNAKAN

### Untuk Membuat Flowchart
- **Draw.io** (https://app.diagrams.net/) - Editor diagram
- **XML Format** - Kompatibilitas universal

### Untuk View/Edit
- **Draw.io Online** - Gratis, no signup
- **Draw.io Desktop** - Download & offline support
- **GitHub** - View Mermaid diagrams

### Untuk Export
- **PNG/JPG** - Presentasi & cetak
- **SVG** - Web & responsive
- **PDF** - Dokumentasi formal
- **XML** - Edit & backup

---

## 📞 FAQ CEPAT

### Q: Bagaimana cara import flowchart?
**A:** 
1. Buka https://app.diagrams.net/
2. File → Open From → Device
3. Pilih file XML
4. Done!

### Q: Bisa edit di Draw.io?
**A:** Ya! Drag, drop, ubah warna, text, layout. Simpan & re-export.

### Q: Format apa saja tersedia?
**A:** XML (source), PNG/JPG (image), SVG (web), PDF (print), Mermaid (text)

### Q: Mana yang harus dibaca dulu?
**A:** 
- Cepat? → FLOWCHART_QUICK_REF.md
- Detail? → FLOWCHART_README.md
- Visual? → FLOWCHART_MERMAID.md

### Q: Apakah flowchart bisa diubah?
**A:** Ya! Download XML, edit di Draw.io, atau hubungi developer.

### Q: Format file apa ini?
**A:** XML (text-based, kompatibel dengan Draw.io)

---

## 🔗 EXTERNAL LINKS

- **Draw.io**: https://app.diagrams.net/
- **Draw.io Desktop**: https://github.com/jgraph/drawio-desktop
- **Mermaid Docs**: https://mermaid.js.org/
- **This Repository**: Check GitHub

---

## 📋 CONTENT SUMMARY

### FLOWCHART_QUICK_REF.md
- ⏱️ **Waktu baca:** 1-2 menit
- 📝 **Isi:** Shortcut, quick guide, troubleshooting
- 👥 **Untuk:** Siapa saja yang ingin cepat

### FLOWCHART_README.md
- ⏱️ **Waktu baca:** 20-30 menit
- 📝 **Isi:** Detail setiap role, database, troubleshooting
- 👥 **Untuk:** Developer, PM, technical lead

### FLOWCHART_SUMMARY.md
- ⏱️ **Waktu baca:** 10-15 menit
- 📝 **Isi:** Ringkasan, checklist, struktur
- 👥 **Untuk:** PM, Manager, overview seeker

### FLOWCHART_MERMAID.md
- ⏱️ **Waktu baca:** 10-15 menit
- 📝 **Isi:** 4 diagram Mermaid format
- 👥 **Untuk:** Visual learner, GitHub viewer

### FLOWCHART_OVERVIEW.md
- ⏱️ **Waktu baca:** 15-20 menit
- 📝 **Isi:** System overview, integration, roadmap
- 👥 **Untuk:** Technical lead, architect

---

## ✅ CHECKLIST

Sebelum mulai menggunakan:

- [ ] Baca file documentation yang sesuai dengan role Anda
- [ ] Download file XML jika ingin edit
- [ ] Buka Draw.io jika ingin visualisasi lebih
- [ ] Bookmark halaman ini untuk referensi
- [ ] Share dengan team/colleague jika perlu
- [ ] Hubungi support jika ada pertanyaan

---

## 📝 VERSION INFO

**Version:** 1.0  
**Created:** 7 April 2026  
**Last Updated:** 7 April 2026  
**Format:** Markdown (.md) + XML  
**Status:** ✅ Complete & Ready to Use  

**Total Files:** 9
- 4 XML flowchart files
- 5 Documentation files
- 1 Index file (this)

**Total Size:** ~50-60 KB

---

## 🎓 RECOMMENDED READING ORDER

### Path 1: I Just Want to Get Started (5 mins)
```
FLOWCHART_QUICK_REF.md
        ↓
Start using the system!
```

### Path 2: I Need to Understand the System (20 mins)
```
FLOWCHART_QUICK_REF.md (2 mins)
        ↓
FLOWCHART_MERMAID.md (10 mins)
        ↓
FLOWCHART_SUMMARY.md (8 mins)
        ↓
Ready to use!
```

### Path 3: I'm a Developer (1-2 hours)
```
FLOWCHART_QUICK_REF.md (2 mins)
        ↓
FLOWCHART_README.md (25 mins)
        ↓
Import XML to Draw.io (5 mins)
        ↓
Review code & database (30 mins)
        ↓
Start implementation!
```

### Path 4: I'm a Technical Lead (30 mins)
```
FLOWCHART_OVERVIEW.md (20 mins)
        ↓
FLOWCHART_README.md - Focus on schema (10 mins)
        ↓
Review with team!
```

---

## 🎁 BONUS FEATURES

✨ **Included in this package:**
- 4 ready-to-use flowchart XMLs
- 5 comprehensive documentation files
- Multiple format support (XML, Mermaid, etc)
- Color-coded diagrams
- Database schema mapping
- RBAC explanation
- Quick reference guide
- Troubleshooting tips
- Bilingual documentation (prepared)

---

## 🚀 NEXT STEPS

1. **Identify your role** → User, Admin, Petugas Gizi, atau Petugas Pengaduan
2. **Choose your resources** → XML file atau documentation file
3. **Read/View** → Understand the flowchart
4. **Implement/Use** → Apply dalam pekerjaan sehari-hari
5. **Feedback** → Hubungi tim untuk perbaikan

---

## 💡 TIPS & TRICKS

### Sharing dengan Team
```
1. Export PNG dari Draw.io
2. Embed di presentation/document
3. Share link ini ke repository
4. Update secara regular
```

### Customization
```
1. Download file XML
2. Buka di Draw.io
3. Edit warna, layout, teks
4. Save dengan nama baru
5. Share versi edited
```

### Version Control
```
1. Commit file XML ke Git
2. Tag dengan version number
3. Include change log
4. Update documentation
```

---

**📞 Need Help?**

1. Check documentation files
2. Google "how to use draw.io"
3. Contact technical team
4. Open issue in repository

---

**🎉 SELAMAT MENGGUNAKAN DOKUMENTASI FLOWCHART MBG REPORT! 🎉**

**Created with ❤️ for better documentation**

Start from: **[Choose your path above]**
