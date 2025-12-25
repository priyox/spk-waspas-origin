<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\JabatanPelaksana as JabatanPelaksanaModel;

class JabatanPelaksana extends Component
{
    public $jabatanPelaksanas, $nama_jabatan;
    public $isModalOpen = false;
    public $jabatan_id_to_edit = null;

    protected $rules = [
        'nama_jabatan' => 'required|string|max:255',
    ];

    public function render()
    {
        $this->jabatanPelaksanas = JabatanPelaksanaModel::all();
        
        return view('livewire.jabatan-pelaksana')
            ->layout('layouts.app');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->isModalOpen = true;
        $this->dispatch('open-modal', 'jabatan-pelaksana-modal');
    }

    public function store()
    {
        $this->validate();

        JabatanPelaksanaModel::updateOrCreate(
            ['id' => $this->jabatan_id_to_edit],
            ['nama_jabatan' => $this->nama_jabatan]
        );

        session()->flash('message', $this->jabatan_id_to_edit ? 'Jabatan Pelaksana berhasil diupdate.' : 'Jabatan Pelaksana berhasil ditambahkan.');

        $this->closeModal();
    }

    public function edit($id)
    {
        $jabatan = JabatanPelaksanaModel::findOrFail($id);
        $this->jabatan_id_to_edit = $id;
        $this->nama_jabatan = $jabatan->nama_jabatan;
        $this->isModalOpen = true;
        $this->dispatch('open-modal', 'jabatan-pelaksana-modal');
    }

    public function delete($id)
    {
        JabatanPelaksanaModel::find($id)->delete();
        session()->flash('message', 'Jabatan Pelaksana berhasil dihapus.');
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetInputFields();
        $this->dispatch('close-modal', 'jabatan-pelaksana-modal');
    }

    private function resetInputFields()
    {
        $this->nama_jabatan = '';
        $this->jabatan_id_to_edit = null;
    }
}
