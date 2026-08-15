@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
    <div class="grid gap-8 lg:grid-cols-[220px_1fr]">
        @include('partials.dashboard-nav', ['role' => 'admin'])

        <div>
            <h1 class="font-serif text-2xl font-bold text-brand-900">Add Property</h1>

            <form method="POST" action="{{ route('admin.properties.store') }}" enctype="multipart/form-data" class="card mt-6 p-6">
                @csrf
                @include('properties._form', ['agents' => $agents])
                <button type="submit" class="btn-primary mt-6">Publish Property</button>
            </form>
        </div>
    </div>
</div>
@endsection
