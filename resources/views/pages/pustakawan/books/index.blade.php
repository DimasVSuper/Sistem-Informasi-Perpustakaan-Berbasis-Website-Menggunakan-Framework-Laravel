@extends('layouts.app')

@section('title', 'Manajemen Buku')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1><i class="bi bi-book"></i> Manajemen Buku</h1>
            <p class="text-muted">Kelola koleksi buku perpustakaan</p>
        </div>
        <a href="{{ route('pustakawan.books.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Tambah Buku
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

<!-- Filter -->
<div class="card mb-3">
    <div class="card-body">
        <form method="GET" class="row g-2">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Cari judul atau pengarang..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="category" class="form-select">
                    <option value="">-- Semua Kategori --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search"></i> Cari
                </button>
            </div>
            <div class="col-md-3">
                <a href="{{ route('pustakawan.books.index') }}" class="btn btn-secondary w-100">
                    <i class="bi bi-arrow-clockwise"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Pengarang</th>
                    <th>Kategori</th>
                    <th>ISBN</th>
                    <th class="text-center">Tersedia</th>
                    <th class="text-center" style="width: 150px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($books as $index => $book)
                    <tr>
                        <td>{{ $books->firstItem() + $loop->index }}</td>
                        <td><strong>{{ $book->title }}</strong></td>
                        <td>{{ $book->author }}</td>
                        <td>
                            <span class="badge bg-info">{{ $book->category->name }}</span>
                        </td>
                        <td><code>{{ $book->isbn }}</code></td>
                        <td class="text-center">
                            <span class="badge bg-{{ $book->available_copies > 0 ? 'success' : 'danger' }}">
                                {{ $book->available_copies }}/{{ $book->total_copies }}
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('pustakawan.books.show', $book) }}" class="btn btn-sm btn-info" title="Lihat">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('pustakawan.books.edit', $book) }}" class="btn btn-sm btn-warning" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('pustakawan.books.destroy', $book) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus buku ini?');">
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
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="bi bi-inbox"></i> Belum ada buku
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($books->count() > 0)
        <div style="padding: 1rem;">
            {{ $books->links('pagination::bootstrap-4') }}
        </div>
    @endif
</div>

<!-- Statistics -->
<div class="row mt-4">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title text-muted">Total Buku</h6>
                <h3 class="mb-0" style="color: var(--primary-color);">{{ $stats['total_books'] }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title text-muted">Total Eksemplar</h6>
                <h3 class="mb-0" style="color: var(--secondary-color);">{{ $stats['total_copies'] }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title text-muted">Tersedia</h6>
                <h3 class="mb-0" style="color: #27ae60;">{{ $stats['available_copies'] }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title text-muted">Dipinjam</h6>
                <h3 class="mb-0" style="color: #e74c3c;">{{ $stats['borrowed_copies'] }}</h3>
            </div>
        </div>
    </div>
</div>
@endsection
