<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBikeRequest;
use App\Http\Requests\UpdateBikeRequest;
use App\Models\Bike;

class BikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('bikes');
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
     * @param  \App\Http\Requests\StoreBikeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBikeRequest $request)
    {
        //
    }

    
    public function edit(Bike $bike)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBikeRequest  $request
     * @param  \App\Models\Bike  $bike
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBikeRequest $request, Bike $bike)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bike  $bike
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bike $bike)
    {
        //
    }
}
