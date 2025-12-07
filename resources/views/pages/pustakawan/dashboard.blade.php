@extends('layouts.app')

@section('title', 'Pustakawan Dashboard - Perpustakaan')

@section('content')
<div class="page-header">
    <h1><i class="bi bi-speedometer2"></i> Dashboard Pustakawan</h1>
    <p class="text-muted">Selamat datang, {{ Auth::user()->name }}</p>
</div>

<!-- Statistics -->
<div class="row">
    <div class="col-md-3">
        <div class="stat-card">
            <i class="bi bi-book" style="font-size: 2rem;"></i>
            <h5>{{ $stats['total_buku'] }}</h5>
            <p>Total Buku</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);">
            <i class="bi bi-tag" style="font-size: 2rem;"></i>
            <h5>{{ $stats['total_kategori'] }}</h5>
            <p>Total Kategori</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);">
            <i class="bi bi-clock-history" style="font-size: 2rem;"></i>
            <h5>{{ $stats['peminjaman_pending'] }}</h5>
            <p>Peminjaman Pending</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #9b59b6 0%, #8e44ad 100%);">
            <i class="bi bi-exclamation-triangle" style="font-size: 2rem;"></i>
            <h5>{{ $stats['peminjaman_overdue'] }}</h5>
            <p>Peminjaman Overdue</p>
        </div>
    </div>
</div>

<!-- Menu Utama -->
<div class="row mt-5">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-book"></i> Manajemen Buku</h5>
            </div>
            <div class="card-body">
                <p class="text-muted">Kelola data buku dalam sistem</p>
                <a href="{{ route('pustakawan.books.index') }}" class="btn btn-sm btn-primary me-2">
                    <i class="bi bi-list"></i> Lihat Semua Buku
                </a>
                <a href="{{ route('pustakawan.books.create') }}" class="btn btn-sm btn-success">
                    <i class="bi bi-plus-circle"></i> Tambah Buku
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-tag"></i> Kategori Buku</h5>
            </div>
            <div class="card-body">
                <p class="text-muted">Kelola kategori buku</p>
                <a href="{{ route('pustakawan.categories.index') }}" class="btn btn-sm btn-primary me-2">
                    <i class="bi bi-list"></i> Lihat Semua Kategori
                </a>
                <a href="{{ route('pustakawan.categories.create') }}" class="btn btn-sm btn-success">
                    <i class="bi bi-plus-circle"></i> Tambah Kategori
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-box-arrow-right"></i> Peminjaman</h5>
            </div>
            <div class="card-body">
                <p class="text-muted">Kelola data peminjaman dan pengembalian buku</p>
                <a href="{{ route('pustakawan.loans.index') }}" class="btn btn-sm btn-primary me-2">
                    <i class="bi bi-list"></i> Lihat Semua Peminjaman
                </a>
                <a href="{{ route('pustakawan.loans.create') }}" class="btn btn-sm btn-success">
                    <i class="bi bi-plus-circle"></i> Catat Peminjaman
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-cash"></i> Konfigurasi Denda</h5>
            </div>
            <div class="card-body">
                <p class="text-muted">Atur nominal dan ketentuan denda keterlambatan</p>
                <a href="{{ route('pustakawan.fines.index') }}" class="btn btn-sm btn-primary me-2">
                    <i class="bi bi-list"></i> Lihat Konfigurasi
                </a>
                <a href="{{ route('pustakawan.fines.create') }}" class="btn btn-sm btn-success">
                    <i class="bi bi-plus-circle"></i> Tambah Konfigurasi
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Checklist Pekerjaan -->
<div class="card mt-5">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-clipboard-check"></i> Checklist Harian</h5>
    </div>
    <div class="card-body">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="check1">
            <label class="form-check-label" for="check1">
                Periksa peminjaman yang pending
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="check2">
            <label class="form-check-label" for="check2">
                Proses pengembalian buku yang sudah dikembalikan
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="check3">
            <label class="form-check-label" for="check3">
                Hitung denda untuk peminjaman yang overdue
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="check4">
            <label class="form-check-label" for="check4">
                Validasi stok buku
            </label>
        </div>
    </div>
</div>
@endsection
