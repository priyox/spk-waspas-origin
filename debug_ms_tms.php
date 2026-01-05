<?php

use App\Models\JabatanTarget;
use App\Models\SyaratJabatan;
use App\Models\WaspasNilai;
use App\Models\JenjangFungsional;

$jabatanId = 20; // Based on logic, if user said jabatan=3, it might be the ID. But let's check what 3 is.
// Actually user URL is /hasil-akhir?jabatan=3. So id=3.

$jabatan = JabatanTarget::find(3);

if (!$jabatan) {
    echo "Jabatan Target ID 3 not found.\n";
    exit;
}

echo "Jabatan Target: {$jabatan->nama_jabatan} (ID: 3)\n";
echo "Eselon ID: {$jabatan->id_eselon}\n";

$syarat = SyaratJabatan::where('eselon_id', $jabatan->id_eselon)->first();

if (!$syarat) {
    echo "Syarat Jabatan not found for Eselon ID {$jabatan->id_eselon}\n";
} else {
    echo "Syarat Jabatan Found:\n";
    echo " - Min Golongan ID: {$syarat->minimal_golongan_id}\n";
    echo " - Syarat Golongan ID: {$syarat->syarat_golongan_id}\n";
    echo " - Min Tingkat Pendidikan ID: {$syarat->minimal_tingkat_pendidikan_id}\n";
    echo " - Min Jenjang Fungsional ID: {$syarat->minimal_jenjang_fungsional_id}\n";
    
    if ($syarat->minimal_jenjang_fungsional_id) {
        $syaratJenjang = JenjangFungsional::find($syarat->minimal_jenjang_fungsional_id);
        echo "   -> Jenjang Name: {$syaratJenjang->jenjang}, Tingkat: {$syaratJenjang->tingkat}\n";
    }
}

echo "\nChecking Candidates for this Jabatan Target (from WaspasNilai)...\n";

$waspasNilais = WaspasNilai::where('jabatan_target_id', 3)->with('kandidat.jabatan_fungsional.jenjang', 'kandidat.golongan')->get();

foreach ($waspasNilais as $wn) {
    $k = $wn->kandidat;
    echo "\nKandidat: {$k->nama} (NIP: {$k->nip})\n";
    echo " - Jenis Jabatan ID: {$k->jenis_jabatan_id}\n";
    
    $isFungsional = ($k->jenis_jabatan_id == 2);
    echo " - Is Fungsional? " . ($isFungsional ? "YES" : "NO") . "\n";
    
    if ($isFungsional) {
        $kf = $k->jabatan_fungsional;
        if ($kf) {
             echo " - Jabatan Fungsional: {$kf->nama_jabatan}\n";
             $kj = $kf->jenjang;
             if ($kj) {
                 echo " - Jenjang: {$kj->jenjang} (Tingkat: {$kj->tingkat})\n";
                 
                 // Simulate Logic
                 if ($syarat && $syarat->minimal_jenjang_fungsional_id) {
                      $syaratJenjang = JenjangFungsional::find($syarat->minimal_jenjang_fungsional_id);
                      if ($kj->tingkat < $syaratJenjang->tingkat) {
                          echo "   *** RESULT: TMS (Tingkat {$kj->tingkat} < {$syaratJenjang->tingkat}) ***\n";
                      } else {
                          echo "   *** RESULT: MS ***\n";
                      }
                 }
             } else {
                 echo " - Jenjang NOT FOUND on Jabatan Fungsional model\n";
             }
        } else {
            echo " - Jabatan Fungsional Relation is NULL\n";
        }
    }
    
    echo " - Golongan ID: {$k->golongan_id}\n";
    if ($syarat) {
        if ($k->golongan_id < $syarat->minimal_golongan_id) {
             echo "   *** Golongan TMS ***\n";
        }
    }
}
