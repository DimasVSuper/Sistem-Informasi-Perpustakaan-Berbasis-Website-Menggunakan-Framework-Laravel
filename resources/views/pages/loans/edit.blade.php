@extends('layouts.app')

@section('title', 'Pengembalian Buku')

@section('content')
<div class="page-header">
    <a href="{{ route(Auth::user()->role . '.loans.index') }}" class="text-muted text-decoration-none">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
    <h1 class="mt-2"><i class="bi bi-box-arrow-in-left"></i> Pengembalian Buku</h1>
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
                    </div>
                    <div class="col-md-6">
                        <p><strong>Email:</strong></p>
                        <p>{{ $loan->user->email }}</p>
                    </div>
                </div>

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
                        <p><strong>Tanggal Pinjam:</strong></p>
                        <p>{{ $loan->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Batas Kembali:</strong></p>
                        <p>{{ $loan->due_date->format('d M Y') }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Status:</strong></p>
                        <p>
                            <span class="badge bg-{{ $loan->status === 'returned' ? 'success' : ($loan->status === 'pending' ? 'warning' : ($loan->status === 'overdue' ? 'danger' : 'info')) }}">
                                {{ ucfirst($loan->status) }}
                            </span>
                        </p>
                    </div>
                </div>

                @if($loan->isOverdue())
                    <div class="alert alert-danger" role="alert">
                        <i class="bi bi-exclamation-triangle"></i>
                        <strong>Peminjaman Terlambat!</strong>
                        <br>
                        Terlambat: {{ $loan->getOverdueDays() }} hari
                    </div>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Proses Pengembalian</h5>
            </div>
            <div class="card-body">
                <form action="{{ route(Auth::user()->role . '.loans.update', $loan) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="return_date" class="form-label">Tanggal Pengembalian <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('return_date') is-invalid @enderror" id="return_date" name="return_date" value="{{ old('return_date', date('Y-m-d')) }}" required>
                        @error('return_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="return_note" class="form-label">Catatan Pengembalian</label>
                        <textarea class="form-control @error('return_note') is-invalid @enderror" id="return_note" name="return_note" rows="3">{{ old('return_note') }}</textarea>
                        @error('return_note')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Kondisi buku, kerusakan, atau catatan lainnya</small>
                    </div>

                    @if(Auth::user()->isLibrarian() && $loan->isOverdue())
                        <div class="alert alert-warning" role="alert">
                            <strong>Perhitungan Denda:</strong><br>
                            Hari terlambat: {{ $loan->getOverdueDays() }} hari<br>
                            Tarif harian: Rp 5.000<br>
                            Total denda (belum termasuk maksimal): Rp {{ number_format($loan->getOverdueDays() * 5000, 0, ',', '.') }}
                        </div>
                    @endif

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Konfirmasi Pengembalian
                        </button>
                        <a href="{{ route(Auth::user()->role . '.loans.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-info-circle"></i> Ringkasan</h5>
            </div>
            <div class="card-body text-small">
                <p><strong>Durasi Peminjaman:</strong></p>
                <p>{{ $loan->created_at->diffInDays($loan->due_date) }} hari</p>

                <p class="mt-3"><strong>Hari Sejak Pinjam:</strong></p>
                <p>{{ $loan->created_at->diffInDays(now()) }} hari</p>

                @if($loan->isOverdue())
                    <p class="mt-3"><strong>Keterlambatan:</strong></p>
                    <p class="text-danger"><strong>{{ $loan->getOverdueDays() }} hari</strong></p>
                @endif
            </div>
        </div>

        @if(Auth::user()->isLibrarian())
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-cash-coin"></i> Perhitungan Denda</h5>
                </div>
                <div class="card-body text-small">
                    <p><strong>Tarif Harian:</strong> Rp 5.000</p>
                    <p><strong>Maksimal Denda:</strong> Rp 500.000</p>
                    @if($loan->isOverdue())
                        <p class="mt-3">
                            <strong>Estimasi Denda:</strong><br>
                            <span class="text-danger" style="font-size: 1.2rem;">
                                Rp {{ number_format(min($loan->getOverdueDays() * 5000, 500000), 0, ',', '.') }}
                            </span>
                        </p>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
