# 📚 Sistem Informasi Perpustakaan

**Library Management System built with Laravel 11 & Bootstrap 5**

![Laravel 11](https://img.shields.io/badge/Laravel-11.0-FF2D20?style=for-the-badge&logo=laravel)
![PHP 8.2](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php)
![Bootstrap 5](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap)
![SQLite](https://img.shields.io/badge/SQLite-3-003B57?style=for-the-badge&logo=sqlite)
![Status](https://img.shields.io/badge/Status-Development-FFA500?style=for-the-badge)

---

## 🎯 Tentang Proyek

Sistem Informasi Perpustakaan adalah aplikasi web yang dirancang untuk mengelola operasional perpustakaan secara digital. Aplikasi ini memungkinkan pengelolaan buku, anggota, peminjaman, dan denda dengan antarmuka yang intuitif dan responsif.

> **Filosofi Pengembangan:**  
> *"Terkadang simple tapi lancar dan cepat lebih baik daripada struktur folder views elit tapi susah"* 🚀
>
> Kesalahan saya adalah membuat Structure Folder Views yang sangat rapih dan Kompleks tapi mempersulit diri saya sendiri hehe......

---

## 🚀 Fitur Utama

### 👤 **Admin** (Pengelola Sistem)
- ✅ Login/Logout
- ✅ Manajemen Pustakawan (Tambah, Edit, Hapus)
- ✅ Melihat Dashboard dengan Statistik
- ✅ Monitoring keseluruhan sistem

### 📖 **Pustakawan** (Petugas Perpustakaan)
- ✅ Login/Logout
- ✅ Manajemen Anggota (Tambah, Edit, Hapus)
- ✅ Manajemen Buku (Tambah, Edit, Hapus)
- ✅ Manajemen Kategori Buku (Tambah, Edit, Hapus)
- ✅ Konfigurasi Nominal Denda
- ✅ Konfirmasi Peminjaman Buku
- ✅ Pencatatan Pengembalian Buku
- ✅ Penghapusan Data Peminjaman
- ✅ Dashboard dengan Statistik Lengkap

### 👥 **Anggota** (Peminjam)
- ✅ Registrasi & Login
- ✅ Meminjam Buku
- ✅ Mengembalikan Buku
- ✅ Melihat Riwayat Peminjaman
- ✅ Dashboard Personal

---

## 📋 Use Case Diagram

```
┌─────────────────────────────────────────────────────────────┐
│                      SISTEM PERPUSTAKAAN                   │
├─────────────────────────────────────────────────────────────┤
│                                                             │
│  ADMIN                 PUSTAKAWAN              ANGGOTA     │
│  ├─ Login              ├─ Login                ├─ Login     │
│  ├─ Logout             ├─ Logout               ├─ Logout    │
│  ├─ Add Pustakawan     ├─ Manage Anggota       ├─ Borrow    │
│  ├─ Edit Pustakawan    ├─ Manage Buku          ├─ Return    │
│  └─ Delete Pustakawan  ├─ Manage Kategori      └─ History   │
│                        ├─ Manage Denda                      │
│                        ├─ Confirm Loans                     │
│                        └─ Record Returns                    │
│                                                             │
└─────────────────────────────────────────────────────────────┘
```

---

## 💾 Database Schema

### **Users** (Pengguna)
- ID, Nama, Email, Phone, Address, Role, Password

### **Categories** (Kategori Buku)
- ID, Nama, Deskripsi

### **Books** (Buku)
- ID, Category ID, Judul, Pengarang, ISBN, Penerbit, Tahun, Total Copies, Available Copies

### **Loans** (Peminjaman)
- ID, User ID, Book ID, Tanggal Pinjam, Tanggal Jatuh Tempo, Tanggal Kembali, Status, Jumlah Denda

### **Fines** (Konfigurasi Denda)
- ID, Tarif Harian, Denda Maksimal

### **Password Resets** & **Sessions**
- Untuk reset password dan session management

---

## 🛠️ Stack Teknologi

| Component | Technology |
|-----------|-----------|
| **Backend** | Laravel 11 |
| **Frontend** | Blade Template, Bootstrap 5, Bootstrap Icons |
| **Database** | SQLite |
| **Package Manager** | Composer, NPM |
| **Build Tool** | Vite |
| **PHP Version** | ^8.2 |

---

## 📦 Instalasi & Setup

### **Prasyarat**
- PHP 8.2+
- Composer
- Node.js & NPM
- Git

### **Langkah Instalasi**

1. **Clone Repository**
```bash
git clone https://github.com/DimasVSuper/Sistem-Informasi-Perpustakaan-Berbasis-Website-Menggunakan-Framework-Laravel.git
cd Sistem-Informasi-Perpustakaan-Berbasis-Website-Menggunakan-Framework-Laravel
```

2. **Install Dependencies**
```bash
composer install
npm install
```

3. **Setup Environment**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Database Setup**
```bash
php artisan migrate:fresh --seed
```

5. **Build Assets**
```bash
npm run build
```

6. **Jalankan Server**
```bash
php artisan serve
```

Akses aplikasi di: `http://localhost:8000`

---

## 👥 Akun Default untuk Testing

### **Admin**
- **Email:** `admin@perpustakaan.com`
- **Password:** `admin123`

### **Pustakawan**
- **Email:** `siti@perpustakaan.com`
- **Password:** `pustakawan123`
- **Email:** `bambang@perpustakaan.com`
- **Password:** `pustakawan123`

### **Anggota (Member)**
- **Email:** `ahmad@email.com`
- **Password:** `member123`
- **Email:** `rina@email.com`
- **Password:** `member123`

---

## 📁 Struktur Folder

```
Sistem-Informasi-Perpustakaan/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   ├── BerandaController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── UserController.php
│   │   │   ├── BookController.php
│   │   │   ├── CategoryController.php
│   │   │   ├── LoanController.php
│   │   │   └── FineController.php
│   │   └── Middleware/
│   │       ├── AdminMiddleware.php
│   │       ├── PustakawanMiddleware.php
│   │       └── AnggotaMiddleware.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Book.php
│   │   ├── Category.php
│   │   ├── Loan.php
│   │   └── Fine.php
│   └── Providers/
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── factories/
├── resources/
│   ├── views/
│   │   ├── auth/
│   │   ├── layouts/
│   │   ├── pages/
│   │   │   ├── admin/
│   │   │   ├── pustakawan/
│   │   │   ├── anggota/
│   │   │   └── loans/
│   │   └── errors/
│   ├── css/
│   └── js/
├── routes/
│   └── web.php
├── storage/
├── tests/
└── public/
```

---

## 🔄 Alur Aplikasi

### **Alur Peminjaman Buku**
```
Anggota
  ↓
[Login]
  ↓
[Lihat Katalog Buku]
  ↓
[Pilih Buku untuk Dipinjam]
  ↓
[Isi Durasi Peminjaman]
  ↓
[Submit Peminjaman → Status: PENDING]
  ↓
Pustakawan
  ↓
[Konfirmasi Peminjaman → Status: APPROVED]
  ↓
[Kurangi Stok Buku]
```

### **Alur Pengembalian Buku**
```
Anggota/Pustakawan
  ↓
[Akses Form Pengembalian]
  ↓
[Input Tanggal Pengembalian]
  ↓
[Sistem Hitung Denda (jika terlambat)]
  ↓
[Update Status → RETURNED]
  ↓
[Tambah Stok Buku]
```

---

## 🐛 Status Pengembangan

⚠️ **Status:** Development (Masih dalam tahap pencarian bug)

### **TODO List**
- [ ] WhatsApp notification untuk pengingat pengembalian (Bukan prioritas)
- [ ] Export laporan PDF
- [ ] Email notification
- [ ] Dashboard statistics improvement
- [ ] Unit & Feature Tests
- [ ] API Development

### **Known Issues**
- Belum ada fitur WhatsApp integration
- Belum ada email notification

---

## 🚨 Fitur dalam Pengembangan

Saat ini sistem masih dalam fase development dan kami terus mencari dan memperbaiki bug. Beberapa fitur mungkin masih dalam tahap penyempurnaan.

Jika menemukan bug atau issue, silakan laporkan di repository ini.

---

## 📊 Sample Data

Sistem dilengkapi dengan sample data termasuk:
- **12 Buku** dengan berbagai kategori (Fiksi, Non-Fiksi, Teknologi, Pendidikan, Seni & Budaya)
- **5 Kategori Buku** yang sudah dikonfigurasi
- **7 Pengguna** (1 Admin, 2 Pustakawan, 4 Anggota)
- **5 Peminjaman** dalam berbagai status (pending, approved, overdue, returned)

---

## 🎨 UI/UX Features

- ✅ Responsive Design (Mobile, Tablet, Desktop)
- ✅ Bootstrap 5 Components
- ✅ Bootstrap Icons Integration
- ✅ Dark Mode Compatible
- ✅ Form Validation
- ✅ Success/Error Alert Messages
- ✅ Pagination untuk List Data
- ✅ Search & Filter Functionality

---

## 🔐 Security Features

- ✅ Authentication & Authorization
- ✅ Role-based Access Control (RBAC)
- ✅ Password Hashing (bcrypt)
- ✅ CSRF Protection
- ✅ SQL Injection Prevention (Eloquent ORM)
- ✅ XSS Protection (Blade Template Escaping)

---

## 📝 Dokumentasi Tambahan

Lihat folder `docs/` untuk:
- `UseCase.md` - Detail use case sistem
- `ActivityDiagram.md` - Diagram aktivitas
- `Penjelasan.md` - Penjelasan teknis

---

## 🤝 Kontribusi

Kontribusi, bug reports, dan feature requests sangat diterima!

Silakan:
1. Fork repository ini
2. Buat branch feature (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buka Pull Request

---

## 📜 License

Proyek ini dilisensikan di bawah MIT License - lihat file `LICENSE` untuk detail.

---

## 👨‍💻 Author

**Dimas V.** - [@DimasVSuper](https://github.com/DimasVSuper)

---

## 📮 Support & Contact

Untuk pertanyaan, saran, atau bantuan:
- 📧 Email: dimas@example.com
- 💬 Issues: GitHub Issues
- 🌐 Website: [Your Website]

---

## 🙏 Terima Kasih

Terima kasih kepada:
- Laravel Community
- Bootstrap Team
- Kontributor dan pengguna yang memberikan feedback

---

## 📈 Roadmap Selanjutnya

- [ ] Mobile App (Flutter/React Native)
- [ ] Advanced Analytics Dashboard
- [ ] Integration dengan sistem membership
- [ ] QR Code untuk tracking buku
- [ ] Payment Gateway integration
- [ ] Multi-language support
- [ ] API REST penuh

---

**Dibuat dengan ❤️ menggunakan Laravel 11**

*Last Updated: 8 December 2025*

