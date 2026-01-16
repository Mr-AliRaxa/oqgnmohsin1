@props(['active'])

<a {{ $attributes->merge(['class' => 'nav-link ' . ($active ? 'active fw-bold' : '')]) }}>
    {{ $slot }}
</a>
