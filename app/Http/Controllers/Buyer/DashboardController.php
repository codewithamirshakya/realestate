<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        $favorites = $user->favorites()->with('property.images')->latest()->get()
            ->pluck('property')
            ->filter();

        $inquiries = $user->inquiries()->with('property')->latest()->get();

        return view('buyer.dashboard', compact('favorites', 'inquiries'));
    }
}
