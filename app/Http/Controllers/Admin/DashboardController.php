<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\Property;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'properties' => Property::count(),
            'available' => Property::where('status', 'available')->count(),
            'sold_or_rented' => Property::whereIn('status', ['sold', 'rented'])->count(),
            'agents' => User::where('role', 'agent')->count(),
            'buyers' => User::where('role', 'buyer')->count(),
            'inquiries' => Inquiry::count(),
            'new_inquiries' => Inquiry::where('status', 'new')->count(),
        ];

        $recentProperties = Property::with('user')->latest()->take(5)->get();
        $recentInquiries = Inquiry::with('property')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentProperties', 'recentInquiries'));
    }
}
