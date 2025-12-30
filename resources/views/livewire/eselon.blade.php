<div class="py-6">
    <div class="w-full mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                @if (session()->has('message'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('message') }}</span>
                    </div>
                @endif

                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Eselon</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Kelola data eselon jabatan</p>
                    </div>
                    <button wire:click="create" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md text-sm font-medium transition-colors duration-150">
                        + Tambah Eselon
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">No</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Eselon</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jenis Jabatan</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($eselons as $index => $e)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900 dark:text-white">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-bold text-gray-900 dark:text-white">{{ $e->eselon }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $e->jenis_jabatan }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <button wire:click="edit({{ $e->id }})" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 mr-2">Edit</button>
                                    <button wire:click="delete({{ $e->id }})" onclick="return confirm('Yakin ingin menghapus data ini?')" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Hapus</button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                    Tidak ada data eselon
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <x-modal name="eselon-modal" :show="$isModalOpen" maxWidth="lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg leading-6 font-medium mb-4">
                            {{ $eselon_id_to_edit ? 'Edit Eselon' : 'Tambah Eselon' }}
                        </h3>

                        <form wire:submit.prevent="store">
                            <div class="space-y-4">
                                <div>
                                    <x-input-label for="eselon" :value="__('Kode Eselon (e.g II.A)')" />
                                    <x-text-input id="eselon" type="text" class="mt-1 block w-full" wire:model="eselon" />
                                    <x-input-error :messages="$errors->get('eselon')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="jenis_jabatan" :value="__('Jenis Jabatan')" />
                                    <x-text-input id="jenis_jabatan" type="text" class="mt-1 block w-full" wire:model="jenis_jabatan" />
                                    <x-input-error :messages="$errors->get('jenis_jabatan')" class="mt-2" />
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
