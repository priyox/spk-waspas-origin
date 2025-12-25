<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Input Nilai Kandidat') }}
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

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                
                {{-- Legend Box --}}
                <div class="mb-6 p-5 bg-gradient-to-r from-blue-50 to-green-50 dark:from-gray-700 dark:to-gray-700 rounded-xl border-2 border-gray-200 dark:border-gray-600 shadow-sm">
                    <h3 class="font-bold text-base text-gray-800 dark:text-gray-200 mb-4">Panduan Input Penilaian:</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="flex items-center gap-3 p-3 bg-indigo-100 dark:bg-indigo-900/50 rounded-lg col-span-3 md:col-span-1">
                            <div class="w-6 h-6 bg-indigo-200 dark:bg-indigo-800 border-2 border-indigo-400 dark:border-indigo-600 rounded-lg flex items-center justify-center">
                                <span class="text-indigo-700 dark:text-indigo-300 text-xs font-bold">▼</span>
                            </div>
                            <div>
                                <span class="font-bold text-sm text-indigo-800 dark:text-indigo-200">Pilih Kategori</span>
                                <p class="text-xs text-indigo-600 dark:text-indigo-300">Pilih opsi yang sesuai untuk setiap kriteria.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    {{-- Read-Only Table --}}
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-widest border-b border-gray-200 dark:border-gray-600 sticky left-0 bg-gray-100 dark:bg-gray-700 z-10 w-64">
                                    Nama Kandidat
                                </th>
                                @foreach($kriterias as $kriteria)
                                <th scope="col" class="px-4 py-4 text-center text-sm font-bold text-gray-700 dark:text-gray-200 border-b border-gray-200 dark:border-gray-600 min-w-[100px]">
                                    <div class="font-bold">{{ $kriteria->kriteria }}</div>
                                    <div class="text-[10px] font-semibold text-indigo-600 dark:text-indigo-400 mt-1">Bobot: {{ $kriteria->bobot }}%</div>
                                </th>
                                @endforeach
                                <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-widest border-b border-gray-200 dark:border-gray-600 sticky right-0 bg-gray-100 dark:bg-gray-700 z-10">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($kandidats as $kandidat)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors" wire:key="kandidat-{{ $kandidat->id }}">
                                <td class="px-6 py-4 whitespace-nowrap sticky left-0 bg-white dark:bg-gray-800 z-10">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-indigo-100 dark:bg-indigo-900/50 rounded-full flex items-center justify-center text-indigo-700 dark:text-indigo-300 font-bold text-lg">
                                            {{ substr($kandidat->nama, 0, 1) }}
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $kandidat->nama }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">NIP: {{ $kandidat->nip }}</div>
                                        </div>
                                    </div>
                                </td>

                                @foreach($kriterias as $kriteria)
                                <td class="px-3 py-4 text-center align-middle">
                                    @php
                                        // Retrieve relationship name from the map in component
                                        $rel = $criterionRelationMap[$kriteria->id] ?? null;
                                        // Get the related model if it exists
                                        $kn = $rel ? $kandidat->$rel : null;
                                    @endphp

                                    @if($kn)
                                        <div class="flex flex-col items-center">
                                            <span class="font-bold text-gray-900 dark:text-gray-100 text-sm text-center">
                                                {{ $kn->kategori }}
                                            </span>
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-xs italic">Belum diisi</span>
                                    @endif
                                </td>
                                @endforeach
                                
                                <td class="px-6 py-4 whitespace-nowrap text-center sticky right-0 bg-white dark:bg-gray-800 z-10">
                                    <button wire:click="startEditing('{{ $kandidat->id }}')" 
                                        wire:loading.attr="disabled"
                                        class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm disabled:opacity-50">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Input Nilai
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{ count($kriterias) + 2 }}" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                                    No data available.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- Modal Input Nilai --}}
                    <x-modal name="input-nilai-modal" :show="$isModalOpen" maxWidth="4xl">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-6 border-b pb-4 dark:border-gray-700">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                                    Input Nilai: <span class="text-indigo-600 dark:text-indigo-400">{{ $editingKandidatName }}</span>
                                </h3>
                                <button wire:click="closeModal" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                                    <span class="sr-only">Close</span>
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <form wire:submit.prevent="saveKandidat">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    @foreach($kriterias as $kriteria)
                                        <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg">
                                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                                {{ $kriteria->kriteria }}
                                            </label>
                                            
                                            <select wire:model.defer="editingValues.{{ $kriteria->id }}"
                                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                                                <option value="">-- Pilih Nilai --</option>
                                                @foreach($this->getKriteriaNilaiOptions($kriteria->id) as $opt)
                                                    <option value="{{ $opt['id'] }}">{{ $opt['kategori'] }} (Nilai: {{ $opt['nilai'] }})</option>
                                                @endforeach
                                            </select>

                                            @error("validationErrors.$kriteria->id")
                                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">Wajib diisi.</p>
                                            @enderror
                                        </div>
                                    @endforeach
                                </div>

                                <div class="mt-8 flex justify-end gap-3">
                                    <button type="button" wire:click="closeModal" 
                                        class="px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 font-medium shadow-sm">
                                        Batal
                                    </button>
                                    <button type="submit" 
                                        class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium shadow-sm flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Simpan Nilai
                                    </button>
                                </div>
                            </form>
                        </div>
                    </x-modal>
            </div>
        </div>
    </div>
</div>
