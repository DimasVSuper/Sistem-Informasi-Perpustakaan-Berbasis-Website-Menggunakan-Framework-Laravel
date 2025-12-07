@extends('layouts.app')

@section('title', 'Catat Peminjaman')

@section('content')
<div class="page-header">
    <a href="{{ route(Auth::user()->role . '.loans.index') }}" class="text-muted text-decoration-none">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
    <h1 class="mt-2"><i class="bi bi-plus-circle"></i> Catat Peminjaman Baru</h1>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Form Catat Peminjaman</h5>
            </div>
            <div class="card-body">
                <form action="{{ route(Auth::user()->role . '.loans.store') }}" method="POST">
                    @csrf

                    @if(Auth::user()->isLibrarian())
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Peminjam <span class="text-danger">*</span></label>
                            <select class="form-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
                                <option value="">-- Pilih Peminjam --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="book_id" class="form-label">Buku <span class="text-danger">*</span></label>
                        <select class="form-select @error('book_id') is-invalid @enderror" id="book_id" name="book_id" required>
                            <option value="">-- Pilih Buku --</option>
                            @foreach($books as $book)
                                <option value="{{ $book->id }}" data-available="{{ $book->available_copies }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>
                                    {{ $book->title }} ({{ $book->author }}) - Tersedia: {{ $book->available_copies }}/{{ $book->total_copies }}
                                </option>
                            @endforeach
                        </select>
                        @error('book_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="note" class="form-label">Catatan</label>
                        <textarea class="form-control @error('note') is-invalid @enderror" id="note" name="note" rows="3">{{ old('note') }}</textarea>
                        @error('note')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Catat Peminjaman
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
                <h5 class="mb-0"><i class="bi bi-info-circle"></i> Panduan</h5>
            </div>
            <div class="card-body small">
                <p><strong>Informasi Peminjaman:</strong></p>
                <ul class="mb-0">
                    <li>Durasi peminjaman: 7 hari</li>
                    <li>Maksimal peminjaman: 3 buku</li>
                    <li>Denda keterlambatan: Rp 5.000/hari</li>
                    <li>Maksimal denda: Rp 500.000</li>
                    <li>Sistem akan otomatis membuat status sesuai role Anda</li>
                </ul>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-book"></i> Buku Tersedia</h5>
            </div>
            <div class="card-body">
                <p class="mb-3">Total buku yang tersedia untuk dipinjam:</p>
                <h3 style="color: var(--secondary-color);">{{ $available_books }}</h3>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('book_id').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const available = selectedOption.getAttribute('data-available');
    if (available === '0') {
        alert('Buku ini tidak tersedia untuk dipinjam');
        this.value = '';
    }
});
</script>
@endsection
