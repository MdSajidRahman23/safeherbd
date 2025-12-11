<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SafeRoute; // Assuming Zahin has this model
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // 1. Dashboard Page (Stats)
    public function index()
    {
        $totalUsers = User::where('role', 'user')->count();
        $totalRoutes = SafeRoute::count();
        
        
        $totalSos = DB::table('sos_alerts')->count(); 

        return view('admin.dashboard', compact('totalUsers', 'totalRoutes', 'totalSos'));
    }

    
    public function usersIndex()
    {
        $users = User::where('role', 'user')->get();
        return view('admin.users', compact('users'));
    }


    public function toggleBlock($id)
    {
        $user = User::findOrFail($id);
        $user->is_blocked = !$user->is_blocked; // Toggle true/false
        $user->save();

        return back()->with('success', 'User status updated.');
    }

    
    public function destroyUser($id)
    {
        User::destroy($id);
        return back()->with('success', 'User deleted successfully.');
    }
}