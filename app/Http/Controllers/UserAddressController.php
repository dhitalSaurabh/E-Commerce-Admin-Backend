<?php

namespace App\Http\Controllers;

use App\Models\userAddress;
use App\Http\Requests\StoreuserAddressRequest;
use App\Http\Requests\UpdateuserAddressRequest;

class UserAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreuserAddressRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(userAddress $userAddress)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateuserAddressRequest $request, userAddress $userAddress)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(userAddress $userAddress)
    {
        //
    }
}
