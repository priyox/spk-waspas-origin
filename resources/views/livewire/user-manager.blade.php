<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 dark:border-gray-700">
            <div class="p-8">
                @if (session()->has('message'))
                    <div class="mb-6 flex items-center p-4 bg-emerald-50 dark:bg-emerald-900/30 border-l-4 border-emerald-500 rounded-r-xl">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3 text-sm font-medium text-emerald-800 dark:text-emerald-200">
                            {{ session('message') }}
                        </div>
                    </div>
                @endif

                @if (session()->has('error'))
                    <div class="mb-6 flex items-center p-4 bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 rounded-r-xl">
                        <div class="flex-shrink-0 text-red-500">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                        </div>
                        <div class="ml-3 text-sm font-medium text-red-800 dark:text-red-200">
                            {{ session('error') }}
                        </div>
                    </div>
                @endif

                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                    <div>
                        <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">Manajemen User</h2>
                        <p class="text-gray-500 dark:text-gray-400 mt-2">Kelola akun pengguna dan hak akses peran mereka</p>
                    </div>
                    <button wire:click="create" class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-indigo-200 dark:shadow-none hover:scale-[1.02] active:scale-[0.98]">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        Tambah User Baru
                    </button>
                </div>

                <!-- Filters -->
                <div class="mb-8 relative max-w-md">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input wire:model.live="search" type="text" placeholder="Cari nama atau email..." 
                        class="block w-full pl-11 pr-4 py-3 border-2 border-gray-100 dark:border-gray-700 rounded-xl bg-gray-50 dark:bg-gray-900 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all dark:text-white">
                </div>

                <div class="overflow-hidden border border-gray-100 dark:border-gray-700 rounded-2xl shadow-sm">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-900/50">
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-center w-16">No</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Identitas Pengguna</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Peran (Role)</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-center w-32">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800 bg-white dark:bg-gray-800">
                            @forelse($users as $index => $user)
                            <tr class="group hover:bg-gray-50 dark:hover:bg-gray-900/30 transition-all">
                                <td class="px-6 py-4 text-sm text-gray-500 text-center font-medium">
                                    {{ ($users->currentPage()-1) * $users->perPage() + $index + 1 }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 flex-shrink-0 rounded-full bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-bold">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $user->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($user->roles as $role)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-200">
                                                {{ $role->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center gap-3">
                                        <button wire:click="edit({{ $user->id }})" class="p-2 text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-950 rounded-lg transition-colors" title="Edit User">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </button>
                                        @if($user->id !== auth()->id())
                                        <button wire:click="delete({{ $user->id }})" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')" class="p-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-950 rounded-lg transition-colors" title="Hapus User">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 01-12 0v1z"/></svg>
                                        <p class="text-lg font-medium">Tidak ada data user ditemukan</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-8">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Form -->
    <x-modal name="user-modal" :show="$isModalOpen" maxWidth="lg">
        <div class="p-8 dark:bg-gray-800">
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                {{ $user_id ? 'Edit Pengguna' : 'Tambah Pengguna Baru' }}
            </h3>

            <form wire:submit.prevent="store">
                <div class="space-y-5">
                    <div>
                        <x-input-label for="name" :value="__('Nama Lengkap')" class="font-bold text-gray-700 dark:text-gray-300" />
                        <x-text-input id="name" type="text" class="mt-1 block w-full rounded-xl py-3" wire:model="name" placeholder="Contoh: Budi Santoso" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('Alamat Email')" class="font-bold text-gray-700 dark:text-gray-300" />
                        <x-text-input id="email" type="email" class="mt-1 block w-full rounded-xl py-3" wire:model="email" placeholder="budi@example.com" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="password" :value="__('Password')" class="font-bold text-gray-700 dark:text-gray-300" />
                        <x-text-input id="password" type="password" class="mt-1 block w-full rounded-xl py-3" wire:model="password" placeholder="{{ $user_id ? 'Kosongkan jika tidak ingin diubah' : 'Minimal 6 karakter' }}" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label :value="__('Peran (Role)')" class="font-bold text-gray-700 dark:text-gray-300 mb-2" />
                        <div class="grid grid-cols-2 gap-3">
                            @foreach($allRoles as $role)
                                <label class="flex items-center p-3 border-2 border-gray-100 dark:border-gray-700 rounded-xl cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-900 transition-all has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50 dark:has-[:checked]:bg-indigo-900/20">
                                    <input type="checkbox" wire:model="selectedRoles" value="{{ $role->name }}" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                    <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">{{ $role->name }}</span>
                                </label>
                            @endforeach
                        </div>
                        <x-input-error :messages="$errors->get('selectedRoles')" class="mt-2" />
                    </div>
                </div>

                <div class="mt-10 flex justify-end gap-3">
                    <button type="button" wire:click="closeModal" class="px-6 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm font-bold rounded-xl hover:bg-gray-200 transition-all">
                        Batal
                    </button>
                    <button type="submit" class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-indigo-200 dark:shadow-none">
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </x-modal>
</div>
