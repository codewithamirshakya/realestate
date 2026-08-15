@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
    <div class="grid gap-8 lg:grid-cols-[220px_1fr]">
        @include('partials.dashboard-nav', ['role' => 'admin'])

        <div>
            <div class="flex flex-wrap items-center justify-between gap-3">
                <h1 class="font-serif text-2xl font-bold text-brand-900">All Properties</h1>
                <a href="{{ route('admin.properties.create') }}" class="btn-primary !px-4 !py-2 text-xs">+ Add Property</a>
            </div>

            <form method="GET" class="mt-4 flex flex-wrap gap-2">
                <a href="{{ route('admin.properties.index') }}" class="btn-outline !px-3 !py-1.5 text-xs {{ request('status') ? '' : '!bg-brand-600 !text-white' }}">All</a>
                @foreach (['available', 'pending', 'sold', 'rented'] as $status)
                    <a href="{{ route('admin.properties.index', ['status' => $status]) }}" class="btn-outline !px-3 !py-1.5 text-xs capitalize {{ request('status') === $status ? '!bg-brand-600 !text-white' : '' }}">{{ $status }}</a>
                @endforeach
            </form>

            <div class="mt-6 overflow-x-auto rounded-xl border border-brand-100">
                <table class="min-w-full divide-y divide-brand-100 text-sm">
                    <thead class="bg-brand-50 text-left text-xs uppercase tracking-wide text-brand-400">
                        <tr>
                            <th class="px-4 py-3">Property</th>
                            <th class="px-4 py-3">Agent</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Price</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-brand-50">
                        @forelse ($properties as $property)
                            <tr>
                                <td class="px-4 py-3 font-medium text-brand-800">{{ $property->title }}</td>
                                <td class="px-4 py-3 text-brand-500">{{ $property->user->name }}</td>
                                <td class="px-4 py-3 capitalize text-brand-500">{{ $property->status }}</td>
                                <td class="px-4 py-3 text-brand-500">{{ $property->formattedPrice() }}</td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('admin.properties.edit', $property) }}" class="font-semibold text-accent-500 hover:text-accent-600">Edit</a>
                                    <form method="POST" action="{{ route('admin.properties.destroy', $property) }}" class="inline" onsubmit="return confirm('Delete this property?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="ml-3 font-semibold text-red-500 hover:text-red-600">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-4 py-6 text-center text-brand-400">No properties found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">{{ $properties->links() }}</div>
        </div>
    </div>
</div>
@endsection
