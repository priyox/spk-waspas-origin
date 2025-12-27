<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Hasil Akhir Seleksi') }}
    </h2>
</x-slot>

<div class="py-6">
    <div class="w-full px-4 lg:px-6">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl">
            <div class="p-6">
                {{-- Header & Title --}}
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Laporan Hasil Akhir</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Hasil perankingan metode WASPAS dan analisis syarat jabatan</p>
                    </div>
                    @if(count($results) > 0)
                        <div class="flex items-center gap-2">
                            <a href="{{ route('hasil-akhir.pdf', ['jabatan' => $selectedJabatanId, 'ms_saja' => $showOnlyMS ? 1 : 0]) }}" 
                                target="_blank"
                                class="inline-flex items-center px-4 py-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-600 rounded-xl text-sm font-bold transition-all border border-indigo-100 shadow-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                Cetak PDF
                            </a>
                            @unless(auth()->user()->hasRole('Pimpinan'))
                            <button wire:click="confirmDelete('{{ $selectedJabatanId }}')" class="inline-flex items-center px-4 py-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-xl text-sm font-bold transition-all border border-red-100">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                Hapus Hasil
                            </button>
                            @endunless
                        </div>
                    @endif
                </div>

                {{-- Flash Messages --}}
                @if (session()->has('message'))
                    <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 rounded-xl flex items-center gap-3">
                        <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ session('message') }}</span>
                    </div>
                @endif

                {{-- Select Jabatan --}}
                <div class="mb-8 p-6 bg-gray-50 dark:bg-gray-700/50 rounded-2xl border border-gray-100 dark:border-gray-600 shadow-sm">
                    <label for="selectedJabatanId" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-3 uppercase tracking-wider">
                        Filter Berdasarkan Jabatan Target
                    </label>
                    <select wire:model.live="selectedJabatanId" id="selectedJabatanId"
                        class="w-full px-4 py-3 text-base border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-100 transition-all appearance-none bg-no-repeat bg-right pr-10"
                        style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27%236b7280%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e'); background-size: 1.5em;">
                        <option value="">-- Pilih Jabatan --</option>
                        @foreach($availableJabatans as $target)
                            <option value="{{ $target->id }}">{{ $target->nama_jabatan }}</option>
                        @endforeach
                    </select>

                    {{-- Filters --}}
                    @if($selectedJabatanId)
                        <div class="mt-4 flex items-center gap-6">
                            <label class="relative inline-flex items-center cursor-pointer group">
                                <input type="checkbox" wire:model.live="showOnlyMS" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 dark:peer-focus:ring-indigo-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-indigo-600"></div>
                                <span class="ml-3 text-sm font-bold text-gray-700 dark:text-gray-300 group-hover:text-indigo-600 transition-colors">Tampilkan Yang Memenuhi Syarat Saja (MS & Masih MS)</span>
                            </label>
                        </div>
                    @endif
                </div>

                @if($selectedJabatanId)
                    @if(count($results) > 0)
                        {{-- Results Table --}}
                        <div class="overflow-hidden rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-100 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">Rank</th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">Kandidat</th>
                                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest leading-6">Status Syarat <br> Jabatan</th>
                                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">Skor Qi</th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">Analisis Kelebihan & Kekurangan</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700">
                                    @foreach($results as $res)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors duration-200">
                                            <td class="px-6 py-6 whitespace-nowrap text-center">
                                                @if($res['rank'] <= 3)
                                                    <div class="flex items-center justify-center">
                                                        <span class="flex items-center justify-center w-10 h-10 rounded-full 
                                                            {{ $res['rank'] == 1 ? 'bg-amber-100 text-amber-700 border-2 border-amber-300 shadow-amber-100' : '' }}
                                                            {{ $res['rank'] == 2 ? 'bg-slate-100 text-slate-600 border-2 border-slate-300' : '' }}
                                                            {{ $res['rank'] == 3 ? 'bg-orange-50 text-orange-600 border-2 border-orange-200' : '' }}
                                                            font-bold text-lg shadow-sm">
                                                            {{ $res['rank'] }}
                                                        </span>
                                                    </div>
                                                @else
                                                    <span class="text-gray-500 font-bold">{{ $res['rank'] }}</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-6">
                                                <div class="flex flex-col">
                                                    <span class="text-base font-bold text-gray-900 dark:text-white">{{ $res['nama'] }}</span>
                                                    <span class="text-xs text-gray-500 dark:text-gray-400 tracking-wider">NIP: {{ $res['nip'] }}</span>
                                                    <div class="mt-1 flex items-center gap-1.5">
                                                        <span class="px-2 py-0.5 bg-indigo-50 dark:bg-indigo-900/40 text-indigo-700 dark:text-indigo-400 rounded text-[10px] font-bold uppercase">{{ $res['golongan'] }}</span>
                                                        <span class="px-2 py-0.5 bg-slate-50 dark:bg-slate-700 text-slate-600 dark:text-slate-300 rounded text-[10px] font-bold uppercase">{{ $res['pendidikan'] }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-6 text-center">
                                                @if($res['status_ms'])
                                                    <div class="inline-flex flex-col items-center">
                                                        @if($res['status_label'] == 'Memenuhi Syarat')
                                                            <span class="px-4 py-1.5 bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300 rounded-full text-xs font-bold border border-green-200 dark:border-green-800 flex items-center gap-1.5 shadow-sm shadow-green-100/50">
                                                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                                </svg>
                                                                MS
                                                            </span>
                                                        @else
                                                            <span class="px-4 py-1.5 bg-indigo-100 text-indigo-800 dark:bg-indigo-900/50 dark:text-indigo-300 rounded-full text-xs font-bold border border-indigo-200 dark:border-indigo-800 flex items-center gap-1.5 shadow-sm shadow-indigo-100/50" title="Golongan 1 tingkat dibawah syarat target">
                                                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                                                </svg>
                                                                Masih MS
                                                            </span>
                                                        @endif
                                                    </div>
                                                @else
                                                    <div class="inline-flex flex-col items-center group relative">
                                                        <span class="px-4 py-1.5 bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300 rounded-full text-xs font-bold border border-red-200 dark:border-red-800 flex items-center gap-1.5 cursor-help">
                                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                                            </svg>
                                                            TMS
                                                        </span>
                                                        <div class="hidden group-hover:block absolute z-20 w-48 p-2 mt-1 bg-white dark:bg-gray-700 border border-red-200 dark:border-red-800 rounded-lg shadow-xl text-[10px] text-red-600 dark:text-red-400 -bottom-16">
                                                            <ul class="list-disc list-inside">
                                                                @foreach($res['alasan_tms'] as $alasan)
                                                                    <li>{{ $alasan }}</li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-6 text-center">
                                                <span class="text-lg font-black text-indigo-600 dark:text-indigo-400">{{ $res['qi'] }}</span>
                                            </td>
                                            <td class="px-6 py-6">
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    {{-- Kelebihan --}}
                                                    <div class="flex flex-col gap-1.5">
                                                        <span class="text-[10px] font-bold text-green-600 dark:text-green-500 uppercase tracking-widest flex items-center gap-1">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                                            Kelebihan
                                                        </span>
                                                        <div class="flex flex-wrap gap-1">
                                                            @forelse($res['kelebihan'] as $plus)
                                                                <span class="px-2 py-0.5 bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 border border-green-100 dark:border-green-900/50 rounded text-[9px] font-medium">{{ $plus }}</span>
                                                            @empty
                                                                <span class="text-[9px] text-gray-400 italic">Tidak ada kelebihan dominan</span>
                                                            @endforelse
                                                        </div>
                                                    </div>
                                                    {{-- Kekurangan --}}
                                                    <div class="flex flex-col gap-1.5">
                                                         <span class="text-[10px] font-bold text-amber-600 dark:text-amber-500 uppercase tracking-widest flex items-center gap-1">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M20 12H4"/></svg>
                                                            Kekurangan
                                                        </span>
                                                        <div class="flex flex-wrap gap-1">
                                                            @forelse($res['kekurangan'] as $minus)
                                                                <span class="px-2 py-0.5 bg-amber-50 dark:bg-amber-900/20 text-amber-700 dark:text-amber-400 border border-amber-100 dark:border-amber-900/50 rounded text-[9px] font-medium">{{ $minus }}</span>
                                                            @empty
                                                                <span class="text-[9px] text-gray-400 italic">Tidak ada kekurangan signifikan</span>
                                                            @endforelse
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        {{-- Empty Results --}}
                        <div class="py-20 text-center bg-gray-50 dark:bg-gray-800/50 rounded-2xl border-2 border-dashed border-gray-200 dark:border-gray-700">
                            <i class="bi bi-info-circle text-5xl text-gray-300 dark:text-gray-600 mb-4 block"></i>
                            <h3 class="text-xl font-bold text-gray-700 dark:text-gray-300">Belum Ada Hasil Perhitungan</h3>
                            <p class="text-gray-500 dark:text-gray-400 mt-2">Pastikan jabatan ini telah melewati proses perhitungan WASPAS di menu Perhitungan.</p>
                            <a href="{{ route('waspas.proses') }}" wire:navigate class="mt-6 inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold transition-all shadow-lg hover:shadow-indigo-500/20">
                                Mulai Perhitungan
                                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        </div>
                    @endif
                @else
                    {{-- No Selection --}}
                    <div class="py-20 text-center bg-gray-50 dark:bg-gray-800/50 rounded-2xl border-2 border-dashed border-gray-200 dark:border-gray-700">
                        <i class="bi bi-filter-circle text-5xl text-gray-300 dark:text-gray-600 mb-4 block"></i>
                        <h3 class="text-xl font-bold text-gray-700 dark:text-gray-300">Silakan Pilih Jabatan Target</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2">Gunakan filter di atas untuk melihat laporan hasil akhir seleksi.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Modal Konfirmasi Hapus --}}
    @if($confirmingDeletion)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/40 backdrop-blur-sm transition-opacity" wire:click="cancelDelete"></div>

        <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl transform transition-all max-w-md w-full p-8 animate-in fade-in zoom-in-95">
            <div class="flex items-center justify-center w-14 h-14 mx-auto rounded-full bg-red-100 dark:bg-red-900/30 mb-6">
                <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>

            <h3 class="text-xl font-bold text-gray-900 dark:text-white text-center mb-2">
                Hapus Hasil Perhitungan?
            </h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 text-center mb-8">
                Apakah Anda yakin ingin menghapus hasil perhitungan untuk jabatan ini? Data yang dihapus tidak dapat dikembalikan.
            </p>

            <div class="flex gap-4">
                <button wire:click="cancelDelete" type="button"
                    class="flex-1 px-4 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-bold rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-all">
                    Batal
                </button>
                <button wire:click="deleteResult" type="button"
                    class="flex-1 px-4 py-3 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition-all shadow-lg shadow-red-500/20">
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
