<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\JabatanTarget as JabatanTargetModel;

class JabatanTarget extends Component
{
    public $jabatanTargets, $nama_jabatan, $id_eselon, $id_bidang;
    public $isModalOpen = false;
    public $jabatan_id_to_edit = null;
    public $confirmingDeletion = false;
    public $deleteJabatanId = null;

    protected $rules = [
        'nama_jabatan' => 'required|string|max:255',
        'id_eselon' => 'required|integer',
        'id_bidang' => 'required|integer',
    ];

    public function render()
    {
        $this->jabatanTargets = JabatanTargetModel::all();
        
        return view('livewire.jabatan-target', [
            'eselons' => \App\Models\Eselon::all(),
            'bidangIlmus' => \App\Models\BidangIlmu::all()
        ])->layout('layouts.app');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->id_eselon = \App\Models\Eselon::first()?->id ?? 0;
        $this->id_bidang = \App\Models\BidangIlmu::first()?->id ?? 0;
        $this->isModalOpen = true;
        $this->dispatch('open-modal', 'jabatan-modal');
    }

    public function store()
    {
        $this->validate();

        JabatanTargetModel::updateOrCreate(
            ['id' => $this->jabatan_id_to_edit],
            [
                'nama_jabatan' => $this->nama_jabatan,
                'id_eselon' => $this->id_eselon,
                'id_bidang' => $this->id_bidang
            ]
        );

        session()->flash('message', $this->jabatan_id_to_edit ? 'Jabatan Target berhasil diupdate.' : 'Jabatan Target berhasil ditambahkan.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $jabatan = JabatanTargetModel::findOrFail($id);
        $this->jabatan_id_to_edit = $id;
        $this->nama_jabatan = $jabatan->nama_jabatan;
        $this->id_eselon = $jabatan->id_eselon;
        $this->id_bidang = $jabatan->id_bidang;
        $this->isModalOpen = true;
        $this->dispatch('open-modal', 'jabatan-modal');
    }

    public function confirmDelete($id)
    {
        $this->confirmingDeletion = true;
        $this->deleteJabatanId = $id;
    }

    public function deleteJabatan()
    {
        if ($this->deleteJabatanId) {
            JabatanTargetModel::find($this->deleteJabatanId)->delete();
            session()->flash('message', 'Jabatan Target berhasil dihapus.');
        }
        $this->confirmingDeletion = false;
        $this->deleteJabatanId = null;
    }

    public function cancelDelete()
    {
        $this->confirmingDeletion = false;
        $this->deleteJabatanId = null;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetInputFields();
        $this->dispatch('close-modal', 'jabatan-modal');
    }

    private function resetInputFields()
    {
        $this->nama_jabatan = '';
        $this->id_eselon = '';
        $this->id_bidang = '';
        $this->jabatan_id_to_edit = null;
    }
}
