<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // 1. Show the admin login form
    public function showLogin()
    {
        // If already logged in as admin, go straight to dashboard
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect('/admin/dashboard');
        }

        return view('admin.login');
    }

    // 2. Process login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            // Check if role is admin
            if (Auth::user()->role !== 'admin') {
                Auth::logout();
                return back()->withErrors(['email' => 'Access denied: Admin only!']);
            }

            $request->session()->regenerate();
            return redirect('/admin/dashboard');
        }

        return back()->withErrors(['email' => 'Wrong email or password.']);
    }

    // 3. Admin Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login')->with('status', 'Logged out successfully!');
    }

    // 4. Admin Dashboard Page
    public function dashboard()
    {
        // Simple counts from MongoDB
        $totalProperties = Property::count();
        $pendingProperties = Property::where('status', 'pending')->count();
        $totalBookings = Booking::count();
        $totalUsers = User::count();
        $totalRevenue = Booking::where('status', 'confirmed')->sum('total_price');

        // Recent 5 records
        $recentBookings = Booking::with('property')->latest()->take(5)->get();
        $recentProperties = Property::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalProperties',
            'pendingProperties',
            'totalBookings',
            'totalUsers',
            'totalRevenue',
            'recentBookings',
            'recentProperties'
        ));
    }

    // 5. Properties moderation page
    public function properties(Request $request)
    {
        $status = $request->status;

        $query = Property::latest();

        if ($status) {
            $query->where('status', $status);
        }

        $properties = $query->get();

        return view('admin.properties', compact('properties', 'status'));
    }

    // 6. Update property status (Approve or Suspend)
    public function updatePropertyStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
        ]);

        $property = Property::findOrFail($id);
        $property->status = $request->status;
        $property->save();

        return back()->with('success', "Property status changed to {$request->status}!");
    }
}
