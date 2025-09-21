<?php

namespace App\Http\Controllers;

use App\Models\UserAddress;

use Auth;
use Illuminate\Http\Request;

class UserAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'message' => "user address retrieved successfully",
            'data' => UserAddress::with(['customer'])->get(),
        ]);
    }
    public function showDetailsToAuthUsers()
    {
        $user = \Illuminate\Support\Facades\Auth::user(); // Get the currently authenticated user
        $userAddress = UserAddress::where('customer_id', $user->id)->with('customer')->first();

        if ($userAddress) {
            return response()->json([
                'message' => "User address retrieved successfully",
                'data' => [
                    'addressFilled' => true,
                    'address' => $userAddress,
                ],
            ]);
        } else {
            return response()->json([
                'message' => "No address found for this user",
                'data' => [
                    'addressFilled' => false,
                ],
            ], 404); // 404 Not Found
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'full_name' => 'required|string|max:150',
            'phone' => 'required|string|max:20',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'is_default' => 'boolean',
        ]);
        $user = $request->user();
        // ❌ Block creation if address already exists
        if ($user->useraddress) {
            return response()->json([
                'message' => 'User already has an address.',
            ], 409); // 409 Conflict
        }

        $userAddress = $request->user()->useraddress()->create($fields);
        // Make sure only one address can be marked as the default
        if ($userAddress->is_default) {
            UserAddress::where('customer_id', Auth::id())
                ->where('id', '!=', $address->id)
                ->update(['is_default' => false]);
        }

        return response()->json([
            "message" => "User Address created successfully",
            "data" => $userAddress,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(UserAddress $userAddress)
    {
        return response()->json([
            "message" => "user address retrieved successfully",
            "data" => $userAddress->load(['customer']),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserAddress $userAddress)
    {
        $fields = $request->validate([
            'full_name' => 'nullable|string|max:150',
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'is_default' => 'boolean',
        ]);
        $userAddress->update($fields);

        // Make sure only one address can be marked as the default
        if ($userAddress->is_default) {
            UserAddress::where('customer_id', Auth::id())
                ->where('id', '!=', $address->id)
                ->update(['is_default' => false]);
        }

        return response()->json([
            "message" => "User Address updated successfully",
            "data" => $userAddress,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserAddress $userAddress)
    {
        $userAddress->delete();
        return response()->json([
            "message" => "user Address deleted successfully",
        ]);
    }
}
