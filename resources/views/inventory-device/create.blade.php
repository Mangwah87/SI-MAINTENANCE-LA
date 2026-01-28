<x-app-layout>
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Tambah Inventory Device</h1>
    </div>

    <form action="{{ route('inventory-device.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow p-6">
        @csrf

        <!-- Header Information -->
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Location (Central)</label>
                <select name="central_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="">Select Central</option>
                    @foreach($centrals as $central)
                        <option value="{{ $central->id }}">{{ $central->nama }} - {{ $central->area }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Date</label>
                <input type="date" name="date" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2"
                       value="{{ date('Y-m-d') }}">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Time</label>
                <input type="time" name="time" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2"
                       value="{{ date('H:i') }}">
            </div>
        </div>

        <!-- Device Sentral Section -->
        <div class="mb-6">
            <div class="flex justify-between items-center mb-3">
                <h2 class="text-lg font-bold text-gray-800">I. DEVICE SENTRAL</h2>
                <button type="button" onclick="addDeviceSentral()"
                        class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-lg text-sm flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add Device
                </button>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full border-collapse border border-gray-300">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border border-gray-300 px-2 py-2 text-xs">NO</th>
                            <th class="border border-gray-300 px-2 py-2 text-xs">EQUIPMENT</th>
                            <th class="border border-gray-300 px-2 py-2 text-xs">QTY</th>
                            <th class="border border-gray-300 px-2 py-2 text-xs" colspan="2">STATUS</th>
                            <th class="border border-gray-300 px-2 py-2 text-xs" colspan="2">BONDING GROUND</th>
                            <th class="border border-gray-300 px-2 py-2 text-xs">KETERANGAN</th>
                            <th class="border border-gray-300 px-2 py-2 text-xs">Action</th>
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
                            <th class="border border-gray-300 px-2 py-1"></th>
                        </tr>
                    </thead>
                    <tbody id="deviceSentralTable">
                        <tr>
                            <td colspan="9" class="border border-gray-300 px-2 py-3 text-center text-gray-500 text-sm">
                                Click "Add Device" to add equipment
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Supporting Facilities Section -->
        <div class="mb-6">
            <div class="flex justify-between items-center mb-3">
                <h2 class="text-lg font-bold text-gray-800">II. SUPPORTING FACILITIES (SARPEN)</h2>
                <button type="button" onclick="addSupportingFacility()"
                        class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-lg text-sm flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add Device
                </button>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full border-collapse border border-gray-300">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border border-gray-300 px-2 py-2 text-xs">NO</th>
                            <th class="border border-gray-300 px-2 py-2 text-xs">EQUIPMENT</th>
                            <th class="border border-gray-300 px-2 py-2 text-xs">QTY</th>
                            <th class="border border-gray-300 px-2 py-2 text-xs" colspan="2">STATUS</th>
                            <th class="border border-gray-300 px-2 py-2 text-xs" colspan="2">BONDING GROUND</th>
                            <th class="border border-gray-300 px-2 py-2 text-xs">KETERANGAN</th>
                            <th class="border border-gray-300 px-2 py-2 text-xs">Action</th>
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
                            <th class="border border-gray-300 px-2 py-1"></th>
                        </tr>
                    </thead>
                    <tbody id="supportingFacilitiesTable">
                        <tr>
                            <td colspan="9" class="border border-gray-300 px-2 py-3 text-center text-gray-500 text-sm">
                                Click "Add Device" to add equipment
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Notes -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Notes / additional informations</label>
        </div>

        <!-- Executors -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-3">Executor</h3>
            <div class="grid grid-cols-2 gap-4">
                @for($i = 1; $i <= 4; $i++)
                <div class="flex gap-2">
                    <input type="text" name="executor_{{ $i }}" placeholder="Executor {{ $i }} Name"
                           class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    <select name="mitra_internal_{{ $i }}" class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
                        <option value="">-</option>
                        <option value="Mitra">Mitra</option>
                        <option value="Internal">Internal</option>
                    </select>
                </div>
                @endfor
            </div>
        </div>

        <!-- Verifikator & Head -->
        <div class="mb-6 grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Verifikator</label>
                <input type="text" name="verifikator"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 mb-2">
                <input type="text" name="verifikator_nik" placeholder="NIK"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Head of Sub Department</label>
                <input type="text" name="head_of_sub_department"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 mb-2">
                <input type="text" name="head_of_sub_department_nik" placeholder="NIK"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2">
            </div>
        </div>

        <!-- Images -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Documentation Images</label>
            <input type="file" name="images[]" multiple accept="image/*"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2">
        </div>

        <!-- Submit Buttons -->
        <div class="flex gap-2">
            <button type="submit"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg">
                Save
            </button>
            <a href="{{ route('inventory-device.index') }}"
               class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">
                Cancel
            </a>
        </div>
    </form>
</div>

<script>
let deviceSentralCounter = 0;
let supportingFacilityCounter = 0;

function addDeviceSentral() {
    const tbody = document.getElementById('deviceSentralTable');

    // Remove empty message if exists
    if (tbody.querySelector('td[colspan="9"]')) {
        tbody.innerHTML = '';
    }

    deviceSentralCounter++;
    const row = document.createElement('tr');
    row.innerHTML = `
        <td class="border border-gray-300 px-2 py-2 text-center text-sm">${deviceSentralCounter}</td>
        <td class="border border-gray-300 px-2 py-1">
            <input type="text" name="device_sentral[${deviceSentralCounter}][equipment]"
                   class="w-full px-2 py-1 text-sm border-0 focus:ring-0" required>
        </td>
        <td class="border border-gray-300 px-2 py-1">
            <input type="number" name="device_sentral[${deviceSentralCounter}][qty]"
                   class="w-full px-2 py-1 text-sm border-0 focus:ring-0" min="0">
        </td>
        <td class="border border-gray-300 px-2 py-1 text-center">
            <input type="checkbox" name="device_sentral[${deviceSentralCounter}][status_active]" value="1">
        </td>
        <td class="border border-gray-300 px-2 py-1 text-center">
            <input type="checkbox" name="device_sentral[${deviceSentralCounter}][status_shutdown]" value="1">
        </td>
        <td class="border border-gray-300 px-2 py-1 text-center">
            <input type="checkbox" name="device_sentral[${deviceSentralCounter}][bonding_connect]" value="1">
        </td>
        <td class="border border-gray-300 px-2 py-1 text-center">
            <input type="checkbox" name="device_sentral[${deviceSentralCounter}][bonding_not_connect]" value="1">
        </td>
        <td class="border border-gray-300 px-2 py-1">
            <input type="text" name="device_sentral[${deviceSentralCounter}][keterangan]"
                   class="w-full px-2 py-1 text-sm border-0 focus:ring-0">
        </td>
        <td class="border border-gray-300 px-2 py-1 text-center">
            <button type="button" onclick="this.closest('tr').remove()"
                    class="text-red-600 hover:text-red-800 text-xs">Remove</button>
        </td>
    `;
    tbody.appendChild(row);
}

function addSupportingFacility() {
    const tbody = document.getElementById('supportingFacilitiesTable');

    // Remove empty message if exists
    if (tbody.querySelector('td[colspan="9"]')) {
        tbody.innerHTML = '';
    }

    supportingFacilityCounter++;
    const row = document.createElement('tr');
    row.innerHTML = `
        <td class="border border-gray-300 px-2 py-2 text-center text-sm">${supportingFacilityCounter}</td>
        <td class="border border-gray-300 px-2 py-1">
            <input type="text" name="supporting_facilities[${supportingFacilityCounter}][equipment]"
                   class="w-full px-2 py-1 text-sm border-0 focus:ring-0" required>
        </td>
        <td class="border border-gray-300 px-2 py-1">
            <input type="number" name="supporting_facilities[${supportingFacilityCounter}][qty]"
                   class="w-full px-2 py-1 text-sm border-0 focus:ring-0" min="0">
        </td>
        <td class="border border-gray-300 px-2 py-1 text-center">
            <input type="checkbox" name="supporting_facilities[${supportingFacilityCounter}][status_active]" value="1">
        </td>
        <td class="border border-gray-300 px-2 py-1 text-center">
            <input type="checkbox" name="supporting_facilities[${supportingFacilityCounter}][status_shutdown]" value="1">
        </td>
        <td class="border border-gray-300 px-2 py-1 text-center">
            <input type="checkbox" name="supporting_facilities[${supportingFacilityCounter}][bonding_connect]" value="1">
        </td>
        <td class="border border-gray-300 px-2 py-1 text-center">
            <input type="checkbox" name="supporting_facilities[${supportingFacilityCounter}][bonding_not_connect]" value="1">
        </td>
        <td class="border border-gray-300 px-2 py-1">
            <input type="text" name="supporting_facilities[${supportingFacilityCounter}][keterangan]"
                   class="w-full px-2 py-1 text-sm border-0 focus:ring-0">
        </td>
        <td class="border border-gray-300 px-2 py-1 text-center">
            <button type="button" onclick="this.closest('tr').remove()"
                    class="text-red-600 hover:text-red-800 text-xs">Remove</button>
        </td>
    `;
    tbody.appendChild(row);
}
</script>
</x-app-layout>
