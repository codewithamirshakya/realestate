@props([
    'key',
    'alt' => '',
    'default' => null,
    'wrapper' => '',
])

@php
    $cms = app(\App\Support\Cms::class);
    $url = $cms->imageUrl($key) ?? $default;
    $editable = $cms->editing();
    $label = $cms->field($key)['label'] ?? $key;
@endphp

@if ($editable)
    <div class="relative {{ $wrapper }}">
        @if ($url)
            <img src="{{ $url }}" alt="{{ $alt }}" {{ $attributes }}>
        @else
            <div {{ $attributes->merge(['class' => 'flex min-h-40 items-center justify-center bg-brand-50 text-sm text-brand-400']) }}>{{ $label }}</div>
        @endif
        <button type="button" class="cms-image-button" data-cms-image="{{ $key }}" data-cms-label="{{ $label }}">
            Change image
        </button>
    </div>
@elseif ($url)
    <img src="{{ $url }}" alt="{{ $alt }}" {{ $attributes }}>
@endif
