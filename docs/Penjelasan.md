# ��� Penjelasan Teknis - Sistem Informasi Perpustakaan

## Ringkasan Sistem

Sistem Informasi Perpustakaan adalah aplikasi berbasis web yang dirancang untuk mengelola seluruh operasional perpustakaan secara digital. Sistem ini menggunakan arsitektur **MVC (Model-View-Controller)** dengan Laravel 11 dan database SQLite.

## Arsitektur Sistem

```
REQUEST
  ▼
ROUTER (routes/web.php)
  ▼
MIDDLEWARE (Authentication & Authorization)
  ▼
CONTROLLER (Business Logic)
  ▼
MODEL (Database Interaction)
  ▼
DATABASE (SQLite)
  ▼
VIEW (Blade Template)
  ▼
RESPONSE
```

## Komponen Utama

### 1. **Routes** (routes/web.php)
Mendefinisikan semua endpoint URL sistem dengan 4 grup akses:
- **Public**: /login, /register, / (home)
- **Admin**: /admin/* (with AdminMiddleware)
- **Pustakawan**: /pustakawan/* (with PustakawanMiddleware)
- **Anggota**: /anggota/* (with AnggotaMiddleware)

### 2. **Middleware** (app/Http/Middleware/)
Mengecek hak akses sebelum controller dijalankan:
- **AdminMiddleware**: Verifikasi role = 'admin'
- **PustakawanMiddleware**: Verifikasi role = 'pustakawan'
- **AnggotaMiddleware**: Verifikasi role = 'anggota'

### 3. **Controllers** (app/Http/Controllers/)
Menangani logika bisnis untuk setiap resource:
- **UserController**: CRUD untuk Pustakawan (Admin)
- **BookController**: CRUD untuk Buku (Pustakawan)
- **CategoryController**: CRUD untuk Kategori (Pustakawan)
- **LoanController**: CRUD untuk Peminjaman (All roles)
- **FineController**: CRUD untuk Konfigurasi Denda
- **DashboardController**: Statistik untuk setiap role
- **BerandaController**: Halaman home

### 4. **Models** (app/Models/)
Merepresentasikan data dan relasi database:
- **User**: Menyimpan data pengguna dengan role (admin, pustakawan, anggota)
- **Book**: Menyimpan data buku dengan tracking available_copies
- **Loan**: Menyimpan data peminjaman dengan status tracking
- **Fine**: Konfigurasi denda per hari dan maksimal
- **Category**: Kategori/klasifikasi buku
- **PasswordReset**: Manajemen reset password token

### 5. **Views** (resources/views/)
43 Blade template untuk render HTML:
- **Layouts**: Master layout dengan navbar & sidebar
- **Auth**: Login & Register pages
- **Pages**: Dashboard, CRUD pages untuk setiap resource
- **Errors**: Error pages (404, 500, etc)

### 6. **Database** (SQLite)
8 tables dengan relasi:
- users
- books (FK: category_id)
- categories
- loans (FK: user_id, book_id)
- fines
- password_resets
- sessions (DB-backed)
- cache_tables (DB-backed)

## Role-Based Access Control (RBAC)

### Admin ���‍���
- **Akses**: /admin/*
- **Fitur**: Manajemen Pustakawan (CRUD)
- **Soft Delete**: Bisa soft delete Pustakawan
- **Dashboard**: Statistik system-wide

### Pustakawan ���
- **Akses**: /pustakawan/*
- **Fitur**: 
  - Manajemen Anggota (CRUD)
  - Manajemen Buku (CRUD)
  - Manajemen Kategori (CRUD)
  - Konfigurasi Denda
  - Konfirmasi Peminjaman
  - Pencatatan Pengembalian
- **Dashboard**: Statistik operasional

### Anggota ���
- **Akses**: /anggota/*
- **Fitur**:
  - Browse Katalog Buku
  - Peminjaman Buku (submit request)
  - Pengembalian Buku
  - Lihat Riwayat Peminjaman
- **Dashboard**: Personal stats

## Fitur Utama

### 1. Soft Delete
User (Pustakawan) bisa di-soft delete:
- Tidak benar-benar dihapus dari database
- Kolom `deleted_at` menyimpan waktu penghapusan
- Query otomatis exclude soft-deleted records
- Admin bisa melihat statistik: active vs inactive

### 2. Inventory Management
Tracking real-time stok buku:
- `total_copies` = jumlah total eksemplar
- `available_copies` = jumlah buku yang bisa dipinjam
- `borrowed` = total_copies - available_copies
- Auto-update saat approve/return peminjaman

### 3. Loan Status Management
6 status peminjaman:
- **PENDING**: Menunggu konfirmasi pustakawan
- **APPROVED**: Disetujui, bisa diambil
- **REJECTED**: Ditolak
- **CANCELLED**: Dibatalkan
- **OVERDUE**: Melewati due_date, hitung denda
- **RETURNED**: Sudah dikembalikan

### 4. Fine Calculation
Perhitungan otomatis denda keterlambatan:
```
Jika returned_at > due_date:
  hari_terlambat = returned_at - due_date
  denda = MIN(hari_terlambat × daily_rate, max_fine)
```

### 5. Session & Cache
Menggunakan database-backed storage:
- Sessions disimpan di table `sessions`
- Cache disimpan di table `cache_tables`
- Persistent across page refresh
- Better for shared hosting

### 6. Authentication
Menggunakan Laravel built-in auth:
- Password di-hash dengan bcrypt
- Guard default: 'web' (session-based)
- Remember me functionality via token
- CSRF protection pada semua form

## Data Flow Example: Peminjaman Buku

```
1. Anggota membuka /anggota/dashboard
   → Request diterima oleh Router
   
2. Router match route ke LoanController@create
   
3. AnggotaMiddleware check:
   - User authenticated? YES
   - User role = 'anggota'? YES
   - Lanjut ke controller
   
4. LoanController@create:
   - Query categories dari database
   - Query books dengan available_copies > 0
   - Pass data ke view
   
5. Blade template render:
   - Tampilkan form dengan kategori dropdown
   - Tampilkan list buku yang available
   
6. Anggota isi form & submit
   - POST /anggota/loans
   
7. LoanController@store:
   - Validasi input
   - Buat record Loan:
     * user_id = auth()->id()
     * book_id = request('book_id')
     * status = 'PENDING'
     * created_at = now()
     * due_date = now() + durasi_hari
   - Save ke database
   
8. Redirect ke /anggota/loans
   - Tampilkan success message
   - Tunggu konfirmasi pustakawan
```

## File Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── UserController.php
│   │   ├── BookController.php
│   │   ├── LoanController.php
│   │   ├── FineController.php
│   │   ├── CategoryController.php
│   │   ├── DashboardController.php
│   │   └── BerandaController.php
│   └── Middleware/
│       ├── AdminMiddleware.php
│       ├── PustakawanMiddleware.php
│       └── AnggotaMiddleware.php
├── Models/
│   ├── User.php (with SoftDeletes)
│   ├── Book.php
│   ├── Loan.php
│   ├── Fine.php
│   ├── Category.php
│   └── PasswordReset.php
└── Providers/
    └── AppServiceProvider.php

database/
├── migrations/
│   ├── 0001_01_01_000000_create_users_table.php
│   ├── 2025_12_08_000001_create_categories_table.php
│   ├── 2025_12_08_000002_create_books_table.php
│   ├── 2025_12_08_000003_create_loans_table.php
│   ├── 2025_12_08_000004_create_fines_table.php
│   ├── 2025_12_08_000005_create_password_resets_table.php
│   ├── 2025_12_08_000006_create_sessions_table.php
│   └── 2025_12_08_000007_create_cache_table.php
├── seeders/
│   └── DatabaseSeeder.php (sample data)
└── factories/
    ├── BookFactory.php
    ├── CategoryFactory.php
    ├── LoanFactory.php
    ├── UserFactory.php
    └── FineFactory.php

resources/views/
├── auth/
│   ├── login.blade.php
│   └── register.blade.php
├── layouts/
│   └── app.blade.php
├── pages/
│   ├── admin/
│   │   └── users/ (CRUD pages)
│   ├── pustakawan/
│   │   ├── books/ (CRUD)
│   │   ├── categories/ (CRUD)
│   │   ├── users/ (CRUD)
│   │   └── fines/ (CRUD)
│   └── loans/ (shared for all roles)
└── errors/

routes/
└── web.php (all route definitions)

config/
├── app.php
├── auth.php
├── database.php
├── session.php
└── ... (other configs)
```

## Best Practices Diterapkan

✅ **Relationship Eager Loading**
- Gunakan `.with()` untuk prevent N+1 query problem
- Contoh: `Book::with('category')->paginate(10)`

✅ **Authorization**
- Middleware untuk route-level authorization
- Role checking di controller level

✅ **Validation**
- Server-side validation di Controller
- Client-side validation di HTML5

✅ **Error Handling**
- Try-catch exception handling
- User-friendly error messages
- Proper HTTP status codes

✅ **Security**
- CSRF protection via @csrf directive
- SQL injection prevention via Eloquent ORM
- XSS protection via Blade escaping {{}
- Password hashing dengan bcrypt
- Role-based access control

✅ **Code Organization**
- Controllers lean (minimal business logic)
- Models handle kompleks logic
- Views hanya untuk rendering

✅ **Performance**
- Database indexing di migration
- Pagination untuk list views
- Caching strategies

## Technology Stack

- **Framework**: Laravel 11
- **PHP Version**: ^8.2
- **Database**: SQLite
- **Frontend**: Bootstrap 5.3.8 + Bootstrap Icons
- **Template Engine**: Blade
- **ORM**: Eloquent
- **Build Tool**: Vite
- **Package Manager**: Composer (PHP), NPM (JavaScript)

## Cara Menjalankan Sistem

```bash
# 1. Clone repository
git clone <repo-url>

# 2. Install dependencies
composer install
npm install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Create database & run migrations
php artisan migrate:fresh --seed

# 5. Build assets
npm run build

# 6. Jalankan server
php artisan serve

# Akses di http://localhost:8000
```

## Testing Credentials

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@perpustakaan.com | admin123 |
| Pustakawan | siti@perpustakaan.com | pustakawan123 |
| Pustakawan | bambang@perpustakaan.com | pustakawan123 |
| Anggota | ahmad@email.com | member123 |
| Anggota | rina@email.com | member123 |

