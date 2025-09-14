<?php

namespace App\Http\Controllers;

use App\Models\Cloth;

use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use function PHPUnit\Framework\returnArgument;


class ClothController extends Controller
{
    // public static function middleware(): array
    // {
    //     return [
    //         new Middleware('auth:sanctum', [
    //             'except' => ['index', 'show']
    //         ]),
    //     ];
    // }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    return Cloth::latest()->get();    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    //      $user = $request->user();

    // if (!$user) {
    //     return response()->json([
    //         'isSuccess' => false,
    //         'message' => 'Unauthenticated',
    //     ], status: 401);
    // }
        $fields = $request->validate([
            'name' => 'required|string',
            'slug' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('cloth_images', 'public');
            $fields['image'] = url('storage/' . $imagePath);
        }

        // $cloth = Cloth::create($fields);
        $cloth = $request->user()->cloths()->create($fields);        
         if ($cloth == true) {
            return response()->json([
                'isSuccess' => true,
                'message' => 'Cloth created successfully',
                'data' => $cloth
            ], 201);
        } else {
            return response()->json([
                'isSuccess' => false,
                'message' => 'Cloth creation failed'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Cloth $cloth)
    {
        return response()->json([
            'message' => 'Cloths Retrieved successfully',
            'data' => $cloth,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cloth $cloth)
    {
         $fields = $request->validate([
            'name' => 'nullable|string',
            'slug' => 'nullable|string',
            'description' => 'nullable|string',
            'price' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('cloth_images', 'public');
            $fields['image'] = url('storage/' . $imagePath);
        }

         if ($cloth->update($fields) == true) {
            return response()->json([
                'isSuccess' => true,
                'message' => 'Cloth updated successfully',
                'data' => $cloth
            ], 200);
        } else {
            return response()->json([
                'isSuccess' => false,
                'message' => 'Cloth updation failed'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cloth $cloth)
    {
        $cloth->delete();
        return response()->json([
            'message' => 'Cloth deleted succesfully',
        ], 200);
    }
}
