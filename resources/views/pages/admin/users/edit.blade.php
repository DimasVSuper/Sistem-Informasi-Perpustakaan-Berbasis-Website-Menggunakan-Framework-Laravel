@extends('layouts.app')

@section('title', 'Edit Pustakawan')

@section('content')
<div class="page-header">
    <a href="{{ route('admin.users.index') }}" class="text-muted text-decoration-none">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
    <h1 class="mt-2"><i class="bi bi-pencil-square"></i> Edit Pustakawan</h1>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Form Edit Data Pustakawan: {{ $user->name }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Email harus unik</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password" class="form-label">Password Baru</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                <input type="password" class="form-control" 
                                       id="password_confirmation" name="password_confirmation">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Nomor Telepon</label>
                        <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                               id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Alamat</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" 
                                  id="address" name="address" rows="3">{{ old('address', $user->address) }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i>
                        <strong>Role Pustakawan:</strong> Status pengguna sebagai Pustakawan tidak dapat diubah melalui edit.
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
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
                <h5 class="mb-0"><i class="bi bi-info-circle"></i> Informasi Akun</h5>
            </div>
            <div class="card-body small">
                <dl class="row mb-0">
                    <dt class="col-sm-5">ID Pengguna:</dt>
                    <dd class="col-sm-7">{{ $user->id }}</dd>

                    <dt class="col-sm-5">Role:</dt>
                    <dd class="col-sm-7">
                        <span class="badge bg-info">{{ ucfirst($user->role) }}</span>
                    </dd>

                    <dt class="col-sm-5">Dibuat:</dt>
                    <dd class="col-sm-7">{{ $user->created_at->format('d M Y H:i') }}</dd>

                    <dt class="col-sm-5">Diperbarui:</dt>
                    <dd class="col-sm-7">{{ $user->updated_at->format('d M Y H:i') }}</dd>
                </dl>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-shield-check"></i> Panduan Edit</h5>
            </div>
            <div class="card-body small">
                <p><strong>Yang dapat diubah:</strong></p>
                <ul class="mb-3">
                    <li>Nama lengkap</li>
                    <li>Email</li>
                    <li>Password (opsional)</li>
                    <li>Nomor telepon</li>
                    <li>Alamat</li>
                </ul>
                <p><strong class="text-warning">⚠️ Perhatian:</strong></p>
                <ul class="mb-0">
                    <li>Pastikan email baru tidak terdaftar</li>
                    <li>Jika mengubah password, pastikan dikomunikasikan dengan benar</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
