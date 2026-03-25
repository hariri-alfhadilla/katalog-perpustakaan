<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-2xl text-gray-900 leading-tight tracking-tight">
                {{ __('Tambah Buku Baru') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8"> 
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100">
                <div class="p-8 text-gray-900">

                    <form action="{{ route('buku.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Judul Buku</label>
                            <input type="text" name="judul" class="w-full rounded-xl border-gray-300 focus:border-black focus:ring-black shadow-sm transition h-12 px-4 placeholder-gray-400" placeholder="Contoh: Laskar Pelangi" required>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Penulis</label>
                                <input type="text" name="penulis" class="w-full rounded-xl border-gray-300 focus:border-black focus:ring-black shadow-sm transition h-12 px-4 placeholder-gray-400" placeholder="Nama Penulis" required>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Penerbit</label>
                                <input type="text" name="penerbit" class="w-full rounded-xl border-gray-300 focus:border-black focus:ring-black shadow-sm transition h-12 px-4 placeholder-gray-400" placeholder="Nama Penerbit" required>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Tahun Terbit</label>
                                <input type="number" name="tahun_terbit" class="w-full rounded-xl border-gray-300 focus:border-black focus:ring-black shadow-sm transition h-12 px-4 placeholder-gray-400" placeholder="2024" required>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Stok Awal</label>
                                <input type="number" name="stok" class="w-full rounded-xl border-gray-300 focus:border-black focus:ring-black shadow-sm transition h-12 px-4 placeholder-gray-400" placeholder="Jumlah buku" required>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-gray-100">
                            <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Cover Buku (Opsional)</label>
                            <input type="file" name="cover" accept="image/png, image/jpeg, image/jpg" 
                                class="w-full rounded-xl border border-gray-300 focus:border-black focus:ring-black shadow-sm transition px-4 py-2 bg-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-black file:text-white hover:file:bg-gray-800 cursor-pointer">
                            <p class="mt-2 text-xs text-gray-500 font-medium">Format: JPG, JPEG, PNG. Maksimal ukuran 2MB. Kosongkan jika tidak ada.</p>
                            @error('cover')
                                <p class="text-xs text-red-500 font-bold mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100 mt-4">
                            <a href="{{ route('buku.index') }}" class="text-sm font-bold text-gray-500 hover:text-black transition px-4 py-2">
                                Batal
                            </a>
                            <button type="submit" class="bg-black hover:bg-gray-800 text-white font-bold py-3 px-8 rounded-full shadow-lg shadow-gray-200 transition transform hover:-translate-y-0.5">
                                Simpan Buku
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>