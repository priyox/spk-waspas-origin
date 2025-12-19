<?php

use Livewire\Volt\Component;

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

<div class="h-screen w-64 bg-indigo-900 text-white fixed left-0 top-0 overflow-y-auto flex flex-col shadow-2xl transition-all duration-300 z-50">
    <!-- Logo -->
    <div class="flex items-center justify-center h-20 border-b border-indigo-800 bg-indigo-950">
        <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-3">
            <x-application-logo class="block h-10 w-auto fill-current text-white" />
            <span class="text-xl font-bold tracking-wider">SPK WASPAS</span>
        </a>
    </div>

    <!-- Nav Links -->
    <nav class="flex-1 px-4 py-6 space-y-2">
        <p class="px-4 text-xs font-semibold text-indigo-400 uppercase tracking-wider mb-2">Main Menu</p>
        
        <a href="{{ route('dashboard') }}" wire:navigate 
           class="flex items-center px-4 py-3 rounded-lg transition-colors duration-200 {{ request()->routeIs('dashboard') ? 'bg-indigo-700 text-white shadow-lg' : 'text-indigo-100 hover:bg-indigo-800 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
            </svg>
            Dashboard
        </a>

        <p class="px-4 text-xs font-semibold text-indigo-400 uppercase tracking-wider mt-6 mb-2">Data Master</p>
        
        <a href="{{ route('kandidat.index') }}" wire:navigate 
           class="flex items-center px-4 py-3 rounded-lg transition-colors duration-200 {{ request()->routeIs('kandidat.*') ? 'bg-indigo-700 text-white shadow-lg' : 'text-indigo-100 hover:bg-indigo-800 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            Candidates
        </a>

        <a href="{{ route('kriteria.index') }}" wire:navigate 
           class="flex items-center px-4 py-3 rounded-lg transition-colors duration-200 {{ request()->routeIs('kriteria.*') ? 'bg-indigo-700 text-white shadow-lg' : 'text-indigo-100 hover:bg-indigo-800 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
            </svg>
            Criteria
        </a>

        <p class="px-4 text-xs font-semibold text-indigo-400 uppercase tracking-wider mt-6 mb-2">Process</p>

        <a href="{{ route('penilaian.input') }}" wire:navigate 
           class="flex items-center px-4 py-3 rounded-lg transition-colors duration-200 {{ request()->routeIs('penilaian.*') ? 'bg-indigo-700 text-white shadow-lg' : 'text-indigo-100 hover:bg-indigo-800 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Assessment
        </a>

        <a href="{{ route('waspas.hasil') }}" wire:navigate 
           class="flex items-center px-4 py-3 rounded-lg transition-colors duration-200 {{ request()->routeIs('waspas.*') ? 'bg-indigo-700 text-white shadow-lg' : 'text-indigo-100 hover:bg-indigo-800 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
            Results
        </a>
    </nav>

</div>
