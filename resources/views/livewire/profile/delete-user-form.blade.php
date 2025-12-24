<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component
{
    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}; ?>

<section class="space-y-6">
    <div class="space-y-3">
        <div class="p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
            <p class="text-sm text-red-800 dark:text-red-300">
                <i class="bi bi-exclamation-triangle-fill mr-2"></i>
                {{ __('Setelah akun Anda dihapus, semua data akan dihapus secara permanen dan tidak dapat dipulihkan. Pastikan Anda telah mengunduh data penting sebelum menghapus akun.') }}
            </p>
        </div>
    </div>

    <button
        x-data=""
        @click="$dispatch('open-modal', 'confirm-user-deletion')"
        class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow-sm transition-colors duration-150"
    >
        <i class="bi bi-trash mr-2"></i>
        {{ __('Hapus Akun') }}
    </button>

    {{-- Modal Konfirmasi --}}
    <x-modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable>
        <div class="p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-lg bg-red-100 dark:bg-red-900 flex items-center justify-center">
                    <i class="bi bi-exclamation-triangle text-red-600 dark:text-red-400 text-xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                    {{ __('Hapus Akun?') }}
                </h3>
            </div>

            <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                {{ __('Tindakan ini tidak dapat dibatalkan. Semua data Anda akan dihapus secara permanen. Silakan masukkan password untuk mengonfirmasi penghapusan akun.') }}
            </p>

            <form wire:submit="deleteUser" class="space-y-4">
                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input
                        wire:model="password"
                        id="password"
                        name="password"
                        type="password"
                        class="mt-2 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="{{ __('Masukkan password Anda') }}"
                        required
                    />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="flex gap-3 justify-end">
                    <button
                        x-data=""
                        @click="$dispatch('close')"
                        type="button"
                        class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-900 dark:text-gray-100 font-semibold rounded-lg transition-colors duration-150"
                    >
                        {{ __('Batal') }}
                    </button>
                    <button
                        type="submit"
                        class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow-sm transition-colors duration-150"
                    >
                        <i class="bi bi-trash mr-2"></i>
                        {{ __('Hapus Akun') }}
                    </button>
                </div>
            </form>
        </div>
    </x-modal>
</section>
