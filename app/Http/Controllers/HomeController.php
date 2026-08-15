<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Service;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $featured = Property::query()
            ->with(['images'])
            ->where('status', 'available')
            ->where('featured', true)
            ->latest()
            ->take(6)
            ->get();

        $latest = Property::query()
            ->with(['images'])
            ->where('status', 'available')
            ->latest()
            ->take(8)
            ->get();

        $services = Service::query()->orderBy('sort_order')->take(6)->get();

        $stats = [
            'properties' => Property::where('status', 'available')->count(),
            'sold' => Property::where('status', 'sold')->count(),
            'cities' => Property::distinct('city')->count('city'),
        ];

        return view('home', compact('featured', 'latest', 'services', 'stats'));
    }
}
