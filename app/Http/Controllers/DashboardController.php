<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductModel;
use App\Models\DiscountModel;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProduct = ProductModel::count(); 
        $products = ProductModel::with('discountRelation')->paginate(10); 
        return view('auth.dashboard', compact('totalProduct', 'products')); 
    }

    public function create()
    {
        return view('auth.createData'); 
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'description'   => 'required|string',
            'price'         => 'required|numeric|min:0',
            'stock'         => 'required|integer|min:0',
            'discount'      => 'nullable|numeric|min:0|max:100',
        ]);

        DB::transaction(function () use ($validated) {
            $product = ProductModel::create([
                'name'        => $validated['name'],
                'description' => $validated['description'],
                'price'       => $validated['price'],
                'stock'       => $validated['stock'],
            ]);

            DiscountModel::create([
                'product_id' => $product->id,
                'discount'   => $validated['discount'] ?? 0,
            ]);
        });

        return redirect()->route('dashboard.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(ProductModel $product)
    {
        $product->load('discountRelation');
        return view('auth.editData', compact('product')); 
    }

    public function update(Request $request, ProductModel $product)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'description'   => 'required|string',
            'price'         => 'required|numeric|min:0',
            'stock'         => 'required|integer|min:0',
            'discount'      => 'nullable|numeric|min:0|max:100',
        ]);

        DB::transaction(function () use ($product, $validated) {
            $product->update([
                'name'        => $validated['name'],
                'description' => $validated['description'],
                'price'       => $validated['price'],
                'stock'       => $validated['stock'],
            ]);

            DiscountModel::updateOrCreate(
                ['product_id' => $product->id],
                ['discount'   => $validated['discount'] ?? 0]
            );
        });

        return redirect()->route('dashboard.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(ProductModel $product)
    {
        $product->delete();
        return redirect()->route('dashboard.index')->with('success', 'Produk berhasil dihapus!');
    }
}