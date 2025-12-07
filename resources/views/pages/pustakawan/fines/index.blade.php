@extends('layouts.app')

@section('title', 'Konfigurasi Denda')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1><i class="bi bi-cash-coin"></i> Konfigurasi Denda</h1>
            <p class="text-muted">Kelola konfigurasi denda keterlambatan peminjaman</p>
        </div>
        <a href="{{ route('pustakawan.fines.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Tambah Konfigurasi
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Tarif Harian</th>
                            <th>Denda Maksimal</th>
                            <th>Status</th>
                            <th class="text-center" style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($fines as $index => $fine)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <strong>Rp {{ number_format($fine->daily_rate, 0, ',', '.') }}</strong>
                                    <br><small class="text-muted">/hari keterlambatan</small>
                                </td>
                                <td>
                                    <strong>Rp {{ number_format($fine->max_fine, 0, ',', '.') }}</strong>
                                </td>
                                <td>
                                    @if($fine->id === $current_fine->id ?? null)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Non-Aktif</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('pustakawan.fines.show', $fine) }}" class="btn btn-sm btn-info" title="Lihat">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('pustakawan.fines.edit', $fine) }}" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('pustakawan.fines.destroy', $fine) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus konfigurasi ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox"></i> Belum ada konfigurasi denda
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        @if($current_fine)
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-star"></i> Konfigurasi Aktif</h5>
                </div>
                <div class="card-body">
                    <p class="mb-2">
                        <strong>Tarif Harian:</strong><br>
                        <span style="font-size: 1.3rem; color: var(--secondary-color);">
                            Rp {{ number_format($current_fine->daily_rate, 0, ',', '.') }}
                        </span>
                    </p>
                    <p>
                        <strong>Denda Maksimal:</strong><br>
                        <span style="font-size: 1.3rem; color: var(--primary-color);">
                            Rp {{ number_format($current_fine->max_fine, 0, ',', '.') }}
                        </span>
                    </p>
                    <p class="text-muted small mb-0">
                        Berlaku sejak: {{ $current_fine->created_at->format('d M Y') }}
                    </p>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-example"></i> Contoh Perhitungan</h5>
                </div>
                <div class="card-body small">
                    <p><strong>Jika keterlambatan 5 hari:</strong></p>
                    <p class="mb-2">
                        5 hari × Rp {{ number_format($current_fine->daily_rate, 0, ',', '.') }} = 
                        <span class="text-info">Rp {{ number_format(5 * $current_fine->daily_rate, 0, ',', '.') }}</span>
                    </p>

                    <p><strong>Jika keterlambatan 150 hari:</strong></p>
                    <p>
                        150 hari × Rp {{ number_format($current_fine->daily_rate, 0, ',', '.') }} = 
                        Rp {{ number_format(150 * $current_fine->daily_rate, 0, ',', '.') }}<br>
                        <span class="text-danger">
                            Tapi maksimal hanya Rp {{ number_format($current_fine->max_fine, 0, ',', '.') }}
                        </span>
                    </p>
                </div>
            </div>
        @else
            <div class="alert alert-warning" role="alert">
                <i class="bi bi-exclamation-triangle"></i> Belum ada konfigurasi denda aktif
            </div>
        @endif
    </div>
</div>
@endsection
