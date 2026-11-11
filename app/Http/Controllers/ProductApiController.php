<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductModel;
use App\Models\DiscountModel;
use Illuminate\Support\Facades\DB;

class ProductApiController extends Controller
{
    public function index()
    {
        $totalProduct = ProductModel::count(); 
        $products = ProductModel::with('discountRelation')->paginate(10); 

        return response()->json([
            'status'  => 'success',
            'message' => 'Daftar produk berhasil diambil',
            'data'    => [
                'total_product' => $totalProduct,
                'products'      => $products
            ]
        ], 200);
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

        $product = DB::transaction(function () use ($validated) {
            $newProduct = ProductModel::create([
                'name'        => $validated['name'],
                'description' => $validated['description'],
                'price'       => $validated['price'],
                'stock'       => $validated['stock'],
            ]);

            DiscountModel::create([
                'product_id' => $newProduct->id,
                'discount'   => $validated['discount'] ?? 0,
            ]);

            return $newProduct;
        });

        $product->load('discountRelation');

        return response()->json([
            'status'  => 'success',
            'message' => 'Produk berhasil ditambahkan!',
            'data'    => $product
        ], 201);
    }

    public function show(ProductModel $product)
    {
        $product->load('discountRelation');

        return response()->json([
            'status'  => 'success',
            'message' => 'Detail produk berhasil diambil',
            'data'    => $product
        ], 200);
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

        $product->load('discountRelation');

        return response()->json([
            'status'  => 'success',
            'message' => 'Produk berhasil diperbarui!',
            'data'    => $product
        ], 200);
    }

    public function destroy(ProductModel $product)
    {
        $product->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Produk berhasil dihapus!'
        ], 200);
    }
}