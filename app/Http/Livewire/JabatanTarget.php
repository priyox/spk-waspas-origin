<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\JabatanTarget as JabatanTargetModel;

class JabatanTarget extends Component
{
    public $jabatanTargets, $nama_jabatan, $id_eselon;
    public $selectedBidangIds = []; // Changed from single ID to array
    public $isModalOpen = false;
    public $jabatan_id_to_edit = null;
    public $confirmingDeletion = false;
    public $deleteJabatanId = null;

    protected $rules = [
        'nama_jabatan' => 'required|string|max:255',
        'id_eselon' => 'required|integer',
        'selectedBidangIds' => 'required|array|min:1', // Validate array
        'selectedBidangIds.*' => 'integer|exists:bidang_ilmus,id',
    ];

    public function render()
    {
        $this->jabatanTargets = JabatanTargetModel::with(['eselon', 'bidangIlmu'])->get();
        
        return view('livewire.jabatan-target', [
            'eselons' => \App\Models\Eselon::all(),
            'bidangIlmus' => \App\Models\BidangIlmu::all()
        ])->layout('layouts.app');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->id_eselon = \App\Models\Eselon::first()?->id ?? 0;
        // Initialize with one empty slot for the "default" input
        $this->selectedBidangIds = ['']; 
        $this->isModalOpen = true;
        $this->dispatch('open-modal', 'jabatan-modal');
    }

    public function addBidang()
    {
        $this->selectedBidangIds[] = '';
    }

    public function removeBidang($index)
    {
        unset($this->selectedBidangIds[$index]);
        $this->selectedBidangIds = array_values($this->selectedBidangIds); // Re-index
    }

    public function store()
    {
        // Filter empty values
        $this->selectedBidangIds = array_filter($this->selectedBidangIds, function($value) {
            return !empty($value);
        });

        $this->validate();

        $jabatan = JabatanTargetModel::updateOrCreate(
            ['id' => $this->jabatan_id_to_edit],
            [
                'nama_jabatan' => $this->nama_jabatan,
                'id_eselon' => $this->id_eselon,
            ]
        );

        // Sync the pivot table
        $jabatan->bidangIlmu()->sync($this->selectedBidangIds);

        session()->flash('message', $this->jabatan_id_to_edit ? 'Jabatan Target berhasil diupdate.' : 'Jabatan Target berhasil ditambahkan.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $jabatan = JabatanTargetModel::with('bidangIlmu')->findOrFail($id);
        $this->jabatan_id_to_edit = $id;
        $this->nama_jabatan = $jabatan->nama_jabatan;
        $this->id_eselon = $jabatan->id_eselon;
        
        // Load existing relations into array
        $this->selectedBidangIds = $jabatan->bidangIlmu->pluck('id')->toArray();
        
        if (empty($this->selectedBidangIds)) {
            $this->selectedBidangIds = [''];
        }
        
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
        $this->selectedBidangIds = [];
        $this->jabatan_id_to_edit = null;
    }
}
