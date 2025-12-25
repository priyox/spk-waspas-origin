<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Services\PenilaianAutoFillService;

class InputNilaiKandidat extends Component
{
    public $kriterias;
    public $nilais = []; // Deprecated, replaced by direct relation access in view
    public $editingValues = []; // State for modal input
    public $autoFillCategories = []; 
    public $validationErrors = []; // Menyimpan error validasi

    // Modal state
    public $isModalOpen = false;
    public $editingKandidatId = null;
    public $editingKandidatName = null;

    // Kriteria yang di-auto-fill (ReadOnly)
    // Kriteria yang di-auto-fill (ReadOnly)
    // ID 4 is now Bidang Ilmu (Auto), ID 8 is Diklat (Static)
    public $autoFilledKriterias = [1, 2, 3, 4];

    // Kriteria checkbox/dropdown groups
    // All are handled as dropdowns now (selecting ID from kriteria_nilais)
    public $dropdownKriterias = [5, 6, 7, 8, 9, 10]; 
    
    // Map Kriteria ID to Model Relationship Name for View
    public $criterionRelationMap = [
        5 => 'knSkp',
        6 => 'knPenghargaan',
        7 => 'knIntegritas',
        8 => 'knDiklat', // ID 8 = Diklat
        9 => 'knPotensi',
        10 => 'knKompetensi',
    ];

    // Map Kriteria ID to Database Column for Saving
    public $criterionColumnMap = [
        5 => 'kn_id_skp',
        6 => 'kn_id_penghargaan',
        7 => 'kn_id_integritas',
        8 => 'kn_id_diklat', // ID 8 = Diklat
        9 => 'kn_id_potensi',
        10 => 'kn_id_kompetensi',
    ];

    protected $autoFillService;

    public function boot()
    {
        $this->autoFillService = app(PenilaianAutoFillService::class);
    }

    public function mount()
    {
        // Filter all static kriterias (4, 5, 6, 7, 9, 10)
        $this->kriterias = \App\Models\Kriteria::whereIn('id', $this->dropdownKriterias)->get();
    }

    public function getKriteriaNilaiOptions($kriteriaId)
    {
        return $this->autoFillService->getOptionsForKriteria($kriteriaId);
    }





    // Modal Actions
    public function startEditing($kandidatId)
    {
        $kandidat = \App\Models\Kandidat::find($kandidatId);
        if (!$kandidat) return;

        $this->editingKandidatId = $kandidatId;
        $this->editingKandidatName = $kandidat->nama;
        $this->isModalOpen = true;
        $this->validationErrors = [];
        $this->editingValues = [];

        // Load existing values into editingValues
        foreach ($this->criterionColumnMap as $kId => $col) {
            $this->editingValues[$kId] = $kandidat->$col;
        }

        $this->dispatch('open-modal', 'input-nilai-modal');
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->editingKandidatId = null;
        $this->editingKandidatName = null;
        $this->validationErrors = [];
        $this->dispatch('close-modal', 'input-nilai-modal');
    }

    public function saveKandidat()
    {
        if (!$this->editingKandidatId) return;

        $kandidatId = $this->editingKandidatId;
        $manualKriterias = $this->dropdownKriterias;
        $hasError = false;

        // Validasi
        foreach ($manualKriterias as $kriteriaId) {
            $value = $this->editingValues[$kriteriaId] ?? null;

             if ($value === '' || $value === null) {
                $this->validationErrors[$kriteriaId] = true; // Simplified error key
                $hasError = true;
            }
        }

        if ($hasError) return;

        // Save
        $kandidat = \App\Models\Kandidat::find($kandidatId);
        
        $updateData = [];
        foreach ($manualKriterias as $kriteriaId) {
            if (isset($this->criterionColumnMap[$kriteriaId])) {
                $col = $this->criterionColumnMap[$kriteriaId];
                $val = $this->editingValues[$kriteriaId] ?? null;
                $updateData[$col] = $val ?: null;
            }
        }
        
        if (!empty($updateData)) {
            $kandidat->update($updateData);
        }

        $this->closeModal(); // This already dispatches the event
        session()->flash('message', "Nilai untuk {$this->editingKandidatName} berhasil disimpan.");
    }

    public function render()
    {
        // Eager load relationships for static criteria labels
        $kandidats = \App\Models\Kandidat::with(['knDiklat', 'knSkp', 'knPenghargaan', 'knIntegritas', 'knPotensi', 'knKompetensi'])->get();

        return view('livewire.input-nilai-kandidat', [
            'kandidats' => $kandidats
        ])->layout('layouts.app');
    }
}
