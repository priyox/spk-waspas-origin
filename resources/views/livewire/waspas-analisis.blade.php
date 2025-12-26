<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Detail Analisis Perhitungan WASPAS') }}
    </h2>
</x-slot>

<div class="py-8">
    <div class="w-full px-4 sm:px-6 lg:px-8">
        
        {{-- Header Section --}}
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-xl shadow-xl p-8 mb-8 text-white no-print">
            <div class="text-center">
                <h1 class="text-3xl font-bold mb-2">ANALISIS DETAIL PERHITUNGAN</h1>
                <h2 class="text-xl font-semibold mb-4">Metode WASPAS (Weighted Aggregated Sum Product Assessment)</h2>
                <div class="max-w-2xl mx-auto">
                    <label for="jabatan" class="block text-sm font-medium text-blue-100 mb-2">Pilih Jabatan Target untuk Dianalisis</label>
                    <select wire:model.live="selectedJabatanId" id="jabatan" class="w-full text-gray-900 border-0 rounded-lg shadow-sm focus:ring-2 focus:ring-white">
                        <option value="">-- Pilih Jabatan --</option>
                        @foreach($jabatanTargets as $j)
                            <option value="{{ $j->id }}">{{ $j->nama_jabatan }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        @if($selectedJabatanId && !empty($results))

        {{-- 1. Narrative Summary --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-8 border-l-4 border-indigo-500">
            <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-4 flex items-center">
                <span class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-600 dark:text-indigo-400 mr-3 text-sm">
                    <i class="bi bi-file-text"></i>
                </span>
                Kesimpulan & Analisis
            </h3>
            <div class="prose dark:prose-invert max-w-none text-gray-700 dark:text-gray-300">
                <p class="mb-2 text-lg">{!! $topCandidateAnalysis !!}</p>
                <p>{!! $gapAnalysis !!}</p>
            </div>
        </div>

        {{-- 2. Matrix X --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-8">
            <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-4 flex items-center">
                <span class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white mr-3 text-sm font-bold">1</span>
                Matriks Data Awal (X) & Nilai Min/Max
            </h3>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-center border-collapse">
                    <thead class="bg-blue-50 dark:bg-blue-900/30">
                        <tr>
                            <th class="p-3 text-left">Nama Kandidat</th>
                            @foreach($kriterias as $k)
                                <th class="p-3 border-l border-blue-100 dark:border-blue-800" title="{{ $k->kriteria }}">K{{ $k->id }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($matrixX as $row)
                        <tr>
                            <td class="p-3 text-left font-medium">{{ $row['nama'] }}</td>
                            @foreach($kriterias as $k)
                                <td class="p-3 border-l border-gray-100 dark:border-gray-700">{{ $row['scores'][$k->id] }}</td>
                            @endforeach
                        </tr>
                        @endforeach
                        <tr class="bg-blue-50 dark:bg-blue-900/20 font-bold border-t-2 border-blue-200 dark:border-blue-700">
                            <td class="p-3 text-left text-blue-700 dark:text-blue-300">Nilai Max (Xmax)</td>
                            @foreach($kriterias as $k)
                                <td class="p-3 border-l border-blue-200 dark:border-blue-700">{{ $maxValues[$k->id] }}</td>
                            @endforeach
                        </tr>
                         <tr class="bg-red-50 dark:bg-red-900/20 font-bold border-t border-red-200 dark:border-red-700">
                            <td class="p-3 text-left text-red-700 dark:text-red-300">Nilai Min (Xmin)</td>
                            @foreach($kriterias as $k)
                                <td class="p-3 border-l border-red-200 dark:border-red-700">{{ $minValues[$k->id] }}</td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
            <p class="text-xs text-gray-500 mt-2">Nilai Max digunakan untuk normalisasi kriteria Benefit, sedangkan Nilai Min untuk kriteria Cost.</p>
        </div>

        {{-- NEW: Kategori Konversi --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-8">
            <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-4 flex items-center">
                <span class="w-8 h-8 rounded-full bg-cyan-600 flex items-center justify-center text-white mr-3 text-sm font-bold">1b</span>
                Konversi Kategori Nilai
            </h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Tabel ini menunjukkan arti deskriptif dari setiap nilai numerik yang diperoleh kandidat.</p>
            <div class="overflow-x-auto">
                <table class="min-w-full text-xs text-center border-collapse">
                    <thead class="bg-cyan-50 dark:bg-cyan-900/30">
                        <tr>
                            <th class="p-2 text-left">Nama Kandidat</th>
                            @foreach($kriterias as $k)
                                <th class="p-2 border-l border-cyan-100 dark:border-cyan-800 w-24">{{ $k->kriteria }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($matrixX as $row)
                        <tr>
                            <td class="p-2 text-left font-medium whitespace-nowrap">{{ $row['nama'] }}</td>
                            @foreach($kriterias as $k)
                                <td class="p-2 border-l border-gray-100 dark:border-gray-700 overflow-hidden text-ellipsis" title="{{ $row['categories'][$k->id] ?? '-' }}">
                                    {{ Str::limit($row['categories'][$k->id] ?? '-', 20) }}
                                </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- 3. Matrix R --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-8">
            <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-4 flex items-center">
                <span class="w-8 h-8 rounded-full bg-green-600 flex items-center justify-center text-white mr-3 text-sm font-bold">2</span>
                Matriks Normalisasi (R)
            </h3>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-center border-collapse">
                    <thead class="bg-green-50 dark:bg-green-900/30">
                        <tr>
                            <th class="p-3 text-left">Nama Kandidat</th>
                            @foreach($kriterias as $k)
                                <th class="p-3 border-l border-green-100 dark:border-green-800">R{{ $k->id }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($results as $row)
                        <tr>
                            <td class="p-3 text-left font-medium">{{ $row['nama'] }}</td>
                            @foreach($kriterias as $k)
                                <td class="p-3 border-l border-gray-100 dark:border-gray-700">{{ number_format($row['normalized'][$k->id], 4) }}</td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- 4. NEW: All Candidate Detail Calculation --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-8">
            <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-4 flex items-center">
                <span class="w-8 h-8 rounded-full bg-purple-600 flex items-center justify-center text-white mr-3 text-sm font-bold">3</span>
                Detail Perhitungan WSM & WPM Tiap Kandidat
            </h3>
            
            <div class="space-y-6">
                @foreach($results as $index => $row)
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                    <div class="bg-gray-50 dark:bg-gray-700 px-4 py-2 flex justify-between items-center cursor-pointer" x-data="{ open: {{ $index < 3 ? 'true' : 'false' }} }" @click="open = !open">
                        <span class="font-bold text-gray-800 dark:text-gray-200">#{{ $index+1 }} {{ $row['nama'] }} (Qi: {{ number_format($row['qi'], 4) }})</span>
                        <span x-show="!open"><i class="bi bi-chevron-down"></i></span>
                        <span x-show="open"><i class="bi bi-chevron-up"></i></span>
                    </div>
                    
                    <div class="p-4 bg-white dark:bg-gray-800" x-data="{ open: {{ $index < 3 ? 'true' : 'false' }} }" x-show="open">
                        
                        {{-- Normalization Detail --}}
                        <div class="mb-4 bg-gray-50 dark:bg-gray-700/50 p-3 rounded text-xs border border-gray-100 dark:border-gray-600">
                            <h5 class="font-bold text-gray-700 dark:text-gray-300 mb-2 uppercase">Langkah 1: Normalisasi (R)</h5>
                            <div class="grid grid-cols-2 md:grid-cols-5 gap-2">
                                @foreach($kriterias as $k)
                                    <div class="p-1 border bg-white dark:bg-gray-800 rounded">
                                        <div class="text-[10px] text-gray-500 font-bold mb-0.5" title="{{ $k->kriteria }}">K{{ $k->id }} ({{ $k->jenis }})</div>
                                        <div class="font-mono text-gray-800 dark:text-gray-200">
                                            {{ $row['calc_details']['norm_formulas'][$k->id]['formula'] }}
                                        </div>
                                        <div class="font-mono font-bold text-green-600">
                                            = {{ $row['calc_details']['norm_formulas'][$k->id]['result'] }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- WSM Detail --}}
                        <div class="mb-4">
                            <h5 class="text-sm font-bold text-blue-700 dark:text-blue-400 mb-2">Langkah 2: Q1 (WSM) = Σ (Normalisasi × Bobot)</h5>
                            <div class="text-xs font-mono bg-blue-50 dark:bg-blue-900/10 p-2 rounded text-gray-700 dark:text-gray-300 leading-relaxed break-words">
                                Q1 = 
                                @foreach($kriterias as $k)
                                    ({{ $row['calc_details']['wsm_terms'][$k->id]['term'] }})@if(!$loop->last) + @endif
                                @endforeach
                                <br>= <strong>{{ number_format($row['wsm'], 4) }}</strong>
                            </div>
                        </div>

                        {{-- WPM Detail --}}
                        <div>
                            <h5 class="text-sm font-bold text-purple-700 dark:text-purple-400 mb-2">Langkah 3: Q2 (WPM) = Π (Normalisasi ^ Bobot)</h5>
                            <div class="text-xs font-mono bg-purple-50 dark:bg-purple-900/10 p-2 rounded text-gray-700 dark:text-gray-300 leading-relaxed break-words">
                                Q2 = 
                                @foreach($kriterias as $k)
                                    {{ $row['calc_details']['wpm_terms'][$k->id]['term'] }}@if(!$loop->last) × @endif
                                @endforeach
                                <br>= <strong>{{ number_format($row['wpm'], 4) }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- 5. Final Ranking Table --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-8">
            <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-4 flex items-center">
                <span class="w-8 h-8 rounded-full bg-orange-600 flex items-center justify-center text-white mr-3 text-sm font-bold">4</span>
                Ranking Akhir
            </h3>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-center border-collapse">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th class="p-3 text-center">Rank</th>
                            <th class="p-3 text-left">Nama Kandidat</th>
                            <th class="p-3">Q1 (WSM)</th>
                            <th class="p-3">Q2 (WPM)</th>
                            <th class="p-3 bg-orange-50 dark:bg-orange-900/30 font-bold border-l border-orange-100">Qi (Total)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($results as $index => $row)
                        <tr class="{{ $index == 0 ? 'bg-yellow-50 dark:bg-yellow-900/10' : '' }}">
                            <td class="p-3 font-bold">
                                @if($index < 3)
                                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full {{ $index==0 ? 'bg-yellow-400 text-yellow-900' : ($index==1 ? 'bg-gray-300' : 'bg-orange-300') }}">{{ $index + 1 }}</span>
                                @else
                                    {{ $index + 1 }}
                                @endif
                            </td>
                            <td class="p-3 text-left font-medium">{{ $row['nama'] }}</td>
                            <td class="p-3">{{ number_format($row['wsm'], 4) }}</td>
                            <td class="p-3">{{ number_format($row['wpm'], 4) }}</td>
                            <td class="p-3 bg-orange-50 dark:bg-orange-900/20 font-bold text-orange-700 dark:text-orange-300 border-l border-orange-100 dark:border-orange-800">{{ number_format($row['qi'], 4) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @elseif($selectedJabatanId)
            <div class="p-12 text-center bg-white dark:bg-gray-800 rounded-xl shadow-sm">
                <span class="block text-4xl mb-4">📭</span>
                <p class="text-gray-500 text-lg">Belum ada data hasil perhitungan untuk jabatan ini.</p>
                <p class="text-gray-400 text-sm mt-2">Pastikan proses perhitungan WASPAS telah dijalankan.</p>
            </div>
        @else
            <div class="p-12 text-center bg-white dark:bg-gray-800 rounded-xl shadow-sm">
                <span class="block text-4xl mb-4">🔍</span>
                <p class="text-gray-500 text-lg">Silakan pilih Jabatan Target di atas untuk memulai analisis.</p>
            </div>
        @endif
        
    </div>
</div>
