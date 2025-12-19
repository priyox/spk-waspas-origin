<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $kandidatCount = \App\Models\Kandidat::count();
        $kriteriaCount = \App\Models\Kriteria::count();
        $userCount = \App\Models\User::count();
        $jabatanCount = \App\Models\JenisJabatan::count();
        // Calculate progress: candidates with scores vs total
        $scoredCandidates = \App\Models\Nilai::distinct('nip')->count('nip');
        $resultsCount = $scoredCandidates . ' / ' . $kandidatCount . ' Dinilai';

        return view('livewire.dashboard', compact('kandidatCount', 'kriteriaCount', 'resultsCount', 'userCount', 'jabatanCount'))
            ->layout('layouts.app');
    }
}
