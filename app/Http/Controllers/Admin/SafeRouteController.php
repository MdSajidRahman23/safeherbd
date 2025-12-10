<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SafeRoute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SafeRouteController extends Controller
{
    /**
     * Display a listing of safe routes with map visualization
     */
    public function index()
    {
        $safeRoutes = SafeRoute::with('creator')->latest()->get();
        return view('admin.safe-routes.index', compact('safeRoutes'));
    }

    /**
     * Show the form for creating a new safe route
     */
    public function create()
    {
        return view('admin.safe-routes.create');
    }

    /**
     * Store a newly created safe route in storage
     */
    public function store(Request $request)
    {
        $request->validate([
            'route_name' => 'required|string|max:255',
            'coordinates_json' => 'required|string',
        ]);

        // Parse coordinates and calculate total crime score
        $coordinates = json_decode($request->coordinates_json, true);
        $totalScore = $this->calculateCrimeScore($coordinates);

        SafeRoute::create([
            'route_name' => $request->route_name,
            'coordinates_json' => $request->coordinates_json,
            'total_score' => $totalScore,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('admin.safe-routes.index')
                        ->with('success', 'Safe route created successfully!');
    }

    /**
     * Show the form for editing the specified safe route
     */
    public function edit(SafeRoute $safeRoute)
    {
        return view('admin.safe-routes.edit', compact('safeRoute'));
    }

    /**
     * Update the specified safe route in storage
     */
    public function update(Request $request, SafeRoute $safeRoute)
    {
        $request->validate([
            'route_name' => 'required|string|max:255',
            'coordinates_json' => 'required|string',
        ]);

        // Parse coordinates and calculate total crime score
        $coordinates = json_decode($request->coordinates_json, true);
        $totalScore = $this->calculateCrimeScore($coordinates);

        $safeRoute->update([
            'route_name' => $request->route_name,
            'coordinates_json' => $request->coordinates_json,
            'total_score' => $totalScore,
        ]);

        return redirect()->route('admin.safe-routes.index')
                        ->with('success', 'Safe route updated successfully!');
    }

    /**
     * Remove the specified safe route from storage
     */
    public function destroy(SafeRoute $safeRoute)
    {
        $safeRoute->delete();

        return redirect()->route('admin.safe-routes.index')
                        ->with('success', 'Safe route deleted successfully!');
    }

    /**
     * Calculate crime score based on coordinates
     * Crime point logic: Theft=1, Robbery=3, Kidnapping=5
     */
    private function calculateCrimeScore($coordinates)
    {
        $totalScore = 0;
        
        // Assuming coordinates contain crime points with types
        // Structure: [{"lat": 23.8103, "lng": 90.4125, "crime_type": "theft", "score": 1}]
        foreach ($coordinates as $point) {
            if (isset($point['crime_type']) && isset($point['score'])) {
                $totalScore += $point['score'];
            }
        }

        return $totalScore;
    }
}
