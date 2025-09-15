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
        $validated = $request->validate([
            // 'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'size' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:50',
            'material' => 'nullable|string|max:100',
            'additional_price' => 'nullable|numeric',
            'sku' => 'nullable|string|max:100|unique:product_varients,sku',
        ]);

        $productVarient = $request->user()->productVarient()->create($validated);

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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductVarient $productVarient)
    {
        // $productVarient = ProductVarient::findOrFail($id);

        $validated = $request->validate([
            // 'user_id' => 'sometimes|required|exists:users,id',
            'product_id' => 'nullable|exists:products,id',
            'size' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:50',
            'material' => 'nullable|string|max:100',
            'additional_price' => 'nullable|numeric',
            'sku' => 'nullable|string|max:100|unique:product_varients,sku,',
        ]);

        $productVarient->update($validated);

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
