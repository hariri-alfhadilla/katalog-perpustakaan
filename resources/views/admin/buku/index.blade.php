<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-2xl text-gray-900 leading-tight tracking-tight">
                {{ __('Kelola Katalog Buku') }}
            </h2>
            
            <a href="{{ route('buku.create') }}" class="inline-flex items-center px-5 py-2.5 bg-black border border-transparent rounded-full font-bold text-xs text-white uppercase tracking-widest hover:bg-gray-800 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-lg shadow-gray-300">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Buku Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-transition.opacity.duration.500ms x-init="setTimeout(() => show = false, 4000)" class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r shadow-sm flex items-center justify-between">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <p class="text-sm text-green-800 font-bold">{{ session('success') }}</p>
                </div>
                <button @click="show = false" class="text-green-500 hover:text-green-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100">
                
                @if($buku->isEmpty())
                    <div class="text-center py-16">
                        <div class="bg-gray-50 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 border border-gray-100">
                            <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Belum ada buku</h3>
                        <p class="text-gray-500 mt-1 text-sm">Mulai tambahkan koleksi buku ke perpustakaan.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto text-left">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500 font-bold">
                                    <th class="px-6 py-4 rounded-tl-lg text-center w-24">Cover</th>
                                    <th class="px-6 py-4 w-1/4">Judul Buku</th>
                                    <th class="px-6 py-4">Penulis</th>
                                    <th class="px-6 py-4">Penerbit</th>
                                    <th class="px-6 py-4">Tahun</th>
                                    <th class="px-6 py-4 text-center">Stok</th>
                                    <th class="px-6 py-4 rounded-tr-lg text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($buku as $item)
                                <tr class="group hover:bg-gray-50/50 transition duration-150">
                                    
                                    <td class="px-6 py-4 align-middle">
                                        <div class="flex justify-center">
                                            @if($item->cover)
                                                <img src="{{ asset('storage/' . $item->cover) }}" alt="Cover {{ $item->judul }}" class="h-16 w-12 object-cover rounded shadow-sm border border-gray-200">
                                            @else
                                                <div class="h-16 w-12 bg-gray-100 rounded flex items-center justify-center border border-gray-200">
                                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                </div>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 align-middle">
                                        <span class="text-sm font-bold text-gray-900">{{ $item->judul }}</span>
                                    </td>
                                    
                                    <td class="px-6 py-4 text-sm text-gray-600 font-medium align-middle">
                                        {{ $item->penulis }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 align-middle">
                                        {{ $item->penerbit }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 align-middle">
                                        {{ $item->tahun_terbit }}
                                    </td>
                                    <td class="px-6 py-4 text-center align-middle">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $item->stok > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $item->stok }}
                                        </span>
                                    </td>
                                    
                                    <td class="px-6 py-4 align-middle text-right w-32">
                                        <div class="flex items-center justify-end gap-2 h-full">
                                            <a href="{{ route('buku.edit', $item->id) }}" class="text-gray-400 hover:text-black transition p-2 hover:bg-gray-100 rounded-lg flex items-center justify-center" title="Edit Buku">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>

                                            <form action="{{ route('buku.destroy', $item->id) }}" method="POST" class="m-0 p-0 flex items-center justify-center">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="text-gray-400 hover:text-red-600 transition p-2 hover:bg-red-50 rounded-lg flex items-center justify-center" title="Hapus Buku" onclick="konfirmasiHapus(this, '{{ $item->judul }}')">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
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
        function konfirmasiHapus(button, judulBuku) {
            Swal.fire({
                title: 'Hapus Buku?',
                text: "Anda akan menghapus buku \"" + judulBuku + "\". Data tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#000000', 
                cancelButtonColor: '#d33',     
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