@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
    <div class="grid gap-8 lg:grid-cols-[220px_1fr]">
        @include('partials.dashboard-nav', ['role' => 'agent'])

        <div>
            <h1 class="font-serif text-2xl font-bold text-brand-900">Welcome back, {{ auth()->user()->name }}</h1>
            <p class="mt-1 text-brand-400">Here's an overview of your listings.</p>

            <div class="mt-6 grid grid-cols-2 gap-4 sm:grid-cols-4">
                <div class="card p-5">
                    <p class="text-2xl font-bold text-brand-700">{{ $stats['total'] }}</p>
                    <p class="text-sm text-brand-400">Total listings</p>
                </div>
                <div class="card p-5">
                    <p class="text-2xl font-bold text-accent-500">{{ $stats['available'] }}</p>
                    <p class="text-sm text-brand-400">Available</p>
                </div>
                <div class="card p-5">
                    <p class="text-2xl font-bold text-brand-700">{{ $stats['sold_or_rented'] }}</p>
                    <p class="text-sm text-brand-400">Sold / Rented</p>
                </div>
                <div class="card p-5">
                    <p class="text-2xl font-bold text-brand-700">{{ $stats['inquiries'] }}</p>
                    <p class="text-sm text-brand-400">Inquiries received</p>
                </div>
            </div>

            <div class="mt-8 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-brand-800">Recent listings</h2>
                <a href="{{ route('agent.properties.create') }}" class="btn-primary !px-4 !py-2 text-xs">+ Add Property</a>
            </div>

            <div class="mt-4 overflow-x-auto rounded-xl border border-brand-100">
                <table class="min-w-full divide-y divide-brand-100 text-sm">
                    <thead class="bg-brand-50 text-left text-xs uppercase tracking-wide text-brand-400">
                        <tr>
                            <th class="px-4 py-3">Property</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Price</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-brand-50">
                        @forelse ($properties->take(8) as $property)
                            <tr>
                                <td class="px-4 py-3 font-medium text-brand-800">{{ $property->title }}</td>
                                <td class="px-4 py-3 capitalize text-brand-500">{{ $property->status }}</td>
                                <td class="px-4 py-3 text-brand-500">{{ $property->formattedPrice() }}</td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('agent.properties.edit', $property) }}" class="font-semibold text-accent-500 hover:text-accent-600">Edit</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-4 py-6 text-center text-brand-400">No properties yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
