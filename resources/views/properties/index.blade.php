@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">

    <div class="mb-8">
        <h1 class="font-serif text-3xl font-bold text-brand-800">Properties</h1>
        <p class="mt-1 text-brand-400">{{ $properties->total() }} listings found</p>
    </div>

    <form action="{{ route('properties.index') }}" method="GET" class="card mb-8 grid gap-4 p-5 sm:grid-cols-2 lg:grid-cols-6">
        <div class="sm:col-span-2 lg:col-span-2">
            <label class="form-label">Keyword</label>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Title, address, city..." class="form-input">
        </div>
        <div>
            <label class="form-label">Type</label>
            <select name="listing_type" class="form-select">
                <option value="">Any</option>
                <option value="sale" @selected(request('listing_type') === 'sale')>For Sale</option>
                <option value="rent" @selected(request('listing_type') === 'rent')>For Rent</option>
            </select>
        </div>
        <div>
            <label class="form-label">Category</label>
            <select name="category" class="form-select">
                <option value="">Any</option>
                <option value="house" @selected(request('category') === 'house')>House</option>
                <option value="apartment" @selected(request('category') === 'apartment')>Apartment</option>
                <option value="land" @selected(request('category') === 'land')>Land</option>
                <option value="commercial" @selected(request('category') === 'commercial')>Commercial</option>
            </select>
        </div>
        <div>
            <label class="form-label">City</label>
            <input list="cities" type="text" name="city" value="{{ request('city') }}" class="form-input" placeholder="Any city">
            <datalist id="cities">
                @foreach ($cities as $city)
                    <option value="{{ $city }}">
                @endforeach
            </datalist>
        </div>
        <div>
            <label class="form-label">Min bedrooms</label>
            <input type="number" min="0" name="bedrooms" value="{{ request('bedrooms') }}" class="form-input">
        </div>
        <div>
            <label class="form-label">Min price (Rs.)</label>
            <input type="number" min="0" name="min_price" value="{{ request('min_price') }}" class="form-input">
        </div>
        <div>
            <label class="form-label">Max price (Rs.)</label>
            <input type="number" min="0" name="max_price" value="{{ request('max_price') }}" class="form-input">
        </div>
        <div>
            <label class="form-label">Sort by</label>
            <select name="sort" class="form-select">
                <option value="newest" @selected(request('sort', 'newest') === 'newest')>Newest</option>
                <option value="price_low" @selected(request('sort') === 'price_low')>Price: Low to High</option>
                <option value="price_high" @selected(request('sort') === 'price_high')>Price: High to Low</option>
            </select>
        </div>
        <div class="flex items-end gap-2 lg:col-span-2">
            <button type="submit" class="btn-primary flex-1">Filter</button>
            <a href="{{ route('properties.index') }}" class="btn-outline flex-1 text-center">Reset</a>
        </div>
    </form>

    @if ($properties->isEmpty())
        <div class="card p-12 text-center text-brand-400">
            <p class="text-lg font-semibold text-brand-600">No properties match your search</p>
            <p class="mt-1 text-sm">Try adjusting your filters or check back soon &mdash; new listings are added regularly.</p>
        </div>
    @else
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($properties as $property)
                @include('partials.property-card', ['property' => $property])
            @endforeach
        </div>

        <div class="mt-10">
            {{ $properties->links() }}
        </div>
    @endif
</div>
@endsection
