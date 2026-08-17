@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-md px-4 py-16 sm:px-6">
    <div class="text-center">
        <x-logo-mark class="mx-auto h-14 w-auto" />
        <h1 class="mt-4 font-serif text-2xl font-bold text-brand-900">Welcome back</h1>
        <p class="mt-1 text-brand-400">Log in to manage your properties and inquiries.</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="card mt-8 space-y-4 p-6">
        @csrf
        <div>
            <label class="form-label">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-input" required autofocus>
        </div>
        <div>
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-input" required>
        </div>
        <label class="flex items-center gap-2 text-sm text-brand-500">
            <input type="checkbox" name="remember" class="rounded border-brand-300 text-brand-600 focus:ring-brand-300">
            Remember me
        </label>
        <button type="submit" class="btn-primary w-full">Log in</button>
    </form>

    <p class="mt-6 text-center text-sm text-brand-400">
        Don't have an account? <a href="{{ route('register') }}" class="font-semibold text-accent-500 hover:text-accent-600">Sign up</a>
    </p>
</div>
@endsection
