@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
    <div class="grid gap-8 lg:grid-cols-[220px_1fr]">
        @include('partials.dashboard-nav', ['role' => 'agent'])

        <div>
            <div class="flex items-center justify-between">
                <h1 class="font-serif text-2xl font-bold text-brand-900">My Properties</h1>
                <a href="{{ route('agent.properties.create') }}" class="btn-primary !px-4 !py-2 text-xs">+ Add Property</a>
            </div>

            <div class="mt-6 grid gap-6 sm:grid-cols-2">
                @forelse ($properties as $property)
                    <div class="card overflow-hidden">
                        @include('partials.property-card', ['property' => $property])
                        <div class="flex gap-2 border-t border-brand-50 p-3">
                            <a href="{{ route('agent.properties.edit', $property) }}" class="btn-outline flex-1 !py-1.5 text-xs">Edit</a>
                            <form method="POST" action="{{ route('agent.properties.destroy', $property) }}" class="flex-1" onsubmit="return confirm('Delete this property?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-outline w-full !border-red-300 !py-1.5 text-xs !text-red-600 hover:!bg-red-50">Delete</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="col-span-2 py-10 text-center text-brand-400">You haven't listed any properties yet.</p>
                @endforelse
            </div>

            <div class="mt-8">{{ $properties->links() }}</div>
        </div>
    </div>
</div>
@endsection
