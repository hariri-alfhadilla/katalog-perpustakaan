<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-900 leading-tight tracking-tight">
            {{ __('Peminjaman Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
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

            <div class="mb-8 bg-black rounded-3xl shadow-lg p-6 sm:p-8 text-white flex flex-col md:flex-row md:items-center justify-between overflow-hidden relative">
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-white opacity-5 rounded-full blur-2xl"></div>
                <div class="absolute right-20 -bottom-10 w-32 h-32 bg-white opacity-5 rounded-full blur-xl"></div>
                
                <div class="relative z-10 w-full md:w-1/2">
                    <p class="text-gray-400 text-xs sm:text-sm font-bold uppercase tracking-widest mb-1 sm:mb-2">Total Buku Aktif</p>
                    <div class="flex items-baseline gap-2">
                        <h3 class="text-5xl sm:text-6xl font-black leading-none">
                            {{ $peminjaman->whereIn('status', ['menunggu', 'dipinjam'])->count() }}
                        </h3>
                        <span class="text-lg sm:text-xl font-medium text-gray-300">/ 3 Buku</span>
                    </div>
                    <p class="text-xs sm:text-sm text-gray-400 mt-3 sm:mt-4">
                        Kamu memiliki sisa kuota pinjam sebanyak <strong>{{ 3 - $peminjaman->whereIn('status', ['menunggu', 'dipinjam'])->count() }}</strong> buku lagi.
                    </p>
                </div>

                <div class="relative z-10 w-full md:w-1/2 mt-6 md:mt-0 bg-white/5 p-4 rounded-2xl border border-white/10 backdrop-blur-sm">
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-3">Daftar Buku Kamu:</p>
                    <ul class="space-y-2">
                        @forelse($peminjaman->whereIn('status', ['menunggu', 'dipinjam']) as $active)
                            <li class="flex items-start gap-3">
                                <div class="mt-1 flex-shrink-0 w-2 h-2 rounded-full {{ $active->status == 'dipinjam' ? 'bg-blue-400 shadow-[0_0_8px_rgba(96,165,250,0.6)]' : 'bg-yellow-400 shadow-[0_0_8px_rgba(250,204,21,0.6)]' }}"></div>
                                <div class="flex flex-col">
                                    <span class="text-xs font-bold leading-tight line-clamp-1">{{ $active->buku->judul }}</span>
                                    <span class="text-[10px] text-gray-500 italic">{{ $active->status == 'dipinjam' ? 'Sudah ditangan' : 'Menunggu admin' }}</span>
                                </div>
                            </li>
                        @empty
                            <li class="text-xs text-gray-500 italic">Belum ada buku yang aktif dipinjam.</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100 p-4 sm:p-8">
                
                @if($peminjaman->isEmpty())
                    <div class="text-center py-10">
                        <div class="bg-gray-50 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 border border-gray-100">
                            <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Belum ada buku dipinjam</h3>
                        <p class="text-gray-500 mt-1 text-sm">Ayo mulai membaca dan pinjam buku favoritmu sekarang.</p>
                        <a href="{{ route('dashboard') }}" class="inline-block mt-4 px-6 py-2 bg-black text-white rounded-full text-sm font-bold hover:bg-gray-800 transition shadow-lg shadow-gray-200">
                            Cari Buku
                        </a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto text-left">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500 font-semibold">
                                    <th class="px-6 py-4 rounded-tl-lg">Judul Buku</th>
                                    <th class="px-6 py-4">Tgl Pengajuan</th>
                                    <th class="px-6 py-4">Tgl Pinjam</th>
                                    <th class="px-6 py-4 text-center">Status</th>
                                    <th class="px-6 py-4 rounded-tr-lg text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($peminjaman as $item)
                                <tr class="group hover:bg-gray-50/50 transition duration-150">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-14 w-10 bg-gray-100 rounded-md overflow-hidden flex items-center justify-center text-gray-400 mr-4 shadow-sm group-hover:shadow transition">
                                                @if($item->buku->cover)
                                                    <img src="{{ asset('storage/' . $item->buku->cover) }}" alt="Cover {{ $item->buku->judul }}" class="h-full w-full object-cover">
                                                @else
                                                    <svg class="h-5 w-5 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="text-sm font-bold text-gray-900">{{ $item->buku->judul }}</div>
                                                <div class="text-xs text-gray-500 font-medium mt-0.5">{{ $item->buku->penulis }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-4 text-sm text-gray-600 font-medium">
                                        {{ $item->created_at->format('d M Y') }}
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-500 font-medium">
                                        {{ $item->tanggal_peminjaman ? \Carbon\Carbon::parse($item->tanggal_peminjaman)->format('d M Y') : '-' }}
                                    </td>
                                    
                                    <td class="px-6 py-4 text-center">
                                        @if($item->status == 'menunggu')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800 border border-yellow-200">
                                                Menunggu Persetujuan
                                            </span>
                                        @elseif($item->status == 'dipinjam')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800 border border-blue-200">
                                                Sedang Dipinjam
                                            </span>
                                        @elseif($item->status == 'dikembalikan')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800 border border-green-200">
                                                Dikembalikan
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800 border border-red-200">
                                                Ditolak Admin
                                            </span>
                                        @endif
                                    </td>
                                    
                                    <td class="px-6 py-4 text-right">
                                        @if($item->status == 'dipinjam')
                                            <form action="{{ route('peminjaman.return', $item->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="bg-white border border-gray-200 text-gray-700 hover:text-red-600 hover:border-red-200 hover:bg-red-50 px-4 py-2 rounded-lg text-xs font-bold transition duration-200 shadow-sm active:scale-95">
                                                    Kembalikan
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-xs text-gray-400 font-medium italic">-</span>
                                        @endif
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
</x-app-layout>