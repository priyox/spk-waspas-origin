<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Proses Perhitungan WASPAS') }}
    </h2>
</x-slot>

<div class="py-6">
    <div class="w-full px-4 lg:px-6 space-y-6">

        {{-- Flash Messages --}}
        @if (session()->has('message'))
            <div class="p-4 bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 rounded-lg">
                {{ session('message') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="p-4 bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-300 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        {{-- Pilih Jabatan Target --}}
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Pilih Jabatan Target</h3>

                <div class="flex flex-col md:flex-row gap-4 items-end">
                    <div class="flex-1">
                        <label for="selectedJabatanId" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Jabatan Target <span class="text-red-500">*</span>
                        </label>
                        <select wire:model.live="selectedJabatanId" id="selectedJabatanId"
                            class="w-full px-4 py-3 text-base border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-100 transition-colors appearance-none bg-no-repeat bg-right pr-10"
                            style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27%236b7280%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e'); background-size: 1.5em;">
                            <option value="">-- Pilih Jabatan Target --</option>
                            @foreach($jabatanTargets as $target)
                                <option value="{{ $target->id }}">{{ $target->nama_jabatan }} ({{ $target->eselon->eselon ?? '-' }})</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="button" wire:click="calculate"
                        class="px-6 py-3 bg-indigo-600 border border-transparent rounded-lg font-semibold text-base text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-50"
                        @if(!$selectedJabatanId) disabled @endif>
                        <span wire:loading.remove wire:target="calculate">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            Hitung WASPAS
                        </span>
                        <span wire:loading wire:target="calculate">
                            <svg class="animate-spin h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Menghitung...
                        </span>
                    </button>
                </div>

                @if($selectedJabatanId)
                    @php
                        $selectedTarget = $jabatanTargets->find($selectedJabatanId);
                        $syarat = \App\Models\SyaratJabatan::where('eselon_id', $selectedTarget?->id_eselon)->first();
                    @endphp
                    @if($syarat)
                    <div class="mt-4 p-3 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg text-sm text-indigo-700 dark:text-indigo-300">
                        <p class="font-semibold mb-1">Syarat Jabatan ({{ $selectedTarget->eselon->eselon ?? '-' }}):</p>
                        <ul class="list-disc list-inside space-y-0.5 text-xs">
                            <li>Min. Golongan: {{ $syarat->minimalGolongan->golongan ?? '-' }}</li>
                            <li>Min. Pendidikan: {{ $syarat->minimalTingkatPendidikan->tingkat ?? '-' }}</li>
                        </ul>
                    </div>
                    @endif
                @endif
            </div>
        </div>

        @if($isCalculated && count($results) > 0)
            {{-- Step 1: Matriks Nilai --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                        1. Matriks Keputusan (X)
                        <span class="text-sm font-normal text-gray-500">- Nilai untuk setiap kriteria</span>
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 border text-sm">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-3 py-2 text-center text-xs font-medium text-gray-500 uppercase sticky left-0 bg-gray-50 dark:bg-gray-700">Kandidat</th>
                                    @foreach($kriterias as $kriteria)
                                    <th class="px-3 py-2 text-center text-xs font-medium text-gray-500 uppercase">
                                        K{{ $kriteria->id }}
                                        @if(in_array($kriteria->id, [1,2,3,4]))
                                            <span class="block text-[9px] text-blue-500">auto</span>
                                        @endif
                                    </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($results as $result)
                                <tr>
                                    <td class="px-3 py-2 text-sm font-medium sticky left-0 bg-white dark:bg-gray-800">{{ $result['nama'] }}</td>
                                    @foreach($kriterias as $kriteria)
                                    <td class="px-3 py-2 text-center {{ in_array($kriteria->id, [1,2,3,4]) ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300' : '' }}">
                                        {{ $matrix[$result['kandidat_id']][$kriteria->id] ?? 0 }}
                                    </td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Step 2: Matriks Ternormalisasi --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                        2. Matriks Ternormalisasi (R)
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 border text-sm">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-3 py-2 text-center text-xs font-medium text-gray-500 uppercase sticky left-0 bg-gray-50 dark:bg-gray-700">Kandidat</th>
                                    @foreach($kriterias as $kriteria)
                                    <th class="px-3 py-2 text-center text-xs font-medium text-gray-500 uppercase">
                                        K{{ $kriteria->id }}
                                        <span class="block text-[9px] text-indigo-400">({{ $kriteria->jenis }})</span>
                                    </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($results as $result)
                                <tr>
                                    <td class="px-3 py-2 text-sm font-medium sticky left-0 bg-white dark:bg-gray-800">{{ $result['nama'] }}</td>
                                    @foreach($kriterias as $kriteria)
                                    <td class="px-3 py-2 text-center">
                                        {{ number_format($normalized[$result['kandidat_id']][$kriteria->id] ?? 0, 4) }}
                                    </td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Step 3: Perhitungan Q --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                        3. Perhitungan Nilai Q & Ranking
                    </h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 border">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-3 text-center text-xs font-bold text-gray-600 dark:text-gray-300 uppercase">Rank</th>
                                    <th class="px-4 py-3 text-center text-xs font-bold text-gray-600 dark:text-gray-300 uppercase">Kandidat</th>
                                    <th class="px-4 py-3 text-center text-xs font-bold text-gray-600 dark:text-gray-300 uppercase">Q1 (WSM)</th>
                                    <th class="px-4 py-3 text-center text-xs font-bold text-gray-600 dark:text-gray-300 uppercase">Q2 (WPM)</th>
                                    <th class="px-4 py-3 text-center text-xs font-bold text-gray-600 dark:text-gray-300 uppercase">Qi (Final)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($results as $index => $result)
                                <tr class="{{ $index === 0 ? 'bg-green-50 dark:bg-green-900/20' : '' }}">
                                    <td class="px-4 py-3 text-center">
                                        @if($index === 0)
                                            <span class="inline-flex items-center justify-center w-8 h-8 bg-yellow-400 text-yellow-900 rounded-full font-bold">
                                                1
                                            </span>
                                        @elseif($index === 1)
                                            <span class="inline-flex items-center justify-center w-8 h-8 bg-gray-300 text-gray-700 rounded-full font-bold">
                                                2
                                            </span>
                                        @elseif($index === 2)
                                            <span class="inline-flex items-center justify-center w-8 h-8 bg-orange-300 text-orange-800 rounded-full font-bold">
                                                3
                                            </span>
                                        @else
                                            <span class="text-gray-500">{{ $index + 1 }}</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="font-semibold text-gray-900 dark:text-gray-100">{{ $result['nama'] }}</div>
                                        <div class="text-xs text-gray-500">{{ $result['nip'] }}</div>
                                    </td>
                                    <td class="px-4 py-3 text-center font-mono">{{ number_format($result['q1'], 4) }}</td>
                                    <td class="px-4 py-3 text-center font-mono">{{ number_format($result['q2'], 4) }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="font-bold text-lg {{ $index === 0 ? 'text-green-600 dark:text-green-400' : 'text-indigo-600 dark:text-indigo-400' }}">
                                            {{ number_format($result['qi'], 4) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="mt-6 flex flex-col sm:flex-row justify-between items-center gap-4 p-4 bg-gray-50 dark:bg-gray-700/30 rounded-lg">
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            <span class="font-semibold">{{ count($results) }}</span> kandidat dihitung untuk
                            <span class="font-semibold text-indigo-600 dark:text-indigo-400">
                                {{ $jabatanTargets->find($selectedJabatanId)?->nama_jabatan }}
                            </span>
                        </div>

                        <div class="flex gap-3">
                            <button type="button" wire:click="saveResults"
                                class="inline-flex items-center px-6 py-2.5 bg-green-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-lg hover:shadow-xl">
                                <span wire:loading.remove wire:target="saveResults">
                                    <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                                    </svg>
                                    Simpan Hasil
                                </span>
                                <span wire:loading wire:target="saveResults">
                                    <svg class="animate-spin h-4 w-4 mr-2 inline" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Menyimpan...
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Formula Info --}}
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                <h4 class="font-semibold text-blue-800 dark:text-blue-300 mb-2">Formula WASPAS:</h4>
                <div class="text-sm text-blue-700 dark:text-blue-400 space-y-1 font-mono">
                    <p>Q1 (WSM) = Σ(Rij × Wj) = Sum of normalized values × weights</p>
                    <p>Q2 (WPM) = Π(Rij ^ Wj) = Product of normalized values ^ weights</p>
                    <p>Qi = 0.5 × Q1 + 0.5 × Q2</p>
                </div>
            </div>
        @elseif($isCalculated && count($results) == 0)
            <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-6 text-center">
                <svg class="w-12 h-12 mx-auto text-yellow-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <p class="text-yellow-700 dark:text-yellow-300 font-semibold">Tidak ada data untuk dihitung</p>
                <p class="text-sm text-yellow-600 dark:text-yellow-400 mt-1">Pastikan data kandidat dan penilaian sudah diisi.</p>
            </div>
        @endif

    </div>
</div>
