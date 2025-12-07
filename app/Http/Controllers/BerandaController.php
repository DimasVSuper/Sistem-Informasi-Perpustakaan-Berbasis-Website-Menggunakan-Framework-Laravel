<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Support\Facades\Auth;

class BerandaController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $role = Auth::user()->role;
            if ($role === 'admin') {
                return redirect('/admin/dashboard');
            } elseif ($role === 'pustakawan') {
                return redirect('/pustakawan/dashboard');
            } elseif ($role === 'anggota') {
                return redirect('/anggota/dashboard');
            }
        }

        $featured_books = Book::limit(6)->get();
        return view('pages.beranda', compact('featured_books'));
    }
}
