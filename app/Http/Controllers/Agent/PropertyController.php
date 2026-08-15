<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Concerns\ManagesPropertyImages;
use App\Http\Controllers\Controller;
use App\Http\Requests\PropertyRequest;
use App\Models\Property;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PropertyController extends Controller
{
    use ManagesPropertyImages;

    public function index(): View
    {
        $properties = Auth::user()->properties()->with('images')->latest()->paginate(10);

        return view('agent.properties.index', compact('properties'));
    }

    public function create(): View
    {
        return view('agent.properties.create');
    }

    public function store(PropertyRequest $request): RedirectResponse
    {
        $property = Auth::user()->properties()->create($request->safe()->except(['images']));

        if ($request->hasFile('images')) {
            $this->storeImages($property, $request->file('images'));
        }

        return redirect()->route('agent.properties.index')->with('status', 'Property listed successfully.');
    }

    public function edit(Property $property): View
    {
        $this->authorizeOwner($property);

        return view('agent.properties.edit', compact('property'));
    }

    public function update(PropertyRequest $request, Property $property): RedirectResponse
    {
        $this->authorizeOwner($property);

        $property->update($request->safe()->except(['images']));

        if ($request->hasFile('images')) {
            $this->storeImages($property, $request->file('images'));
        }

        return redirect()->route('agent.properties.index')->with('status', 'Property updated successfully.');
    }

    public function destroy(Property $property): RedirectResponse
    {
        $this->authorizeOwner($property);

        $property->delete();

        return back()->with('status', 'Property removed.');
    }

    public function destroyImage(Property $property, int $image): RedirectResponse
    {
        $this->authorizeOwner($property);

        $this->deleteImage($property, $image);

        return back()->with('status', 'Image removed.');
    }

    protected function authorizeOwner(Property $property): void
    {
        abort_unless($property->user_id === Auth::id(), 403);
    }
}
