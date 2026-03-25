<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-2xl text-gray-900 leading-tight tracking-tight">
                Edit Buku: <span class="text-gray-500 font-medium">{{ $buku->judul }}</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8"> 
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100">
                <div class="p-8 text-gray-900">

                    <form action="{{ route('buku.update', $buku->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Judul Buku</label>
                            <input type="text" name="judul" value="{{ old('judul', $buku->judul) }}" 
                                class="w-full rounded-xl border-gray-300 focus:border-black focus:ring-black shadow-sm transition h-12 px-4 placeholder-gray-400" 
                                placeholder="Masukkan judul buku..." required>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Penulis</label>
                                <input type="text" name="penulis" value="{{ old('penulis', $buku->penulis) }}" 
                                    class="w-full rounded-xl border-gray-300 focus:border-black focus:ring-black shadow-sm transition h-12 px-4 placeholder-gray-400" 
                                    required>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Penerbit</label>
                                <input type="text" name="penerbit" value="{{ old('penerbit', $buku->penerbit) }}" 
                                    class="w-full rounded-xl border-gray-300 focus:border-black focus:ring-black shadow-sm transition h-12 px-4 placeholder-gray-400" 
                                    required>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Tahun Terbit</label>
                                <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}" 
                                    class="w-full rounded-xl border-gray-300 focus:border-black focus:ring-black shadow-sm transition h-12 px-4 placeholder-gray-400" 
                                    required>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Stok Buku</label>
                                <input type="number" name="stok" value="{{ old('stok', $buku->stok) }}" 
                                    class="w-full rounded-xl border-gray-300 focus:border-black focus:ring-black shadow-sm transition h-12 px-4 placeholder-gray-400" 
                                    required>
                            </div>
                        </div>

                        <div class="pt-6 mt-4 flex flex-col md:flex-row gap-6 items-start border-t border-gray-100">
                            <div class="w-32 flex-shrink-0">
                                <label class="block text-xs font-bold text-gray-500 mb-2 uppercase tracking-widest text-center">Cover Saat Ini</label>
                                @if($buku->cover)
                                    <img src="{{ asset('storage/' . $buku->cover) }}" alt="Cover {{ $buku->judul }}" class="w-full aspect-[3/4] object-cover rounded-xl shadow-sm border border-gray-200">
                                @else
                                    <div class="w-full aspect-[3/4] bg-gray-50 rounded-xl flex items-center justify-center border border-gray-200 text-gray-400">
                                        <span class="text-[10px] font-bold uppercase tracking-widest text-gray-400 text-center px-2">No Cover</span>
                                    </div>
                                @endif
                            </div>

                            <div class="flex-grow w-full">
                                <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Ganti Cover Baru (Opsional)</label>
                                <input type="file" name="cover" accept="image/png, image/jpeg, image/jpg" 
                                    class="w-full rounded-xl border border-gray-300 focus:border-black focus:ring-black shadow-sm transition px-4 py-2 bg-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-black file:text-white hover:file:bg-gray-800 cursor-pointer">
                                <p class="mt-2 text-xs text-gray-500 font-medium">Format: JPG, JPEG, PNG. Maksimal ukuran 2MB. Kosongkan jika tidak ingin mengganti gambar cover saat ini.</p>
                                @error('cover')
                                    <p class="text-xs text-red-500 font-bold mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100 mt-6">
                            <a href="{{ route('buku.index') }}" class="text-sm font-bold text-gray-500 hover:text-black transition px-4 py-2">
                                Batal
                            </a>
                            <button type="submit" class="bg-black hover:bg-gray-800 text-white font-bold py-3 px-8 rounded-full shadow-lg shadow-gray-200 transition transform hover:-translate-y-0.5">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>