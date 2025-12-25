<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Daftar Kandidat') }}
    </h2>
</x-slot>

<div class="py-8">
    <div class="w-full px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                @if (session()->has('message'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('message') }}</span>
                    </div>
                @endif

                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Kelola Data Kandidat</h3>
                    <button wire:click="create" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md text-sm font-medium transition-colors duration-150">
                        + Tambah Kandidat
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">No</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Informasi Kandidat</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Golongan & TMT</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jabatan & Unit Kerja</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Pendidikan</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($kandidats as $index => $kandidat)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-center">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 flex-shrink-0">
                                            <img class="h-10 w-10 rounded-full bg-indigo-100" src="https://ui-avatars.com/api/?name={{ urlencode($kandidat->nama) }}&background=6366f1&color=fff" alt="">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-bold text-gray-900 dark:text-gray-100">{{ $kandidat->nama }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">NIP: {{ $kandidat->nip }}</div>
                                            <div class="text-[10px] text-gray-400 italic">
                                                {{ $kandidat->tempat_lahir }}, {{ $kandidat->tanggal_lahir ? \Carbon\Carbon::parse($kandidat->tanggal_lahir)->translatedFormat('d-m-Y') : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $kandidat->golongan?->golongan ?? '-' }}</div>
                                    <div class="text-[10px] text-gray-500">TMT: {{ $kandidat->tmt_golongan ? \Carbon\Carbon::parse($kandidat->tmt_golongan)->format('d-m-Y') : '-' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 dark:text-gray-100 font-medium">{{ $kandidat->jabatan }}</div>
                                    <div class="text-xs text-indigo-600 dark:text-indigo-400">
                                        {{ $kandidat->eselon?->eselon ?? '' }}
                                        {{ $kandidat->jabatan_fungsional?->nama_jabatan ?? '' }}
                                        {{ $kandidat->jabatan_pelaksana?->nama_jabatan ?? '' }}
                                    </div>
                                    <div class="text-[10px] text-gray-500 mt-1">{{ $kandidat->unit_kerja?->unit_kerja ?? $kandidat->unit_kerja }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-gray-100">{{ $kandidat->tingkat_pendidikan?->tingkat ?? '-' }}</div>
                                    <div class="text-xs text-gray-500 truncate max-w-[150px]">{{ $kandidat->jurusan_pendidikan?->jurusan ?? $kandidat->jurusan }}</div>
                                    <div class="text-[10px] text-indigo-500">{{ $kandidat->bidang_ilmu?->bidang ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex items-center justify-center gap-2">
                                        <button wire:click="edit('{{ $kandidat->nip }}')" class="inline-flex items-center px-3 py-1.5 bg-amber-100 hover:bg-amber-200 text-amber-700 dark:bg-amber-900/50 dark:hover:bg-amber-900 dark:text-amber-300 rounded-lg transition-colors">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            Edit
                                        </button>
                                        <button wire:click="confirmDelete('{{ $kandidat->nip }}')" class="inline-flex items-center px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 dark:bg-red-900/50 dark:hover:bg-red-900 dark:text-red-300 rounded-lg transition-colors">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 whitespace-nowrap text-center text-sm text-gray-500 dark:text-gray-400">
                                    <div class="flex flex-col items-center">
                                        <i class="bi bi-person-x text-4xl mb-2 text-gray-300"></i>
                                        <span>Belum ada data kandidat.</span>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <x-modal name="kandidat-modal" :show="$isModalOpen" maxWidth="6xl">
                    <div class="p-8 text-gray-900 dark:text-gray-100">
                        <div class="flex items-center justify-between mb-6 border-b pb-4 dark:border-gray-700">
                            <h3 class="text-xl font-bold text-indigo-600 dark:text-indigo-400">
                                <i class="bi bi-person-plus-fill mr-2"></i>
                                {{ $kandidat_id_to_edit ? 'Edit Data Kandidat' : 'Tambah Kandidat Baru' }}
                            </h3>
                            <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>

                        <form wire:submit.prevent="store">
                            <div class="grid grid-cols-1 gap-6">
                                <!-- Section: Identitas Diri -->
                                <div class="bg-gray-50 dark:bg-gray-700/30 p-5 rounded-lg">
                                    <h4 class="text-sm font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-4 flex items-center">
                                        <span class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center text-indigo-600 dark:text-indigo-400 mr-2 text-sm font-bold">1</span>
                                        Identitas Diri
                                    </h4>
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
                                        <div>
                                            <label for="nip" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">NIP <span class="text-red-500">*</span></label>
                                            <input type="text" id="nip" wire:model="nip" placeholder="19XXXXXXXXXXXXXX" {{ $kandidat_id_to_edit ? 'disabled' : '' }}
                                                class="w-full px-4 py-3 text-base border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-100 disabled:bg-gray-100 dark:disabled:bg-gray-700 disabled:cursor-not-allowed transition-colors" />
                                            @error('nip') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label for="nama" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                                            <input type="text" id="nama" wire:model="nama" placeholder="Nama lengkap & Gelar"
                                                class="w-full px-4 py-3 text-base border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-100 transition-colors" />
                                            @error('nama') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label for="tempat_lahir" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Tempat Lahir</label>
                                            <input type="text" id="tempat_lahir" wire:model="tempat_lahir" placeholder="Kota kelahiran"
                                                class="w-full px-4 py-3 text-base border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-100 transition-colors" />
                                            @error('tempat_lahir') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label for="tanggal_lahir" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Tanggal Lahir</label>
                                            <input type="date" id="tanggal_lahir" wire:model="tanggal_lahir"
                                                class="w-full px-4 py-3 text-base border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-100 transition-colors" />
                                            @error('tanggal_lahir') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Section: Jabatan & Kepegawaian -->
                                <div class="bg-gray-50 dark:bg-gray-700/30 p-5 rounded-lg">
                                    <h4 class="text-sm font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-4 flex items-center">
                                        <span class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center text-indigo-600 dark:text-indigo-400 mr-2 text-sm font-bold">2</span>
                                        Jabatan & Kepegawaian
                                    </h4>
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
                                        <div>
                                            <label for="jenis_jabatan_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Jenis Jabatan <span class="text-red-500">*</span></label>
                                            <select id="jenis_jabatan_id" wire:model.live="jenis_jabatan_id"
                                                class="w-full px-4 py-3 text-base border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-100 transition-colors appearance-none bg-no-repeat bg-right pr-10"
                                                style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27%236b7280%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e'); background-size: 1.5em;">
                                                <option value="">-- Pilih Jenis Jabatan --</option>
                                                @foreach($jenis_jabatans as $j)
                                                    <option value="{{ $j->id }}">{{ $j->jenis_jabatan }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="md:col-span-2">
                                            <label for="jabatan" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Nama Jabatan <span class="text-red-500">*</span></label>
                                            
                                            @if($jenis_jabatan_id == 2)
                                                <select id="jabatan_fungsional_id" wire:model.live="jabatan_fungsional_id"
                                                    class="w-full px-4 py-3 text-base border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-100 transition-colors appearance-none bg-no-repeat bg-right pr-10 mb-2"
                                                    style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27%236b7280%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e'); background-size: 1.5em;">
                                                    <option value="">-- Pilih Jabatan Fungsional --</option>
                                                    @foreach($jabatan_fungsionals as $jf)
                                                        <option value="{{ $jf->id }}">{{ $jf->nama_jabatan }} ({{ $jf->jenjang }})</option>
                                                    @endforeach
                                                </select>
                                                <input type="text" id="jabatan" wire:model="jabatan" placeholder="Nama Jabatan terisi otomatis" readonly
                                                    class="w-full px-4 py-3 text-base bg-gray-100 border-2 border-gray-300 dark:border-gray-600 rounded-lg text-gray-500 cursor-not-allowed" />
                                            @elseif($jenis_jabatan_id == 3)
                                                <select id="jabatan_pelaksana_id" wire:model.live="jabatan_pelaksana_id"
                                                    class="w-full px-4 py-3 text-base border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-100 transition-colors appearance-none bg-no-repeat bg-right pr-10 mb-2"
                                                    style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27%236b7280%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e'); background-size: 1.5em;">
                                                    <option value="">-- Pilih Jabatan Pelaksana --</option>
                                                    @foreach($jabatan_pelaksanas as $jp)
                                                        <option value="{{ $jp->id }}">{{ $jp->nama_jabatan }}</option>
                                                    @endforeach
                                                </select>
                                                <input type="text" id="jabatan" wire:model="jabatan" placeholder="Nama Jabatan terisi otomatis" readonly
                                                    class="w-full px-4 py-3 text-base bg-gray-100 border-2 border-gray-300 dark:border-gray-600 rounded-lg text-gray-500 cursor-not-allowed" />
                                            @elseif(in_array($jenis_jabatan_id, [20, 30, 40]))
                                                <select id="jabatan_target_id" wire:model.live="jabatan_target_id"
                                                    class="w-full px-4 py-3 text-base border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-100 transition-colors appearance-none bg-no-repeat bg-right pr-10 mb-2"
                                                    style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27%236b7280%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e'); background-size: 1.5em;">
                                                    <option value="">-- Pilih Jabatan --</option>
                                                    @foreach($jabatan_targets as $jt)
                                                        <option value="{{ $jt->id }}">{{ $jt->nama_jabatan }}</option>
                                                    @endforeach
                                                </select>
                                                <input type="text" id="jabatan" wire:model="jabatan" placeholder="Nama Jabatan terisi otomatis" readonly
                                                    class="w-full px-4 py-3 text-base bg-gray-100 border-2 border-gray-300 dark:border-gray-600 rounded-lg text-gray-500 cursor-not-allowed" />
                                            @else
                                                <input type="text" id="jabatan" wire:model="jabatan" placeholder="Nama Jabatan Lengkap"
                                                    class="w-full px-4 py-3 text-base border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-100 transition-colors" />
                                            @endif
                                            @error('jabatan') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                        </div>

                                        <div>
                                            <label for="tmt_jabatan" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">TMT Jabatan</label>
                                            <input type="date" id="tmt_jabatan" wire:model="tmt_jabatan"
                                                class="w-full px-4 py-3 text-base border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-100 transition-colors" />
                                        </div>

                                        <!-- Eselon only for structural -->
                                        @if(in_array($jenis_jabatan_id, [20, 30, 40]))
                                        <div>
                                            <label for="eselon_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Eselon</label>
                                            <select id="eselon_id" wire:model="eselon_id" disabled
                                                class="w-full px-4 py-3 text-base border-2 border-gray-300 dark:border-gray-600 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-500 cursor-not-allowed appearance-none bg-no-repeat bg-right pr-10"
                                                style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27%239ca3af%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e'); background-size: 1.5em;">
                                                <option value="">-- Auto-filled --</option>
                                                @foreach($eselons as $e)
                                                    <option value="{{ $e->id }}">{{ $e->eselon }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @endif

                                        <div>
                                            <label for="golongan_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Golongan <span class="text-red-500">*</span></label>
                                            <select id="golongan_id" wire:model="golongan_id"
                                                class="w-full px-4 py-3 text-base border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-100 transition-colors appearance-none bg-no-repeat bg-right pr-10"
                                                style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27%236b7280%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e'); background-size: 1.5em;">
                                                <option value="">-- Pilih Golongan --</option>
                                                @foreach($golongans as $g)
                                                    <option value="{{ $g->id }}">{{ $g->golongan }} - {{ $g->pangkat }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label for="tmt_golongan" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">TMT Golongan</label>
                                            <input type="date" id="tmt_golongan" wire:model="tmt_golongan"
                                                class="w-full px-4 py-3 text-base border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-100 transition-colors" />
                                        </div>
                                        <div class="md:col-span-2">
                                            <label for="unit_kerja_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Unit Kerja <span class="text-red-500">*</span></label>
                                            <select id="unit_kerja_id" wire:model="unit_kerja_id"
                                                class="w-full px-4 py-3 text-base border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-100 transition-colors appearance-none bg-no-repeat bg-right pr-10"
                                                style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27%236b7280%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e'); background-size: 1.5em;">
                                                <option value="">-- Pilih Unit Kerja --</option>
                                                @foreach($unit_kerjas as $uk)
                                                    <option value="{{ $uk->id }}">{{ $uk->unit_kerja }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section: Pendidikan -->
                                <div class="bg-gray-50 dark:bg-gray-700/30 p-5 rounded-lg">
                                    <h4 class="text-sm font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-4 flex items-center">
                                        <span class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center text-indigo-600 dark:text-indigo-400 mr-2 text-sm font-bold">3</span>
                                        Latar Belakang Pendidikan
                                    </h4>
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
                                        <div>
                                            <label for="tingkat_pendidikan_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Tingkat Pendidikan <span class="text-red-500">*</span></label>
                                            <select id="tingkat_pendidikan_id" wire:model.live="tingkat_pendidikan_id"
                                                class="w-full px-4 py-3 text-base border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-100 transition-colors appearance-none bg-no-repeat bg-right pr-10"
                                                style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27%236b7280%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e'); background-size: 1.5em;">
                                                <option value="">-- Pilih Tingkat --</option>
                                                @foreach($tingkat_pendidikans as $tp)
                                                    <option value="{{ $tp->id }}">{{ $tp->tingkat }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="md:col-span-2">
                                            <label for="jurusan_pendidikan_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Jurusan Spesifik</label>
                                            <select id="jurusan_pendidikan_id" wire:model.live="jurusan_pendidikan_id"
                                                class="w-full px-4 py-3 text-base border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-100 transition-colors appearance-none bg-no-repeat bg-right pr-10"
                                                style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27%236b7280%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e'); background-size: 1.5em;">
                                                <option value="">-- Pilih Jurusan Spesifik --</option>
                                                @foreach($jurusan_pendidikans as $jp)
                                                    @if($jp->tingkat_pendidikan_id == $tingkat_pendidikan_id)
                                                        <option value="{{ $jp->id }}">{{ $jp->jurusan }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <p class="text-xs text-gray-400 mt-1">Jika tidak ada, isi di kolom "Keterangan Jurusan" di bawah</p>
                                        </div>
                                        <div>
                                            <label for="bidang_ilmu_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Kelompok Bidang</label>
                                            <select id="bidang_ilmu_id" wire:model="bidang_ilmu_id" disabled
                                                class="w-full px-4 py-3 text-base border-2 border-gray-300 dark:border-gray-600 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-500 cursor-not-allowed appearance-none bg-no-repeat bg-right pr-10"
                                                style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27%239ca3af%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e'); background-size: 1.5em;">
                                                <option value="">-- Auto-filled --</option>
                                                @foreach($bidang_ilmus as $bi)
                                                    <option value="{{ $bi->id }}">{{ $bi->bidang }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="md:col-span-4">
                                            <label for="jurusan" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Keterangan Jurusan (Lainnya)</label>
                                            <input type="text" id="jurusan" wire:model="jurusan" placeholder="Gunakan jika jurusan spesifik tidak tersedia di daftar"
                                                class="w-full px-4 py-3 text-base border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-100 transition-colors" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-8 flex justify-center gap-x-4">
                                <button type="button" wire:click="closeModal"
                                    class="px-8 py-3 text-base font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors">
                                    Batal
                                </button>

                                <button type="submit"
                                    class="px-8 py-3 text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition-colors flex items-center">
                                    <i class="bi bi-save mr-2"></i>
                                    Simpan Data
                                </button>
                            </div>
                        </form>
                    </div>
                </x-modal>

                <!-- Delete Confirmation Modal -->
                <div x-show="$wire.confirmingDeletion" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm" style="display: none;">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-md w-full mx-4 overflow-hidden animate-in fade-in zoom-in-95 duration-300">
                        <div class="p-6 text-center">
                            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/30 mb-4">
                                <i class="bi bi-exclamation-triangle text-red-600 dark:text-red-400 text-lg"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Hapus Kandidat</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
                                Apakah Anda yakin ingin menghapus kandidat ini? Tindakan ini tidak dapat dibatalkan.
                            </p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-4 flex gap-3 justify-center sm:flex-row flex-col-reverse">
                            <button wire:click="cancelDelete" type="button"
                                class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                Batal
                            </button>
                            <button wire:click="deleteKandidat" type="button"
                                class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition-colors">
                                Hapus
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
