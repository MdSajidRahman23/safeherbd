<?php

namespace App\Http\Controllers;

use App\Models\SafeRoute;
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
        ]);

        // Store the report - you could create a RouteReport model for this
        // For now, just log it or store in database
        \Log::info('Unsafe spot reported on route ' . $request->route_id . ': ' . $request->message);

        // TODO: Create a route_reports table and save the report
        // For now, just return success
        return response()->json(['success' => true, 'message' => 'Report submitted successfully']);
    }
}