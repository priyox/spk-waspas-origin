<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Kandidat;
use App\Models\Kriteria;
use App\Models\JabatanTarget;
use App\Services\PenilaianAutoFillService;

echo "=== PERHITUNGAN MANUAL WASPAS ===\n\n";

// 1. Ambil data kandidat
$kandidat = Kandidat::with(['knDiklat', 'knSkp', 'knPenghargaan', 'knIntegritas', 'knPotensi', 'knKompetensi', 
                             'golongan', 'tingkat_pendidikan', 'jurusan_pendidikan', 'eselon'])->find(96);

if (!$kandidat) {
    echo "Kandidat dengan ID 96 tidak ditemukan!\n";
    exit;
}

echo "KANDIDAT:\n";
echo "ID: {$kandidat->id}\n";
echo "NIP: {$kandidat->nip}\n";
echo "Nama: {$kandidat->nama}\n";
echo "Golongan: " . ($kandidat->golongan->golongan ?? '-') . "\n";
echo "Pendidikan: " . ($kandidat->tingkat_pendidikan->tingkat ?? '-') . "\n";
echo "TMT Jabatan: {$kandidat->tmt_jabatan}\n\n";

// 2. Ambil kriteria
$kriterias = Kriteria::orderBy('id')->get();
echo "KRITERIA:\n";
foreach ($kriterias as $k) {
    echo "K{$k->id}: {$k->nama} (Bobot: {$k->bobot}%, Jenis: {$k->jenis})\n";
}
echo "\n";

// 3. Ambil jabatan target pertama untuk contoh
$jabatanTarget = JabatanTarget::first();
echo "JABATAN TARGET: " . ($jabatanTarget->nama_jabatan ?? 'N/A') . "\n\n";

// 4. Build Matrix X
$autoFillService = app(PenilaianAutoFillService::class);
$matrix = [];

// Static criteria
$staticMap = [
    5 => 'knSkp', 
    6 => 'knPenghargaan', 
    7 => 'knIntegritas', 
    8 => 'knDiklat',
    9 => 'knPotensi', 
    10 => 'knKompetensi'
];

foreach ($staticMap as $kId => $rel) {
    $matrix[$kId] = $kandidat->$rel->nilai ?? 0;
}

// Dynamic criteria
$autoFilledValues = $autoFillService->autoFillKandidat($kandidat, $jabatanTarget);
foreach ($autoFilledValues as $kriteriaId => $nilai) {
    $matrix[$kriteriaId] = $nilai;
}

echo "MATRIKS KEPUTUSAN (X):\n";
foreach ($kriterias as $k) {
    echo "K{$k->id}: {$matrix[$k->id]}\n";
}
echo "\n";

// 5. Hitung Min/Max (untuk normalisasi, kita asumsikan nilai kandidat ini sebagai contoh)
// Dalam praktiknya, min/max dihitung dari semua kandidat
// Untuk contoh ini, kita gunakan nilai kandidat ini sebagai max
$minMax = [];
foreach ($kriterias as $k) {
    $minMax[$k->id] = [
        'min' => 1, // Asumsi min = 1
        'max' => $matrix[$k->id] // Untuk contoh, gunakan nilai kandidat sebagai max
    ];
}

// 6. Normalisasi
$normalized = [];
echo "NORMALISASI (R):\n";
foreach ($kriterias as $k) {
    $val = $matrix[$k->id];
    $type = strtolower($k->jenis ?? 'benefit');
    
    if ($type == 'cost') {
        $norm = ($val != 0) ? ($minMax[$k->id]['min'] / $val) : 0;
    } else {
        $norm = ($minMax[$k->id]['max'] != 0) ? ($val / $minMax[$k->id]['max']) : 0;
    }
    
    $normalized[$k->id] = $norm;
    echo "R{$k->id}: " . number_format($norm, 10) . " (Jenis: {$type})\n";
}
echo "\n";

// 7. Hitung WSM (Q1)
$q1 = 0;
echo "PERHITUNGAN WSM (Q1):\n";
foreach ($kriterias as $k) {
    $norm = $normalized[$k->id];
    $weight = $k->bobot / 100;
    $contribution = $norm * $weight;
    $q1 += $contribution;
    echo "K{$k->id}: {$norm} × {$weight} = " . number_format($contribution, 10) . "\n";
}
echo "Q1 (WSM) = " . number_format($q1, 10) . "\n\n";

// 8. Hitung WPM (Q2)
$q2 = 1;
echo "PERHITUNGAN WPM (Q2):\n";
foreach ($kriterias as $k) {
    $norm = $normalized[$k->id];
    $weight = $k->bobot / 100;
    $powered = pow($norm, $weight);
    $q2 *= $powered;
    echo "K{$k->id}: {$norm}^{$weight} = " . number_format($powered, 10) . "\n";
}
echo "Q2 (WPM) = " . number_format($q2, 10) . "\n\n";

// 9. Hitung Qi
$qi = (0.5 * $q1) + (0.5 * $q2);
echo "NILAI AKHIR:\n";
echo "Qi = (0.5 × Q1) + (0.5 × Q2)\n";
echo "Qi = (0.5 × " . number_format($q1, 10) . ") + (0.5 × " . number_format($q2, 10) . ")\n";
echo "Qi = " . number_format($qi, 10) . "\n\n";

echo "HASIL PEMBULATAN 4 DESIMAL:\n";
echo "WSM (Q1) = " . number_format($q1, 4) . "\n";
echo "WPM (Q2) = " . number_format($q2, 4) . "\n";
echo "Qi = " . number_format($qi, 4) . "\n";
