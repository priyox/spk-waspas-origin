<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\BidangIlmu as BidangIlmuModel;

use Livewire\WithPagination;

class BidangIlmu extends Component
{
    use WithPagination;

    // public $bidangIlmus; // Removed
    public $bidang;
    public $search = '';
    public $isModalOpen = false;
    public $bidang_id_to_edit = null;

    protected $rules = [
        'bidang' => 'required|string|max:100',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $bidangIlmus = BidangIlmuModel::where('bidang', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);
        
        return view('livewire.bidang-ilmu', [
            'bidangIlmus' => $bidangIlmus
        ])->layout('layouts.app');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->isModalOpen = true;
        $this->dispatch('open-modal', 'bidang-modal');
    }

    public function store()
    {
        $this->validate();

        BidangIlmuModel::updateOrCreate(
            ['id' => $this->bidang_id_to_edit],
            ['bidang' => $this->bidang]
        );

        session()->flash('message', $this->bidang_id_to_edit ? 'Bidang Ilmu berhasil diupdate.' : 'Bidang Ilmu berhasil ditambahkan.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $bidangIlmu = BidangIlmuModel::findOrFail($id);
        $this->bidang_id_to_edit = $id;
        $this->bidang = $bidangIlmu->bidang;
        $this->isModalOpen = true;
        $this->dispatch('open-modal', 'bidang-modal');
    }

    public function delete($id)
    {
        BidangIlmuModel::find($id)->delete();
        session()->flash('message', 'Bidang Ilmu berhasil dihapus.');
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetInputFields();
        $this->dispatch('close-modal', 'bidang-modal');
    }

    private function resetInputFields()
    {
        $this->bidang = '';
        $this->bidang_id_to_edit = null;
    }
}
