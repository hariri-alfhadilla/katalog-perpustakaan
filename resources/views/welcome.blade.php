<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bobooks - Perpustakaan Digital</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,900&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="antialiased bg-white text-gray-900">

    <nav class="bg-white/80 backdrop-blur-md fixed w-full z-10 top-0 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex-shrink-0 flex items-center gap-3">
                    <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <span class="font-black text-xl tracking-tighter text-black">Bobooks.</span>
                </div>

                <div class="hidden sm:flex sm:items-center sm:gap-6">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm font-medium text-gray-500 hover:text-black transition">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-medium text-gray-500 hover:text-black transition">Masuk</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="rounded-full bg-black px-6 py-2 text-sm font-medium text-white hover:bg-gray-800 transition">
                                    Daftar
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden bg-white">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            
            <h1 class="text-5xl sm:text-7xl font-black text-gray-900 tracking-tighter mb-8 leading-tight">
                Perpustakaan. <br>
                <span class="text-gray-400">Digital & Modern.</span>
            </h1>
            
            <p class="text-xl text-gray-500 max-w-xl mx-auto mb-12 font-normal leading-relaxed">
                Platform manajemen buku sekolah yang dirancang untuk kecepatan dan kemudahan akses. Tanpa ribet.
            </p>
            
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('register') }}" class="px-8 py-4 bg-black text-white rounded-full font-medium hover:bg-gray-800 transition w-full sm:w-auto">
                    Mulai Sekarang
                </a>
                <a href="#fitur" class="px-8 py-4 bg-gray-100 text-gray-900 rounded-full font-medium hover:bg-gray-200 transition w-full sm:w-auto">
                    Pelajari Lebih Lanjut
                </a>
            </div>
        </div>
    </section>

    <section id="fitur" class="py-24 bg-white border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div class="group">
                    <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center text-black mb-6 border border-gray-100 group-hover:bg-black group-hover:text-white transition duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2 tracking-tight">Pencarian Instan</h3>
                    <p class="text-gray-500 leading-relaxed text-sm">Algoritma pencarian yang dioptimalkan untuk menemukan buku dalam milidetik.</p>
                </div>
                <div class="group">
                    <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center text-black mb-6 border border-gray-100 group-hover:bg-black group-hover:text-white transition duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2 tracking-tight">Stok Real-time</h3>
                    <p class="text-gray-500 leading-relaxed text-sm">Sinkronisasi data otomatis. Apa yang Anda lihat di layar adalah apa yang tersedia di rak.</p>
                </div>
                <div class="group">
                    <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center text-black mb-6 border border-gray-100 group-hover:bg-black group-hover:text-white transition duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2 tracking-tight">Jurnal Digital</h3>
                    <p class="text-gray-500 leading-relaxed text-sm">Pencatatan riwayat peminjaman yang terstruktur rapi untuk setiap siswa.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-white border-t border-gray-100 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="text-center md:text-left">
                <span class="font-black text-lg text-black tracking-tighter">Bobooks.</span>
                <p class="text-xs text-gray-400 mt-2">© 2026. Dibuat dengan presisi.</p>
            </div>
            <div class="flex space-x-8 text-sm font-medium">
                <a href="#" class="text-gray-400 hover:text-black transition">Bantuan</a>
                <a href="#" class="text-gray-400 hover:text-black transition">Privasi</a>
                <a href="#" class="text-gray-400 hover:text-black transition">Syarat</a>
            </div>
        </div>
    </footer>

</body>
</html>