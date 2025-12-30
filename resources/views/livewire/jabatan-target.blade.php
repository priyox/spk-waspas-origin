<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Jabatan Target') }}
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
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Jabatan Target</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Kelola data jabatan target untuk penilaian WASPAS</p>
                    </div>
                    <button wire:click="create" class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-indigo-200 dark:shadow-none hover:scale-[1.02] active:scale-[0.98]">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        Tambah Jabatan Target
                    </button>
                </div>

                <!-- Filters -->
                <div class="mb-8 relative max-w-md">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari Jabatan..." 
                        class="block w-full pl-11 pr-4 py-3 border-2 border-gray-100 dark:border-gray-700 rounded-xl bg-gray-50 dark:bg-gray-900 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all dark:text-white">
                </div>

                <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">No</th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Nama Jabatan</th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Eselon</th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Bidang Ilmu</th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($jabatanTargets as $index => $jabatan)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white font-medium">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $jabatan->nama_jabatan }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                                        {{ $jabatan->eselon->eselon ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                    <div class="flex flex-wrap gap-1">
                                        @forelse($jabatan->bidangIlmu as $bidang)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                {{ $bidang->bidang }}
                                            </span>
                                        @empty
                                            -
                                        @endforelse
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex items-center justify-center gap-2">
                                        <button wire:click="edit({{ $jabatan->id }})" class="inline-flex items-center px-3 py-1.5 bg-amber-100 hover:bg-amber-200 text-amber-700 dark:bg-amber-900/50 dark:hover:bg-amber-900 dark:text-amber-300 rounded-lg transition-colors">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            Edit
                                        </button>
                                        <button wire:click="confirmDelete({{ $jabatan->id }})" class="inline-flex items-center px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 dark:bg-red-900/50 dark:hover:bg-red-900 dark:text-red-300 rounded-lg transition-colors">
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
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                        <p class="text-gray-500 dark:text-gray-400 font-medium">Tidak ada data jabatan target</p>
                                        <p class="text-gray-400 dark:text-gray-500 text-sm mt-1">Klik tombol "Tambah Jabatan Target" untuk menambah data baru</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $jabatanTargets->links() }}
                </div>

                <x-modal name="jabatan-modal" :show="$isModalOpen" maxWidth="xl">
                    <div class="p-8 text-gray-900 dark:text-gray-100">
                        <div class="flex items-center justify-between mb-6 border-b pb-4 dark:border-gray-700">
                            <h3 class="text-xl font-bold text-indigo-600 dark:text-indigo-400">
                                <i class="bi bi-briefcase mr-2"></i>
                                {{ $jabatan_id_to_edit ? 'Edit Jabatan Target' : 'Tambah Jabatan Target' }}
                            </h3>
                            <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>

                        <form wire:submit.prevent="store">
                            <div class="space-y-5">
                                <!-- Nama Jabatan -->
                                <div>
                                    <label for="nama_jabatan" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Nama Jabatan <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="nama_jabatan" wire:model="nama_jabatan" placeholder="Masukkan nama jabatan target"
                                        class="w-full px-4 py-3 text-base border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-100 transition-colors" />
                                    @error('nama_jabatan') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>

                                <!-- Eselon -->
                                <div>
                                    <label for="id_eselon" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Eselon <span class="text-red-500">*</span>
                                    </label>
                                    <select id="id_eselon" wire:model="id_eselon"
                                        class="w-full px-4 py-3 text-base border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-100 transition-colors appearance-none bg-no-repeat bg-right pr-10"
                                        style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27%236b7280%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e'); background-size: 1.5em;">
                                        <option value="">-- Pilih Eselon --</option>
                                        @foreach($eselons as $eselon)
                                            <option value="{{ $eselon->id }}">{{ $eselon->eselon }}</option>
                                        @endforeach
                                    </select>
                                    @error('id_eselon') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>

                                <!-- Bidang Ilmu (Dynamic Repeater) -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Bidang Ilmu <span class="text-red-500">*</span>
                                    </label>
                                    
                                    <div class="space-y-3">
                                        @foreach($selectedBidangIds as $index => $selectedId)
                                            <div class="flex gap-2">
                                                <div class="grow relative">
                                                    <select wire:model="selectedBidangIds.{{ $index }}"
                                                        class="w-full px-4 py-3 text-base border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-100 transition-colors appearance-none bg-no-repeat bg-right pr-10"
                                                        style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27%236b7280%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e'); background-size: 1.5em;">
                                                        <option value="">-- Pilih Bidang Ilmu --</option>
                                                        @foreach($bidangIlmus as $bidang)
                                                            <option value="{{ $bidang->id }}">{{ $bidang->bidang }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                
                                                <button type="button" wire:click="removeBidang({{ $index }})" 
                                                    class="px-3 py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 focus:ring-2 focus:ring-red-500 transition-colors"
                                                    @if(count($selectedBidangIds) <= 1) disabled style="opacity: 0.5; cursor: not-allowed;" @endif>
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>

                                    <button type="button" wire:click="addBidang"
                                        class="mt-3 inline-flex items-center px-4 py-2 bg-indigo-50 text-indigo-700 rounded-lg hover:bg-indigo-100 focus:ring-2 focus:ring-indigo-500 transition-colors text-sm font-medium">
                                        <i class="bi bi-plus-lg mr-2"></i> Tambah Bidang Ilmu
                                    </button>

                                    @error('selectedBidangIds') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    @error('selectedBidangIds.*') <span class="text-red-500 text-xs mt-1 block">Silakan pilih bidang ilmu valid.</span> @enderror
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
                                    Simpan
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
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Hapus Jabatan Target</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
                                Apakah Anda yakin ingin menghapus jabatan target ini? Tindakan ini tidak dapat dibatalkan.
                            </p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-4 flex gap-3 justify-center sm:flex-row flex-col-reverse">
                            <button wire:click="cancelDelete" type="button"
                                class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                Batal
                            </button>
                            <button wire:click="deleteJabatan" type="button"
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
