<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\SyaratJabatan as SyaratJabatanModel;

class SyaratJabatan extends Component
{
    public $syaratJabatans, $eselon_id, $syarat, $nilai;
    public $isModalOpen = false;
    public $syarat_id_to_edit = null;

    protected $rules = [
        'eselon_id' => 'required|exists:eselons,id',
        'syarat' => 'required|string|max:100',
        'nilai' => 'required|string|max:100',
    ];

    public function render()
    {
        $this->syaratJabatans = SyaratJabatanModel::with('eselon')->get();
        
        return view('livewire.syarat-jabatan', [
            'eselons' => \App\Models\Eselon::all()
        ])->layout('layouts.app');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->eselon_id = \App\Models\Eselon::first()?->id;
        $this->isModalOpen = true;
    }

    public function store()
    {
        $this->validate();

        SyaratJabatanModel::updateOrCreate(
            ['id' => $this->syarat_id_to_edit],
            [
                'eselon_id' => $this->eselon_id,
                'syarat' => $this->syarat,
                'nilai' => $this->nilai
            ]
        );

        session()->flash('message', $this->syarat_id_to_edit ? 'Syarat Jabatan berhasil diupdate.' : 'Syarat Jabatan berhasil ditambahkan.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $syaratJabatan = SyaratJabatanModel::findOrFail($id);
        $this->syarat_id_to_edit = $id;
        $this->eselon_id = $syaratJabatan->eselon_id;
        $this->syarat = $syaratJabatan->syarat;
        $this->nilai = $syaratJabatan->nilai;
        $this->isModalOpen = true;
    }

    public function delete($id)
    {
        SyaratJabatanModel::find($id)->delete();
        session()->flash('message', 'Syarat Jabatan berhasil dihapus.');
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetInputFields();
    }

    private function resetInputFields()
    {
        $this->eselon_id = '';
        $this->syarat = '';
        $this->nilai = '';
        $this->syarat_id_to_edit = null;
    }
}
