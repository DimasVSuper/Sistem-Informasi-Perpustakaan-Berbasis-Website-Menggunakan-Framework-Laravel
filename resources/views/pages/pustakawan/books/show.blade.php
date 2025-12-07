@extends('layouts.app')

@section('title', $book->title)

@section('content')
<div class="page-header">
    <a href="{{ route('pustakawan.books.index') }}" class="text-muted text-decoration-none">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
    <h1 class="mt-2"><i class="bi bi-book"></i> {{ $book->title }}</h1>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">Detail Buku</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Judul:</strong></p>
                        <p>{{ $book->title }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Pengarang:</strong></p>
                        <p>{{ $book->author }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>ISBN:</strong></p>
                        <p><code>{{ $book->isbn }}</code></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Kategori:</strong></p>
                        <p><span class="badge bg-info">{{ $book->category->name }}</span></p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Penerbit:</strong></p>
                        <p>{{ $book->publisher ?? 'Tidak ada data' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Tahun Terbit:</strong></p>
                        <p>{{ $book->publication_year ?? 'Tidak ada data' }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <p><strong>Total Eksemplar:</strong></p>
                        <p class="fs-5 text-primary">{{ $book->total_copies }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Tersedia:</strong></p>
                        <p class="fs-5 text-success">{{ $book->available_copies }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Sedang Dipinjam:</strong></p>
                        <p class="fs-5 text-danger">{{ $book->total_copies - $book->available_copies }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Harga:</strong></p>
                        <p>{{ $book->price ? 'Rp ' . number_format($book->price, 0, ',', '.') : 'Tidak ada data' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Status Ketersediaan:</strong></p>
                        <p>
                            <span class="badge bg-{{ $book->available_copies > 0 ? 'success' : 'danger' }}">
                                {{ $book->available_copies > 0 ? 'Tersedia' : 'Habis' }}
                            </span>
                        </p>
                    </div>
                </div>

                @if($book->description)
                    <div class="mb-3">
                        <p><strong>Deskripsi:</strong></p>
                        <p class="text-muted">{{ $book->description }}</p>
                    </div>
                @endif

                <p class="text-muted small">
                    Dibuat: {{ $book->created_at->format('d M Y H:i') }}<br>
                    Diperbarui: {{ $book->updated_at->format('d M Y H:i') }}
                </p>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-hourglass"></i> Riwayat Peminjaman Terbaru</h5>
            </div>
            @if($book->loans->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Peminjam</th>
                                <th>Tanggal Pinjam</th>
                                <th>Batas Kembali</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($book->loans->sortByDesc('created_at')->take(5) as $loan)
                                <tr>
                                    <td>{{ $loan->user->name }}</td>
                                    <td>{{ $loan->created_at->format('d M Y') }}</td>
                                    <td>{{ $loan->due_date->format('d M Y') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $loan->status === 'returned' ? 'success' : ($loan->status === 'pending' ? 'warning' : ($loan->status === 'overdue' ? 'danger' : 'info')) }}">
                                            {{ ucfirst($loan->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="card-body text-center text-muted">
                    <i class="bi bi-inbox"></i> Belum ada riwayat peminjaman
                </div>
            @endif
        </div>
    </div>

    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-tools"></i> Aksi</h5>
            </div>
            <div class="card-body d-flex flex-column gap-2">
                <a href="{{ route('pustakawan.books.edit', $book) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Edit Buku
                </a>
                <form action="{{ route('pustakawan.books.destroy', $book) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus buku ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="bi bi-trash"></i> Hapus Buku
                    </button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-graph-up"></i> Statistik</h5>
            </div>
            <div class="card-body">
                <p>
                    <strong>Total Peminjaman:</strong><br>
                    <span class="badge bg-primary">{{ $book->loans->count() }}</span>
                </p>
                <p>
                    <strong>Peminjaman Aktif:</strong><br>
                    <span class="badge bg-warning">{{ $book->loans->whereIn('status', ['pending', 'approved'])->count() }}</span>
                </p>
                <p>
                    <strong>Peminjaman Overdue:</strong><br>
                    <span class="badge bg-danger">{{ $book->loans->where('status', 'overdue')->count() }}</span>
                </p>
                <p class="mb-0">
                    <strong>Peminjaman Selesai:</strong><br>
                    <span class="badge bg-success">{{ $book->loans->where('status', 'returned')->count() }}</span>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
