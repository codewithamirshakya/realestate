@props(['class' => 'h-10 w-10'])

{{-- Recreation of the Om Realtors mountain/skyline mark as a crisp inline SVG --}}
<svg viewBox="0 0 120 90" fill="none" xmlns="http://www.w3.org/2000/svg" {{ $attributes->merge(['class' => $class]) }}>
    <defs>
        <linearGradient id="omMarkGradient" x1="60" y1="0" x2="60" y2="92" gradientUnits="userSpaceOnUse">
            <stop offset="0" stop-color="#163f58" />
            <stop offset="1" stop-color="#9dc3d6" />
        </linearGradient>
    </defs>
    @php
        $lines = [];
        for ($i = 0; $i < 9; $i++) {
            $apexY = 8 + $i * 2.2;
            $height = 14 + $i * 7.5;
            $baseY = $apexY + $height;
            $spread = 8 + $i * 7.2;
            $lines[] = [60 - $spread, $baseY, 60, $apexY, 60 + $spread, $baseY];
        }
    @endphp
    @foreach ($lines as $i => [$x1, $y1, $x2, $y2, $x3, $y3])
        <polyline
            points="{{ $x1 }},{{ $y1 }} {{ $x2 }},{{ $y2 }} {{ $x3 }},{{ $y3 }}"
            stroke="url(#omMarkGradient)"
            stroke-width="2.4"
            stroke-linecap="round"
            stroke-linejoin="round"
            opacity="{{ 1 - $i * 0.05 }}"
        />
    @endforeach
</svg>
