# ��� Use Case Specification - Sistem Informasi Perpustakaan

## Daftar Use Case

### **ROLE: ADMIN** ���‍���
1. ✅ **Login** - Masuk ke sistem
2. ✅ **Logout** - Keluar dari sistem
3. ✅ **Add Pustakawan** - Tambah data pustakawan baru
4. ✅ **Edit Pustakawan** - Edit data pustakawan
5. ✅ **Delete Pustakawan** - Soft delete pustakawan
6. ✅ **View Dashboard** - Lihat statistik system-wide

### **ROLE: PUSTAKAWAN** ���
1. ✅ **Login** - Masuk ke sistem
2. ✅ **Logout** - Keluar dari sistem
3. ✅ **Add Anggota** - Tambah anggota baru
4. ✅ **Edit Anggota** - Edit data anggota
5. ✅ **Delete Anggota** - Soft delete anggota
6. ✅ **Add Buku** - Tambah buku ke katalog
7. ✅ **Edit Buku** - Edit data buku
8. ✅ **Delete Buku** - Hapus buku (jika tidak ada loan aktif)
9. ✅ **Add Kategori** - Tambah kategori buku
10. ✅ **Edit Kategori** - Edit kategori
11. ✅ **Delete Kategori** - Hapus kategori
12. ✅ **Set Fine Configuration** - Tentukan nominal denda
13. ✅ **Confirm Loan** - Approve/Reject peminjaman
14. ✅ **Record Return** - Catat pengembalian buku & hitung denda
15. ✅ **Delete Loan** - Hapus data peminjaman (rejected/cancelled)
16. ✅ **View Dashboard** - Lihat statistik operasional

### **ROLE: ANGGOTA** ���
1. ✅ **Register** - Daftar akun baru
2. ✅ **Login** - Masuk ke sistem
3. ✅ **Logout** - Keluar dari sistem
4. ✅ **Browse Books** - Lihat katalog buku
5. ✅ **Borrow Book** - Pinjam buku (submit request)
6. ✅ **Return Book** - Kembalikan buku
7. ✅ **View Loan History** - Lihat riwayat peminjaman
8. ✅ **View Dashboard** - Lihat statistik personal

---

## Use Case Detail

### **UC-01: LOGIN**
**Actor**: User (belum authenticated)
**Precondition**: User punya akun valid
**Main Flow**:
1. User buka halaman /login
2. Inputkan email & password
3. Click "Login"
4. Sistem validasi kredensial
5. Jika valid → set session, redirect ke dashboard sesuai role
6. Jika invalid → tampilkan error message, tetap di login page

**Validation**:
- Email harus format email valid
- Password minimal 6 karakter
- Account harus aktif (tidak soft deleted)

---

### **UC-02: LOGOUT**
**Actor**: User (authenticated)
**Precondition**: User sudah login
**Main Flow**:
1. User klik tombol "Logout"
2. Sistem destroy session
3. Clear remember token jika ada
4. Redirect ke halaman login
5. Tampilkan pesan "Logout berhasil"

---

### **UC-03: ADD PUSTAKAWAN (Admin)**
**Actor**: Admin
**Precondition**: Admin sudah login, middleware verify role='admin'
**Main Flow**:
1. Admin ke /admin/users/create
2. Isi form:
   - Nama (required, text)
   - Email (required, unique, email format)
   - Phone (optional)
   - Address (optional)
   - Password auto-generate atau input manual
3. Sistem set role = 'pustakawan'
4. Hash password dengan bcrypt
5. Save ke database
6. Redirect ke /admin/users
7. Tampilkan success notification

**Validation**:
- Email belum terdaftar (unique check)
- Nama tidak boleh kosong
- Email format valid
- Password minimum 8 karakter

---

### **UC-04: EDIT PUSTAKAWAN (Admin)**
**Actor**: Admin
**Precondition**: Admin sudah login, pustakawan exists di database
**Main Flow**:
1. Admin klik Edit pada daftar pustakawan
2. Load form dengan data existing
3. Ubah field yang ingin diupdate:
   - Nama
   - Email
   - Phone
   - Address
   - Optional: Reset password (input password baru)
4. Click "Update"
5. Sistem validate & save
6. Redirect ke users list
7. Tampilkan success message

**Validation**:
- Email harus unik (tidak duplikat dengan pustakawan lain)
- Nama tidak boleh kosong
- Jika reset password, password min 8 karakter

---

### **UC-05: DELETE PUSTAKAWAN (Admin)**
**Actor**: Admin
**Precondition**: Admin sudah login, pustakawan exists
**Main Flow**:
1. Admin klik Delete pada daftar pustakawan
2. Sistem tampilkan confirmation dialog
3. Jika confirm → soft delete (set deleted_at = now)
4. Jika cancel → tidak ada aksi
5. Redirect ke users list
6. Tampilkan success message
7. Pustakawan tidak bisa login lagi

**Business Logic**:
- Soft delete, bukan hard delete
- Pustakawan tetap ada di database untuk audit
- Active/Inactive statistik updated
- Tidak bisa hapus diri sendiri (self-delete)

---

### **UC-06: ADD ANGGOTA (Pustakawan)**
**Actor**: Pustakawan
**Precondition**: Pustakawan sudah login, middleware verify role='pustakawan'
**Main Flow**:
1. Pustakawan ke /pustakawan/users/create
2. Isi form:
   - Nama (required)
   - Email (required, unique)
   - Phone (optional)
   - Address (optional)
   - Password auto-generate
3. Sistem set role = 'anggota'
4. Save ke database
5. Redirect ke /pustakawan/users
6. Success notification

---

### **UC-07: ADD BUKU (Pustakawan)**
**Actor**: Pustakawan
**Precondition**: Pustakawan sudah login
**Main Flow**:
1. Pustakawan ke /pustakawan/books/create
2. Isi form:
   - Judul (required, text)
   - Pengarang (required, text)
   - ISBN (required, unique, 13 digit)
   - Kategori (required, select from dropdown)
   - Penerbit (optional)
   - Tahun Terbit (optional, default: current year)
   - Total Copies (required, min: 1)
   - Harga (optional, number)
   - Deskripsi (optional, textarea)
3. Click "Simpan"
4. Validasi & save ke database
5. Set available_copies = total_copies
6. Redirect ke books list
7. Success message

**Validation**:
- ISBN harus 13 digit & unique
- Judul, Pengarang harus ada
- Total copies minimal 1
- Kategori harus dipilih

---

### **UC-08: CONFIRM LOAN (Pustakawan)**
**Actor**: Pustakawan
**Precondition**: Loan status = PENDING
**Main Flow**:
1. Pustakawan ke /pustakawan/loans
2. Filter status = PENDING
3. Klik loan untuk melihat detail
4. Review data anggota & buku
5. Click "Approve" atau "Reject"

**If Approve**:
- Status → APPROVED
- available_copies dikurangi 1
- Update success
- Redirect ke loans list

**If Reject**:
- Optional: Input reason
- Status → REJECTED
- Stok tidak berubah
- Anggota tidak bisa ambil buku

**Validation**:
- Buku harus tersedia (available_copies > 0)
- Anggota tidak boleh ada overdue loan
- Tidak exceed max simultaneous loans (misal max 5)

---

### **UC-09: RECORD RETURN (Pustakawan)**
**Actor**: Pustakawan
**Precondition**: Loan status = APPROVED
**Main Flow**:
1. Pustakawan ke /pustakawan/loans
2. Filter status = APPROVED
3. Klik "Return"
4. Input tanggal pengembalian (default: today)
5. Sistem auto-calculate:
   - Jika returned_date > due_date:
     * hari_terlambat = returned_date - due_date
     * denda = MIN(hari_terlambat × daily_rate, max_fine)
6. Tampilkan perhitungan denda ke pustakawan
7. Optional: Pustakawan bisa adjust denda amount
8. Click "Confirm Return"
9. Update database:
   - Status → RETURNED
   - returned_at = input date
   - fine_amount = calculated amount
   - available_copies ditambah 1
10. Success message

**Validation**:
- returned_date ≥ created_at (tidak boleh sebelum pinjam)
- Denda tidak boleh > max_fine
- Hanya bisa return jika status APPROVED

---

### **UC-10: BORROW BOOK (Anggota)**
**Actor**: Anggota
**Precondition**: Anggota sudah login
**Main Flow**:
1. Anggota browse katalog di /anggota/dashboard
2. Lihat daftar buku available
3. Click tombol "Pinjam"
4. Input durasi peminjaman:
   - 7 hari
   - 14 hari
   - 21 hari
5. Click "Submit"
6. Sistem buat Loan record:
   - status = 'PENDING'
   - user_id = auth()->id()
   - book_id = selected book
   - created_at = now
   - due_date = now + duration
7. Redirect ke /anggota/loans
8. Success message "Permintaan peminjaman terkirim, menunggu konfirmasi pustakawan"

**Validation**:
- Buku harus available (available_copies > 0)
- Anggota tidak boleh punya overdue loan lain
- Tidak exceed max simultaneous loans (max 5)
- Durasi harus dipilih

---

### **UC-11: RETURN BOOK (Anggota/Pustakawan)**
**Actor**: Anggota or Pustakawan
**Precondition**: Loan status = APPROVED
**Main Flow**:
1. Ke /anggota/loans atau /pustakawan/loans
2. Lihat daftar active loans
3. Click "Kembalikan"
4. Confirm dialog
5. Submit return
6. Sistem update:
   - Status → RETURNED
   - returned_at = now
   - Calculate fine jika overdue
   - available_copies + 1
7. Tampilkan detail pengembalian & denda (jika ada)
8. Success message

---

### **UC-12: VIEW LOAN HISTORY (Anggota)**
**Actor**: Anggota
**Precondition**: Anggota sudah login
**Main Flow**:
1. Ke /anggota/loans
2. Tampilkan daftar semua peminjaman (paginated)
3. Kolom: Judul, Tgl Pinjam, Batas Kembali, Status, Denda
4. Filter by status (All, Pending, Approved, Overdue, Returned)
5. Click row untuk lihat detail
6. Detail include: Due date countdown, Fine amount, History

---

### **UC-13: VIEW DASHBOARD**
**Actor**: Admin, Pustakawan, Anggota
**Precondition**: User sudah login

**For Admin**:
- Total Pustakawan (Active, Inactive)
- Total Buku, Total Peminjaman
- Status breakdown (pending, approved, overdue, returned)
- Chart/Graph

**For Pustakawan**:
- Total Buku, Total Anggota
- Peminjaman breakdown
- Pending loans list
- Overdue loans alert

**For Anggota**:
- Peminjaman aktif
- Overdue loans (alert)
- Total denda
- Loan history

---

## Use Case Matrix

| Use Case | Admin | Pustakawan | Anggota | Public |
|----------|-------|-----------|---------|--------|
| Login | ✅ | ✅ | ✅ | ✅ |
| Logout | ✅ | ✅ | ✅ | ❌ |
| Register | ❌ | ❌ | ✅ | ✅ |
| Add Pustakawan | ✅ | ❌ | ❌ | ❌ |
| Edit Pustakawan | ✅ | ❌ | ❌ | ❌ |
| Delete Pustakawan | ✅ | ❌ | ❌ | ❌ |
| Manage Anggota | ❌ | ✅ | ❌ | ❌ |
| Manage Buku | ❌ | ✅ | ❌ | ❌ |
| Manage Kategori | ❌ | ✅ | ❌ | ❌ |
| Manage Denda | ❌ | ✅ | ❌ | ❌ |
| Confirm Loan | ❌ | ✅ | ❌ | ❌ |
| Record Return | ❌ | ✅ | ❌ | ❌ |
| Borrow Book | ❌ | ❌ | ✅ | ❌ |
| Return Book | ❌ | ✅ | ✅ | ❌ |
| View History | ❌ | ✅ | ✅ | ❌ |
| View Dashboard | ✅ | ✅ | ✅ | ❌ |

---

## Skenario Penggunaan

### **Skenario 1: Peminjaman Buku Sukses (Tepat Waktu)**

**Flow**:
1. Anggota Ahmad login → /anggota/dashboard
2. Cari buku "Clean Code" → Click "Pinjam"
3. Pilih durasi 7 hari → Submit (UC-10)
4. Status = PENDING, Ahmad redirect ke /anggota/loans
5. Pustakawan Siti login → /pustakawan/loans
6. Lihat pending Ahmad → Click detail → Click "Approve" (UC-08)
7. Status APPROVED, available_copies berkurang
8. Ahmad ambil buku fisik ke perpustakaan
9. Hari ke-7: Ahmad kembalikan buku ke Siti
10. Siti catat pengembalian → Click "Confirm Return" (UC-09)
11. Denda = 0 (tidak terlambat)
12. Status RETURNED, available_copies kembali
13. Complete!

---

### **Skenario 2: Peminjaman dengan Denda (Overdue)**

**Flow**:
1. Anggota Rina pinjam buku, due_date = 15 Desember
2. Hari ke-18: Rina baru kembalikan (3 hari overdue)
3. Daily rate = Rp 5.000, max fine = Rp 100.000
4. Denda = 3 × 5.000 = Rp 15.000
5. Siti catat return:
   - Status OVERDUE → RETURNED
   - fine_amount = Rp 15.000
   - available_copies + 1
6. Rina lihat fine di dashboard
7. Complete!

---

### **Skenario 3: Penolakan Peminjaman**

**Flow**:
1. Anggota Budi request pinjam buku X, status = PENDING
2. Buku X available_copies = 0 (sudah habis)
3. Siti review request → Click "Reject"
4. Status REJECTED, available_copies tetap 0
5. Budi terlihat status REJECTED di /anggota/loans
6. Budi bisa request buku lain
7. Complete!

---

## Relasi & Dependencies

```
UC-01 (Login)
  ├─ UC-03 (Add Pustakawan) - Admin only
  ├─ UC-04 (Edit Pustakawan) - Admin only
  ├─ UC-05 (Delete Pustakawan) - Admin only
  ├─ UC-06 (Add Anggota) - Pustakawan only
  ├─ UC-07 (Add Buku) - Pustakawan only
  ├─ UC-08 (Confirm Loan) - Pustakawan only
  ├─ UC-09 (Record Return) - Pustakawan only
  ├─ UC-10 (Borrow Book) - Anggota only
  ├─ UC-11 (Return Book) - Anggota/Pustakawan
  ├─ UC-12 (View History) - Anggota
  ├─ UC-13 (Dashboard) - All roles
  └─ UC-02 (Logout)
```

---

## Non-Functional Requirements

✅ **Performance**
- Response time < 2 detik untuk semua operasi
- Pagination 10-20 items per page
- Database query optimized dengan eager loading

✅ **Security**
- Password hashed dengan bcrypt
- CSRF protection pada semua form
- Role-based access control
- Input validation & sanitization
- SQL injection prevention via Eloquent

✅ **Reliability**
- 99.5% uptime target
- Automatic database backup
- Error logging & monitoring

✅ **Usability**
- Intuitive UI/UX
- Responsive design (mobile, tablet, desktop)
- Clear error messages
- Helpful tooltips & guidance

✅ **Maintainability**
- Clean code, proper naming
- Comprehensive documentation
- Version control (Git)
- Test coverage (unit & feature tests)



