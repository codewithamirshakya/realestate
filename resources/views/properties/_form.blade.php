@php
    $p = $property ?? null;
@endphp

<div class="grid gap-4 sm:grid-cols-2">
    <div class="sm:col-span-2">
        <label class="form-label">Title</label>
        <input type="text" name="title" value="{{ old('title', $p?->title) }}" class="form-input" required>
    </div>

    @if (isset($agents))
        <div class="sm:col-span-2">
            <label class="form-label">Assign to agent</label>
            <select name="user_id" class="form-select">
                <option value="">{{ auth()->user()->name }} (me)</option>
                @foreach ($agents as $agent)
                    <option value="{{ $agent->id }}" @selected(old('user_id', $p?->user_id) == $agent->id)>{{ $agent->name }}</option>
                @endforeach
            </select>
        </div>
    @endif

    <div class="sm:col-span-2">
        <label class="form-label">Description</label>
        <textarea name="description" rows="5" class="form-textarea" required>{{ old('description', $p?->description) }}</textarea>
    </div>

    <div>
        <label class="form-label">Listing type</label>
        <select name="listing_type" class="form-select" required>
            <option value="sale" @selected(old('listing_type', $p?->listing_type) === 'sale')>For Sale</option>
            <option value="rent" @selected(old('listing_type', $p?->listing_type) === 'rent')>For Rent</option>
        </select>
    </div>

    <div>
        <label class="form-label">Category</label>
        <select name="category" class="form-select" required>
            @foreach (['house' => 'House', 'apartment' => 'Apartment', 'land' => 'Land', 'commercial' => 'Commercial'] as $value => $label)
                <option value="{{ $value }}" @selected(old('category', $p?->category) === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="form-label">Status</label>
        <select name="status" class="form-select" required>
            @foreach (['available' => 'Available', 'pending' => 'Pending', 'sold' => 'Sold', 'rented' => 'Rented'] as $value => $label)
                <option value="{{ $value }}" @selected(old('status', $p?->status ?? 'available') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="form-label">Price (Rs.)</label>
        <input type="number" step="0.01" min="0" name="price" value="{{ old('price', $p?->price) }}" class="form-input" required>
    </div>

    <div>
        <label class="form-label">Area (sqft)</label>
        <input type="number" step="0.01" min="0" name="area_sqft" value="{{ old('area_sqft', $p?->area_sqft) }}" class="form-input">
    </div>

    <div>
        <label class="form-label">Bedrooms</label>
        <input type="number" min="0" name="bedrooms" value="{{ old('bedrooms', $p?->bedrooms) }}" class="form-input">
    </div>

    <div>
        <label class="form-label">Bathrooms</label>
        <input type="number" min="0" name="bathrooms" value="{{ old('bathrooms', $p?->bathrooms) }}" class="form-input">
    </div>

    <div>
        <label class="form-label">Parking</label>
        <input type="number" min="0" name="parking" value="{{ old('parking', $p?->parking) }}" class="form-input">
    </div>

    <div class="sm:col-span-2">
        <label class="form-label">Address</label>
        <input type="text" name="address" value="{{ old('address', $p?->address) }}" class="form-input" required>
    </div>

    <div>
        <label class="form-label">City</label>
        <input type="text" name="city" value="{{ old('city', $p?->city) }}" class="form-input" required>
    </div>

    <div class="flex items-end pb-2.5">
        <label class="flex items-center gap-2 text-sm font-medium text-brand-600">
            <input type="checkbox" name="featured" value="1" class="rounded border-brand-300 text-brand-600 focus:ring-brand-300" @checked(old('featured', $p?->featured))>
            Feature this listing on the homepage
        </label>
    </div>

    <div class="sm:col-span-2">
        <label class="form-label">Photos {{ $p ? '(add more)' : '(up to 8)' }}</label>
        <input type="file" name="images[]" multiple accept="image/*" class="form-input">
    </div>

    @if ($p && $p->images->isNotEmpty())
        <div class="sm:col-span-2">
            <p class="form-label">Current photos</p>
            <div class="grid grid-cols-4 gap-3 sm:grid-cols-6">
                @foreach ($p->images as $image)
                    <div class="group relative aspect-square overflow-hidden rounded-lg border border-brand-100">
                        <img src="{{ $image->url() }}" class="h-full w-full object-cover" alt="">
                        <button type="submit" form="delete-image-{{ $image->id }}"
                                class="absolute right-1 top-1 hidden rounded-full bg-red-600 px-1.5 py-0.5 text-xs text-white group-hover:block">
                            &times;
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
