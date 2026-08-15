<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PropertyController extends Controller
{
    public function index(Request $request): View
    {
        $query = Property::query()
            ->with(['images'])
            ->where('status', 'available')
            ->search($request->string('q')->toString());

        if ($request->filled('listing_type')) {
            $query->where('listing_type', $request->string('listing_type'));
        }

        if ($request->filled('category')) {
            $query->where('category', $request->string('category'));
        }

        if ($request->filled('city')) {
            $query->where('city', 'like', '%'.$request->string('city').'%');
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', (float) $request->input('min_price'));
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', (float) $request->input('max_price'));
        }

        if ($request->filled('bedrooms')) {
            $query->where('bedrooms', '>=', (int) $request->input('bedrooms'));
        }

        $sort = $request->string('sort', 'newest');
        match ((string) $sort) {
            'price_low' => $query->orderBy('price', 'asc'),
            'price_high' => $query->orderBy('price', 'desc'),
            default => $query->latest(),
        };

        $properties = $query->paginate(9)->withQueryString();

        $cities = Property::query()->where('status', 'available')->distinct()->orderBy('city')->pluck('city');

        return view('properties.index', compact('properties', 'cities'));
    }

    public function show(Property $property): View
    {
        $property->load(['images', 'user']);
        $property->increment('views_count');

        $related = Property::query()
            ->with('images')
            ->where('status', 'available')
            ->where('city', $property->city)
            ->where('id', '!=', $property->id)
            ->take(3)
            ->get();

        $isFavorited = auth()->check()
            ? $property->favoritedBy()->where('user_id', auth()->id())->exists()
            : false;

        return view('properties.show', compact('property', 'related', 'isFavorited'));
    }

    public function inquire(Request $request, Property $property): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $property->inquiries()->create([
            ...$validated,
            'user_id' => auth()->id(),
        ]);

        return back()->with('status', 'Thanks! Your inquiry has been sent to our team.');
    }
}
