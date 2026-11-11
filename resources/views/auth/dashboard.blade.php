<x-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Manajemen Produk</h1>
                <p class="text-sm text-gray-500">Kelola daftar produk, diskon, dan stok toko Anda.</p>
            </div>
            <a href="{{ route('dashboard.create') }}" 
            class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm rounded-lg shadow-sm transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Produk
            </a>
        </div>

        @if(session('success'))
            <div class="p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 rounded-r-lg text-sm shadow-sm flex justify-between items-center">
                <span>{{ session('success') }}</span>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 font-bold">&times;</button>
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm flex items-center space-x-4">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Produk</p>
                    <p class="text-2xl font-extrabold text-gray-900">{{ $totalProduct }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            <th class="py-3 px-4">Nama Produk</th>
                            <th class="py-3 px-4">Harga Asli</th>
                            <th class="py-3 px-4">Diskon</th>
                            <th class="py-3 px-4">Harga Akhir</th>
                            <th class="py-3 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse($products as $product)
                            @php
                                $discountVal = $product->discountRelation->qty ?? $product->discountRelation->discount ?? 0;
                            @endphp
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="py-3.5 px-4 font-medium text-gray-900">
                                    <a href="{{ route('dashboard.edit', $product->id) }}" class="hover:text-indigo-600 transition">
                                        {{ $product->name }}
                                    </a>
                                </td>
                                <td class="py-3.5 px-4 text-gray-600">
                                    <span class="{{ $discountVal > 0 ? 'line-through text-gray-400' : '' }}">
                                        Rp{{ number_format($product->price, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4">
                                    @if($discountVal > 0)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                            {{ $discountVal }}% OFF
                                        </span>
                                    @else
                                        <span class="text-xs text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 font-semibold text-gray-900">
                                    Rp{{ number_format($product->final_price ?? $product->price, 0, ',', '.') }}
                                </td>
                                <td class="py-3.5 px-4 text-right space-x-2">
                                    <a href="{{ route('dashboard.edit', $product->id) }}" 
                                    class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-sm">
                                        Edit
                                    </a>

                                    <form action="{{ route('dashboard.destroy', $product->id) }}" 
                                        method="POST" 
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')" 
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                    </svg>
                                    <p class="text-base font-medium text-gray-900">Belum ada data produk</p>
                                    <p class="text-sm text-gray-500 mt-1">Klik tombol di atas untuk menambahkan produk baru.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($products->hasPages())
                <div class="px-4 py-3 bg-gray-50 border-t border-gray-200">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layout>