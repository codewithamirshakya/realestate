@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
    <div class="grid gap-8 lg:grid-cols-[220px_1fr]">
        @include('partials.dashboard-nav', ['role' => 'admin'])

        <div>
            <div class="flex flex-wrap items-end justify-between gap-3">
                <div>
                    <h1 class="font-serif text-2xl font-bold text-brand-900">Admin Dashboard</h1>
                    <p class="mt-1 text-brand-400">Overview of {{ config('company.name_en') }}</p>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.content.index') }}" class="btn-outline !px-4 !py-2 text-xs">Site content</a>
                    <form method="POST" action="{{ route('admin.content.edit-mode') }}">
                        @csrf
                        <button type="submit" class="btn-primary !px-4 !py-2 text-xs">
                            {{ session(\App\Support\Cms::SESSION_KEY) ? 'Turn off inline editing' : 'Edit site inline' }}
                        </button>
                    </form>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-2 gap-4 sm:grid-cols-4">
                <div class="card p-5">
                    <p class="text-2xl font-bold text-brand-700">{{ $stats['properties'] }}</p>
                    <p class="text-sm text-brand-400">Properties</p>
                </div>
                <div class="card p-5">
                    <p class="text-2xl font-bold text-accent-500">{{ $stats['available'] }}</p>
                    <p class="text-sm text-brand-400">Available</p>
                </div>
                <div class="card p-5">
                    <p class="text-2xl font-bold text-brand-700">{{ $stats['agents'] }}</p>
                    <p class="text-sm text-brand-400">Agents</p>
                </div>
                <div class="card p-5">
                    <p class="text-2xl font-bold text-brand-700">{{ $stats['buyers'] }}</p>
                    <p class="text-sm text-brand-400">Buyers</p>
                </div>
                <div class="card p-5 sm:col-span-2">
                    <p class="text-2xl font-bold text-brand-700">{{ $stats['sold_or_rented'] }}</p>
                    <p class="text-sm text-brand-400">Sold / Rented</p>
                </div>
                <div class="card p-5 sm:col-span-2">
                    <p class="text-2xl font-bold text-red-500">{{ $stats['new_inquiries'] }}</p>
                    <p class="text-sm text-brand-400">New inquiries ({{ $stats['inquiries'] }} total)</p>
                </div>
            </div>

            <div class="mt-10 grid gap-8 lg:grid-cols-2">
                <div>
                    <h2 class="text-lg font-semibold text-brand-800">Recent Properties</h2>
                    <div class="mt-3 space-y-3">
                        @forelse ($recentProperties as $property)
                            <div class="card flex items-center justify-between p-4">
                                <div>
                                    <p class="font-medium text-brand-800">{{ $property->title }}</p>
                                    <p class="text-xs text-brand-400">by {{ $property->user->name }}</p>
                                </div>
                                <a href="{{ route('admin.properties.edit', $property) }}" class="text-sm font-semibold text-accent-500 hover:text-accent-600">Manage</a>
                            </div>
                        @empty
                            <p class="text-brand-400">No properties yet.</p>
                        @endforelse
                    </div>
                </div>

                <div>
                    <h2 class="text-lg font-semibold text-brand-800">Recent Inquiries</h2>
                    <div class="mt-3 space-y-3">
                        @forelse ($recentInquiries as $inquiry)
                            <div class="card p-4">
                                <p class="font-medium text-brand-800">{{ $inquiry->name }} &middot; {{ $inquiry->email }}</p>
                                <p class="text-xs text-brand-400">{{ $inquiry->property?->title ?? 'General inquiry' }}</p>
                                <p class="mt-1 line-clamp-2 text-sm text-brand-500">{{ $inquiry->message }}</p>
                            </div>
                        @empty
                            <p class="text-brand-400">No inquiries yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
