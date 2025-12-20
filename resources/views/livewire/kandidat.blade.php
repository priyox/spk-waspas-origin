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
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Informasi Kandidat</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Golongan / Eselon</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jabatan & Unit Kerja</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Pendidikan</th>
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
                                            <img class="h-10 w-10 rounded-full bg-indigo-100" src="https://ui-avatars.com/api/?name={{ urlencode($kandidat->nama) }}&background=6366f1&color=fff" alt="">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-bold text-gray-900 dark:text-gray-100">{{ $kandidat->nama }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">NIP: {{ $kandidat->nip }}</div>
                                            <div class="text-xs text-gray-400 italic">{{ $kandidat->tempat_lahir }}, {{ \Carbon\Carbon::parse($kandidat->tanggal_lahir)->translatedFormat('d F Y') }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-gray-100">{{ $kandidat->golongan?->golongan ?? '-' }}</div>
                                    <div class="text-xs text-indigo-600 dark:text-indigo-400 font-semibold">{{ $kandidat->eselon?->eselon ?? 'Non-Eselon' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 dark:text-gray-100 font-medium">{{ $kandidat->jabatan }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $kandidat->unit_kerja ?? 'Unit Kerja tidak diset' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-gray-100">{{ $kandidat->tingkat_pendidikan?->tingkat ?? '-' }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $kandidat->bidang_ilmu?->bidang ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button wire:click="edit('{{ $kandidat->nip }}')" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 mr-2">Edit</button>
                                    <button wire:click="delete('{{ $kandidat->nip }}')" onclick="return confirm('Apakah Anda yakin ingin menghapus kandidat ini?')" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Hapus</button>
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

                                <x-modal name="kandidat-modal" :show="$isModalOpen" maxWidth="4xl">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg leading-6 font-medium mb-4">
                            {{ $kandidat_id_to_edit ? 'Edit Kandidat' : 'Tambah Kandidat' }}
                        </h3>

                        <form wire:submit.prevent="store">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- NIP -->
                                <div>
                                    <x-input-label for="nip" :value="__('NIP')" />
                                    <x-text-input id="nip" type="text" class="mt-1 block w-full" wire:model="nip" :disabled="$kandidat_id_to_edit" />
                                    <x-input-error :messages="$errors->get('nip')" class="mt-2" />
                                </div>

                                <!-- Nama -->
                                <div>
                                    <x-input-label for="nama" :value="__('Nama')" />
                                    <x-text-input id="nama" type="text" class="mt-1 block w-full" wire:model="nama" />
                                    <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                                </div>

                                <!-- Tempat Lahir -->
                                <div>
                                    <x-input-label for="tempat_lahir" :value="__('Tempat Lahir')" />
                                    <x-text-input id="tempat_lahir" type="text" class="mt-1 block w-full" wire:model="tempat_lahir" />
                                    <x-input-error :messages="$errors->get('tempat_lahir')" class="mt-2" />
                                </div>

                                <!-- Tanggal Lahir -->
                                <div>
                                    <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
                                    <x-text-input id="tanggal_lahir" type="date" class="mt-1 block w-full" wire:model="tanggal_lahir" />
                                    <x-input-error :messages="$errors->get('tanggal_lahir')" class="mt-2" />
                                </div>

                                <!-- Jabatan -->
                                <div>
                                    <x-input-label for="jabatan" :value="__('Jabatan')" />
                                    <x-text-input id="jabatan" type="text" class="mt-1 block w-full" wire:model="jabatan" />
                                    <x-input-error :messages="$errors->get('jabatan')" class="mt-2" />
                                </div>

                                <!-- Golongan -->
                                <div>
                                    <x-input-label for="golongan_id" :value="__('Golongan')" />
                                    <select id="golongan_id" wire:model="golongan_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                        <option value="">Pilih Golongan</option>
                                        @foreach($golongans as $g)
                                            <option value="{{ $g->id }}">{{ $g->golongan }} - {{ $g->pangkat }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('golongan_id')" class="mt-2" />
                                </div>

                                <!-- Jenis Jabatan -->
                                <div>
                                    <x-input-label for="jenis_jabatan_id" :value="__('Jenis Jabatan')" />
                                    <select id="jenis_jabatan_id" wire:model="jenis_jabatan_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                        <option value="">Pilih Jenis Jabatan</option>
                                        @foreach($jenis_jabatans as $j)
                                            <option value="{{ $j->id }}">{{ $j->jenis_jabatan }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('jenis_jabatan_id')" class="mt-2" />
                                </div>

                                <!-- Tingkat Pendidikan -->
                                <div>
                                    <x-input-label for="tingkat_pendidikan_id" :value="__('Pendidikan')" />
                                    <select id="tingkat_pendidikan_id" wire:model="tingkat_pendidikan_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                        <option value="">Pilih Pendidikan</option>
                                        @foreach($tingkat_pendidikans as $tp)
                                            <option value="{{ $tp->id }}">{{ $tp->tingkat }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('tingkat_pendidikan_id')" class="mt-2" />
                                </div>

                                <!-- Bidang Ilmu -->
                                <div>
                                    <x-input-label for="bidang_ilmu_id" :value="__('Bidang Ilmu')" />
                                    <select id="bidang_ilmu_id" wire:model="bidang_ilmu_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                        <option value="">Pilih Bidang</option>
                                        @foreach($bidang_ilmus as $bi)
                                            <option value="{{ $bi->id }}">{{ $bi->bidang }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('bidang_ilmu_id')" class="mt-2" />
                                </div>

                                <!-- Eselon (Optional) -->
                                <div>
                                    <x-input-label for="eselon_id" :value="__('Eselon (Opsional)')" />
                                    <select id="eselon_id" wire:model="eselon_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                        <option value="">Tidak Ada</option>
                                        @foreach($eselons as $e)
                                            <option value="{{ $e->id }}">{{ $e->eselon }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="mt-6 flex justify-end gap-x-3">
                                <x-secondary-button wire:click="closeModal">
                                    {{ __('Batal') }}
                                </x-secondary-button>

                                <x-primary-button type="submit">
                                    {{ __('Simpan') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </x-modal>

            </div>
        </div>
    </div>
</div>
