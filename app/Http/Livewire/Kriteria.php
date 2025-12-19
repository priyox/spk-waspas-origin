<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Kriteria extends Component
{
    public $kriterias, $kriteria, $bobot, $jenis;
    public $isModalOpen = false;
    public $kriteria_id_to_edit = null;

    protected $rules = [
        'kriteria' => 'required|string|max:255',
        'bobot' => 'required|numeric',
        'jenis' => 'required|in:Benefit,Cost',
    ];

    public function render()
    {
        $this->kriterias = \App\Models\Kriteria::all();
        return view('livewire.kriteria')
            ->layout('layouts.app');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->isModalOpen = true;
    }

    public function store()
    {
        $this->validate();

        \App\Models\Kriteria::updateOrCreate(['id' => $this->kriteria_id_to_edit], [
            'kriteria' => $this->kriteria,
            'bobot' => $this->bobot,
            'jenis' => $this->jenis,
        ]);

        session()->flash('message', $this->kriteria_id_to_edit ? 'Kriteria updated successfully.' : 'Kriteria created successfully.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $kriteria = \App\Models\Kriteria::findOrFail($id);
        $this->kriteria_id_to_edit = $id;
        $this->kriteria = $kriteria->kriteria;
        $this->bobot = $kriteria->bobot;
        $this->jenis = $kriteria->jenis;
    
        $this->isModalOpen = true;
    }

    public function delete($id)
    {
        \App\Models\Kriteria::find($id)->delete();
        session()->flash('message', 'Kriteria deleted successfully.');
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetInputFields();
    }

    private function resetInputFields()
    {
        $this->kriteria = '';
        $this->bobot = '';
        $this->jenis = '';
        $this->kriteria_id_to_edit = null;
    }
}
