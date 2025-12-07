<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of books.
     */
    public function index()
    {
        $books = Book::with('category')->paginate(10);
        $categories = Category::all();
        $stats = [
            'total_books' => Book::count(),
            'total_copies' => Book::sum('total_copies'),
            'available_copies' => Book::sum('available_copies'),
            'borrowed_copies' => Book::sum('total_copies') - Book::sum('available_copies'),
        ];
        return view('pages.pustakawan.books.index', compact('books', 'categories', 'stats'));
    }

    /**
     * Show the form for creating a new book.
     */
    public function create()
    {
        $categories = Category::all();
        return view('pages.pustakawan.books.create', compact('categories'));
    }

    /**
     * Store a newly created book in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn|max:20',
            'publisher' => 'nullable|string|max:255',
            'published_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'total_copies' => 'required|integer|min:1',
            'description' => 'nullable|string|max:1000',
        ]);

        $validated['available_copies'] = $validated['total_copies'];
        Book::create($validated);

        return redirect()->route('pustakawan.books.index')
            ->with('success', 'Buku berhasil ditambahkan');
    }

    /**
     * Display the specified book.
     */
    public function show(Book $book)
    {
        $book->load('loans.user');
        return view('pages.pustakawan.books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified book.
     */
    public function edit(Book $book)
    {
        $categories = Category::all();
        return view('pages.pustakawan.books.edit', compact('book', 'categories'));
    }

    /**
     * Update the specified book in storage.
     */
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn,' . $book->id . '|max:20',
            'publisher' => 'nullable|string|max:255',
            'published_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'total_copies' => 'required|integer|min:1',
            'description' => 'nullable|string|max:1000',
        ]);

        $book->update($validated);

        return redirect()->route('pustakawan.books.index')
            ->with('success', 'Buku berhasil diperbarui');
    }

    /**
     * Remove the specified book from storage.
     */
    public function destroy(Book $book)
    {
        if ($book->loans()->where('status', '!=', 'returned')->exists()) {
            return redirect()->route('pustakawan.books.index')
                ->with('error', 'Buku tidak bisa dihapus karena masih dipinjam');
        }

        $book->delete();

        return redirect()->route('pustakawan.books.index')
            ->with('success', 'Buku berhasil dihapus');
    }
}
