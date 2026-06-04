@props([
    'variant' => 'default',
    'size' => 'default',
])

@php
$baseStyles = 'inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-semibold leading-none tracking-normal ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50';

$variants = [
    'default' => 'bg-primary text-primary-foreground hover:bg-primary/90',
    'destructive' => 'bg-destructive text-destructive-foreground hover:bg-destructive/90',
    'outline' => 'border border-border bg-background text-foreground hover:border-primary/40 hover:bg-secondary',
    'secondary' => 'bg-secondary text-secondary-foreground hover:bg-secondary/80',
    'ghost' => 'text-foreground hover:bg-secondary',
    'accent' => 'bg-accent text-accent-foreground hover:bg-accent/90',
    'hero-outline' => 'border border-white/35 bg-white/10 text-white backdrop-blur-sm hover:bg-white/18 hover:border-white/55',
    'link' => 'text-primary underline-offset-4 hover:underline',
];

$sizes = [
    'default' => 'h-10 px-4',
    'sm' => 'h-9 rounded-md px-3 text-xs',
    'lg' => 'h-11 rounded-md px-5',
    'icon' => 'h-10 w-10',
];

$classes = trim(implode(' ', [
    $baseStyles,
    $variants[$variant] ?? $variants['default'],
    $sizes[$size] ?? $sizes['default'],
]));
@endphp

@if ($attributes->has('href'))
    <a {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
