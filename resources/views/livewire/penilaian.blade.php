<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Penilaian Kandidat') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="mb-6 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Input Nilai Kandidat</h3>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Masukkan nilai untuk setiap kandidat berdasarkan kriteria.</p>
                    </div>
                </div>

                @if (session()->has('message'))
                    <div class="mb-4 p-4 text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800">
                        {{ session('message') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <form wire:submit.prevent="save">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama Kandidat</th>
                                    @foreach($kriterias as $kriteria)
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        {{ $kriteria->kriteria }} ({{ $kriteria->bobot }}%)
                                    </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($kandidats as $kandidat)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                        <div class="flex flex-col">
                                            <span>{{ $kandidat->nama }}</span>
                                            <span class="text-xs text-gray-500">{{ $kandidat->nip }}</span>
                                        </div>
                                    </td>
                                    @foreach($kriterias as $kriteria)
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="number" step="0.01" 
                                            wire:model.defer="nilais.{{ $kandidat->nip }}.{{ $kriteria->id }}"
                                            class="w-24 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 text-right" 
                                            placeholder="0">
                                    </td>
                                    @endforeach
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="{{ count($kriterias) + 1 }}" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                        Belum ada data kandidat atau kriteria.
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
