<?php
// File: app/Http/Controllers/ReportController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AcMaintenance;
use App\Models\BatteryMaintenance;
use App\Models\CablePanelMaintenance;
use App\Models\Dokumentasi;
use App\Models\GensetMaintenance;
use App\Models\GroundingMaintenance;
use App\Models\Inverter;
use App\Models\PMPermohonan;
use App\Models\PmShelter;
use App\Models\RectifierMaintenance;
use App\Models\ScheduleMaintenance;
use App\Models\TindakLanjut;
use App\Models\UpsMaintenance;
use App\Models\UpsMaintenance1;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');
        $formType = $request->input('form_type', 'all');
        $location = $request->input('location');

        $allData = $this->getAllFormsData($dateFrom, $dateTo, $formType, $location);

        // Pagination manual
        $perPage = 10;
        $currentPage = $request->input('page', 1);
        $total = count($allData);
        $paginatedData = array_slice($allData, ($currentPage - 1) * $perPage, $perPage);

        return view('reports.all-forms', [
            'data' => $paginatedData,
            'total' => $total,
            'perPage' => $perPage,
            'currentPage' => $currentPage,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'formType' => $formType,
            'location' => $location,
        ]);
    }

    public function exportAllPdf(Request $request)
    {
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');
        $formType = $request->input('form_type', 'all');
        $location = $request->input('location');

        $allData = $this->getAllFormsData($dateFrom, $dateTo, $formType, $location);

        $pdf = Pdf::loadView('reports.all-forms-pdf', [
            'data' => $allData,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'formType' => $formType,
            'location' => $location,
        ])->setPaper('a4', 'landscape');

        return $pdf->download('laporan-semua-form-' . now()->format('Y-m-d') . '.pdf');
    }

    private function getAllFormsData($dateFrom = null, $dateTo = null, $formType = 'all', $location = null)
    {
        $allData = [];

        // 1. Battery Maintenance
        if ($formType == 'all' || $formType == 'battery') {
            $batteries = BatteryMaintenance::with('user')
                ->when($dateFrom && !$dateTo, fn($q) => $q->whereDate('maintenance_date', '=', $dateFrom))
                ->when($dateFrom && $dateTo, fn($q) => $q->whereDate('maintenance_date', '>=', $dateFrom))
                ->when($dateTo, fn($q) => $q->whereDate('maintenance_date', '<=', $dateTo))
                ->when($location, fn($q) => $q->where('location', 'like', "%$location%"))
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'type' => 'Maintenance Battery',
                        'icon' => 'battery-charging',
                        'tanggal' => $item->maintenance_date,
                        'lokasi' => $item->location ?? '-',
                        'teknisi' => $item->technician_name ?? '-',
                        'status' => 'Completed',
                        'created_by' => $item->user->name ?? '-',
                        'created_at' => $item->created_at,
                        'route_detail' => route('battery.show', $item->id),
                        'route_pdf' => route('battery.pdf', $item->id),
                    ];
                });
            $allData = array_merge($allData, $batteries->toArray());
        }

        // 2. Rectifier Maintenance
        if ($formType == 'all' || $formType == 'rectifier') {
            $rectifiers = RectifierMaintenance::with('user')
                ->when($dateFrom && !$dateTo, fn($q) => $q->whereDate('date_time', '=', $dateFrom))
                ->when($dateFrom && $dateTo, fn($q) => $q->whereDate('date_time', '>=', $dateFrom))
                ->when($dateTo, fn($q) => $q->whereDate('date_time', '<=', $dateTo))
                ->when($location, fn($q) => $q->where('location', 'like', "%$location%"))
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'type' => 'Maintenance Rectifier',
                        'icon' => 'git-compare-arrows',
                        'tanggal' => $item->date_time,
                        'lokasi' => $item->location ?? '-',
                        'teknisi' => $item->executor_1 ?? '-',
                        'status' => 'Completed',
                        'created_by' => $item->user->name ?? '-',
                        'created_at' => $item->created_at,
                        'route_detail' => route('rectifier.show', $item->id),
                        'route_pdf' => route('rectifier.export-pdf', $item->id),
                    ];
                });
            $allData = array_merge($allData, $rectifiers->toArray());
        }

        // 3. Genset Maintenance
        if ($formType == 'all' || $formType == 'genset') {
            $gensets = GensetMaintenance::with('user')
                ->when($dateFrom && !$dateTo, fn($q) => $q->whereDate('maintenance_date', '=', $dateFrom))
                ->when($dateFrom && $dateTo, fn($q) => $q->whereDate('maintenance_date', '>=', $dateFrom))
                ->when($dateTo, fn($q) => $q->whereDate('maintenance_date', '<=', $dateTo))
                ->when($location, fn($q) => $q->where('location', 'like', "%$location%"))
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'type' => 'Maintenance Genset',
                        'icon' => 'zap',
                        'tanggal' => $item->maintenance_date,
                        'lokasi' => $item->location ?? '-',
                        'teknisi' => $item->technician_1_name ?? '-',
                        'status' => 'Completed',
                        'created_by' => $item->user->name ?? '-',
                        'created_at' => $item->created_at,
                        'route_detail' => route('genset.show', $item->id),
                        'route_pdf' => route('genset.pdf', $item->id),
                    ];
                });
            $allData = array_merge($allData, $gensets->toArray());
        }

        // 4. UPS 1 Phase Maintenance
        if ($formType == 'all' || $formType == 'ups1') {
            $ups1 = UpsMaintenance1::with('user')
                ->when($dateFrom && !$dateTo, fn($q) => $q->whereDate('date_time', '=', $dateFrom))
                ->when($dateFrom && $dateTo, fn($q) => $q->whereDate('date_time', '>=', $dateFrom))
                ->when($dateTo, fn($q) => $q->whereDate('date_time', '<=', $dateTo))
                ->when($location, fn($q) => $q->where('location', 'like', "%$location%"))
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'type' => 'Maintenance 1 Phase UPS',
                        'icon' => 'pc-case',
                        'tanggal' => $item->date_time,
                        'lokasi' => $item->location ?? '-',
                        'teknisi' => $item->executor_1 ?? '-',
                        'status' => $item->overall_status ?? 'Completed',
                        'created_by' => $item->user->name ?? '-',
                        'created_at' => $item->created_at,
                        'route_detail' => route('ups1.show', $item->id),
                        'route_pdf' => route('ups1.print', $item->id),
                    ];
                });
            $allData = array_merge($allData, $ups1->toArray());
        }

        // 5. UPS 3 Phase Maintenance
        if ($formType == 'all' || $formType == 'ups3') {
            $ups3 = UpsMaintenance::with('user')
                ->when($dateFrom && !$dateTo, fn($q) => $q->whereDate('date_time', '=', $dateFrom))
                ->when($dateFrom && $dateTo, fn($q) => $q->whereDate('date_time', '>=', $dateFrom))
                ->when($dateTo, fn($q) => $q->whereDate('date_time', '<=', $dateTo))
                ->when($location, fn($q) => $q->where('location', 'like', "%$location%"))
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'type' => 'Maintenance 3 Phase UPS',
                        'icon' => 'cpu',
                        'tanggal' => $item->date_time,
                        'lokasi' => $item->location ?? '-',
                        'teknisi' => $item->executor_1 ?? '-',
                        'status' => $item->overall_status ?? 'Completed',
                        'created_by' => $item->user->name ?? '-',
                        'created_at' => $item->created_at,
                        'route_detail' => route('ups3.show', $item->id),
                        'route_pdf' => route('ups3.print', $item->id),
                    ];
                });
            $allData = array_merge($allData, $ups3->toArray());
        }

        // 6. AC Maintenance
        if ($formType == 'all' || $formType == 'ac') {
            $acs = AcMaintenance::with('user')
                ->when($dateFrom && !$dateTo, fn($q) => $q->whereDate('date_time', '=', $dateFrom))
                ->when($dateFrom && $dateTo, fn($q) => $q->whereDate('date_time', '>=', $dateFrom))
                ->when($dateTo, fn($q) => $q->whereDate('date_time', '<=', $dateTo))
                ->when($location, fn($q) => $q->where('location', 'like', "%$location%"))
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'type' => 'Maintenance AC',
                        'icon' => 'air-vent',
                        'tanggal' => $item->date_time,
                        'lokasi' => $item->location ?? '-',
                        'teknisi' => $item->executor_1 ?? '-',
                        'status' => 'Completed',
                        'created_by' => $item->user->name ?? '-',
                        'created_at' => $item->created_at,
                        'route_detail' => route('ac.show', $item->id),
                        'route_pdf' => route('ac.print', $item->id),
                    ];
                });
            $allData = array_merge($allData, $acs->toArray());
        }

        // 7. PM Permohonan
        if ($formType == 'all' || $formType == 'permohonan') {
            $permohonan = PMPermohonan::with('user')
                ->when($dateFrom && !$dateTo, fn($q) => $q->whereDate('tanggal', '=', $dateFrom))
                ->when($dateFrom && $dateTo, fn($q) => $q->whereDate('tanggal', '>=', $dateFrom))
                ->when($dateTo, fn($q) => $q->whereDate('tanggal', '<=', $dateTo))
                ->when($location, fn($q) => $q->where('lokasi', 'like', "%$location%"))
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'type' => 'Permohonan Tindak Lanjut PM',
                        'icon' => 'book-text',
                        'tanggal' => $item->tanggal,
                        'lokasi' => $item->lokasi ?? '-',
                        'teknisi' => $item->nama ?? '-',
                        'status' => $item->status ?? 'Pending',
                        'created_by' => $item->user->name ?? '-',
                        'created_at' => $item->created_at,
                        'route_detail' => route('pm-permohonan.show', $item->id),
                        'route_pdf' => route('pm-permohonan.pdf', $item->id),
                    ];
                });
            $allData = array_merge($allData, $permohonan->toArray());
        }

        // 8. Tindak Lanjut
        if ($formType == 'all' || $formType == 'tindaklanjut') {
            $tindakLanjut = TindakLanjut::with('user')
                ->when($dateFrom && !$dateTo, fn($q) => $q->whereDate('tanggal', '=', $dateFrom))
                ->when($dateFrom && $dateTo, fn($q) => $q->whereDate('tanggal', '>=', $dateFrom))
                ->when($dateTo, fn($q) => $q->whereDate('tanggal', '<=', $dateTo))
                ->when($location, fn($q) => $q->where('lokasi', 'like', "%$location%"))
                ->get()
                ->map(function ($item) {
                    $pelaksanaNama = '-';
                    if (is_array($item->pelaksana) && count($item->pelaksana) > 0) {
                        $pelaksanaNama = $item->pelaksana[0]['nama'] ?? '-';
                    }

                    return [
                        'id' => $item->id,
                        'type' => 'Formulir Tindak Lanjut PM',
                        'icon' => 'book-check',
                        'tanggal' => $item->tanggal,
                        'lokasi' => $item->lokasi ?? '-',
                        'teknisi' => $pelaksanaNama,
                        'status' => $item->selesai ? 'Selesai' : 'Proses',
                        'created_by' => $item->user->name ?? '-',
                        'created_at' => $item->created_at,
                        'route_detail' => route('tindak-lanjut.show', $item->id),
                        'route_pdf' => route('tindak-lanjut.pdf', $item->id),
                    ];
                });
            $allData = array_merge($allData, $tindakLanjut->toArray());
        }

        // 9. Dokumentasi
        if ($formType == 'all' || $formType == 'dokumentasi') {
            $dokumentasi = Dokumentasi::with('user')
                ->when($dateFrom && !$dateTo, fn($q) => $q->whereDate('tanggal_dokumentasi', '=', $dateFrom))
                ->when($dateFrom && $dateTo, fn($q) => $q->whereDate('tanggal_dokumentasi', '>=', $dateFrom))
                ->when($dateTo, fn($q) => $q->whereDate('tanggal_dokumentasi', '<=', $dateTo))
                ->when($location, fn($q) => $q->where('lokasi', 'like', "%$location%"))
                ->get()
                ->map(function ($item) {
                    $pelaksanaNama = '-';
                    if (is_array($item->pelaksana) && count($item->pelaksana) > 0) {
                        $pelaksanaNama = $item->pelaksana[0]['nama'] ?? '-';
                    }

                    return [
                        'id' => $item->id,
                        'type' => 'Formulir Dokumentasi & Pendataan',
                        'icon' => 'clipboard-check',
                        'tanggal' => $item->tanggal_dokumentasi,
                        'lokasi' => $item->lokasi ?? '-',
                        'teknisi' => $pelaksanaNama,
                        'status' => 'Completed',
                        'created_by' => $item->user->name ?? '-',
                        'created_at' => $item->created_at,
                        'route_detail' => route('dokumentasi.show', $item->id),
                        'route_pdf' => route('dokumentasi.pdf', $item->id),
                    ];
                });
            $allData = array_merge($allData, $dokumentasi->toArray());
        }

        // 10. Jadwal PM Sentral
        if ($formType == 'all' || $formType == 'jadwal') {
            $jadwal = ScheduleMaintenance::with('user', 'locations')
                ->when($dateFrom && !$dateTo, fn($q) => $q->whereDate('tanggal_pembuatan', '=', $dateFrom))
                ->when($dateFrom && $dateTo, fn($q) => $q->whereDate('tanggal_pembuatan', '>=', $dateFrom))
                ->when($dateTo, fn($q) => $q->whereDate('tanggal_pembuatan', '<=', $dateTo))
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'type' => 'Jadwal PM Sentral',
                        'icon' => 'calendar-check',
                        'tanggal' => $item->tanggal_pembuatan,
                        'lokasi' => $item->locations->pluck('nama')->implode(', ') ?: '-',
                        'teknisi' => $item->dibuat_oleh ?? '-',
                        'status' => 'Scheduled',
                        'created_by' => $item->user->name ?? '-',
                        'created_at' => $item->created_at,
                        'route_detail' => route('schedule.show', $item->id),
                        'route_pdf' => route('schedule.pdf', $item->id),
                    ];
                });
            $allData = array_merge($allData, $jadwal->toArray());
        }

        // 11. PM Inverter
        if ($formType == 'all' || $formType == 'inverter') {
            $inverters = Inverter::with('user')
                ->when($dateFrom && !$dateTo, fn($q) => $q->whereDate('tanggal_dokumentasi', '=', $dateFrom))
                ->when($dateFrom && $dateTo, fn($q) => $q->whereDate('tanggal_dokumentasi', '>=', $dateFrom))
                ->when($dateTo, fn($q) => $q->whereDate('tanggal_dokumentasi', '<=', $dateTo))
                ->when($location, fn($q) => $q->where('lokasi', 'like', "%$location%"))
                ->get()
                ->map(function ($item) {
                    $pelaksanaNama = '-';
                    if (is_array($item->pelaksana) && count($item->pelaksana) > 0) {
                        $pelaksanaNama = $item->pelaksana[0]['nama'] ?? '-';
                    }

                    return [
                        'id' => $item->id,
                        'type' => 'PM Inverter -48VDC-220VAC',
                        'icon' => 'arrow-left-right',
                        'tanggal' => $item->tanggal_dokumentasi,
                        'lokasi' => $item->lokasi ?? '-',
                        'teknisi' => $pelaksanaNama,
                        'status' => 'Completed',
                        'created_by' => $item->user->name ?? '-',
                        'created_at' => $item->created_at,
                        'route_detail' => route('inverter.show', $item->id),
                        'route_pdf' => route('inverter.pdf', $item->id),
                    ];
                });
            $allData = array_merge($allData, $inverters->toArray());
        }

        // 12. PM Shelter
        if ($formType == 'all' || $formType == 'shelter') {
            $shelters = PmShelter::with('user')
                ->when($dateFrom && !$dateTo, fn($q) => $q->whereDate('date', '=', $dateFrom))
                ->when($dateFrom && $dateTo, fn($q) => $q->whereDate('date', '>=', $dateFrom))
                ->when($dateTo, fn($q) => $q->whereDate('date', '<=', $dateTo))
                ->when($location, function ($q) use ($location) {
                    $q->where(function ($query) use ($location) {
                        $query->where('location', 'like', "%$location%")
                            ->orWhereHas('central', function ($q) use ($location) {
                                $q->where('nama', 'like', "%$location%")
                                    ->orWhere('area', 'like', "%$location%")
                                    ->orWhere('id_sentral', 'like', "%$location%");
                            });
                    });
                })
                ->get()
                ->map(function ($item) {
                    $executorNama = '-';
                    if (is_array($item->executors) && count($item->executors) > 0) {
                        $executorNama = $item->executors[0]['name'] ?? '-';
                    }
                    $lokasi = '-';

                    if ($item->central) {
                        $lokasi = $item->central->id_sentral . " - " . $item->central->nama;
                    }


                    return [
                        'id' => $item->id,
                        'type' => 'Preventive Maintenance Ruang Shelter',
                        'icon' => 'house',
                        'tanggal' => $item->date,
                        'lokasi' => $lokasi,
                        'teknisi' => $executorNama,
                        'status' => 'Completed',
                        'created_by' => $item->user->name ?? '-',
                        'created_at' => $item->created_at,
                        'route_detail' => route('pm-shelter.show', $item->id),
                        'route_pdf' => route('pm-shelter.export-pdf', $item->id),
                    ];
                });
            $allData = array_merge($allData, $shelters->toArray());
        }

        // 13. PM Petir & Grounding
        if ($formType == 'all' || $formType == 'grounding') {
            $grounding = GroundingMaintenance::with('user')
                ->when($dateFrom && !$dateTo, fn($q) => $q->whereDate('maintenance_date', '=', $dateFrom))
                ->when($dateFrom && $dateTo, fn($q) => $q->whereDate('maintenance_date', '>=', $dateFrom))
                ->when($dateTo, fn($q) => $q->whereDate('maintenance_date', '<=', $dateTo))
                ->when($location, fn($q) => $q->where('location', 'like', "%$location%"))
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'type' => 'PM Petir dan Grounding',
                        'icon' => 'zap',
                        'tanggal' => $item->maintenance_date,
                        'lokasi' => $item->location ?? '-',
                        'teknisi' => $item->technician_1_name ?? '-',
                        'status' => 'Completed',
                        'created_by' => $item->user->name ?? '-',
                        'created_at' => $item->created_at,
                        'route_detail' => route('grounding.show', $item->id),
                        'route_pdf' => route('grounding.pdf', $item->id),
                    ];
                });
            $allData = array_merge($allData, $grounding->toArray());
        }

        // 14. PM Instalasi Kabel & Panel Distribusi
        if ($formType == 'all' || $formType == 'cable') {
            $cables = CablePanelMaintenance::with('user')
                ->when($dateFrom && !$dateTo, fn($q) => $q->whereDate('maintenance_date', '=', $dateFrom))
                ->when($dateFrom && $dateTo, fn($q) => $q->whereDate('maintenance_date', '>=', $dateFrom))
                ->when($dateTo, fn($q) => $q->whereDate('maintenance_date', '<=', $dateTo))
                ->when($location, fn($q) => $q->where('location', 'like', "%$location%"))
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'type' => 'PM Instalasi Kabel & Panel Distribusi',
                        'icon' => 'cable',
                        'tanggal' => $item->maintenance_date,
                        'lokasi' => $item->location ?? '-',
                        'teknisi' => $item->technician_1_name ?? '-',
                        'status' => 'Completed',
                        'created_by' => $item->user->name ?? '-',
                        'created_at' => $item->created_at,
                        'route_detail' => route('cable-panel.show', $item->id),
                        'route_pdf' => route('cable-panel.pdf', $item->id),
                    ];
                });
            $allData = array_merge($allData, $cables->toArray());
        }

        // Sort berdasarkan tanggal terbaru
        usort($allData, function ($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });

        return $allData;
    }
}
