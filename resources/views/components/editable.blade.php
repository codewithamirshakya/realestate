@props([
    'key',
    'as' => 'p',
    'default' => null,
    'multiline' => false,
])

@php
    $cms = app(\App\Support\Cms::class);
    $value = $cms->value($key, $default);
    $editable = $cms->editing();
    $label = $cms->field($key)['label'] ?? $key;
@endphp

<{{ $as }} {{ $attributes->class([
        'cms-editable' => $editable,
        'whitespace-pre-line' => $multiline,
    ]) }}
    @if ($editable)
        data-cms-key="{{ $key }}"
        data-cms-label="{{ $label }}"
        contenteditable="plaintext-only"
        spellcheck="false"
        role="textbox"
        tabindex="0"
    @endif
>{{ $editable && blank($value) ? $label : $value }}</{{ $as }}>
