<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\BidangIlmu as BidangIlmuModel;

class BidangIlmu extends Component
{
    public $bidangIlmus, $bidang;
    public $isModalOpen = false;
    public $bidang_id_to_edit = null;

    protected $rules = [
        'bidang' => 'required|string|max:100',
    ];

    public function render()
    {
        $this->bidangIlmus = BidangIlmuModel::all();
        
        return view('livewire.bidang-ilmu')
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
    }

    private function resetInputFields()
    {
        $this->bidang = '';
        $this->bidang_id_to_edit = null;
    }
}
