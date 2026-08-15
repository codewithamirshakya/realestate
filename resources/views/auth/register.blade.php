@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-md px-4 py-16 sm:px-6">
    <div class="text-center">
        <x-logo-mark class="mx-auto h-14 w-14" />
        <h1 class="mt-4 font-serif text-2xl font-bold text-brand-900">Create your account</h1>
        <p class="mt-1 text-brand-400">Join {{ config('company.name_en') }} to buy, rent, or list property.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="card mt-8 space-y-4 p-6">
        @csrf
        <div>
            <label class="form-label">Full name</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-input" required autofocus>
        </div>
        <div>
            <label class="form-label">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-input" required>
        </div>
        <div>
            <label class="form-label">Phone (optional)</label>
            <input type="text" name="phone" value="{{ old('phone') }}" class="form-input">
        </div>
        <div>
            <label class="form-label">I want to</label>
            <div class="grid grid-cols-2 gap-3">
                <label class="flex cursor-pointer items-center justify-center rounded-lg border border-brand-200 px-3 py-3 text-sm font-medium has-[:checked]:border-brand-600 has-[:checked]:bg-brand-50">
                    <input type="radio" name="role" value="buyer" class="sr-only" {{ old('role', 'buyer') === 'buyer' ? 'checked' : '' }}>
                    Buy / Rent property
                </label>
                <label class="flex cursor-pointer items-center justify-center rounded-lg border border-brand-200 px-3 py-3 text-sm font-medium has-[:checked]:border-brand-600 has-[:checked]:bg-brand-50">
                    <input type="radio" name="role" value="agent" class="sr-only" {{ old('role') === 'agent' ? 'checked' : '' }}>
                    List my property
                </label>
            </div>
        </div>
        <div>
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-input" required>
        </div>
        <div>
            <label class="form-label">Confirm password</label>
            <input type="password" name="password_confirmation" class="form-input" required>
        </div>
        <button type="submit" class="btn-primary w-full">Create account</button>
    </form>

    <p class="mt-6 text-center text-sm text-brand-400">
        Already have an account? <a href="{{ route('login') }}" class="font-semibold text-accent-500 hover:text-accent-600">Log in</a>
    </p>
</div>
@endsection
