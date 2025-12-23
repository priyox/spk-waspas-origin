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
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Golongan & TMT</th>
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
                                            <div class="text-[10px] text-gray-400 italic">
                                                {{ $kandidat->tempat_lahir }}, {{ $kandidat->tanggal_lahir ? \Carbon\Carbon::parse($kandidat->tanggal_lahir)->translatedFormat('d-m-Y') : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $kandidat->golongan?->golongan ?? '-' }}</div>
                                    <div class="text-[10px] text-gray-500">TMT: {{ $kandidat->tmt_golongan ? \Carbon\Carbon::parse($kandidat->tmt_golongan)->format('d-m-Y') : '-' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 dark:text-gray-100 font-medium">{{ $kandidat->jabatan }}</div>
                                    <div class="text-xs text-indigo-600 dark:text-indigo-400">
                                        {{ $kandidat->eselon?->eselon ?? '' }} 
                                        {{ $kandidat->jabatan_fungsional?->nama_jabatan ?? '' }}
                                        {{ $kandidat->jabatan_pelaksana?->nama_jabatan ?? '' }}
                                    </div>
                                    <div class="text-[10px] text-gray-500 mt-1">{{ $kandidat->unit_kerja?->unit_kerja ?? $kandidat->unit_kerja }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-gray-100">{{ $kandidat->tingkat_pendidikan?->tingkat ?? '-' }}</div>
                                    <div class="text-xs text-gray-500 truncate max-w-[150px]">{{ $kandidat->jurusan_pendidikan?->jurusan ?? $kandidat->jurusan }}</div>
                                    <div class="text-[10px] text-indigo-500">{{ $kandidat->bidang_ilmu?->bidang ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button wire:click="edit('{{ $kandidat->nip }}')" class="p-1 text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 transition-colors">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button wire:click="delete('{{ $kandidat->nip }}')" onclick="return confirm('Apakah Anda yakin ingin menghapus kandidat ini?')" class="p-1 text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 transition-colors">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 whitespace-nowrap text-center text-sm text-gray-500 dark:text-gray-400">
                                    <div class="flex flex-col items-center">
                                        <i class="bi bi-person-x text-4xl mb-2 text-gray-300"></i>
                                        <span>Belum ada data kandidat.</span>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <x-modal name="kandidat-modal" :show="$isModalOpen" maxWidth="5xl">
                    <div class="p-8 text-gray-900 dark:text-gray-100">
                        <div class="flex items-center justify-between mb-6 border-b pb-4 dark:border-gray-700">
                            <h3 class="text-xl font-bold text-indigo-600 dark:text-indigo-400">
                                <i class="bi bi-person-plus-fill mr-2"></i>
                                {{ $kandidat_id_to_edit ? 'Edit Data Kandidat' : 'Tambah Kandidat Baru' }}
                            </h3>
                            <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>

                        <form wire:submit.prevent="store">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <!-- Section: Identitas Diri -->
                                <div class="col-span-full bg-gray-50 dark:bg-gray-700/30 p-4 rounded-lg">
                                    <h4 class="text-sm font-bold uppercase tracking-wider text-gray-500 mb-4 flex items-center">
                                        <span class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center text-indigo-600 mr-2">1</span>
                                        Identitas Diri
                                    </h4>
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                        <div class="md:col-span-1">
                                            <x-input-label for="nip" :value="__('NIP')" />
                                            <x-text-input id="nip" type="text" class="mt-1 block w-full" wire:model="nip" placeholder="19XXXXXXXXXXXXXX" :disabled="$kandidat_id_to_edit" />
                                            <x-input-error :messages="$errors->get('nip')" class="mt-2" />
                                        </div>
                                        <div class="md:col-span-1">
                                            <x-input-label for="nama" :value="__('Nama Lengkap')" />
                                            <x-text-input id="nama" type="text" class="mt-1 block w-full" wire:model="nama" placeholder="Nama lengkap & Gelar" />
                                            <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                                        </div>
                                        <div>
                                            <x-input-label for="tempat_lahir" :value="__('Tempat Lahir')" />
                                            <x-text-input id="tempat_lahir" type="text" class="mt-1 block w-full" wire:model="tempat_lahir" />
                                            <x-input-error :messages="$errors->get('tempat_lahir')" class="mt-2" />
                                        </div>
                                        <div>
                                            <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
                                            <x-text-input id="tanggal_lahir" type="date" class="mt-1 block w-full" wire:model="tanggal_lahir" />
                                            <x-input-error :messages="$errors->get('tanggal_lahir')" class="mt-2" />
                                        </div>
                                    </div>
                                </div>

                                <!-- Section: Jabatan & Kepegawaian -->
                                <div class="col-span-full bg-gray-50 dark:bg-gray-700/30 p-4 rounded-lg">
                                    <h4 class="text-sm font-bold uppercase tracking-wider text-gray-500 mb-4 flex items-center">
                                        <span class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center text-indigo-600 mr-2">2</span>
                                        Jabatan & Kepegawaian
                                    </h4>
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                        <div class="md:col-span-2">
                                            <x-input-label for="jabatan" :value="__('Nama Jabatan')" />
                                            <x-text-input id="jabatan" type="text" class="mt-1 block w-full" wire:model="jabatan" placeholder="Nama Jabatan Lengkap" />
                                            <x-input-error :messages="$errors->get('jabatan')" class="mt-2" />
                                        </div>
                                        <div>
                                            <x-input-label for="tmt_jabatan" :value="__('TMT Jabatan')" />
                                            <x-text-input id="tmt_jabatan" type="date" class="mt-1 block w-full" wire:model="tmt_jabatan" />
                                        </div>
                                        <div>
                                            <x-input-label for="jenis_jabatan_id" :value="__('Jenis Jabatan')" />
                                            <select id="jenis_jabatan_id" wire:model.live="jenis_jabatan_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                                <option value="">Pilih Jenis</option>
                                                @foreach($jenis_jabatans as $j)
                                                    <option value="{{ $j->id }}">{{ $j->jenis_jabatan }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Conditional Fields based on Jenis Jabatan -->
                                        @if(in_array($jenis_jabatan_id, [20, 30, 40]))
                                        <div>
                                            <x-input-label for="eselon_id" :value="__('Eselon')" />
                                            <select id="eselon_id" wire:model="eselon_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                                <option value="">Pilih Eselon</option>
                                                @foreach($eselons as $e)
                                                    <option value="{{ $e->id }}">{{ $e->eselon }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @elseif($jenis_jabatan_id == 2)
                                        <div class="md:col-span-2">
                                            <x-input-label for="jabatan_fungsional_id" :value="__('Jabatan Fungsional')" />
                                            <select id="jabatan_fungsional_id" wire:model="jabatan_fungsional_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                                <option value="">Pilih Jabfung</option>
                                                @foreach($jabatan_fungsionals as $jf)
                                                    <option value="{{ $jf->id }}">{{ $jf->nama_jabatan }} ({{ $jf->jenjang }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @elseif($jenis_jabatan_id == 3)
                                        <div class="md:col-span-2">
                                            <x-input-label for="jabatan_pelaksana_id" :value="__('Jabatan Pelaksana')" />
                                            <select id="jabatan_pelaksana_id" wire:model="jabatan_pelaksana_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                                <option value="">Pilih Jabatan Pelaksana</option>
                                                @foreach($jabatan_pelaksanas as $jp)
                                                    <option value="{{ $jp->id }}">{{ $jp->nama_jabatan }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @endif

                                        <div>
                                            <x-input-label for="golongan_id" :value="__('Golongan')" />
                                            <select id="golongan_id" wire:model="golongan_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                                <option value="">Pilih Golongan</option>
                                                @foreach($golongans as $g)
                                                    <option value="{{ $g->id }}">{{ $g->golongan }} - {{ $g->pangkat }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <x-input-label for="tmt_golongan" :value="__('TMT Golongan')" />
                                            <x-text-input id="tmt_golongan" type="date" class="mt-1 block w-full" wire:model="tmt_golongan" />
                                        </div>
                                        <div class="md:col-span-2">
                                            <x-input-label for="unit_kerja_id" :value="__('Unit Kerja')" />
                                            <select id="unit_kerja_id" wire:model="unit_kerja_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                                <option value="">Pilih Unit Kerja</option>
                                                @foreach($unit_kerjas as $uk)
                                                    <option value="{{ $uk->id }}">{{ $uk->unit_kerja }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section: Pendidikan -->
                                <div class="col-span-full bg-gray-50 dark:bg-gray-700/30 p-4 rounded-lg">
                                    <h4 class="text-sm font-bold uppercase tracking-wider text-gray-500 mb-4 flex items-center">
                                        <span class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center text-indigo-600 mr-2">3</span>
                                        Latar Belakang Pendidikan
                                    </h4>
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                        <div>
                                            <x-input-label for="tingkat_pendidikan_id" :value="__('Tingkat')" />
                                            <select id="tingkat_pendidikan_id" wire:model="tingkat_pendidikan_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                                <option value="">Pilih Tingkat</option>
                                                @foreach($tingkat_pendidikans as $tp)
                                                    <option value="{{ $tp->id }}">{{ $tp->tingkat }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="md:col-span-2">
                                            <x-input-label for="jurusan_pendidikan_id" :value="__('Jurusan Spesifik')" />
                                            <select id="jurusan_pendidikan_id" wire:model="jurusan_pendidikan_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                                <option value="">Pilih Jurusan</option>
                                                @foreach($jurusan_pendidikans as $jp)
                                                    <option value="{{ $jp->id }}">{{ $jp->jurusan }}</option>
                                                @endforeach
                                            </select>
                                            <div class="text-[10px] text-gray-400 mt-1">* Jika tidak ada, isi di kolom manual samping</div>
                                        </div>
                                        <div>
                                            <x-input-label for="bidang_ilmu_id" :value="__('Kelompok Bidang')" />
                                            <select id="bidang_ilmu_id" wire:model="bidang_ilmu_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                                <option value="">Pilih Bidang</option>
                                                @foreach($bidang_ilmus as $bi)
                                                    <option value="{{ $bi->id }}">{{ $bi->bidang }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="md:col-span-full">
                                            <x-input-label for="jurusan" :value="__('Keterangan Jurusan (Lainnya)')" />
                                            <x-text-input id="jurusan" type="text" class="mt-1 block w-full" wire:model="jurusan" placeholder="Gunakan jika jurusan spesifik tidak tersedia di daftar" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-8 flex justify-end gap-x-4">
                                <x-secondary-button wire:click="closeModal" class="px-6 py-2">
                                    {{ __('Batal') }}
                                </x-secondary-button>

                                <x-primary-button type="submit" class="px-8 py-2 bg-indigo-600 hover:bg-indigo-700">
                                    <i class="bi bi-save mr-2"></i>
                                    {{ __('Simpan Data') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </x-modal>

            </div>
        </div>
    </div>
</div>
