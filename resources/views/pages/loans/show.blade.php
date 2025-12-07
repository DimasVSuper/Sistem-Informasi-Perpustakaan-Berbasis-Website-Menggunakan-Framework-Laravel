@extends('layouts.app')

@section('title', 'Detail Peminjaman')

@section('content')
<div class="page-header">
    <a href="{{ route(Auth::user()->role . '.loans.index') }}" class="text-muted text-decoration-none">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
    <h1 class="mt-2"><i class="bi bi-info-circle"></i> Detail Peminjaman</h1>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">Informasi Peminjaman</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Peminjam:</strong></p>
                        <p>{{ $loan->user->name }}</p>
                        <p class="text-muted">{{ $loan->user->email }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Status Peminjam:</strong></p>
                        <p>
                            <span class="badge bg-{{ $loan->user->role === 'admin' ? 'danger' : ($loan->user->role === 'pustakawan' ? 'info' : 'success') }}">
                                {{ ucfirst($loan->user->role) }}
                            </span>
                        </p>
                    </div>
                </div>

                <hr>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Buku:</strong></p>
                        <p><strong>{{ $loan->book->title }}</strong></p>
                        <p class="text-muted">{{ $loan->book->author }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Kategori:</strong></p>
                        <p><span class="badge bg-info">{{ $loan->book->category->name }}</span></p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <p><strong>ISBN:</strong></p>
                        <p><code>{{ $loan->book->isbn }}</code></p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Penerbit:</strong></p>
                        <p>{{ $loan->book->publisher ?? '-' }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Tahun Terbit:</strong></p>
                        <p>{{ $loan->book->publication_year ?? '-' }}</p>
                    </div>
                </div>

                <hr>

                <div class="row mb-3">
                    <div class="col-md-3">
                        <p><strong>Tanggal Pinjam:</strong></p>
                        <p>{{ $loan->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <div class="col-md-3">
                        <p><strong>Batas Kembali:</strong></p>
                        <p>{{ $loan->due_date->format('d M Y') }}</p>
                    </div>
                    <div class="col-md-3">
                        <p><strong>Durasi:</strong></p>
                        <p>{{ $loan->created_at->diffInDays($loan->due_date) }} hari</p>
                    </div>
                    <div class="col-md-3">
                        <p><strong>Status:</strong></p>
                        <p>
                            <span class="badge bg-{{ $loan->status === 'returned' ? 'success' : ($loan->status === 'pending' ? 'warning' : ($loan->status === 'overdue' ? 'danger' : 'info')) }} style="font-size: 0.9rem;">
                                {{ ucfirst($loan->status) }}
                            </span>
                        </p>
                    </div>
                </div>

                @if($loan->status === 'returned' && $loan->returned_at)
                    <div class="alert alert-success" role="alert">
                        <i class="bi bi-check-circle"></i> Buku telah dikembalikan pada {{ $loan->returned_at->format('d M Y H:i') }}
                    </div>
                @elseif($loan->isOverdue())
                    <div class="alert alert-danger" role="alert">
                        <i class="bi bi-exclamation-triangle"></i>
                        <strong>Peminjaman Terlambat!</strong> {{ $loan->getOverdueDays() }} hari
                    </div>
                @else
                    <div class="alert alert-info" role="alert">
                        <i class="bi bi-info-circle"></i> Peminjaman aktif - Kembalikan sebelum {{ $loan->due_date->format('d M Y') }}
                    </div>
                @endif

                @if($loan->note)
                    <div class="mt-3">
                        <p><strong>Catatan Peminjaman:</strong></p>
                        <p class="text-muted">{{ $loan->note }}</p>
                    </div>
                @endif

                @if($loan->return_note)
                    <div class="mt-3">
                        <p><strong>Catatan Pengembalian:</strong></p>
                        <p class="text-muted">{{ $loan->return_note }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-tools"></i> Aksi</h5>
            </div>
            <div class="card-body d-flex flex-column gap-2">
                @if($loan->status !== 'returned')
                    <a href="{{ route(Auth::user()->role . '.loans.edit', $loan) }}" class="btn btn-warning">
                        <i class="bi bi-box-arrow-in-left"></i> Kembalikan Buku
                    </a>
                @endif
                <a href="{{ route(Auth::user()->role . '.loans.index') }}" class="btn btn-secondary">
                    <i class="bi bi-list"></i> Kembali ke Daftar
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-calendar"></i> Waktu</h5>
            </div>
            <div class="card-body text-small">
                <p><strong>Hari Sejak Pinjam:</strong></p>
                <p>{{ $loan->created_at->diffInDays(now()) }} hari</p>

                @if($loan->isOverdue())
                    <p class="mt-3"><strong>Keterlambatan:</strong></p>
                    <p class="text-danger"><strong>{{ $loan->getOverdueDays() }} hari</strong></p>

                    <p class="mt-3"><strong>Estimasi Denda:</strong></p>
                    <p class="text-danger">
                        <strong>Rp {{ number_format(min($loan->getOverdueDays() * 5000, 500000), 0, ',', '.') }}</strong>
                    </p>
                @else
                    <p class="mt-3"><strong>Sisa Waktu:</strong></p>
                    <p class="text-info"><strong>{{ $loan->due_date->diffInDays(now()) }} hari</strong></p>
                @endif
            </div>
        </div>
    </div>
@endsection
@endsection
