<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Kandidat;
use App\Models\Kriteria;
use App\Models\Nilai;
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

        $kandidats = Kandidat::all();
        $kriterias = Kriteria::orderBy('id')->get();
        $nilais = Nilai::all();
        $jabatanTarget = JabatanTarget::find($this->selectedJabatanId);

        // 1. Build Matrix X
        $this->matrix = [];

        // Fill from database (manual values: K4, K5, K6, K7, K9, K10)
        foreach ($nilais as $nilai) {
            $this->matrix[$nilai->kandidats_id][$nilai->kriteria_id] = $nilai->nilai;
        }

        // Calculate auto-fill values for all kandidats (K1, K2, K3, K8) based on jabatan target
        foreach ($kandidats as $kandidat) {
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
                $q2 *= pow($norm + 0.0001, $weight);
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
                'pangkat' => $matrixData[1] ?? 0,           // K1
                'masa_jabatan' => $matrixData[2] ?? 0,      // K2
                'tingkat_pendidikan' => $matrixData[3] ?? 0, // K3
                'diklat' => $matrixData[4] ?? 0,            // K4
                'skp' => $matrixData[5] ?? 0,               // K5
                'penghargaan' => $matrixData[6] ?? 0,       // K6
                'hukdis' => $matrixData[7] ?? 0,            // K7 (Integritas)
                'bidang_ilmu' => $matrixData[8] ?? 0,       // K8
                'potensi' => $matrixData[9] ?? 0,           // K9
                'kompetensi' => $matrixData[10] ?? 0,       // K10
                'wsm' => $result['q1'],
                'wpm' => $result['q2'],
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
