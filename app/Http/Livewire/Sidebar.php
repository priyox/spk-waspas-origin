<?php


namespace App\Http\Livewire;


use Livewire\Component;
use App\Models\Menu;


class Sidebar extends Component
{
    public function render()
    {
        if (! auth()->check()) {
            $menus = collect();
            return view('livewire.sidebar', compact('menus'));
        }

        $roleIds = auth()->user()->roles->pluck('id');

        $menus = Menu::whereNull('parent_id')
            ->where('is_active', true)
            ->whereHas('roles', function ($q) use ($roleIds) {
                $q->whereIn('roles.id', $roleIds);
            })
            ->with(['children' => function ($q) use ($roleIds) {
                $q->where('is_active', true)
                    ->whereHas('roles', function ($q2) use ($roleIds) {
                        $q2->whereIn('roles.id', $roleIds);
                    })
                    ->orderBy('order');
            }])
            ->orderBy('order')
            ->get();

        return view('livewire.sidebar', compact('menus'));
    }
}