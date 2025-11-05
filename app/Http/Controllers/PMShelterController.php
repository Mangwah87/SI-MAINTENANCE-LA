<?php

namespace App\Http\Controllers;

use App\Models\PmShelter;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PmShelterController extends Controller
{
    public function index(Request $request)
    {
        $query = PmShelter::with('user')->where('user_id', auth()->id());

        // Search - mencari di location dan executors
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('location', 'like', "%{$search}%")
                    ->orWhereRaw("JSON_SEARCH(LOWER(executors), 'one', LOWER(?)) IS NOT NULL", ["%{$search}%"]);
            });
        }

        // Sorting by date (desc = terbaru, asc = terlama)
        $sortDirection = $request->get('sort', 'desc');
        if (in_array($sortDirection, ['asc', 'desc'])) {
            $query->orderBy('date', $sortDirection)->orderBy('time', $sortDirection);
        } else {
            $query->orderBy('date', 'desc')->orderBy('time', 'desc');
        }

        $pmShelters = $query->paginate(10)->withQueryString();

        // For AJAX requests (realtime search)
        if ($request->ajax()) {
            return response()->json([
                'html' => view('pm-shelter.partials.table', compact('pmShelters'))->render(),
                'count' => $pmShelters->total()
            ]);
        }

        return view('pm-shelter.index', compact('pmShelters'));
    }

    public function create()
    {
        return view('pm-shelter.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'location' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required',
            'brand_type' => 'nullable|string|max:255',
            'reg_number' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|max:255',
            'kondisi_ruangan_result' => 'nullable|string',
            'kondisi_ruangan_status' => 'required|in:OK,NOK',
            'kondisi_kunci_result' => 'nullable|string',
            'kondisi_kunci_status' => 'required|in:OK,NOK',
            'layout_tata_ruang_result' => 'nullable|string',
            'layout_tata_ruang_status' => 'required|in:OK,NOK',
            'kontrol_keamanan_result' => 'nullable|string',
            'kontrol_keamanan_status' => 'required|in:OK,NOK',
            'aksesibilitas_result' => 'nullable|string',
            'aksesibilitas_status' => 'required|in:OK,NOK',
            'aspek_teknis_result' => 'nullable|string',
            'aspek_teknis_status' => 'required|in:OK,NOK',
            'kondisi_ruangan_photos.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'kondisi_kunci_photos.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'layout_tata_ruang_photos.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'kontrol_keamanan_photos.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'aksesibilitas_photos.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'aspek_teknis_photos.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'kondisi_ruangan_photo_metadata.*' => 'nullable|string',
            'kondisi_kunci_photo_metadata.*' => 'nullable|string',
            'layout_tata_ruang_photo_metadata.*' => 'nullable|string',
            'kontrol_keamanan_photo_metadata.*' => 'nullable|string',
            'aksesibilitas_photo_metadata.*' => 'nullable|string',
            'aspek_teknis_photo_metadata.*' => 'nullable|string',
            'notes' => 'nullable|string',
            'executors.*.name' => 'required|string|max:255',
            'executors.*.department' => 'nullable|string|max:255',
            'executors.*.sub_department' => 'nullable|string|max:255',
            'approvers.*.name' => 'required|string|max:255',
            'approvers.*.nik' => 'nullable|string|max:255',
        ]);

        $validated['user_id'] = auth()->id();

        $executors = [];
        if ($request->has('executors')) {
            foreach ($request->executors as $executor) {
                if (!empty($executor['name'])) {
                    $executors[] = $executor;
                }
            }
        }
        $validated['executors'] = $executors;

        $approvers = [];
        if ($request->has('approvers')) {
            foreach ($request->approvers as $approver) {
                if (!empty($approver['name'])) {
                    $approvers[] = $approver;
                }
            }
        }
        $validated['approvers'] = $approvers;

        $validated['photos'] = $this->processAllPhotos($request);

        $pmShelter = PmShelter::create($validated);

        return redirect()->route('pm-shelter.show', $pmShelter->id)
            ->with('success', 'Data PM Shelter berhasil ditambahkan');
    }

    public function show(PmShelter $pmShelter)
    {
        return view('pm-shelter.show', compact('pmShelter'));
    }

    public function edit(PmShelter $pmShelter)
    {
        return view('pm-shelter.edit', compact('pmShelter'));
    }

    public function update(Request $request, PmShelter $pmShelter)
    {
        $validated = $request->validate([
            'location' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required',
            'brand_type' => 'nullable|string|max:255',
            'reg_number' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|max:255',
            'kondisi_ruangan_result' => 'nullable|string',
            'kondisi_ruangan_status' => 'required|in:OK,NOK',
            'kondisi_kunci_result' => 'nullable|string',
            'kondisi_kunci_status' => 'required|in:OK,NOK',
            'layout_tata_ruang_result' => 'nullable|string',
            'layout_tata_ruang_status' => 'required|in:OK,NOK',
            'kontrol_keamanan_result' => 'nullable|string',
            'kontrol_keamanan_status' => 'required|in:OK,NOK',
            'aksesibilitas_result' => 'nullable|string',
            'aksesibilitas_status' => 'required|in:OK,NOK',
            'aspek_teknis_result' => 'nullable|string',
            'aspek_teknis_status' => 'required|in:OK,NOK',
            'kondisi_ruangan_photos.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'kondisi_kunci_photos.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'layout_tata_ruang_photos.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'kontrol_keamanan_photos.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'aksesibilitas_photos.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'aspek_teknis_photos.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'kondisi_ruangan_photo_metadata.*' => 'nullable|string',
            'kondisi_kunci_photo_metadata.*' => 'nullable|string',
            'layout_tata_ruang_photo_metadata.*' => 'nullable|string',
            'kontrol_keamanan_photo_metadata.*' => 'nullable|string',
            'aksesibilitas_photo_metadata.*' => 'nullable|string',
            'aspek_teknis_photo_metadata.*' => 'nullable|string',
            'removed_kondisi_ruangan_photos.*' => 'nullable|string',
            'removed_kondisi_kunci_photos.*' => 'nullable|string',
            'removed_layout_tata_ruang_photos.*' => 'nullable|string',
            'removed_kontrol_keamanan_photos.*' => 'nullable|string',
            'removed_aksesibilitas_photos.*' => 'nullable|string',
            'removed_aspek_teknis_photos.*' => 'nullable|string',
            'notes' => 'nullable|string',
            'executors.*.name' => 'required|string|max:255',
            'executors.*.department' => 'nullable|string|max:255',
            'executors.*.sub_department' => 'nullable|string|max:255',
            'approvers.*.name' => 'required|string|max:255',
            'approvers.*.nik' => 'nullable|string|max:255',
        ]);

        $executors = [];
        if ($request->has('executors')) {
            foreach ($request->executors as $executor) {
                if (!empty($executor['name'])) {
                    $executors[] = $executor;
                }
            }
        }
        $validated['executors'] = $executors;

        $approvers = [];
        if ($request->has('approvers')) {
            foreach ($request->approvers as $approver) {
                if (!empty($approver['name'])) {
                    $approvers[] = $approver;
                }
            }
        }
        $validated['approvers'] = $approvers;

        $existingPhotos = $pmShelter->photos ?? [];
        $removedPaths = $this->getRemovedPhotoPaths($request);

        foreach ($removedPaths as $path) {
            Storage::disk('public')->delete($path);
        }

        $existingPhotos = array_filter($existingPhotos, function ($photo) use ($removedPaths) {
            return !in_array($photo['path'], $removedPaths);
        });

        $newPhotos = $this->processAllPhotos($request);
        $validated['photos'] = array_values(array_merge($existingPhotos, $newPhotos));

        $pmShelter->update($validated);

        return redirect()->route('pm-shelter.show', $pmShelter->id)
            ->with('success', 'Data PM Shelter berhasil diperbarui');
    }

    public function destroy(PmShelter $pmShelter)
    {
        if ($pmShelter->photos) {
            foreach ($pmShelter->photos as $photo) {
                Storage::disk('public')->delete($photo['path']);
            }
        }

        $pmShelter->delete();

        return redirect()->route('pm-shelter.index')
            ->with('success', 'Data PM Shelter berhasil dihapus');
    }

    public function exportPdf(PmShelter $pmShelter)
    {
        $pdf = Pdf::loadView('pm-shelter.pdf', compact('pmShelter'))
            ->setPaper('a4', 'portrait');
        $pdf->getDomPDF()->set_option('enable_php', true);
        $fileName = 'PM Shelter-FM-LAP-D2-SOP-003-009-' . $pmShelter->date->format('d-m-Y') . '.pdf';

        return $pdf->stream($fileName);
    }

    private function processAllPhotos(Request $request): array
    {
        $allPhotos = [];

        $photoFields = [
            'kondisi_ruangan_photos',
            'kondisi_kunci_photos',
            'layout_tata_ruang_photos',
            'kontrol_keamanan_photos',
            'aksesibilitas_photos',
            'aspek_teknis_photos'
        ];

        foreach ($photoFields as $fieldName) {
            $metadataKey = str_replace('_photos', '_photo_metadata', $fieldName);

            if ($request->hasFile($fieldName)) {
                $files = $request->file($fieldName);
                $metadataArray = $request->input($metadataKey, []);

                foreach ($files as $index => $file) {
                    $path = $file->store('pm-shelter-photos', 'public');

                    $metadata = [];
                    if (isset($metadataArray[$index])) {
                        $metadata = json_decode($metadataArray[$index], true) ?? [];
                    }

                    $allPhotos[] = [
                        'field' => $fieldName,
                        'path' => $path,
                        'latitude' => $metadata['latitude'] ?? null,
                        'longitude' => $metadata['longitude'] ?? null,
                        'location_name' => $metadata['location_name'] ?? null,
                        'taken_at' => $metadata['taken_at'] ?? now()->toISOString(),
                    ];
                }
            }
        }

        return $allPhotos;
    }

    private function getRemovedPhotoPaths(Request $request): array
    {
        $removedPaths = [];

        $removedFields = [
            'removed_kondisi_ruangan_photos',
            'removed_kondisi_kunci_photos',
            'removed_layout_tata_ruang_photos',
            'removed_kontrol_keamanan_photos',
            'removed_aksesibilitas_photos',
            'removed_aspek_teknis_photos'
        ];

        foreach ($removedFields as $field) {
            if ($request->has($field)) {
                $removedPaths = array_merge($removedPaths, $request->input($field, []));
            }
        }

        return $removedPaths;
    }
}