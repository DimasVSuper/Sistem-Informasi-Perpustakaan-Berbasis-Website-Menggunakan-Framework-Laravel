<?php

namespace App\Http\Controllers;

use App\Models\Fine;
use Illuminate\Http\Request;

class FineController extends Controller
{
    /**
     * Display the fine configuration.
     */
    public function index()
    {
        $fines = Fine::paginate(10);
        $current_fine = Fine::getCurrent();
        return view('pages.pustakawan.fines.index', compact('fines', 'current_fine'));
    }

    /**
     * Show the form for creating a new fine configuration.
     */
    public function create()
    {
        return view('pages.pustakawan.fines.create');
    }

    /**
     * Store a newly created fine configuration in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'daily_rate' => 'required|numeric|min:0',
            'max_fine' => 'nullable|numeric|min:0',
        ]);

        Fine::create($validated);

        return redirect()->route('pustakawan.fines.index')
            ->with('success', 'Konfigurasi denda berhasil dibuat');
    }

    /**
     * Display the specified fine configuration.
     */
    public function show(Fine $fine)
    {
        $current_fine = Fine::getCurrent();
        return view('pages.pustakawan.fines.show', compact('fine', 'current_fine'));
    }

    /**
     * Show the form for editing the specified fine configuration.
     */
    public function edit(Fine $fine)
    {
        $current_fine = Fine::getCurrent();
        return view('pages.pustakawan.fines.edit', compact('fine', 'current_fine'));
    }

    /**
     * Update the specified fine configuration in storage.
     */
    public function update(Request $request, Fine $fine)
    {
        $validated = $request->validate([
            'daily_rate' => 'required|numeric|min:0',
            'max_fine' => 'nullable|numeric|min:0',
        ]);

        $fine->update($validated);

        return redirect()->route('pustakawan.fines.index')
            ->with('success', 'Konfigurasi denda berhasil diperbarui');
    }

    /**
     * Remove the specified fine configuration from storage.
     */
    public function destroy(Fine $fine)
    {
        $fine->delete();

        return redirect()->route('pustakawan.fines.index')
            ->with('success', 'Konfigurasi denda berhasil dihapus');
    }
}
