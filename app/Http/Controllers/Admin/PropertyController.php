<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\ManagesPropertyImages;
use App\Http\Controllers\Controller;
use App\Http\Requests\PropertyRequest;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PropertyController extends Controller
{
    use ManagesPropertyImages;

    public function index(Request $request): View
    {
        $query = Property::with(['user', 'images'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        $properties = $query->paginate(15)->withQueryString();

        return view('admin.properties.index', compact('properties'));
    }

    public function create(): View
    {
        $agents = User::where('role', User::ROLE_AGENT)->orderBy('name')->get();

        return view('admin.properties.create', compact('agents'));
    }

    public function store(PropertyRequest $request): RedirectResponse
    {
        $data = $request->safe()->except(['images', 'user_id']);
        $data['user_id'] = $request->input('user_id') ?: $request->user()->id;

        $property = Property::create($data);

        if ($request->hasFile('images')) {
            $this->storeImages($property, $request->file('images'));
        }

        return redirect()->route('admin.properties.index')->with('status', 'Property created.');
    }

    public function edit(Property $property): View
    {
        // The current owner is always listed, even if they are an admin or no
        // longer an agent — otherwise the browser would pre-select the blank
        // option and the form would come back with no owner at all.
        $agents = User::query()
            ->where(fn ($query) => $query->where('role', User::ROLE_AGENT)->orWhere('id', $property->user_id))
            ->orderBy('name')
            ->get();

        return view('admin.properties.edit', compact('property', 'agents'));
    }

    public function update(PropertyRequest $request, Property $property): RedirectResponse
    {
        // `user_id` is dropped from the validated data on purpose: an empty
        // select submits an empty string, which arrives here as null and would
        // otherwise wipe the owner (properties.user_id is NOT NULL).
        $data = $request->safe()->except(['images', 'user_id']);

        if ($request->filled('user_id')) {
            $data['user_id'] = $request->integer('user_id');
        }

        $property->update($data);

        if ($request->hasFile('images')) {
            $this->storeImages($property, $request->file('images'));
        }

        return redirect()->route('admin.properties.index')->with('status', 'Property updated.');
    }

    public function destroy(Property $property): RedirectResponse
    {
        $property->delete();

        return back()->with('status', 'Property deleted.');
    }

    public function destroyImage(Property $property, int $image): RedirectResponse
    {
        $this->deleteImage($property, $image);

        return back()->with('status', 'Image removed.');
    }
}
