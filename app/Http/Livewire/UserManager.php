<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Str;

class UserManager extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'id';
    public $sortDirection = 'desc';
    public $perPage = 10;

    public $showModal = false;
    public $isEdit = false;
    public $modelId;

    public $name;
    public $email;
    public $password;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
    ];

    protected $validationAttributes = [
        'modelId' => 'user',
    ];

    protected $updatesQueryString = ['search', 'sortField', 'sortDirection', 'perPage'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = User::query()
            ->when($this->search, function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('email', 'like', "%{$this->search}%");
            })
            ->orderBy($this->sortField, $this->sortDirection);

        $users = $query->paginate($this->perPage);

        return view('livewire.user-manager', [
            'users' => $users,
        ]);
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function create()
    {
        $this->resetForm();
        $this->isEdit = false;
        $this->showModal = true;
        $this->dispatchBrowserEvent('show-user-modal');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->modelId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password = null;
        $this->isEdit = true;
        $this->showModal = true;
        $this->dispatchBrowserEvent('show-user-modal');
    }

    public function save()
    {
        if ($this->isEdit) {
            $rules = [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $this->modelId,
            ];
            if ($this->password) {
                $rules['password'] = 'min:6';
            }
            $this->validate($rules);

            $user = User::findOrFail($this->modelId);
            $user->name = $this->name;
            $user->email = $this->email;
            if ($this->password) {
                $user->password = bcrypt($this->password);
            }
            $user->save();
            session()->flash('message', 'User updated');
        } else {
            $this->validate();
            User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => bcrypt($this->password),
            ]);
            session()->flash('message', 'User created');
        }

        $this->showModal = false;
        $this->resetForm();
        $this->dispatchBrowserEvent('hide-user-modal');
    }

    public $confirmingDeleteId;

    public function confirmDelete($id)
    {
        $this->confirmingDeleteId = $id;
        $this->dispatchBrowserEvent('show-delete-modal');
    }

    public function delete()
    {
        if ($this->confirmingDeleteId) {
            User::find($this->confirmingDeleteId)->delete();
            session()->flash('message', 'User deleted');
            $this->confirmingDeleteId = null;
            $this->dispatchBrowserEvent('hide-delete-modal');
        }
    }

    public function resetForm()
    {
        $this->reset(['name', 'email', 'password', 'modelId', 'showModal']);
    }
}
