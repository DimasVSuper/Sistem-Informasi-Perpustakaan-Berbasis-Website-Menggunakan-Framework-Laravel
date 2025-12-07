<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda - Sistem Informasi Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }

        /* Navbar */
        .navbar {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 80px 0;
            text-align: center;
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }

        /* Book Cards */
        .book-card {
            transition: transform 0.3s, box-shadow 0.3s;
            border: none;
            border-radius: 8px;
            overflow: hidden;
        }

        .book-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .book-card-img {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 250px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
        }

        .book-card-title {
            font-weight: bold;
            color: var(--primary-color);
            margin-top: 15px;
        }

        .book-card-author {
            color: #7f8c8d;
            font-size: 0.95rem;
        }

        .book-card-category {
            display: inline-block;
            background: var(--secondary-color);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            margin-top: 10px;
        }

        /* CTA Buttons */
        .btn-login {
            background: var(--primary-color);
            border: none;
            color: white;
            padding: 12px 30px;
            font-weight: bold;
        }

        .btn-login:hover {
            background: var(--secondary-color);
            color: white;
        }

        .btn-register {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            padding: 10px 28px;
            font-weight: bold;
        }

        .btn-register:hover {
            background: var(--primary-color);
            color: white;
        }

        /* Features Section */
        .feature-box {
            text-align: center;
            padding: 30px;
            margin-bottom: 20px;
        }

        .feature-icon {
            font-size: 2.5rem;
            color: var(--secondary-color);
            margin-bottom: 15px;
        }

        .feature-title {
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .feature-desc {
            color: #7f8c8d;
            font-size: 0.95rem;
        }

        /* Footer */
        footer {
            background: var(--primary-color);
            color: white;
            padding: 30px 0;
            margin-top: 60px;
        }

        footer p {
            margin: 0;
        }

        /* Section Title */
        .section-title {
            font-size: 2rem;
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 40px;
            text-align: center;
            position: relative;
            padding-bottom: 15px;
        }

        .section-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: var(--secondary-color);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-book"></i> Perpustakaan
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right"></i> Masuk
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">
                            <i class="bi bi-person-plus"></i> Daftar
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1><i class="bi bi-book-half"></i> Selamat Datang di Perpustakaan</h1>
            <p>Sistem Informasi Perpustakaan Berbasis Website</p>
            <div>
                <a href="{{ route('login') }}" class="btn btn-login me-3">Masuk Akun</a>
                <a href="{{ route('register') }}" class="btn btn-register">Daftar Baru</a>
            </div>
        </div>
    </section>

    <!-- Featured Books -->
    <section class="container my-5">
        <h2 class="section-title">Buku Unggulan</h2>
        <div class="row">
            @foreach($featured_books as $book)
            <div class="col-md-4 mb-4">
                <div class="card book-card">
                    <div class="book-card-img">
                        <i class="bi bi-book"></i>
                    </div>
                    <div class="card-body">
                        <h5 class="book-card-title">{{ $book->title }}</h5>
                        <p class="book-card-author"><strong>{{ $book->author }}</strong></p>
                        <span class="book-card-category">{{ $book->category->name }}</span>
                        <p class="text-muted mt-3 mb-2">{{ Str::limit($book->description, 100) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-success">
                                <i class="bi bi-check-circle"></i> {{ $book->available_copies }} tersedia
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Features -->
    <section class="bg-light py-5">
        <div class="container">
            <h2 class="section-title">Fitur Perpustakaan</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="feature-box">
                        <div class="feature-icon">
                            <i class="bi bi-search"></i>
                        </div>
                        <h5 class="feature-title">Cari Buku</h5>
                        <p class="feature-desc">Cari koleksi buku terlengkap dengan kategori yang beragam</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-box">
                        <div class="feature-icon">
                            <i class="bi bi-bookmark-check"></i>
                        </div>
                        <h5 class="feature-title">Peminjaman Mudah</h5>
                        <p class="feature-desc">Proses peminjaman yang cepat dan transparan</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-box">
                        <div class="feature-icon">
                            <i class="bi bi-calendar-event"></i>
                        </div>
                        <h5 class="feature-title">Kelola Jadwal</h5>
                        <p class="feature-desc">Pantau tanggal pengembalian dan perpanjangan peminjaman</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Info Section -->
    <section class="container my-5">
        <div class="row">
            <div class="col-md-8">
                <h3 style="color: var(--primary-color); font-weight: bold;">Tentang Sistem Ini</h3>
                <p>Sistem Informasi Perpustakaan Berbasis Website adalah platform modern untuk mengelola koleksi buku dan proses peminjaman. Dengan antarmuka yang user-friendly, anggota dapat dengan mudah mencari, meminjam, dan mengelola peminjaman buku mereka secara online.</p>
                <p>Fitur-fitur utama meliputi pencarian buku, peminjaman online, pelacakan status peminjaman, perhitungan denda otomatis, dan manajemen kategori buku yang efisien.</p>
            </div>
            <div class="col-md-4">
                <div class="card" style="border: none; background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%); color: white;">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-info-circle"></i> Info Penting</h5>
                        <ul class="mb-0" style="font-size: 0.95rem;">
                            <li>Durasi peminjaman: 7 hari</li>
                            <li>Max buku: 3 per waktu</li>
                            <li>Denda: Rp 5.000/hari</li>
                            <li>Max denda: Rp 500.000</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container py-4">
            <div class="row">
                <div class="col-md-4">
                    <h6><i class="bi bi-book"></i> Perpustakaan</h6>
                    <p class="text-muted">Sistem Informasi Perpustakaan Berbasis Website</p>
                </div>
                <div class="col-md-4">
                    <h6>Layanan</h6>
                    <ul class="list-unstyled text-muted" style="font-size: 0.95rem;">
                        <li><a href="{{ route('login') }}" class="text-muted text-decoration-none">Masuk</a></li>
                        <li><a href="{{ route('register') }}" class="text-muted text-decoration-none">Daftar</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6>Kontak</h6>
                    <p class="text-muted" style="font-size: 0.95rem;">
                        Email: info@perpustakaan.com<br>
                        Telp: (021) 123-4567
                    </p>
                </div>
            </div>
            <hr class="bg-white">
            <p class="text-center text-muted mb-0">&copy; 2025 Sistem Informasi Perpustakaan. Semua hak dilindungi.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
