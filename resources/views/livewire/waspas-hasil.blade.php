<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Hasil Perangkingan WASPAS') }}
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

        {{-- Filter Section --}}
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg no-print">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Filter Hasil Perhitungan</h3>

                <div class="flex flex-col md:flex-row gap-4 items-end">
                    <div class="flex-1">
                        <label for="selectedJabatanId" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Jabatan Target
                        </label>
                        <select wire:model.live="selectedJabatanId" id="selectedJabatanId"
                            class="w-full px-4 py-3 text-base border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-100 transition-colors appearance-none bg-no-repeat bg-right pr-10"
                            style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27%236b7280%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e'); background-size: 1.5em;">
                            <option value="">-- Pilih Jabatan Target --</option>
                            @foreach($jabatanTargets as $target)
                                @php
                                    $hasResult = $availableJabatans->contains('id', $target->id);
                                @endphp
                                <option value="{{ $target->id }}" {{ !$hasResult ? 'disabled' : '' }}>
                                    {{ $target->nama_jabatan }} ({{ $target->eselon->eselon ?? '-' }})
                                    @if(!$hasResult) - Belum ada hasil @endif
                                </option>
                            @endforeach
                        </select>
                    </div>

                    @if($selectedJabatanId && count($results) > 0)
                    <button type="button" wire:click="confirmDelete({{ $selectedJabatanId }})"
                        class="px-6 py-3 bg-red-600 border border-transparent rounded-lg font-semibold text-base text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Hapus Hasil
                    </button>
                    @endif
                </div>

                @if($availableJabatans->isEmpty())
                <div class="mt-4 p-3 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg text-sm text-yellow-700 dark:text-yellow-300">
                    <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    Belum ada hasil perhitungan yang tersimpan. Silakan lakukan perhitungan di halaman
                    <a href="{{ route('waspas.proses') }}" class="underline font-semibold" wire:navigate>Proses WASPAS</a>.
                </div>
                @endif
            </div>
        </div>

        {{-- Results Section --}}
        @if($selectedJabatanId && count($results) > 0)
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                {{-- Header --}}
                <div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            Hasil Perangkingan untuk
                            <span class="text-indigo-600 dark:text-indigo-400">
                                {{ $jabatanTargets->find($selectedJabatanId)?->nama_jabatan }}
                            </span>
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Dihitung pada: {{ \Carbon\Carbon::parse($results[0]['created_at'])->format('d M Y, H:i') }}
                        </p>
                    </div>
                    <button onclick="window.print()"
                        class="no-print px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium transition-colors duration-150 flex items-center">
                        <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        Cetak / Simpan PDF
                    </button>
                </div>

                {{-- Ranking Cards for Top 3 --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    @foreach(array_slice($results, 0, 3) as $index => $result)
                    <div class="relative p-4 rounded-xl border-2 {{ $index === 0 ? 'bg-gradient-to-br from-yellow-50 to-yellow-100 dark:from-yellow-900/20 dark:to-yellow-800/20 border-yellow-400' : ($index === 1 ? 'bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700/50 dark:to-gray-600/50 border-gray-400' : 'bg-gradient-to-br from-orange-50 to-orange-100 dark:from-orange-900/20 dark:to-orange-800/20 border-orange-400') }}">
                        {{-- Rank Badge --}}
                        <div class="absolute -top-3 -left-3">
                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full font-bold text-lg shadow-lg {{ $index === 0 ? 'bg-yellow-400 text-yellow-900' : ($index === 1 ? 'bg-gray-300 text-gray-700' : 'bg-orange-300 text-orange-800') }}">
                                {{ $index + 1 }}
                            </span>
                        </div>

                        <div class="ml-6">
                            <h4 class="font-bold text-gray-900 dark:text-gray-100 text-lg">{{ $result['nama'] }}</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $result['nip'] }}</p>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">{{ $result['jabatan'] }}</p>

                            <div class="mt-3 grid grid-cols-3 gap-2 text-center text-xs">
                                <div class="bg-white/50 dark:bg-gray-800/50 rounded p-1">
                                    <div class="text-gray-500">Q1</div>
                                    <div class="font-mono font-semibold">{{ number_format($result['q1'], 3) }}</div>
                                </div>
                                <div class="bg-white/50 dark:bg-gray-800/50 rounded p-1">
                                    <div class="text-gray-500">Q2</div>
                                    <div class="font-mono font-semibold">{{ number_format($result['q2'], 3) }}</div>
                                </div>
                                <div class="bg-indigo-100 dark:bg-indigo-900/50 rounded p-1">
                                    <div class="text-indigo-600 dark:text-indigo-300">Qi</div>
                                    <div class="font-mono font-bold text-indigo-700 dark:text-indigo-200">{{ number_format($result['qi'], 3) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Full Results Table --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 border">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-center text-xs font-bold text-gray-600 dark:text-gray-300 uppercase">Rank</th>
                                <th class="px-4 py-3 text-center text-xs font-bold text-gray-600 dark:text-gray-300 uppercase">Kandidat</th>
                                <th class="px-4 py-3 text-center text-xs font-bold text-gray-600 dark:text-gray-300 uppercase">Gol.</th>
                                @foreach($kriterias as $kriteria)
                                <th class="px-2 py-3 text-center text-xs font-medium text-gray-500 uppercase" title="{{ $kriteria->kriteria }}">
                                    K{{ $kriteria->id }}
                                </th>
                                @endforeach
                                <th class="px-4 py-3 text-center text-xs font-bold text-gray-600 dark:text-gray-300 uppercase">Q1</th>
                                <th class="px-4 py-3 text-center text-xs font-bold text-gray-600 dark:text-gray-300 uppercase">Q2</th>
                                <th class="px-4 py-3 text-center text-xs font-bold text-gray-600 dark:text-gray-300 uppercase bg-indigo-50 dark:bg-indigo-900/30">Qi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($results as $index => $result)
                            <tr class="{{ $index === 0 ? 'bg-green-50 dark:bg-green-900/20' : '' }}">
                                <td class="px-4 py-3 text-center">
                                    @if($index === 0)
                                        <span class="inline-flex items-center justify-center w-7 h-7 bg-yellow-400 text-yellow-900 rounded-full font-bold text-sm">1</span>
                                    @elseif($index === 1)
                                        <span class="inline-flex items-center justify-center w-7 h-7 bg-gray-300 text-gray-700 rounded-full font-bold text-sm">2</span>
                                    @elseif($index === 2)
                                        <span class="inline-flex items-center justify-center w-7 h-7 bg-orange-300 text-orange-800 rounded-full font-bold text-sm">3</span>
                                    @else
                                        <span class="text-gray-500">{{ $index + 1 }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class="font-semibold text-gray-900 dark:text-gray-100 text-sm">{{ $result['nama'] }}</div>
                                    <div class="text-xs text-gray-500">{{ $result['nip'] }}</div>
                                </td>
                                <td class="px-4 py-3 text-center text-xs">{{ $result['golongan'] }}</td>
                                <td class="px-2 py-3 text-center text-xs bg-blue-50 dark:bg-blue-900/10">{{ $result['pangkat'] }}</td>
                                <td class="px-2 py-3 text-center text-xs bg-blue-50 dark:bg-blue-900/10">{{ $result['masa_jabatan'] }}</td>
                                <td class="px-2 py-3 text-center text-xs bg-blue-50 dark:bg-blue-900/10">{{ $result['tingkat_pendidikan'] }}</td>
                                <td class="px-2 py-3 text-center text-xs">{{ $result['diklat'] }}</td>
                                <td class="px-2 py-3 text-center text-xs">{{ $result['skp'] }}</td>
                                <td class="px-2 py-3 text-center text-xs">{{ $result['penghargaan'] }}</td>
                                <td class="px-2 py-3 text-center text-xs">{{ $result['hukdis'] }}</td>
                                <td class="px-2 py-3 text-center text-xs bg-blue-50 dark:bg-blue-900/10">{{ $result['bidang_ilmu'] }}</td>
                                <td class="px-2 py-3 text-center text-xs">{{ $result['potensi'] }}</td>
                                <td class="px-2 py-3 text-center text-xs">{{ $result['kompetensi'] }}</td>
                                <td class="px-4 py-3 text-center font-mono text-sm">{{ number_format($result['q1'], 4) }}</td>
                                <td class="px-4 py-3 text-center font-mono text-sm">{{ number_format($result['q2'], 4) }}</td>
                                <td class="px-4 py-3 text-center bg-indigo-50 dark:bg-indigo-900/30">
                                    <span class="font-bold text-indigo-700 dark:text-indigo-300">{{ number_format($result['qi'], 4) }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Legend --}}
                <div class="mt-4 p-3 bg-gray-50 dark:bg-gray-700/30 rounded-lg text-xs text-gray-600 dark:text-gray-400">
                    <span class="font-semibold">Keterangan Kriteria:</span>
                    @foreach($kriterias as $kriteria)
                        <span class="ml-2">K{{ $kriteria->id }}: {{ $kriteria->kriteria }}</span>{{ !$loop->last ? ',' : '' }}
                    @endforeach
                    <br class="mt-1">
                    <span class="inline-block mt-1 px-2 py-0.5 bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300 rounded text-[10px]">Biru = Auto-filled</span>
                </div>
            </div>
        </div>
        @elseif($selectedJabatanId && count($results) === 0)
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="text-gray-500 dark:text-gray-400 font-semibold">Belum ada hasil perhitungan untuk jabatan ini.</p>
                <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">Silakan lakukan perhitungan di halaman Proses WASPAS.</p>
                <a href="{{ route('waspas.proses') }}" wire:navigate
                    class="inline-flex items-center mt-4 px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    Hitung WASPAS
                </a>
            </div>
        </div>
        @endif

    </div>

    {{-- Modal Konfirmasi Hapus --}}
    @if($confirmingDeletion)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-black/40 backdrop-blur-sm transition-opacity" wire:click="cancelDelete"></div>

        <div class="relative bg-white dark:bg-gray-800 rounded-xl shadow-2xl transform transition-all max-w-md w-full p-6 animate-in fade-in zoom-in-95">
            {{-- Icon --}}
            <div class="flex items-center justify-center w-12 h-12 mx-auto rounded-full bg-red-100 dark:bg-red-900/30 mb-4">
                <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </div>

            {{-- Content --}}
            <h3 class="text-lg font-bold text-gray-900 dark:text-white text-center mb-2">
                Hapus Hasil Perhitungan
            </h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 text-center mb-6">
                Apakah Anda yakin ingin menghapus hasil perhitungan untuk jabatan ini? Data yang dihapus tidak dapat dikembalikan.
            </p>

            {{-- Buttons --}}
            <div class="flex gap-3">
                <button wire:click="cancelDelete" type="button"
                    class="flex-1 px-4 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                    Batal
                </button>
                <button wire:click="deleteResult" type="button"
                    class="flex-1 px-4 py-2.5 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-colors shadow-lg">
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>
    @endif

    <style>
        @media print {
            .no-print, nav, aside {
                display: none !important;
            }
            body, .min-h-screen {
                background-color: white !important;
            }
            .shadow-sm, .shadow-md, .shadow-lg {
                box-shadow: none !important;
            }
            .dark\:bg-gray-800, .dark\:bg-gray-700, .dark\:bg-gray-900 {
                background-color: white !important;
            }
            .dark\:text-gray-100, .dark\:text-gray-200, .dark\:text-gray-300 {
                color: black !important;
            }
            table {
                border-collapse: collapse;
                width: 100%;
            }
            th, td {
                border: 1px solid #ddd !important;
            }
        }
    </style>
</div>
