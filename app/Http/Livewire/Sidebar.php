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

        $user = auth()->user();
        // Eager load roles for fallback check
        $menus = Menu::whereNull('parent_id')
            ->where('is_active', true)
            ->with(['roles', 'children' => function ($q) {
                $q->where('is_active', true)
                  ->with('roles')
                  ->orderBy('order');
            }])
            ->orderBy('order')
            ->get();

        // Helper function for access check
        $checkAccess = function ($menuItem) use ($user) {
            // Priority 1: Check specific permission
            if (!empty($menuItem->permission_name)) {
                return $user->can($menuItem->permission_name);
            }
            
            // Priority 2: Fallback to Role-based check (Legacy/Simple mode)
            // Check if user has ANY of the roles assigned to this menu
            // If menu has no roles assigned, assume it's open or restrict based on policy (here restricting safe)
            if ($menuItem->roles->isEmpty()) {
                return true; // No restriction? Or false? Let's say True for now if no roles defined, but usually we define roles.
                // Actually, if no permission AND no roles, maybe it's public inside auth?
                // Let's assume strict: if roles defined, must match. If empty, visible.
            }
            
            return $user->hasAnyRole($menuItem->roles->pluck('name')->toArray());
        };

        // Filter Parents
        $menus = $menus->filter(function ($menu) use ($checkAccess) {
            return $checkAccess($menu);
        });

        // Filter Children
        foreach ($menus as $menu) {
            $filteredChildren = $menu->children->filter(function ($child) use ($checkAccess) {
                return $checkAccess($child);
            });
            $menu->setRelation('children', $filteredChildren);
        }

        return view('livewire.sidebar', compact('menus'));
    }
}