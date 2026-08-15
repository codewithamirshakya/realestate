@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-5xl px-4 py-14 sm:px-6 lg:px-8">
    <div class="text-center">
        <x-editable key="contact.title" as="h1" class="font-serif text-3xl font-bold text-brand-900" />
        <x-editable key="contact.subtitle" as="p" multiline class="mt-2 text-brand-400" />
    </div>

    <div class="mt-10 grid gap-10 lg:grid-cols-5">
        <div class="card space-y-5 p-6 lg:col-span-2">
            <div>
                <p class="text-xs uppercase tracking-wide text-brand-300">Office</p>
                <p class="mt-1 font-medium text-brand-700">{{ config('company.address_en') }}</p>
                <p class="text-sm text-brand-400">{{ config('company.address_np') }}</p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-wide text-brand-300">Phone</p>
                <a href="tel:{{ config('company.phone') }}" class="mt-1 block font-medium text-brand-700 hover:text-accent-500">{{ config('company.phone') }}</a>
            </div>
            <div>
                <p class="text-xs uppercase tracking-wide text-brand-300">Email</p>
                <a href="mailto:{{ config('company.email') }}" class="mt-1 block font-medium text-brand-700 hover:text-accent-500">{{ config('company.email') }}</a>
            </div>
            <div>
                <p class="text-xs uppercase tracking-wide text-brand-300">Contact person</p>
                <p class="mt-1 font-medium text-brand-700">{{ config('company.contact_person') }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('contact.store') }}" class="card space-y-4 p-6 lg:col-span-3">
            @csrf
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="form-label">Name</label>
                    <input type="text" name="name" value="{{ old('name', auth()->user()->name ?? '') }}" class="form-input" required>
                </div>
                <div>
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" class="form-input" required>
                </div>
            </div>
            <div>
                <label class="form-label">Phone (optional)</label>
                <input type="text" name="phone" value="{{ old('phone') }}" class="form-input">
            </div>
            <div>
                <label class="form-label">Message</label>
                <textarea name="message" rows="5" class="form-textarea" required>{{ old('message') }}</textarea>
            </div>
            <button type="submit" class="btn-primary w-full sm:w-auto">@cms('contact.form_button')</button>
        </form>
    </div>
</div>
@endsection
