<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SosAlert;
use Illuminate\Support\Facades\Auth;

class SosController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'message' => 'nullable|string|max:255',
        ]);

        $alert = SosAlert::create([
            'user_id' => Auth::id(),
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'message' => $request->message ?? 'Immediate assistance required.',
            'status' => 'Open',
        ]);

        return response()->json([
            'message' => 'SOS Alert sent successfully!', 
            'alert_id' => $alert->id
        ], 201);
    }
    
    public function index()
    {

        $alerts = SosAlert::with('user')->latest()->get();
        return view('admin.dashboard', compact('alerts'));
    }
}
