@props(['icon' => 'building', 'class' => 'h-5 w-5'])

@php
    $paths = [
        'calculator' => 'M9 7h6m-6 4h.01M12 11h.01M15 11h.01M9 15h.01M12 15h.01M15 15h.01M7 3h10a2 2 0 012 2v14a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z',
        'ruler' => 'M4 16l10.5-10.5a1.5 1.5 0 012.121 0l1.879 1.879a1.5 1.5 0 010 2.121L8 20H4v-4z M12 8l1.5 1.5M9 11l1.5 1.5M6 14l1.5 1.5',
        'map' => 'M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7',
        'bank' => 'M3 21h18M4 10h16M4 10l8-6 8 6M6 10v9m4-9v9m4-9v9m4-9v9',
        'draft' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
        'home' => 'M3 12l9-9 9 9M5 10v10a1 1 0 001 1h4a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h4a1 1 0 001-1V10',
        'building' => 'M3 21h18M6 21V7l6-4 6 4v14M9 9h1m-1 4h1m-1 4h1m4-8h1m-1 4h1m-1 4h1',
    ];
    $d = $paths[$icon] ?? $paths['building'];
@endphp

<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" {{ $attributes->merge(['class' => $class]) }}>
    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $d }}" />
</svg>
