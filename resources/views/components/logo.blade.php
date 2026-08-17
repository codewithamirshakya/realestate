@props(['dark' => false])

<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-2.5']) }}>
    <x-logo-mark class="h-10 w-auto shrink-0" :dark="$dark" alt="" />
    <span class="leading-tight">
        <span class="block font-serif text-lg font-bold tracking-[0.18em] {{ $dark ? 'text-white' : 'text-brand-700' }}">
            OM REALTORS
        </span>
        <span class="block text-[11px] font-medium tracking-wider {{ $dark ? 'text-brand-200' : 'text-brand-400' }}">
            घर जग्गा किनबेच सेवा
        </span>
    </span>
</span>
