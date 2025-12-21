<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Penilaian extends Component
{
    public $kandidats;
    public $kriterias;
    public $jabatanTargets;
    public $selectedJabatanId;
    public $nilais = [];

    public function mount()
    {
        $this->jabatanTargets = \App\Models\JabatanTarget::all();
        $this->kriterias = \App\Models\Kriteria::all();

        // Load existing values
        $existingNilais = \App\Models\Nilai::all();
        foreach ($existingNilais as $nilai) {
            $this->nilais[$nilai->kandidats_id][$nilai->kriteria_id] = $nilai->nilai;
        }
    }

    public function save()
    {
        foreach ($this->nilais as $kandidatId => $kriteriaValues) {
            foreach ($kriteriaValues as $kriteriaId => $value) {
                if ($value !== '' && $value !== null) {
                    \App\Models\Nilai::updateOrCreate(
                        [
                            'kandidats_id' => $kandidatId,
                            'kriteria_id' => $kriteriaId,
                        ],
                        [
                            'nilai' => $value
                        ]
                    );
                }
            }
        }

        session()->flash('message', 'Penilaian berhasil disimpan.');
        $this->redirect(route('waspas.proses'), navigate: true);
    }

    public function render()
    {
        $query = \App\Models\Kandidat::query();

        if ($this->selectedJabatanId) {
            $target = \App\Models\JabatanTarget::find($this->selectedJabatanId);
            if ($target) {
                $query->where('eselon_id', $target->id_eselon)
                      ->where('bidang_ilmu_id', $target->id_bidang);
            }
        }

        $this->kandidats = $query->get();

        return view('livewire.penilaian')
            ->layout('layouts.app');
    }
}
