<x-app-layout>
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Detail Inventory Device</h1>
        <div class="flex gap-2">
            <a href="{{ route('inventory-device.edit', $inventory->id) }}"
               class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">
                Edit
            </a>
            <a href="{{ route('inventory-device.pdf', $inventory->id) }}"
               class="bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded-lg" target="_blank">
                Download PDF
            </a>
            <a href="{{ route('inventory-device.index') }}"
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                Back
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <!-- Header Information -->
        <div class="grid grid-cols-2 gap-4 mb-6 pb-6 border-b">
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Location</label>
                <p class="text-gray-900">
                    @if($inventory->central)
                        {{ $inventory->central->nama }} - {{ $inventory->central->area }}
                    @else
                        {{ $inventory->location ?? '-' }}
                    @endif
                </p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Date / Time</label>
                <p class="text-gray-900">
                    {{ \Carbon\Carbon::parse($inventory->date)->format('d/m/Y') }}
                    {{ \Carbon\Carbon::parse($inventory->time)->format('H:i') }}
                </p>
            </div>
        </div>

        <!-- Device Sentral -->
        <div class="mb-6">
            <h2 class="text-lg font-bold text-gray-800 mb-3 bg-yellow-400 px-3 py-2 rounded">I. DEVICE SENTRAL</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full border-collapse border border-gray-300">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border border-gray-300 px-3 py-2 text-xs">NO</th>
                            <th class="border border-gray-300 px-3 py-2 text-xs">EQUIPMENT</th>
                            <th class="border border-gray-300 px-3 py-2 text-xs">QTY</th>
                            <th class="border border-gray-300 px-3 py-2 text-xs" colspan="2">STATUS</th>
                            <th class="border border-gray-300 px-3 py-2 text-xs" colspan="2">BONDING GROUND</th>
                            <th class="border border-gray-300 px-3 py-2 text-xs">KETERANGAN</th>
                        </tr>
                        <tr>
                            <th class="border border-gray-300 px-2 py-1"></th>
                            <th class="border border-gray-300 px-2 py-1"></th>
                            <th class="border border-gray-300 px-2 py-1"></th>
                            <th class="border border-gray-300 px-2 py-1 text-xs bg-gray-50">ACTIVE</th>
                            <th class="border border-gray-300 px-2 py-1 text-xs bg-gray-50">SHUTDOWN</th>
                            <th class="border border-gray-300 px-2 py-1 text-xs bg-yellow-100">CONNECT</th>
                            <th class="border border-gray-300 px-2 py-1 text-xs bg-yellow-100">NOT CONNECT</th>
                            <th class="border border-gray-300 px-2 py-1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $deviceSentral = is_string($inventory->device_sentral)
                                ? json_decode($inventory->device_sentral, true)
                                : ($inventory->device_sentral ?? []);
                        @endphp
                        @if(!empty($deviceSentral) && count($deviceSentral) > 0)
                            @foreach($deviceSentral as $index => $device)
                            <tr>
                                <td class="border border-gray-300 px-3 py-2 text-center">{{ $index + 1 }}</td>
                                <td class="border border-gray-300 px-3 py-2">{{ $device['equipment'] ?? '-' }}</td>
                                <td class="border border-gray-300 px-3 py-2 text-center">{{ $device['qty'] ?? '-' }}</td>
                                <td class="border border-gray-300 px-3 py-2 text-center">
                                    {{ isset($device['status_active']) && $device['status_active'] ? '✓' : '' }}
                                </td>
                                <td class="border border-gray-300 px-3 py-2 text-center">
                                    {{ isset($device['status_shutdown']) && $device['status_shutdown'] ? '✓' : '' }}
                                </td>
                                <td class="border border-gray-300 px-3 py-2 text-center">
                                    {{ isset($device['bonding_connect']) && $device['bonding_connect'] ? '✓' : '' }}
                                </td>
                                <td class="border border-gray-300 px-3 py-2 text-center">
                                    {{ isset($device['bonding_not_connect']) && $device['bonding_not_connect'] ? '✓' : '' }}
                                </td>
                                <td class="border border-gray-300 px-3 py-2">{{ $device['keterangan'] ?? '' }}</td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8" class="border border-gray-300 px-3 py-4 text-center text-gray-500">
                                    No data available
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Supporting Facilities -->
        <div class="mb-6">
            <h2 class="text-lg font-bold text-gray-800 mb-3 bg-yellow-400 px-3 py-2 rounded">II. SUPPORTING FACILITIES (SARPEN)</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full border-collapse border border-gray-300">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border border-gray-300 px-3 py-2 text-xs">NO</th>
                            <th class="border border-gray-300 px-3 py-2 text-xs">EQUIPMENT</th>
                            <th class="border border-gray-300 px-3 py-2 text-xs">QTY</th>
                            <th class="border border-gray-300 px-3 py-2 text-xs" colspan="2">STATUS</th>
                            <th class="border border-gray-300 px-3 py-2 text-xs" colspan="2">BONDING GROUND</th>
                            <th class="border border-gray-300 px-3 py-2 text-xs">KETERANGAN</th>
                        </tr>
                        <tr>
                            <th class="border border-gray-300 px-2 py-1"></th>
                            <th class="border border-gray-300 px-2 py-1"></th>
                            <th class="border border-gray-300 px-2 py-1"></th>
                            <th class="border border-gray-300 px-2 py-1 text-xs bg-gray-50">ACTIVE</th>
                            <th class="border border-gray-300 px-2 py-1 text-xs bg-gray-50">SHUTDOWN</th>
                            <th class="border border-gray-300 px-2 py-1 text-xs bg-yellow-100">CONNECT</th>
                            <th class="border border-gray-300 px-2 py-1 text-xs bg-yellow-100">NOT CONNECT</th>
                            <th class="border border-gray-300 px-2 py-1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $supportingFacilities = is_string($inventory->supporting_facilities)
                                ? json_decode($inventory->supporting_facilities, true)
                                : ($inventory->supporting_facilities ?? []);
                        @endphp
                        @if(!empty($supportingFacilities) && count($supportingFacilities) > 0)
                            @foreach($supportingFacilities as $index => $device)
                            <tr>
                                <td class="border border-gray-300 px-3 py-2 text-center">{{ $index + 1 }}</td>
                                <td class="border border-gray-300 px-3 py-2">{{ $device['equipment'] ?? '-' }}</td>
                                <td class="border border-gray-300 px-3 py-2 text-center">{{ $device['qty'] ?? '-' }}</td>
                                <td class="border border-gray-300 px-3 py-2 text-center">
                                    {{ isset($device['status_active']) && $device['status_active'] ? '✓' : '' }}
                                </td>
                                <td class="border border-gray-300 px-3 py-2 text-center">
                                    {{ isset($device['status_shutdown']) && $device['status_shutdown'] ? '✓' : '' }}
                                </td>
                                <td class="border border-gray-300 px-3 py-2 text-center">
                                    {{ isset($device['bonding_connect']) && $device['bonding_connect'] ? '✓' : '' }}
                                </td>
                                <td class="border border-gray-300 px-3 py-2 text-center">
                                    {{ isset($device['bonding_not_connect']) && $device['bonding_not_connect'] ? '✓' : '' }}
                                </td>
                                <td class="border border-gray-300 px-3 py-2">{{ $device['keterangan'] ?? '' }}</td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8" class="border border-gray-300 px-3 py-4 text-center text-gray-500">
                                    No data available
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Notes -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-600 mb-2">Notes / additional informations</label>
            <div class="border border-gray-300 rounded-lg p-3 bg-gray-50 min-h-[60px]">
                <p class="text-gray-900">{{ $inventory->notes ?? '-' }}</p>
            </div>
        </div>

        <!-- Executors -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-3 text-gray-800">Executor</h3>
            <div class="grid grid-cols-2 gap-4">
                @for($i = 1; $i <= 4; $i++)
                    @if($inventory->{'executor_'.$i})
                    <div class="flex items-center gap-2 p-2 bg-gray-50 rounded">
                        <span class="font-medium text-gray-600">{{ $i }}.</span>
                        <span class="flex-1">{{ $inventory->{'executor_'.$i} }}</span>
                        @if($inventory->{'mitra_internal_'.$i})
                            <span class="text-xs px-2 py-1 rounded
                                {{ $inventory->{'mitra_internal_'.$i} == 'Mitra' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                {{ $inventory->{'mitra_internal_'.$i} }}
                            </span>
                        @endif
                    </div>
                    @endif
                @endfor
            </div>
        </div>

        <!-- Verifikator & Head -->
        <div class="grid grid-cols-2 gap-4">
            <div class="p-4 bg-gray-50 rounded-lg">
                <label class="block text-sm font-medium text-gray-600 mb-2">Verifikator</label>
                <p class="text-gray-900 font-medium">{{ $inventory->verifikator ?? '-' }}</p>
                @if($inventory->verifikator_nik)
                    <p class="text-sm text-gray-600">NIK: {{ $inventory->verifikator_nik }}</p>
                @endif
            </div>
            <div class="p-4 bg-gray-50 rounded-lg">
                <label class="block text-sm font-medium text-gray-600 mb-2">Head of Sub Department</label>
                <p class="text-gray-900 font-medium">{{ $inventory->head_of_sub_department ?? '-' }}</p>
                @if($inventory->head_of_sub_department_nik)
                    <p class="text-sm text-gray-600">NIK: {{ $inventory->head_of_sub_department_nik }}</p>
                @endif
            </div>
        </div>
    </div>
</div>
</x-app-layout>
