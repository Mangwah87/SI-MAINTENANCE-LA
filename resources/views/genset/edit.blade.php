<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Form Preventive Maintenance Genset') }}
            </h2>
            <a href="{{ route('genset.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('genset.update', $maintenance->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 bg-gradient-to-r from-purple-50 to-blue-50 border-b border-gray-200">
                        <h3 class="text-xl font-bold text-gray-800">Informasi Umum</h3>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Location *</label>
                            <input type="text" name="location" value="{{ old('location', $maintenance->location) }}" required class="w-full border-gray-300 rounded-lg">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Date / Time *</label>
                            <input type="datetime-local" name="maintenance_date" value="{{ old('maintenance_date', $maintenance->maintenance_date->format('Y-m-d\TH:i')) }}" required class="w-full border-gray-300 rounded-lg">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Brand / Type</label>
                            <input type="text" name="brand_type" value="{{ old('brand_type', $maintenance->brand_type) }}" class="w-full border-gray-300 rounded-lg">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Capacity</label>
                            <input type="text" name="capacity" value="{{ old('capacity', $maintenance->capacity) }}" class="w-full border-gray-300 rounded-lg">
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                     <div class="p-6 bg-gray-50 border-b border-gray-200">
                        <h3 class="text-xl font-bold text-gray-800">1. Visual Check</h3>
                    </div>
                    <div class="p-6">
                         <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-bold text-gray-600 uppercase">Description</th>
                                    <th class="px-4 py-2 text-left text-xs font-bold text-gray-600 uppercase">Result</th>
                                    <th class="px-4 py-2 text-left text-xs font-bold text-gray-600 uppercase">Comment</th>
                                </tr>
                            </thead>
                             <tbody class="bg-white divide-y divide-gray-200">
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
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $label }}</td>
                                    <td class="px-4 py-3"><input type="text" name="{{ $key }}_result" value="{{ old($key.'_result', $maintenance->{$key.'_result'}) }}" class="w-full text-sm border-gray-300 rounded-md"></td>
                                    <td class="px-4 py-3"><input type="text" name="{{ $key }}_comment" value="{{ old($key.'_comment', $maintenance->{$key.'_comment'}) }}" class="w-full text-sm border-gray-300 rounded-md"></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Notes / Additional Informations</label>
                        <textarea name="notes" rows="4" class="w-full border-gray-300 rounded-lg">{{ old('notes', $maintenance->notes) }}</textarea>
                    </div>
                     <div class="p-6 border-t border-gray-200">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Pelaksana</h3>
                        <div class="space-y-4">
                             @for ($i = 1; $i <= 3; $i++)
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 border p-4 rounded-md">
                                <span class="md:col-span-1 font-semibold self-center">Pelaksana #{{ $i }} {{ $i == 1 ? '*' : '(Opsional)'}}</span>
                                <div class="md:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                     <input type="text" name="technician_{{ $i }}_name" placeholder="Nama" value="{{ old('technician_'.$i.'_name', $maintenance->{'technician_'.$i.'_name'}) }}" class="w-full text-sm border-gray-300 rounded-md" {{ $i == 1 ? 'required' : '' }}>
                                     <input type="text" name="technician_{{ $i }}_department" placeholder="Departemen" value="{{ old('technician_'.$i.'_department', $maintenance->{'technician_'.$i.'_department'}) }}" class="w-full text-sm border-gray-300 rounded-md">
                                </div>
                            </div>
                            @endfor
                        </div>
                    </div>
                </div>

                <div class="flex justify-center gap-4">
                    <button type="submit" class="px-8 py-3 bg-gradient-to-r from-purple-500 to-blue-500 hover:from-purple-600 hover:to-blue-600 text-white font-bold rounded-lg">
                        Update Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>