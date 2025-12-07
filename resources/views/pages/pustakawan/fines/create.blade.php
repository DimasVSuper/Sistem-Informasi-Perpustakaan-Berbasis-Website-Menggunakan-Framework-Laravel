@extends('layouts.app')

@section('title', 'Tambah Konfigurasi Denda')

@section('content')
<div class="page-header">
    <a href="{{ route('pustakawan.fines.index') }}" class="text-muted text-decoration-none">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
    <h1 class="mt-2"><i class="bi bi-plus-circle"></i> Tambah Konfigurasi Denda</h1>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Form Tambah Konfigurasi Denda</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('pustakawan.fines.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="daily_rate" class="form-label">Tarif Harian (Rp) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('daily_rate') is-invalid @enderror" id="daily_rate" name="daily_rate" value="{{ old('daily_rate', 5000) }}" min="0" step="100" required>
                        @error('daily_rate')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Biaya denda per hari keterlambatan</small>
                    </div>

                    <div class="mb-3">
                        <label for="max_fine" class="form-label">Denda Maksimal (Rp) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('max_fine') is-invalid @enderror" id="max_fine" name="max_fine" value="{{ old('max_fine', 500000) }}" min="0" step="1000" required>
                        @error('max_fine')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Batas maksimal denda yang dapat dikenakan</small>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi/Catatan</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Misalnya: Kebijakan mulai berlaku, perubahan, dll</small>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Simpan Konfigurasi
                        </button>
                        <a href="{{ route('pustakawan.fines.index') }}" class="btn btn-secondary">
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
                <h5 class="mb-0"><i class="bi bi-info-circle"></i> Panduan</h5>
            </div>
            <div class="card-body small">
                <p><strong>Tips Konfigurasi Denda:</strong></p>
                <ul class="mb-0">
                    <li>Tarif harian adalah biaya per hari keterlambatan</li>
                    <li>Contoh: Rp 5.000/hari × 10 hari = Rp 50.000</li>
                    <li>Jika melebihi maksimal, denda akan dipotong ke maksimal</li>
                    <li>Sistem otomatis menentukan konfigurasi terbaru sebagai aktif</li>
                    <li>Ubah nilai untuk perubahan kebijakan denda</li>
                </ul>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-example"></i> Contoh Standar</h5>
            </div>
            <div class="card-body small">
                <p><strong>Rekomendasi:</strong></p>
                <p>
                    Tarif: Rp 5.000<br>
                    Maksimal: Rp 500.000
                </p>
                <p class="text-muted mb-0">
                    (Ini adalah nilai standar industri perpustakaan)
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
