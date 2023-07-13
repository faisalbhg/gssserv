<?php

namespace App\Http\Controllers;

use App\Models\ItemProductSalePrice;
use App\Http\Requests\StoreItemProductSalePriceRequest;
use App\Http\Requests\UpdateItemProductSalePriceRequest;

class ItemProductSalePriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreItemProductSalePriceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreItemProductSalePriceRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ItemProductSalePrice  $itemProductSalePrice
     * @return \Illuminate\Http\Response
     */
    public function show(ItemProductSalePrice $itemProductSalePrice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ItemProductSalePrice  $itemProductSalePrice
     * @return \Illuminate\Http\Response
     */
    public function edit(ItemProductSalePrice $itemProductSalePrice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateItemProductSalePriceRequest  $request
     * @param  \App\Models\ItemProductSalePrice  $itemProductSalePrice
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateItemProductSalePriceRequest $request, ItemProductSalePrice $itemProductSalePrice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ItemProductSalePrice  $itemProductSalePrice
     * @return \Illuminate\Http\Response
     */
    public function destroy(ItemProductSalePrice $itemProductSalePrice)
    {
        //
    }
}
