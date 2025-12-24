<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Syarat Jabatan') }}
    </h2>
</x-slot>

<div class="py-6">
    <div class="w-full px-4 lg:px-6">
        {{-- Flash Messages --}}
        @if (session()->has('message'))
            <div class="mb-4 p-4 bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 rounded-lg flex items-center gap-3">
                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span>{{ session('message') }}</span>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                {{-- Header --}}
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Syarat Jabatan</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Kelola persyaratan jabatan berdasarkan eselon</p>
                    </div>
                    <button wire:click="create" class="inline-flex items-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-semibold transition-colors duration-150 shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Tambah Syarat Jabatan
                    </button>
                </div>

                {{-- Info Card --}}
                <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <div class="text-sm text-blue-700 dark:text-blue-300">
                            <p class="font-semibold">Tentang Syarat Jabatan:</p>
                            <p class="mt-1">Syarat jabatan menentukan persyaratan minimal untuk setiap level eselon, termasuk golongan minimal dan tingkat pendidikan minimal yang digunakan dalam perhitungan WASPAS.</p>
                        </div>
                    </div>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">No</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Eselon</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Min. Golongan</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Min. Pendidikan</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Min. Eselon</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Keterangan</th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($syaratJabatans as $index => $syarat)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white font-medium">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                                        {{ $syarat->eselon->eselon ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    {{ $syarat->minimalGolongan->golongan ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    {{ $syarat->minimalTingkatPendidikan->tingkat ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    {{ $syarat->minimalEselon->eselon ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 max-w-xs truncate" title="{{ $syarat->keterangan }}">
                                    {{ $syarat->keterangan ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($syarat->is_active)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                            <span class="w-2 h-2 mr-1.5 bg-green-500 rounded-full"></span>
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                            <span class="w-2 h-2 mr-1.5 bg-red-500 rounded-full"></span>
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex items-center justify-center gap-2">
                                        <button wire:click="edit({{ $syarat->id }})" class="inline-flex items-center px-3 py-1.5 bg-amber-100 hover:bg-amber-200 text-amber-700 dark:bg-amber-900/50 dark:hover:bg-amber-900 dark:text-amber-300 rounded-lg transition-colors">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            Edit
                                        </button>
                                        <button wire:click="confirmDelete({{ $syarat->id }})" class="inline-flex items-center px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 dark:bg-red-900/50 dark:hover:bg-red-900 dark:text-red-300 rounded-lg transition-colors">
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
                                <td colspan="8" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <p class="text-gray-500 dark:text-gray-400 font-medium">Tidak ada data syarat jabatan</p>
                                        <p class="text-gray-400 dark:text-gray-500 text-sm mt-1">Klik tombol "Tambah Syarat Jabatan" untuk menambah data baru</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Create/Edit --}}
    <x-modal name="syarat-modal" :show="$isModalOpen" maxWidth="xl">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <div class="flex items-center gap-3 mb-6">
                <div class="p-2 bg-indigo-100 dark:bg-indigo-900 rounded-lg">
                    <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold">
                        {{ $syarat_id_to_edit ? 'Edit Syarat Jabatan' : 'Tambah Syarat Jabatan' }}
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ $syarat_id_to_edit ? 'Ubah data syarat jabatan yang ada' : 'Masukkan data syarat jabatan baru' }}
                    </p>
                </div>
            </div>

            <form wire:submit.prevent="store">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Eselon --}}
                    <div>
                        <label for="eselon_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Eselon <span class="text-red-500">*</span>
                        </label>
                        <select id="eselon_id" wire:model="eselon_id"
                            class="w-full px-3 py-2.5 border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 rounded-lg shadow-sm">
                            <option value="">-- Pilih Eselon --</option>
                            @foreach($eselons as $eselon)
                                <option value="{{ $eselon->id }}">{{ $eselon->eselon }}</option>
                            @endforeach
                        </select>
                        @error('eselon_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Minimal Golongan --}}
                    <div>
                        <label for="minimal_golongan_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Minimal Golongan <span class="text-red-500">*</span>
                        </label>
                        <select id="minimal_golongan_id" wire:model="minimal_golongan_id"
                            class="w-full px-3 py-2.5 border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 rounded-lg shadow-sm">
                            <option value="">-- Pilih Golongan --</option>
                            @foreach($golongans as $golongan)
                                <option value="{{ $golongan->id }}">{{ $golongan->golongan }}</option>
                            @endforeach
                        </select>
                        @error('minimal_golongan_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Minimal Tingkat Pendidikan --}}
                    <div>
                        <label for="minimal_tingkat_pendidikan_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Minimal Tingkat Pendidikan <span class="text-red-500">*</span>
                        </label>
                        <select id="minimal_tingkat_pendidikan_id" wire:model="minimal_tingkat_pendidikan_id"
                            class="w-full px-3 py-2.5 border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 rounded-lg shadow-sm">
                            <option value="">-- Pilih Tingkat Pendidikan --</option>
                            @foreach($tingkatPendidikans as $tingkat)
                                <option value="{{ $tingkat->id }}">{{ $tingkat->tingkat }}</option>
                            @endforeach
                        </select>
                        @error('minimal_tingkat_pendidikan_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Minimal Eselon (Optional) --}}
                    <div>
                        <label for="minimal_eselon_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Minimal Eselon <span class="text-gray-400 text-xs font-normal">(opsional)</span>
                        </label>
                        <select id="minimal_eselon_id" wire:model="minimal_eselon_id"
                            class="w-full px-3 py-2.5 border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 rounded-lg shadow-sm">
                            <option value="">-- Tidak Ada --</option>
                            @foreach($eselons as $eselon)
                                <option value="{{ $eselon->id }}">{{ $eselon->eselon }}</option>
                            @endforeach
                        </select>
                        @error('minimal_eselon_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Keterangan --}}
                    <div class="md:col-span-2">
                        <label for="keterangan" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Keterangan <span class="text-gray-400 text-xs font-normal">(opsional)</span>
                        </label>
                        <textarea id="keterangan" wire:model="keterangan" rows="2"
                            class="w-full px-3 py-2.5 border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 rounded-lg shadow-sm"
                            placeholder="Masukkan keterangan tambahan..."></textarea>
                        @error('keterangan') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Is Active --}}
                    <div class="md:col-span-2">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" wire:model="is_active"
                                class="w-5 h-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-900">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                Status Aktif
                            </span>
                        </label>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 ml-8">
                            Syarat jabatan yang tidak aktif tidak akan digunakan dalam perhitungan
                        </p>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <button type="button" wire:click="closeModal"
                        class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-gray-300 rounded-lg font-medium transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-semibold transition-colors shadow-lg">
                        <span wire:loading.remove wire:target="store">
                            {{ $syarat_id_to_edit ? 'Update' : 'Simpan' }}
                        </span>
                        <span wire:loading wire:target="store">
                            Menyimpan...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </x-modal>

    {{-- Modal Konfirmasi Hapus --}}
    @if($confirmingDeletion)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-black/40 backdrop-blur-sm transition-opacity" wire:click="cancelDelete"></div>

        <div class="relative bg-white dark:bg-gray-800 rounded-xl shadow-2xl transform transition-all max-w-md w-full p-6 animate-in fade-in zoom-in-95">
            {{-- Icon --}}
            <div class="flex items-center justify-center w-12 h-12 mx-auto rounded-full bg-red-100 dark:bg-red-900/30 mb-4">
                <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>

            {{-- Content --}}
            <h3 class="text-lg font-bold text-gray-900 dark:text-white text-center mb-2">
                Hapus Syarat Jabatan
            </h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 text-center mb-6">
                Apakah Anda yakin ingin menghapus syarat jabatan ini? Data yang dihapus tidak dapat dikembalikan.
            </p>

            {{-- Buttons --}}
            <div class="flex gap-3">
                <button wire:click="cancelDelete" type="button"
                    class="flex-1 px-4 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                    Batal
                </button>
                <button wire:click="delete" type="button"
                    class="flex-1 px-4 py-2.5 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-colors shadow-lg">
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
