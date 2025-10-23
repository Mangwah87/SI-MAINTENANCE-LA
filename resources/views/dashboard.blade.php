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
                <a href="{{ route('battery.index') }}" class="block">
                    <div class="bg-gradient-to-br from-purple-50 to-blue-50 rounded-2xl p-6 flex flex-col items-center justify-center hover:shadow-lg transition-all duration-300 cursor-pointer group">
                        <div class="mb-4 transform group-hover:scale-110 transition-transform duration-300">
                            <i data-lucide="battery-charging" class="w-12 h-12 text-purple-500"></i>
                        </div>
                        <span class="text-sm sm:text-base font-medium text-gray-700 text-center">Maintenance Battery</span>
                    </div>
                </a>

                <!-- ENV -->
                {{-- <div class="bg-gradient-to-br from-yellow-50 to-orange-50 rounded-2xl p-6 flex flex-col items-center justify-center hover:shadow-lg transition-all duration-300 cursor-pointer group">
                    <div class="mb-4 transform group-hover:scale-110 transition-transform duration-300">
                       <i data-lucide="Container" class="w-12 h-12  text-yellow-500"></i>
                    </div>
                    <span class="text-sm sm:text-base font-medium text-gray-700 text-center"> Maintenance Env</span>
                </div> --}}
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-6 flex flex-col items-center justify-center hover:shadow-lg transition-all duration-300 cursor-pointer group">
                    <div class="mb-4 transform group-hover:scale-110 transition-transform duration-300">
                        <i data-lucide="ev-charger" class="w-12 h-12  text-blue-500"></i>
                    </div>
                    <span class="text-sm sm:text-base font-medium text-gray-700 text-center"> Maintenance Genset</span>
                </div>
                <div class=" bg-blue-500 rounded-2xl p-6 flex flex-col items-center justify-center hover:shadow-lg transition-all duration-300 cursor-pointer group">
                    <div class="mb-4 transform group-hover:scale-110 transition-transform duration-300">
                        <i data-lucide="pc-case" class="w-12 h-12  text-white"></i>
                    </div>
                    <span class="text-sm sm:text-base font-medium text-white text-center"> Maintenance 1 Phase UPS</span>
                </div>
                <div class=" bg-blue-500 rounded-2xl p-6 flex flex-col items-center justify-center hover:shadow-lg transition-all duration-300 cursor-pointer group">
                    <div class="mb-4 transform group-hover:scale-110 transition-transform duration-300">
                        <i data-lucide="pc-case" class="w-12 h-12  text-white"></i>
                    </div>
                    <span class="text-sm sm:text-base font-medium text-white text-center"> Maintenance 3 Phase UPS</span>
                </div>
                <div class=" bg-blue-500 rounded-2xl p-6 flex flex-col items-center justify-center hover:shadow-lg transition-all duration-300 cursor-pointer group">
                    <div class="mb-4 transform group-hover:scale-110 transition-transform duration-300">
                        <i data-lucide="air-vent" class="w-12 h-12  text-white"></i>
                    </div>
                    <span class="text-sm sm:text-base font-medium text-white text-center"> Maintenance AC</span>
                </div>
                <a href="{{ route('tindak-lanjut.index') }}" class="block h-full">
                    <div class="bg-gradient-to-br from-orange-400 to-red-500 rounded-2xl p-6 shadow-xl border-2 border-orange-300 h-full min-h-[180px] flex flex-col items-center justify-center hover:shadow-2xl hover:scale-105 transition-all duration-300 cursor-pointer group">
                        <div class="mb-4 transform group-hover:scale-110 transition-transform duration-300">
                            <i data-lucide="clipboard-check" class="w-12 h-12 text-white"></i>
                        </div>
                        <span class="text-sm sm:text-base font-bold text-white text-center leading-tight">Formulir Tindak Lanjut Preventive Maintenance</span>
                    </div>
                </a>
                 <a href="{{ route('followup.index') }}" class="block h-full">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 shadow-lg border-2 border-blue-400 h-full min-h-[180px] flex flex-col items-center justify-center hover:shadow-2xl hover:scale-105 transition-all duration-300 cursor-pointer group">
                        <div class="mb-4 transform group-hover:scale-110 transition-transform duration-300">
                            <i data-lucide="arrow-up-wide-narrow" class="w-12 h-12 text-white"></i>
                        </div>
                        <span class="text-sm sm:text-base font-semibold text-white text-center leading-tight">Permohonan Tindak Lanjut Preventive Maintenance</span>
                    </div>
                </a>
                <div class=" bg-blue-500 rounded-2xl p-6 flex flex-col items-center justify-center hover:shadow-lg transition-all duration-300 cursor-pointer group">
                    <div class="mb-4 transform group-hover:scale-110 transition-transform duration-300">
                        <i data-lucide="file-text" class="w-12 h-12  text-white"></i>
                    </div>
                    <span class="text-sm sm:text-base font-medium text-white text-center">Dokumentasi dan Pendataan Perangkat</span>
                </div>
                <div class=" bg-blue-500 rounded-2xl p-6 flex flex-col items-center justify-center hover:shadow-lg transition-all duration-300 cursor-pointer group">
                    <div class="mb-4 transform group-hover:scale-110 transition-transform duration-300">
                        <i data-lucide="calendar-check" class="w-12 h-12  text-white"></i>
                    </div>
                    <span class="text-sm sm:text-base font-medium text-white text-center">Jadwal Preventive Maintenance Sentral</span>
                </div>
                <div class=" bg-blue-500 rounded-2xl p-6 flex flex-col items-center justify-center hover:shadow-lg transition-all duration-300 cursor-pointer group">
                    <div class="mb-4 transform group-hover:scale-110 transition-transform duration-300">
                        <i data-lucide="move-right" class="w-12 h-12  text-white"></i>
                    </div>
                    <span class="text-sm sm:text-base font-medium text-white text-center">Preventive Maintenance Inverter -48VDC-220VAC</span>
                </div>
                <!-- Preventive Maintenance Ruang Shelter -->
                <a href="{{ route('pm-shelter.index') }}" class="bg-blue-500 rounded-2xl p-6 flex flex-col items-center justify-center hover:shadow-lg transition-all duration-300 cursor-pointer group">
                    <div class="mb-4 transform group-hover:scale-110 transition-transform duration-300">
                    <i data-lucide="house" class="w-12 h-12 text-white"></i>
                    </div>
                    <span class="text-sm sm:text-base font-medium text-white text-center">Preventive Maintenance Ruang Shelter</span>
                </a>
                <div class=" bg-blue-500 rounded-2xl p-6 flex flex-col items-center justify-center hover:shadow-lg transition-all duration-300 cursor-pointer group">
                    <div class="mb-4 transform group-hover:scale-110 transition-transform duration-300">
                        <i data-lucide="house" class="w-12 h-12  text-white"></i>
                    </div>
                    <span class="text-sm sm:text-base font-medium text-white text-center">Preventive Maintenance Ruang Shelter</span>
                </div>
                <div class=" bg-blue-500 rounded-2xl p-6 flex flex-col items-center justify-center hover:shadow-lg transition-all duration-300 cursor-pointer group">
                    <div class="mb-4 transform group-hover:scale-110 transition-transform duration-300">
                        <i data-lucide="arrow-left-right" class="w-12 h-12  text-white"></i>
                    </div>
                    <span class="text-sm sm:text-base font-medium text-white text-center">Preventive Maintenance Rectifier</span>
                </div>
                <div class=" bg-blue-500 rounded-2xl p-6 flex flex-col items-center justify-center hover:shadow-lg transition-all duration-300 cursor-pointer group">
                    <div class="mb-4 transform group-hover:scale-110 transition-transform duration-300">
                        <i data-lucide="zap" class="w-12 h-12  text-white"></i>
                    </div>
                    <span class="text-sm sm:text-base font-medium text-white text-center">Preventive Maintenance Petir dan Grounding</span>
                </div>
                <div class=" bg-blue-500 rounded-2xl p-6 flex flex-col items-center justify-center hover:shadow-lg transition-all duration-300 cursor-pointer group">
                    <div class="mb-4 transform group-hover:scale-110 transition-transform duration-300">
                        <i data-lucide="cable" class="w-12 h-12  text-white"></i>
                    </div>
                    <span class="text-sm sm:text-base font-medium text-white text-center">Preventive Maintenance Instalasi Kabel dan Panel Distribusi</span>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
