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
                        <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">Peran & Izin</h2>
                        <p class="text-gray-500 dark:text-gray-400 mt-2">Definisikan level akses (Role) dan hak istimewa (Permission)</p>
                    </div>
                    <button wire:click="create" class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-indigo-200 dark:shadow-none hover:scale-[1.02] active:scale-[0.98]">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        Tambah Role Baru
                    </button>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    @foreach($roles as $role)
                    <div class="bg-gray-50 dark:bg-gray-900/40 rounded-2xl border-2 border-gray-100 dark:border-gray-700 p-6 group hover:border-indigo-500 transition-all">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-extrabold text-gray-900 dark:text-white group-hover:text-indigo-600 transition-colors uppercase tracking-wider">{{ $role->name }}</h3>
                                <p class="text-xs text-gray-400 mt-1">ID: {{ $role->id }} | Dibuat: {{ $role->created_at->format('d/m/Y') }}</p>
                            </div>
                            <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <button wire:click="edit({{ $role->id }})" class="p-2 bg-white dark:bg-gray-800 rounded-lg shadow-sm text-indigo-600 hover:text-indigo-800">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                @if($role->name !== 'Super Admin')
                                <button wire:click="delete({{ $role->id }})" onclick="return confirm('Hapus role ini? User dengan role ini akan kehilangan akses.')" class="p-2 bg-white dark:bg-gray-800 rounded-lg shadow-sm text-red-600 hover:text-red-800">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                                @endif
                            </div>
                        </div>

                        <div>
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 block">Hak Akses:</span>
                            <div class="flex flex-wrap gap-2">
                                @forelse($role->permissions as $p)
                                    <span class="px-3 py-1 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-xs font-medium text-gray-600 dark:text-gray-300">
                                        {{ $p->name }}
                                    </span>
                                @empty
                                    <span class="text-xs text-gray-400 italic">Belum ada izin khusus diberikan</span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Role -->
    <x-modal name="role-modal" :show="$isModalOpen" maxWidth="4xl">
        <div class="p-8 dark:bg-gray-800">
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                {{ $role_id ? 'Edit Role: ' . $name : 'Tambah Role Baru' }}
            </h3>

            <form wire:submit.prevent="store">
                <div class="space-y-6">
                    <div>
                        <x-input-label for="name" :value="__('Nama Role')" class="font-bold" />
                        <x-text-input id="name" type="text" class="mt-1 block w-full rounded-xl py-3" wire:model="name" placeholder="E.g. Manajer, Auditor" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label :value="__('Daftar Izin (Permissions)')" class="font-bold mb-4" />
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 max-h-96 overflow-y-auto pr-2 custom-scrollbar">
                            @foreach($allPermissions as $perm)
                                <label class="flex items-start p-3 border-2 border-gray-50 dark:border-gray-700 rounded-xl cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-900 transition-all has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50/50">
                                    <input type="checkbox" wire:model="selectedPermissions" value="{{ $perm->name }}" class="mt-1 w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                    <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300 leading-tight">{{ $perm->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="mt-10 flex justify-end gap-3">
                    <button type="button" wire:click="closeModal" class="px-6 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm font-bold rounded-xl hover:bg-gray-200 transition-all">
                        Batal
                    </button>
                    <button type="submit" class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-indigo-200 dark:shadow-none">
                        Simpan Role
                    </button>
                </div>
            </form>
        </div>
    </x-modal>
</div>
