<?php

namespace App\Http\Controllers;

use App\Events\SosAlertCreated;
use App\Models\SosAlert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class SosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'latitude' => ['required','numeric','between:-90,90'],
            'longitude' => ['required','numeric','between:-180,180'],
            'message' => ['nullable','string','max:2000'],
        ]);

        $alert = SosAlert::create([
            'user_id' => Auth::id(),
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
            'message' => $data['message'] ?? null,
            'status' => 'pending',
        ]);

        // Broadcast event for realtime admin listeners
        event(new SosAlertCreated($alert));

        return response()->json(['success' => true, 'id' => $alert->id], Response::HTTP_CREATED);
    }

    /**
     * Show user's SOS history
     */
    public function history()
    {
        $alerts = SosAlert::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('sos-history', compact('alerts'));
    }
}

