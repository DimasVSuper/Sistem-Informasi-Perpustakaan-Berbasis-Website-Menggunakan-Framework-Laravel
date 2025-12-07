@extends('layouts.app')

@section('title', 'Detail Konfigurasi Denda')

@section('content')
<div class="page-header">
    <a href="{{ route('pustakawan.fines.index') }}" class="text-muted text-decoration-none">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
    <h1 class="mt-2"><i class="bi bi-info-circle"></i> Detail Konfigurasi Denda</h1>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">Informasi Konfigurasi</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Tarif Harian:</strong></p>
                        <p style="font-size: 1.5rem; color: var(--secondary-color);">
                            Rp {{ number_format($fine->daily_rate, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Denda Maksimal:</strong></p>
                        <p style="font-size: 1.5rem; color: var(--primary-color);">
                            Rp {{ number_format($fine->max_fine, 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Status:</strong></p>
                        <p>
                            @if($fine->id === $current_fine->id ?? null)
                                <span class="badge bg-success" style="font-size: 0.95rem; padding: 0.5rem 1rem;">Aktif</span>
                            @else
                                <span class="badge bg-secondary" style="font-size: 0.95rem; padding: 0.5rem 1rem;">Non-Aktif</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Berlaku Sejak:</strong></p>
                        <p>{{ $fine->created_at->format('d M Y H:i') }}</p>
                    </div>
                </div>

                @if($fine->description)
                    <div class="mb-3">
                        <p><strong>Deskripsi/Catatan:</strong></p>
                        <p class="text-muted">{{ $fine->description }}</p>
                    </div>
                @endif

                <p class="text-muted small">
                    Diperbarui: {{ $fine->updated_at->format('d M Y H:i') }}
                </p>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-calculator"></i> Contoh Perhitungan</h5>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Hari Terlambat</th>
                            <th>Perhitungan</th>
                            <th>Denda</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1 hari</td>
                            <td>1 × Rp {{ number_format($fine->daily_rate, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format(min(1 * $fine->daily_rate, $fine->max_fine), 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>3 hari</td>
                            <td>3 × Rp {{ number_format($fine->daily_rate, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format(min(3 * $fine->daily_rate, $fine->max_fine), 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>7 hari</td>
                            <td>7 × Rp {{ number_format($fine->daily_rate, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format(min(7 * $fine->daily_rate, $fine->max_fine), 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>30 hari</td>
                            <td>30 × Rp {{ number_format($fine->daily_rate, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format(min(30 * $fine->daily_rate, $fine->max_fine), 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>100+ hari</td>
                            <td>Maksimal denda</td>
                            <td><strong>Rp {{ number_format($fine->max_fine, 0, ',', '.') }}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-tools"></i> Aksi</h5>
            </div>
            <div class="card-body d-flex flex-column gap-2">
                <a href="{{ route('pustakawan.fines.edit', $fine) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Edit Konfigurasi
                </a>
                <form action="{{ route('pustakawan.fines.destroy', $fine) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus konfigurasi ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="bi bi-trash"></i> Hapus Konfigurasi
                    </button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-info-circle"></i> Info Sistem</h5>
            </div>
            <div class="card-body small">
                <p><strong>Rumus Perhitungan:</strong></p>
                <code>Denda = MIN(hari_terlambat × tarif_harian, denda_maksimal)</code>

                <p class="mt-3"><strong>Penjelasan:</strong></p>
                <ul class="mb-0">
                    <li>Sistem menghitung otomatis denda pada pengembalian</li>
                    <li>Menggunakan konfigurasi terbaru yang aktif</li>
                    <li>Tidak bisa melebihi denda maksimal</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
