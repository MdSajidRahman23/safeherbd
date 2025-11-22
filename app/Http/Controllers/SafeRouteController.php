<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SafeRoute;
use Illuminate\Support\Facades\Auth;

class SafeRouteController extends Controller
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
            'coordinates' => 'required', 
            
            'crime_points' => 'nullable|numeric',
        ]);

        SafeRoute::create([
            'route_name' => $request->route_name,
            'coordinates' => json_decode($request->coordinates),
            'total_score' => $request->crime_points ?? 0,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('safe-routes.index')->with('success', 'Safe Route created successfully!');
    }
}