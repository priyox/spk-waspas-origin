<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\JabatanTarget;
use App\Models\WaspasNilai;
use App\Models\Kriteria;
use App\Models\SyaratJabatan;
use App\Models\Kandidat;

class HasilAkhir extends Component
{
    public $jabatanTargets;
    public $selectedJabatanId = '';
    public $results = [];
    public $kriterias;
    public $confirmingDeletion = false;
    public $showOnlyMS = false;
    public $deleteJabatanId = null;

    protected $queryString = [
        'selectedJabatanId' => ['as' => 'jabatan'],
        'showOnlyMS' => ['as' => 'ms_saja']
    ];

    public function mount()
    {
        $this->kriterias = Kriteria::orderBy('id')->get();

        if (request()->has('jabatan')) {
            $this->selectedJabatanId = request()->get('jabatan');
            $this->loadResults();
        }
    }

    public function updatedSelectedJabatanId()
    {
        $this->loadResults();
    }

    public function updatedShowOnlyMS()
    {
        $this->loadResults();
    }

    public function loadResults()
    {
        if (!$this->selectedJabatanId) {
            $this->results = [];
            return;
        }

        // Load directly from stored WASPAS results
        $waspasNilais = WaspasNilai::where('jabatan_target_id', $this->selectedJabatanId)
            ->with(['kandidat.golongan', 'kandidat.tingkat_pendidikan', 'kandidat.eselon', 'kandidat.jabatan_fungsional.jenjang'])
            ->get();

        if ($waspasNilais->isEmpty()) {
            $this->results = [];
            return;
        }

        $jabatanTarget = JabatanTarget::find($this->selectedJabatanId);
        $syarat = SyaratJabatan::where('eselon_id', $jabatanTarget->id_eselon)->first();

        $this->results = $waspasNilais->map(function ($item, $index) use ($syarat, $jabatanTarget) {
            $qi = (0.5 * $item->wsm) + (0.5 * $item->wpm);
            $kandidat = $item->kandidat;

            // MS/TMS Logic (Comparison with Syarat Jabatan)
            $status_ms = true;
            $is_masih_ms = false;
            $alasan_tms = [];
            




            if ($syarat) {
                // 1. Check Golongan (Base Requirement)
                $minGol = $syarat->minimal_golongan_id;
                $syaratGol = $syarat->syarat_golongan_id;

                if ($kandidat->golongan_id < $minGol) {
                    $status_ms = false;
                    $alasan_tms[] = "Golongan ({$kandidat->golongan->golongan}) dibawah batas minimal";
                } elseif ($kandidat->golongan_id < $syaratGol) {
                    $is_masih_ms = true;
                }

                // 2. Check Pendidikan (Base Requirement)
                if ($kandidat->tingkat_pendidikan_id < $syarat->minimal_tingkat_pendidikan_id) {
                    $status_ms = false;
                    $alasan_tms[] = "Pendidikan ({$kandidat->tingkat_pendidikan->tingkat}) dibawah syarat minimum";
                }

                // 3. User Specific Logic: Eselon vs Fungsional vs Pelaksana
                $eselonIds = [20, 30, 40]; // Pimpinan Tinggi, Administrator, Pengawas
                $isStruktural = in_array($kandidat->jenis_jabatan_id, $eselonIds);
                $isFungsional = ($kandidat->jenis_jabatan_id == 2); 
                $isPelaksana = ($kandidat->jenis_jabatan_id == 3);

                if ($isStruktural) {
                    // Rule: If minimal_eselon_id is empty => MS. If filled => Check.
                    if ($syarat->minimal_eselon_id) {
                        // Smaller ID = Higher Rank (e.g. 21 > 41). Candidate ID must be <= Syarat ID.
                        // If candidate has no eselon_id but is structural, that's a data discrepancy, effectively TMS if requirement exists.
                        if (!$kandidat->eselon_id || $kandidat->eselon_id > $syarat->minimal_eselon_id) {
                            $status_ms = false;
                            $alasan_tms[] = "Eselon belum memenuhi syarat";
                        }
                    }
                } 
                elseif ($isFungsional) {
                    // Rule: Check minimal_jenjang_fungsional_id
                    if ($syarat->minimal_jenjang_fungsional_id) {
                         $syaratJenjang = \App\Models\JenjangFungsional::find($syarat->minimal_jenjang_fungsional_id);
                         $kandidatJenjang = $kandidat->jabatan_fungsional?->jenjang;
                         
                         // If candidate has no functional job or no jenjang -> Fail if requirement exists
                         if (!$kandidatJenjang || $kandidatJenjang->tingkat < $syaratJenjang->tingkat) {
                             $status_ms = false;
                             $alasan_tms[] = "Jenjang Fungsional belum memenuhi syarat minimum";
                         }
                    }
                } 
                elseif ($isPelaksana) {
                     // Rule: Pelaksana only for Pengawas (Eselon IV.A / IV.B -> IDs 41, 42)
                     // Check target jabatan's eselon
                     if (!in_array($jabatanTarget->id_eselon, [41, 42])) {
                          $status_ms = false;
                          $alasan_tms[] = "Pelaksana hanya bisa menduduki Jabatan Pengawas";
                     }
                }
            }

            // Final Status Label
            $status_label = 'TMS';
            if ($status_ms) {
                $status_label = $is_masih_ms ? 'Masih Memenuhi Syarat' : 'Memenuhi Syarat';
            }

            // Kelebihan & Kekurangan based on scores stored in waspas_nilais
            $kelebihan = [];
            $kekurangan = [];
            
            $scores = [
                1 => $item->pangkat,
                2 => $item->masa_jabatan,
                3 => $item->tingkat_pendidikan,
                4 => $item->bidang_ilmu,
                5 => $item->skp,
                6 => $item->penghargaan,
                7 => $item->hukdis,
                8 => $item->diklat,
                9 => $item->potensi,
                10 => $item->kompetensi,
            ];

            foreach ($this->kriterias as $k) {
                $score = $scores[$k->id] ?? 0;
                if ($score >= 4) {
                    $kelebihan[] = $k->kriteria;
                } elseif ($score <= 2) {
                    $kekurangan[] = $k->kriteria;
                }
            }



            return [
                'id' => $item->id,
                'nip' => $kandidat->nip ?? '-',
                'nama' => $kandidat->nama ?? '-',
                'qi' => round($qi, 4),
                'rank' => 0,
                'status_ms' => $status_ms,
                'status_label' => $status_label,
                'alasan_tms' => $alasan_tms,
                'kelebihan' => $kelebihan,
                'kekurangan' => $kekurangan,
                'golongan' => $kandidat->golongan->golongan ?? '-',
                'pendidikan' => $kandidat->tingkat_pendidikan->tingkat ?? '-',
            ];
        })->sortByDesc('qi')->values();

        // Filter if showOnlyMS is true
        if ($this->showOnlyMS) {
            $this->results = $this->results->filter(function ($res) {
                return $res['status_ms'] === true;
            });
        }

        $this->results = $this->results->values()->toArray();

        foreach ($this->results as $index => &$res) {
            $res['rank'] = $index + 1;
        }
    }

    public function confirmDelete($jabatanId)
    {
        $this->confirmingDeletion = true;
        $this->deleteJabatanId = $jabatanId;
    }

    public function deleteResult()
    {
        // Pimpinan cannot delete results
        if (auth()->user()->hasRole('Pimpinan')) {
            session()->flash('error', 'Pimpinan hanya memiliki akses view. Tidak dapat menghapus hasil perhitungan.');
            $this->confirmingDeletion = false;
            $this->deleteJabatanId = null;
            return;
        }

        if ($this->deleteJabatanId) {
            WaspasNilai::where('jabatan_target_id', $this->deleteJabatanId)->delete();
            session()->flash('message', 'Hasil perhitungan berhasil dihapus.');
            $this->results = [];
            $this->selectedJabatanId = '';
        }
        $this->confirmingDeletion = false;
        $this->deleteJabatanId = null;
    }

    public function cancelDelete()
    {
        $this->confirmingDeletion = false;
        $this->deleteJabatanId = null;
    }

    public function render()
    {
        // Only show jabatans that have saved results
        $availableJabatans = WaspasNilai::select('jabatan_target_id')
            ->distinct()
            ->with('jabatanTarget')
            ->get()
            ->pluck('jabatanTarget')
            ->filter();

        return view('livewire.hasil-akhir', [
            'availableJabatans' => $availableJabatans
        ])->layout('layouts.app');
    }
}
