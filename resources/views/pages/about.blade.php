@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
    <div class="grid items-center gap-12 lg:grid-cols-2">
        <div>
            <x-editable key="about.badge" as="span" class="badge bg-accent-50 text-accent-600" />
            <x-editable key="about.title" as="h1" class="mt-4 font-serif text-3xl font-bold text-brand-900 sm:text-4xl" />
            <x-editable key="about.subtitle" as="p" class="mt-1 text-lg text-brand-400" />

            <x-editable key="about.body_en" as="p" multiline class="mt-6 leading-relaxed text-brand-600" />
            <x-editable key="about.body_np" as="p" multiline class="mt-4 leading-relaxed text-brand-500" />

            <div class="mt-8 grid grid-cols-2 gap-6">
                <div>
                    <p class="text-3xl font-bold text-brand-700">{{ $stats['properties'] }}+</p>
                    <x-editable key="about.stats.properties_label" as="p" class="text-sm text-brand-400" />
                </div>
                <div>
                    <p class="text-3xl font-bold text-brand-700">{{ $stats['sold'] }}+</p>
                    <x-editable key="about.stats.sold_label" as="p" class="text-sm text-brand-400" />
                </div>
            </div>

            <a href="{{ route('contact.create') }}" class="btn-primary mt-8 inline-flex">@cms('about.cta_label')</a>
        </div>

        <div class="flex flex-col items-center gap-6">
            <x-editable-image key="about.image_primary" alt="{{ config('company.name_en') }}"
                              wrapper="w-full max-w-md"
                              class="w-full max-w-md rounded-xl border border-brand-100 shadow-md" />
            <x-editable-image key="about.image_secondary" alt="{{ config('company.name_en') }} services"
                              wrapper="w-full max-w-md"
                              class="w-full max-w-md rounded-xl border border-brand-100 shadow-md" />
        </div>
    </div>

    <div class="mt-16 grid gap-6 border-t border-brand-100 pt-12 sm:grid-cols-3">
        <div class="card p-6">
            <x-editable key="about.cards.office_title" as="h3" class="font-semibold text-brand-800" />
            <p class="mt-2 text-sm text-brand-500">{{ config('company.address_en') }}</p>
            <p class="text-sm text-brand-400">{{ config('company.address_np') }}</p>
        </div>
        <div class="card p-6">
            <x-editable key="about.cards.phone_title" as="h3" class="font-semibold text-brand-800" />
            <p class="mt-2 text-sm text-brand-500">{{ config('company.contact_person') }}</p>
            <p class="text-sm text-brand-500">{{ config('company.phone') }}</p>
        </div>
        <div class="card p-6">
            <x-editable key="about.cards.email_title" as="h3" class="font-semibold text-brand-800" />
            <p class="mt-2 text-sm text-brand-500">{{ config('company.email') }}</p>
        </div>
    </div>
</div>
@endsection
