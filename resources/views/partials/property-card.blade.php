@php
    $image = $property->primaryImage();
    $statusColors = [
        'available' => 'bg-accent-400 text-white',
        'pending' => 'bg-amber-500 text-white',
        'sold' => 'bg-brand-700 text-white',
        'rented' => 'bg-brand-700 text-white',
    ];
@endphp
<a href="{{ route('properties.show', $property) }}" class="card group flex flex-col overflow-hidden transition hover:-translate-y-1 hover:shadow-lg">
    <div class="relative aspect-[4/3] w-full overflow-hidden bg-gradient-to-br from-brand-200 to-brand-500">
        @if ($image)
            <img src="{{ $image->url() }}" alt="{{ $property->title }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
        @else
            <div class="flex h-full w-full items-center justify-center">
                <x-logo-mark class="h-12 w-auto opacity-50" alt="" />
            </div>
        @endif

        <div class="absolute left-3 top-3 flex gap-2">
            <span class="badge {{ $statusColors[$property->status] ?? 'bg-brand-600 text-white' }}">{{ ucfirst($property->status) }}</span>
            @if ($property->featured)
                <span class="badge bg-white/90 text-brand-700">Featured</span>
            @endif
        </div>
        <span class="absolute right-3 top-3 badge bg-white/90 text-brand-700 capitalize">For {{ $property->listing_type }}</span>
    </div>

    <div class="flex flex-1 flex-col p-4">
        <p class="text-lg font-bold text-brand-700">{{ $property->formattedPrice() }}@if($property->listing_type === 'rent')<span class="text-xs font-medium text-brand-400">/month</span>@endif</p>
        <h3 class="mt-1 line-clamp-1 text-base font-semibold text-brand-900">{{ $property->title }}</h3>
        <p class="mt-1 line-clamp-1 text-sm text-brand-400">{{ $property->address }}, {{ $property->city }}</p>

        <div class="mt-3 flex flex-wrap gap-3 border-t border-brand-50 pt-3 text-xs font-medium text-brand-500">
            @if ($property->bedrooms)
                <span>{{ $property->bedrooms }} Bed</span>
            @endif
            @if ($property->bathrooms)
                <span>{{ $property->bathrooms }} Bath</span>
            @endif
            @if ($property->area_sqft)
                <span>{{ number_format($property->area_sqft) }} sqft</span>
            @endif
            <span class="ml-auto capitalize text-brand-300">{{ $property->category }}</span>
        </div>
    </div>
</a>
