<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Kandidat extends Component
{
    public $kandidats, $nip, $nama, $tempat_lahir, $tanggal_lahir, $jabatan, $unit_kerja, $jurusan;
    public $golongan_id, $jenis_jabatan_id, $eselon_id, $tingkat_pendidikan_id, $bidang_ilmu_id;
    public $isModalOpen = false;
    public $kandidat_id_to_edit = null;

    protected $rules = [
        'nip' => 'required|string|max:20',
        'nama' => 'required|string|max:255',
        'tempat_lahir' => 'required|string|max:100',
        'tanggal_lahir' => 'required|date',
        'golongan_id' => 'required|exists:golongans,id',
        'jenis_jabatan_id' => 'required|exists:jenis_jabatans,id',
        'jabatan' => 'required|string|max:255',
        'tingkat_pendidikan_id' => 'required|exists:tingkat_pendidikans,id',
        'bidang_ilmu_id' => 'required|exists:bidang_ilmus,id',
    ];

    public function render()
    {
        $this->kandidats = \App\Models\Kandidat::with(['golongan', 'eselon', 'tingkat_pendidikan', 'bidang_ilmu'])->get();
        
        return view('livewire.kandidat', [
            'golongans' => \App\Models\Golongan::all(),
            'jenis_jabatans' => \App\Models\JenisJabatan::all(),
            'tingkat_pendidikans' => \App\Models\TingkatPendidikan::all(),
            'bidang_ilmus' => \App\Models\BidangIlmu::all(),
            'eselons' => \App\Models\Eselon::all(), // Optional
        ])->layout('layouts.app');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->isModalOpen = true;
        // Set defaults if lists are not empty to improve UX
        $this->golongan_id = \App\Models\Golongan::first()?->id;
        $this->jenis_jabatan_id = \App\Models\JenisJabatan::first()?->id;
        $this->tingkat_pendidikan_id = \App\Models\TingkatPendidikan::first()?->id;
        $this->bidang_ilmu_id = \App\Models\BidangIlmu::first()?->id;

        $this->dispatch('open-modal', 'kandidat-modal');
    }

    public function store()
    {
        // Validation for update unique NIP check could be complex, simplifying for now
        $this->validate();

        \App\Models\Kandidat::updateOrCreate(['nip' => $this->nip], [
            'nama' => $this->nama,
            'tempat_lahir' => $this->tempat_lahir,
            'tanggal_lahir' => $this->tanggal_lahir,
            'golongan_id' => $this->golongan_id,
            'jenis_jabatan_id' => $this->jenis_jabatan_id,
            'eselon_id' => $this->eselon_id ?: null,
            'jabatan' => $this->jabatan,
            'unit_kerja' => $this->unit_kerja,
            'tingkat_pendidikan_id' => $this->tingkat_pendidikan_id,
            'jurusan' => $this->jurusan,
            'bidang_ilmu_id' => $this->bidang_ilmu_id,
        ]);

        session()->flash('message', $this->kandidat_id_to_edit ? 'Kandidat updated successfully.' : 'Kandidat created successfully.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($nip)
    {
        $kandidat = \App\Models\Kandidat::findOrFail($nip);
        $this->nip = $kandidat->nip;
        $this->nama = $kandidat->nama;
        $this->tempat_lahir = $kandidat->tempat_lahir;
        $this->tanggal_lahir = $kandidat->tanggal_lahir;
        $this->golongan_id = $kandidat->golongan_id;
        $this->jenis_jabatan_id = $kandidat->jenis_jabatan_id;
        $this->eselon_id = $kandidat->eselon_id;
        $this->jabatan = $kandidat->jabatan;
        $this->unit_kerja = $kandidat->unit_kerja;
        $this->tingkat_pendidikan_id = $kandidat->tingkat_pendidikan_id;
        $this->jurusan = $kandidat->jurusan;
        $this->bidang_ilmu_id = $kandidat->bidang_ilmu_id;
        
        $this->kandidat_id_to_edit = $nip; // Actually NIP is primary key
        $this->isModalOpen = true;

        $this->dispatch('open-modal', 'kandidat-modal');
    }

    public function delete($nip)
    {
        \App\Models\Kandidat::find($nip)->delete();
        session()->flash('message', 'Kandidat deleted successfully.');
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetInputFields();
        $this->dispatch('close-modal', 'kandidat-modal');
    }

    private function resetInputFields()
    {
        $this->nip = '';
        $this->nama = '';
        $this->tempat_lahir = '';
        $this->tanggal_lahir = '';
        $this->golongan_id = '';
        $this->jenis_jabatan_id = '';
        $this->eselon_id = '';
        $this->jabatan = '';
        $this->unit_kerja = '';
        $this->tingkat_pendidikan_id = '';
        $this->jurusan = '';
        $this->bidang_ilmu_id = '';
        $this->kandidat_id_to_edit = null;
    }
}
