@props([
    'size' => 'default', // default or small
])

@php
$heightClass = $size === 'small' ? 'h-11 sm:h-12 md:h-[52px]' : 'h-14 sm:h-16 md:h-20';
@endphp

<div {{ $attributes->merge(['class' => 'flex items-center']) }}>
    <img 
        src="{{ asset('images/logo.png') }}" 
        alt="Access Bhutan Tours & Treks" 
        class="{{ $heightClass }} w-auto object-contain block transition-all duration-200 hover:scale-[1.02] dark:brightness-105 dark:contrast-105"
    >
</div>
