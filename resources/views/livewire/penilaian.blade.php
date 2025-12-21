<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Penilaian Kandidat') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="mb-8 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl border border-gray-200 dark:border-gray-700">
                    <label for="selectedJabatanId" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Filter Berdasarkan Jabatan Target</label>
                    <select wire:model.live="selectedJabatanId" id="selectedJabatanId" class="w-full md:w-1/2 lg:w-1/3 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-all">
                        <option value="">-- Pilih Semua Jabatan --</option>
                        @foreach($jabatanTargets as $target)
                            <option value="{{ $target->id }}">{{ $target->nama_jabatan }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="overflow-x-auto">
                    <form wire:submit.prevent="save">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-widest border-b border-gray-200 dark:border-gray-600">Nama Kandidat</th>
                                    @foreach($kriterias as $kriteria)
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-widest border-b border-gray-200 dark:border-gray-600">
                                        {{ $kriteria->kriteria }}
                                        <div class="text-[10px] font-medium text-indigo-500 mt-1">Bobot: {{ $kriteria->bobot }}</div>
                                    </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($kandidats as $kandidat)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
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
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <input type="number" step="0.01" 
                                            wire:model.defer="nilais.{{ $kandidat->id }}.{{ $kriteria->id }}"
                                            class="w-20 lg:w-24 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 text-center font-medium transition-all" 
                                            placeholder="0.0">
                                    </td>
                                    @endforeach
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="{{ count($kriterias) + 1 }}" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                                        <div class="flex flex-col items-center">
                                            <i class="bi bi-person-x text-4xl text-gray-300 mb-2"></i>
                                            <p>Tidak ada kandidat @if($selectedJabatanId) yang memenuhi kriteria jabatan ini @endif.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="mt-6 flex justify-end gap-x-3">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <span wire:loading.remove wire:target="save">Simpan Penilaian</span>
                                <span wire:loading wire:target="save">Menyimpan...</span>
                            </button>
                            
                            <a href="{{ route('waspas.proses') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Lanjut ke Perhitungan &rarr;
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
