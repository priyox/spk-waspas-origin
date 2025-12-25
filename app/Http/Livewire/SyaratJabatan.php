<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\SyaratJabatan as SyaratJabatanModel;
use App\Models\Eselon;
use App\Models\Golongan;
use App\Models\TingkatPendidikan;

class SyaratJabatan extends Component
{
    public $syaratJabatans;
    public $eselon_id;
    public $minimal_golongan_id;
    public $syarat_golongan_id;
    public $minimal_tingkat_pendidikan_id;
    public $minimal_eselon_id;
    public $minimal_jenjang_fungsional_id;
    public $keterangan;
    public $is_active = true;

    public $isModalOpen = false;
    public $syarat_id_to_edit = null;
    public $confirmingDeletion = false;
    public $deleteId = null;

    protected $rules = [
        'eselon_id' => 'required|exists:eselons,id',
        'syarat_golongan_id' => 'required|exists:golongans,id',
        'minimal_golongan_id' => 'required|exists:golongans,id',
        'minimal_tingkat_pendidikan_id' => 'required|exists:tingkat_pendidikans,id',
        'minimal_eselon_id' => 'nullable|exists:eselons,id',
        'minimal_jenjang_fungsional_id' => 'nullable|exists:jenjang_fungsionals,id',
        'keterangan' => 'nullable|string|max:255',
        'is_active' => 'boolean',
    ];

    protected $messages = [
        'eselon_id.required' => 'Eselon wajib dipilih',
        'syarat_golongan_id.required' => 'Syarat golongan wajib dipilih',
        'minimal_golongan_id.required' => 'Minimal golongan wajib dipilih',
        'minimal_tingkat_pendidikan_id.required' => 'Minimal tingkat pendidikan wajib dipilih',
    ];

    public function render()
    {
        $this->syaratJabatans = SyaratJabatanModel::with([
            'eselon',
            'minimalGolongan',
            'syaratGolongan',
            'minimalTingkatPendidikan',
            'minimalEselon',
            'jenjangFungsional'
        ])->orderBy('eselon_id')->get();

        return view('livewire.syarat-jabatan', [
            'eselons' => Eselon::orderBy('id')->get(),
            'golongans' => Golongan::orderBy('id')->get(),
            'tingkatPendidikans' => TingkatPendidikan::orderBy('id')->get(),
            'jenjangFungsionals' => \App\Models\JenjangFungsional::orderBy('tingkat')->get(),
        ])->layout('layouts.app');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->isModalOpen = true;
        $this->dispatch('open-modal', 'syarat-modal');
    }

    public function store()
    {
        $this->validate();

        SyaratJabatanModel::updateOrCreate(
            ['id' => $this->syarat_id_to_edit],
            [
                'eselon_id' => $this->eselon_id,
                'minimal_golongan_id' => $this->minimal_golongan_id, 
                'syarat_golongan_id' => $this->syarat_golongan_id,
                'minimal_tingkat_pendidikan_id' => $this->minimal_tingkat_pendidikan_id,
                'minimal_eselon_id' => $this->minimal_eselon_id ?: null,
                'minimal_jenjang_fungsional_id' => $this->minimal_jenjang_fungsional_id ?: null,
                'keterangan' => $this->keterangan,
                'is_active' => $this->is_active,
            ]
        );

        session()->flash('message', $this->syarat_id_to_edit ? 'Syarat Jabatan berhasil diupdate.' : 'Syarat Jabatan berhasil ditambahkan.');

        $this->closeModal();
    }

    public function edit($id)
    {
        $syaratJabatan = SyaratJabatanModel::findOrFail($id);
        $this->syarat_id_to_edit = $id;
        $this->eselon_id = $syaratJabatan->eselon_id;
        $this->syarat_golongan_id = $syaratJabatan->syarat_golongan_id;
        $this->minimal_golongan_id = $syaratJabatan->minimal_golongan_id;
        $this->minimal_tingkat_pendidikan_id = $syaratJabatan->minimal_tingkat_pendidikan_id;
        $this->minimal_eselon_id = $syaratJabatan->minimal_eselon_id;
        $this->minimal_jenjang_fungsional_id = $syaratJabatan->minimal_jenjang_fungsional_id;
        $this->keterangan = $syaratJabatan->keterangan;
        $this->is_active = $syaratJabatan->is_active;
        $this->isModalOpen = true;
        $this->dispatch('open-modal', 'syarat-modal');
    }

    public function confirmDelete($id)
    {
        $this->confirmingDeletion = true;
        $this->deleteId = $id;
    }

    public function delete()
    {
        if ($this->deleteId) {
            SyaratJabatanModel::find($this->deleteId)->delete();
            session()->flash('message', 'Syarat Jabatan berhasil dihapus.');
        }
        $this->confirmingDeletion = false;
        $this->deleteId = null;
    }

    public function cancelDelete()
    {
        $this->confirmingDeletion = false;
        $this->deleteId = null;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetInputFields();
        $this->dispatch('close-modal', 'syarat-modal');
    }

    private function resetInputFields()
    {
        $this->eselon_id = '';
        $this->minimal_golongan_id = '';
        $this->syarat_golongan_id = '';
        $this->minimal_tingkat_pendidikan_id = '';
        $this->minimal_eselon_id = '';
        $this->minimal_jenjang_fungsional_id = '';
        $this->keterangan = '';
        $this->is_active = true;
        $this->syarat_id_to_edit = null;
        $this->resetValidation();
    }
}
