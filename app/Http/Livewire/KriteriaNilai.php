<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\KriteriaNilai as KriteriaNilaiModel;
use App\Models\Kriteria;

class KriteriaNilai extends Component
{
    public $kriteriaNilais, $kategori, $nilai, $ket, $kriteria_id;
    public $isModalOpen = false;
    public $kriteria_nilai_id_to_edit = null;
    public $confirmingDeletion = false;
    public $deleteKriteriaNilaiId = null;

    protected $rules = [
        'kriteria_id' => 'required|exists:kriterias,id',
        'kategori' => 'required|string|max:100',
        'nilai' => 'required|integer|min:0',
        'ket' => 'nullable|string',
    ];

    public function render()
    {
        $this->kriteriaNilais = KriteriaNilaiModel::with('kriteria')->get();

        return view('livewire.kriteria-nilai', [
            'kriterias' => Kriteria::all(),
        ])->layout('layouts.app');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->kriteria_id = Kriteria::first()?->id ?? '';
        $this->isModalOpen = true;
        $this->dispatch('open-modal', 'kriteria-nilai-modal');
    }

    public function store()
    {
        // Super Admin view-only restriction
        if (auth()->user()->hasRole('Super Admin')) {
            session()->flash('error', 'Super Admin hanya memiliki akses view. Tidak dapat menambah/mengubah data.');
            $this->closeModal();
            return;
        }

        $this->validate();

        KriteriaNilaiModel::updateOrCreate(
            ['id' => $this->kriteria_nilai_id_to_edit],
            [
                'kriteria_id' => $this->kriteria_id,
                'kategori' => $this->kategori,
                'nilai' => $this->nilai,
                'ket' => $this->ket ?: null,
            ]
        );

        session()->flash('message', $this->kriteria_nilai_id_to_edit ? 'Kriteria Nilai berhasil diupdate.' : 'Kriteria Nilai berhasil ditambahkan.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $kriteriaNilai = KriteriaNilaiModel::findOrFail($id);
        $this->kriteria_nilai_id_to_edit = $id;
        $this->kriteria_id = $kriteriaNilai->kriteria_id;
        $this->kategori = $kriteriaNilai->kategori;
        $this->nilai = $kriteriaNilai->nilai;
        $this->ket = $kriteriaNilai->ket;
        $this->isModalOpen = true;
        $this->dispatch('open-modal', 'kriteria-nilai-modal');
    }

    public function confirmDelete($id)
    {
        $this->confirmingDeletion = true;
        $this->deleteKriteriaNilaiId = $id;
    }

    public function deleteKriteriaNilai()
    {
        // Super Admin view-only restriction
        if (auth()->user()->hasRole('Super Admin')) {
            session()->flash('error', 'Super Admin hanya memiliki akses view. Tidak dapat menghapus data.');
            $this->confirmingDeletion = false;
            $this->deleteKriteriaNilaiId = null;
            return;
        }

        if ($this->deleteKriteriaNilaiId) {
            KriteriaNilaiModel::find($this->deleteKriteriaNilaiId)->delete();
            session()->flash('message', 'Kriteria Nilai berhasil dihapus.');
        }
        $this->confirmingDeletion = false;
        $this->deleteKriteriaNilaiId = null;
    }

    public function cancelDelete()
    {
        $this->confirmingDeletion = false;
        $this->deleteKriteriaNilaiId = null;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetInputFields();
        $this->dispatch('close-modal', 'kriteria-nilai-modal');
    }

    private function resetInputFields()
    {
        $this->kategori = '';
        $this->nilai = '';
        $this->ket = '';
        $this->kriteria_id = '';
        $this->kriteria_nilai_id_to_edit = null;
    }
}
