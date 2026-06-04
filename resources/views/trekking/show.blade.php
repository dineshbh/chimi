@extends('layouts.app')

@section('title', $trek->title . ' - Trekking Guide')
@section('meta_description', $trek->description)

@section('content')
@php
    $images = [
        'snowman-trek' => 'https://images.unsplash.com/photo-1472214222541-d510753a8707?q=80&w=1200',
        'jomolhari-trek' => 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?q=80&w=1200',
        'druk-path-trek' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?q=80&w=1200',
        'dagala-trek' => 'https://images.unsplash.com/photo-1533105079780-92b9be482077?q=80&w=1200'
    ];
    $imgUrl = $images[$trek->slug] ?? 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?q=80&w=1200';
@endphp

<!-- Header Banner -->
<div class="relative bg-slate-900 text-white py-20 overflow-hidden">
    <div class="absolute inset-0 opacity-40 bg-[url('{{ $imgUrl }}')] bg-cover bg-center"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-background via-background/60 to-transparent"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-2 mb-4">
            <a href="{{ route('trekking') }}" class="text-xs font-semibold text-primary dark:text-accent hover:underline uppercase tracking-wider flex items-center gap-1">
                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/></svg>
                Back to Trekking
            </a>
        </div>
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold font-serif text-foreground tracking-tight leading-tight">
            {{ $trek->title }}
        </h1>
        <p class="mt-2 text-sm sm:text-base text-muted-foreground max-w-xl">
            {{ $trek->description }}
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left: Trek Details Content -->
        <article class="lg:col-span-2 bg-card border rounded-lg p-6 sm:p-10 shadow-sm">
            <div id="trek-content" class="prose prose-slate dark:prose-invert max-w-none text-muted-foreground leading-relaxed text-base space-y-6">
                {!! $trek->content_html !!}
            </div>
        </article>

        <!-- Right: Matching Itinerary Book Panel & Inquiry Form -->
        <aside class="lg:col-span-1 space-y-8">
            <!-- Matching Tour Package -->
            @if($package)
                <x-ui.card class="border-primary/20 dark:border-accent/20 bg-primary/5 dark:bg-accent/5">
                    <x-ui.card.header>
                        <span class="text-[10px] font-bold text-primary dark:text-accent uppercase tracking-wider">Accompanying Tour Package</span>
                        <x-ui.card.title class="text-lg">{{ $package->title }}</x-ui.card.title>
                        <x-ui.card.description>{{ $package->duration }} • Guided & Fully Supported</x-ui.card.description>
                    </x-ui.card.header>
                    <x-ui.card.content>
                        <p class="text-xs text-muted-foreground leading-relaxed">
                            {{ $package->snippet }}
                        </p>
                    </x-ui.card.content>
                    <x-ui.card.footer>
                        <x-ui.button href="{{ route('tours.show', ['slug' => $package->slug]) }}" class="w-full">
                            View Itinerary & Pricing
                        </x-ui.button>
                    </x-ui.card.footer>
                </x-ui.card>
            @endif

            <!-- Custom Quote Request -->
            <x-ui.card class="sticky top-24">
                <x-ui.card.header>
                    <x-ui.card.title>Customize Your Trek</x-ui.card.title>
                    <x-ui.card.description>Inquire about planning a private trek for {{ $trek->title }}</x-ui.card.description>
                </x-ui.card.header>
                <x-ui.card.content>
                    <form action="{{ route('contact.submit') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="package" value="Custom Trek: {{ $trek->title }}">
                        
                        <div class="space-y-1">
                            <label for="name" class="text-xs font-semibold text-foreground uppercase">Your Name *</label>
                            <input type="text" name="name" id="name" required class="flex h-9 w-full rounded-md border border-input bg-background px-3 py-1 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring">
                        </div>

                        <div class="space-y-1">
                            <label for="email" class="text-xs font-semibold text-foreground uppercase">Email Address *</label>
                            <input type="email" name="email" id="email" required class="flex h-9 w-full rounded-md border border-input bg-background px-3 py-1 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring">
                        </div>

                        <div class="space-y-1">
                            <label for="phone" class="text-xs font-semibold text-foreground uppercase">Phone Number</label>
                            <input type="text" name="phone" id="phone" class="flex h-9 w-full rounded-md border border-input bg-background px-3 py-1 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring">
                        </div>

                        <div class="space-y-1">
                            <label for="message" class="text-xs font-semibold text-foreground uppercase">Preferred Travel Window & Details *</label>
                            <textarea name="message" id="message" rows="4" required placeholder="Let us know your expected travel window, fitness level, and group size..." class="flex min-h-[60px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"></textarea>
                        </div>

                        <x-ui.button type="submit" class="w-full">
                            Send Trek Inquiry
                        </x-ui.button>
                    </form>
                </x-ui.card.content>
            </x-ui.card>
        </aside>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Adjust styling of injected images & tables in native HTML
        const container = document.getElementById('trek-content');
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
                link.className = "text-primary dark:text-accent font-semibold hover:underline";
            });
        }
    });
</script>
@endsection
