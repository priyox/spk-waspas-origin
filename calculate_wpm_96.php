<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Kandidat;
use App\Models\Kriteria;
use App\Models\JabatanTarget;
use App\Services\PenilaianAutoFillService;

echo "=== PERHITUNGAN WPM KANDIDAT ID 96 ===\n\n";

// 1. Ambil data kandidat
$kandidat = Kandidat::with(['knDiklat', 'knSkp', 'knPenghargaan', 'knIntegritas', 'knPotensi', 'knKompetensi'])->find(96);

if (!$kandidat) {
    echo "Kandidat dengan ID 96 tidak ditemukan!\n";
    exit;
}

echo "KANDIDAT: {$kandidat->nama} (ID: {$kandidat->id})\n\n";

// 2. Ambil kriteria
$kriterias = Kriteria::orderBy('id')->get();

// 3. Ambil jabatan target pertama
$jabatanTarget = JabatanTarget::first();

// 4. Build Matrix X
$autoFillService = app(PenilaianAutoFillService::class);
$matrix = [];

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

$autoFilledValues = $autoFillService->autoFillKandidat($kandidat, $jabatanTarget);
foreach ($autoFilledValues as $kriteriaId => $nilai) {
    $matrix[$kriteriaId] = $nilai;
}

// 5. Hitung Min/Max dan Normalisasi
$minMax = [];
$allKandidats = Kandidat::with(['knDiklat', 'knSkp', 'knPenghargaan', 'knIntegritas', 'knPotensi', 'knKompetensi'])->get();

// Build matrix untuk semua kandidat
$allMatrix = [];
foreach ($allKandidats as $k) {
    foreach ($staticMap as $kId => $rel) {
        $allMatrix[$k->id][$kId] = $k->$rel->nilai ?? 0;
    }
    $autoVals = $autoFillService->autoFillKandidat($k, $jabatanTarget);
    foreach ($autoVals as $kriteriaId => $nilai) {
        $allMatrix[$k->id][$kriteriaId] = $nilai;
    }
}

// Hitung min/max
foreach ($kriterias as $kriteria) {
    $values = [];
    foreach ($allKandidats as $k) {
        if (isset($allMatrix[$k->id][$kriteria->id])) {
            $values[] = $allMatrix[$k->id][$kriteria->id];
        }
    }
    if (count($values) > 0) {
        $minMax[$kriteria->id]['min'] = min($values);
        $minMax[$kriteria->id]['max'] = max($values);
    } else {
        $minMax[$kriteria->id]['min'] = 0;
        $minMax[$kriteria->id]['max'] = 1;
    }
}

// Normalisasi
$normalized = [];
foreach ($kriterias as $kriteria) {
    $val = $matrix[$kriteria->id];
    $type = strtolower($kriteria->jenis ?? 'benefit');
    
    if ($type == 'cost') {
        $norm = ($val != 0) ? ($minMax[$kriteria->id]['min'] / $val) : 0;
    } else {
        $norm = ($minMax[$kriteria->id]['max'] != 0) ? ($val / $minMax[$kriteria->id]['max']) : 0;
    }
    
    $normalized[$kriteria->id] = $norm;
}

// 6. Hitung WPM
echo "PERHITUNGAN WPM (Q2):\n";
echo str_repeat("=", 80) . "\n\n";

$q2 = 1;
$step = 1;

foreach ($kriterias as $k) {
    $norm = $normalized[$k->id];
    $weight = $k->bobot / 100;
    
    // Hitung pemangkatan
    $base = $norm;
    $powered = pow($base, $weight);
    
    echo "Langkah {$step} - K{$k->id} ({$k->nama}):\n";
    echo "  Bobot: {$k->bobot}% = {$weight}\n";
    echo "  Nilai Ternormalisasi: " . number_format($norm, 10) . "\n";
    echo "  Base: {$norm} = " . number_format($base, 10) . "\n";
    echo "  Pemangkatan: ({$base})^{$weight} = " . number_format($powered, 15) . "\n";
    echo "  Q2 sebelum: " . number_format($q2, 15) . "\n";
    
    $q2 *= $powered;
    
    echo "  Q2 setelah: " . number_format($q2, 15) . "\n";
    echo "\n";
    
    $step++;
}

echo str_repeat("=", 80) . "\n";
echo "HASIL AKHIR WPM (Q2):\n";
echo "Nilai Penuh: " . number_format($q2, 15) . "\n";
echo "Dibulatkan 4 desimal: " . number_format($q2, 4) . "\n";
echo "Dengan round(4): " . round($q2, 4) . "\n";
echo str_repeat("=", 80) . "\n";
