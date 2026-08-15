@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
    <div class="grid gap-8 lg:grid-cols-[220px_1fr]">
        @include('partials.dashboard-nav', ['role' => 'admin'])

        <div>
            <h1 class="font-serif text-2xl font-bold text-brand-900">Edit Property</h1>

            <form method="POST" action="{{ route('admin.properties.update', $property) }}" enctype="multipart/form-data" class="card mt-6 p-6">
                @csrf @method('PUT')
                @include('properties._form', ['property' => $property, 'agents' => $agents])
                <button type="submit" class="btn-primary mt-6">Save Changes</button>
            </form>

            @foreach ($property->images as $image)
                <form id="delete-image-{{ $image->id }}" method="POST" action="{{ route('admin.properties.images.destroy', [$property, $image]) }}" class="hidden">
                    @csrf @method('DELETE')
                </form>
            @endforeach
        </div>
    </div>
</div>
@endsection
