<?php

use Livewire\Volt\Component;

new class extends Component
{
    public $menus;

    public function mount()
    {
        $this->menus = \App\Models\Menu::where('is_active', 1)
            ->whereNull('parent_id') // Top level menus
            ->with(['children' => function($q) {
                $q->where('is_active', 1)->orderBy('order');
            }])
            ->orderBy('order')
            ->get();
    }
}; ?>

<div class="h-screen w-64 bg-indigo-900 text-white fixed left-0 top-0 overflow-y-auto flex flex-col shadow-2xl transition-all duration-300 z-50"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
    <!-- Logo -->
    <div class="flex items-center justify-center h-20 border-b border-indigo-800 bg-indigo-950">
        <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-3">
            <x-application-logo class="block h-10 w-auto fill-current text-white" />
            <span class="text-xl font-bold tracking-wider">SPK WASPAS</span>
        </a>
    </div>

    <!-- Nav Links -->
    <nav class="flex-1 px-4 py-6 space-y-2">
        @foreach($menus as $menu)
            @php
                // Logic to hide Parent if it serves as a container (no route) but has no active children
                // "Tutup Parent" interpretation: Don't show empty categories
                $hasChildren = $menu->children->isNotEmpty();
                $isContainer = !$menu->route || $menu->route === '#';
                
                if (!$hasChildren && $isContainer) {
                    continue;
                }
                
                // Logic to Auto-Open Parent if a child is active
                // Check if any child route matches current request
                $isActiveGroup = false;
                if ($hasChildren) {
                    foreach ($menu->children as $child) {
                        if (request()->routeIs($child->route . '*')) {
                            $isActiveGroup = true;
                            break;
                        }
                    }
                }
            @endphp
            
            {{-- Category Header (if it has children or is just a label) --}}
            @if($menu->children->isNotEmpty())
                <div x-data="{ open: {{ $isActiveGroup ? 'true' : 'false' }} }">
                    <button @click="open = !open" 
                        class="flex items-center justify-between w-full px-4 py-3 rounded-lg text-indigo-100 hover:bg-indigo-800 hover:text-white transition-colors duration-200">
                        <div class="flex items-center">
                            @if($menu->icon)
                                <i class="{{ $menu->icon }} w-5 h-5 mr-3 text-center"></i>
                            @else
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                            @endif
                            <span class="text-sm font-medium">{{ $menu->menu_name }}</span>
                        </div>
                        <svg class="w-4 h-4 transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    
                    {{-- Submenu Items --}}
                    <div x-show="open" x-cloak class="mt-2 space-y-1 pl-11">
                        @foreach($menu->children as $child)
                             <a href="{{ Route::has($child->route) ? route($child->route) : '#' }}" wire:navigate 
                                class="block px-4 py-2 text-sm rounded-lg transition-colors duration-200 {{ request()->routeIs($child->route . '*') ? 'text-white bg-indigo-700' : 'text-indigo-300 hover:text-white hover:bg-indigo-800' }}">
                                {{ $child->menu_name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @else
                {{-- Single Menu Item --}}
                @if($menu->route && $menu->route !== '#')
                    <a href="{{ Route::has($menu->route) ? route($menu->route) : '#' }}" wire:navigate 
                    class="flex items-center px-4 py-3 rounded-lg transition-colors duration-200 {{ request()->routeIs($menu->route . '*') ? 'bg-indigo-700 text-white shadow-lg' : 'text-indigo-100 hover:bg-indigo-800 hover:text-white' }}">
                        @if($menu->icon)
                            <!-- Assuming icon is a class name like 'fas fa-home' or SVG path data if stored that way. 
                                 For safety, if it looks like SVG path, render SVG, else render <i> tag. 
                                 However, standardizing on simple approach first. -->
                             <i class="{{ $menu->icon }} w-5 h-5 mr-3 text-center text-lg"></i>
                        @else
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        @endif
                        <span class="text-sm font-medium">{{ $menu->menu_name }}</span>
                    </a>
                @else
                    {{-- Just a Label/Header if no route --}}
                     <p class="px-4 text-xs font-semibold text-indigo-400 uppercase tracking-wider mt-6 mb-2">{{ $menu->menu_name }}</p>
                @endif
            @endif
        @endforeach
    </nav>

</div>
