<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('LA Maintenance System') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Job Categories Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 sm:gap-6">
                
                <!-- Battery -->
                <div class="bg-gradient-to-br from-purple-50 to-blue-50 rounded-2xl p-6 flex flex-col items-center justify-center hover:shadow-lg transition-all duration-300 cursor-pointer group">
                    <div class="mb-4 transform group-hover:scale-110 transition-transform duration-300">
                        <i data-lucide="battery-charging" class="w-12 h-12 text-purple-500"></i>

                    </div>
                    <span class="text-sm sm:text-base font-medium text-gray-700 text-center">Maintenance Battery</span>
                </div>

                <!-- ENV -->
                <div class="bg-gradient-to-br from-yellow-50 to-orange-50 rounded-2xl p-6 flex flex-col items-center justify-center hover:shadow-lg transition-all duration-300 cursor-pointer group">
                    <div class="mb-4 transform group-hover:scale-110 transition-transform duration-300">
                       <i data-lucide="Container" class="w-12 h-12  text-yellow-500"></i>
                    </div>
                    <span class="text-sm sm:text-base font-medium text-gray-700 text-center">Env Maintenance</span>
                </div>

                <h1>lanjutkan..... kawan sesuaikan dengan menu masing-masing</h1>

            </div>
        </div>
    </div>
</x-app-layout>