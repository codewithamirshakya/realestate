@props([
    'class' => 'h-10 w-auto',
    'dark' => false,
    'alt' => null,
])

{{-- The Om Realtors pyramid mark. `dark` swaps in the light version for use on
     navy/photo backgrounds. Both files are generated from the supplied logo. --}}
<img src="{{ asset($dark ? 'images/logo-mark-light.png' : 'images/logo-mark.png') }}"
     alt="{{ $alt ?? config('company.name_en') }}"
     {{ $attributes->merge(['class' => $class]) }}>
