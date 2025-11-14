<?php

namespace App\Http\Controllers;

use App\Models\Central;
use Illuminate\Http\Request;

class CentralController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $centrals = Central::orderBy('area')->orderBy('id_sentral')->paginate(15);
        return view('central.index', compact('centrals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Hanya superadmin yang bisa akses (sudah dihandle di middleware)
        return view('central.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_sentral' => 'required|string|unique:central,id_sentral|max:255',
            'nama' => 'required|string|max:255',
            'area' => 'required|string|max:255',
        ], [
            'id_sentral.unique' => 'ID Sentral sudah digunakan.',
            'id_sentral.required' => 'ID Sentral wajib diisi.',
            'nama.required' => 'Nama Sentral wajib diisi.',
            'area.required' => 'Area wajib diisi.',
        ]);

        Central::create($validated);

        return redirect()->route('central.index')
            ->with('success', 'Data sentral berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Central $central)
    {
        return view('central.show', compact('central'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Central $central)
    {
        // Hanya superadmin yang bisa akses
        return view('central.edit', compact('central'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Central $central)
    {
        $validated = $request->validate([
            'id_sentral' => 'required|string|max:255|unique:central,id_sentral,' . $central->id,
            'nama' => 'required|string|max:255',
            'area' => 'required|string|max:255',
        ], [
            'id_sentral.unique' => 'ID Sentral sudah digunakan.',
            'id_sentral.required' => 'ID Sentral wajib diisi.',
            'nama.required' => 'Nama Sentral wajib diisi.',
            'area.required' => 'Area wajib diisi.',
        ]);

        $central->update($validated);

        return redirect()->route('central.index')
            ->with('success', 'Data sentral berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Central $central)
    {
        $central->delete();

        return redirect()->route('central.index')
            ->with('success', 'Data sentral berhasil dihapus!');
    }
}