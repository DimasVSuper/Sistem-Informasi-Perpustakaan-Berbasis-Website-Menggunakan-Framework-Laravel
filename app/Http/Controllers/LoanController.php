<?php

namespace App\Http\Controllers;

use App\Models\{
    Loan,
    User,  
    Fine,
    Book,
};

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoanController extends Controller
{
    /**
     * Display a listing of loans.
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'anggota') {
            $loans = $user->Loan::loans()->with('book')->paginate(10);
        } else {
            $loans = Loan::with('user', 'book')->paginate(10);
        }
        
        $stats = [
            'total' => Loan::count(),
            'pending' => Loan::where('status', 'pending')->count(),
            'overdue' => Loan::where('status', 'overdue')->count(),
            'returned' => Loan::where('status', 'returned')->count(),
        ];
        
        return view('pages.loans.index', compact('loans', 'stats'));
    }

    /**
     * Show the form for creating a new loan.
     */
    public function create()
    {
        $users = User::where('role', 'anggota')->get();
        $books = Book::where('available_copies', '>', 0)->get();
        $available_books = Book::where('available_copies', '>', 0)->count();
        return view('pages.loans.create', compact('users', 'books', 'available_books'));
    }

    /**
     * Store a newly created loan in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'borrow_date' => 'required|date',
            'due_date' => 'required|date|after:borrow_date',
        ]);

        $book = Book::findOrFail($validated['book_id']);
        
        if ($book->available_copies <= 0) {
            return back()->with('error', 'Buku tidak tersedia');
        }

        $validated['user_id'] = Auth::id();
        $validated['status'] = Auth::user()->role === 'anggota' ? 'pending' : 'approved';

        Loan::create($validated);
        
        if (Auth::user()->role !== 'anggota') {
            $book->decrement('available_copies');
        }

        $role = Auth::user()->role;
        return redirect()->route($role . '.loans.index')
            ->with('success', 'Peminjaman berhasil dibuat');
    }

    /**
     * Display the specified loan.
     */
    public function show(Loan $loan)
    {
        return view('pages.loans.show', compact('loan'));
    }

    /**
     * Show the form for editing the specified loan.
     */
    public function edit(Loan $loan)
    {
        return view('pages.loans.edit', compact('loan'));
    }

    /**
     * Update the specified loan in storage (for return process).
     */
    public function update(Request $request, Loan $loan)
    {
        if ($loan->status === 'returned') {
            return back()->with('error', 'Peminjaman sudah dikembalikan');
        }

        $validated = $request->validate([
            'return_date' => 'required|date|after_or_equal:' . $loan->borrow_date,
        ]);

        // Calculate fine if overdue
        if ($validated['return_date'] > $loan->due_date) {
            $overdue_days = now()->diffInDays($loan->due_date);
            $fine = Fine::getCurrent();
            $loan->fine_amount = (string) $fine->calculateFine($overdue_days);
        }

        $loan->update([
            'return_date' => $validated['return_date'],
            'status' => 'returned',
        ]);

        // Increment available copies
        $loan->book->increment('available_copies');

        $role = Auth::user()->role;
        return redirect()->route($role . '.loans.index')
            ->with('success', 'Peminjaman berhasil dikembalikan');
    }

    /**
     * Remove the specified loan from storage.
     */
    public function destroy(Loan $loan)
    {
        if ($loan->status !== 'pending') {
            return back()->with('error', 'Hanya peminjaman dengan status pending yang bisa dihapus');
        }

        $loan->delete();

        $role = Auth::user()->role;
        return redirect()->route($role . '.loans.index')
            ->with('success', 'Peminjaman berhasil dihapus');
    }
}
