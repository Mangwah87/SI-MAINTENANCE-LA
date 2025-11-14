<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Selamat Datang ') }}{{ Auth::user()->name }}
            </h2>
        </div>
    </x-slot>

    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    <script>
        lucide.createIcons();
    </script>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- SECTION: LAPORAN (Featured/Highlighted) -->
            <div class="mb-8">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i data-lucide="bar-chart-3" class="w-5 h-5 text-blue-600"></i>
                    Laporan
                </h3>
                <a href="{{ route('reports.all-forms') }}" class="block">
                    <div
                        class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-2xl p-6 shadow-xl border-2 border-blue-700 hover:shadow-2xl hover:scale-[1.02] transition-all duration-300 cursor-pointer group">
                        <div class="flex items-center gap-4">
                            <div
                                class="bg-white rounded-xl p-4 transform group-hover:scale-110 transition-transform duration-300">
                                <i data-lucide="folder-open" class="w-10 h-10 text-blue-600"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-xl font-bold text-white mb-1">Laporan Semua Form Maintenance</h4>

                            </div>
                            <div class="hidden sm:block">
                                <i data-lucide="arrow-right"
                                    class="w-6 h-6 text-white transform group-hover:translate-x-2 transition-transform duration-300"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- SECTION: FORM MAINTENANCE -->
            <div class="mb-4">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i data-lucide="clipboard-list" class="w-5 h-5 text-blue-600"></i>
                    Form Maintenance
                </h3>
            </div>

            <!-- Job Categories Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 sm:gap-6">

                <!-- Battery -->
                <a href="{{ route('battery.index') }}" class="block h-full">
                    <div
                        class="bg-white rounded-2xl p-6 shadow-lg border-2  h-full min-h-[180px] flex flex-col items-center justify-center hover:shadow-2xl hover:scale-105 transition-all duration-300 cursor-pointer group">
                        <div class="mb-4 transform group-hover:scale-110 transition-transform duration-300">
                            <i data-lucide="battery-charging" class="w-12 h-12 text-blue-600"></i>
                        </div>
                        <span
                            class="text-sm sm:text-base font-semibold text-black text-center leading-tight">Maintenance
                            Battery</span>
                    </div>
                </a>

                <!-- Maintenance Rectifier -->
                <a href="{{ route('rectifier.index') }}" class="block h-full">
                    <div
                        class="bg-white rounded-2xl p-6 shadow-lg border-2 h-full min-h-[180px] flex flex-col items-center justify-center hover:shadow-2xl hover:scale-105 transition-all duration-300 cursor-pointer group">
                        <div class="mb-4 transform group-hover:scale-110 transition-transform duration-300">
                            <i data-lucide="git-compare-arrows" class="w-12 h-12 text-blue-600"></i>
                        </div>
                        <span
                            class="text-sm sm:text-base font-semibold text-black text-center leading-tight">Maintenance
                            Rectifier
                        </span>
                    </div>
                </a>

                <!-- Genset -->
                <a href="{{ route('genset.index') }}" class="block h-full">
                    <div
                        class="bg-white rounded-2xl p-6 shadow-lg border-2  h-full min-h-[180px] flex flex-col items-center justify-center hover:shadow-2xl hover:scale-105 transition-all duration-300 cursor-pointer group">
                        <div class="mb-4 transform group-hover:scale-110 transition-transform duration-300">
                            <i data-lucide="zap" class="w-12 h-12 text-blue-600"></i>
                        </div>
                        <span
                            class="text-sm sm:text-base font-semibold text-black text-center leading-tight">Maintenance
                            Genset</span>
                    </div>
                </a>

                <!-- 1 Phase UPS -->
                <a href="{{ route('ups1.index') }}" class="block h-full">
                    <div
                        class="bg-white rounded-2xl p-6 shadow-lg border-2  h-full min-h-[180px] flex flex-col items-center justify-center hover:shadow-2xl hover:scale-105 transition-all duration-300 cursor-pointer group">
                        <div class="mb-4 transform group-hover:scale-110 transition-transform duration-300">
                            <i data-lucide="pc-case" class="w-12 h-12 text-blue-600"></i>
                        </div>
                        <span
                            class="text-sm sm:text-base font-semibold text-black text-center leading-tight">Maintenance
                            1 Phase UPS</span>
                    </div>
                </a>

                <!-- 3 Phase UPS -->
                <a href="{{ route('ups3.index') }}" class="block h-full">
                    <div
                        class="bg-white rounded-2xl p-6 shadow-lg border-2  h-full min-h-[180px] flex flex-col items-center justify-center hover:shadow-2xl hover:scale-105 transition-all duration-300 cursor-pointer group">
                        <div class="mb-4 transform group-hover:scale-110 transition-transform duration-300">
                            <i data-lucide="cpu" class="w-12 h-12 text-blue-600"></i>
                        </div>
                        <span
                            class="text-sm sm:text-base font-semibold text-black text-center leading-tight">Maintenance
                            3 Phase UPS</span>
                    </div>
                </a>

                <!-- AC -->
                <a href="{{ route('ac.index') }}" class="block h-full">
                    <div
                        class="bg-white rounded-2xl p-6 shadow-lg border-2  h-full min-h-[180px] flex flex-col items-center justify-center hover:shadow-2xl hover:scale-105 transition-all duration-300 cursor-pointer group">
                        <div class="mb-4 transform group-hover:scale-110 transition-transform duration-300">
                            <i data-lucide="air-vent" class="w-12 h-12 text-blue-600"></i>
                        </div>
                        <span
                            class="text-sm sm:text-base font-semibold text-black text-center leading-tight">Maintenance
                            AC</span>
                    </div>
                </a>

                <!-- Permohonan Tindak Lanjut Preventive Maintenance -->
                <a href="{{ route('pm-permohonan.index') }}" class="block h-full">
                    <div
                        class="bg-white rounded-2xl p-6 shadow-lg border-2  h-full min-h-[180px] flex flex-col items-center justify-center hover:shadow-2xl hover:scale-105 transition-all duration-300 cursor-pointer group">
                        <div class="mb-4 transform group-hover:scale-110 transition-transform duration-300">
                            <i data-lucide="book-text" class="w-12 h-12 text-blue-600"></i>
                        </div>
                        <span class="text-sm sm:text-base font-semibold text-black text-center leading-tight">Permohonan
                            Tindak Lanjut Preventive Maintenance</span>
                    </div>
                </a>

                <!-- Formulir Tindak Lanjut Preventive Maintenance -->
                <a href="{{ route('tindak-lanjut.index') }}" class="block h-full">
                    <div
                        class="bg-white rounded-2xl p-6 shadow-xl border-2  h-full min-h-[180px] flex flex-col items-center justify-center hover:shadow-2xl hover:scale-105 transition-all duration-300 cursor-pointer group">
                        <div class="mb-4 transform group-hover:scale-110 transition-transform duration-300">
                            <i data-lucide="book-check" class="w-12 h-12 text-blue-600"></i>
                        </div>
                        <span class="text-sm sm:text-base font-bold text-black text-center leading-tight">Formulir
                            Tindak Lanjut Preventive Maintenance</span>
                    </div>
                </a>

                <a href="{{ route('dokumentasi.index') }}" class="block h-full">
                    <div
                        class="bg-white rounded-2xl p-6 shadow-xl border-2 h-full min-h-[180px] flex flex-col items-center justify-center hover:shadow-2xl hover:scale-105 transition-all duration-300 cursor-pointer group">
                        <div class="mb-4 transform group-hover:scale-110 transition-transform duration-300">
                            <i data-lucide="clipboard-check" class="w-12 h-12 text-blue-600"></i>
                        </div>
                        <span class="text-sm sm:text-base font-bold text-black text-center leading-tight">Formulir
                            Dokumentasi dan Pendataan Perangkat</span>
                    </div>
                </a>

                <!-- Jadwal PM Sentral -->
                <a href="{{ route('schedule.index') }}" class="block h-full">
                    <div
                        class="bg-white rounded-2xl p-6 shadow-xl border-2  h-full min-h-[180px] flex flex-col items-center justify-center hover:shadow-2xl hover:scale-105 transition-all duration-300 cursor-pointer group">
                        <div class="mb-4 transform group-hover:scale-110 transition-transform duration-300">
                            <i data-lucide="calendar-check" class="w-12 h-12 text-blue-600"></i>
                        </div>
                        <span class="text-sm sm:text-base font-semibold text-black text-center leading-tight">Jadwal PM
                            Sentral</span>
                    </div>
                </a>

                <!-- PM Inverter -->
                <a href="inverter" class="block h-full">
                    <div
                        class="bg-white rounded-2xl p-6 shadow-lg border-2 h-full min-h-[180px] flex flex-col items-center justify-center hover:shadow-2xl hover:scale-105 transition-all duration-300 cursor-pointer group">
                        <div class="mb-4 transform group-hover:scale-110 transition-transform duration-300">
                            <i data-lucide="arrow-left-right" class="w-12 h-12 text-blue-600"></i>
                        </div>
                        <span class="text-sm sm:text-base font-semibold text-black text-center leading-tight">PM
                            Inverter -48VDC-220VAC</span>
                    </div>
                </a>

                <!-- Preventive Maintenance Ruang Shelter -->
                <a href="{{ route('pm-shelter.index') }}" class="block h-full">
                    <div
                        class="bg-white rounded-2xl p-6 shadow-lg border-2  h-full min-h-[180px] flex flex-col items-center justify-center hover:shadow-2xl hover:scale-105 transition-all duration-300 cursor-pointer group">
                        <div class="mb-4 transform group-hover:scale-110 transition-transform duration-300">
                            <i data-lucide="house" class="w-12 h-12 text-blue-600"></i>
                        </div>
                        <span
                            class="text-sm sm:text-base font-semibold text-black text-center leading-tight">Preventive
                            Maintenance Ruang Shelter</span>
                    </div>
                </a>

                <!-- PM Petir dan Grounding -->
                <a href="{{ route('grounding.index') }}" class="block h-full">
                    <div
                        class="bg-white rounded-2xl p-6 shadow-lg border-2  h-full min-h-[180px] flex flex-col items-center justify-center hover:shadow-2xl hover:scale-105 transition-all duration-300 cursor-pointer group">
                        <div class="mb-4 transform group-hover:scale-110 transition-transform duration-300">
                            <i data-lucide="zap" class="w-12 h-12 text-blue-600"></i>
                        </div>
                        <span class="text-sm sm:text-base font-semibold text-black text-center leading-tight">PM Petir
                            dan Grounding</span>
                    </div>
                </a>

                <!-- PM Instalasi Kabel -->
                <a href="{{ route('cable-panel.index') }}" class="block h-full">
                    <div
                        class="bg-white rounded-2xl p-6 shadow-lg border-2  h-full min-h-[180px] flex flex-col items-center justify-center hover:shadow-2xl hover:scale-105 transition-all duration-300 cursor-pointer group">
                        <div class="mb-4 transform group-hover:scale-110 transition-transform duration-300">
                            <i data-lucide="cable" class="w-12 h-12 text-blue-600"></i>
                        </div>
                        <span class="text-sm sm:text-base font-semibold text-black text-center leading-tight">PM
                            Instalasi Kabel dan Panel Distribusi</span>
                    </div>
                </a>

            </div>
        </div>
    </div>
</x-app-layout>
