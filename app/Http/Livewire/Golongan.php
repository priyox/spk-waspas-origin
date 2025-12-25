<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Golongan as GolonganModel;

class Golongan extends Component
{
    public $golongans, $golongan, $pangkat;
    public $isModalOpen = false;
    public $golongan_id_to_edit = null;

    protected $rules = [
        'golongan' => 'required|string|max:5',
        'pangkat' => 'required|string|max:255',
    ];

    public function render()
    {
        $this->golongans = GolonganModel::all();
        
        return view('livewire.golongan')
            ->layout('layouts.app');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->isModalOpen = true;
        $this->dispatch('open-modal', 'golongan-modal');
    }

    public function store()
    {
        $this->validate();

        GolonganModel::updateOrCreate(
            ['id' => $this->golongan_id_to_edit],
            [
                'golongan' => $this->golongan,
                'pangkat' => $this->pangkat
            ]
        );

        session()->flash('message', $this->golongan_id_to_edit ? 'Golongan berhasil diupdate.' : 'Golongan berhasil ditambahkan.');

        $this->closeModal();
    }

    public function edit($id)
    {
        $g = GolonganModel::findOrFail($id);
        $this->golongan_id_to_edit = $id;
        $this->golongan = $g->golongan;
        $this->pangkat = $g->pangkat;
        $this->isModalOpen = true;
        $this->dispatch('open-modal', 'golongan-modal');
    }

    public function delete($id)
    {
        GolonganModel::find($id)->delete();
        session()->flash('message', 'Golongan berhasil dihapus.');
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetInputFields();
        $this->dispatch('close-modal', 'golongan-modal');
    }

    private function resetInputFields()
    {
        $this->golongan = '';
        $this->pangkat = '';
        $this->golongan_id_to_edit = null;
    }
}
