<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Preventive Maintenance AC') }}
            </h2>
            <a href="{{ route('ac.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium text-sm">
                + Add New
            </a>
        </div>
    </x-slot>

    <div class="py-4 md:py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Success Alert -->
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center gap-3 animate-pulse">
                    <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Search Bar -->
            <div class="mb-6 relative">
                <input type="text" id="searchInput" placeholder="Search location, brand, capacity..."
                       class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                <svg class="w-4 h-4 absolute left-3 top-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>

            <!-- Desktop Table View -->
            <div class="hidden md:block bg-white rounded-lg shadow overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Location</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Date / Time</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Brand / Type</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Capacity</th>
                                <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700 pr-8">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y" id="tableBody">
                            @foreach($maintenances as $maintenance)
                                <tr class="hover:bg-blue-50 transition duration-150">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $maintenance->location }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $maintenance->date_time->format('d/m/Y H:i') }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $maintenance->brand_type }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $maintenance->capacity }}</td>

                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end gap-3">
                                            <a href="{{ route('ac.show', $maintenance->id) }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm">View</a>
                                            <a href="{{ route('ac.edit', $maintenance->id) }}" class="text-orange-600 hover:text-orange-800 font-medium text-sm">Edit</a>
                                            <button onclick="deleteRecord({{ $maintenance->id }})" class="text-red-600 hover:text-red-800 font-medium text-sm">Delete</button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($maintenances->isEmpty())
                    <div class="px-6 py-12 text-center text-gray-500">
                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                        <p class="text-lg">No maintenance records found</p>
                        <p class="text-sm text-gray-400 mt-1">Start by adding a new maintenance record</p>
                    </div>
                @endif
            </div>

            <!-- Mobile Card View -->
            <div class="md:hidden space-y-3" id="cardContainer">
                @foreach($maintenances as $maintenance)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4 hover:shadow-md transition">
                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between items-start">
                                <h3 class="font-semibold text-gray-900 text-base">{{ $maintenance->location }}</h3>
                                @if($maintenance->overall_status === 'OK')
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-medium">OK</span>
                                @else
                                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs font-medium">NOK</span>
                                @endif
                            </div>
                            <p class="text-xs text-gray-500">{{ $maintenance->date_time->format('d/m/Y H:i') }}</p>
                        </div>

                        <div class="grid grid-cols-2 gap-3 mb-4 pb-3 border-b border-gray-100 text-xs">
                            <div>
                                <span class="text-gray-500">Brand:</span>
                                <p class="font-medium text-gray-900 mt-0.5">{{ $maintenance->brand_type }}</p>
                            </div>
                            <div>
                                <span class="text-gray-500">Capacity:</span>
                                <p class="font-medium text-gray-900 mt-0.5">{{ $maintenance->capacity }}</p>
                            </div>
                            <div>
                                <span class="text-gray-500">AC Units:</span>
                                <p class="font-medium text-gray-900 mt-0.5">
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs font-medium">
                                        {{ $maintenance->active_ac_units }} Unit{{ $maintenance->active_ac_units > 1 ? 's' : '' }}
                                    </span>
                                </p>
                            </div>
                            <div>
                                <span class="text-gray-500">Reg. Number:</span>
                                <p class="font-medium text-gray-900 mt-0.5">{{ $maintenance->reg_number ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="flex gap-2 text-xs">
                            <a href="{{ route('ac.show', $maintenance->id) }}" class="text-blue-600 hover:text-blue-800 font-medium">View</a>
                            <span class="text-gray-400">/</span>
                            <a href="{{ route('ac.edit', $maintenance->id) }}" class="text-orange-600 hover:text-orange-800 font-medium">Edit</a>
                            <span class="text-gray-400">/</span>
                            <button onclick="deleteRecord({{ $maintenance->id }})" class="text-red-600 hover:text-red-800 font-medium">Delete</button>
                        </div>
                    </div>
                @endforeach

                @if($maintenances->isEmpty())
                    <div class="text-center py-12 text-gray-500">
                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                        <p class="text-base">No maintenance records found</p>
                        <p class="text-sm text-gray-400 mt-1">Start by adding a new maintenance record</p>
                    </div>
                @endif
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $maintenances->links('pagination::tailwind') }}
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl p-6 max-w-sm w-full">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Delete Record</h3>
            <p class="text-gray-600 text-sm mb-6">Are you sure you want to delete this maintenance record? This action cannot be undone.</p>
            <div class="flex gap-3">
                <button onclick="closeDeleteModal()" class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium text-sm">
                    Cancel
                </button>
                <form id="deleteForm" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium text-sm">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        let currentDeleteId = null;

        function deleteRecord(id) {
            currentDeleteId = id;
            const form = document.getElementById('deleteForm');
            form.action = `/ac/${id}`;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            currentDeleteId = null;
        }

        function filterTable() {
            const searchValue = document.getElementById('searchInput').value.toLowerCase().trim();

            // For desktop table
            const tableRows = document.querySelectorAll('#tableBody tr');
            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchValue) ? '' : 'none';
            });

            // For mobile cards
            const cards = document.querySelectorAll('#cardContainer > div:not(.text-center)');
            cards.forEach(card => {
                const text = card.textContent.toLowerCase();
                card.style.display = text.includes(searchValue) ? '' : 'none';
            });
        }

        document.getElementById('searchInput').addEventListener('keyup', filterTable);

        // Close modal when clicking outside
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });

        // Auto-hide success message after 5 seconds
        setTimeout(function() {
            const successAlert = document.querySelector('.animate-pulse');
            if (successAlert) {
                successAlert.style.transition = 'opacity 0.5s';
                successAlert.style.opacity = '0';
                setTimeout(() => successAlert.remove(), 500);
            }
        }, 5000);
    </script>
</x-app-layout>
