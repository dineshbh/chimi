@extends('layouts.app')

@section('title', $pageData['title'] . ' - About Bhutan')
@section('meta_description', $pageData['description'] ?? '')
@section('meta_keywords', $pageData['keywords'] ?? '')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        
        <!-- Sidebar Navigation (Desktop) -->
        <aside class="hidden lg:block lg:col-span-1 space-y-6">
            <div class="sticky top-24">
                <span class="text-xs font-semibold text-muted-foreground uppercase tracking-wider block mb-4">About Bhutan</span>
                <nav class="flex flex-col space-y-1">
                    @foreach($aboutSlugs as $key => $label)
                        @php
                            $routeSlug = str_replace('about-us_', '', $key);
                            $isActive = $slug === $key;
                        @endphp
                        <a 
                            href="{{ route('about', ['slug' => $routeSlug]) }}" 
                            class="px-3 py-2 text-sm font-medium rounded-md transition-colors {{ $isActive ? 'bg-primary/10 text-primary dark:text-accent font-semibold' : 'text-muted-foreground hover:bg-muted hover:text-foreground' }}"
                        >
                            {{ $label }}
                        </a>
                    @endforeach
                </nav>
            </div>
        </aside>

        <!-- Mobile Section Selector -->
        <div class="lg:hidden w-full mb-6">
            <label for="about-section-selector" class="sr-only">Select Section</label>
            <select 
                id="about-section-selector" 
                class="block w-full rounded-md border border-input bg-background px-3 py-2 text-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
                onchange="window.location.href = this.value"
            >
                @foreach($aboutSlugs as $key => $label)
                    @php
                        $routeSlug = str_replace('about-us_', '', $key);
                        $isSelected = $slug === $key;
                    @endphp
                    <option 
                        value="{{ route('about', ['slug' => $routeSlug]) }}" 
                        {{ $isSelected ? 'selected' : '' }}
                    >
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Main Content Area -->
        <article class="lg:col-span-3 bg-card border rounded-lg p-6 sm:p-10 shadow-sm">
            <header class="pb-6 border-b border-border mb-8">
                <h1 class="text-3xl sm:text-4xl font-bold font-serif text-foreground tracking-tight leading-tight">
                    {{ $pageData['title'] }}
                </h1>
            </header>

            <div class="prose prose-slate dark:prose-invert max-w-none text-muted-foreground leading-relaxed text-base space-y-6">
                <!-- Inject Content HTML dynamically -->
                {!! $pageData['content_html'] !!}
            </div>
        </article>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Adjust styling of injected images & tables in native HTML
        const container = document.querySelector('article');
        if (container) {
            const images = container.querySelectorAll('img');
            images.forEach(img => {
                img.className = "rounded-lg border shadow-sm my-6 max-w-full mx-auto object-cover h-auto";
            });

            const tables = container.querySelectorAll('table');
            tables.forEach(table => {
                table.className = "min-w-full divide-y border my-6 text-sm bg-card text-foreground";
                const cells = table.querySelectorAll('td, th');
                cells.forEach(cell => {
                    cell.className = "px-4 py-3 border border-border/80 text-foreground";
                });
            });

            const links = container.querySelectorAll('a');
            links.forEach(link => {
                if (!link.classList.contains('yjanchor')) {
                    link.className = "text-primary dark:text-accent font-semibold hover:underline";
                }
            });
        }
    });
</script>
@endsection
