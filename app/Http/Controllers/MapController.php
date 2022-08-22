<?php

namespace App\Http\Controllers;

use App\Models\Tower;
use Illuminate\Http\Request;

class MapController extends Controller
{
        
    public function show()
    {
        $allTowers = Tower::all();
        return view('mapa', compact('allTowers'));
    }
    
    public function add (Request $request)
    {
        //dd($request);
        return response()->json(['success'=>'Ajax request submitted successfully']);
    }
}
