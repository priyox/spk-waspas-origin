<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\JabatanTarget;
use App\Models\WaspasNilai;
use App\Models\Kriteria;

class WaspasAnalisis extends Component
{
    public $jabatanTargets;
    public $selectedJabatanId = '';
    public $results = [];
    public $matrixX = [];
    public $matrixR = [];
    public $maxValues = [];
    public $minValues = [];
    public $scoreDescriptions = [];
    public $kriterias = [];

    // Analysis Texts
    public $topCandidateAnalysis = '';
    public $gapAnalysis = '';
    
    protected $queryString = ['selectedJabatanId' => ['as' => 'jabatan']];

    public function mount()
    {
        $this->jabatanTargets = JabatanTarget::all();
        $this->kriterias = Kriteria::orderBy('id')->get();
        // Pre-load score descriptions
        $this->loadScoreDescriptions();

        if (request()->has('jabatan')) {
            $this->selectedJabatanId = request()->get('jabatan');
            $this->loadAnalysis();
        }
    }

    private function loadScoreDescriptions()
    {
        $kriteriaNilais = \App\Models\KriteriaNilai::all();
        foreach ($kriteriaNilais as $kn) {
            // Mapping: kriteria_id -> nilai -> kategori
            $this->scoreDescriptions[$kn->kriteria_id][$kn->nilai] = $kn->kategori;
        }
    }

    public function updatedSelectedJabatanId()
    {
        $this->loadAnalysis();
    }

    public function loadAnalysis()
    {
        if (!$this->selectedJabatanId) {
            $this->resetAnalysis();
            return;
        }

        $waspasNilais = WaspasNilai::where('jabatan_target_id', $this->selectedJabatanId)
            ->with(['kandidat.golongan'])
            ->get();

        if ($waspasNilais->isEmpty()) {
            $this->resetAnalysis();
            return;
        }

        // 1. Prepare Matrix X (Raw Data)
        $this->matrixX = [];
        $this->maxValues = [];
        $this->minValues = [];
        
        // Initialize max/min values
        foreach ($this->kriterias as $k) {
            $this->maxValues[$k->id] = -INF;
            $this->minValues[$k->id] = INF;
        }

        foreach ($waspasNilais as $nilai) {
            $row = [
                'nama' => $nilai->kandidat->nama ?? '-',
                'nip' => $nilai->kandidat->nip ?? '-', // Added NIP
                'wsm' => $nilai->wsm,
                'wpm' => $nilai->wpm,
                'qi' => (0.5 * $nilai->wsm) + (0.5 * $nilai->wpm),
                'scores' => [],
                'categories' => [] // Store text descriptions
            ];

            // Mapping scores based on Kriteria Order
            $scoreMap = [
                1 => $nilai->pangkat,
                2 => $nilai->masa_jabatan,
                3 => $nilai->tingkat_pendidikan,
                4 => $nilai->bidang_ilmu,
                5 => $nilai->skp,
                6 => $nilai->penghargaan,
                7 => $nilai->hukdis,
                8 => $nilai->diklat,
                9 => $nilai->potensi,
                10 => $nilai->kompetensi
            ];

            foreach ($this->kriterias as $k) {
                $val = $scoreMap[$k->id] ?? 0;
                $row['scores'][$k->id] = $val;
                
                // Map to category
                $row['categories'][$k->id] = $this->getCategory($k->id, $val);

                if ($val > $this->maxValues[$k->id]) {
                    $this->maxValues[$k->id] = $val;
                }
                if ($val < $this->minValues[$k->id]) {
                    $this->minValues[$k->id] = $val;
                }
            }
            $this->matrixX[] = $row;
        }

        // 2. Prepare Matrix R (Normalized)
        $this->matrixR = [];
        foreach ($this->matrixX as $xRow) {
            $rRow = $xRow;
            $rRow['normalized'] = [];
            
            // For detail calculation display
            $rRow['calc_details'] = [
                'wsm_terms' => [], // "norm * bobot"
                'wpm_terms' => [], // "(norm)^bobot"
            ];

            foreach ($this->kriterias as $k) {
                // Determine normalization logic
                $type = strtolower($k->jenis);
                $max = $this->maxValues[$k->id];
                $min = $this->minValues[$k->id];
                $val = $xRow['scores'][$k->id];
                $norm = 0;

                if ($type == 'cost') {
                    // Min / Value
                    $norm = $val > 0 ? ($min / $val) : 0;
                } else {
                    // Value / Max (Benefit default)
                    $norm = $max > 0 ? ($val / $max) : 0;
                }
                
                $rRow['normalized'][$k->id] = $norm;

                $rRow['normalized'][$k->id] = $norm;
                
                // Detailed Manual Calculations
                $bobotDecimal = $k->bobot / 100;
                
                // 1. Normalization Formula String
                $normFormula = ($type == 'cost') 
                    ? "{$min} / {$val}" 
                    : "{$val} / {$max}";
                $rRow['calc_details']['norm_formulas'][$k->id] = [
                    'formula' => $normFormula,
                    'result' => number_format($norm, 4)
                ];

                // 2. WSM Term
                $rRow['calc_details']['wsm_terms'][$k->id] = [
                    'term' => number_format($norm, 4) . " × " . number_format($bobotDecimal, 2),
                    'result' => $norm * $bobotDecimal
                ];
                
                // 3. WPM Term
                $rRow['calc_details']['wpm_terms'][$k->id] = [
                    'term' => "(" . number_format($norm, 4) . ")^" . number_format($bobotDecimal, 2),
                    'result' => pow($norm + 0.0001, $bobotDecimal) // +epsilon for log safety usually, mimicking logic
                ];
            }
            $this->matrixR[] = $rRow;
        }

        // Sort by Qi for ranking
        usort($this->matrixR, fn($a, $b) => $b['qi'] <=> $a['qi']);
        $this->results = $this->matrixR;

        // 3. Generate Narrative Analysis
        $this->generateNarrative();
    }

    private function getCategory($kriteriaId, $nilai)
    {
        // Custom logic for special cases or use map
        // For range based logic, exact match might fail if floats are involved but here it seems integer based 1-5
        
        // Direct match from DB
        if (isset($this->scoreDescriptions[$kriteriaId][(int)$nilai])) {
             return $this->scoreDescriptions[$kriteriaId][(int)$nilai];
        }

        // Fallback generic
        return match((int)$nilai) {
            5 => 'Sangat Baik/Sesuai',
            4 => 'Baik',
            3 => 'Cukup',
            2 => 'Kurang',
            1 => 'Sangat Kurang/Tidak Sesuai',
            default => '-'
        };
    }



    private function generateNarrative()
    {
        if (empty($this->results)) return;

        $top = $this->results[0];
        
        // Top Candidate Analysis
        $this->topCandidateAnalysis = "Berdasarkan hasil perhitungan metode WASPAS, kandidat terbaik adalah <strong>{$top['nama']}</strong> dengan nilai Qi <strong>" . number_format($top['qi'], 4) . "</strong>. ";
        
        // Find strengths (where normalized score is 1.0 or high)
        $strengths = [];
        foreach ($this->kriterias as $k) {
            if ($top['normalized'][$k->id] == 1.0) {
                $strengths[] = $k->kriteria;
            }
        }
        
        if (!empty($strengths)) {
            $this->topCandidateAnalysis .= "Kandidat ini memiliki keunggulan maksimal pada kriteria: " . implode(', ', array_slice($strengths, 0, 3));
            if (count($strengths) > 3) $this->topCandidateAnalysis .= ", dan lain-lain.";
        }

        // Gap Analysis
        if (count($this->results) > 1) {
            $second = $this->results[1];
            $gap = $top['qi'] - $second['qi'];
            $this->gapAnalysis = "Terdapat selisih nilai sebesar <strong>" . number_format($gap, 4) . "</strong> antara peringkat pertama ({$top['nama']}) dan kedua ({$second['nama']}). ";
            
            if ($gap < 0.05) {
                $this->gapAnalysis .= "Persaingan sangat ketat, yang berarti kualitas kedua kandidat teratas hampir setara.";
            } elseif ($gap > 0.2) {
                $this->gapAnalysis .= "Peringkat pertama unggul cukup signifikan dibandingkan kandidat lainnya.";
            }
        }
    }

    // Helper to get formatted formula for display
    public function getManualCalculationExample()
    {
        if (empty($this->results)) return null;
        
        $example = $this->results[0]; // Top candidate
        $steps = [
            'normalization' => [],
            'q1' => [],
            'q2' => [],
            'qi' => ''
        ];

        foreach ($this->kriterias as $k) {
            $val = $example['scores'][$k->id];
            $max = $this->maxValues[$k->id];
            $norm = $example['normalized'][$k->id];
            $weight = $k->bobot / 100;
            
            // Normalization Step
            $steps['normalization'][$k->id] = [
                'formula' => "{$val} / {$max}",
                'result' => number_format($norm, 4)
            ];

            // Q1 Step
            $steps['q1'][$k->id] = [
                'term' => "({$norm} × {$weight})",
                'value' => number_format($norm * $weight, 4)
            ];

            // Q2 Step
            $steps['q2'][$k->id] = [
                'term' => "({$norm} + 0.0001)^{$weight}", // Adding epsilon for safety display
                'value' => number_format(pow($norm + 0.0001, $weight), 4)
            ];
        }

        return [
            'candidate' => $example['nama'],
            'steps' => $steps
        ];
    }

    private function resetAnalysis()
    {
        $this->results = [];
        $this->matrixX = [];
        $this->matrixR = [];
        $this->maxValues = [];
        $this->topCandidateAnalysis = '';
        $this->gapAnalysis = '';
    }

    public function render()
    {
        $manualExample = $this->getManualCalculationExample();
        return view('livewire.waspas-analisis', [
            'manualExample' => $manualExample
        ])->layout('layouts.app');
    }
}
