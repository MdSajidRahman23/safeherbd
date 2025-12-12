<?php

namespace App\Http\Controllers;


use App\Models\SafeRoute;
use App\Models\RouteReport;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    /**
     * Display list of safe routes for users
     */
    public function index()
    {
        $routes = SafeRoute::with('creator')
            ->orderBy('total_score', 'asc')
            ->get();

        return view('safe-routes.index', compact('routes'));
    }


    /**
     * Report an unsafe spot on a route
     */
    public function reportUnsafeSpot(Request $request)
    {
        $request->validate([
            'route_id' => 'required|exists:safe_routes,id',
            'message' => 'required|string|max:1000',
            'incident_type' => 'required|in:theft,robbery,kidnapping,harassment,other',
            'location' => 'nullable|string',
        ]);

        // Create route report
        RouteReport::create([
            'safe_route_id' => $request->route_id,
            'user_id' => auth()->id(),
            'incident_type' => $request->incident_type,
            'message' => $request->message,
            'location' => $request->location ? json_decode($request->location, true) : null,
            'status' => 'pending',
        ]);

        // Update route safety score based on incident type
        $route = SafeRoute::find($request->route_id);
        $this->updateRouteScore($route, $request->incident_type);

        return response()->json([
            'success' => true, 
            'message' => 'Report submitted successfully and route safety score updated'
        ]);
    }

    /**
     * Update route safety score based on incident type
     */
    private function updateRouteScore($route, $incidentType)
    {
        $scores = [
            'theft' => 1,
            'robbery' => 3,
            'kidnapping' => 5,
            'harassment' => 2,
            'other' => 1,
        ];

        $scoreToAdd = $scores[$incidentType] ?? 1;

        // Update incident count based on type
        switch ($incidentType) {
            case 'theft':
                $route->increment('theft_count');
                break;
            case 'robbery':
                $route->increment('robbery_count');
                break;
            case 'kidnapping':
                $route->increment('kidnapping_count');
                break;
        }

        // Calculate new total score
        $route->total_score = ($route->theft_count * 1) + 
                             ($route->robbery_count * 3) + 
                             ($route->kidnapping_count * 5);
        $route->save();
    }
}