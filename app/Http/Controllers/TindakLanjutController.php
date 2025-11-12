<?php

namespace App\Http\Controllers;

use App\Models\TindakLanjut;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class TindakLanjutController extends Controller
{
    public function index(Request $request)
    {
        $query = TindakLanjut::with('user')->where('user_id', auth()->id());

        // Search - mencari di lokasi, ruang, dan pelaksana
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('lokasi', 'like', "%{$search}%")
                    ->orWhere('ruang', 'like', "%{$search}%")
                    ->orWhereRaw("JSON_SEARCH(LOWER(pelaksana), 'one', LOWER(?)) IS NOT NULL", ["%{$search}%"]);
            });
        }

        // Sorting by date (desc = terbaru, asc = terlama)
        $sortDirection = $request->get('sort', 'desc');
        if (in_array($sortDirection, ['asc', 'desc'])) {
            $query->orderBy('tanggal', $sortDirection)->orderBy('jam', $sortDirection);
        } else {
            $query->orderBy('tanggal', 'desc')->orderBy('jam', 'desc');
        }

        $tindakLanjuts = $query->paginate(10)->withQueryString();

        // For AJAX requests (realtime search)
        if ($request->ajax()) {
            return response()->json([
                'html' => view('tindak-lanjut.partials.table', compact('tindakLanjuts'))->render(),
                'count' => $tindakLanjuts->total()
            ]);
        }

        return view('tindak-lanjut.index', compact('tindakLanjuts'));
    }

    public function create()
    {
        return view('tindak-lanjut.create');
    }

    public function store(Request $request)
    {
        // Base validation rules
        $rules = [
            'berdasarkan' => 'required|in:permohonan_tindak_lanjut,pelaksanaan_pm',
            'tanggal' => 'required|date',
            'jam' => 'required',
            'lokasi' => 'required|string|max:255',
            'ruang' => 'required|string|max:255',
            'permasalahan' => 'required|string',
            'tindakan_penyelesaian' => 'required|string',
            'hasil_perbaikan' => 'required|string',
            'status_penyelesaian' => 'required|in:selesai,tidak_selesai',
            'pelaksana' => 'required|array|min:1',
            'pelaksana.*.nama' => 'required|string|max:255',
            'pelaksana.*.department' => 'required|string|max:255',
            'pelaksana.*.sub_department' => 'nullable|string|max:255',
            'mengetahui_nama' => 'required|string|max:255',
            'mengetahui_nik' => 'nullable|string|max:255',
        ];

        // Conditional validation based on status_penyelesaian
        if ($request->status_penyelesaian === 'selesai') {
            $rules['selesai_tanggal'] = 'required|date';
            $rules['selesai_jam'] = 'required';
        } else {
            $rules['tidak_lanjut'] = 'required|string';
        }

        $validated = $request->validate($rules);

        // Set user_id
        $validated['user_id'] = auth()->id();

        // Process pelaksana (can be multiple)
        $pelaksana = [];
        if ($request->has('pelaksana')) {
            foreach ($request->pelaksana as $p) {
                if (!empty($p['nama'])) {
                    $pelaksana[] = [
                        'nama' => $p['nama'],
                        'department' => $p['department'],
                        'sub_department' => $p['sub_department'] ?? null,
                    ];
                }
            }
        }
        $validated['pelaksana'] = $pelaksana;

        // Set department from first pelaksana for filtering
        $firstPelaksana = $pelaksana[0] ?? null;
        $validated['department'] = $firstPelaksana['department'] ?? null;
        $validated['sub_department'] = $firstPelaksana['sub_department'] ?? null;

        // Process mengetahui
        $validated['mengetahui'] = [
            'nama' => $validated['mengetahui_nama'],
            'nik' => $validated['mengetahui_nik'],
        ];

        // Set boolean based on radio button choice
        $validated['permohonan_tindak_lanjut'] = $validated['berdasarkan'] === 'permohonan_tindak_lanjut';
        $validated['pelaksanaan_pm'] = $validated['berdasarkan'] === 'pelaksanaan_pm';

        $validated['selesai'] = $validated['status_penyelesaian'] === 'selesai';
        $validated['selesai_tanggal'] = $validated['status_penyelesaian'] === 'selesai' ? $validated['selesai_tanggal'] : null;
        $validated['selesai_jam'] = $validated['status_penyelesaian'] === 'selesai' ? $validated['selesai_jam'] : null;

        $validated['tidak_selesai'] = $validated['status_penyelesaian'] === 'tidak_selesai';
        $validated['tidak_lanjut'] = $validated['status_penyelesaian'] === 'tidak_selesai' ? ($validated['tidak_lanjut'] ?? null) : null;

        // Remove temporary fields
        unset($validated['berdasarkan']);
        unset($validated['status_penyelesaian']);
        unset($validated['mengetahui_nama']);
        unset($validated['mengetahui_nik']);

        $tindakLanjut = TindakLanjut::create($validated);

        return redirect()->route('tindak-lanjut.show', $tindakLanjut->id)
            ->with('success', 'Tindak Lanjut berhasil ditambahkan');
    }

    public function show(TindakLanjut $tindakLanjut)
    {
        // Authorization check - user hanya bisa lihat data miliknya
        if ($tindakLanjut->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('tindak-lanjut.show', compact('tindakLanjut'));
    }

    public function edit(TindakLanjut $tindakLanjut)
    {
        // Authorization check - user hanya bisa edit data miliknya
        if ($tindakLanjut->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('tindak-lanjut.edit', compact('tindakLanjut'));
    }

    public function update(Request $request, TindakLanjut $tindakLanjut)
    {
        // Authorization check - user hanya bisa update data miliknya
        if ($tindakLanjut->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Base validation rules
        $rules = [
            'berdasarkan' => 'required|in:permohonan_tindak_lanjut,pelaksanaan_pm',
            'tanggal' => 'required|date',
            'jam' => 'required',
            'lokasi' => 'required|string|max:255',
            'ruang' => 'required|string|max:255',
            'permasalahan' => 'required|string',
            'tindakan_penyelesaian' => 'required|string',
            'hasil_perbaikan' => 'required|string',
            'status_penyelesaian' => 'required|in:selesai,tidak_selesai',
            'pelaksana' => 'required|array|min:1',
            'pelaksana.*.nama' => 'required|string|max:255',
            'pelaksana.*.department' => 'required|string|max:255',
            'pelaksana.*.sub_department' => 'nullable|string|max:255',
            'mengetahui_nama' => 'required|string|max:255',
            'mengetahui_nik' => 'nullable|string|max:255',
        ];

        // Conditional validation
        if ($request->status_penyelesaian === 'selesai') {
            $rules['selesai_tanggal'] = 'required|date';
            $rules['selesai_jam'] = 'required';
        } else {
            $rules['tidak_lanjut'] = 'required|string';
        }

        $validated = $request->validate($rules);

        // Process pelaksana
        $pelaksana = [];
        if ($request->has('pelaksana')) {
            foreach ($request->pelaksana as $p) {
                if (!empty($p['nama'])) {
                    $pelaksana[] = [
                        'nama' => $p['nama'],
                        'department' => $p['department'],
                        'sub_department' => $p['sub_department'] ?? null,
                    ];
                }
            }
        }
        $validated['pelaksana'] = $pelaksana;

        // Set department from first pelaksana
        $firstPelaksana = $pelaksana[0] ?? null;
        $validated['department'] = $firstPelaksana['department'] ?? null;
        $validated['sub_department'] = $firstPelaksana['sub_department'] ?? null;

        // Process mengetahui
        $validated['mengetahui'] = [
            'nama' => $validated['mengetahui_nama'],
            'nik' => $validated['mengetahui_nik'],
        ];

        // Set boolean based on radio button choice
        $validated['permohonan_tindak_lanjut'] = $validated['berdasarkan'] === 'permohonan_tindak_lanjut';
        $validated['pelaksanaan_pm'] = $validated['berdasarkan'] === 'pelaksanaan_pm';

        $validated['selesai'] = $validated['status_penyelesaian'] === 'selesai';
        $validated['selesai_tanggal'] = $validated['status_penyelesaian'] === 'selesai' ? $validated['selesai_tanggal'] : null;
        $validated['selesai_jam'] = $validated['status_penyelesaian'] === 'selesai' ? $validated['selesai_jam'] : null;

        $validated['tidak_selesai'] = $validated['status_penyelesaian'] === 'tidak_selesai';
        $validated['tidak_lanjut'] = $validated['status_penyelesaian'] === 'tidak_selesai' ? ($validated['tidak_lanjut'] ?? null) : null;

        // Remove temporary fields
        unset($validated['berdasarkan']);
        unset($validated['status_penyelesaian']);
        unset($validated['mengetahui_nama']);
        unset($validated['mengetahui_nik']);

        $tindakLanjut->update($validated);

        return redirect()->route('tindak-lanjut.show', $tindakLanjut->id)
            ->with('success', 'Tindak Lanjut berhasil diupdate');
    }

    public function destroy(TindakLanjut $tindakLanjut)
    {
        // Authorization check - user hanya bisa delete data miliknya
        if ($tindakLanjut->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $tindakLanjut->delete();

        return redirect()->route('tindak-lanjut.index')
            ->with('success', 'Tindak Lanjut berhasil dihapus');
    }

    public function generatePdf(TindakLanjut $tindakLanjut)
    {

        $pdf = Pdf::loadView('tindak-lanjut.pdf', compact('tindakLanjut'))
            ->setPaper('a4', 'portrait');

        $fileName = 'Tindak-Lanjut-FM-LAP-D2-SOP-003-005-' . date('d-m-Y', strtotime($tindakLanjut->tanggal)) . '.pdf';

        return $pdf->stream($fileName);
    }
}