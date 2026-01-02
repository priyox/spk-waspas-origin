<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Kandidat;
use App\Models\Kriteria;
use App\Models\JabatanTarget;
use App\Models\WaspasNilai;
use App\Services\PenilaianAutoFillService;

class WaspasProses extends Component
{
    public $jabatanTargets;
    public $selectedJabatanId = '';
    public $isCalculated = false;
    public $results = [];
    public $normalized = [];
    public $matrix = [];
    public $minMaxValues = [];

    protected $autoFillService;

    public function boot()
    {
        $this->autoFillService = app(PenilaianAutoFillService::class);
    }

    public function mount()
    {
        $this->jabatanTargets = JabatanTarget::all();
    }

    public function updatedSelectedJabatanId()
    {
        $this->isCalculated = false;
        $this->results = [];
        $this->normalized = [];
    }

    /**
     * Proses perhitungan WASPAS
     */
    public function calculate()
    {
        if (!$this->selectedJabatanId) {
            session()->flash('error', 'Pilih jabatan target terlebih dahulu.');
            return;
        }

        // 1. Build Matrix X
        $this->matrix = [];

        // Eager load relations
        $kandidats = Kandidat::with(['knDiklat', 'knSkp', 'knPenghargaan', 'knIntegritas', 'knPotensi', 'knKompetensi'])->get();
        
        $kriterias = Kriteria::orderBy('id')->get();
        $jabatanTarget = JabatanTarget::find($this->selectedJabatanId);

        foreach ($kandidats as $kandidat) {
            // A. Static Criteria (From Kandidat Table)
            // Map Kriteria ID => Relation Name
            $staticMap = [
                5 => 'knSkp', 
                6 => 'knPenghargaan', 
                7 => 'knIntegritas', 
                8 => 'knDiklat',  // ID 8 = Diklat
                9 => 'knPotensi', 
                10 => 'knKompetensi'
            ];

            foreach ($staticMap as $kId => $rel) {
                // Get nilai (1-5) from relation, default to 1 (min) or 0 if missing
                $this->matrix[$kandidat->id][$kId] = $kandidat->$rel->nilai ?? 0;
            }

            // B. Dynamic/Auto-filled Criteria (K1, K2, K3, K8)
            // Uses current logic
            $autoFilledValues = $this->autoFillService->autoFillKandidat($kandidat, $jabatanTarget);
            foreach ($autoFilledValues as $kriteriaId => $nilai) {
                $this->matrix[$kandidat->id][$kriteriaId] = $nilai;
            }
        }

        // 2. Normalize Matrix R
        $this->normalized = [];
        $minMax = [];

        // Find Min/Max for each criteria
        foreach ($kriterias as $kriteria) {
            $values = [];
            foreach ($kandidats as $kandidat) {
                if (isset($this->matrix[$kandidat->id][$kriteria->id])) {
                    $values[] = $this->matrix[$kandidat->id][$kriteria->id];
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
        
        $this->minMaxValues = $minMax;

        // Calculate Normalized values
        foreach ($kandidats as $kandidat) {
            foreach ($kriterias as $kriteria) {
                $val = $this->matrix[$kandidat->id][$kriteria->id] ?? 0;
                $norm = 0;

                $type = strtolower($kriteria->jenis ?? 'benefit');

                if ($type == 'cost') {
                    $norm = ($val != 0) ? ($minMax[$kriteria->id]['min'] / $val) : 0;
                } else {
                    $norm = ($minMax[$kriteria->id]['max'] != 0) ? ($val / $minMax[$kriteria->id]['max']) : 0;
                }

                $this->normalized[$kandidat->id][$kriteria->id] = $norm;
            }
        }

        // 3. Calculate Q Values
        $this->results = [];
        foreach ($kandidats as $kandidat) {
            $q1 = 0; // WSM (Sum)
            $q2 = 1; // WPM (Product)

            foreach ($kriterias as $kriteria) {
                $norm = $this->normalized[$kandidat->id][$kriteria->id] ?? 0;
                $weight = $kriteria->bobot / 100;

                // WSM: Sum (Norm * Weight)
                $q1 += ($norm * $weight);

                // WPM: Product (Norm ^ Weight)
                $q2 *= pow($norm, $weight);
            }

            $qi = (0.5 * $q1) + (0.5 * $q2);

            $this->results[] = [
                'kandidat_id' => $kandidat->id,
                'nip' => $kandidat->nip,
                'nama' => $kandidat->nama,
                'matrix' => $this->matrix[$kandidat->id] ?? [],
                'q1' => $q1,
                'q2' => $q2,
                'qi' => $qi
            ];
        }

        // Sort by Qi Descending
        usort($this->results, function ($a, $b) {
            return $b['qi'] <=> $a['qi'];
        });

        $this->isCalculated = true;
    }

    /**
     * Simpan hasil perhitungan ke database
     */
    public function saveResults()
    {
        if (!$this->isCalculated || empty($this->results)) {
            session()->flash('error', 'Lakukan perhitungan terlebih dahulu.');
            return;
        }

        // Hapus hasil lama untuk jabatan target ini
        WaspasNilai::where('jabatan_target_id', $this->selectedJabatanId)->delete();

        // Simpan hasil baru
        foreach ($this->results as $index => $result) {
            $matrixData = $result['matrix'];

            WaspasNilai::create([
                'jabatan_target_id' => $this->selectedJabatanId,
                'kandidats_id' => $result['kandidat_id'],
                // Bulatkan semua nilai ke 4 desimal
                'pangkat' => round($matrixData[1] ?? 0, 4),
                'masa_jabatan' => round($matrixData[2] ?? 0, 4),
                'tingkat_pendidikan' => round($matrixData[3] ?? 0, 4),
                'diklat' => round($matrixData[8] ?? 0, 4),
                'skp' => round($matrixData[5] ?? 0, 4),
                'penghargaan' => round($matrixData[6] ?? 0, 4),
                'hukdis' => round($matrixData[7] ?? 0, 4),
                'bidang_ilmu' => round($matrixData[4] ?? 0, 4),
                'potensi' => round($matrixData[9] ?? 0, 4),
                'kompetensi' => round($matrixData[10] ?? 0, 4),
                // Bulatkan WSM dan WPM ke 4 desimal
                'wsm' => round($result['q1'], 4),
                'wpm' => round($result['q2'], 4),
            ]);
        }

        session()->flash('message', 'Hasil perhitungan berhasil disimpan.');
        $this->redirect(route('waspas.hasil', ['jabatan' => $this->selectedJabatanId]), navigate: true);
    }

    public function render()
    {
        $kriterias = Kriteria::orderBy('id')->get();
        $kandidats = Kandidat::all();

        return view('livewire.waspas-proses', [
            'kriterias' => $kriterias,
            'kandidats' => $kandidats,
        ])->layout('layouts.app');
    }
}
