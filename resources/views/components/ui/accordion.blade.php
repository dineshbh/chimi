@props([
    'title',
    'open' => false,
])

<details {{ $attributes->merge(['class' => 'group border-b border-border/80 py-1 [&_summary::-webkit-details-marker]:hidden']) }} {{ $open ? 'open' : '' }}>
    <summary class="flex cursor-pointer items-center justify-between py-4 text-base font-medium transition-all hover:underline text-foreground">
        <span>{{ $title }}</span>
        <span class="ml-4 shrink-0">
            <svg class="h-5 w-5 shrink-0 transition-transform duration-200 group-open:rotate-180 text-muted-foreground" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </span>
    </summary>
    <div class="pb-4 text-sm leading-relaxed text-muted-foreground prose prose-slate dark:prose-invert max-w-none">
        {{ $slot }}
    </div>
</details>
