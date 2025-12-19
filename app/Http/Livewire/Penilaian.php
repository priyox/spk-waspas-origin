<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Penilaian extends Component
{
    public $kandidats;
    public $kriterias;
    public $nilais = [];

    public function mount()
    {
        $this->kandidats = \App\Models\Kandidat::all();
        $this->kriterias = \App\Models\Kriteria::all();

        // Load existing values
        $existingNilais = \App\Models\Nilai::all();
        foreach ($existingNilais as $nilai) {
            $this->nilais[$nilai->nip][$nilai->kriteria_id] = $nilai->nilai;
        }
    }

    public function save()
    {
        foreach ($this->nilais as $nip => $kriteriaValues) {
            foreach ($kriteriaValues as $kriteriaId => $value) {
                if ($value !== '' && $value !== null) {
                    \App\Models\Nilai::updateOrCreate(
                        [
                            'nip' => $nip,
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
        return view('livewire.penilaian')
            ->layout('layouts.app');
    }
}
