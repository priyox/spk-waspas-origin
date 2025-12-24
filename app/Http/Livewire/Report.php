<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Kandidat;
use App\Models\Kriteria;
use App\Models\Nilai;
use App\Models\JabatanTarget;
use App\Models\WaspasNilai;
use App\Services\PenilaianAutoFillService;

class Report extends Component
{
    public $jabatanTargets;
    public $selectedJabatanId = '';
    public $kriterias;
    public $kandidats;
    public $matrix = [];
    public $normalized = [];
    public $results = [];
    public $minMax = [];
    public $showCalculation = false;

    protected $autoFillService;

    public function boot()
    {
        $this->autoFillService = app(PenilaianAutoFillService::class);
    }

    public function mount()
    {
        $this->jabatanTargets = JabatanTarget::all();
        $this->kriterias = Kriteria::orderBy('id')->get();
        $this->kandidats = Kandidat::all();

        // Check if jabatan is passed via query string
        if (request()->has('jabatan')) {
            $this->selectedJabatanId = request()->get('jabatan');
            $this->calculate();
        }
    }

    public function updatedSelectedJabatanId()
    {
        if ($this->selectedJabatanId) {
            $this->calculate();
        } else {
            $this->showCalculation = false;
            $this->matrix = [];
            $this->normalized = [];
            $this->results = [];
        }
    }

    /**
     * Proses perhitungan WASPAS dengan detail lengkap
     */
    public function calculate()
    {
        if (!$this->selectedJabatanId) {
            return;
        }

        $nilais = Nilai::all();
        $jabatanTarget = JabatanTarget::find($this->selectedJabatanId);

        // 1. Build Matrix X
        $this->matrix = [];

        // Fill from database (manual values: K4, K5, K6, K7, K9, K10)
        foreach ($nilais as $nilai) {
            $nilaiValue = $nilai->nilai;

            // Konversi K9 dan K10 dari 0-100 ke 1-5 untuk perhitungan
            if (in_array($nilai->kriteria_id, [9, 10])) {
                $nilaiValue = $this->autoFillService->konversiPersentaseKeNilai($nilai->nilai, $nilai->kriteria_id);
            }

            $this->matrix[$nilai->kandidats_id][$nilai->kriteria_id] = $nilaiValue;
        }

        // Calculate auto-fill values for all kandidats (K1, K2, K3, K8)
        foreach ($this->kandidats as $kandidat) {
            $autoFilledValues = $this->autoFillService->autoFillKandidat($kandidat, $jabatanTarget);
            foreach ($autoFilledValues as $kriteriaId => $nilai) {
                $this->matrix[$kandidat->id][$kriteriaId] = $nilai;
            }
        }

        // 2. Find Min/Max for each criteria
        $this->minMax = [];
        foreach ($this->kriterias as $kriteria) {
            $values = [];
            foreach ($this->kandidats as $kandidat) {
                if (isset($this->matrix[$kandidat->id][$kriteria->id])) {
                    $values[] = $this->matrix[$kandidat->id][$kriteria->id];
                }
            }
            if (count($values) > 0) {
                $this->minMax[$kriteria->id] = [
                    'min' => min($values),
                    'max' => max($values)
                ];
            } else {
                $this->minMax[$kriteria->id] = ['min' => 0, 'max' => 1];
            }
        }

        // 3. Calculate Normalized values
        $this->normalized = [];
        foreach ($this->kandidats as $kandidat) {
            foreach ($this->kriterias as $kriteria) {
                $val = $this->matrix[$kandidat->id][$kriteria->id] ?? 0;
                $norm = 0;

                $type = strtolower($kriteria->jenis ?? 'benefit');

                if ($type == 'cost') {
                    $norm = ($val != 0) ? ($this->minMax[$kriteria->id]['min'] / $val) : 0;
                } else {
                    $norm = ($this->minMax[$kriteria->id]['max'] != 0) ? ($val / $this->minMax[$kriteria->id]['max']) : 0;
                }

                $this->normalized[$kandidat->id][$kriteria->id] = round($norm, 4);
            }
        }

        // 4. Calculate Q Values (WSM, WPM, Qi)
        $this->results = [];
        foreach ($this->kandidats as $kandidat) {
            $q1 = 0; // WSM
            $q2 = 1; // WPM
            $q1Details = [];
            $q2Details = [];

            foreach ($this->kriterias as $kriteria) {
                $norm = $this->normalized[$kandidat->id][$kriteria->id] ?? 0;
                $weight = $kriteria->bobot / 100;

                // WSM: Sum (Norm * Weight)
                $wsmValue = $norm * $weight;
                $q1 += $wsmValue;
                $q1Details[$kriteria->id] = round($wsmValue, 4);

                // WPM: Product (Norm ^ Weight)
                $wpmValue = pow($norm + 0.0001, $weight);
                $q2 *= $wpmValue;
                $q2Details[$kriteria->id] = round($wpmValue, 4);
            }

            $qi = (0.5 * $q1) + (0.5 * $q2);

            $this->results[] = [
                'kandidat' => $kandidat,
                'matrix' => $this->matrix[$kandidat->id] ?? [],
                'normalized' => $this->normalized[$kandidat->id] ?? [],
                'q1' => round($q1, 4),
                'q2' => round($q2, 4),
                'qi' => round($qi, 4),
                'q1_details' => $q1Details,
                'q2_details' => $q2Details,
            ];
        }

        // Sort by Qi Descending
        usort($this->results, function ($a, $b) {
            return $b['qi'] <=> $a['qi'];
        });

        // Add ranking
        foreach ($this->results as $index => &$result) {
            $result['rank'] = $index + 1;
        }

        $this->showCalculation = true;
    }

    public function render()
    {
        return view('livewire.report')->layout('layouts.app');
    }
}
