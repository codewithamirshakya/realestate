@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">

    <nav class="mb-6 text-sm text-brand-400">
        <a href="{{ route('properties.index') }}" class="hover:text-accent-500">&larr; Back to properties</a>
    </nav>

    <div class="grid gap-10 lg:grid-cols-3">
        <div class="lg:col-span-2">
            {{-- Gallery --}}
            <div class="overflow-hidden rounded-xl border border-brand-100">
                @if ($property->images->isNotEmpty())
                    <div class="aspect-video w-full bg-brand-100">
                        <img src="{{ $property->primaryImage()->url() }}" alt="{{ $property->title }}" class="h-full w-full object-cover" id="mainImage">
                    </div>
                    @if ($property->images->count() > 1)
                        <div class="grid grid-cols-5 gap-1 bg-brand-50 p-1">
                            @foreach ($property->images as $img)
                                <button type="button" onclick="document.getElementById('mainImage').src='{{ $img->url() }}'" class="aspect-square overflow-hidden rounded">
                                    <img src="{{ $img->url() }}" class="h-full w-full object-cover" alt="">
                                </button>
                            @endforeach
                        </div>
                    @endif
                @else
                    <div class="flex aspect-video w-full items-center justify-center bg-gradient-to-br from-brand-200 to-brand-500">
                        <x-logo-mark class="h-16 w-auto opacity-50" alt="" />
                    </div>
                @endif
            </div>

            <div class="mt-8 flex flex-wrap items-start justify-between gap-4">
                <div>
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="badge bg-accent-400 text-white capitalize">{{ $property->status }}</span>
                        <span class="badge bg-brand-100 text-brand-700 capitalize">For {{ $property->listing_type }}</span>
                        <span class="badge bg-brand-100 text-brand-700 capitalize">{{ $property->category }}</span>
                    </div>
                    <h1 class="mt-3 font-serif text-2xl font-bold text-brand-900 sm:text-3xl">{{ $property->title }}</h1>
                    <p class="mt-1 text-brand-400">{{ $property->address }}, {{ $property->city }}</p>
                </div>

                @auth
                    <form method="POST" action="{{ route('favorites.toggle', $property) }}">
                        @csrf
                        <button type="submit" class="btn-outline">
                            {{ $isFavorited ? '♥ Saved' : '♡ Save' }}
                        </button>
                    </form>
                @endauth
            </div>

            <div class="mt-6 grid grid-cols-2 gap-4 rounded-xl border border-brand-100 p-5 sm:grid-cols-4">
                <div>
                    <p class="text-xs uppercase tracking-wide text-brand-300">Price</p>
                    <p class="mt-1 font-semibold text-brand-800">{{ $property->formattedPrice() }}</p>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-wide text-brand-300">Bedrooms</p>
                    <p class="mt-1 font-semibold text-brand-800">{{ $property->bedrooms ?? '&mdash;' }}</p>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-wide text-brand-300">Bathrooms</p>
                    <p class="mt-1 font-semibold text-brand-800">{{ $property->bathrooms ?? '&mdash;' }}</p>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-wide text-brand-300">Area</p>
                    <p class="mt-1 font-semibold text-brand-800">{{ $property->area_sqft ? number_format($property->area_sqft).' sqft' : '&mdash;' }}</p>
                </div>
            </div>

            <div class="mt-8">
                <h2 class="font-serif text-xl font-bold text-brand-800">Description</h2>
                <p class="mt-3 whitespace-pre-line text-brand-600">{{ $property->description }}</p>
            </div>

            @if ($related->isNotEmpty())
                <div class="mt-12">
                    <h2 class="font-serif text-xl font-bold text-brand-800">More in {{ $property->city }}</h2>
                    <div class="mt-5 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($related as $rp)
                            @include('partials.property-card', ['property' => $rp])
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        {{-- Sidebar: agent + inquiry form --}}
        <div class="space-y-6">
            <div class="card p-5">
                <p class="text-xs uppercase tracking-wide text-brand-300">Listed by</p>
                <p class="mt-1 font-semibold text-brand-800">{{ $property->user->name }}</p>
                @if ($property->user->phone)
                    <p class="text-sm text-brand-500">{{ $property->user->phone }}</p>
                @endif
                <p class="text-sm text-brand-500">{{ $property->user->email }}</p>
            </div>

            <div class="card p-5">
                <h3 class="font-semibold text-brand-800">Interested in this property?</h3>
                <p class="mt-1 text-sm text-brand-400">Send an inquiry and our team will contact you shortly.</p>

                <form method="POST" action="{{ route('properties.inquire', $property) }}" class="mt-4 space-y-3">
                    @csrf
                    <div>
                        <label class="form-label">Name</label>
                        <input type="text" name="name" value="{{ old('name', auth()->user()->name ?? '') }}" class="form-input" required>
                    </div>
                    <div>
                        <label class="form-label">Email</label>
                        <input type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" class="form-input" required>
                    </div>
                    <div>
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Message</label>
                        <textarea name="message" rows="4" class="form-textarea" required>{{ old('message', "Hi, I'm interested in \"{$property->title}\". Please share more details.") }}</textarea>
                    </div>
                    <button type="submit" class="btn-primary w-full">Send Inquiry</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
