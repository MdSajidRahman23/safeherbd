<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SafeRoute;
use App\Models\ForumReport;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{

    // 1. Dashboard Page (Stats)
    public function index()
    {
        $totalUsers = User::where('role', 'user')->count();
        $totalRoutes = SafeRoute::count();
        $totalSos = DB::table('sos_alerts')->count(); 
        
        // Get recent SOS alerts for the dashboard
        $alerts = DB::table('sos_alerts')
            ->join('users', 'sos_alerts.user_id', '=', 'users.id')
            ->select('sos_alerts.*', 'users.name as user_name')
            ->orderBy('sos_alerts.created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact('totalUsers', 'totalRoutes', 'totalSos', 'alerts'));
    }

    
    public function usersIndex()
    {
        $users = User::where('role', 'user')->get();
        return view('admin.users', compact('users'));
    }

    // Block user
    public function blockUser($id)
    {
        $user = User::findOrFail($id);
        $user->is_blocked = true; 
        $user->save();

        return back()->with('success', 'User blocked successfully.');
    }

    // Unblock user
    public function unblockUser($id)
    {
        $user = User::findOrFail($id);
        $user->is_blocked = false; 
        $user->save();

        return back()->with('success', 'User unblocked successfully.');
    }

    
    public function destroyUser($id)
    {
        User::destroy($id);
        return back()->with('success', 'User deleted successfully.');
    }

    // Safe Routes Management
    public function safeRoutesIndex()
    {
        $safeRoutes = SafeRoute::with('creator')->latest()->get();
        return view('admin.safe-routes', compact('safeRoutes'));
    }

    // Reports Management
    public function reportsIndex()
    {
        $reports = ForumReport::with(['post', 'reporter'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('admin.reports', compact('reports'));
    }

    // Update report status
    public function updateReportStatus(Request $request, $id)
    {
        $report = ForumReport::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:pending,reviewed,resolved'
        ]);

        $report->update(['status' => $request->status]);
        
        return response()->json(['success' => true]);
    }

    // Delete report
    public function destroyReport($id)
    {
        ForumReport::destroy($id);
        return response()->json(['success' => true]);
    }
}
