@extends('layouts.app')

@section('title', $guide->title . ' - Access Bhutan Travel Guide')
@section('meta_description', $guide->description)

@section('content')
@php
    $images = [
        'visa-guide' => 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?q=80&w=1200',
        'cost-guide' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?q=80&w=1200',
        'food-guide' => 'https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca?q=80&w=1200',
        'packing-lists' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?q=80&w=1200',
        'travel-tips' => 'https://images.unsplash.com/photo-1533105079780-92b9be482077?q=80&w=1200'
    ];
    $imgUrl = app()->environment('production') ? null : ($images[$guide->slug] ?? 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?q=80&w=1200');
@endphp

<!-- Header Banner -->
<div class="relative bg-slate-900 text-white py-20 overflow-hidden">
    @if($imgUrl)
        <div class="absolute inset-0 opacity-40 bg-cover bg-center" style="background-image: url('{{ $imgUrl }}');"></div>
    @endif
    <div class="absolute inset-0 bg-[linear-gradient(90deg,rgba(5,17,8,0.94)_0%,rgba(9,30,16,0.78)_44%,rgba(9,30,16,0.18)_74%,rgba(5,17,8,0.36)_100%)]"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-background via-background/60 to-transparent"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-2 mb-4">
            <a href="{{ route('guide') }}" class="text-xs font-semibold text-primary dark:text-accent hover:underline uppercase tracking-wider flex items-center gap-1">
                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/></svg>
                Back to Guides
            </a>
        </div>
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold font-serif text-foreground tracking-tight leading-tight">
            {{ $guide->title }}
        </h1>
        <p class="mt-2 text-sm sm:text-base text-muted-foreground max-w-xl">
            {{ $guide->description }}
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left: Blog Post Content -->
        <article class="lg:col-span-2 bg-card border rounded-lg p-6 sm:p-10 shadow-sm">
            <div id="guide-content" class="prose prose-slate dark:prose-invert max-w-none text-muted-foreground leading-relaxed text-base space-y-6">
                {!! $guide->content_html !!}
            </div>
        </article>

        <!-- Right: Inquiry Form & Related Blogs Sidebar -->
        <aside class="lg:col-span-1 space-y-8">
            <!-- Planning Form Card -->
            <x-ui.card class="sticky top-24">
                <x-ui.card.header>
                    <x-ui.card.title>Ready to Visit Bhutan?</x-ui.card.title>
                    <x-ui.card.description>Inquire today to plan your dream vacation with Access Bhutan.</x-ui.card.description>
                </x-ui.card.header>
                <x-ui.card.content>
                    <form action="{{ route('contact.submit') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="package" value="General Travel Guide Lead: {{ $guide->title }}">
                        
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
                            <label for="message" class="text-xs font-semibold text-foreground uppercase">Your Message *</label>
                            <textarea name="message" id="message" rows="4" required placeholder="Let us know your travel preferences, questions, or ideas..." class="flex min-h-[60px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"></textarea>
                        </div>

                        <x-ui.button type="submit" class="w-full">
                            Send Message
                        </x-ui.button>
                    </form>
                </x-ui.card.content>
            </x-ui.card>

            <!-- Related Articles -->
            @if($allGuides->isNotEmpty())
                <div class="space-y-4">
                    <span class="text-xs font-bold text-muted-foreground uppercase tracking-wider block">More Travel Guides</span>
                    
                    @foreach($allGuides as $relGuide)
                        @php
                            $relImages = [
                                'visa-guide' => 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?q=80&w=200',
                                'cost-guide' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?q=80&w=200',
                                'food-guide' => 'https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca?q=80&w=200',
                                'packing-lists' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?q=80&w=200',
                                'travel-tips' => 'https://images.unsplash.com/photo-1533105079780-92b9be482077?q=80&w=200'
                            ];
                            $relImgUrl = app()->environment('production') ? null : ($relImages[$relGuide->slug] ?? 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?q=80&w=200');
                        @endphp
                        <x-ui.card class="hover:shadow-md transition-shadow flex items-center p-3 gap-3">
                            @if($relImgUrl)
                                <img src="{{ $relImgUrl }}" alt="{{ $relGuide->title }}" class="h-14 w-14 object-cover rounded-md shrink-0">
                            @else
                                <div class="h-14 w-14 rounded-md shrink-0 bg-gradient-to-br from-[#0e2213] to-[#1c1106] flex items-center justify-center relative overflow-hidden">
                                    <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(rgba(255,255,255,0.15) 1px, transparent 1px); background-size: 8px 8px;"></div>
                                    <span class="font-serif font-bold text-white/10 text-lg select-none">{{ substr($relGuide->title, 0, 1) }}</span>
                                </div>
                            @endif
                            <div class="space-y-1 min-w-0">
                                <h4 class="text-sm font-bold text-foreground line-clamp-1">
                                    <a href="{{ route('guide.show', ['slug' => $relGuide->slug]) }}" class="hover:underline">
                                        {{ $relGuide->title }}
                                    </a>
                                </h4>
                                <p class="text-xs text-muted-foreground line-clamp-1">{{ $relGuide->description }}</p>
                            </div>
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
        const container = document.getElementById('guide-content');
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
