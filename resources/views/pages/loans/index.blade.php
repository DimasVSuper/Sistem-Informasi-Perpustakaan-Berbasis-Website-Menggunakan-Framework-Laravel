@extends('layouts.app')

@section('title', 'Kelola Peminjaman')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1><i class="bi bi-box-arrow-right"></i> Peminjaman Buku</h1>
            <p class="text-muted">
                @if(Auth::user()->isLibrarian())
                    Kelola semua peminjaman buku
                @else
                    Kelola peminjaman buku Anda
                @endif
            </p>
        </div>
        @if(Auth::user()->isLibrarian() || Auth::user()->isMember())
            <a href="{{ route(Auth::user()->role . '.loans.create') }}" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Catat Peminjaman
            </a>
        @endif
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
@if(Auth::user()->isLibrarian())
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" class="row g-2">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Cari peminjam atau buku..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">-- Semua Status --</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="overdue" {{ request('status') === 'overdue' ? 'selected' : '' }}>Overdue</option>
                        <option value="returned" {{ request('status') === 'returned' ? 'selected' : '' }}>Returned</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Cari
                    </button>
                </div>
                <div class="col-md-5">
                    <a href="{{ route('pustakawan.loans.index') }}" class="btn btn-secondary w-100">
                        <i class="bi bi-arrow-clockwise"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>
@endif

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    @if(Auth::user()->isLibrarian())
                        <th>Peminjam</th>
                    @endif
                    <th>Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th>Batas Kembali</th>
                    <th>Status</th>
                    <th class="text-center" style="width: 150px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($loans as $index => $loan)
                    <tr>
                        <td>{{ $loans->firstItem() + $loop->index }}</td>
                        @if(Auth::user()->isLibrarian())
                            <td><strong>{{ $loan->user->name }}</strong></td>
                        @endif
                        <td>{{ $loan->book->title }}</td>
                        <td>{{ $loan->created_at->format('d M Y') }}</td>
                        <td>
                            <strong>{{ $loan->due_date->format('d M Y') }}</strong>
                            @if($loan->isOverdue())
                                <br><small class="text-danger">{{ $loan->getOverdueDays() }} hari terlambat</small>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-{{ $loan->status === 'returned' ? 'success' : ($loan->status === 'pending' ? 'warning' : ($loan->status === 'overdue' ? 'danger' : 'info')) }}">
                                {{ ucfirst($loan->status) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route(Auth::user()->role . '.loans.show', $loan) }}" class="btn btn-sm btn-info" title="Lihat">
                                <i class="bi bi-eye"></i>
                            </a>
                            @if($loan->status !== 'returned')
                                <a href="{{ route(Auth::user()->role . '.loans.edit', $loan) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ Auth::user()->isLibrarian() ? '7' : '6' }}" class="text-center text-muted py-4">
                            <i class="bi bi-inbox"></i> Belum ada peminjaman
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($loans->count() > 0)
        <div class="card-footer">
            {{ $loans->links() }}
        </div>
    @endif
</div>

<!-- Statistics -->
<div class="row mt-4">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title text-muted">Total Peminjaman</h6>
                <h3 class="mb-0" style="color: var(--primary-color);">{{ $stats['total'] }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title text-muted">Pending</h6>
                <h3 class="mb-0" style="color: #f39c12;">{{ $stats['pending'] }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title text-muted">Overdue</h6>
                <h3 class="mb-0" style="color: #e74c3c;">{{ $stats['overdue'] }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title text-muted">Returned</h6>
                <h3 class="mb-0" style="color: #27ae60;">{{ $stats['returned'] }}</h3>
            </div>
        </div>
    </div>
</div>
@endsection
