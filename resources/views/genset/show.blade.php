<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Genset Maintenance') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('genset.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                    Kembali
                </a>
                {{-- Tombol Edit --}}
                <a href="{{ route('genset.edit', $maintenance->id) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-lg text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                    Edit
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                 <div class="p-6 bg-gradient-to-r from-blue-50 to-white-450 border-b border-gray-200">
                    <h3 class="text-xl font-bold text-blue-600">Informasi Dokumen</h3>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-1">No. Dokumen</label>
                        <p class="text-lg font-bold text-blue-700">{{ $maintenance->doc_number }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-1">Location</label>
                        <p class="text-lg text-gray-800">{{ $maintenance->location }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-1">Date / Time</label>
                        <p class="text-lg text-gray-800">{{ $maintenance->maintenance_date->format('d F Y, H:i') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-1">Brand / Type</label>
                        <p class="text-lg text-gray-800">{{ $maintenance->brand_type ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-1">Capacity</label>
                        <p class="text-lg text-gray-800">{{ $maintenance->capacity ?? '-' }}</p>
                    </div>
                     @if($maintenance->notes)
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Notes</label>
                            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                                <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $maintenance->notes }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-xl font-bold text-gray-800">1. Visual Check</h3>
                </div>
                <div class="p-6">
                    <table class="min-w-full">
                        <tbody class="divide-y divide-gray-200">
                            @php
                                $visualChecks = [
                                    'environment_condition' => 'Environment Condition',
                                    'engine_oil_press_display' => 'Engine Oil Press. Display',
                                    'engine_water_temp_display' => 'Engine Water Temp. Display',
                                    'battery_connection' => 'Battery Connection',
                                    'engine_oil_level' => 'Engine Oil Level',
                                    'engine_fuel_level' => 'Engine Fuel Level',
                                    'running_hours' => 'Running Hours',
                                    'cooling_water_level' => 'Cooling Water Level',
                                ];
                            @endphp
                            @foreach($visualChecks as $key => $label)
                            <tr>
                                <td class="py-3 pr-4 font-medium text-sm text-gray-600 w-1/3">{{$label}}</td>
                                <td class="py-3 px-4 text-sm text-gray-800 font-semibold">{{ $maintenance->{$key.'_result'} ?? '-'}}</td>
                                <td class="py-3 pl-4 text-sm text-gray-600">{{ $maintenance->{$key.'_comment'} ?? '-'}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-xl font-bold text-gray-800">2. Engine Running Test</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h4 class="font-bold text-lg text-gray-700 mb-4 border-b pb-2">I. No Load Test</h4>
                            <div class="space-y-3">
                                <p class="font-semibold text-gray-600">AC Output Voltage:</p>
                                <div class="pl-4 grid grid-cols-2 gap-x-4 gap-y-1 text-sm">
                                    <span>R-S: <b class="text-gray-900">{{ $maintenance->no_load_ac_voltage_rs ?? '-' }}</b></span>
                                    <span>R-N: <b class="text-gray-900">{{ $maintenance->no_load_ac_voltage_rn ?? '-' }}</b></span>
                                    <span>S-T: <b class="text-gray-900">{{ $maintenance->no_load_ac_voltage_st ?? '-' }}</b></span>
                                    <span>S-N: <b class="text-gray-900">{{ $maintenance->no_load_ac_voltage_sn ?? '-' }}</b></span>
                                    <span>T-R: <b class="text-gray-900">{{ $maintenance->no_load_ac_voltage_tr ?? '-' }}</b></span>
                                    <span>T-N: <b class="text-gray-900">{{ $maintenance->no_load_ac_voltage_tn ?? '-' }}</b></span>
                                </div>
                                <p class="text-sm">Output Freq: <b class="text-gray-900">{{ $maintenance->no_load_output_frequency ?? '-' }}</b></p>
                                <p class="text-sm">Batt. Charging Current: <b class="text-gray-900">{{ $maintenance->no_load_battery_charging_current ?? '-' }}</b></p>
                                <p class="text-sm">Cooling Water Temp: <b class="text-gray-900">{{ $maintenance->no_load_engine_cooling_water_temp ?? '-' }}</b></p>
                                <p class="text-sm">Engine Oil Press: <b class="text-gray-900">{{ $maintenance->no_load_engine_oil_press ?? '-' }}</b></p>
                            </div>
                        </div>

                        <div>
                             <h4 class="font-bold text-lg text-gray-700 mb-4 border-b pb-2">II. Load Test</h4>
                            <div class="space-y-3">
                                <p class="font-semibold text-gray-600">AC Output Voltage:</p>
                                <div class="pl-4 grid grid-cols-2 gap-x-4 gap-y-1 text-sm">
                                    <span>R-S: <b class="text-gray-900">{{ $maintenance->load_ac_voltage_rs ?? '-' }}</b></span>
                                    <span>R-N: <b class="text-gray-900">{{ $maintenance->load_ac_voltage_rn ?? '-' }}</b></span>
                                    <span>S-T: <b class="text-gray-900">{{ $maintenance->load_ac_voltage_st ?? '-' }}</b></span>
                                    <span>S-N: <b class="text-gray-900">{{ $maintenance->load_ac_voltage_sn ?? '-' }}</b></span>
                                    <span>T-R: <b class="text-gray-900">{{ $maintenance->load_ac_voltage_tr ?? '-' }}</b></span>
                                    <span>T-N: <b class="text-gray-900">{{ $maintenance->load_ac_voltage_tn ?? '-' }}</b></span>
                                </div>
                                 <p class="font-semibold text-gray-600 mt-3">AC Output Current:</p>
                                <div class="pl-4 grid grid-cols-2 gap-x-4 gap-y-1 text-sm">
                                    <span>R: <b class="text-gray-900">{{ $maintenance->load_ac_current_r ?? '-' }}</b></span>
                                    <span>S: <b class="text-gray-900">{{ $maintenance->load_ac_current_s ?? '-' }}</b></span>
                                    <span>T: <b class="text-gray-900">{{ $maintenance->load_ac_current_t ?? '-' }}</b></span>
                                </div>
                                <p class="text-sm">Output Freq: <b class="text-gray-900">{{ $maintenance->load_output_frequency ?? '-' }}</b></p>
                                <p class="text-sm">Batt. Charging Current: <b class="text-gray-900">{{ $maintenance->load_battery_charging_current ?? '-' }}</b></p>
                                <p class="text-sm">Cooling Water Temp: <b class="text-gray-900">{{ $maintenance->load_engine_cooling_water_temp ?? '-' }}</b></p>
                                <p class="text-sm">Engine Oil Press: <b class="text-gray-900">{{ $maintenance->load_engine_oil_press ?? '-' }}</b></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>