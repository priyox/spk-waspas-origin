<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Laporan & Dokumentasi Metode WASPAS') }}
    </h2>
</x-slot>

<div class="py-8">
    <div class="w-full px-4 sm:px-6 lg:px-8">

        {{-- Header Section --}}
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl shadow-xl p-8 mb-8 text-white">
            <div class="text-center">
                <h1 class="text-3xl font-bold mb-2">SISTEM PENDUKUNG KEPUTUSAN</h1>
                <h2 class="text-xl font-semibold mb-4">Penentuan Kandidat Jabatan Menggunakan Metode WASPAS</h2>
                <p class="text-indigo-100">Weighted Aggregated Sum Product Assessment</p>
                <div class="mt-4 text-sm text-indigo-200">
                    <p>Dokumen ini berisi penjelasan lengkap mengenai dasar teori, kriteria penilaian,</p>
                    <p>dan proses perhitungan algoritma WASPAS yang diimplementasikan dalam sistem.</p>
                </div>
            </div>
        </div>

        {{-- Table of Contents --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-8">
            <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4 flex items-center">
                <span class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-600 dark:text-indigo-400 mr-3 text-sm">
                    <i class="bi bi-list-ol"></i>
                </span>
                Daftar Isi
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div class="space-y-2">
                    <a href="#pendahuluan" class="block text-indigo-600 dark:text-indigo-400 hover:underline">1. Pendahuluan</a>
                    <a href="#metode-waspas" class="block text-indigo-600 dark:text-indigo-400 hover:underline">2. Metode WASPAS</a>
                    <a href="#kriteria" class="block text-indigo-600 dark:text-indigo-400 hover:underline">3. Kriteria Penilaian</a>
                    <a href="#data-kandidat" class="block text-indigo-600 dark:text-indigo-400 hover:underline">4. Data Kandidat</a>
                    <a href="#perhitungan" class="block text-indigo-600 dark:text-indigo-400 hover:underline">5. Proses Perhitungan</a>
                </div>
                <div class="space-y-2">
                    <a href="#contoh-manual" class="block text-indigo-600 dark:text-indigo-400 hover:underline">6. Contoh Perhitungan Manual</a>
                    <a href="#hasil" class="block text-indigo-600 dark:text-indigo-400 hover:underline">7. Hasil Perangkingan</a>
                    <a href="#implementasi" class="block text-indigo-600 dark:text-indigo-400 hover:underline">8. Implementasi Sistem</a>
                    <a href="#kesimpulan" class="block text-indigo-600 dark:text-indigo-400 hover:underline">9. Kesimpulan</a>
                </div>
            </div>
        </div>

        {{-- Section 1: Pendahuluan --}}
        <div id="pendahuluan" class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-8">
            <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-4 flex items-center">
                <span class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center text-white mr-3 text-sm font-bold">1</span>
                Pendahuluan
            </h3>
            <div class="prose dark:prose-invert max-w-none text-gray-700 dark:text-gray-300">
                <p class="mb-4">
                    <strong>Sistem Pendukung Keputusan (SPK)</strong> atau <em>Decision Support System (DSS)</em> adalah sistem informasi berbasis komputer yang dirancang untuk membantu pengambil keputusan dalam menyelesaikan masalah-masalah semi-terstruktur dan tidak terstruktur.
                </p>
                <p class="mb-4">
                    Dalam konteks penentuan kandidat jabatan, SPK membantu proses seleksi dengan mengolah berbagai kriteria penilaian secara sistematis dan objektif. Sistem ini menggunakan metode <strong>WASPAS (Weighted Aggregated Sum Product Assessment)</strong> sebagai algoritma perhitungannya.
                </p>
                <div class="bg-indigo-50 dark:bg-indigo-900/30 rounded-lg p-4 mt-4">
                    <h4 class="font-semibold text-indigo-800 dark:text-indigo-300 mb-2">Tujuan Sistem:</h4>
                    <ul class="list-disc list-inside space-y-1 text-sm">
                        <li>Memberikan rekomendasi kandidat terbaik berdasarkan kriteria yang telah ditentukan</li>
                        <li>Meminimalisir subjektivitas dalam proses pengambilan keputusan</li>
                        <li>Mempercepat proses analisis dan evaluasi kandidat</li>
                        <li>Menyediakan dokumentasi perhitungan yang transparan dan dapat diaudit</li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Section 2: Metode WASPAS --}}
        <div id="metode-waspas" class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-8">
            <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-4 flex items-center">
                <span class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center text-white mr-3 text-sm font-bold">2</span>
                Metode WASPAS
            </h3>
            <div class="prose dark:prose-invert max-w-none text-gray-700 dark:text-gray-300">
                <h4 class="text-lg font-semibold mb-3">2.1 Definisi</h4>
                <p class="mb-4">
                    <strong>WASPAS (Weighted Aggregated Sum Product Assessment)</strong> adalah metode yang dikembangkan oleh <em>Zavadskas et al.</em> pada tahun 2012. Metode ini merupakan kombinasi unik dari dua model pengambilan keputusan multi-kriteria:
                </p>
                <ul class="list-disc list-inside mb-4 space-y-2">
                    <li><strong>WSM (Weighted Sum Model)</strong> - Model penjumlahan terbobot</li>
                    <li><strong>WPM (Weighted Product Model)</strong> - Model perkalian terbobot</li>
                </ul>

                <h4 class="text-lg font-semibold mb-3">2.2 Kelebihan Metode WASPAS</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div class="bg-green-50 dark:bg-green-900/30 rounded-lg p-4">
                        <h5 class="font-semibold text-green-800 dark:text-green-300 mb-2">Akurasi Tinggi</h5>
                        <p class="text-sm">Kombinasi WSM dan WPM menghasilkan ranking yang lebih akurat dibandingkan metode tunggal.</p>
                    </div>
                    <div class="bg-blue-50 dark:bg-blue-900/30 rounded-lg p-4">
                        <h5 class="font-semibold text-blue-800 dark:text-blue-300 mb-2">Fleksibel</h5>
                        <p class="text-sm">Dapat menangani kriteria benefit (semakin tinggi semakin baik) dan cost (semakin rendah semakin baik).</p>
                    </div>
                    <div class="bg-purple-50 dark:bg-purple-900/30 rounded-lg p-4">
                        <h5 class="font-semibold text-purple-800 dark:text-purple-300 mb-2">Sederhana</h5>
                        <p class="text-sm">Proses perhitungan relatif mudah dipahami dan diimplementasikan.</p>
                    </div>
                    <div class="bg-orange-50 dark:bg-orange-900/30 rounded-lg p-4">
                        <h5 class="font-semibold text-orange-800 dark:text-orange-300 mb-2">Transparan</h5>
                        <p class="text-sm">Setiap langkah perhitungan dapat dilacak dan diverifikasi.</p>
                    </div>
                </div>

                <h4 class="text-lg font-semibold mb-3">2.3 Rumus Matematika</h4>
                <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-6 mb-4 font-mono text-sm overflow-x-auto">
                    <p class="mb-4"><strong>Langkah 1: Normalisasi Matriks</strong></p>
                    <p class="mb-2">Untuk kriteria <span class="text-green-600 dark:text-green-400">Benefit</span>:</p>
                    <p class="text-center text-lg mb-2">r<sub>ij</sub> = x<sub>ij</sub> / max(x<sub>ij</sub>)</p>
                    <p class="mb-2">Untuk kriteria <span class="text-red-600 dark:text-red-400">Cost</span>:</p>
                    <p class="text-center text-lg mb-4">r<sub>ij</sub> = min(x<sub>ij</sub>) / x<sub>ij</sub></p>

                    <p class="mb-4"><strong>Langkah 2: Menghitung Nilai Q</strong></p>
                    <p class="mb-2">WSM (Q<sub>1</sub>):</p>
                    <p class="text-center text-lg mb-2">Q<sub>1</sub> = Σ (r<sub>ij</sub> × w<sub>j</sub>)</p>
                    <p class="mb-2">WPM (Q<sub>2</sub>):</p>
                    <p class="text-center text-lg mb-4">Q<sub>2</sub> = Π (r<sub>ij</sub>)<sup>w<sub>j</sub></sup></p>

                    <p class="mb-4"><strong>Langkah 3: Menghitung Nilai Akhir</strong></p>
                    <p class="text-center text-lg">Q<sub>i</sub> = λ × Q<sub>1</sub> + (1 - λ) × Q<sub>2</sub></p>
                    <p class="text-center text-sm mt-2 text-gray-600 dark:text-gray-400">dimana λ = 0.5 (nilai optimal berdasarkan penelitian)</p>
                </div>

                <div class="bg-yellow-50 dark:bg-yellow-900/30 rounded-lg p-4">
                    <h5 class="font-semibold text-yellow-800 dark:text-yellow-300 mb-2">Keterangan:</h5>
                    <ul class="text-sm space-y-1">
                        <li><strong>x<sub>ij</sub></strong> = Nilai alternatif i pada kriteria j</li>
                        <li><strong>r<sub>ij</sub></strong> = Nilai ternormalisasi</li>
                        <li><strong>w<sub>j</sub></strong> = Bobot kriteria j (dalam desimal)</li>
                        <li><strong>Q<sub>i</sub></strong> = Nilai akhir WASPAS untuk alternatif i</li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Section 3: Kriteria Penilaian --}}
        <div id="kriteria" class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-8">
            <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-4 flex items-center">
                <span class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center text-white mr-3 text-sm font-bold">3</span>
                Kriteria Penilaian
            </h3>

            <p class="text-gray-700 dark:text-gray-300 mb-4">
                Sistem menggunakan <strong>{{ $kriterias->count() }} kriteria</strong> penilaian dengan total bobot 100%. Berikut adalah kriteria yang digunakan:
            </p>

            <div class="overflow-x-auto mb-6">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase">Kode</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase">Kriteria</th>
                            <th class="px-4 py-3 text-center text-xs font-bold text-gray-600 dark:text-gray-300 uppercase">Bobot</th>
                            <th class="px-4 py-3 text-center text-xs font-bold text-gray-600 dark:text-gray-300 uppercase">Jenis</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($kriterias as $kriteria)
                        <tr>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                                    K{{ $kriteria->id }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">{{ $kriteria->kriteria }}</td>
                            <td class="px-4 py-3 text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    {{ $kriteria->bobot }}%
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $kriteria->jenis == 'Benefit' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                    {{ $kriteria->jenis ?? 'Benefit' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">
                                @if(in_array($kriteria->id, [1,2,3,8]))
                                    <span class="text-blue-600 dark:text-blue-400"><i class="bi bi-cpu mr-1"></i> Auto-fill dari data kandidat</span>
                                @elseif(in_array($kriteria->id, [9,10]))
                                    <span class="text-green-600 dark:text-green-400"><i class="bi bi-percent mr-1"></i> Input persentase (0-100%)</span>
                                @else
                                    <span class="text-yellow-600 dark:text-yellow-400"><i class="bi bi-list-check mr-1"></i> Pilihan dropdown (1-5)</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <td colspan="2" class="px-4 py-3 text-sm font-bold text-gray-700 dark:text-gray-300 text-right">Total Bobot:</td>
                            <td class="px-4 py-3 text-center">
                                @php $totalBobot = $kriterias->sum('bobot'); @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold {{ $totalBobot == 100 ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                    {{ $totalBobot }}%
                                </span>
                            </td>
                            <td colspan="2"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-green-50 dark:bg-green-900/30 rounded-lg p-4">
                    <h5 class="font-semibold text-green-800 dark:text-green-300 mb-2"><i class="bi bi-arrow-up-circle mr-1"></i> Kriteria Benefit</h5>
                    <p class="text-sm text-green-700 dark:text-green-400">Semakin tinggi nilai, semakin baik. Contoh: Pendidikan, Pengalaman, SKP.</p>
                    <p class="text-xs mt-2 text-green-600 dark:text-green-500">Rumus: r = nilai / max(nilai)</p>
                </div>
                <div class="bg-red-50 dark:bg-red-900/30 rounded-lg p-4">
                    <h5 class="font-semibold text-red-800 dark:text-red-300 mb-2"><i class="bi bi-arrow-down-circle mr-1"></i> Kriteria Cost</h5>
                    <p class="text-sm text-red-700 dark:text-red-400">Semakin rendah nilai, semakin baik. Contoh: Hukuman Disiplin.</p>
                    <p class="text-xs mt-2 text-red-600 dark:text-red-500">Rumus: r = min(nilai) / nilai</p>
                </div>
            </div>
        </div>

        {{-- Section 4: Data Kandidat --}}
        <div id="data-kandidat" class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-8">
            <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-4 flex items-center">
                <span class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center text-white mr-3 text-sm font-bold">4</span>
                Data Kandidat
            </h3>

            <p class="text-gray-700 dark:text-gray-300 mb-4">
                Terdapat <strong>{{ $kandidats->count() }} kandidat</strong> yang akan dievaluasi dalam sistem ini:
            </p>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase">No</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase">NIP</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase">Nama</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase">Jabatan</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase">Golongan</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase">Pendidikan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($kandidats as $index => $kandidat)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="px-4 py-3 text-gray-500 dark:text-gray-400">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 font-mono text-xs text-gray-600 dark:text-gray-400">{{ $kandidat->nip }}</td>
                            <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $kandidat->nama }}</td>
                            <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $kandidat->jabatan }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                                    {{ $kandidat->golongan->golongan ?? '-' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $kandidat->tingkat_pendidikan->tingkat ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Section 5: Proses Perhitungan --}}
        <div id="perhitungan" class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-8">
            <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-4 flex items-center">
                <span class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center text-white mr-3 text-sm font-bold">5</span>
                Proses Perhitungan WASPAS
            </h3>

            {{-- Jabatan Target Selector --}}
            <div class="bg-indigo-50 dark:bg-indigo-900/30 rounded-lg p-4 mb-6">
                <label class="block text-sm font-semibold text-indigo-800 dark:text-indigo-300 mb-2">
                    <i class="bi bi-briefcase mr-1"></i> Pilih Jabatan Target untuk Melihat Perhitungan:
                </label>
                <select wire:model.live="selectedJabatanId"
                    class="w-full md:w-1/2 px-4 py-3 text-base border-2 border-indigo-300 dark:border-indigo-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-100 transition-colors">
                    <option value="">-- Pilih Jabatan Target --</option>
                    @foreach($jabatanTargets as $jabatan)
                        <option value="{{ $jabatan->id }}">{{ $jabatan->nama_jabatan }} ({{ $jabatan->eselon->eselon ?? '-' }})</option>
                    @endforeach
                </select>
            </div>

            @if($showCalculation)
                {{-- Step 5.1: Matrix Keputusan --}}
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-3 flex items-center">
                        <span class="w-6 h-6 rounded-full bg-blue-500 flex items-center justify-center text-white mr-2 text-xs">5.1</span>
                        Matriks Keputusan (X)
                    </h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                        Matriks keputusan berisi nilai setiap alternatif (kandidat) pada setiap kriteria. Nilai sudah dalam skala 1-5.
                    </p>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                            <thead class="bg-blue-50 dark:bg-blue-900/30">
                                <tr>
                                    <th class="px-3 py-2 text-left text-xs font-bold text-blue-800 dark:text-blue-300 uppercase sticky left-0 bg-blue-50 dark:bg-blue-900/30">Kandidat</th>
                                    @foreach($kriterias as $kriteria)
                                    <th class="px-3 py-2 text-center text-xs font-bold text-blue-800 dark:text-blue-300 uppercase">K{{ $kriteria->id }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($results as $result)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <td class="px-3 py-2 font-medium text-gray-900 dark:text-white sticky left-0 bg-white dark:bg-gray-800 text-xs">
                                        {{ Str::limit($result['kandidat']->nama, 20) }}
                                    </td>
                                    @foreach($kriterias as $kriteria)
                                    <td class="px-3 py-2 text-center text-gray-700 dark:text-gray-300">
                                        {{ $result['matrix'][$kriteria->id] ?? 0 }}
                                    </td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Step 5.2: Min/Max Values --}}
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-3 flex items-center">
                        <span class="w-6 h-6 rounded-full bg-purple-500 flex items-center justify-center text-white mr-2 text-xs">5.2</span>
                        Nilai Min/Max per Kriteria
                    </h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                        Nilai minimum dan maksimum digunakan untuk proses normalisasi.
                    </p>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                            <thead class="bg-purple-50 dark:bg-purple-900/30">
                                <tr>
                                    <th class="px-3 py-2 text-left text-xs font-bold text-purple-800 dark:text-purple-300 uppercase">Nilai</th>
                                    @foreach($kriterias as $kriteria)
                                    <th class="px-3 py-2 text-center text-xs font-bold text-purple-800 dark:text-purple-300 uppercase">K{{ $kriteria->id }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                <tr>
                                    <td class="px-3 py-2 font-medium text-gray-900 dark:text-white">Min</td>
                                    @foreach($kriterias as $kriteria)
                                    <td class="px-3 py-2 text-center text-red-600 dark:text-red-400 font-semibold">
                                        {{ $minMax[$kriteria->id]['min'] ?? 0 }}
                                    </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td class="px-3 py-2 font-medium text-gray-900 dark:text-white">Max</td>
                                    @foreach($kriterias as $kriteria)
                                    <td class="px-3 py-2 text-center text-green-600 dark:text-green-400 font-semibold">
                                        {{ $minMax[$kriteria->id]['max'] ?? 0 }}
                                    </td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Step 5.3: Normalized Matrix --}}
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-3 flex items-center">
                        <span class="w-6 h-6 rounded-full bg-green-500 flex items-center justify-center text-white mr-2 text-xs">5.3</span>
                        Matriks Ternormalisasi (R)
                    </h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                        Normalisasi dilakukan berdasarkan jenis kriteria (Benefit atau Cost). Nilai hasil normalisasi berkisar antara 0 hingga 1.
                    </p>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                            <thead class="bg-green-50 dark:bg-green-900/30">
                                <tr>
                                    <th class="px-3 py-2 text-left text-xs font-bold text-green-800 dark:text-green-300 uppercase sticky left-0 bg-green-50 dark:bg-green-900/30">Kandidat</th>
                                    @foreach($kriterias as $kriteria)
                                    <th class="px-3 py-2 text-center text-xs font-bold text-green-800 dark:text-green-300 uppercase">K{{ $kriteria->id }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($results as $result)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <td class="px-3 py-2 font-medium text-gray-900 dark:text-white sticky left-0 bg-white dark:bg-gray-800 text-xs">
                                        {{ Str::limit($result['kandidat']->nama, 20) }}
                                    </td>
                                    @foreach($kriterias as $kriteria)
                                    <td class="px-3 py-2 text-center text-gray-700 dark:text-gray-300 font-mono text-xs">
                                        {{ number_format($result['normalized'][$kriteria->id] ?? 0, 4) }}
                                    </td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Step 5.4: WSM and WPM Calculation --}}
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-3 flex items-center">
                        <span class="w-6 h-6 rounded-full bg-orange-500 flex items-center justify-center text-white mr-2 text-xs">5.4</span>
                        Perhitungan Q1 (WSM) dan Q2 (WPM)
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div class="bg-blue-50 dark:bg-blue-900/30 rounded-lg p-4">
                            <h5 class="font-semibold text-blue-800 dark:text-blue-300 mb-2">Q1 - Weighted Sum Model (WSM)</h5>
                            <p class="text-sm text-blue-700 dark:text-blue-400">Q1 = Σ(r<sub>ij</sub> × w<sub>j</sub>)</p>
                            <p class="text-xs mt-1 text-blue-600 dark:text-blue-500">Penjumlahan nilai normalisasi × bobot</p>
                        </div>
                        <div class="bg-purple-50 dark:bg-purple-900/30 rounded-lg p-4">
                            <h5 class="font-semibold text-purple-800 dark:text-purple-300 mb-2">Q2 - Weighted Product Model (WPM)</h5>
                            <p class="text-sm text-purple-700 dark:text-purple-400">Q2 = Π(r<sub>ij</sub>)<sup>w<sub>j</sub></sup></p>
                            <p class="text-xs mt-1 text-purple-600 dark:text-purple-500">Perkalian nilai normalisasi pangkat bobot</p>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                            <thead class="bg-orange-50 dark:bg-orange-900/30">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-orange-800 dark:text-orange-300 uppercase">Kandidat</th>
                                    <th class="px-4 py-3 text-center text-xs font-bold text-orange-800 dark:text-orange-300 uppercase">Q1 (WSM)</th>
                                    <th class="px-4 py-3 text-center text-xs font-bold text-orange-800 dark:text-orange-300 uppercase">Q2 (WPM)</th>
                                    <th class="px-4 py-3 text-center text-xs font-bold text-orange-800 dark:text-orange-300 uppercase">Qi = 0.5×Q1 + 0.5×Q2</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($results as $result)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $result['kandidat']->nama }}</td>
                                    <td class="px-4 py-3 text-center font-mono text-blue-600 dark:text-blue-400">{{ number_format($result['q1'], 4) }}</td>
                                    <td class="px-4 py-3 text-center font-mono text-purple-600 dark:text-purple-400">{{ number_format($result['q2'], 4) }}</td>
                                    <td class="px-4 py-3 text-center font-mono font-bold text-orange-600 dark:text-orange-400">{{ number_format($result['qi'], 4) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Section 6: Contoh Perhitungan Manual --}}
                @if(count($results) > 0)
                @php
                    $contoh = $results[0]; // Ambil kandidat pertama sebagai contoh
                    $bobotDecimal = [];
                    foreach($kriterias as $k) {
                        $bobotDecimal[$k->id] = $k->bobot / 100;
                    }
                @endphp
                <div id="contoh-manual" class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-3 flex items-center">
                        <span class="w-8 h-8 rounded-full bg-pink-600 flex items-center justify-center text-white mr-3 text-sm font-bold">6</span>
                        Contoh Perhitungan Manual
                    </h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                        Berikut adalah contoh perhitungan manual untuk kandidat <strong class="text-indigo-600 dark:text-indigo-400">{{ $contoh['kandidat']->nama }}</strong>:
                    </p>

                    {{-- Langkah 1: Data Awal --}}
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-4">
                        <h5 class="font-semibold text-gray-800 dark:text-white mb-3 flex items-center">
                            <span class="w-5 h-5 rounded bg-blue-500 text-white text-xs flex items-center justify-center mr-2">1</span>
                            Data Nilai Awal (Matriks X)
                        </h5>
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm mb-2">
                                <thead>
                                    <tr class="bg-blue-100 dark:bg-blue-900/50">
                                        <th class="px-3 py-2 text-left text-xs font-bold">Kriteria</th>
                                        @foreach($kriterias as $kriteria)
                                        <th class="px-3 py-2 text-center text-xs font-bold">K{{ $kriteria->id }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="px-3 py-2 font-medium">Nilai (x<sub>ij</sub>)</td>
                                        @foreach($kriterias as $kriteria)
                                        <td class="px-3 py-2 text-center font-mono text-blue-600 dark:text-blue-400">
                                            {{ $contoh['matrix'][$kriteria->id] ?? 0 }}
                                        </td>
                                        @endforeach
                                    </tr>
                                    <tr class="bg-gray-100 dark:bg-gray-600">
                                        <td class="px-3 py-2 font-medium">Bobot (w<sub>j</sub>)</td>
                                        @foreach($kriterias as $kriteria)
                                        <td class="px-3 py-2 text-center font-mono">
                                            {{ $kriteria->bobot }}% = {{ number_format($bobotDecimal[$kriteria->id], 2) }}
                                        </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td class="px-3 py-2 font-medium">Jenis</td>
                                        @foreach($kriterias as $kriteria)
                                        <td class="px-3 py-2 text-center">
                                            <span class="text-xs px-2 py-0.5 rounded {{ ($kriteria->jenis ?? 'Benefit') == 'Benefit' ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300' }}">
                                                {{ $kriteria->jenis ?? 'Benefit' }}
                                            </span>
                                        </td>
                                        @endforeach
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Langkah 2: Normalisasi --}}
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-4">
                        <h5 class="font-semibold text-gray-800 dark:text-white mb-3 flex items-center">
                            <span class="w-5 h-5 rounded bg-green-500 text-white text-xs flex items-center justify-center mr-2">2</span>
                            Proses Normalisasi
                        </h5>
                        <div class="space-y-3 text-sm">
                            @foreach($kriterias as $kriteria)
                            @php
                                $val = $contoh['matrix'][$kriteria->id] ?? 0;
                                $norm = $contoh['normalized'][$kriteria->id] ?? 0;
                                $type = strtolower($kriteria->jenis ?? 'benefit');
                                $minVal = $minMax[$kriteria->id]['min'] ?? 0;
                                $maxVal = $minMax[$kriteria->id]['max'] ?? 1;
                            @endphp
                            <div class="flex flex-wrap items-center gap-2 p-2 rounded {{ ($kriteria->jenis ?? 'Benefit') == 'Benefit' ? 'bg-green-50 dark:bg-green-900/30' : 'bg-red-50 dark:bg-red-900/30' }}">
                                <span class="font-semibold w-12">K{{ $kriteria->id }}:</span>
                                @if($type == 'benefit')
                                    <span class="font-mono">r<sub>{{ $kriteria->id }}</sub> = x<sub>ij</sub> / max = {{ $val }} / {{ $maxVal }} = </span>
                                @else
                                    <span class="font-mono">r<sub>{{ $kriteria->id }}</sub> = min / x<sub>ij</sub> = {{ $minVal }} / {{ $val }} = </span>
                                @endif
                                <span class="font-mono font-bold text-green-600 dark:text-green-400">{{ number_format($norm, 4) }}</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">({{ $kriteria->jenis ?? 'Benefit' }})</span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Langkah 3: Perhitungan Q1 (WSM) --}}
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-4">
                        <h5 class="font-semibold text-gray-800 dark:text-white mb-3 flex items-center">
                            <span class="w-5 h-5 rounded bg-blue-500 text-white text-xs flex items-center justify-center mr-2">3</span>
                            Perhitungan Q1 (Weighted Sum Model)
                        </h5>
                        <div class="bg-blue-50 dark:bg-blue-900/30 rounded-lg p-3 mb-3">
                            <p class="font-mono text-sm mb-2">Q1 = Σ (r<sub>ij</sub> × w<sub>j</sub>)</p>
                            <p class="font-mono text-sm">
                                Q1 = @foreach($kriterias as $index => $kriteria)@php $norm = $contoh['normalized'][$kriteria->id] ?? 0; $weight = $bobotDecimal[$kriteria->id]; @endphp({{ number_format($norm, 4) }} × {{ number_format($weight, 2) }})@if($index < count($kriterias) - 1) + @endif @endforeach
                            </p>
                        </div>
                        <div class="overflow-x-auto mb-3">
                            <table class="min-w-full text-xs">
                                <thead>
                                    <tr class="bg-blue-100 dark:bg-blue-900/50">
                                        <th class="px-2 py-1">Kriteria</th>
                                        @foreach($kriterias as $kriteria)
                                        <th class="px-2 py-1 text-center">K{{ $kriteria->id }}</th>
                                        @endforeach
                                        <th class="px-2 py-1 text-center bg-blue-200 dark:bg-blue-800">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="px-2 py-1 font-medium">r × w</td>
                                        @php $totalQ1 = 0; @endphp
                                        @foreach($kriterias as $kriteria)
                                        @php
                                            $norm = $contoh['normalized'][$kriteria->id] ?? 0;
                                            $weight = $bobotDecimal[$kriteria->id];
                                            $wsmVal = $norm * $weight;
                                            $totalQ1 += $wsmVal;
                                        @endphp
                                        <td class="px-2 py-1 text-center font-mono">{{ number_format($wsmVal, 4) }}</td>
                                        @endforeach
                                        <td class="px-2 py-1 text-center font-mono font-bold text-blue-600 dark:text-blue-400 bg-blue-100 dark:bg-blue-800">{{ number_format($totalQ1, 4) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <p class="text-center text-lg font-bold text-blue-600 dark:text-blue-400">
                            Q1 = {{ number_format($contoh['q1'], 4) }}
                        </p>
                    </div>

                    {{-- Langkah 4: Perhitungan Q2 (WPM) --}}
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-4">
                        <h5 class="font-semibold text-gray-800 dark:text-white mb-3 flex items-center">
                            <span class="w-5 h-5 rounded bg-purple-500 text-white text-xs flex items-center justify-center mr-2">4</span>
                            Perhitungan Q2 (Weighted Product Model)
                        </h5>
                        <div class="bg-purple-50 dark:bg-purple-900/30 rounded-lg p-3 mb-3">
                            <p class="font-mono text-sm mb-2">Q2 = Π (r<sub>ij</sub> + ε)<sup>w<sub>j</sub></sup></p>
                            <p class="text-xs text-purple-600 dark:text-purple-400 mb-2">* ε (epsilon) = 0.0001 ditambahkan untuk mencegah hasil 0 jika ada nilai normalisasi = 0</p>
                            <p class="font-mono text-sm">
                                Q2 = @foreach($kriterias as $index => $kriteria)@php $norm = $contoh['normalized'][$kriteria->id] ?? 0; $weight = $bobotDecimal[$kriteria->id]; @endphp({{ number_format($norm, 4) }} + 0.0001)<sup>{{ number_format($weight, 2) }}</sup>@if($index < count($kriterias) - 1) × @endif @endforeach
                            </p>
                        </div>
                        <div class="overflow-x-auto mb-3">
                            <table class="min-w-full text-xs">
                                <thead>
                                    <tr class="bg-purple-100 dark:bg-purple-900/50">
                                        <th class="px-2 py-1">Kriteria</th>
                                        @foreach($kriterias as $kriteria)
                                        <th class="px-2 py-1 text-center">K{{ $kriteria->id }}</th>
                                        @endforeach
                                        <th class="px-2 py-1 text-center bg-purple-200 dark:bg-purple-800">Hasil</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="px-2 py-1 font-medium">(r+ε)<sup>w</sup></td>
                                        @php $productQ2 = 1; @endphp
                                        @foreach($kriterias as $kriteria)
                                        @php
                                            $norm = $contoh['normalized'][$kriteria->id] ?? 0;
                                            $weight = $bobotDecimal[$kriteria->id];
                                            $wpmVal = pow($norm + 0.0001, $weight);
                                            $productQ2 *= $wpmVal;
                                        @endphp
                                        <td class="px-2 py-1 text-center font-mono">{{ number_format($wpmVal, 4) }}</td>
                                        @endforeach
                                        <td class="px-2 py-1 text-center font-mono font-bold text-purple-600 dark:text-purple-400 bg-purple-100 dark:bg-purple-800">{{ number_format($productQ2, 4) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <p class="text-center text-lg font-bold text-purple-600 dark:text-purple-400">
                            Q2 = {{ number_format($contoh['q2'], 4) }}
                        </p>
                    </div>

                    {{-- Langkah 5: Perhitungan Qi --}}
                    <div class="bg-gradient-to-r from-orange-50 to-yellow-50 dark:from-orange-900/30 dark:to-yellow-900/30 rounded-lg p-4">
                        <h5 class="font-semibold text-gray-800 dark:text-white mb-3 flex items-center">
                            <span class="w-5 h-5 rounded bg-orange-500 text-white text-xs flex items-center justify-center mr-2">5</span>
                            Perhitungan Nilai Akhir (Qi)
                        </h5>
                        <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-inner">
                            <p class="font-mono text-center text-lg mb-3">
                                Qi = λ × Q1 + (1 - λ) × Q2
                            </p>
                            <p class="text-center text-sm text-gray-600 dark:text-gray-400 mb-3">
                                dimana λ = 0.5 (nilai optimal)
                            </p>
                            <p class="font-mono text-center text-lg mb-2">
                                Qi = (0.5 × {{ number_format($contoh['q1'], 4) }}) + (0.5 × {{ number_format($contoh['q2'], 4) }})
                            </p>
                            <p class="font-mono text-center text-lg mb-2">
                                Qi = {{ number_format(0.5 * $contoh['q1'], 4) }} + {{ number_format(0.5 * $contoh['q2'], 4) }}
                            </p>
                            <div class="text-center mt-4 p-3 bg-gradient-to-r from-orange-500 to-yellow-500 rounded-lg">
                                <span class="text-white font-bold text-xl">Qi = {{ number_format($contoh['qi'], 4) }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Info Ranking --}}
                    <div class="mt-4 p-3 bg-indigo-50 dark:bg-indigo-900/30 rounded-lg text-sm">
                        <p class="text-indigo-800 dark:text-indigo-300">
                            <i class="bi bi-info-circle mr-1"></i>
                            Proses perhitungan yang sama dilakukan untuk setiap kandidat. Kandidat kemudian diurutkan berdasarkan nilai Qi dari tertinggi ke terendah untuk menentukan ranking.
                        </p>
                    </div>
                </div>
                @endif
            @else
                <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                    <i class="bi bi-calculator text-5xl mb-4 block opacity-50"></i>
                    <p>Pilih jabatan target untuk melihat detail perhitungan WASPAS</p>
                </div>
            @endif
        </div>

        {{-- Section 7: Hasil Perangkingan --}}
        <div id="hasil" class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-8">
            <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-4 flex items-center">
                <span class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center text-white mr-3 text-sm font-bold">7</span>
                Hasil Perangkingan
            </h3>

            @if($showCalculation && count($results) > 0)
                <p class="text-gray-700 dark:text-gray-300 mb-4">
                    Berdasarkan perhitungan WASPAS, berikut adalah hasil perangkingan kandidat untuk jabatan target yang dipilih:
                </p>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gradient-to-r from-indigo-500 to-purple-500">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-bold text-white uppercase">Ranking</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-white uppercase">Kandidat</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-white uppercase">NIP</th>
                                <th class="px-4 py-3 text-center text-xs font-bold text-white uppercase">Q1</th>
                                <th class="px-4 py-3 text-center text-xs font-bold text-white uppercase">Q2</th>
                                <th class="px-4 py-3 text-center text-xs font-bold text-white uppercase">Qi (Nilai Akhir)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($results as $index => $result)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 {{ $index == 0 ? 'bg-yellow-50 dark:bg-yellow-900/20' : '' }}">
                                <td class="px-4 py-3">
                                    @if($index == 0)
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-yellow-400 text-yellow-900 font-bold">
                                            <i class="bi bi-trophy-fill"></i>
                                        </span>
                                    @elseif($index == 1)
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-300 text-gray-700 font-bold">2</span>
                                    @elseif($index == 2)
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-orange-300 text-orange-800 font-bold">3</span>
                                    @else
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 text-gray-600 font-bold dark:bg-gray-700 dark:text-gray-300">{{ $index + 1 }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $result['kandidat']->nama }}</td>
                                <td class="px-4 py-3 font-mono text-sm text-gray-600 dark:text-gray-400">{{ $result['kandidat']->nip }}</td>
                                <td class="px-4 py-3 text-center font-mono text-sm text-gray-700 dark:text-gray-300">{{ number_format($result['q1'], 4) }}</td>
                                <td class="px-4 py-3 text-center font-mono text-sm text-gray-700 dark:text-gray-300">{{ number_format($result['q2'], 4) }}</td>
                                <td class="px-4 py-3 text-center">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold {{ $index == 0 ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200' }}">
                                        {{ number_format($result['qi'], 4) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if(count($results) > 0)
                <div class="mt-6 p-4 bg-green-50 dark:bg-green-900/30 rounded-lg border-l-4 border-green-500">
                    <h4 class="font-bold text-green-800 dark:text-green-300 mb-2"><i class="bi bi-check-circle-fill mr-2"></i>Rekomendasi Sistem</h4>
                    <p class="text-green-700 dark:text-green-400">
                        Berdasarkan hasil perhitungan WASPAS, kandidat dengan nilai tertinggi adalah
                        <strong>{{ $results[0]['kandidat']->nama }}</strong> dengan nilai Qi sebesar
                        <strong>{{ number_format($results[0]['qi'], 4) }}</strong>.
                    </p>
                </div>
                @endif
            @else
                <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                    <i class="bi bi-trophy text-5xl mb-4 block opacity-50"></i>
                    <p>Pilih jabatan target untuk melihat hasil perangkingan</p>
                </div>
            @endif
        </div>

        {{-- Section 8: Implementasi Sistem --}}
        <div id="implementasi" class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-8">
            <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-4 flex items-center">
                <span class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center text-white mr-3 text-sm font-bold">8</span>
                Implementasi Sistem
            </h3>

            <div class="prose dark:prose-invert max-w-none text-gray-700 dark:text-gray-300">
                <h4 class="text-lg font-semibold mb-3">8.1 Teknologi yang Digunakan</h4>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-red-50 dark:bg-red-900/30 rounded-lg p-4 text-center">
                        <div class="text-2xl mb-2">🐘</div>
                        <p class="font-semibold text-red-800 dark:text-red-300">Laravel 10</p>
                        <p class="text-xs text-red-600 dark:text-red-400">PHP Framework</p>
                    </div>
                    <div class="bg-blue-50 dark:bg-blue-900/30 rounded-lg p-4 text-center">
                        <div class="text-2xl mb-2">⚡</div>
                        <p class="font-semibold text-blue-800 dark:text-blue-300">Livewire 3</p>
                        <p class="text-xs text-blue-600 dark:text-blue-400">Reactive UI</p>
                    </div>
                    <div class="bg-cyan-50 dark:bg-cyan-900/30 rounded-lg p-4 text-center">
                        <div class="text-2xl mb-2">🎨</div>
                        <p class="font-semibold text-cyan-800 dark:text-cyan-300">Tailwind CSS</p>
                        <p class="text-xs text-cyan-600 dark:text-cyan-400">Styling</p>
                    </div>
                    <div class="bg-orange-50 dark:bg-orange-900/30 rounded-lg p-4 text-center">
                        <div class="text-2xl mb-2">🐬</div>
                        <p class="font-semibold text-orange-800 dark:text-orange-300">MySQL</p>
                        <p class="text-xs text-orange-600 dark:text-orange-400">Database</p>
                    </div>
                </div>

                <h4 class="text-lg font-semibold mb-3">8.2 Fitur Utama Sistem</h4>
                <ul class="list-disc list-inside space-y-2 mb-6">
                    <li><strong>Manajemen Kandidat:</strong> CRUD data kandidat dengan informasi lengkap</li>
                    <li><strong>Manajemen Kriteria:</strong> Pengaturan kriteria, bobot, dan jenis (Benefit/Cost)</li>
                    <li><strong>Auto-Fill Nilai:</strong> Pengisian otomatis untuk kriteria K1, K2, K3, K8</li>
                    <li><strong>Input Penilaian:</strong> Form input nilai untuk kriteria manual</li>
                    <li><strong>Perhitungan WASPAS:</strong> Proses perhitungan otomatis dengan visualisasi</li>
                    <li><strong>Hasil & Perangkingan:</strong> Tampilan hasil dengan ranking kandidat</li>
                    <li><strong>Laporan:</strong> Dokumentasi lengkap proses perhitungan</li>
                </ul>

                <h4 class="text-lg font-semibold mb-3">8.3 Alur Kerja Sistem</h4>
                <div class="flex flex-wrap items-center justify-center gap-2 mb-6">
                    <span class="px-4 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg text-sm font-medium">Input Data Kandidat</span>
                    <i class="bi bi-arrow-right text-gray-400"></i>
                    <span class="px-4 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg text-sm font-medium">Atur Kriteria & Bobot</span>
                    <i class="bi bi-arrow-right text-gray-400"></i>
                    <span class="px-4 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg text-sm font-medium">Input Penilaian</span>
                    <i class="bi bi-arrow-right text-gray-400"></i>
                    <span class="px-4 py-2 bg-indigo-100 dark:bg-indigo-900 rounded-lg text-sm font-medium text-indigo-800 dark:text-indigo-200">Proses WASPAS</span>
                    <i class="bi bi-arrow-right text-gray-400"></i>
                    <span class="px-4 py-2 bg-green-100 dark:bg-green-900 rounded-lg text-sm font-medium text-green-800 dark:text-green-200">Hasil Ranking</span>
                </div>
            </div>
        </div>

        {{-- Section 9: Kesimpulan --}}
        <div id="kesimpulan" class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-8">
            <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-4 flex items-center">
                <span class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center text-white mr-3 text-sm font-bold">9</span>
                Kesimpulan
            </h3>

            <div class="prose dark:prose-invert max-w-none text-gray-700 dark:text-gray-300">
                <p class="mb-4">
                    Sistem Pendukung Keputusan dengan metode WASPAS telah berhasil diimplementasikan untuk membantu proses penentuan kandidat jabatan. Beberapa kesimpulan yang dapat diambil:
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div class="bg-green-50 dark:bg-green-900/30 rounded-lg p-4">
                        <h5 class="font-semibold text-green-800 dark:text-green-300 mb-2"><i class="bi bi-check-circle mr-2"></i>Kelebihan Sistem</h5>
                        <ul class="text-sm space-y-1 text-green-700 dark:text-green-400">
                            <li>• Proses penilaian lebih objektif dan terukur</li>
                            <li>• Perhitungan dilakukan secara otomatis dan akurat</li>
                            <li>• Hasil dapat dilacak dan diverifikasi</li>
                            <li>• Dokumentasi perhitungan lengkap</li>
                        </ul>
                    </div>
                    <div class="bg-blue-50 dark:bg-blue-900/30 rounded-lg p-4">
                        <h5 class="font-semibold text-blue-800 dark:text-blue-300 mb-2"><i class="bi bi-lightbulb mr-2"></i>Rekomendasi</h5>
                        <ul class="text-sm space-y-1 text-blue-700 dark:text-blue-400">
                            <li>• Hasil SPK sebagai bahan pertimbangan</li>
                            <li>• Keputusan akhir tetap pada pengambil keputusan</li>
                            <li>• Perlu validasi dengan assessment lainnya</li>
                            <li>• Review berkala terhadap bobot kriteria</li>
                        </ul>
                    </div>
                </div>

                <div class="bg-yellow-50 dark:bg-yellow-900/30 rounded-lg p-4 border-l-4 border-yellow-500">
                    <p class="text-sm text-yellow-800 dark:text-yellow-300">
                        <strong><i class="bi bi-exclamation-triangle mr-1"></i>Catatan Penting:</strong>
                        Hasil perhitungan dari Sistem Pendukung Keputusan ini bersifat sebagai rekomendasi dan bahan pertimbangan. Keputusan akhir penentuan jabatan tetap berada pada pihak yang berwenang dengan mempertimbangkan faktor-faktor lain yang mungkin tidak tercakup dalam sistem.
                    </p>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="bg-gray-100 dark:bg-gray-700 rounded-xl p-6 text-center text-gray-600 dark:text-gray-400">
            <p class="text-sm mb-2">
                <strong>Dokumen ini dihasilkan secara otomatis oleh Sistem Pendukung Keputusan</strong>
            </p>
            <p class="text-xs">
                Tanggal: {{ now()->translatedFormat('d F Y, H:i') }} WIB |
                Total Kriteria: {{ $kriterias->count() }} |
                Total Kandidat: {{ $kandidats->count() }}
            </p>
        </div>

    </div>
</div>
