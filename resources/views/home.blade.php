@extends('layouts.app')

@php
    $cms = app(\App\Support\Cms::class);
    $heroImage = $cms->imageUrl('home.hero.image');
@endphp

@section('content')

    {{-- Hero --}}
    <section class="relative overflow-hidden bg-brand-800"
             @if ($heroImage) style="background-image: url('{{ $heroImage }}'); background-size: cover; background-position: center;" @endif>
        @if ($heroImage)
            <div class="absolute inset-0 bg-brand-900/70"></div>
        @else
            <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(circle at 20% 20%, white 1px, transparent 1px); background-size: 22px 22px;"></div>
        @endif
        <div class="relative mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8 lg:py-28">
            @if ($cms->editing())
                <div class="relative mb-6 flex h-12 justify-end" data-cms-image-target>
                    <button type="button" class="cms-image-button !static" data-cms-image="home.hero.image" data-cms-label="Hero background image">
                        Change hero background
                    </button>
                </div>
            @endif

            <div class="max-w-2xl">
                <x-editable key="home.hero.badge" as="span" class="badge bg-accent-400/20 text-accent-200" />
                <x-editable key="home.hero.title" as="h1" multiline
                            class="mt-4 font-serif text-4xl font-bold leading-tight text-white sm:text-5xl" />
                <x-editable key="home.hero.subtitle" as="p" multiline class="mt-4 text-lg text-brand-200" />
                <x-editable key="home.hero.subtitle_np" as="p" multiline class="mt-1 text-base text-brand-300" />

                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('properties.index') }}" class="btn-accent">@cms('home.hero.cta_primary')</a>
                    <a href="{{ route('register') }}" class="btn-outline-white">@cms('home.hero.cta_secondary')</a>
                </div>
            </div>

            {{-- Search box --}}
            <form action="{{ route('properties.index') }}" method="GET" class="card mt-10 grid gap-3 bg-white/95 p-4 sm:grid-cols-4 sm:p-5">
                <div class="sm:col-span-2">
                    <label class="form-label">@cms('home.search.keyword_label')</label>
                    <input type="text" name="q" placeholder="@cms('home.search.keyword_placeholder')" class="form-input">
                </div>
                <div>
                    <label class="form-label">@cms('home.search.type_label')</label>
                    <select name="listing_type" class="form-select">
                        <option value="">Any</option>
                        <option value="sale">For Sale</option>
                        <option value="rent">For Rent</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="btn-primary w-full">@cms('home.search.button')</button>
                </div>
            </form>
        </div>
    </section>

    {{-- Stats --}}
    <section class="border-b border-brand-100">
        <div class="mx-auto grid max-w-7xl grid-cols-3 gap-4 px-4 py-8 text-center sm:px-6 lg:px-8">
            <div>
                <p class="text-3xl font-bold text-brand-700">{{ $stats['properties'] }}+</p>
                <x-editable key="home.stats.properties_label" as="p" class="text-sm text-brand-400" />
            </div>
            <div>
                <p class="text-3xl font-bold text-brand-700">{{ $stats['sold'] }}+</p>
                <x-editable key="home.stats.sold_label" as="p" class="text-sm text-brand-400" />
            </div>
            <div>
                <p class="text-3xl font-bold text-brand-700">{{ $stats['cities'] }}+</p>
                <x-editable key="home.stats.cities_label" as="p" class="text-sm text-brand-400" />
            </div>
        </div>
    </section>

    {{-- Featured properties --}}
    @if ($featured->isNotEmpty())
        <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between">
                <div>
                    <x-editable key="home.featured.title" as="h2" class="font-serif text-2xl font-bold text-brand-800 sm:text-3xl" />
                    <x-editable key="home.featured.subtitle" as="p" class="mt-1 text-brand-400" />
                </div>
                <a href="{{ route('properties.index') }}" class="hidden text-sm font-semibold text-accent-500 hover:text-accent-600 sm:block">View all &rarr;</a>
            </div>
            <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($featured as $property)
                    @include('partials.property-card', ['property' => $property])
                @endforeach
            </div>
        </section>
    @endif

    {{-- Services preview --}}
    <section class="bg-accent-50/60">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <div class="text-center">
                <x-editable key="home.services.title" as="h2" class="font-serif text-2xl font-bold text-brand-800 sm:text-3xl" />
                <x-editable key="home.services.subtitle" as="p" class="mt-2 text-brand-400" />
            </div>
            <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($services as $service)
                    <div class="card p-6">
                        <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-brand-600 text-white">
                            <x-service-icon :icon="$service->icon" class="h-5 w-5" />
                        </div>
                        <h3 class="mt-4 font-semibold text-brand-800">{{ $service->title_en }}</h3>
                        <p class="text-sm text-brand-400">{{ $service->title_np }}</p>
                        <p class="mt-2 text-sm text-brand-500">{{ Str::limit($service->description_en, 90) }}</p>
                    </div>
                @endforeach
            </div>
            <div class="mt-8 text-center">
                <a href="{{ route('services.index') }}" class="btn-primary">@cms('home.services.cta')</a>
            </div>
        </div>
    </section>

    {{-- Latest properties --}}
    @if ($latest->isNotEmpty())
        <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <x-editable key="home.latest.title" as="h2" class="font-serif text-2xl font-bold text-brand-800 sm:text-3xl" />
            <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($latest as $property)
                    @include('partials.property-card', ['property' => $property])
                @endforeach
            </div>
        </section>
    @endif

    {{-- CTA --}}
    <section class="bg-brand-700">
        <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-4 px-4 py-12 text-center sm:px-6 md:flex-row md:text-left lg:px-8">
            <div>
                <x-editable key="home.cta.title" as="h2" class="font-serif text-2xl font-bold text-white" />
                <x-editable key="home.cta.body" as="p" multiline class="mt-1 text-brand-200" />
            </div>
            <a href="{{ route('register') }}" class="btn-accent shrink-0">@cms('home.cta.button')</a>
        </div>
    </section>

@endsection
