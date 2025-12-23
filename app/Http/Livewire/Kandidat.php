<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Kandidat extends Component
{
    public $kandidats, $nip, $nama, $tempat_lahir, $tanggal_lahir, $jabatan, $tmt_golongan, $tmt_jabatan, $jurusan;
    public $golongan_id, $jenis_jabatan_id, $eselon_id, $tingkat_pendidikan_id, $jurusan_pendidikan_id, $jabatan_fungsional_id, $jabatan_pelaksana_id, $bidang_ilmu_id, $unit_kerja_id;
    public $isModalOpen = false;
    public $kandidat_id_to_edit = null;

    protected $rules = [
        'nip' => 'required|string|max:20',
        'nama' => 'required|string|max:255',
        'tempat_lahir' => 'required|string|max:100',
        'tanggal_lahir' => 'nullable|date',
        'golongan_id' => 'nullable|exists:golongans,id',
        'tmt_golongan' => 'nullable|date',
        'jenis_jabatan_id' => 'nullable|exists:jenis_jabatans,id',
        'eselon_id' => 'nullable|exists:eselons,id',
        'jabatan' => 'required|string|max:255',
        'tmt_jabatan' => 'nullable|date',
        'tingkat_pendidikan_id' => 'nullable|exists:tingkat_pendidikans,id',
        'jurusan_pendidikan_id' => 'nullable|exists:jurusan_pendidikans,id',
        'jabatan_fungsional_id' => 'nullable|exists:jabatan_fungsionals,id',
        'jabatan_pelaksana_id' => 'nullable|exists:jabatan_pelaksanas,id',
        'bidang_ilmu_id' => 'nullable|exists:bidang_ilmus,id',
        'unit_kerja_id' => 'nullable|exists:unit_kerjas,id',
        'jurusan' => 'nullable|string|max:255',
    ];

    public function render()
    {
        $this->kandidats = \App\Models\Kandidat::with([
            'golongan', 
            'eselon', 
            'tingkat_pendidikan', 
            'bidang_ilmu', 
            'unit_kerja',
            'jurusan_pendidikan',
            'jabatan_fungsional',
            'jabatan_pelaksana'
        ])->get();
        
        return view('livewire.kandidat', [
            'golongans' => \App\Models\Golongan::all(),
            'jenis_jabatans' => \App\Models\JenisJabatan::all(),
            'tingkat_pendidikans' => \App\Models\TingkatPendidikan::all(),
            'bidang_ilmus' => \App\Models\BidangIlmu::all(),
            'eselons' => \App\Models\Eselon::all(),
            'unit_kerjas' => \App\Models\UnitKerja::all(),
            'jurusan_pendidikans' => \App\Models\JurusanPendidikan::all(),
            'jabatan_fungsionals' => \App\Models\JabatanFungsional::all(),
            'jabatan_pelaksanas' => \App\Models\JabatanPelaksana::all(),
        ])->layout('layouts.app');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->isModalOpen = true;
        
        $this->dispatch('open-modal', 'kandidat-modal');
    }

    public function store()
    {
        $this->validate();

        \App\Models\Kandidat::updateOrCreate(['nip' => $this->nip], [
            'nama' => $this->nama,
            'tempat_lahir' => $this->tempat_lahir,
            'tanggal_lahir' => $this->tanggal_lahir ?: null,
            'golongan_id' => $this->golongan_id ?: null,
            'tmt_golongan' => $this->tmt_golongan ?: null,
            'jenis_jabatan_id' => $this->jenis_jabatan_id ?: null,
            'eselon_id' => $this->eselon_id ?: null,
            'jabatan' => $this->jabatan,
            'tmt_jabatan' => $this->tmt_jabatan ?: null,
            'tingkat_pendidikan_id' => $this->tingkat_pendidikan_id ?: null,
            'jurusan_pendidikan_id' => $this->jurusan_pendidikan_id ?: null,
            'jabatan_fungsional_id' => $this->jabatan_fungsional_id ?: null,
            'jabatan_pelaksana_id' => $this->jabatan_pelaksana_id ?: null,
            'bidang_ilmu_id' => $this->bidang_ilmu_id ?: null,
            'unit_kerja_id' => $this->unit_kerja_id ?: null,
            'jurusan' => $this->jurusan,
        ]);

        session()->flash('message', $this->kandidat_id_to_edit ? 'Kandidat updated successfully.' : 'Kandidat created successfully.');

        $this->closeModal();
    }

    public function edit($nip)
    {
        $kandidat = \App\Models\Kandidat::where('nip', $nip)->firstOrFail();
        $this->nip = $kandidat->nip;
        $this->nama = $kandidat->nama;
        $this->tempat_lahir = $kandidat->tempat_lahir;
        $this->tanggal_lahir = $kandidat->tanggal_lahir;
        $this->golongan_id = $kandidat->golongan_id;
        $this->tmt_golongan = $kandidat->tmt_golongan;
        $this->jenis_jabatan_id = $kandidat->jenis_jabatan_id;
        $this->eselon_id = $kandidat->eselon_id;
        $this->jabatan = $kandidat->jabatan;
        $this->tmt_jabatan = $kandidat->tmt_jabatan;
        $this->tingkat_pendidikan_id = $kandidat->tingkat_pendidikan_id;
        $this->jurusan_pendidikan_id = $kandidat->jurusan_pendidikan_id;
        $this->jabatan_fungsional_id = $kandidat->jabatan_fungsional_id;
        $this->jabatan_pelaksana_id = $kandidat->jabatan_pelaksana_id;
        $this->bidang_ilmu_id = $kandidat->bidang_ilmu_id;
        $this->unit_kerja_id = $kandidat->unit_kerja_id;
        $this->jurusan = $kandidat->jurusan;
        
        $this->kandidat_id_to_edit = $nip;
        $this->isModalOpen = true;

        $this->dispatch('open-modal', 'kandidat-modal');
    }

    public function delete($nip)
    {
        \App\Models\Kandidat::where('nip', $nip)->delete();
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
        $this->tmt_golongan = '';
        $this->jenis_jabatan_id = '';
        $this->eselon_id = '';
        $this->jabatan = '';
        $this->tmt_jabatan = '';
        $this->tingkat_pendidikan_id = '';
        $this->jurusan_pendidikan_id = '';
        $this->jabatan_fungsional_id = '';
        $this->jabatan_pelaksana_id = '';
        $this->bidang_ilmu_id = '';
        $this->unit_kerja_id = '';
        $this->jurusan = '';
        $this->kandidat_id_to_edit = null;
    }
}
