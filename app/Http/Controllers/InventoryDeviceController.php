<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InventoryDevice;
use App\Models\Central;
use Barryvdh\DomPDF\Facade\Pdf;

class InventoryDeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inventories = InventoryDevice::with('central')->latest()->paginate(10);
        return view('inventory-device.index', compact('inventories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $centrals = Central::all();
        return view('inventory-device.create', compact('centrals'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'central_id' => 'required|exists:central,id',
            'date' => 'required|date',
            'time' => 'required',
            'device_sentral' => 'nullable|array',
            'supporting_facilities' => 'nullable|array',
            'notes' => 'nullable|string',
            'executor_1' => 'nullable|string',
            'mitra_internal_1' => 'nullable|string',
            'executor_2' => 'nullable|string',
            'mitra_internal_2' => 'nullable|string',
            'executor_3' => 'nullable|string',
            'mitra_internal_3' => 'nullable|string',
            'executor_4' => 'nullable|string',
            'mitra_internal_4' => 'nullable|string',
            'verifikator' => 'nullable|string',
            'verifikator_nik' => 'nullable|string',
            'head_of_sub_department' => 'nullable|string',
            'head_of_sub_department_nik' => 'nullable|string',
            'images.*' => 'nullable|image|max:5120',
        ]);

        // Handle image uploads
        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $key => $file) {
                $path = $file->store('inventory-device-images', 'public');
                $images[$key][] = $path;
            }
        }
        $validated['images'] = $images;

        InventoryDevice::create($validated);

        return redirect()->route('inventory-device.index')
            ->with('success', 'Inventory Device berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $inventory = InventoryDevice::with('central')->findOrFail($id);
        return view('inventory-device.show', compact('inventory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $inventory = InventoryDevice::findOrFail($id);
        $centrals = Central::all();
        return view('inventory-device.edit', compact('inventory', 'centrals'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $inventory = InventoryDevice::findOrFail($id);

        $validated = $request->validate([
            'central_id' => 'required|exists:central,id',
            'date' => 'required|date',
            'time' => 'required',
            'device_sentral' => 'nullable|array',
            'supporting_facilities' => 'nullable|array',
            'notes' => 'nullable|string',
            'executor_1' => 'nullable|string',
            'mitra_internal_1' => 'nullable|string',
            'executor_2' => 'nullable|string',
            'mitra_internal_2' => 'nullable|string',
            'executor_3' => 'nullable|string',
            'mitra_internal_3' => 'nullable|string',
            'executor_4' => 'nullable|string',
            'mitra_internal_4' => 'nullable|string',
            'verifikator' => 'nullable|string',
            'verifikator_nik' => 'nullable|string',
            'head_of_sub_department' => 'nullable|string',
            'head_of_sub_department_nik' => 'nullable|string',
            'images.*' => 'nullable|image|max:5120',
        ]);

        // Handle image uploads
        $images = $inventory->images ?? [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $key => $file) {
                $path = $file->store('inventory-device-images', 'public');
                $images[$key][] = $path;
            }
        }
        $validated['images'] = $images;

        $inventory->update($validated);

        return redirect()->route('inventory-device.index')
            ->with('success', 'Inventory Device berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $inventory = InventoryDevice::findOrFail($id);
        $inventory->delete();

        return redirect()->route('inventory-device.index')
            ->with('success', 'Inventory Device berhasil dihapus.');
    }

    /**
     * Generate PDF
     */
    public function generatePdf(string $id)
    {
        $inventory = InventoryDevice::with('central')->findOrFail($id);

        $pdf = Pdf::loadView('inventory-device.pdf', compact('inventory'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('inventory-device-' . $inventory->id . '.pdf');
    }
}
