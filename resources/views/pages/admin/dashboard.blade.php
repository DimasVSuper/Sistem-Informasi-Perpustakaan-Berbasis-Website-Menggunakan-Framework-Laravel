@extends('layouts.app')

@section('title', 'Admin Dashboard - Perpustakaan')

@section('content')
<div class="page-header">
    <h1><i class="bi bi-speedometer2"></i> Dashboard Admin</h1>
    <p class="text-muted">Selamat datang, {{ Auth::user()->name }}</p>
</div>

<!-- Statistics -->
<div class="row">
    <div class="col-md-3">
        <div class="stat-card">
            <i class="bi bi-people" style="font-size: 2rem;"></i>
            <h5>{{ $stats['total_pustakawan'] }}</h5>
            <p>Total Pustakawan</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);">
            <i class="bi bi-person-check" style="font-size: 2rem;"></i>
            <h5>{{ $stats['total_anggota'] }}</h5>
            <p>Total Anggota</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #27ae60 0%, #229954 100%);">
            <i class="bi bi-book" style="font-size: 2rem;"></i>
            <h5>{{ $stats['total_buku'] }}</h5>
            <p>Total Buku</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);">
            <i class="bi bi-tag" style="font-size: 2rem;"></i>
            <h5>{{ $stats['total_kategori'] }}</h5>
            <p>Total Kategori</p>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="card mt-5">
    <div class="card-header">
        <h5 class="mb-0">Aksi Cepat</h5>
    </div>
    <div class="card-body">
        <a href="{{ route('admin.users.index') }}" class="btn btn-primary me-2">
            <i class="bi bi-people-fill"></i> Kelola Pustakawan
        </a>
        <a href="{{ route('admin.users.create') }}" class="btn btn-success me-2">
            <i class="bi bi-plus-circle"></i> Tambah Pustakawan
        </a>
    </div>
</div>

<!-- Recent Activity -->
<div class="card mt-4">
    <div class="card-header">
        <h5 class="mb-0">Informasi Sistem</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Nama Aplikasi:</strong> Sistem Informasi Perpustakaan</p>
                <p><strong>Versi:</strong> 1.0</p>
                <p><strong>Framework:</strong> Laravel 11</p>
            </div>
            <div class="col-md-6">
                <p><strong>Database:</strong> SQLite</p>
                <p><strong>Tanggal:</strong> {{ date('d M Y') }}</p>
                <p><strong>Jam:</strong> {{ date('H:i:s') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
