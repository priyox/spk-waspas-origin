<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Penilaian Kandidat') }}
    </h2>
</x-slot>

<div class="py-6">
    <div class="w-full px-4 lg:px-6">
        {{-- Flash Messages --}}
        @if (session()->has('message'))
            <div class="mb-4 p-4 bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 rounded-lg flex items-center gap-3">
                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span>{{ session('message') }}</span>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-4 p-4 bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-300 rounded-lg flex items-center gap-3">
                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <span class="font-semibold">{{ session('error') }}</span>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                {{-- Pilih Jabatan Target --}}
                <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl border border-gray-200 dark:border-gray-700">
                    <label for="selectedJabatanId" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Jabatan Target <span class="text-xs font-normal text-gray-500">(menentukan syarat jabatan untuk perhitungan)</span>
                    </label>
                    <select wire:model.live="selectedJabatanId" id="selectedJabatanId"
                        class="w-full px-4 py-3 text-base border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-100 transition-colors appearance-none bg-no-repeat bg-right pr-10"
                        style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27%236b7280%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e'); background-size: 1.5em;">
                        <option value="">-- Pilih Jabatan Target --</option>
                        @foreach($jabatanTargets as $target)
                            <option value="{{ $target->id }}">{{ $target->nama_jabatan }}</option>
                        @endforeach
                    </select>
                    @if($selectedJabatanId)
                        @php
                            $selectedTarget = $jabatanTargets->find($selectedJabatanId);
                            $syarat = \App\Models\SyaratJabatan::where('eselon_id', $selectedTarget?->id_eselon)->first();
                        @endphp
                        @if($syarat)
                        <div class="mt-3 p-3 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg text-xs text-indigo-700 dark:text-indigo-300">
                            <p class="font-semibold mb-1">Syarat Jabatan ({{ $selectedTarget->eselon->eselon ?? '-' }}):</p>
                            <ul class="list-disc list-inside space-y-0.5">
                                <li>Min. Golongan: {{ $syarat->minimalGolongan->golongan ?? '-' }}</li>
                                <li>Min. Pendidikan: {{ $syarat->minimalTingkatPendidikan->tingkat ?? '-' }}</li>
                            </ul>
                        </div>
                        @endif
                    @endif
                </div>

                {{-- Legend Box --}}
                <div class="mb-6 p-5 bg-gradient-to-r from-blue-50 to-green-50 dark:from-gray-700 dark:to-gray-700 rounded-xl border-2 border-gray-200 dark:border-gray-600 shadow-sm">
                    <h3 class="font-bold text-base text-gray-800 dark:text-gray-200 mb-4">Panduan Input Penilaian:</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex items-center gap-3 p-3 bg-blue-100 dark:bg-blue-900/50 rounded-lg">
                            <div class="w-6 h-6 bg-blue-200 dark:bg-blue-800 border-2 border-blue-400 dark:border-blue-600 rounded-lg flex items-center justify-center">
                                <span class="text-blue-700 dark:text-blue-300 text-xs font-bold">A</span>
                            </div>
                            <div>
                                <span class="font-bold text-sm text-blue-800 dark:text-blue-200">Auto-filled (K1-K4)</span>
                                <p class="text-xs text-blue-600 dark:text-blue-300">Pangkat, Masa Jabatan, Pendidikan, Bidang Ilmu</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 p-3 bg-gray-100 dark:bg-gray-700/50 rounded-lg">
                            <div class="w-6 h-6 bg-gray-200 dark:bg-gray-600 border-2 border-gray-400 dark:border-gray-500 rounded-lg flex items-center justify-center">
                                <span class="text-gray-700 dark:text-gray-300 text-xs font-bold">S</span>
                            </div>
                            <div>
                                <span class="font-bold text-sm text-gray-800 dark:text-gray-200">Data Kandidat (K5-K10)</span>
                                <p class="text-xs text-gray-600 dark:text-gray-300">SKP, Penghargaan, Integritas, Diklat, Potensi, Kompetensi</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <form wire:submit.prevent="save">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-center text-base font-bold text-gray-700 dark:text-gray-200 tracking-wide border-b border-gray-200 dark:border-gray-600 sticky left-0 bg-gray-100 dark:bg-gray-700 z-10">
                                        Nama Kandidat
                                    </th>
                                    @foreach($kriterias as $kriteria)
                                    <th scope="col" class="px-4 py-4 text-center text-sm font-bold text-gray-700 dark:text-gray-200 border-b border-gray-200 dark:border-gray-600 min-w-[120px]">
                                        <div class="font-bold">{{ $kriteria->kriteria }}</div>
                                        <div class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 mt-1">Bobot: {{ $kriteria->bobot }}%</div>
                                    </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($kandidats as $kandidat)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap sticky left-0 bg-white dark:bg-gray-800 z-10">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="flex-shrink-0 h-10 w-10 bg-indigo-100 dark:bg-indigo-900/50 rounded-full flex items-center justify-center text-indigo-700 dark:text-indigo-300 font-bold text-lg mb-1">
                                                {{ substr($kandidat->nama, 0, 1) }}
                                            </div>
                                            <div class="text-center">
                                                <div class="text-sm font-semibold text-gray-900 dark:text-gray-100 leading-tight">{{ $kandidat->nama }}</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">NIP: {{ $kandidat->nip }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    @foreach($kriterias as $kriteria)
                                    <td class="px-3 py-4 text-center align-top">
                                        {{-- Auto-filled Kriteria (1,2,3,4) --}}
                                        @if(in_array($kriteria->id, [1,2,3,4]))
                                            @php
                                                $catData = $autoFillCategories[$kandidat->id][$kriteria->id] ?? null;
                                            @endphp
                                            <div class="flex flex-col items-center justify-center gap-1">
                                                <div class="inline-block">
                                                    <input type="number" step="1"
                                                        wire:model.defer="nilais.{{ $kandidat->id }}.{{ $kriteria->id }}"
                                                        class="w-16 py-2 rounded-lg border-2 border-blue-300 dark:border-blue-600 bg-blue-100 dark:bg-blue-900/40 shadow-sm text-lg text-center font-bold text-blue-700 dark:text-blue-300 cursor-not-allowed"
                                                        readonly
                                                        title="Nilai auto-filled berdasarkan data kandidat">
                                                </div>
                                                @if($catData)
                                                <div class="text-xs text-center w-full max-w-[140px] flex flex-col items-center">
                                                    <div class="font-semibold text-blue-700 dark:text-blue-300 leading-tight w-full">{{ $catData['kategori'] }}</div>
                                                    <div class="text-gray-500 dark:text-gray-400 text-[10px] truncate w-full" title="{{ $catData['detail'] }}">{{ $catData['detail'] }}</div>
                                                </div>
                                                @endif
                                            </div>

                                        {{-- Static Kriteria (5,6,7,8,9,10) - Read from relation --}}
                                        @elseif(in_array($kriteria->id, [5,6,7,8,9,10]))
                                            @php
                                                // Map relation dynamically
                                                $map = [
                                                    5 => 'knSkp', 6 => 'knPenghargaan', 
                                                    7 => 'knIntegritas', 8 => 'knDiklat',
                                                    9 => 'knPotensi', 10 => 'knKompetensi'
                                                ];
                                                $rel = $map[$kriteria->id] ?? null;
                                                $kn = $rel ? $kandidat->$rel : null;
                                            @endphp
                                            <div class="flex flex-col items-center gap-1">
                                                @if($kn)
                                                    <div class="w-16 py-2 flex items-center justify-center rounded-lg border-2 border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 shadow-sm text-lg font-bold text-gray-700 dark:text-gray-200" 
                                                        title="Nilai berdasarkan data kandidat">
                                                        {{ $kn->nilai }}
                                                    </div>
                                                    <div class="text-xs text-center max-w-[140px]">
                                                        <div class="font-semibold text-gray-700 dark:text-gray-300">{{ $kn->kategori }}</div>
                                                    </div>
                                                    {{-- Hidden input for form submission --}}
                                                    <input type="hidden" wire:model.defer="nilais.{{ $kandidat->id }}.{{ $kriteria->id }}">
                                                @else
                                                    <div class="w-16 py-2 flex items-center justify-center rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-700 text-gray-400 font-bold">
                                                        -
                                                    </div>
                                                    <div class="text-[10px] text-gray-400 italic">Belum diisi</div>
                                                @endif
                                            </div>

                                        {{-- Default (jika ada kriteria lain yang dinamis manual) --}}
                                        @else
                                            <input type="number" step="0.01"
                                                wire:model.defer="nilais.{{ $kandidat->id }}.{{ $kriteria->id }}"
                                                class="w-24 lg:w-28 px-3 py-2.5 rounded-lg border-2 border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 text-base dark:bg-gray-900 text-center font-semibold transition-all"
                                                placeholder="0.0">
                                        @endif
                                    </td>
                                    @endforeach
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="{{ count($kriterias) + 1 }}" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-16 h-16 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            <p class="font-semibold">Tidak ada kandidat yang tersedia</p>
                                            <p class="text-sm mt-1">Silakan tambahkan data kandidat terlebih dahulu</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>

                        @if(count($kandidats) > 0)
                        <div class="mt-6 p-4 bg-gray-50 dark:bg-gray-700/30 rounded-lg">
                            <div class="text-sm text-gray-600 dark:text-gray-400 text-center mb-4">
                                <span class="font-semibold text-gray-900 dark:text-gray-100">{{ count($kandidats) }}</span> kandidat
                                @if($selectedJabatanId) | Jabatan Target dipilih @endif
                            </div>

                            <div class="flex flex-wrap justify-center gap-3">
                                <button type="submit"
                                    class="inline-flex items-center px-6 py-2.5 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 shadow-lg hover:shadow-xl">
                                    <span wire:loading.remove wire:target="save">
                                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Simpan Penilaian
                                    </span>
                                    <span wire:loading wire:target="save">
                                        <svg class="animate-spin h-4 w-4 mr-2 inline" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Menyimpan...
                                    </span>
                                </button>

                                <a href="{{ route('waspas.proses') }}" wire:navigate
                                    class="inline-flex items-center px-6 py-2.5 bg-gray-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 shadow-lg hover:shadow-xl">
                                    Lanjut ke Perhitungan
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        @endif
                    </form>
                </div>

                {{-- Info Box --}}
                <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                    <div class="flex">
                        <svg class="w-5 h-5 text-blue-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        <div class="text-sm text-blue-700 dark:text-blue-300">
                            <p class="font-semibold mb-1">Catatan Penting:</p>
                            <ul class="list-disc list-inside space-y-1 text-xs">
                                <li>Kriteria <strong>Pangkat, Masa Jabatan, Pendidikan, dan Bidang Ilmu</strong> akan terisi otomatis berdasarkan data kandidat</li>
                                <li>Kriteria <strong>Potensi (K9)</strong> dan <strong>Kompetensi (K10)</strong> input dalam bentuk persentase (0-100)</li>
                                <li>Persentase akan otomatis dikonversi ke skala 1-5 saat disimpan</li>
                                <li>Pastikan semua kriteria terisi sebelum menyimpan</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
