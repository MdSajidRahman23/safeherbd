<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SosAlert;
use App\Events\SosAlertCreated;
use Illuminate\Support\Facades\Auth;

class SosController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'message' => 'nullable|string|max:500',
        ]);

        $alert = SosAlert::create([
            'user_id' => Auth::id(),
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'message' => $request->message ?? 'Immediate assistance required.',
            'status' => 'pending',
        ]);

        event(new SosAlertCreated($alert));

        return response()->json([
            'success' => true,
            'message' => 'SOS Alert sent successfully!',
            'alert_id' => $alert->id
        ], 201);
    }
    
    public function index()
    {

        $alerts = SosAlert::with('user')->latest()->get();
        return view('admin.dashboard', compact('alerts'));
    }

    public function close(Request $request, $id)
    {
        $alert = SosAlert::findOrFail($id);
        $alert->update(['status' => 'Closed']);

        return response()->json(['success' => true, 'message' => 'Alert closed successfully']);
    }
}
