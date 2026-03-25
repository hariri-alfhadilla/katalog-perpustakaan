<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-2xl text-gray-900 leading-tight tracking-tight">
                {{ __('Dashboard Admin') }}
            </h2>
            <span class="text-sm text-gray-500 font-medium">
                {{ \Carbon\Carbon::now()->format('l, d F Y') }}
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-black rounded-2xl p-8 mb-8 text-white shadow-xl shadow-gray-200 relative overflow-hidden">
                <div class="relative z-10">
                    <h3 class="text-3xl font-black mb-2">Halo, {{ Auth::user()->name }}!</h3>
                    <p class="text-gray-400 max-w-xl">Selamat datang di pusat kontrol Bobooks. Pantau aktivitas perpustakaan dan kelola data dengan mudah dari sini.</p>
                </div>
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-gray-800 rounded-full opacity-50 blur-3xl"></div>
                <div class="absolute bottom-0 right-20 -mb-10 w-40 h-40 bg-gray-700 rounded-full opacity-30 blur-2xl"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-bold text-gray-400 uppercase tracking-wide">Koleksi Buku</p>
                            <h4 class="text-4xl font-black text-gray-900 mt-2">{{ $totalBuku }}</h4>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-xl text-black">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-bold text-gray-400 uppercase tracking-wide">Anggota Siswa</p>
                            <h4 class="text-4xl font-black text-gray-900 mt-2">{{ $totalAnggota }}</h4>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-xl text-black">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-bold text-gray-400 uppercase tracking-wide">Sedang Dipinjam</p>
                            <h4 class="text-4xl font-black text-gray-900 mt-2">{{ $totalPinjam }}</h4>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-xl text-black">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        </div>
                    </div>
                </div>

                
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <a href="{{ route('buku.index') }}" class="group bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:border-black transition flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-gray-50 flex items-center justify-center group-hover:bg-black group-hover:text-white transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">Kelola Katalog Buku</h4>
                            <p class="text-sm text-gray-500">Tambah, edit, atau hapus buku.</p>
                        </div>
                    </div>
                    <svg class="w-5 h-5 text-gray-300 group-hover:text-black transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>

                <a href="{{ route('anggota.index') }}" class="group bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:border-black transition flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-gray-50 flex items-center justify-center group-hover:bg-black group-hover:text-white transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">Kelola Katalog Anggota</h4>
                            <p class="text-sm text-gray-500">Pantau akun anggota siswa.</p>
                        </div>
                    </div>
                    <svg class="w-5 h-5 text-gray-300 group-hover:text-black transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>

        </div>
    </div>
</x-app-layout>