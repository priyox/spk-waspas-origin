<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Proses Perhitungan WASPAS') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        
        <!-- Step 1: Matriks Ternormalisasi -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">1. Matriks Ternormalisasi (R)</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 border">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Kandidat</th>
                                @foreach($kriterias as $kriteria)
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                    {{ $kriteria->kriteria }} <br>
                                    <span class="text-xs lowercase text-indigo-400">({{ $kriteria->jenis }})</span>
                                </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($kandidats as $kandidat)
                            <tr>
                                <td class="px-4 py-2 text-sm">{{ $kandidat->nama }}</td>
                                @foreach($kriterias as $kriteria)
                                <td class="px-4 py-2 text-sm">
                                    {{ number_format($normalized[$kandidat->nip][$kriteria->id] ?? 0, 4) }}
                                </td>
                                @endforeach
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{ count($kriterias) + 1 }}" class="px-4 py-2 text-center text-sm">Tidak ada data.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Step 2: Hitung Nilai Q -->
         <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">2. Perhitungan Nilai Q (Qi)</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                     @foreach($results as $result)
                     <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <h4 class="font-semibold text-indigo-600 dark:text-indigo-400 mb-2">{{ $result['nama'] }}</h4>
                        <div class="text-sm space-y-1">
                            <p>Q1 (Sum) = <strong>{{ number_format($result['q1'], 4) }}</strong></p>
                            <p>Q2 (Product) = <strong>{{ number_format($result['q2'], 4) }}</strong></p>
                            <p class="mt-2 text-lg font-bold border-t pt-2">Qi = {{ number_format($result['qi'], 4) }}</p>
                        </div>
                     </div>
                     @endforeach
                </div>
                
                <div class="mt-6 flex justify-end">
                    <a href="{{ route('waspas.hasil') }}" wire:navigate class="px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Lihat Hasil Akhir (Ranking) &rarr;
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
