@extends('layouts.app')

@section('content')
<div class="bg-brand-800 py-14 text-center text-white">
    <x-editable key="services.hero.title" as="h1" class="font-serif text-3xl font-bold sm:text-4xl" />
    <x-editable key="services.hero.subtitle" as="p" multiline class="mt-2 text-brand-200" />
</div>

<div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
    <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($services as $service)
            <div class="card p-7">
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-brand-600 text-white">
                    <x-service-icon :icon="$service->icon" class="h-6 w-6" />
                </div>
                <h2 class="mt-4 text-lg font-bold text-brand-800">{{ $service->title_en }}</h2>
                <p class="text-sm font-medium text-brand-400">{{ $service->title_np }}</p>
                <p class="mt-3 text-sm leading-relaxed text-brand-600">{{ $service->description_en }}</p>
                @if ($service->description_np)
                    <p class="mt-2 text-sm leading-relaxed text-brand-400">{{ $service->description_np }}</p>
                @endif
            </div>
        @endforeach
    </div>

    @if (app(\App\Support\Cms::class)->canEdit())
        <p class="mt-6 text-center text-xs text-brand-400">
            The service cards above come from <a href="{{ route('admin.services.index') }}" class="font-semibold text-accent-500 hover:text-accent-600">Services</a> in the admin panel.
        </p>
    @endif

    <div class="card mt-14 flex flex-col items-center gap-4 bg-accent-50/60 p-10 text-center">
        <x-editable key="services.cta.title" as="h2" class="font-serif text-2xl font-bold text-brand-800" />
        <x-editable key="services.cta.body" as="p" multiline class="max-w-xl text-brand-500" />
        <a href="{{ route('contact.create') }}" class="btn-primary">@cms('services.cta.button')</a>
    </div>
</div>
@endsection
