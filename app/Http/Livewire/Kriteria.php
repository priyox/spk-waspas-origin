<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Kriteria extends Component
{
    public $kriterias, $kriteria, $bobot, $jenis;
    public $isModalOpen = false;
    public $kriteria_id_to_edit = null;
    public $confirmingDeletion = false;
    public $deleteKriteriaId = null;

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
        $this->dispatch('open-modal', 'kriteria-modal');
    }

    public function store()
    {
        // Super Admin view-only restriction
        if (auth()->user()->hasRole('Super Admin')) {
            session()->flash('error', 'Super Admin hanya memiliki akses view. Tidak dapat menambah/mengubah data.');
            $this->closeModal();
            return;
        }

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
        $this->dispatch('open-modal', 'kriteria-modal');
    }

    public function confirmDelete($id)
    {
        $this->confirmingDeletion = true;
        $this->deleteKriteriaId = $id;
    }

    public function deleteKriteria()
    {
        // Super Admin view-only restriction
        if (auth()->user()->hasRole('Super Admin')) {
            session()->flash('error', 'Super Admin hanya memiliki akses view. Tidak dapat menghapus data.');
            $this->confirmingDeletion = false;
            $this->deleteKriteriaId = null;
            return;
        }

        if ($this->deleteKriteriaId) {
            \App\Models\Kriteria::find($this->deleteKriteriaId)->delete();
            session()->flash('message', 'Kriteria deleted successfully.');
        }
        $this->confirmingDeletion = false;
        $this->deleteKriteriaId = null;
    }

    public function cancelDelete()
    {
        $this->confirmingDeletion = false;
        $this->deleteKriteriaId = null;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetInputFields();
        $this->dispatch('close-modal', 'kriteria-modal');
    }

    private function resetInputFields()
    {
        $this->kriteria = '';
        $this->bobot = '';
        $this->jenis = '';
        $this->kriteria_id_to_edit = null;
    }
}
