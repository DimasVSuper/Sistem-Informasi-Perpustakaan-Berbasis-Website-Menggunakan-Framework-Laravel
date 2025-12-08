# ��� Activity Diagram - Sistem Informasi Perpustakaan

## Alur Peminjaman Buku

Berikut adalah alur lengkap proses peminjaman buku dari awal hingga selesai:

```
┌────────────────────────────┐
│      Anggota               │
└─────────┬──────────────────┘
          │
          ▼
    [Login Sistem]
          │
          ▼
[Browse Katalog Buku]
          │
          ▼
[Memilih Buku untuk Dipinjam]
          │
          ▼
[Mengisi Durasi Peminjaman]
          │
          ▼
[Submit Peminjaman]
          │
          ▼
   [Status: PENDING]
          │
    ┌─────────────────────────────────────┐
    │   Pustakawan                        │
    └─────────┬───────────────────────────┘
              │
              ▼
    [Lihat Daftar Peminjaman Pending]
              │
              ▼
    [Review Data Anggota & Buku]
              │
              ▼
         <Keputusan>
    ┌──── Disetujui? ────┐
    │      │      │      │
   YA    TIDAK  BATALKAN
    │      │      │
    ▼      ▼      ▼
[APPROVED] [REJECTED] [CANCELLED]
    │
    ▼
[Kurangi Stok Buku]
    │
    ▼
[Anggota Ambil Buku]
    │
    ▼
[Status: APPROVED]
    │
    │     (Masa Peminjaman)
    │     ┌─────────────────┐
    │     │ Hari ke-1 s.d   │
    │     │ Due Date        │
    │     └────┬────────┬───┘
    │          │        │
    │    [Tepat Waktu] [Overdue]
    │          │        │
    ├──────────┼────────┤
    │          │
    ▼          ▼
[Anggota Kembalikan Buku]
    │
    ▼
[Pustakawan Catat Pengembalian]
    │
    ▼
[Hitung Keterlambatan & Denda]
    │
    ▼
[Status: RETURNED]
    │
    ▼
[Tambah Stok Buku]
    │
    ▼
   (SELESAI)
```

## Penjelasan Detail Alur

### ��� **Phase 1: Pengajuan Peminjaman (Anggota)**
1. **Login** - Anggota masuk dengan email & password
2. **Browse** - Melihat daftar buku lengkap dengan filter kategori
3. **Pilih Buku** - Memilih buku yang ingin dipinjam
4. **Isi Durasi** - Memilih lama peminjaman (7, 14, atau 21 hari)
5. **Submit** - Status berubah menjadi **PENDING**

### ✅ **Phase 2: Konfirmasi Pustakawan**
1. **Review** - Pustakawan melihat detail peminjaman
2. **Keputusan** - Approve, Reject, atau Cancel
3. **Approve** - Jika setuju:
   - Status → **APPROVED**
   - Stok buku dikurangi (available_copies -1)
   - Anggota bisa ambil buku fisik
4. **Reject** - Jika tidak setuju (alasan buku habis, dll)
5. **Cancel** - Jika peminjam membatalkan

### ⏱️ **Phase 3: Masa Peminjaman**
- Anggota memiliki durasi sejumlah hari sesuai yang ditentukan
- Jika tepat waktu → status tetap **APPROVED**
- Jika melewati due_date → status berubah **OVERDUE**
- Sistem otomatis mulai hitung keterlambatan

### ��� **Phase 4: Pengembalian Buku**
1. **Kembalikan** - Anggota membawa buku kembali
2. **Catat** - Pustakawan mencatat waktu pengembalian
3. **Hitung Denda** - Jika terlambat:
   - Rumus: (hari_terlambat × daily_rate) maksimal max_fine
   - Contoh: 3 hari × Rp5.000 = Rp15.000 (jika max Rp100.000)
4. **Update** - Status → **RETURNED**
5. **Stok** - available_copies ditambah kembali
6. **Selesai** - Transaksi peminjaman selesai

## Status Peminjaman

| Status | Keterangan | Trigger | Aksi |
|--------|-----------|---------|------|
| **PENDING** | Menunggu konfirmasi pustakawan | Submit form | Tunggu review |
| **APPROVED** | Telah dikonfirmasi & disetujui | Pustakawan approve | Stok berkurang |
| **REJECTED** | Ditolak oleh pustakawan | Pustakawan reject | Tidak bisa ambil |
| **CANCELLED** | Dibatalkan | Anggota/Pustakawan | - |
| **OVERDUE** | Melebihi batas waktu | Auto (hari melewati due_date) | Hitung denda |
| **RETURNED** | Sudah dikembalikan | Pencatatan pengembalian | Stok bertambah |

## Denda & Keterlambatan

### Perhitungan Otomatis
- **Daily Rate**: Denda per hari keterlambatan (misal: Rp5.000)
- **Max Fine**: Denda maksimal (misal: Rp100.000)
- **Formula**: `MIN(hari_terlambat × daily_rate, max_fine)`

### Contoh Skenario
| Skenario | Hari Terlambat | Perhitungan | Denda Akhir |
|----------|---|---|---|
| Tepat Waktu | 0 | 0 × 5.000 | Rp0 |
| 3 Hari Terlambat | 3 | 3 × 5.000 | Rp15.000 |
| 25 Hari Terlambat | 25 | 25 × 5.000 = 125.000 (cap 100.000) | Rp100.000 |

## Inventory Management

### Tracking Stok Buku
- **Total Copies** - Jumlah total buku yang dimiliki perpustakaan
- **Available Copies** - Buku yang tersedia untuk dipinjam
- **Borrowed** - Total Copies - Available Copies

### Perubahan Stok
```
Awal: Total = 5, Available = 5

Peminjaman Diapprove:
  Available → Available - 1 = 4

Pengembalian:
  Available → Available + 1 = 5
```

## Timeline

```
Hari 1 (Approve)    Hari 7 (Due Date)    Hari 10 (Return)
     │                    │                     │
     ├─────────────────────┤                     │
     │   APPROVED (OK)     │                     │
     │                     ├─────────────────────┤
     │                     │    OVERDUE (3hr)    │
     │                     │                     ├─ RETURNED + Denda
     │                     │                     │
    [Ambil]          [Seharusnya Kembali]    [Dikembalikan]
```
