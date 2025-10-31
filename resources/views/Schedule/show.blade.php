<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            {{-- Mengambil Bulan dan Tahun dari jadwal --}}
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Jadwal PM: {{ \Carbon\Carbon::parse($schedule->bulan)->format('F Y') }}
            </h2>
            <div class="flex gap-2">
                {{-- Tombol Download PDF (Menggunakan rute yang ada di Controller) --}}
                <a href="{{ route('schedule.pdf', $schedule->id) }}" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors duration-200" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    Download PDF
                </a>
                {{-- Tombol Kembali --}}
                <a href="{{ route('schedule.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-4 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Bagian Dokumen & Ringkasan Petugas (Dihilangkan untuk brevity) --}}
            
            <hr class="my-6"> 

            {{-- 2. TABEL SPREADSHEET (1 - 31) - KOREKSI STICKY --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-6">
                <div class="p-6 bg-gradient-to-r from-teal-50 to-green-50 border-b border-gray-200">
                    <h3 class="text-xl font-bold text-gray-800">Detail Jadwal Harian</h3>
                    <p class="text-sm text-gray-600 mt-1">Simbol: <span class="text-blue-600 font-bold">&#x25CF; (Rencana)</span>, <span class="text-green-600 font-bold">&#x2713; (Realisasi)</span></p>
                </div>
                <div class="p-6 overflow-x-auto rounded-lg border border-gray-200">
                    @php
                        $monthDays = \Carbon\Carbon::parse($schedule->bulan)->daysInMonth;
                        // ✅ PERUBAHAN: Lebar Kolom Lokasi dikecilkan sedikit untuk rapat
                        $colLokasiWidth = '75px'; 
                        // ✅ PERUBAHAN: Lebar Kolom Keterangan (Rencana/Realisasi) dikembalikan ke 100px agar teks muat
                        $colKeteranganWidth = '100px'; 
                        
                        // Posisi sticky Keterangan: TIDAK DIGUNAKAN LAGI KARENA STICKY HILANG
                        $stickyKeteranganLeft = $colLokasiWidth; 
                    @endphp
                    
                    <table class="min-w-full divide-y divide-gray-200 table-fixed border-collapse">
                        <thead>
                            <tr class="bg-gray-100">
                                {{-- Kolom Lokasi: STICKY 1 (left: 0). Z-INDEX TERTINGGI agar selalu di depan --}}
                                <th rowspan="2" class="p-0.5 text-center text-xs font-bold text-gray-700 uppercase tracking-wider sticky left-0 bg-gray-100 border border-gray-300 z-30" style="width: {{ $colLokasiWidth }}">Lokasi</th>
                                
                                {{-- Kolom Keterangan: TIDAK STICKY, agar bergeser bersama kolom hari --}}
                                <th rowspan="2" class="p-0.5 text-center text-xs font-bold text-gray-700 uppercase tracking-wider bg-gray-100 border border-gray-300 z-10" style="width: {{ $colKeteranganWidth }}">Keterangan</th>
                                
                                {{-- HEADER MINGGU. p-0.5 --}}
                                @for ($week = 1; $week <= 5; $week++)
                                    @php
                                        $startDay = ($week - 1) * 7 + 1;
                                        $endDay = min($week * 7, $monthDays);
                                        $colspan = $endDay - $startDay + 1;
                                    @endphp
                                    
                                    @if ($colspan > 0)
                                        <th colspan="{{ $colspan }}" class="p-0.5 text-center text-xs font-medium text-gray-600 uppercase tracking-wider border border-gray-300">Minggu {{ $week }}</th>
                                    @endif
                                @endfor
                            </tr>
                            
                            {{-- HEADER TANGGAL. p-0 --}}
                            <tr class="bg-gray-200">
                                @for ($day = 1; $day <= $monthDays; $day++)
                                    <th class="p-0 text-center text-xs font-bold text-gray-700 uppercase tracking-wider border border-gray-300" style="width: 25px">{{ $day }}</th>
                                @endfor
                            </tr>
                        </thead>
                        
                        <tbody class="bg-white divide-y divide-gray-200">
                            {{-- Loop melalui setiap lokasi --}}
                            @forelse ($schedule->locations as $location)
                                @php
                                    $rencanaDays = $location->rencana ?? [];
                                    $realisasiDays = $location->realisasi ?? [];
                                @endphp

                                {{-- Baris Rencana --}}
                                <tr>
                                    {{-- Kolom Lokasi: STICKY 1 (left: 0). z-index tetap 10 --}}
                                    <td rowspan="2" class="p-1 whitespace-nowrap text-xs font-semibold text-gray-900 border border-gray-300 align-middle sticky left-0 bg-white z-10 text-center" style="width: {{ $colLokasiWidth }};">
                                        {{ $location->nama }}
                                        {{-- NAMA PETUGAS --}}
                                        <div class="text-[10px] text-gray-500 font-normal mt-0.5">{{ $location->petugas }}</div>
                                    </td>
                                    
                                    {{-- KETERANGAN RENCANA: TIDAK STICKY, HANYA Z-INDEX 1 --}}
                                    <td class="p-0 whitespace-nowrap text-[10px] text-blue-600 border border-gray-300 align-top font-semibold bg-blue-50 z-10 text-center" style="width: {{ $colKeteranganWidth }}">
                                        Rencana
                                    </td>
                                    
                                    @for ($day = 1; $day <= $monthDays; $day++)
                                        {{-- Cell Rencana. p-0 --}}
                                        <td class="p-0 text-center text-sm border border-gray-300 bg-blue-50">
                                            @if (is_array($rencanaDays) && in_array($day, $rencanaDays))
                                                <span class="text-blue-600 font-bold text-base" title="Rencana tanggal {{ $day }}">&#x25CF;</span> 
                                            @else
                                                &nbsp;
                                            @endif
                                        </td>
                                    @endfor
                                </tr>

                                {{-- Baris Realisasi --}}
                                <tr>
                                    {{-- KETERANGAN REALISASI: TIDAK STICKY, HANYA Z-INDEX 1 --}}
                                    <td class="p-0 whitespace-nowrap text-[10px] text-green-600 border border-gray-300 align-top font-semibold bg-green-50 z-10 text-center" style="width: {{ $colKeteranganWidth }}">
                                        Realisasi
                                    </td>
                                    @for ($day = 1; $day <= $monthDays; $day++)
                                        {{-- Cell Realisasi. p-0 --}}
                                        <td class="p-0 text-center text-sm border border-gray-300 bg-green-50">
                                            @if (is_array($realisasiDays) && in_array($day, $realisasiDays))
                                                <span class="text-green-600 font-bold text-base">&#x2713;</span> 
                                            @else
                                                &nbsp;
                                            @endif
                                        </td>
                                    @endfor
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ 2 + $monthDays }}" class="p-4 whitespace-nowrap text-center text-base text-gray-500">
                                        Tidak ada detail lokasi untuk jadwal ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>