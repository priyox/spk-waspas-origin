<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\JurusanPendidikan as JurusanPendidikanModel;
use App\Models\TingkatPendidikan;
use App\Models\BidangIlmu;

use Livewire\WithPagination;

class JurusanPendidikan extends Component // Renamed to avoid class name conflict with Model if in same namespace, but here namespace is different
{
    use WithPagination;

    // public $jurusans; // Removed to use direct view passing for pagination
    public $nama_jurusan, $tingkat_pendidikan_id, $bidang_ilmu_id;
    public $search = '';
    public $isModalOpen = false;
    public $jurusan_id_to_edit = null;

    // Options for dropdowns
    public $tingkat_pendidikan_options;
    public $bidang_ilmu_options;

    protected $rules = [
        'nama_jurusan' => 'required|string|max:255',
        'tingkat_pendidikan_id' => 'required|exists:tingkat_pendidikans,id', // or nullable? Assuming required based on logic
        'bidang_ilmu_id' => 'nullable|exists:bidang_ilmus,id',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        // Preload options
        $this->tingkat_pendidikan_options = \App\Models\TingkatPendidikan::all();
        $this->bidang_ilmu_options = BidangIlmu::all();
    }

    public function render()
    {
        $jurusans = JurusanPendidikanModel::with(['tingkat_pendidikan', 'bidang_ilmu'])
            ->where('nama_jurusan', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.jurusan-pendidikan', [
            'jurusans' => $jurusans
        ])->layout('layouts.app');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isModalOpen = true;
        // Dispatch event if using browser events for modal
        $this->dispatch('open-modal', 'jurusan-modal'); 
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetInputFields();
        $this->dispatch('close-modal', 'jurusan-modal');
    }

    private function resetInputFields()
    {
        $this->nama_jurusan = '';
        $this->tingkat_pendidikan_id = '';
        $this->bidang_ilmu_id = '';
        $this->jurusan_id_to_edit = null;
    }

    public function store()
    {
        $this->validate();

        JurusanPendidikanModel::updateOrCreate(
            ['id' => $this->jurusan_id_to_edit],
            [
                'nama_jurusan' => $this->nama_jurusan,
                'tingkat_pendidikan_id' => $this->tingkat_pendidikan_id,
                'bidang_ilmu_id' => $this->bidang_ilmu_id,
            ]
        );

        session()->flash('message', $this->jurusan_id_to_edit ? 'Jurusan Pendidikan updated successfully.' : 'Jurusan Pendidikan created successfully.');

        $this->closeModal();
    }

    public function edit($id)
    {
        $jurusan = JurusanPendidikanModel::findOrFail($id);
        $this->jurusan_id_to_edit = $id;
        $this->nama_jurusan = $jurusan->nama_jurusan;
        $this->tingkat_pendidikan_id = $jurusan->tingkat_pendidikan_id;
        $this->bidang_ilmu_id = $jurusan->bidang_ilmu_id;
        $this->openModal();
    }

    public function delete($id)
    {
        JurusanPendidikanModel::find($id)->delete();
        session()->flash('message', 'Jurusan Pendidikan deleted successfully.');
    }
}
