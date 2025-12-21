<?php

namespace App\Http\Livewire;

use Livewire\Component;

class WaspasHasil extends Component
{
    public function render()
    {
        $kandidats = \App\Models\Kandidat::all();
        $kriterias = \App\Models\Kriteria::all();
        $nilais = \App\Models\Nilai::all();

        // 1. Build Matrix X
        $matrix = [];
        foreach ($nilais as $nilai) {
            $matrix[$nilai->kandidats_id][$nilai->kriteria_id] = $nilai->nilai;
        }

        // 2. Normalize Matrix R (Simplified for result, just needed for Q calc)
        $minMax = [];
        foreach ($kriterias as $kriteria) {
            $values = [];
            foreach ($kandidats as $kandidat) {
                if (isset($matrix[$kandidat->id][$kriteria->id])) {
                    $values[] = $matrix[$kandidat->id][$kriteria->id];
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

        // 3. Calculate Q Values
        $results = [];
        foreach ($kandidats as $kandidat) {
            $q1 = 0;
            $q2 = 1;

            foreach ($kriterias as $kriteria) {
                $val = $matrix[$kandidat->id][$kriteria->id] ?? 0;
                $norm = 0;
                $type = strtolower($kriteria->jenis ?? 'benefit');

                if ($type == 'cost') {
                     $norm = ($val != 0) ? ($minMax[$kriteria->id]['min'] / $val) : 0;
                } else {
                     $norm = ($minMax[$kriteria->id]['max'] != 0) ? ($val / $minMax[$kriteria->id]['max']) : 0;
                }

                $weight = $kriteria->bobot / 100;
                $q1 += ($norm * $weight);
                // Add a small epsilon (0.0001) to norm to prevent entire product becoming zero if norm is 0
                $q2 *= pow($norm + 0.0001, $weight);
            }

            $results[] = [
                'nip' => $kandidat->nip,
                'nama' => $kandidat->nama,
                'q1' => $q1,
                'q2' => $q2,
                'qi' => (0.5 * $q1) + (0.5 * $q2)
            ];
        }

        // Sort by Qi Descending
        usort($results, function ($a, $b) {
            return $b['qi'] <=> $a['qi'];
        });

        return view('livewire.waspas-hasil', compact('results'))
            ->layout('layouts.app');
    }
}
