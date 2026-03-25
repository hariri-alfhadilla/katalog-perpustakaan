<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-2xl text-gray-900 leading-tight tracking-tight">
                {{ __('Registrasi Siswa Baru') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8"> <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100">
                <div class="p-8 text-gray-900">

                    <form action="{{ route('anggota.store') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Nama Lengkap</label>
                                <input type="text" name="name" class="w-full rounded-xl border-gray-300 focus:border-black focus:ring-black shadow-sm transition h-12 px-4 placeholder-gray-400" placeholder="Contoh: Budi Santoso" required>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Email Sekolah</label>
                                <input type="email" name="email" class="w-full rounded-xl border-gray-300 focus:border-black focus:ring-black shadow-sm transition h-12 px-4 placeholder-gray-400" placeholder="siswa@sekolah.com" required>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Password Awal</label>
                            <div class="relative">
                                <input type="text" name="password" value="password123" class="w-full rounded-xl border-gray-300 focus:border-black focus:ring-black shadow-sm transition h-12 px-4 placeholder-gray-500 bg-gray-50 font-medium" required>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <span class="text-xs text-gray-400 font-bold uppercase">Default</span>
                                </div>
                            </div>
                            <p class="text-sm text-gray-500 mt-2 flex items-center gap-1">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>Berikan password ini kepada siswa agar bisa login pertama kali.</span>
                            </p>
                        </div>

                        <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100 mt-4">
                            <a href="{{ route('anggota.index') }}" class="text-sm font-bold text-gray-500 hover:text-black transition px-4 py-2">
                                Batal
                            </a>
                            <button type="submit" class="bg-black hover:bg-gray-800 text-white font-bold py-3 px-8 rounded-full shadow-lg shadow-gray-200 transition transform hover:-translate-y-0.5">
                                Daftarkan Siswa
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>