@extends('layouts.app')

@section('title', $category->name)

@section('content')
<div class="page-header">
    <a href="{{ route('pustakawan.categories.index') }}" class="text-muted text-decoration-none">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
    <h1 class="mt-2"><i class="bi bi-tag"></i> {{ $category->name }}</h1>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Detail Kategori</h5>
            </div>
            <div class="card-body">
                <p><strong>Nama:</strong> {{ $category->name }}</p>
                <p><strong>Deskripsi:</strong></p>
                <p class="text-muted">{{ $category->description ?? 'Tidak ada deskripsi' }}</p>
                <p class="text-muted small">Dibuat: {{ $category->created_at->format('d M Y H:i') }}</p>
                <p class="text-muted small">Diperbarui: {{ $category->updated_at->format('d M Y H:i') }}</p>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-book"></i> Buku dalam Kategori Ini ({{ $category->books->count() }})</h5>
            </div>
            @if($category->books->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Judul</th>
                                <th>Pengarang</th>
                                <th>ISBN</th>
                                <th>Tersedia</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($category->books as $book)
                                <tr>
                                    <td><strong>{{ $book->title }}</strong></td>
                                    <td>{{ $book->author }}</td>
                                    <td><code>{{ $book->isbn }}</code></td>
                                    <td>
                                        <span class="badge bg-{{ $book->available_copies > 0 ? 'success' : 'danger' }}">
                                            {{ $book->available_copies }}/{{ $book->total_copies }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="card-body text-center text-muted">
                    <i class="bi bi-inbox"></i> Belum ada buku dalam kategori ini
                </div>
            @endif
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-tools"></i> Aksi</h5>
            </div>
            <div class="card-body d-flex flex-column gap-2">
                <a href="{{ route('pustakawan.categories.edit', $category) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Edit Kategori
                </a>
                <form action="{{ route('pustakawan.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="bi bi-trash"></i> Hapus Kategori
                    </button>
                </form>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-info-circle"></i> Statistik</h5>
            </div>
            <div class="card-body">
                <p><strong>Total Buku:</strong> {{ $category->books->count() }}</p>
                <p><strong>Total Eksemplar:</strong> {{ $category->books->sum('total_copies') }}</p>
                <p><strong>Tersedia:</strong> {{ $category->books->sum('available_copies') }}</p>
                <p><strong>Sedang Dipinjam:</strong> {{ $category->books->sum('total_copies') - $category->books->sum('available_copies') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
