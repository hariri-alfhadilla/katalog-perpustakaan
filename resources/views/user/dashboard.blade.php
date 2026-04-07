<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-900 leading-tight tracking-tight">
            {{ __('Katalog Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success') || session('error'))
            <div class="mb-6">
                @if(session('success'))
                    <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r shadow-sm flex items-center">
                        <svg class="h-5 w-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <p class="text-sm text-green-800 font-medium">{{ session('success') }}</p>
                    </div>
                @endif
                @if(session('error'))
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r shadow-sm flex items-center">
                        <svg class="h-5 w-5 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                        <p class="text-sm text-red-800 font-medium">{{ session('error') }}</p>
                    </div>
                @endif
            </div>
            @endif

            @php
                $activePeminjaman = \App\Models\Peminjaman::with('buku')
                    ->where('user_id', auth()->id())
                    ->whereIn('status', ['menunggu', 'dipinjam'])
                    ->get();
                $jumlahAktif = $activePeminjaman->count();
            @endphp

            <div class="mb-8 bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col lg:flex-row justify-between items-center gap-4">
                <div class="w-full lg:w-1/3">
                    <h3 class="text-lg font-bold text-gray-900">Temukan Buku Favoritmu</h3>
                    <p class="text-gray-500 text-sm mt-1">Jelajahi koleksi ilmu pengetahuan tanpa batas.</p>
                </div>

                <form action="{{ route('dashboard') }}" method="GET" class="w-full lg:w-2/3 flex flex-col sm:flex-row gap-2">
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" name="search" placeholder="Cari judul atau penulis..." 
                            class="w-full pl-10 pr-4 py-2.5 rounded-xl border-gray-200 focus:border-black focus:ring-black transition text-sm bg-gray-50 focus:bg-white"
                            value="{{ request('search') }}">
                    </div>
                    
                    <button type="submit" class="bg-black text-white px-6 py-2.5 rounded-xl hover:bg-gray-800 transition text-sm font-bold shadow-lg shadow-gray-200 w-full sm:w-auto">
                        Cari
                    </button>
                    
                    @if(request('search'))
                    <a href="{{ route('dashboard') }}" class="bg-gray-100 text-gray-600 px-4 py-2.5 rounded-xl hover:bg-gray-200 transition text-sm flex items-center justify-center font-medium w-full sm:w-auto">
                        Reset
                    </a>
                    @endif
                </form>
            </div>
            
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 sm:gap-6">
                @foreach($buku as $item)
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-200 flex flex-col overflow-hidden group">
                    
                    <div class="relative aspect-[3/4] bg-gray-50 w-full overflow-hidden border-b border-gray-100">
                        @if($item->cover)
                            <img src="{{ asset('storage/' . $item->cover) }}" alt="Cover {{ $item->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-gray-300">
                                <svg class="w-10 h-10 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                <span class="text-[10px] font-bold uppercase tracking-widest text-gray-400">No Cover</span>
                            </div>
                        @endif
                    </div>

                    <div class="p-4 flex flex-col flex-grow">
                        <h3 class="text-sm font-bold text-gray-900 leading-snug line-clamp-2" title="{{ $item->judul }}">
                            {{ $item->judul }}
                        </h3>
                        <p class="text-xs text-gray-500 mt-1 line-clamp-1">{{ $item->penulis }}</p>
                        
                        <div class="mt-4 pt-3 border-t border-gray-50 flex items-center justify-between mt-auto">
                            <div class="flex flex-col">
                                <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Stok</span>
                                <span class="text-xs font-black {{ $item->stok > 0 ? 'text-green-600' : 'text-red-500' }}">
                                    {{ $item->stok > 0 ? $item->stok : 'Habis' }}
                                </span>
                            </div>
                            
                            <form action="{{ route('peminjaman.store', $item->id) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                    class="px-4 py-1.5 rounded-lg text-xs font-bold transition-colors {{ $item->stok > 0 && $jumlahAktif < 3 ? 'bg-black text-white hover:bg-gray-800 active:scale-95 shadow-md' : 'bg-gray-100 text-gray-400 cursor-not-allowed' }}"
                                    {{ $item->stok <= 0 || $jumlahAktif >= 3 ? 'disabled' : '' }}>
                                    Pinjam
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            @if($buku->isEmpty())
            <div class="text-center py-16 bg-white rounded-2xl border-2 border-dashed border-gray-200 mt-6">
                <div class="bg-gray-50 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900">Buku tidak ditemukan</h3>
                <p class="text-gray-500 mt-1">Coba gunakan kata kunci lain atau reset pencarian.</p>
                @if(request('search'))
                <a href="{{ route('dashboard') }}" class="inline-block mt-4 text-black font-bold hover:underline">
                    &larr; Kembali ke Semua Buku
                </a>
                @endif
            </div>
            @endif

        </div>
    </div>
</x-app-layout>