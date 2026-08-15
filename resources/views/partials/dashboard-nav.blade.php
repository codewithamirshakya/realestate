@php
    $links = match ($role) {
        'admin' => [
            ['label' => 'Dashboard', 'route' => 'admin.dashboard'],
            ['label' => 'Properties', 'route' => 'admin.properties.index'],
            ['label' => 'Inquiries', 'route' => 'admin.inquiries.index'],
            ['label' => 'Users', 'route' => 'admin.users.index'],
            ['label' => 'Services', 'route' => 'admin.services.index'],
            ['label' => 'Site Content', 'route' => 'admin.content.index'],
        ],
        'agent' => [
            ['label' => 'Dashboard', 'route' => 'agent.dashboard'],
            ['label' => 'My Properties', 'route' => 'agent.properties.index'],
            ['label' => 'Add Property', 'route' => 'agent.properties.create'],
        ],
        default => [
            ['label' => 'Dashboard', 'route' => 'buyer.dashboard'],
            ['label' => 'Browse Properties', 'route' => 'properties.index'],
        ],
    };
@endphp

<aside class="lg:sticky lg:top-24 lg:self-start">
    <div class="card p-4">
        <p class="px-2 text-xs font-semibold uppercase tracking-wide text-brand-300">{{ ucfirst($role) }} Panel</p>
        <nav class="mt-2 space-y-1">
            @foreach ($links as $link)
                <a href="{{ route($link['route']) }}"
                   class="block rounded-lg px-3 py-2 text-sm font-medium {{ request()->routeIs($link['route']) ? 'bg-brand-600 text-white' : 'text-brand-600 hover:bg-brand-50' }}">
                    {{ $link['label'] }}
                </a>
            @endforeach
        </nav>
    </div>
</aside>
