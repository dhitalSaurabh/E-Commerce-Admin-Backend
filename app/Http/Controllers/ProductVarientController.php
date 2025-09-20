<?php

namespace App\Http\Controllers;

use App\Models\ProductVarient;
use Illuminate\Http\Request;

class ProductVarientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $productVarient = ProductVarient::all();
        // return response()->json($productVarient);
        return response()->json([
            'message' => 'Product Varient Retrived',
            'data' => ProductVarient::with(['product.category'])->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            // 'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'size' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:50',
            'material' => 'nullable|string|max:100',
            'price' => 'nullable|numeric',
            'sku' => 'nullable|string|max:100|unique:product_varients,sku',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('variant_images', 'public');
            $fields['image'] = url('storage/' . $imagePath);
        }
        $productVarient = $request->user()->productVarient()->create($fields);

        return response()->json($productVarient, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductVarient $productVarient)
    {
        return response()->json([
            'message' => 'Product Varient Retrived',
            'data' => $productVarient->load(['product.category']),
        ]);
    }

    public function getByProductId($productId)
    {
        $variants = ProductVarient::with(['product.category'])
        ->where('product_id', $productId)->get();
         return response()->json([
        'message' => 'Product Variants Retrieved',
        'data' => $variants,
    ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductVarient $productVarient)
    {
        // $productVarient = ProductVarient::findOrFail($id);

        $fields = $request->validate([
            // 'user_id' => 'sometimes|required|exists:users,id',
            'product_id' => 'nullable|exists:products,id',
            'size' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:50',
            'material' => 'nullable|string|max:100',
            'price' => 'nullable|numeric',
            'sku' => 'nullable|string|max:100|unique:product_varients,sku,',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('variant_images', 'public');
            $fields['image'] = url('storage/' . $imagePath);
        }
        $productVarient->update($fields);

        return response()->json([
            'message' => 'Product varient updated successfully',
            'data' => $productVarient,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductVarient $productVarient)
    {
        $productVarient->delete();

        return response()->json([
            'message' => 'Product varient deleted successfully',
        ]);
    }
}
