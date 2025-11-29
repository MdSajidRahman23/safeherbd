<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SafeRoute; 
use Illuminate\Support\Facades\Auth; 

class RouteController extends Controller
{
    public function index()
    {
        $routes = SafeRoute::all();
        return view('safe_routes.index', compact('routes'));
    }

    public function create()
    {
        
        return view('safe_routes.create');
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'route_name' => 'required|string|max:255',
            'coordinates' => 'required|json', 
            'theft_count' => 'nullable|integer|min:0',
            'robbery_count' => 'nullable|integer|min:0',
            'kidnapping_count' => 'nullable|integer|min:0',
            'harassment_count' => 'nullable|integer|min:0',
        ]);

       
        $theft_score = ($request->theft_count ?? 0) * 1;
        $robbery_score = ($request->robbery_count ?? 0) * 3;
        $kidnap_score = ($request->kidnapping_count ?? 0) * 5;
        $harassment_score = ($request->harassment_count ?? 0) * 5;

        $total_risk_score = $theft_score + $robbery_score + $kidnap_score + $harassment_score;

        
        SafeRoute::create([
            'route_name' => $request->route_name,
            'coordinates_json' => $request->coordinates, 
            'total_score' => $total_risk_score,
            'created_by' => Auth::id(), 
        ]);

        
        return redirect()->route('safe_routes.index')->with('success', 'Safe Route created successfully with Risk Score: ' . $total_risk_score);
    }
}