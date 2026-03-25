<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-2xl text-gray-900 leading-tight tracking-tight">
                {{ __('Riwayat Peminjaman') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-transition.opacity.duration.500ms x-init="setTimeout(() => show = false, 4000)" class="mb-6 flex items-center justify-between bg-green-50/80 backdrop-blur-sm border border-green-200 p-4 rounded-2xl shadow-lg shadow-green-100/50">
                <div class="flex items-center">
                    <div class="bg-green-500/20 p-2 rounded-xl mr-4">
                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-black text-green-900 uppercase tracking-wider">Berhasil!</h4>
                        <p class="text-xs text-green-700 font-medium mt-0.5">{{ session('success') }}</p>
                    </div>
                </div>
                <button @click="show = false" class="text-green-500 hover:bg-green-200 hover:text-green-800 p-1.5 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            @endif

            @if(session('error'))
            <div x-data="{ show: true }" x-show="show" x-transition.opacity.duration.500ms x-init="setTimeout(() => show = false, 4000)" class="mb-6 flex items-center justify-between bg-red-50/80 backdrop-blur-sm border border-red-200 p-4 rounded-2xl shadow-lg shadow-red-100/50">
                <div class="flex items-center">
                    <div class="bg-red-500/20 p-2 rounded-xl mr-4">
                        <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-black text-red-900 uppercase tracking-wider">Gagal!</h4>
                        <p class="text-xs text-red-700 font-medium mt-0.5">{{ session('error') }}</p>
                    </div>
                </div>
                <button @click="show = false" class="text-red-500 hover:bg-red-200 hover:text-red-800 p-1.5 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100">
                @if($peminjaman->isEmpty())
                    <div class="text-center py-16">
                        <div class="bg-gray-50 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 border border-gray-100">
                            <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Belum ada aktivitas</h3>
                        <p class="text-gray-500 mt-1 text-sm">Data peminjaman akan muncul di sini.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto text-left">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500 font-bold">
                                    <th class="px-6 py-4 rounded-tl-lg">Peminjam</th>
                                    <th class="px-6 py-4">Buku</th>
                                    <th class="px-6 py-4">Tgl Pinjam</th>
                                    <th class="px-6 py-4">Tgl Kembali</th>
                                    <th class="px-6 py-4 text-center">Status</th>
                                    <th class="px-6 py-4 rounded-tr-lg text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($peminjaman as $item)
                                <tr class="hover:bg-gray-50/50 transition duration-150">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="h-8 w-8 rounded-full bg-black text-white flex items-center justify-center font-bold text-xs mr-3">
                                                {{ substr($item->user->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="text-sm font-bold text-gray-900">{{ $item->user->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $item->user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-4 text-sm text-gray-600 font-medium">
                                        {{ $item->buku->judul }}
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $item->tanggal_peminjaman ? \Carbon\Carbon::parse($item->tanggal_peminjaman)->format('d M Y') : '-' }}
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $item->tanggal_pengembalian ? \Carbon\Carbon::parse($item->tanggal_pengembalian)->format('d M Y') : '-' }}
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        @if($item->status == 'menunggu')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800 border border-yellow-200">
                                                 Menunggu
                                            </span>
                                        @elseif($item->status == 'dipinjam')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800 border border-blue-200">
                                                 Dipinjam
                                            </span>
                                        @elseif($item->status == 'dikembalikan')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800 border border-green-200">
                                                 Dikembalikan
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800 border border-red-200">
                                                 Ditolak
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            @if($item->status == 'menunggu')
                                                <form action="{{ route('peminjaman.terima', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="button" onclick="konfirmasiTerima(this, '{{ $item->user->name }}')" class="bg-black text-white px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-gray-800 transition active:scale-95 shadow-sm">
                                                        Terima
                                                    </button>
                                                </form>

                                                <form action="{{ route('peminjaman.tolak', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="button" onclick="konfirmasiTolak(this, '{{ $item->user->name }}')" class="bg-red-50 text-red-600 px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-red-100 hover:text-red-700 transition active:scale-95 border border-red-100 shadow-sm">
                                                        Tolak
                                                    </button>
                                                </form>
                                            
                                            @elseif($item->status == 'dipinjam')
                                                <form action="{{ route('peminjaman.return', $item->id) }}" method="POST">
                                                    @csrf
                                                    <button type="button" onclick="konfirmasiSelesai(this, '{{ $item->user->name }}', '{{ $item->buku->judul }}')" class="text-xs font-bold text-black border border-black px-3 py-1.5 rounded-full hover:bg-black hover:text-white transition shadow-sm active:scale-95">
                                                        Selesai
                                                    </button>
                                                </form>
                                                
                                            @else
                                                <span class="text-xs font-medium text-gray-400 italic">Selesai diproses</span>
                                            @endif
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
        function konfirmasiTerima(button, namaPeminjam) {
            Swal.fire({
                title: 'Setujui Peminjaman?',
                text: "Kamu akan menyetujui peminjaman buku dari " + namaPeminjam + ".",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#000000', 
                cancelButtonColor: '#d33',     
                confirmButtonText: 'Ya, Setujui!',
                cancelButtonText: 'Batal',
                background: '#fff',
                color: '#000'
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit();
                }
            })
        }

        function konfirmasiTolak(button, namaPeminjam) {
            Swal.fire({
                title: 'Tolak Peminjaman?',
                text: "Kamu akan menolak pengajuan peminjaman dari " + namaPeminjam + ".",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#000000', 
                cancelButtonColor: '#d33',     
                confirmButtonText: 'Ya, Tolak!',
                cancelButtonText: 'Batal',
                background: '#fff',
                color: '#000'
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit();
                }
            })
        }

        function konfirmasiSelesai(button, namaPeminjam, judulBuku) {
            Swal.fire({
                title: 'Selesaikan Peminjaman?',
                text: "Buku \"" + judulBuku + "\" dari " + namaPeminjam + " sudah dikembalikan?",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#000000', 
                cancelButtonColor: '#d33',     
                confirmButtonText: 'Ya, Sudah!',
                cancelButtonText: 'Belum',
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