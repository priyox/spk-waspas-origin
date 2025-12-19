<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Daftar Kandidat') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">No</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama Kandidat</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jabatan Saat Ini</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($kandidats as $index => $kandidat)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 flex-shrink-0">
                                            <img class="h-10 w-10 rounded-full bg-gray-200" src="https://ui-avatars.com/api/?name={{ urlencode($kandidat->nama) }}&background=random" alt="">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $kandidat->nama }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">NIP: {{ $kandidat->nip }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $kandidat->jabatan }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button wire:click="edit('{{ $kandidat->nip }}')" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 mr-2">Edit</button>
                                    <button wire:click="delete('{{ $kandidat->nip }}')" onclick="return confirm('Are you sure you want to delete this item?')" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Hapus</button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500 dark:text-gray-400">
                                    Belum ada data kandidat.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Modal -->
                @if($isModalOpen)
                <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                        <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                            <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100" id="modal-title">
                                            {{ $kandidat_id_to_edit ? 'Edit Kandidat' : 'Tambah Kandidat' }}
                                        </h3>
                                        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <!-- NIP -->
                                            <div>
                                                <label for="nip" class="block text-sm font-medium text-gray-700 dark:text-gray-300">NIP</label>
                                                <input type="text" wire:model="nip" id="nip" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm" {{ $kandidat_id_to_edit ? 'disabled' : '' }}>
                                                @error('nip') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                            </div>
                                            
                                            <!-- Nama -->
                                            <div>
                                                <label for="nama" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama</label>
                                                <input type="text" wire:model="nama" id="nama" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm">
                                                @error('nama') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                            </div>

                                            <!-- Tempat Lahir -->
                                            <div>
                                                <label for="tempat_lahir" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tempat Lahir</label>
                                                <input type="text" wire:model="tempat_lahir" id="tempat_lahir" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm">
                                                @error('tempat_lahir') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                            </div>

                                            <!-- Tanggal Lahir -->
                                            <div>
                                                <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Lahir</label>
                                                <input type="date" wire:model="tanggal_lahir" id="tanggal_lahir" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm">
                                                @error('tanggal_lahir') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                            </div>

                                            <!-- Jabatan -->
                                            <div>
                                                <label for="jabatan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jabatan</label>
                                                <input type="text" wire:model="jabatan" id="jabatan" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm">
                                                @error('jabatan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                            </div>

                                            <!-- Golongan -->
                                            <div>
                                                <label for="golongan_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Golongan</label>
                                                <select wire:model="golongan_id" id="golongan_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm">
                                                    <option value="">Pilih Golongan</option>
                                                    @foreach($golongans as $g)
                                                        <option value="{{ $g->id }}">{{ $g->golongan }} - {{ $g->pangkat }}</option>
                                                    @endforeach
                                                </select>
                                                @error('golongan_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                            </div>

                                            <!-- Jenis Jabatan -->
                                            <div>
                                                <label for="jenis_jabatan_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis Jabatan</label>
                                                <select wire:model="jenis_jabatan_id" id="jenis_jabatan_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm">
                                                    <option value="">Pilih Jenis Jabatan</option>
                                                    @foreach($jenis_jabatans as $j)
                                                        <option value="{{ $j->id }}">{{ $j->jenis_jabatan }}</option>
                                                    @endforeach
                                                </select>
                                                @error('jenis_jabatan_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                            </div>

                                            <!-- Tingkat Pendidikan -->
                                            <div>
                                                <label for="tingkat_pendidikan_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pendidikan</label>
                                                <select wire:model="tingkat_pendidikan_id" id="tingkat_pendidikan_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm">
                                                    <option value="">Pilih Pendidikan</option>
                                                    @foreach($tingkat_pendidikans as $tp)
                                                        <option value="{{ $tp->id }}">{{ $tp->tingkat }}</option>
                                                    @endforeach
                                                </select>
                                                @error('tingkat_pendidikan_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                            </div>

                                            <!-- Bidang Ilmu -->
                                            <div>
                                                <label for="bidang_ilmu_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Bidang Ilmu</label>
                                                <select wire:model="bidang_ilmu_id" id="bidang_ilmu_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm">
                                                    <option value="">Pilih Bidang</option>
                                                    @foreach($bidang_ilmus as $bi)
                                                        <option value="{{ $bi->id }}">{{ $bi->bidang }}</option>
                                                    @endforeach
                                                </select>
                                                @error('bidang_ilmu_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                            </div>
                                             
                                              <!-- Eselon (Optional) -->
                                            <div>
                                                <label for="eselon_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Eselon (Opsional)</label>
                                                <select wire:model="eselon_id" id="eselon_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm">
                                                    <option value="">Tidak Ada</option>
                                                    @foreach($eselons as $e)
                                                        <option value="{{ $e->id }}">{{ $e->eselon }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <button wire:click.prevent="store()" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                                    Simpan
                                </button>
                                <button wire:click="closeModal()" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                    Batal
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</div>
