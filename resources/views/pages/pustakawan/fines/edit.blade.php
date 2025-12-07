@extends('layouts.app')

@section('title', 'Edit Konfigurasi Denda')

@section('content')
<div class="page-header">
    <a href="{{ route('pustakawan.fines.index') }}" class="text-muted text-decoration-none">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
    <h1 class="mt-2"><i class="bi bi-pencil"></i> Edit Konfigurasi Denda</h1>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Form Edit Konfigurasi Denda</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('pustakawan.fines.update', $fine) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="daily_rate" class="form-label">Tarif Harian (Rp) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('daily_rate') is-invalid @enderror" id="daily_rate" name="daily_rate" value="{{ old('daily_rate', $fine->daily_rate) }}" min="0" step="100" required>
                        @error('daily_rate')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Biaya denda per hari keterlambatan</small>
                    </div>

                    <div class="mb-3">
                        <label for="max_fine" class="form-label">Denda Maksimal (Rp) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('max_fine') is-invalid @enderror" id="max_fine" name="max_fine" value="{{ old('max_fine', $fine->max_fine) }}" min="0" step="1000" required>
                        @error('max_fine')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Batas maksimal denda yang dapat dikenakan</small>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi/Catatan</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $fine->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Perbarui Konfigurasi
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
                <h5 class="mb-0"><i class="bi bi-info-circle"></i> Informasi</h5>
            </div>
            <div class="card-body text-small">
                <p>
                    <strong>Status:</strong><br>
                    @if($fine->id === $current_fine->id ?? null)
                        <span class="badge bg-success">Aktif</span>
                    @else
                        <span class="badge bg-secondary">Non-Aktif</span>
                    @endif
                </p>
                <p>
                    <strong>Dibuat:</strong><br>
                    {{ $fine->created_at->format('d M Y H:i') }}
                </p>
                <p>
                    <strong>Diperbarui:</strong><br>
                    {{ $fine->updated_at->format('d M Y H:i') }}
                </p>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-example"></i> Preview</h5>
            </div>
            <div class="card-body small">
                <p><strong>5 hari terlambat:</strong></p>
                <p>5 × Rp <span id="rate-preview">{{ number_format($fine->daily_rate, 0, ',', '.') }}</span> = <span id="result-5" class="text-info">Rp 25.000</span></p>

                <p class="mt-2"><strong>100 hari terlambat:</strong></p>
                <p>100 × Rp <span id="rate-preview2">{{ number_format($fine->daily_rate, 0, ',', '.') }}</span> = Rp <span id="calc-100">{{ number_format(100 * $fine->daily_rate, 0, ',', '.') }}</span><br>
                <span id="result-100" class="text-danger" style="display:{{ 100 * $fine->daily_rate > $fine->max_fine ? 'block' : 'none' }};">
                    Tapi maksimal: Rp {{ number_format($fine->max_fine, 0, ',', '.') }}
                </span></p>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('daily_rate').addEventListener('input', function() {
    const rate = parseInt(this.value) || 0;
    document.getElementById('rate-preview').textContent = new Intl.NumberFormat('id-ID').format(rate);
    document.getElementById('rate-preview2').textContent = new Intl.NumberFormat('id-ID').format(rate);
    document.getElementById('result-5').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(rate * 5);
    document.getElementById('calc-100').textContent = new Intl.NumberFormat('id-ID').format(rate * 100);
});
</script>
@endsection
