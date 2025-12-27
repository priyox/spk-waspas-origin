<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\JabatanTarget;
use App\Models\WaspasNilai;
use App\Models\Kriteria;

class WaspasHasil extends Component
{
    public $jabatanTargets;
    public $selectedJabatanId = '';
    public $results = [];
    public $confirmingDeletion = false;
    public $deleteJabatanId = null;

    protected $queryString = ['selectedJabatanId' => ['as' => 'jabatan']];

    public function mount()
    {
        $this->jabatanTargets = JabatanTarget::all();

        // Check if jabatan is passed via query string
        if (request()->has('jabatan')) {
            $this->selectedJabatanId = request()->get('jabatan');
            $this->loadResults();
        }
    }

    public function updatedSelectedJabatanId()
    {
        $this->loadResults();
    }

    public function loadResults()
    {
        if (!$this->selectedJabatanId) {
            $this->results = [];
            return;
        }

        $waspasNilais = WaspasNilai::where('jabatan_target_id', $this->selectedJabatanId)
            ->with('kandidat')
            ->get();

        if ($waspasNilais->isEmpty()) {
            $this->results = [];
            return;
        }

        // Calculate Qi from stored WSM and WPM
        $this->results = $waspasNilais->map(function ($item) {
            $qi = (0.5 * $item->wsm) + (0.5 * $item->wpm);
            return [
                'id' => $item->id,
                'kandidat_id' => $item->kandidats_id,
                'nip' => $item->kandidat->nip ?? '-',
                'nama' => $item->kandidat->nama ?? '-',
                'jabatan' => $item->kandidat->jabatan ?? '-',
                'golongan' => $item->kandidat->golongan->golongan ?? '-',
                'pangkat' => $item->pangkat,
                'masa_jabatan' => $item->masa_jabatan,
                'tingkat_pendidikan' => $item->tingkat_pendidikan,
                'diklat' => $item->diklat,
                'skp' => $item->skp,
                'penghargaan' => $item->penghargaan,
                'hukdis' => $item->hukdis,
                'bidang_ilmu' => $item->bidang_ilmu,
                'potensi' => $item->potensi,
                'kompetensi' => $item->kompetensi,
                'q1' => $item->wsm,
                'q2' => $item->wpm,
                'qi' => $qi,
                'created_at' => $item->created_at,
            ];
        })->sortByDesc('qi')->values()->toArray();
    }

    public function confirmDelete($jabatanId)
    {
        $this->confirmingDeletion = true;
        $this->deleteJabatanId = $jabatanId;
    }

    public function deleteResult()
    {
        // Pimpinan cannot delete results
        if (auth()->user()->hasRole('Pimpinan')) {
            session()->flash('error', 'Pimpinan hanya memiliki akses view. Tidak dapat menghapus hasil perhitungan.');
            $this->confirmingDeletion = false;
            $this->deleteJabatanId = null;
            return;
        }

        if ($this->deleteJabatanId) {
            WaspasNilai::where('jabatan_target_id', $this->deleteJabatanId)->delete();
            session()->flash('message', 'Hasil perhitungan berhasil dihapus.');
            $this->results = [];
            $this->selectedJabatanId = '';
        }
        $this->confirmingDeletion = false;
        $this->deleteJabatanId = null;
    }

    public function cancelDelete()
    {
        $this->confirmingDeletion = false;
        $this->deleteJabatanId = null;
    }

    public function render()
    {
        $kriterias = Kriteria::orderBy('id')->get();

        // Get available results (jabatan yang sudah ada hasilnya)
        $availableJabatans = WaspasNilai::select('jabatan_target_id')
            ->distinct()
            ->with('jabatanTarget')
            ->get()
            ->pluck('jabatanTarget')
            ->filter();

        return view('livewire.waspas-hasil', [
            'kriterias' => $kriterias,
            'availableJabatans' => $availableJabatans,
        ])->layout('layouts.app');
    }
}
