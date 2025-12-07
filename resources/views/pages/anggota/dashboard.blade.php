@extends('layouts.app')

@section('title', 'Anggota Dashboard - Perpustakaan')

@section('content')
<div class="page-header">
    <h1><i class="bi bi-speedometer2"></i> Dashboard Anggota</h1>
    <p class="text-muted">Selamat datang, {{ Auth::user()->name }}</p>
</div>

<!-- Statistics -->
<div class="row">
    <div class="col-md-4">
        <div class="stat-card">
            <i class="bi bi-box-arrow-right" style="font-size: 2rem;"></i>
            <h5>{{ $stats['total_peminjaman'] }}</h5>
            <p>Total Peminjaman</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card" style="background: linear-gradient(135deg, #27ae60 0%, #229954 100%);">
            <i class="bi bi-check-circle" style="font-size: 2rem;"></i>
            <h5>{{ $stats['peminjaman_aktif'] }}</h5>
            <p>Peminjaman Aktif</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card" style="background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);">
            <i class="bi bi-exclamation-triangle" style="font-size: 2rem;"></i>
            <h5>{{ $stats['peminjaman_overdue'] }}</h5>
            <p>Peminjaman Overdue</p>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="card mt-5">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-lightning"></i> Aksi Cepat</h5>
    </div>
    <div class="card-body">
        <a href="{{ route('anggota.loans.index') }}" class="btn btn-primary me-2">
            <i class="bi bi-list"></i> Lihat Peminjaman Saya
        </a>
        <a href="{{ route('anggota.loans.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Pinjam Buku Baru
        </a>
    </div>
</div>

<!-- Info Penting -->
<div class="card mt-4">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-info-circle"></i> Informasi Penting</h5>
    </div>
    <div class="card-body">
        <div class="alert alert-info" role="alert">
            <strong>Kebijakan Peminjaman:</strong>
            <ul class="mb-0 mt-2">
                <li>Durasi peminjaman maksimal 7 hari</li>
                <li>Maksimal 3 buku sekaligus</li>
                <li>Denda keterlambatan Rp 5.000 per hari</li>
                <li>Maksimal denda Rp 500.000</li>
            </ul>
        </div>
    </div>
</div>

<!-- Bantuan -->
<div class="card mt-4">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-question-circle"></i> Butuh Bantuan?</h5>
    </div>
    <div class="card-body">
        <p>Hubungi pustakawan jika Anda memiliki pertanyaan atau masalah terkait peminjaman buku.</p>
        <p class="text-muted mb-0">Jam Operasional: Senin - Jumat, 08:00 - 16:00 WIB</p>
    </div>
</div>
@endsection
