@props([
    'tipo' => '',      // Valor de filtro, ej: 'Nacimiento', 'Fuga', 'Deceso' o ''
    'label' => null,   // Texto visible, por defecto será igual a 'tipo', o 'Todos' si está vacío
    'icon' => '',      // Emoji o ícono representativo
])

@php
    $label = $label ?? ($tipo ?: 'Todos'); // Si no hay label, usar tipo o "Todos"
    $isActive = request('tipo') === $tipo;
@endphp

<a 
    href="{{ route('eventos.index', ['tipo' => $tipo]) }}"
    {{ $attributes->merge([
        'class' => 'flex items-center gap-2 px-4 py-2 rounded-md text-sm font-medium transition-colors ' .
                   ($isActive ? 'bg-blue-100 text-blue-800 font-semibold' : 'text-gray-700 hover:bg-gray-100')
    ]) }}
>
    @if($icon)
        <span>{{ $icon }}</span>
    @endif
    <span>{{ $label }}</span>
</a>
