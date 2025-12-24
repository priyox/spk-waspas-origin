<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Profil Pengguna') }}
    </h2>
</x-slot>

<div class="py-8">
    <div class="w-full px-4 sm:px-6 lg:px-8">

        {{-- Profile Header Card --}}
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl shadow-lg p-8 mb-8 text-white">
            <div class="flex items-center gap-6">
                <div class="h-24 w-24 rounded-full bg-white flex items-center justify-center text-indigo-600 font-bold text-4xl shadow-lg">
                    {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                </div>
                <div>
                    <h1 class="text-3xl font-bold mb-2">{{ Auth::user()->name }}</h1>
                    <p class="text-indigo-100 mb-3">{{ Auth::user()->email }}</p>
                    <div class="flex gap-2 flex-wrap">
                        <span class="px-3 py-1 bg-white/20 rounded-full text-sm backdrop-blur-sm">
                            <i class="bi bi-shield-lock mr-1"></i> Pengguna Terdaftar
                        </span>
                        <span class="px-3 py-1 bg-white/20 rounded-full text-sm backdrop-blur-sm">
                            <i class="bi bi-calendar-event mr-1"></i> Terdaftar sejak {{ Auth::user()->created_at->translatedFormat('d F Y') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sections Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Section 1: Informasi Profil --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="w-10 h-10 rounded-lg bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center">
                        <i class="bi bi-person text-indigo-600 dark:text-indigo-400 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                        Informasi Profil
                    </h3>
                </div>
                <livewire:profile.update-profile-information-form />
            </div>

            {{-- Section 2: Ubah Password --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                        <i class="bi bi-lock text-blue-600 dark:text-blue-400 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                        Keamanan
                    </h3>
                </div>
                <livewire:profile.update-password-form />
            </div>

        </div>

        {{-- Section 3: Hapus Akun (Full Width) --}}
        <div class="mt-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-red-200 dark:border-red-900">
                <div class="w-10 h-10 rounded-lg bg-red-100 dark:bg-red-900 flex items-center justify-center">
                    <i class="bi bi-trash text-red-600 dark:text-red-400 text-xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                    Zona Berbahaya
                </h3>
            </div>
            <livewire:profile.delete-user-form />
        </div>

    </div>
</div>
