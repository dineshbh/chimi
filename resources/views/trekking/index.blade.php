@extends('layouts.app')

@section('title', 'Trekking in Bhutan - Himalayan Trekking Guides & Packages')
@section('meta_description', 'Guide to the most legendary Himalayan treks, including the iconic Snowman Trek, Jomolhari Trek, and Druk Path Trek.')

@section('content')
<!-- Hero Header -->
<div class="relative bg-slate-900 text-white py-24 sm:py-32 overflow-hidden">
    <div class="absolute inset-0 opacity-40 bg-[url('https://images.unsplash.com/photo-1544735716-392fe2489ffa?q=80&w=1600')] bg-cover bg-center"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-background via-background/60 to-transparent"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
        <span class="text-xs font-bold tracking-widest text-primary dark:text-accent uppercase">Explore the High Himalayas</span>
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold font-serif tracking-tight text-foreground">
            Trekking in Bhutan
        </h1>
        <p class="max-w-2xl mx-auto text-base sm:text-lg text-muted-foreground">
            From easy 6-day alpine routes connecting valleys to the 25-day Snowman Trek, explore the pristine wilderness of the thunder dragon kingdom.
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 space-y-16">
    <!-- Trek Guides Section -->
    <div class="space-y-8">
        <div class="text-center md:text-left">
            <h2 class="text-3xl font-bold font-serif text-foreground">Himalayan Trekking Guides</h2>
            <p class="text-muted-foreground text-sm max-w-md mt-1">Detailed guides, difficulty charts, elevations, and packing checklists for top routes.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach($trekGuides as $guide)
                @php
                    // Set metadata dynamically based on slug
                    $meta = [
                        'snowman-trek' => ['diff' => 'Extreme', 'color' => 'bg-red-500/10 text-red-600 dark:text-red-400', 'alt' => '5,230m', 'dur' => '25 Days', 'bg' => 'https://images.unsplash.com/photo-1472214222541-d510753a8707?q=80&w=600'],
                        'jomolhari-trek' => ['diff' => 'Demanding', 'color' => 'bg-amber-500/10 text-amber-600 dark:text-amber-400', 'alt' => '4,890m', 'dur' => '12 Days', 'bg' => 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?q=80&w=600'],
                        'druk-path-trek' => ['diff' => 'Moderate', 'color' => 'bg-cyan-500/10 text-cyan-600 dark:text-cyan-400', 'alt' => '4,200m', 'dur' => '6 Days', 'bg' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?q=80&w=600'],
                        'dagala-trek' => ['diff' => 'Moderate', 'color' => 'bg-cyan-500/10 text-cyan-600 dark:text-cyan-400', 'alt' => '4,720m', 'dur' => '6 Days', 'bg' => 'https://images.unsplash.com/photo-1533105079780-92b9be482077?q=80&w=600']
                    ][$guide->slug] ?? ['diff' => 'Moderate', 'color' => 'bg-cyan-500/10 text-cyan-600 dark:text-cyan-400', 'alt' => '4,500m', 'dur' => '7-10 Days', 'bg' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?q=80&w=600'];
                @endphp
                <x-ui.card class="group flex flex-col md:flex-row overflow-hidden hover:shadow-lg transition-all duration-300">
                    <!-- Image Panel -->
                    <div class="relative w-full md:w-48 h-48 md:h-auto overflow-hidden shrink-0">
                        <img src="{{ $meta['bg'] }}" alt="{{ $guide->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-black/30 md:hidden"></div>
                    </div>
                    
                    <!-- Content Panel -->
                    <div class="p-6 flex flex-col justify-between flex-grow">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold uppercase tracking-wider {{ $meta['color'] }}">
                                    {{ $meta['diff'] }}
                                </span>
                                <span class="text-xs text-muted-foreground flex items-center gap-1">
                                    Max Alt: <strong>{{ $meta['alt'] }}</strong>
                                </span>
                            </div>
                            <h3 class="text-xl font-bold font-serif text-foreground group-hover:text-primary dark:group-hover:text-accent transition-colors">
                                <a href="{{ route('trekking.show', ['slug' => $guide->slug]) }}">{{ $guide->title }}</a>
                            </h3>
                            <p class="text-sm text-muted-foreground line-clamp-3 leading-relaxed">
                                {{ $guide->description ?? 'Read our complete trail overview, route map, elevation profiles, weather guide and packing requirements.' }}
                            </p>
                        </div>
                        <div class="pt-4 border-t border-border/50 flex items-center justify-between mt-4">
                            <span class="text-xs text-muted-foreground font-medium">Duration: {{ $meta['dur'] }}</span>
                            <a href="{{ route('trekking.show', ['slug' => $guide->slug]) }}" class="inline-flex items-center text-xs font-semibold text-primary dark:text-accent hover:underline gap-1">
                                Read Guide
                                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    </div>
                </x-ui.card>
            @endforeach
        </div>
    </div>

    <!-- Trek Packages Section -->
    <div class="space-y-8 border-t border-border pt-16">
        <div class="text-center md:text-left">
            <h2 class="text-3xl font-bold font-serif text-foreground">Trekking Tour Packages</h2>
            <p class="text-muted-foreground text-sm max-w-md mt-1">Book a fully guided, supported trek with experienced mountain guides, cooks, and pack animals.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($trekPackages as $package)
                <div class="rounded-lg border bg-card text-card-foreground shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between h-[360px] overflow-hidden">
                    <div class="p-6 space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold uppercase tracking-wider bg-cyan-500/10 text-cyan-600 dark:text-cyan-400">
                                Guided Trek
                            </span>
                            <span class="text-xs font-medium text-muted-foreground flex items-center gap-1">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ $package->duration }}
                            </span>
                        </div>
                        <h3 class="text-lg font-bold font-serif leading-tight text-foreground line-clamp-2" title="{{ $package->title }}">
                            <a href="{{ route('tours.show', ['slug' => $package->slug]) }}" class="hover:text-primary dark:hover:text-accent">
                                {{ $package->title }}
                            </a>
                        </h3>
                        <p class="text-sm text-muted-foreground leading-relaxed line-clamp-4">
                            {{ $package->snippet }}
                        </p>
                    </div>
                    
                    <div class="flex items-center justify-between px-6 pb-6 border-t mt-auto pt-4 border-muted/50">
                        <a 
                            href="{{ route('tours.show', ['slug' => $package->slug]) }}" 
                            class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-semibold ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 bg-secondary text-secondary-foreground hover:bg-secondary/80 h-9 px-3 w-full"
                        >
                            View Itinerary
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
