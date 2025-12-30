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

                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                    <div>
                        <h3 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">Kelola Data Kandidat</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2">Daftar semua kandidat yang terdaftar dalam sistem</p>
                    </div>
                    <button wire:click="create" class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-indigo-200 dark:shadow-none hover:scale-[1.02] active:scale-[0.98]">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        Tambah Kandidat
                    </button>
                </div>

                <!-- Filters -->
                <div class="mb-8 relative max-w-md">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari NIP, Nama, Jabatan..." 
                        class="block w-full pl-11 pr-4 py-3 border-2 border-gray-100 dark:border-gray-700 rounded-xl bg-gray-50 dark:bg-gray-900 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all dark:text-white">
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
                                    <div class="text-[10px] text-gray-500 mt-1">{{ $kandidat->unitKerja?->unit_kerja ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-gray-100">{{ $kandidat->tingkat_pendidikan?->tingkat ?? '-' }}</div>
                                    <div class="text-xs text-gray-500 truncate max-w-[150px]">{{ $kandidat->jurusan_pendidikan?->jurusan ?? $kandidat->jurusan }}</div>
                                    <div class="text-[10px] text-indigo-500">{{ $kandidat->bidang_ilmu?->bidang ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex items-center justify-center gap-2">
                                        <button wire:click="showDetail('{{ $kandidat->nip }}')" class="inline-flex items-center px-3 py-1.5 bg-blue-100 hover:bg-blue-200 text-blue-700 dark:bg-blue-900/50 dark:hover:bg-blue-900 dark:text-blue-300 rounded-lg transition-colors">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            Detail
                                        </button>
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

                <div class="mt-4">
                    {{ $kandidats->links() }}
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
                                            <input type="text" id="nip" wire:model="nip" placeholder="19XXXXXXXXXXXXXX"
                                                class="w-full px-4 py-3 text-base border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-100 transition-colors" />
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
                                    </div>
                                </div>
                            </div>

                            <!-- Section 5: Penilaian (Optional) -->
                            <div class="bg-gray-50 dark:bg-gray-700/30 p-5 rounded-lg">
                                <h4 class="text-sm font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-4 flex items-center">
                                    <span class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center text-indigo-600 dark:text-indigo-400 mr-2 text-sm font-bold">4</span>
                                    Penilaian (Opsional)
                                </h4>
                                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-5">
                                    <div class="flex items-start">
                                        <i class="bi bi-info-circle text-blue-600 dark:text-blue-400 text-lg mr-3 mt-0.5"></i>
                                        <div class="text-sm text-blue-800 dark:text-blue-200">
                                            <p class="font-semibold mb-1">Nilai penilaian dapat diisi sekarang atau nanti saat edit.</p>
                                            <p class="text-xs">Kriteria K1-K4 (Pangkat, Masa Jabatan, Pendidikan, Bidang Ilmu) akan dihitung otomatis berdasarkan data kandidat.</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <!-- K5: SKP -->
                                    <div>
                                        <label for="kn_id_skp" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                            K5: Predikat Kinerja (SKP)
                                        </label>
                                        <select id="kn_id_skp" wire:model="kn_id_skp"
                                            class="w-full px-4 py-3 text-base border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-100 transition-colors">
                                            <option value="">-- Pilih Predikat --</option>
                                            @foreach($kriteriaNilaiOptions[5] ?? [] as $option)
                                                <option value="{{ $option['id'] }}">{{ $option['kategori'] }} (Nilai: {{ $option['nilai'] }})</option>
                                            @endforeach
                                        </select>
                                        @error('kn_id_skp') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- K6: Penghargaan -->
                                    <div>
                                        <label for="kn_id_penghargaan" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                            K6: Penghargaan
                                        </label>
                                        <select id="kn_id_penghargaan" wire:model="kn_id_penghargaan"
                                            class="w-full px-4 py-3 text-base border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-100 transition-colors">
                                            <option value="">-- Pilih Penghargaan --</option>
                                            @foreach($kriteriaNilaiOptions[6] ?? [] as $option)
                                                <option value="{{ $option['id'] }}">{{ $option['kategori'] }} (Nilai: {{ $option['nilai'] }})</option>
                                            @endforeach
                                        </select>
                                        @error('kn_id_penghargaan') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- K7: Integritas -->
                                    <div>
                                        <label for="kn_id_integritas" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                            K7: Integritas
                                        </label>
                                        <select id="kn_id_integritas" wire:model="kn_id_integritas"
                                            class="w-full px-4 py-3 text-base border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-100 transition-colors">
                                            <option value="">-- Pilih Integritas --</option>
                                            @foreach($kriteriaNilaiOptions[7] ?? [] as $option)
                                                <option value="{{ $option['id'] }}">{{ $option['kategori'] }} (Nilai: {{ $option['nilai'] }})</option>
                                            @endforeach
                                        </select>
                                        @error('kn_id_integritas') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- K8: Diklat -->
                                    <div>
                                        <label for="kn_id_diklat" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                            K8: Diklat Struktural
                                        </label>
                                        <select id="kn_id_diklat" wire:model="kn_id_diklat"
                                            class="w-full px-4 py-3 text-base border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-100 transition-colors">
                                            <option value="">-- Pilih Diklat --</option>
                                            @foreach($kriteriaNilaiOptions[8] ?? [] as $option)
                                                <option value="{{ $option['id'] }}">{{ $option['kategori'] }} (Nilai: {{ $option['nilai'] }})</option>
                                            @endforeach
                                        </select>
                                        @error('kn_id_diklat') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- K9: Potensi -->
                                    <div>
                                        <label for="kn_id_potensi" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                            K9: Potensi
                                        </label>
                                        <select id="kn_id_potensi" wire:model="kn_id_potensi"
                                            class="w-full px-4 py-3 text-base border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-100 transition-colors">
                                            <option value="">-- Pilih Potensi --</option>
                                            @foreach($kriteriaNilaiOptions[9] ?? [] as $option)
                                                <option value="{{ $option['id'] }}">{{ $option['kategori'] }} (Nilai: {{ $option['nilai'] }})</option>
                                            @endforeach
                                        </select>
                                        @error('kn_id_potensi') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- K10: Kompetensi -->
                                    <div>
                                        <label for="kn_id_kompetensi" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                            K10: Kompetensi
                                        </label>
                                        <select id="kn_id_kompetensi" wire:model="kn_id_kompetensi"
                                            class="w-full px-4 py-3 text-base border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-100 transition-colors">
                                            <option value="">-- Pilih Kompetensi --</option>
                                            @foreach($kriteriaNilaiOptions[10] ?? [] as $option)
                                                <option value="{{ $option['id'] }}">{{ $option['kategori'] }} (Nilai: {{ $option['nilai'] }})</option>
                                            @endforeach
                                        </select>
                                        @error('kn_id_kompetensi') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
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

                <!-- Detail Modal -->
                @if($showingDetail && $detailKandidatNip)
                    @php
                        $detailKandidat = \App\Models\Kandidat::with([
                            'golongan', 'eselon', 'tingkat_pendidikan', 'bidang_ilmu', 
                            'unitKerja', 'jurusan_pendidikan', 'jabatan_fungsional', 
                            'jabatan_pelaksana', 'jenis_jabatan',
                            'knDiklat', 'knSkp', 'knPenghargaan', 'knIntegritas', 
                            'knPotensi', 'knKompetensi'
                        ])->where('nip', $detailKandidatNip)->first();
                    @endphp

                    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-4xl w-full mx-4 max-h-[90vh] overflow-y-auto">
                            <!-- Modal Header -->
                            <div class="sticky top-0 bg-gradient-to-r from-blue-600 to-indigo-600 p-6 rounded-t-xl">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-4">
                                        <div class="h-16 w-16 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center">
                                            <i class="bi bi-person-badge text-3xl text-white"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-2xl font-bold text-white">Detail Kandidat</h3>
                                            <p class="text-blue-100 text-sm">Informasi Lengkap Pegawai</p>
                                        </div>
                                    </div>
                                    <button wire:click="closeDetailModal" class="text-white/80 hover:text-white transition-colors">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Modal Body -->
                            <div class="p-6 space-y-6">
                                <!-- Personal Information -->
                                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-lg p-5 border border-blue-200 dark:border-blue-800">
                                    <h4 class="text-lg font-bold text-blue-900 dark:text-blue-100 mb-4 flex items-center">
                                        <i class="bi bi-person-circle mr-2"></i>
                                        Data Pribadi
                                    </h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">NIP</label>
                                            <p class="text-base font-medium text-gray-900 dark:text-gray-100 mt-1">{{ $detailKandidat->nip }}</p>
                                        </div>
                                        <div>
                                            <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nama Lengkap</label>
                                            <p class="text-base font-medium text-gray-900 dark:text-gray-100 mt-1">{{ $detailKandidat->nama }}</p>
                                        </div>
                                        <div>
                                            <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tempat Lahir</label>
                                            <p class="text-base font-medium text-gray-900 dark:text-gray-100 mt-1">{{ $detailKandidat->tempat_lahir ?? '-' }}</p>
                                        </div>
                                        <div>
                                            <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal Lahir</label>
                                            <p class="text-base font-medium text-gray-900 dark:text-gray-100 mt-1">
                                                {{ $detailKandidat->tanggal_lahir ? \Carbon\Carbon::parse($detailKandidat->tanggal_lahir)->translatedFormat('d F Y') : '-' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Position Information -->
                                <div class="bg-gradient-to-br from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 rounded-lg p-5 border border-purple-200 dark:border-purple-800">
                                    <h4 class="text-lg font-bold text-purple-900 dark:text-purple-100 mb-4 flex items-center">
                                        <i class="bi bi-briefcase-fill mr-2"></i>
                                        Informasi Jabatan
                                    </h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Jenis Jabatan</label>
                                            <p class="text-base font-medium text-gray-900 dark:text-gray-100 mt-1">{{ $detailKandidat->jenis_jabatan?->jenis_jabatan ?? '-' }}</p>
                                        </div>
                                        <div>
                                            <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nama Jabatan</label>
                                            <p class="text-base font-medium text-gray-900 dark:text-gray-100 mt-1">{{ $detailKandidat->jabatan ?? '-' }}</p>
                                        </div>
                                        <div>
                                            <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Eselon</label>
                                            <p class="text-base font-medium text-gray-900 dark:text-gray-100 mt-1">{{ $detailKandidat->eselon?->eselon ?? '-' }}</p>
                                        </div>
                                        <div>
                                            <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">TMT Jabatan</label>
                                            <p class="text-base font-medium text-gray-900 dark:text-gray-100 mt-1">
                                                {{ $detailKandidat->tmt_jabatan ? \Carbon\Carbon::parse($detailKandidat->tmt_jabatan)->translatedFormat('d F Y') : '-' }}
                                            </p>
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Unit Kerja</label>
                                            <p class="text-base font-medium text-gray-900 dark:text-gray-100 mt-1">{{ $detailKandidat->unitKerja?->unit_kerja ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Rank Information -->
                                <div class="bg-gradient-to-br from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 rounded-lg p-5 border border-amber-200 dark:border-amber-800">
                                    <h4 class="text-lg font-bold text-amber-900 dark:text-amber-100 mb-4 flex items-center">
                                        <i class="bi bi-award-fill mr-2"></i>
                                        Kepangkatan
                                    </h4>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div>
                                            <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Golongan</label>
                                            <p class="text-base font-medium text-gray-900 dark:text-gray-100 mt-1">{{ $detailKandidat->golongan?->golongan ?? '-' }}</p>
                                        </div>
                                        <div>
                                            <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Pangkat</label>
                                            <p class="text-base font-medium text-gray-900 dark:text-gray-100 mt-1">{{ $detailKandidat->golongan?->pangkat ?? '-' }}</p>
                                        </div>
                                        <div>
                                            <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">TMT Golongan</label>
                                            <p class="text-base font-medium text-gray-900 dark:text-gray-100 mt-1">
                                                {{ $detailKandidat->tmt_golongan ? \Carbon\Carbon::parse($detailKandidat->tmt_golongan)->translatedFormat('d F Y') : '-' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Education Information -->
                                <div class="bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-lg p-5 border border-green-200 dark:border-green-800">
                                    <h4 class="text-lg font-bold text-green-900 dark:text-green-100 mb-4 flex items-center">
                                        <i class="bi bi-mortarboard-fill mr-2"></i>
                                        Latar Belakang Pendidikan
                                    </h4>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div>
                                            <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tingkat Pendidikan</label>
                                            <p class="text-base font-medium text-gray-900 dark:text-gray-100 mt-1">{{ $detailKandidat->tingkat_pendidikan?->tingkat ?? '-' }}</p>
                                        </div>
                                        <div>
                                            <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Jurusan</label>
                                            <p class="text-base font-medium text-gray-900 dark:text-gray-100 mt-1">{{ $detailKandidat->jurusan_pendidikan?->jurusan ?? $detailKandidat->jurusan ?? '-' }}</p>
                                        </div>
                                        <div>
                                            <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Bidang Ilmu</label>
                                            <p class="text-base font-medium text-gray-900 dark:text-gray-100 mt-1">{{ $detailKandidat->bidang_ilmu?->bidang ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Assessment Scores -->
                                <div class="bg-gradient-to-br from-indigo-50 to-blue-50 dark:from-indigo-900/20 dark:to-blue-900/20 rounded-lg p-5 border border-indigo-200 dark:border-indigo-800">
                                    <h4 class="text-lg font-bold text-indigo-900 dark:text-indigo-100 mb-4 flex items-center">
                                        <i class="bi bi-clipboard-data-fill mr-2"></i>
                                        Nilai
                                    </h4>
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                        <div class="bg-white dark:bg-gray-700/50 rounded-lg p-3 border border-gray-200 dark:border-gray-600">
                                            <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">SKP</label>
                                            <p class="text-base font-bold text-indigo-600 dark:text-indigo-400 mt-1">
                                                {{ $detailKandidat->knSkp?->kategori ?? '-' }}
                                            </p>
                                            @if($detailKandidat->knSkp)
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Nilai: {{ $detailKandidat->knSkp->nilai }}</p>
                                            @endif
                                        </div>
                                        <div class="bg-white dark:bg-gray-700/50 rounded-lg p-3 border border-gray-200 dark:border-gray-600">
                                            <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Penghargaan</label>
                                            <p class="text-base font-bold text-indigo-600 dark:text-indigo-400 mt-1">
                                                {{ $detailKandidat->knPenghargaan?->kategori ?? '-' }}
                                            </p>
                                            @if($detailKandidat->knPenghargaan)
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Nilai: {{ $detailKandidat->knPenghargaan->nilai }}</p>
                                            @endif
                                        </div>
                                        <div class="bg-white dark:bg-gray-700/50 rounded-lg p-3 border border-gray-200 dark:border-gray-600">
                                            <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Integritas</label>
                                            <p class="text-base font-bold text-indigo-600 dark:text-indigo-400 mt-1">
                                                {{ $detailKandidat->knIntegritas?->kategori ?? '-' }}
                                            </p>
                                            @if($detailKandidat->knIntegritas)
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Nilai: {{ $detailKandidat->knIntegritas->nilai }}</p>
                                            @endif
                                        </div>
                                        <div class="bg-white dark:bg-gray-700/50 rounded-lg p-3 border border-gray-200 dark:border-gray-600">
                                            <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Diklat</label>
                                            <p class="text-base font-bold text-indigo-600 dark:text-indigo-400 mt-1">
                                                {{ $detailKandidat->knDiklat?->kategori ?? '-' }}
                                            </p>
                                            @if($detailKandidat->knDiklat)
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Nilai: {{ $detailKandidat->knDiklat->nilai }}</p>
                                            @endif
                                        </div>
                                        <div class="bg-white dark:bg-gray-700/50 rounded-lg p-3 border border-gray-200 dark:border-gray-600">
                                            <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Potensi</label>
                                            <p class="text-base font-bold text-indigo-600 dark:text-indigo-400 mt-1">
                                                {{ $detailKandidat->knPotensi?->kategori ?? '-' }}
                                            </p>
                                            @if($detailKandidat->knPotensi)
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Nilai: {{ $detailKandidat->knPotensi->nilai }}</p>
                                            @endif
                                        </div>
                                        <div class="bg-white dark:bg-gray-700/50 rounded-lg p-3 border border-gray-200 dark:border-gray-600">
                                            <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kompetensi</label>
                                            <p class="text-base font-bold text-indigo-600 dark:text-indigo-400 mt-1">
                                                {{ $detailKandidat->knKompetensi?->kategori ?? '-' }}
                                            </p>
                                            @if($detailKandidat->knKompetensi)
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Nilai: {{ $detailKandidat->knKompetensi->nilai }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Footer -->
                            <div class="sticky bottom-0 bg-gray-50 dark:bg-gray-700/50 px-6 py-4 rounded-b-xl border-t border-gray-200 dark:border-gray-600">
                                <button wire:click="closeDetailModal" type="button"
                                    class="w-full px-6 py-3 text-base font-medium text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl">
                                    <i class="bi bi-x-circle mr-2"></i>
                                    Tutup
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
