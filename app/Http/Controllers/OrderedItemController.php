<?php

namespace App\Http\Controllers;

use App\Models\orderedItem;
use App\Http\Requests\StoreorderedItemRequest;
use App\Http\Requests\UpdateorderedItemRequest;

class OrderedItemController extends Controller
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
    public function store(StoreorderedItemRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(orderedItem $orderedItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateorderedItemRequest $request, orderedItem $orderedItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(orderedItem $orderedItem)
    {
        //
    }
}
