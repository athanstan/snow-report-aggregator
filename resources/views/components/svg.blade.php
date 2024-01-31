@props([
    'title' => '',
    'svg' => '',
])
<svg {{ $attributes }} x-data x-tooltip.raw="{{ $title }}" width="24" height="24">
    <use xlink:href="{{ asset('tabler-sprite.svg').'#tabler-'.$svg }}" />
</svg>
