<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleManager extends Component
{
    public $roles, $name, $role_id;
    public $selectedPermissions = [];
    public $isModalOpen = false;

    protected $rules = [
        'name' => 'required|unique:roles,name',
    ];

    public function render()
    {
        $this->roles = Role::with('permissions')->get();
        $allPermissions = Permission::all();
        
        return view('livewire.role-manager', [
            'allPermissions' => $allPermissions
        ])->layout('layouts.app');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->isModalOpen = true;
        $this->dispatch('open-modal', 'role-modal');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $this->role_id = $id;
        $this->name = $role->name;
        $this->selectedPermissions = $role->permissions->pluck('name')->toArray();
        
        $this->isModalOpen = true;
        $this->dispatch('open-modal', 'role-modal');
    }

    public function store()
    {
        $rules = [
            'name' => 'required|unique:roles,name,' . $this->role_id,
        ];
        $this->validate($rules);

        $role = Role::updateOrCreate(['id' => $this->role_id], ['name' => $this->name]);
        $role->syncPermissions($this->selectedPermissions);

        session()->flash('message', $this->role_id ? 'Role updated successfully.' : 'Role created successfully.');
        
        $this->closeModal();
    }

    public function delete($id)
    {
        $role = Role::findOrFail($id);
        if ($role->name === 'Super Admin') {
            session()->flash('error', 'Super Admin role cannot be deleted!');
            return;
        }
        $role->delete();
        session()->flash('message', 'Role deleted successfully.');
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetInputFields();
        $this->dispatch('close-modal', 'role-modal');
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->role_id = null;
        $this->selectedPermissions = [];
    }
}
