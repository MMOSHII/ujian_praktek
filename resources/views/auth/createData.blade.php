<x-layout>
    <div class="max-w-2xl mx-auto px-4 py-8">
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 sm:p-8">
            <div class="mb-6">
                <h2 class="text-xl font-bold text-gray-900 tracking-tight">Tambah Produk Baru</h2>
                <p class="text-sm text-gray-500 mt-1">Isi formulir di bawah ini untuk menambahkan produk ke katalog toko Anda.</p>
            </div>

            <form action="{{ route('dashboard.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
                    <input type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}" 
                        required
                        class="w-full px-3.5 py-2 text-sm bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition shadow-sm"
                        placeholder="Masukkan nama produk">
                </div>
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea id="description" 
                            name="description" 
                            rows="3" 
                            required
                            class="w-full px-3.5 py-2 text-sm bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition shadow-sm"
                            placeholder="Tuliskan deskripsi produk">{{ old('description') }}</textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    {{-- Harga --}}
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp)</label>
                        <input type="number" 
                            id="price" 
                            name="price" 
                            value="{{ old('price') }}" 
                            required 
                            min="0"
                            class="w-full px-3.5 py-2 text-sm bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition shadow-sm"
                            placeholder="0">
                    </div>

                    <div>
                        <label for="discount" class="block text-sm font-medium text-gray-700 mb-1">Diskon (%)</label>
                        <input type="number" 
                            id="discount" 
                            name="discount" 
                            value="{{ old('discount', 0) }}" 
                            min="0" 
                            max="100"
                            class="w-full px-3.5 py-2 text-sm bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition shadow-sm"
                            placeholder="0">
                    </div>

                    <div>
                        <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stok</label>
                        <input type="number" 
                            id="stock" 
                            name="stock" 
                            value="{{ old('stock') }}" 
                            required 
                            min="0"
                            class="w-full px-3.5 py-2 text-sm bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition shadow-sm"
                            placeholder="0">
                    </div>
                </div>

                <div class="pt-4 flex items-center justify-end space-x-3 border-t border-gray-100">
                    <a href="{{ route('dashboard.index') }}" 
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition shadow-sm">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition shadow-sm">
                        Simpan Produk
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layout>