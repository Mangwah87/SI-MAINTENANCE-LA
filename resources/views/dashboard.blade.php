<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('LA Maintenance System') }}
            </h2>
        </div>
    </x-slot>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    <script>
        lucide.createIcons();
    </script>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Job Categories Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 sm:gap-6">

                <!-- Battery -->
                <a href="{{ route('battery.index') }}" class="block h-full">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 shadow-lg border-2 border-blue-400 h-full min-h-[180px] flex flex-col items-center justify-center hover:shadow-2xl hover:scale-105 transition-all duration-300 cursor-pointer group">
                        <div class="mb-4 transform group-hover:scale-110 transition-transform duration-300">
                            <i data-lucide="battery-charging" class="w-12 h-12 text-white"></i>
                        </div>
                        <span class="text-sm sm:text-base font-semibold text-white text-center leading-tight">Maintenance Battery</span>
                    </div>
                </a>

                <!-- Genset -->
                <a href="#" class="block h-full">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 shadow-lg border-2 border-blue-400 h-full min-h-[180px] flex flex-col items-center justify-center hover:shadow-2xl hover:scale-105 transition-all duration-300 cursor-pointer group">
                        <div class="mb-4 transform group-hover:scale-110 transition-transform duration-300">
                            <i data-lucide="zap" class="w-12 h-12 text-white"></i>
                        </div>
                        <span class="text-sm sm:text-base font-semibold text-white text-center leading-tight">Maintenance Genset</span>
                    </div>
                </a>

                <!-- 1 Phase UPS -->
                <a href="{{ route('ups1.index') }}" class="block h-full">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 shadow-lg border-2 border-blue-400 h-full min-h-[180px] flex flex-col items-center justify-center hover:shadow-2xl hover:scale-105 transition-all duration-300 cursor-pointer group">
                        <div class="mb-4 transform group-hover:scale-110 transition-transform duration-300">
                            <i data-lucide="pc-case" class="w-12 h-12 text-white"></i>
                        </div>
                        <span class="text-sm sm:text-base font-semibold text-white text-center leading-tight">Maintenance 1 Phase UPS</span>
                    </div>
                </a>

                <!-- 3 Phase UPS -->
                <a href="{{ route('ups3.index') }}" class="block h-full">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 shadow-lg border-2 border-blue-400 h-full min-h-[180px] flex flex-col items-center justify-center hover:shadow-2xl hover:scale-105 transition-all duration-300 cursor-pointer group">
                        <div class="mb-4 transform group-hover:scale-110 transition-transform duration-300">
                            <i data-lucide="cpu" class="w-12 h-12 text-white"></i>
                        </div>
                        <span class="text-sm sm:text-base font-semibold text-white text-center leading-tight">Maintenance 3 Phase UPS</span>
                    </div>
                </a>

                <!-- AC -->
                <a href="{{ route('ac.index')}}" class="block h-full">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 shadow-lg border-2 border-blue-400 h-full min-h-[180px] flex flex-col items-center justify-center hover:shadow-2xl hover:scale-105 transition-all duration-300 cursor-pointer group">
                        <div class="mb-4 transform group-hover:scale-110 transition-transform duration-300">
                            <i data-lucide="air-vent" class="w-12 h-12 text-white"></i>
                        </div>
                        <span class="text-sm sm:text-base font-semibold text-white text-center leading-tight">Maintenance AC</span>
                    </div>
                </a>

                <!-- Permohonan Tindak Lanjut -->
                <a href="#" class="block h-full">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 shadow-lg border-2 border-blue-400 h-full min-h-[180px] flex flex-col items-center justify-center hover:shadow-2xl hover:scale-105 transition-all duration-300 cursor-pointer group">
                        <div class="mb-4 transform group-hover:scale-110 transition-transform duration-300">
                            <i data-lucide="arrow-up-wide-narrow" class="w-12 h-12 text-white"></i>
                        </div>
                        <span class="text-sm sm:text-base font-semibold text-white text-center leading-tight">Permohonan Tindak Lanjut PM</span>
                    </div>
                </a>

                <!-- Tindak Lanjut -->
                <a href="#" class="block h-full">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 shadow-lg border-2 border-blue-400 h-full min-h-[180px] flex flex-col items-center justify-center hover:shadow-2xl hover:scale-105 transition-all duration-300 cursor-pointer group">
                        <div class="mb-4 transform group-hover:scale-110 transition-transform duration-300">
                            <i data-lucide="arrow-up-narrow-wide" class="w-12 h-12 text-white"></i>
                        </div>
                        <span class="text-sm sm:text-base font-semibold text-white text-center leading-tight">Tindak Lanjut PM</span>
                    </div>
                </a>

                <!-- Dokumentasi -->
                <a href="#" class="block h-full">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 shadow-lg border-2 border-blue-400 h-full min-h-[180px] flex flex-col items-center justify-center hover:shadow-2xl hover:scale-105 transition-all duration-300 cursor-pointer group">
                        <div class="mb-4 transform group-hover:scale-110 transition-transform duration-300">
                            <i data-lucide="file-text" class="w-12 h-12 text-white"></i>
                        </div>
                        <span class="text-sm sm:text-base font-semibold text-white text-center leading-tight">Dokumentasi dan Pendataan Perangkat</span>
                    </div>
                </a>

                <!-- Jadwal PM Sentral -->
                <a href="#" class="block h-full">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 shadow-lg border-2 border-blue-400 h-full min-h-[180px] flex flex-col items-center justify-center hover:shadow-2xl hover:scale-105 transition-all duration-300 cursor-pointer group">
                        <div class="mb-4 transform group-hover:scale-110 transition-transform duration-300">
                            <i data-lucide="calendar-check" class="w-12 h-12 text-white"></i>
                        </div>
                        <span class="text-sm sm:text-base font-semibold text-white text-center leading-tight">Jadwal PM Sentral</span>
                    </div>
                </a>

                <!-- PM Inverter -->
                <a href="#" class="block h-full">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 shadow-lg border-2 border-blue-400 h-full min-h-[180px] flex flex-col items-center justify-center hover:shadow-2xl hover:scale-105 transition-all duration-300 cursor-pointer group">
                        <div class="mb-4 transform group-hover:scale-110 transition-transform duration-300">
                            <i data-lucide="move-right" class="w-12 h-12 text-white"></i>
                        </div>
                        <span class="text-sm sm:text-base font-semibold text-white text-center leading-tight">PM Inverter -48VDC-220VAC</span>
                    </div>
                </a>

                <!-- PM Ruang Shelter -->
                <a href="#" class="block h-full">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 shadow-lg border-2 border-blue-400 h-full min-h-[180px] flex flex-col items-center justify-center hover:shadow-2xl hover:scale-105 transition-all duration-300 cursor-pointer group">
                        <div class="mb-4 transform group-hover:scale-110 transition-transform duration-300">
                            <i data-lucide="house" class="w-12 h-12 text-white"></i>
                        </div>
                        <span class="text-sm sm:text-base font-semibold text-white text-center leading-tight">PM Ruang Shelter</span>
                    </div>
                </a>

                <!-- PM Rectifier -->
                <a href="#" class="block h-full">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 shadow-lg border-2 border-blue-400 h-full min-h-[180px] flex flex-col items-center justify-center hover:shadow-2xl hover:scale-105 transition-all duration-300 cursor-pointer group">
                        <div class="mb-4 transform group-hover:scale-110 transition-transform duration-300">
                            <i data-lucide="arrow-left-right" class="w-12 h-12 text-white"></i>
                        </div>
                        <span class="text-sm sm:text-base font-semibold text-white text-center leading-tight">PM Rectifier</span>
                    </div>
                </a>

                <!-- PM Petir dan Grounding -->
                <a href="#" class="block h-full">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 shadow-lg border-2 border-blue-400 h-full min-h-[180px] flex flex-col items-center justify-center hover:shadow-2xl hover:scale-105 transition-all duration-300 cursor-pointer group">
                        <div class="mb-4 transform group-hover:scale-110 transition-transform duration-300">
                            <i data-lucide="zap" class="w-12 h-12 text-white"></i>
                        </div>
                        <span class="text-sm sm:text-base font-semibold text-white text-center leading-tight">PM Petir dan Grounding</span>
                    </div>
                </a>

                <!-- PM Instalasi Kabel -->
                <a href="#" class="block h-full">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 shadow-lg border-2 border-blue-400 h-full min-h-[180px] flex flex-col items-center justify-center hover:shadow-2xl hover:scale-105 transition-all duration-300 cursor-pointer group">
                        <div class="mb-4 transform group-hover:scale-110 transition-transform duration-300">
                            <i data-lucide="cable" class="w-12 h-12 text-white"></i>
                        </div>
                        <span class="text-sm sm:text-base font-semibold text-white text-center leading-tight">PM Instalasi Kabel dan Panel Distribusi</span>
                    </div>
                </a>

            </div>
        </div>
    </div>
</x-app-layout>
