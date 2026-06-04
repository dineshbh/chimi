@extends('layouts.app')

@section('title', $destination->title . ' Travel Guide - Access Bhutan Tours')
@section('meta_description', $destination->description)

@section('seo_schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "BreadcrumbList",
  "itemListElement": [
    {
      "@@type": "ListItem",
      "position": 1,
      "name": "Home",
      "item": "{{ route('home') }}"
    },
    {
      "@@type": "ListItem",
      "position": 2,
      "name": "Destinations",
      "item": "{{ route('destinations') }}"
    },
    {
      "@@type": "ListItem",
      "position": 3,
      "name": "{{ $destination->title }}",
      "item": "{{ request()->url() }}"
    }
  ]
}
</script>
@endsection

@section('content')
<!-- Full Gradient Destination Hero -->
<section class="relative isolate overflow-hidden bg-slate-950 text-white">
    @if($heroImage)
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ $heroImage }}');"></div>
    @endif
    <div class="absolute inset-0 bg-[linear-gradient(90deg,rgba(5,17,8,0.94)_0%,rgba(9,30,16,0.78)_44%,rgba(9,30,16,0.18)_74%,rgba(5,17,8,0.36)_100%)]"></div>
    <div class="absolute inset-0 bg-[linear-gradient(0deg,rgba(5,17,8,0.92)_0%,rgba(5,17,8,0.24)_46%,rgba(5,17,8,0.08)_100%)]"></div>
    <div class="absolute inset-0 opacity-18" style="background-image: linear-gradient(rgba(255,255,255,0.08) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.08) 1px, transparent 1px); background-size: 40px 40px;"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20 lg:py-24">
        <div class="max-w-3xl space-y-5">
            <a href="{{ route('destinations') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-white/75 hover:text-white uppercase tracking-wider transition-colors">
                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/></svg>
                Back to Destinations
            </a>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold font-serif text-white tracking-tight leading-tight">
                {{ $destination->title }}
            </h1>
            <p class="text-base sm:text-lg text-white/80 leading-relaxed max-w-2xl">
                {{ $destination->description }}
            </p>
            <div class="flex flex-wrap items-center gap-3 pt-2">
                <span class="inline-flex items-center rounded-full border border-white/20 bg-white/10 px-3.5 py-1.5 text-sm font-semibold text-white backdrop-blur">
                    Destination guide
                </span>
                <a href="{{ route('contact') }}" class="inline-flex items-center rounded-full bg-accent px-3.5 py-1.5 text-sm font-bold text-accent-foreground transition-colors hover:bg-accent/90">
                    Plan this route
                </a>
            </div>
        </div>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left: Destination Guide Content -->
        <article class="lg:col-span-2 bg-card border rounded-lg p-6 sm:p-10 shadow-sm">
            <div id="destination-content" class="prose prose-slate dark:prose-invert max-w-none text-muted-foreground leading-relaxed text-base space-y-6">
                {!! $destination->content_html !!}
            </div>
        </article>

        <!-- Right: Inquiry Form & Suggested Tours -->
        <aside class="lg:col-span-1 space-y-8">
            <!-- Travel Planner Card -->
            <x-ui.card class="sticky top-24">
                <x-ui.card.header>
                    <x-ui.card.title>Plan Your Visit</x-ui.card.title>
                    <x-ui.card.description>Inquire about custom trips to {{ $destination->title }}</x-ui.card.description>
                </x-ui.card.header>
                <x-ui.card.content>
                    <form action="{{ route('contact.submit') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="package" value="Custom Journey containing {{ $destination->title }}">
                        
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
                            <label for="message" class="text-xs font-semibold text-foreground uppercase">Travel Dates & Group Size *</label>
                            <textarea name="message" id="message" rows="4" required placeholder="Let us know your preferred dates, budget, and details..." class="flex min-h-[60px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"></textarea>
                        </div>

                        <x-ui.button type="submit" variant="accent" class="w-full">
                            Request Custom Quote
                        </x-ui.button>
                    </form>
                </x-ui.card.content>
            </x-ui.card>

            <!-- Suggested Tours -->
            @if($suggestedTours->isNotEmpty())
                <div class="space-y-4">
                    <span class="text-xs font-bold text-muted-foreground uppercase tracking-wider block">Recommended Tours</span>
                    
                    @foreach($suggestedTours as $tour)
                        <x-ui.card class="hover:shadow-md transition-shadow">
                            <x-ui.card.header class="p-4 flex flex-col space-y-1">
                                <span class="text-[10px] font-semibold uppercase tracking-wider text-primary dark:text-accent">
                                    {{ $tour->duration }}
                                </span>
                                <x-ui.card.title class="text-base line-clamp-1">
                                    <a href="{{ route('tours.show', ['slug' => $tour->slug]) }}" class="hover:underline text-foreground">
                                        {{ $tour->title }}
                                    </a>
                                </x-ui.card.title>
                            </x-ui.card.header>
                            <x-ui.card.content class="p-4 pt-0">
                                <p class="text-xs text-muted-foreground line-clamp-2">{{ $tour->snippet }}</p>
                            </x-ui.card.content>
                            <x-ui.card.footer class="p-4 pt-0">
                                <x-ui.button href="{{ route('tours.show', ['slug' => $tour->slug]) }}" variant="link" class="p-0 text-xs font-bold flex items-center gap-1">
                                    View Itinerary
                                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </x-ui.button>
                            </x-ui.card.footer>
                        </x-ui.card>
                    @endforeach
                </div>
            @endif
        </aside>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Adjust styling of injected images & tables in native HTML
        const container = document.getElementById('destination-content');
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
