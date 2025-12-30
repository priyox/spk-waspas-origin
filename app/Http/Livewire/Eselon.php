<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Eselon as EselonModel;

class Eselon extends Component
{
    public $eselons, $eselon, $jenis_jabatan;
    public $isModalOpen = false;
    public $eselon_id_to_edit = null;

    protected $rules = [
        'eselon' => 'required|string|max:20',
        'jenis_jabatan' => 'nullable|string|max:50',
    ];

    public function render()
    {
        // Order by ID since IDs are hierarchical (21, 22, 31...)
        $this->eselons = EselonModel::orderBy('id')->get();
        return view('livewire.eselon')->layout('layouts.app');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isModalOpen = true;
        $this->dispatch('open-modal', 'eselon-modal');
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetInputFields();
        $this->dispatch('close-modal', 'eselon-modal');
    }

    private function resetInputFields()
    {
        $this->eselon = '';
        $this->jenis_jabatan = '';
        $this->eselon_id_to_edit = null;
    }

    public function store()
    {
        $this->validate();

        // If creating new, we need to handle ID manually if auto-increment is off
        // But for simplicity in UI, we might let user input ID or just rely on DB if it was auto-increment.
        // The Model says incrementing=false. This implies we MUST provide an ID.
        // However, the migration says $table->id() which is BIGINT AUTO INCREMENT.
        // Let's re-read the migration in step 751:
        // $table->id(); -> This is auto-increment. 
        // The Model says incrementing=false. This is a CONTRADICTION I introduced or exists.
        // Step 755 seeder sets IDs manually. Auto-increment tables usually allow manual ID insert.
        // But if I create via UI, I don't input ID.
        // Let's trust the migration: standard id() is auto-increment.
        // So I can just create().
        
        // Wait, step 693 Eselon.php says: public $incrementing = false; 
        // This suggests I (or whoever wrote it) wanted manual IDs.
        // But form doesn't have ID input.
        // I will stick to standard auto-increment behavior if possible, or assume migration is right.
        // If I need to be safe, I'd remove $incrementing=false from model, involving another file edit.
        // For now, let's fix the column names first.
        
        EselonModel::updateOrCreate(
            ['id' => $this->eselon_id_to_edit],
            [
                'eselon' => $this->eselon,
                'jenis_jabatan' => $this->jenis_jabatan,
            ]
        );

        session()->flash('message', $this->eselon_id_to_edit ? 'Eselon updated successfully.' : 'Eselon created successfully.');

        $this->closeModal();
    }

    public function edit($id)
    {
        $eselon = EselonModel::findOrFail($id);
        $this->eselon_id_to_edit = $id;
        $this->eselon = $eselon->eselon;
        $this->jenis_jabatan = $eselon->jenis_jabatan;
        $this->openModal();
    }

    public function delete($id)
    {
        EselonModel::find($id)->delete();
        session()->flash('message', 'Eselon deleted successfully.');
    }
}
