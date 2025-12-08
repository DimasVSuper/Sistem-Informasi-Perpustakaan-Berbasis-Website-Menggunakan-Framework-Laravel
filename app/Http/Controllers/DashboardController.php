<?php

namespace App\Http\Controllers;

use App\Models\{
    User,
    Book,
    Loan,
    Category,
};
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $stats = [
                'total_pustakawan' => User::where('role', 'pustakawan')->count(),
                'total_anggota' => User::where('role', 'anggota')->count(),
                'total_buku' => Book::count(),
                'total_kategori' => Category::count(),
            ];
            return view('pages.admin.dashboard', compact('stats'));
        } elseif ($user->role === 'pustakawan') {
            $stats = [
                'total_buku' => Book::count(),
                'total_kategori' => Category::count(),
                'peminjaman_pending' => Loan::where('status', 'pending')->count(),
                'peminjaman_overdue' => Loan::where('status', 'overdue')->count(),
            ];
            return view('pages.pustakawan.dashboard', compact('stats'));
        } elseif ($user->role === 'anggota') {
            $stats = [
                'total_peminjaman' => $user->Loan::loans()->count(),
                'peminjaman_aktif' => $user->Loan::loans()->where('status', '!=', 'returned')->count(),
                'peminjaman_overdue' => $user->Loan::loans()->where('status', 'overdue')->count(),
            ];
            return view('pages.anggota.dashboard', compact('stats'));
        }
    }
}
