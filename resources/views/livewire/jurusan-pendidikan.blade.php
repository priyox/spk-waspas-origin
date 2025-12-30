<div class="py-6">
    <div class="w-full mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                @if (session()->has('message'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('message') }}</span>
                    </div>
                @endif

                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Jurusan Pendidikan</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Kelola data jurusan pendidikan</p>
                    </div>
                    <button wire:click="create" class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-indigo-200 dark:shadow-none hover:scale-[1.02] active:scale-[0.98]">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        Tambah Jurusan
                    </button>
                </div>

                <!-- Filters -->
                <div class="mb-8 relative max-w-md">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari Jurusan..." 
                        class="block w-full pl-11 pr-4 py-3 border-2 border-gray-100 dark:border-gray-700 rounded-xl bg-gray-50 dark:bg-gray-900 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all dark:text-white">
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">No</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama Jurusan</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tingkat</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Bidang Ilmu</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($jurusans as $index => $j)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900 dark:text-white">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 dark:text-white">{{ $j->nama_jurusan }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $j->tingkat_pendidikan->tingkat ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $j->bidang_ilmu->bidang ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <button wire:click="edit({{ $j->id }})" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 mr-2">Edit</button>
                                    <button wire:click="delete({{ $j->id }})" onclick="return confirm('Yakin ingin menghapus data ini?')" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Hapus</button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                    Tidak ada data jurusan
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $jurusans->links() }}
                </div>

                <x-modal name="jurusan-modal" :show="$isModalOpen" maxWidth="lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg leading-6 font-medium mb-4">
                            {{ $jurusan_id_to_edit ? 'Edit Jurusan' : 'Tambah Jurusan' }}
                        </h3>

                        <form wire:submit.prevent="store">
                            <div class="space-y-4">
                                <div>
                                    <x-input-label for="nama_jurusan" :value="__('Nama Jurusan')" />
                                    <x-text-input id="nama_jurusan" type="text" class="mt-1 block w-full" wire:model="nama_jurusan" />
                                    <x-input-error :messages="$errors->get('nama_jurusan')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="tingkat_pendidikan_id" :value="__('Tingkat Pendidikan')" />
                                    <select id="tingkat_pendidikan_id" wire:model="tingkat_pendidikan_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                        <option value="">-- Pilih Tingkat --</option>
                                        @foreach($tingkat_pendidikan_options as $tp)
                                            <option value="{{ $tp->id }}">{{ $tp->tingkat }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('tingkat_pendidikan_id')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="bidang_ilmu_id" :value="__('Bidang Ilmu')" />
                                    <select id="bidang_ilmu_id" wire:model="bidang_ilmu_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                        <option value="">-- Pilih Bidang Ilmu (Opsional) --</option>
                                        @foreach($bidang_ilmu_options as $bi)
                                            <option value="{{ $bi->id }}">{{ $bi->bidang }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('bidang_ilmu_id')" class="mt-2" />
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
