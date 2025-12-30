<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Services\PenilaianAutoFillService;

use Livewire\WithPagination;

class Kandidat extends Component
{
    use WithPagination;

    // public $kandidats; // Removed
    public $nip, $nama, $tempat_lahir, $tanggal_lahir, $jabatan, $tmt_golongan, $tmt_jabatan, $jurusan;
    public $golongan_id, $jenis_jabatan_id, $eselon_id, $tingkat_pendidikan_id, $jurusan_pendidikan_id, $jabatan_fungsional_id, $jabatan_pelaksana_id, $jabatan_target_id, $bidang_ilmu_id, $unit_kerja_id;
    
    public $search = '';
    
    public $isModalOpen = false;
    public $kandidat_id_to_edit = null;
    public $confirmingDeletion = false;
    public $deleteNip = null;
    public $showingDetail = false;
    public $detailKandidatNip = null;
    
    // Assessment fields (K5-K10)
    public $kn_id_skp, $kn_id_penghargaan, $kn_id_integritas;
    public $kn_id_diklat, $kn_id_potensi, $kn_id_kompetensi;
    
    // Kriteria nilai options for dropdowns
    public $kriteriaNilaiOptions = [];
    
    protected $autoFillService;

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
        'jabatan_target_id' => 'nullable|exists:jabatan_targets,id',
        'bidang_ilmu_id' => 'nullable|exists:bidang_ilmus,id',
        'unit_kerja_id' => 'nullable|exists:unit_kerjas,id',
        'jurusan' => 'nullable|string|max:255',
        // Assessment fields
        'kn_id_skp' => 'nullable|exists:kriteria_nilais,id',
        'kn_id_penghargaan' => 'nullable|exists:kriteria_nilais,id',
        'kn_id_integritas' => 'nullable|exists:kriteria_nilais,id',
        'kn_id_diklat' => 'nullable|exists:kriteria_nilais,id',
        'kn_id_potensi' => 'nullable|exists:kriteria_nilais,id',
        'kn_id_kompetensi' => 'nullable|exists:kriteria_nilais,id',
    ];

    public function boot()
    {
        $this->autoFillService = app(PenilaianAutoFillService::class);
    }
    
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $kandidats = \App\Models\Kandidat::with([
            'golongan', 
            'eselon', 
            'tingkat_pendidikan', 
            'bidang_ilmu', 
            'unitKerja',
            'jurusan_pendidikan',
            'jabatan_fungsional',
            'jabatan_pelaksana'
        ])
        ->where(function($query) {
            $query->where('nama', 'like', '%' . $this->search . '%')
                  ->orWhere('nip', 'like', '%' . $this->search . '%')
                  ->orWhere('jabatan', 'like', '%' . $this->search . '%');
        })
        ->orderBy('id', 'desc')
        ->paginate(10);
        
        // Load kriteria nilai options for assessment dropdowns
        $this->kriteriaNilaiOptions = [
            5 => $this->autoFillService->getOptionsForKriteria(5),  // SKP
            6 => $this->autoFillService->getOptionsForKriteria(6),  // Penghargaan
            7 => $this->autoFillService->getOptionsForKriteria(7),  // Integritas
            8 => $this->autoFillService->getOptionsForKriteria(8),  // Diklat
            9 => $this->autoFillService->getOptionsForKriteria(9),  // Potensi
            10 => $this->autoFillService->getOptionsForKriteria(10), // Kompetensi
        ];
        
        return view('livewire.kandidat', [
            'kandidats' => $kandidats,
            'golongans' => \App\Models\Golongan::all(),
            'jenis_jabatans' => \App\Models\JenisJabatan::all(),
            'tingkat_pendidikans' => \App\Models\TingkatPendidikan::all(),
            'bidang_ilmus' => \App\Models\BidangIlmu::all(),
            'eselons' => \App\Models\Eselon::all(),
            'unit_kerjas' => \App\Models\UnitKerja::all(),
            'jurusan_pendidikans' => \App\Models\JurusanPendidikan::all(),
            'jabatan_fungsionals' => \App\Models\JabatanFungsional::all(),
            'jabatan_pelaksanas' => \App\Models\JabatanPelaksana::all(),
            'jabatan_targets' => \App\Models\JabatanTarget::all(),
        ])->layout('layouts.app');
    }

    public function updatedTingkatPendidikanId()
    {
        $this->jurusan_pendidikan_id = null;
    }

    public function updatedJurusanPendidikanId($value)
    {
        if ($value) {
            $jurusan = \App\Models\JurusanPendidikan::find($value);
            if ($jurusan) {
                $this->bidang_ilmu_id = $jurusan->bidang_ilmu_id;
            }
        }
    }



    public function updatedJabatanFungsionalId($value)
    {
        if ($value) {
            $jw = \App\Models\JabatanFungsional::find($value);
            if ($jw) $this->jabatan = $jw->nama_jabatan;
        }
    }

    public function updatedJabatanPelaksanaId($value)
    {
        if ($value) {
            $jp = \App\Models\JabatanPelaksana::find($value);
            if ($jp) $this->jabatan = $jp->nama_jabatan;
        }
    }

    public function updatedJabatanTargetId($value)
    {
        if ($value) {
            $jt = \App\Models\JabatanTarget::find($value);
            if ($jt) {
                $this->jabatan = $jt->nama_jabatan;
                $this->eselon_id = $jt->id_eselon;
            }
        }
    }

    public function create()
    {
        $this->resetInputFields();
        $this->isModalOpen = true;
        
        $this->dispatch('open-modal', 'kandidat-modal');
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

        $data = [
            'nip' => $this->nip,
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
            'jabatan_target_id' => $this->jabatan_target_id ?: null,
            'bidang_ilmu_id' => $this->bidang_ilmu_id ?: null,
            'unit_kerja_id' => $this->unit_kerja_id ?: null,
            'jurusan' => $this->jurusan,
            // Assessment fields
            'kn_id_skp' => $this->kn_id_skp ?: null,
            'kn_id_penghargaan' => $this->kn_id_penghargaan ?: null,
            'kn_id_integritas' => $this->kn_id_integritas ?: null,
            'kn_id_diklat' => $this->kn_id_diklat ?: null,
            'kn_id_potensi' => $this->kn_id_potensi ?: null,
            'kn_id_kompetensi' => $this->kn_id_kompetensi ?: null,
        ];

        if ($this->kandidat_id_to_edit) {
            // Update existing kandidat by ID
            $kandidat = \App\Models\Kandidat::findOrFail($this->kandidat_id_to_edit);
            $kandidat->update($data);
            session()->flash('message', 'Kandidat updated successfully.');
        } else {
            // Create new kandidat
            \App\Models\Kandidat::create($data);
            session()->flash('message', 'Kandidat created successfully.');
        }

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
        $this->jabatan_target_id = $kandidat->jabatan_target_id;
        $this->bidang_ilmu_id = $kandidat->bidang_ilmu_id;
        $this->unit_kerja_id = $kandidat->unit_kerja_id;
        $this->jurusan = $kandidat->jurusan;
        
        // Load assessment values
        $this->kn_id_skp = $kandidat->kn_id_skp;
        $this->kn_id_penghargaan = $kandidat->kn_id_penghargaan;
        $this->kn_id_integritas = $kandidat->kn_id_integritas;
        $this->kn_id_diklat = $kandidat->kn_id_diklat;
        $this->kn_id_potensi = $kandidat->kn_id_potensi;
        $this->kn_id_kompetensi = $kandidat->kn_id_kompetensi;
        
        $this->kandidat_id_to_edit = $kandidat->id; // Store ID instead of NIP
        $this->isModalOpen = true;

        
        $this->dispatch('open-modal', 'kandidat-modal');
    }

    public function confirmDelete($nip)
    {
        $this->confirmingDeletion = true;
        $this->deleteNip = $nip;
    }

    public function deleteKandidat()
    {
        // Super Admin view-only restriction
        if (auth()->user()->hasRole('Super Admin')) {
            session()->flash('error', 'Super Admin hanya memiliki akses view. Tidak dapat menghapus data.');
            $this->confirmingDeletion = false;
            $this->deleteNip = null;
            return;
        }

        if ($this->deleteNip) {
            \App\Models\Kandidat::where('nip', $this->deleteNip)->delete();
            session()->flash('message', 'Kandidat deleted successfully.');
        }
        $this->confirmingDeletion = false;
        $this->deleteNip = null;
    }

    public function cancelDelete()
    {
        $this->confirmingDeletion = false;
        $this->deleteNip = null;
    }

    public function showDetail($nip)
    {
        $this->detailKandidatNip = $nip;
        $this->showingDetail = true;
    }

    public function closeDetailModal()
    {
        $this->showingDetail = false;
        $this->detailKandidatNip = null;
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
        $this->jabatan_target_id = '';
        $this->bidang_ilmu_id = '';
        $this->unit_kerja_id = '';
        $this->jurusan = '';
        // Reset assessment fields
        $this->kn_id_skp = null;
        $this->kn_id_penghargaan = null;
        $this->kn_id_integritas = null;
        $this->kn_id_diklat = null;
        $this->kn_id_potensi = null;
        $this->kn_id_kompetensi = null;
        $this->kandidat_id_to_edit = null;
    }
}
