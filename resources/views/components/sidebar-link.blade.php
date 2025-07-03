@props(['route', 'icon', 'label'])

@php
    $isActive = request()->routeIs($route . '*');
@endphp

<a href="{{ route($route) }}"
   {{ $attributes->merge(['class' => "flex items-center gap-3 px-4 py-2 rounded-lg font-semibold transition-colors " . ($isActive ? 'bg-blue-600 text-white shadow-lg' : 'text-gray-300 hover:bg-blue-500 hover:text-white')]) }}>
    <span class="text-lg">{{ $icon }}</span>
    <span>{{ $label }}</span>
</a>
