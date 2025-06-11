@props(['name', 'class' => null, 'variant' => null])

@php
    $view = 'flux.icon.' . $name;
@endphp

@if (view()->exists($view))
    <div {{ $attributes->merge(['class' => $class]) }}>
        @include($view, ['class' => $class, 'variant' => $variant])
    </div>
@else
    <!-- Icon "{{ $name }}" not found -->
@endif 