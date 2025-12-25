

    <div class="py-6">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Banner -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl shadow-xl overflow-hidden mb-8 relative">
                <div class="px-8 py-10 relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between">
                    <div>
                        <h3 class="text-3xl font-bold text-white mb-2">Selamat Datang, {{ Auth::user()->name }}!</h3>
                        <p class="text-indigo-100 text-lg max-w-2xl">
                            Setiap keputusan besar dimulai dari data yang akurat. Keputusan cerdas, kepemimpinan berkualitas. Lets GO!!
                        </p>
                    </div>
                    <div class="mt-6 md:mt-0">
                         <span class="inline-flex items-center px-4 py-2 rounded-full bg-white/20 text-white backdrop-blur-sm border border-white/20 text-sm font-medium">
                            <span class="w-2 h-2 mr-2 bg-green-400 rounded-full animate-pulse"></span>
                            System Active
                        </span>
                    </div>
                </div>
                
                <!-- Decorative Circles -->
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-purple-500/20 rounded-full blur-2xl"></div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Candidates Card -->
                <div class="group relative bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 dark:border-gray-700">
                    <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                        <svg class="w-24 h-24 text-indigo-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                    </div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-indigo-50 dark:bg-indigo-900/30 rounded-xl text-indigo-600 dark:text-indigo-400">
                             <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                        <span class="text-3xl font-bold text-gray-900 dark:text-white">{{ $kandidatCount }}</span>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Kandidat</h4>
                    <p class="text-sm text-gray-500 mt-1">Total Kandidat</p>
                    <a href="{{ route('kandidat.index') }}" wire:navigate class="mt-4 inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-700">
                        Manage Kandidat &rarr;
                    </a>
                </div>

                <!-- Criteria Card -->
                <div class="group relative bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 dark:border-gray-700">
                     <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                        <svg class="w-24 h-24 text-purple-600" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                    </div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-purple-50 dark:bg-purple-900/30 rounded-xl text-purple-600 dark:text-purple-400">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                        </div>
                        <span class="text-3xl font-bold text-gray-900 dark:text-white">{{ $kriteriaCount }}</span>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Kriteria</h4>
                    <p class="text-sm text-gray-500 mt-1">Total Kriteria Penilaian</p>
                    <a href="{{ route('kriteria.index') }}" wire:navigate class="mt-4 inline-flex items-center text-sm font-medium text-purple-600 hover:text-purple-700">
                        Kelola Kriteria &rarr;
                    </a>
                </div>

                <!-- Users Card -->
                <!-- <div class="group relative bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 dark:border-gray-700">
                     <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                        <svg class="w-24 h-24 text-blue-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                    </div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-blue-50 dark:bg-blue-900/30 rounded-xl text-blue-600 dark:text-blue-400">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <span class="text-3xl font-bold text-gray-900 dark:text-white">{{ $userCount }}</span>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Pengguna</h4>
                    <p class="text-sm text-gray-500 mt-1">Total User terdaftar</p>
                </div> -->

                <!-- Jabatan Card -->
                <!-- <div class="group relative bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 dark:border-gray-700">
                     <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                        <svg class="w-24 h-24 text-amber-600" fill="currentColor" viewBox="0 0 24 24"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg>
                    </div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-amber-50 dark:bg-amber-900/30 rounded-xl text-amber-600 dark:text-amber-400">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                        <span class="text-3xl font-bold text-gray-900 dark:text-white">{{ $jabatanCount }}</span>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Jabatan Target</h4>
                    <p class="text-sm text-gray-500 mt-1">Jenis jabatan tersedia</p>
                </div> -->

                <!-- Results Card -->
                <div class="group relative bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 dark:border-gray-700">
                     <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                        <svg class="w-24 h-24 text-pink-600" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 12l-5-5 1.41-1.41L12 12.17l5.59-5.59L19 8l-7 7z"/></svg>
                    </div>
                    <div class="flex items-center justify-between mb-4">
                         <div class="p-3 bg-pink-50 dark:bg-pink-900/30 rounded-xl text-pink-600 dark:text-pink-400">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        </div>
                        <span class="text-2xl font-bold text-gray-900 dark:text-white">{{ $resultsCount }}</span>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Hasil Perangkingan</h4>
                    <p class="text-sm text-gray-500 mt-1">Penilaian WASPAS</p>
                    <a href="{{ route('waspas.hasil') }}" wire:navigate class="mt-4 inline-flex items-center text-sm font-medium text-pink-600 hover:text-pink-700">
                        View Ranking &rarr;
                    </a>
                </div>
            </div>
            
        </div>
    </div>

