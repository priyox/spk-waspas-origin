<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserManager extends Component
{
    use WithPagination;

    public $search = '';
    public $name, $email, $password, $user_id;
    public $selectedRoles = [];
    public $isModalOpen = false;

    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $users = User::with('roles')
            ->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);

        return view('livewire.user-manager', [
            'users' => $users,
            'allRoles' => Role::all()
        ])->layout('layouts.app');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->isModalOpen = true;
        $this->dispatch('open-modal', 'user-modal');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->user_id = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->selectedRoles = $user->roles->pluck('name')->toArray();
        $this->password = '';
        
        $this->isModalOpen = true;
        $this->dispatch('open-modal', 'user-modal');
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'email' => ['required', 'email', Rule::unique('users')->ignore($this->user_id)],
            'password' => $this->user_id ? 'nullable|min:6' : 'required|min:6',
        ]);

        $data = [
            'name' => $this->name,
            'email' => $this->email,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        $user = User::updateOrCreate(['id' => $this->user_id], $data);
        $user->syncRoles($this->selectedRoles);

        session()->flash('message', $this->user_id ? 'User updated successfully.' : 'User created successfully.');
        
        $this->closeModal();
    }

    public function delete($id)
    {
        if ($id == auth()->id()) {
            session()->flash('error', 'You cannot delete yourself!');
            return;
        }
        
        User::find($id)->delete();
        session()->flash('message', 'User deleted successfully.');
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetInputFields();
        $this->dispatch('close-modal', 'user-modal');
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->user_id = null;
        $this->selectedRoles = [];
    }
}
