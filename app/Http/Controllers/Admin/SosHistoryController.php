<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SosAlert;
use Illuminate\Http\Request;

class SosHistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin']);
    }

    public function index(Request $request)
    {
        $alerts = SosAlert::with('user')->latest()->paginate(25);

        return view('admin.sos-history', compact('alerts'));
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SosAlert;
use Illuminate\Http\Request;

class SosHistoryController extends Controller
{
    /**
     * Display a listing of all SOS alerts for admin
     */
    public function index()
    {
        $alerts = SosAlert::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.sos-history', compact('alerts'));
    }
}
