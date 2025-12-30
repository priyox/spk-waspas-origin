<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\JabatanFungsional as JabatanFungsionalModel;
use App\Models\JenjangFungsional;

use Livewire\WithPagination;

class JabatanFungsional extends Component
{
    use WithPagination;

    // public $jabatanFungsionals; // Removed
    public $nama_jabatan, $jenjang_id;
    public $search = '';
    public $isModalOpen = false;
    public $jabatan_id_to_edit = null;

    protected $rules = [
        'nama_jabatan' => 'required|string|max:255',
        'jenjang_id' => 'required|exists:jenjang_fungsionals,id',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $jabatanFungsionals = JabatanFungsionalModel::with('jenjang')
            ->where('nama_jabatan', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);
            
        $jenjangs = JenjangFungsional::orderBy('tingkat')->get();
        
        return view('livewire.jabatan-fungsional', [
            'jabatanFungsionals' => $jabatanFungsionals,
            'jenjangs' => $jenjangs
        ])->layout('layouts.app');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->isModalOpen = true;
        $this->dispatch('open-modal', 'jabatan-fungsional-modal');
    }

    public function store()
    {
        $this->validate();

        JabatanFungsionalModel::updateOrCreate(
            ['id' => $this->jabatan_id_to_edit],
            [
                'nama_jabatan' => $this->nama_jabatan,
                'jenjang_id' => $this->jenjang_id
            ]
        );

        session()->flash('message', $this->jabatan_id_to_edit ? 'Jabatan Fungsional berhasil diupdate.' : 'Jabatan Fungsional berhasil ditambahkan.');

        $this->closeModal();
    }

    public function edit($id)
    {
        $jabatan = JabatanFungsionalModel::findOrFail($id);
        $this->jabatan_id_to_edit = $id;
        $this->nama_jabatan = $jabatan->nama_jabatan;
        $this->jenjang_id = $jabatan->jenjang_id;
        $this->isModalOpen = true;
        $this->dispatch('open-modal', 'jabatan-fungsional-modal');
    }

    public function delete($id)
    {
        JabatanFungsionalModel::find($id)->delete();
        session()->flash('message', 'Jabatan Fungsional berhasil dihapus.');
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetInputFields();
        $this->dispatch('close-modal', 'jabatan-fungsional-modal');
    }

    private function resetInputFields()
    {
        $this->nama_jabatan = '';
        $this->jenjang_id = '';
        $this->jabatan_id_to_edit = null;
    }
}
