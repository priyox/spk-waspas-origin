<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JabatanTarget;
use App\Models\WaspasNilai;
use App\Models\Kriteria;
use App\Models\SyaratJabatan;
use App\Models\JenjangFungsional;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function downloadHasilAkhir(Request $request)
    {
        $jabatanId = $request->query('jabatan');
        $showOnlyMS = $request->query('ms_saja') == '1';

        if (!$jabatanId) {
            return redirect()->back()->with('error', 'Jabatan tidak dipilih.');
        }

        $jabatanTarget = JabatanTarget::with('eselon')->findOrFail($jabatanId);
        $kriterias = Kriteria::orderBy('id')->get();
        $syarat = SyaratJabatan::where('eselon_id', $jabatanTarget->id_eselon)->first();

        $waspasNilais = WaspasNilai::where('jabatan_target_id', $jabatanId)
            ->with(['kandidat.golongan', 'kandidat.tingkat_pendidikan', 'kandidat.eselon', 'kandidat.jabatan_fungsional.jenjang'])
            ->get();

        $results = $waspasNilais->map(function ($item) use ($syarat) {
            $qi = (0.5 * $item->wsm) + (0.5 * $item->wpm);
            $kandidat = $item->kandidat;

            $status_ms = true;
            $is_masih_ms = false;
            $alasan_tms = [];

            if ($syarat) {
                // Golongan
                $minGol = $syarat->minimal_golongan_id;
                $syaratGol = $syarat->syarat_golongan_id;

                if ($kandidat->golongan_id < $minGol) {
                    $status_ms = false;
                    $alasan_tms[] = "Golongan dibawah batas minimal";
                } elseif ($kandidat->golongan_id < $syaratGol) {
                    $is_masih_ms = true;
                }

                // Pendidikan
                if ($kandidat->tingkat_pendidikan_id < $syarat->minimal_tingkat_pendidikan_id) {
                    $status_ms = false;
                    $alasan_tms[] = "Pendidikan dibawah syarat minimum";
                }

                // Manajerial vs Fungsional
                $isFungsional = ($kandidat->jenis_jabatan_id == 2);
                $isManajerial = in_array($kandidat->jenis_jabatan_id, [20, 30, 40]);

                if ($isManajerial) {
                    if ($syarat->minimal_eselon_id) {
                        if (!$kandidat->eselon_id || $kandidat->eselon_id > $syarat->minimal_eselon_id) {
                            $status_ms = false;
                            $alasan_tms[] = "Eselon belum memenuhi syarat";
                        }
                    }
                } elseif ($isFungsional) {
                    if ($syarat->minimal_jenjang_fungsional_id) {
                        $syaratJenjang = JenjangFungsional::find($syarat->minimal_jenjang_fungsional_id);
                        $kandidatJenjang = $kandidat->jabatan_fungsional?->jenjang;
                        if (!$kandidatJenjang || $kandidatJenjang->tingkat < $syaratJenjang->tingkat) {
                            $status_ms = false;
                            $alasan_tms[] = "Jenjang Fungsional belum memenuhi syarat";
                        }
                    }
                }
            }

            $status_label = $status_ms ? ($is_masih_ms ? 'Masih MS' : 'MS') : 'TMS';

            // Kelebihan & Kekurangan
            $kelebihan = [];
            $kekurangan = [];
            $scores = [
                1 => $item->pangkat, 2 => $item->masa_jabatan, 3 => $item->tingkat_pendidikan,
                4 => $item->bidang_ilmu, 5 => $item->skp, 6 => $item->penghargaan,
                7 => $item->hukdis, 8 => $item->diklat, 9 => $item->potensi, 10 => $item->kompetensi,
            ];

            foreach (Kriteria::all() as $k) {
                $score = $scores[$k->id] ?? 0;
                if ($score >= 4) $kelebihan[] = $k->kriteria;
                elseif ($score <= 2) $kekurangan[] = $k->kriteria;
            }

            return [
                'nama' => $kandidat->nama,
                'nip' => $kandidat->nip,
                'golongan' => $kandidat->golongan->golongan ?? '-',
                'pendidikan' => $kandidat->tingkat_pendidikan->tingkat ?? '-',
                'qi' => round($qi, 4),
                'status_ms' => $status_ms,
                'status_label' => $status_label,
                'alasan_tms' => $alasan_tms,
                'kelebihan' => $kelebihan,
                'kekurangan' => $kekurangan,
            ];
        })->sortByDesc('qi');

        if ($showOnlyMS) {
            $results = $results->filter(fn($res) => $res['status_ms']);
        }

        $results = $results->values();

        $pdf = Pdf::loadView('reports.hasil-akhir-pdf', [
            'jabatan' => $jabatanTarget,
            'results' => $results,
            'date' => now()->translatedFormat('d F Y'),
            'syarat' => $syarat
        ]);

        return $pdf->setPaper('a4', 'landscape')->download('Laporan_Hasil_Akhir_' . str_replace(' ', '_', $jabatanTarget->nama_jabatan) . '.pdf');
    }
}
