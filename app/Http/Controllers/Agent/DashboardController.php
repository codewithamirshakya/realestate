<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $agent = Auth::user();

        $properties = $agent->properties()->latest()->get();

        $stats = [
            'total' => $properties->count(),
            'available' => $properties->where('status', 'available')->count(),
            'sold_or_rented' => $properties->whereIn('status', ['sold', 'rented'])->count(),
            'inquiries' => \App\Models\Inquiry::whereIn('property_id', $properties->pluck('id'))->count(),
        ];

        return view('agent.dashboard', compact('properties', 'stats'));
    }
}
