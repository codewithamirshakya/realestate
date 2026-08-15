@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
    <div class="grid gap-8 lg:grid-cols-[220px_1fr]">
        @include('partials.dashboard-nav', ['role' => 'buyer'])

        <div>
            <h1 class="font-serif text-2xl font-bold text-brand-900">Welcome, {{ auth()->user()->name }}</h1>
            <p class="mt-1 text-brand-400">Track your saved properties and inquiries.</p>

            <h2 class="mt-8 text-lg font-semibold text-brand-800">Saved Properties</h2>
            <div class="mt-4 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($favorites as $property)
                    @include('partials.property-card', ['property' => $property])
                @empty
                    <p class="col-span-full py-6 text-brand-400">You haven't saved any properties yet. <a href="{{ route('properties.index') }}" class="font-semibold text-accent-500">Browse listings &rarr;</a></p>
                @endforelse
            </div>

            <h2 class="mt-10 text-lg font-semibold text-brand-800">My Inquiries</h2>
            <div class="mt-4 space-y-3">
                @forelse ($inquiries as $inquiry)
                    <div class="card p-4">
                        <p class="font-medium text-brand-800">{{ $inquiry->property?->title ?? 'General inquiry' }}</p>
                        <p class="mt-1 text-sm text-brand-500">{{ $inquiry->message }}</p>
                        <p class="mt-2 text-xs uppercase tracking-wide text-brand-300">Status: {{ $inquiry->status }}</p>
                    </div>
                @empty
                    <p class="text-brand-400">No inquiries sent yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
