<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function toggle(Request $request, Property $property): RedirectResponse
    {
        $user = $request->user();

        $favorite = $user->favorites()->where('property_id', $property->id)->first();

        if ($favorite) {
            $favorite->delete();
            $status = 'Removed from your saved properties.';
        } else {
            $user->favorites()->create(['property_id' => $property->id]);
            $status = 'Saved to your favorites.';
        }

        return back()->with('status', $status);
    }
}
