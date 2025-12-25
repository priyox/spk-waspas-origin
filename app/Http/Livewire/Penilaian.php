<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Services\PenilaianAutoFillService;

class Penilaian extends Component
{
    public $kandidats;
    public $kriterias;
    public $jabatanTargets;
    public $selectedJabatanId;
    public $nilais = [];
    public $autoFillCategories = []; // Menyimpan kategori untuk auto-fill
    public $validationErrors = []; // Menyimpan error validasi

    // Kriteria yang di-auto-fill
    // ID 4 = Bidang Ilmu (Auto)
    public $autoFilledKriterias = [1, 2, 3, 4];

    // Kriteria dropdown (Semua static jadi dropdown/mapped)
    // ID 8 = Diklat (Static)
    public $dropdownKriterias = [5, 6, 7, 8, 9, 10];

    // Kriteria input persentase (Deprecated)
    public $persentaseKriterias = [];

    protected $autoFillService;

    public function boot()
    {
        $this->autoFillService = app(PenilaianAutoFillService::class);
    }

    public function mount()
    {
        $this->jabatanTargets = \App\Models\JabatanTarget::all();
        $this->kriterias = \App\Models\Kriteria::all();

        // Load kandidats dengan eager loading
        $this->loadKandidats();

        // Populate Nilai dari data Kandidat (Static Criteria)
        foreach ($this->kandidats as $k) {
             // Mapping: Kriteria ID => Relation Name
             $map = [
                5 => 'knSkp',
                6 => 'knPenghargaan',
                7 => 'knIntegritas',
                8 => 'knDiklat', // ID 8 = Diklat
                9 => 'knPotensi',
                10 => 'knKompetensi'
             ];
             
             foreach ($map as $kId => $rel) {
                 // Ambil 'nilai' (1-5) dari relasi jika ada
                 if ($k->$rel) {
                     $this->nilais[$k->id][$kId] = $k->$rel->nilai;
                 }
             }
        }

        // Auto-fill kriteria yang bisa di-auto-fill (Dynamic)
        $this->autoFillNilai();
    }

    /**
     * Auto-fill nilai untuk kriteria 1, 2, 3, 8
     * SELALU override nilai auto-fill, tidak peduli ada nilai lama
     */
    public function autoFillNilai()
    {
        if (!$this->kandidats) {
            return;
        }

        $jabatanTarget = $this->selectedJabatanId
            ? \App\Models\JabatanTarget::find($this->selectedJabatanId)
            : null;

        foreach ($this->kandidats as $kandidat) {
            $autoFilledValues = $this->autoFillService->autoFillKandidat($kandidat, $jabatanTarget);

            foreach ($autoFilledValues as $kriteriaId => $nilai) {
                // SELALU override untuk kriteria auto-fill
                $this->nilais[$kandidat->id][$kriteriaId] = $nilai;
            }

            // Simpan kategori untuk tampilan
            $this->autoFillCategories[$kandidat->id] = $this->autoFillService->getAutoFillCategories($kandidat, $jabatanTarget);
        }
    }

    /**
     * Trigger auto-fill saat filter jabatan berubah
     */
    public function updatedSelectedJabatanId()
    {
        $this->loadKandidats();
        $this->autoFillNilai();
    }

    /**
     * Load semua kandidat
     * Filter tidak diperlukan - jabatan target hanya untuk menentukan syarat jabatan
     * yang digunakan dalam perhitungan nilai (berdasarkan eselon target)
     */
    private function loadKandidats()
    {
        $this->kandidats = \App\Models\Kandidat::with(['knDiklat', 'knSkp', 'knPenghargaan', 'knIntegritas', 'knPotensi', 'knKompetensi'])->get();
    }

    /**
     * Get dropdown options untuk kriteria tertentu
     */
    public function getKriteriaNilaiOptions($kriteriaId)
    {
        return $this->autoFillService->getOptionsForKriteria($kriteriaId);
    }

    /**
     * Check if kriteria is auto-filled
     */
    public function isAutoFilled($kriteriaId)
    {
        return in_array($kriteriaId, $this->autoFilledKriterias);
    }

    /**
     * Check if kriteria is dropdown
     */
    public function isDropdown($kriteriaId)
    {
        return in_array($kriteriaId, $this->dropdownKriterias);
    }

    /**
     * Check if kriteria is persentase input
     */
    public function isPersentase($kriteriaId)
    {
        return in_array($kriteriaId, $this->persentaseKriterias);
    }

    /**
     * Validasi semua field terisi
     */
    public function validateAllFilled(): bool
    {
        $this->validationErrors = [];
        $manualKriterias = array_merge($this->dropdownKriterias, $this->persentaseKriterias);

        foreach ($this->kandidats as $kandidat) {
            foreach ($manualKriterias as $kriteriaId) {
                $value = $this->nilais[$kandidat->id][$kriteriaId] ?? null;

                // Validasi berdasarkan tipe kriteria:
                if (in_array($kriteriaId, $this->dropdownKriterias)) {
                    // Dropdown (K4-K7): nilai harus 1-5, tidak boleh kosong, null, atau 0
                    if ($value === '' || $value === null || $value === 0 || $value === '0' || $value < 1 || $value > 5) {
                        $this->validationErrors[$kandidat->id][$kriteriaId] = true;
                    }
                } elseif (in_array($kriteriaId, $this->persentaseKriterias)) {
                    // Persentase (K9-K10): nilai 0-100 valid, tapi tidak boleh kosong atau null
                    // Nilai 0 diperbolehkan untuk persentase (contoh: 0% = tidak ada penghargaan)
                    if ($value === '' || $value === null || $value < 0 || $value > 100) {
                        $this->validationErrors[$kandidat->id][$kriteriaId] = true;
                    }
                }
            }
        }

        return empty($this->validationErrors);
    }

    /**
     * Cek apakah field memiliki error
     */
    public function hasError($kandidatId, $kriteriaId): bool
    {
        return isset($this->validationErrors[$kandidatId][$kriteriaId]);
    }

    /**
     * Simpan penilaian
     */
    public function save()
    {
        // Validasi dulu
        if (!$this->validateAllFilled()) {
            $totalErrors = 0;
            foreach ($this->validationErrors as $kandidatErrors) {
                $totalErrors += count($kandidatErrors);
            }
            session()->flash('error', "Terdapat {$totalErrors} field yang belum diisi. Silakan lengkapi semua data terlebih dahulu.");
            return;
        }

        foreach ($this->nilais as $kandidatId => $kriteriaValues) {
            foreach ($kriteriaValues as $kriteriaId => $value) {
                // SKIP kriteria auto-fill, jangan simpan ke database
                // Auto-fill values (K1, K2, K3, K8) hanya untuk render, tidak disimpan
                if (in_array($kriteriaId, $this->autoFilledKriterias)) {
                    continue;
                }

                // Validasi nilai sebelum simpan
                $isValid = false;
                if (in_array($kriteriaId, $this->dropdownKriterias)) {
                    // Dropdown: nilai harus 1-5
                    $isValid = ($value !== '' && $value !== null && $value >= 1 && $value <= 5);
                } elseif (in_array($kriteriaId, $this->persentaseKriterias)) {
                    // Persentase: nilai 0-100 (0 valid)
                    $isValid = ($value !== '' && $value !== null && $value >= 0 && $value <= 100);
                }

                if ($isValid) {
                    // Simpan nilai asli tanpa konversi
                    // Untuk K9 dan K10, nilai 0-100 disimpan apa adanya
                    // Konversi ke 1-5 dilakukan di WaspasProses saat perhitungan
                    \App\Models\Nilai::updateOrCreate(
                        [
                            'kandidats_id' => $kandidatId,
                            'kriteria_id' => $kriteriaId,
                        ],
                        [
                            'nilai' => $value
                        ]
                    );
                }
            }
        }

        $this->validationErrors = []; // Clear errors setelah berhasil
        session()->flash('message', 'Penilaian berhasil disimpan.');
        $this->redirect(route('waspas.proses'), navigate: true);
    }

    public function render()
    {
        $this->loadKandidats();

        // Auto-fill setiap render untuk memastikan nilai selalu update
        // Aman karena field auto-fill readonly di UI
        $this->autoFillNilai();

        return view('livewire.penilaian')
            ->layout('layouts.app');
    }
}
