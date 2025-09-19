<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'message' => 'Reviews retrieved successfully',
            'data' => Review::with(['product', 'customer'])->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $fields = $request->validate([
            // 'customer_id' => 'required|exists:customers,id',
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
        ]);

        $review = $request->user()->reviews()->create($fields);

        return response()->json([
            'message' => 'Review created successfully',
            'data' => $review,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        return response()->json([
            'message' => 'Review retrieved successfully',
            'data' => $review->load(['product', 'customer', 'user']),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, review $review)
    {
         $fields = $request->validate([
            // 'customer_id' => 'nullable|exists:customers,id',
            'product_id' => 'nullable|exists:products,id',
            'rating' => 'nullable|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $review ->update($fields);

        return response()->json([
            'message' => 'Review updated successfully',
            'data' => $review,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(review $review)
    {
         $review->delete();

        return response()->json([
            'message' => 'Review deleted successfully',
        ]);
    }
}
