<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-2xl text-gray-900 leading-tight tracking-tight">
                {{ __('Kelola Anggota (Siswa)') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-xl shadow-sm flex items-center">
                <svg class="h-5 w-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                <p class="text-sm text-green-800 font-bold">{{ session('success') }}</p>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100">
                
                @if($anggota->isEmpty())
                    <div class="text-center py-16">
                        <div class="bg-gray-50 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 border border-gray-100">
                            <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Belum ada siswa</h3>
                        <p class="text-gray-500 mt-1 text-sm font-medium">Silakan daftarkan siswa baru ke dalam sistem.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto text-left">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500 font-bold">
                                    <th class="px-6 py-4 rounded-tl-xl">Nama Lengkap</th>
                                    <th class="px-6 py-4">Email</th>
                                    <th class="px-6 py-4">Terdaftar Sejak</th>
                                    <th class="px-6 py-4 rounded-tr-xl text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($anggota as $user)
                                <tr class="group hover:bg-gray-50/50 transition duration-150">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="h-8 w-8 rounded-full bg-gray-200 border border-gray-300 flex items-center justify-center text-gray-600 font-bold mr-3 shadow-sm">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                            <span class="text-sm font-bold text-gray-900 group-hover:text-black">{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 font-medium">
                                        {{ $user->email }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 font-medium">
                                        {{ $user->created_at->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <form action="{{ route('anggota.destroy', $user->id) }}" method="POST" class="inline-block form-hapus">
                                            @csrf
                                            @method('DELETE')
                                            
                                            <button type="button" onclick="konfirmasiHapus(this, '{{ $user->name }}')" 
                                                    class="group/btn flex items-center gap-2 ml-auto px-4 py-2 rounded-lg text-red-500 hover:bg-red-50 hover:text-red-700 transition-all duration-200 active:scale-95">
                                                <svg class="w-4 h-4 transition-transform group-hover/btn:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                <span class="text-xs font-black uppercase tracking-widest">Hapus</span>
                                            </button>

                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function konfirmasiHapus(button, namaSiswa) {
            Swal.fire({
                title: 'Hapus Siswa?',
                text: "Anda akan menghapus data siswa \"" + namaSiswa + "\". Akses login mereka akan hilang.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#000000', // Hitam
                cancelButtonColor: '#d33',     // Merah
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                background: '#fff',
                color: '#000'
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit();
                }
            })
        }
    </script>
</x-app-layout>