<x-guest-layout>
    <div class="absolute top-4 left-4">
        <a href="/" class="group flex items-center text-sm font-medium text-gray-400 hover:text-black transition">
            <svg class="w-4 h-4 mr-1 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Beranda
        </a>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-8 text-center pt-4">
        <a href="/" class="inline-flex items-center justify-center gap-2 mb-6 group">
            <div class="p-2 bg-gray-50 rounded-xl group-hover:bg-gray-100 transition">
                <svg class="w-8 h-8 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
            <span class="font-black text-2xl tracking-tighter text-black">Bobooks.</span>
        </a>

        <h2 class="text-2xl font-black text-gray-900">Selamat Datang Kembali</h2>
        <p class="text-sm text-gray-500 mt-2">Masukan detail akun anda untuk melanjutkan.</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <div>
            <label for="email" class="block text-xs font-bold text-gray-500 mb-2 uppercase tracking-wide">Email</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                </div>
                <input id="email" class="w-full pl-11 rounded-xl border-gray-200 focus:border-black focus:ring-black shadow-sm transition h-12 placeholder-gray-400 text-sm font-medium bg-gray-50/50 focus:bg-white" 
                       type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="nama@sekolah.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <div class="flex justify-between items-center mb-2">
                <label for="password" class="block text-xs font-bold text-gray-500 uppercase tracking-wide">Password</label>
            </div>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <input id="password" class="w-full pl-11 rounded-xl border-gray-200 focus:border-black focus:ring-black shadow-sm transition h-12 placeholder-gray-400 text-sm font-medium bg-gray-50/50 focus:bg-white"
                                type="password"
                                name="password"
                                required autocomplete="current-password" placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-black shadow-sm focus:ring-black" name="remember">
                <span class="ms-2 text-sm text-gray-600 font-medium">{{ __('Ingat Saya') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-bold text-gray-900 hover:underline" href="{{ route('password.request') }}">
                    {{ __('Lupa Password?') }}
                </a>
            @endif
        </div>

        <button type="submit" class="w-full bg-black hover:bg-gray-800 text-white font-bold py-3.5 px-4 rounded-xl shadow-lg shadow-gray-200 transition transform hover:-translate-y-0.5 flex justify-center items-center gap-2">
            <span>Masuk Sekarang</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
        </button>

        <div class="text-center mt-6">
            <p class="text-sm text-gray-500">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="font-bold text-black hover:underline">
                    Daftar di sini
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>