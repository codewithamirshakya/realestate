<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\View\View;

class PageController extends Controller
{
    public function about(): View
    {
        $stats = [
            'properties' => Property::count(),
            'sold' => Property::where('status', 'sold')->count(),
        ];

        return view('pages.about', compact('stats'));
    }
}
