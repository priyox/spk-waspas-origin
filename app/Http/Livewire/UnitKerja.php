<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\UnitKerja as UnitKerjaModel;

class UnitKerja extends Component
{
    public $unitKerjas, $unit_kerja;
    public $isModalOpen = false;
    public $unit_id_to_edit = null;

    protected $rules = [
        'unit_kerja' => 'required|string|max:255',
    ];

    public function render()
    {
        $this->unitKerjas = UnitKerjaModel::all();
        
        return view('livewire.unit-kerja')
            ->layout('layouts.app');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->isModalOpen = true;
        $this->dispatch('open-modal', 'unit-kerja-modal');
    }

    public function store()
    {
        $this->validate();

        UnitKerjaModel::updateOrCreate(
            ['id' => $this->unit_id_to_edit],
            ['unit_kerja' => $this->unit_kerja]
        );

        session()->flash('message', $this->unit_id_to_edit ? 'Unit Kerja berhasil diupdate.' : 'Unit Kerja berhasil ditambahkan.');

        $this->closeModal();
    }

    public function edit($id)
    {
        $unit = UnitKerjaModel::findOrFail($id);
        $this->unit_id_to_edit = $id;
        $this->unit_kerja = $unit->unit_kerja;
        $this->isModalOpen = true;
        $this->dispatch('open-modal', 'unit-kerja-modal');
    }

    public function delete($id)
    {
        UnitKerjaModel::find($id)->delete();
        session()->flash('message', 'Unit Kerja berhasil dihapus.');
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetInputFields();
        $this->dispatch('close-modal', 'unit-kerja-modal');
    }

    private function resetInputFields()
    {
        $this->unit_kerja = '';
        $this->unit_id_to_edit = null;
    }
}
