<header class="sticky top-0 z-40 border-b border-brand-100 bg-white/95 backdrop-blur">
    <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-8">
        <a href="{{ route('home') }}" class="shrink-0">
            <x-logo />
        </a>

        <nav class="hidden items-center gap-7 text-sm font-semibold text-brand-700 md:flex">
            <a href="{{ route('home') }}" class="hover:text-accent-500 {{ request()->routeIs('home') ? 'text-accent-500' : '' }}">Home</a>
            <a href="{{ route('properties.index') }}" class="hover:text-accent-500 {{ request()->routeIs('properties.*') ? 'text-accent-500' : '' }}">Properties</a>
            <a href="{{ route('services.index') }}" class="hover:text-accent-500 {{ request()->routeIs('services.*') ? 'text-accent-500' : '' }}">Services</a>
            <a href="{{ route('pages.about') }}" class="hover:text-accent-500 {{ request()->routeIs('pages.about') ? 'text-accent-500' : '' }}">About</a>
            <a href="{{ route('contact.create') }}" class="hover:text-accent-500 {{ request()->routeIs('contact.*') ? 'text-accent-500' : '' }}">Contact</a>
        </nav>

        <div class="flex items-center gap-3">
            @auth
                @php($user = auth()->user())
                <a href="{{ $user->isAdmin() ? route('admin.dashboard') : ($user->isAgent() ? route('agent.dashboard') : route('buyer.dashboard')) }}"
                   class="hidden text-sm font-semibold text-brand-700 hover:text-accent-500 sm:block">
                    {{ $user->name }}
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-outline !px-4 !py-2 text-xs">Log out</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="hidden text-sm font-semibold text-brand-700 hover:text-accent-500 sm:block">Log in</a>
                <a href="{{ route('register') }}" class="btn-primary !px-4 !py-2 text-xs">Sign up</a>
            @endauth
        </div>
    </div>

    <nav class="flex items-center gap-5 overflow-x-auto border-t border-brand-50 px-4 py-2 text-xs font-semibold text-brand-600 md:hidden">
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('properties.index') }}">Properties</a>
        <a href="{{ route('services.index') }}">Services</a>
        <a href="{{ route('pages.about') }}">About</a>
        <a href="{{ route('contact.create') }}">Contact</a>
    </nav>
</header>
