<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Data Pole
        </h2>
    </x-slot>

    <div class="container mx-auto p-6 max-w-6xl">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <!-- Header section with responsive layout -->
            <div class="mb-6 pb-4 border-b-2">
                <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Detail Data Pole</h2>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('pole.edit', $pole->id) }}" class="inline-block px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition">
                            Edit
                        </a>
                        <form action="{{ route('pole.destroy', $pole->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition">
                                Hapus
                            </button>
                        </form>
                        <a href="{{ route('pole.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Kembali
                        </a>
                        <a href="{{ route('pole.pdf', $pole->id) }}" class="inline-block px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition" target="_blank">
                            Cetak PDF
                        </a>
                    </div>
                </div>
            </div>

            {{-- Informasi Umum --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">Informasi Umum</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="border-l-4 border-blue-500 pl-3 rounded-md">
                        <p class="text-sm text-gray-600">Lokasi Sentral</p>
                        <p class="font-semibold">
                            @if($pole->central)
                                {{ $pole->central->nama }} - {{ $pole->central->area }} ({{ $pole->central->id_sentral }})
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </p>
                    </div>
                    <div class="border-l-4 border-blue-500 pl-3 rounded-md">
                        <p class="text-sm text-gray-600">Tanggal</p>
                        <p class="font-semibold">{{ \Carbon\Carbon::parse($pole->date)->format('d/m/Y') }}</p>
                    </div>
                    <div class="border-l-4 border-blue-500 pl-3 rounded-md">
                        <p class="text-sm text-gray-600">Waktu</p>
                        <p class="font-semibold">{{ \Carbon\Carbon::parse($pole->time)->format('H:i') }} WITA</p>
                    </div>
                    <div class="border-l-4 border-blue-500 pl-3 rounded-md">
                        <p class="text-sm text-gray-600">Tipe Pole</p>
                        <p class="font-semibold">{{ $pole->type_pole }}</p>
                    </div>
                </div>
            </div>

            {{-- Physical Check --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">Physical Check</h3>
                <div class="overflow-x-auto">
                    <table class="w-full border">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border p-2 text-left">Item</th>
                                <th class="border p-2 text-left">Result</th>
                                <th class="border p-2 text-center">Status</th>
                                <th class="border p-2 text-center">Foto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="border p-2">a. Foundation Condition</td>
                                <td class="border p-2 font-semibold">{{ $pole->foundation_condition ?? '-' }}</td>
                                <td class="border p-2 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{ ($pole->status_foundation_condition ?? '-') === 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $pole->status_foundation_condition ?? '-' }}
                                    </span>
                                </td>
                                <td class="border p-2">
                                    @if(isset($pole->images['physical_check_foundation_condition']))
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($pole->images['physical_check_foundation_condition'] as $imagePath)
                                                <a href="{{ asset('storage/' . $imagePath) }}" target="_blank">
                                                    <img src="{{ asset('storage/' . $imagePath) }}" alt="Photo" class="w-16 h-16 object-cover rounded border hover:opacity-75">
                                                </a>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-sm">-</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="border p-2">b. Pole/Tower Foundation Flange</td>
                                <td class="border p-2 font-semibold">{{ $pole->pole_tower_foundation_flange ?? '-' }}</td>
                                <td class="border p-2 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{ ($pole->status_pole_tower_foundation_flange ?? '-') === 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $pole->status_pole_tower_foundation_flange ?? '-' }}
                                    </span>
                                </td>
                                <td class="border p-2">
                                    @if(isset($pole->images['physical_check_foundation_flange']))
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($pole->images['physical_check_foundation_flange'] as $imagePath)
                                                <a href="{{ asset('storage/' . $imagePath) }}" target="_blank">
                                                    <img src="{{ asset('storage/' . $imagePath) }}" alt="Photo" class="w-16 h-16 object-cover rounded border hover:opacity-75">
                                                </a>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-sm">-</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="border p-2">c. Pole/Tower Support Flange</td>
                                <td class="border p-2 font-semibold">{{ $pole->pole_tower_support_flange ?? '-' }}</td>
                                <td class="border p-2 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{ ($pole->status_pole_tower_support_flange ?? '-') === 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $pole->status_pole_tower_support_flange ?? '-' }}
                                    </span>
                                </td>
                                <td class="border p-2">
                                    @if(isset($pole->images['physical_check_support_flange']))
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($pole->images['physical_check_support_flange'] as $imagePath)
                                                <a href="{{ asset('storage/' . $imagePath) }}" target="_blank">
                                                    <img src="{{ asset('storage/' . $imagePath) }}" alt="Photo" class="w-16 h-16 object-cover rounded border hover:opacity-75">
                                                </a>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-sm">-</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="border p-2">d. Flange Condition Connection</td>
                                <td class="border p-2 font-semibold">{{ $pole->flange_condition_connection ?? '-' }}</td>
                                <td class="border p-2 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{ ($pole->status_flange_condition_connection ?? '-') === 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $pole->status_flange_condition_connection ?? '-' }}
                                    </span>
                                </td>
                                <td class="border p-2">
                                    @if(isset($pole->images['physical_check_connection_flange']))
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($pole->images['physical_check_connection_flange'] as $imagePath)
                                                <a href="{{ asset('storage/' . $imagePath) }}" target="_blank">
                                                    <img src="{{ asset('storage/' . $imagePath) }}" alt="Photo" class="w-16 h-16 object-cover rounded border hover:opacity-75">
                                                </a>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-sm">-</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="border p-2">e. Pole/Tower Condition</td>
                                <td class="border p-2 font-semibold">{{ $pole->pole_tower_condition ?? '-' }}</td>
                                <td class="border p-2 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{ ($pole->status_pole_tower_condition ?? '-') === 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $pole->status_pole_tower_condition ?? '-' }}
                                    </span>
                                </td>
                                <td class="border p-2">
                                    @if(isset($pole->images['physical_check_pole_tower_condition']))
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($pole->images['physical_check_pole_tower_condition'] as $imagePath)
                                                <a href="{{ asset('storage/' . $imagePath) }}" target="_blank">
                                                    <img src="{{ asset('storage/' . $imagePath) }}" alt="Photo" class="w-16 h-16 object-cover rounded border hover:opacity-75">
                                                </a>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-sm">-</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="border p-2">f. Arm Antenna Condition</td>
                                <td class="border p-2 font-semibold">{{ $pole->arm_antenna_condition ?? '-' }}</td>
                                <td class="border p-2 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{ ($pole->status_arm_antenna_condition ?? '-') === 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $pole->status_arm_antenna_condition ?? '-' }}
                                    </span>
                                </td>
                                <td class="border p-2">
                                    @if(isset($pole->images['physical_check_arm_antenna']))
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($pole->images['physical_check_arm_antenna'] as $imagePath)
                                                <a href="{{ asset('storage/' . $imagePath) }}" target="_blank">
                                                    <img src="{{ asset('storage/' . $imagePath) }}" alt="Photo" class="w-16 h-16 object-cover rounded border hover:opacity-75">
                                                </a>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-sm">-</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="border p-2">g. Availability Basbar Ground</td>
                                <td class="border p-2 font-semibold">{{ $pole->availability_basbar_ground ?? '-' }}</td>
                                <td class="border p-2 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{ ($pole->status_availability_basbar_ground ?? '-') === 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $pole->status_availability_basbar_ground ?? '-' }}
                                    </span>
                                </td>
                                <td class="border p-2">
                                    @if(isset($pole->images['physical_check_basbar_ground']))
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($pole->images['physical_check_basbar_ground'] as $imagePath)
                                                <a href="{{ asset('storage/' . $imagePath) }}" target="_blank">
                                                    <img src="{{ asset('storage/' . $imagePath) }}" alt="Photo" class="w-16 h-16 object-cover rounded border hover:opacity-75">
                                                </a>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-sm">-</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="border p-2">h. Bonding Bar</td>
                                <td class="border p-2 font-semibold">{{ $pole->bonding_bar ?? '-' }}</td>
                                <td class="border p-2 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{ ($pole->status_bonding_bar ?? '-') === 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $pole->status_bonding_bar ?? '-' }}
                                    </span>
                                </td>
                                <td class="border p-2">
                                    @if(isset($pole->images['physical_check_bonding_bar']))
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($pole->images['physical_check_bonding_bar'] as $imagePath)
                                                <a href="{{ asset('storage/' . $imagePath) }}" target="_blank">
                                                    <img src="{{ asset('storage/' . $imagePath) }}" alt="Photo" class="w-16 h-16 object-cover rounded border hover:opacity-75">
                                                </a>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-sm">-</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Performance Measurement --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">Performance Measurement</h3>
                <div class="overflow-x-auto">
                    <table class="w-full border">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border p-2 text-left">Item</th>
                                <th class="border p-2 text-left">Result</th>
                                <th class="border p-2 text-center">Foto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="border p-2">Inclination Measurement</td>
                                <td class="border p-2 font-semibold">{{ $pole->inclination_measurement ?? '-' }}</td>
                                <td class="border p-2">
                                    @if(isset($pole->images['performance_inclination']))
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($pole->images['performance_inclination'] as $imagePath)
                                                <a href="{{ asset('storage/' . $imagePath) }}" target="_blank">
                                                    <img src="{{ asset('storage/' . $imagePath) }}" alt="Photo" class="w-16 h-16 object-cover rounded border hover:opacity-75">
                                                </a>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-sm">-</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Data Pelaksana --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3 bg-indigo-50 p-2 rounded">Data Pelaksana</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    @for($i = 1; $i <= 4; $i++)
                        <div class="border p-3 rounded">
                            <p class="text-sm text-gray-600">Pelaksana {{ $i }}</p>
                            <p class="font-semibold mt-1">{{ $pole->{'executor_'.$i} ?? '-' }}</p>
                            @if($pole->{'executor_'.$i})
                                <p class="text-xs text-gray-500 mt-1">{{ $pole->{'mitra_internal_'.$i} ?? '-' }}</p>
                            @endif
                        </div>
                    @endfor
                </div>
            </div>

            {{-- Mengetahui --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3 bg-indigo-50 p-2 rounded">Mengetahui</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="border p-3 rounded bg-blue-50">
                        <p class="text-sm text-gray-600">Verifikator</p>
                        <p class="font-semibold mt-1">{{ $pole->verifikator ?? '-' }}</p>
                        @if($pole->verifikator_nik)
                            <p class="text-xs text-gray-500 mt-1">NIK: {{ $pole->verifikator_nik }}</p>
                        @endif
                    </div>
                    <div class="border p-3 rounded bg-blue-50">
                        <p class="text-sm text-gray-600">Head of Sub Department</p>
                        <p class="font-semibold mt-1">{{ $pole->head_of_sub_department ?? '-' }}</p>
                        @if($pole->head_of_sub_department_nik)
                            <p class="text-xs text-gray-500 mt-1">NIK: {{ $pole->head_of_sub_department_nik }}</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Notes --}}
            @if($pole->notes)
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-3 bg-blue-50 p-2 rounded">Notes / Catatan</h3>
                    <div class="border p-4 rounded bg-gray-50">
                        <p class="whitespace-pre-wrap">{{ $pole->notes }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
