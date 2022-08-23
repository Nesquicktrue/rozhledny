<?php

namespace App\Http\Controllers;

use App\Models\Tower;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MapController extends Controller
{
        
    public function show()
    {
        $allTowers = Tower::all();
        
        $myTowersIDs = Visit::select('tower_id')->where('user_id', Auth::id())->pluck('tower_id')->toArray();
        $myTowers = Tower::whereIn('id', $myTowersIDs)->get();
        $myTowersVisitedAt = Visit::select('tower_id', 'visited_at')->where('user_id', Auth::id())->get();

        return view('mapa', compact('allTowers', 'myTowers', 'myTowersVisitedAt'));
    }
    
    public function add (Request $request)
    {
        $visited = new Visit;
        $visited->user_id = Auth::id();
        $visited->tower_id = $request->post('towerID');
        $visited->visited_at = $request->post('visitedAt') ? $request->post('visitedAt') : date('Y-m-d', time());
        $visited->save();
        
        return response()->json(['success'=>'Zapsano uspesne']);
    }
}
