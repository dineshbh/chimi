<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Access Bhutan Tours & Treks - Trusted Local Tour Operator')</title>
        <meta name="description" content="@yield('meta_description', 'Plan your Bhutan trip with Access Bhutan Tours, a trusted local tour operator offering authentic cultural journeys, treks & custom tours.')">
        <meta name="keywords" content="@yield('meta_keywords', 'Bhutan travel agency, Bhutan tour company, Access Bhutan Tours, Bhutan private tours, Bhutan trekking')">

        @yield('seo_schema')

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">

        <!-- Scripts & Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Inline Theme Script to prevent flash of theme (Disabled dark mode) -->
        <script>
            document.documentElement.classList.add('light');
            document.documentElement.classList.remove('dark');
        </script>

        <!-- Global Unsplash Image Fallback Script -->
        <script>
            (function() {
                const FALLBACK_SVG = 'data:image/svg+xml;utf8,' + encodeURIComponent(
                    '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 500" width="100%" height="100%">' +
                    '<defs>' +
                    '<linearGradient id="bg" x1="0%" y1="0%" x2="100%" y2="100%">' +
                    '<stop offset="0%" stop-color="#0e2213"/>' +
                    '<stop offset="50%" stop-color="#051108"/>' +
                    '<stop offset="100%" stop-color="#1c1106"/>' +
                    '</linearGradient>' +
                    '<pattern id="grid" width="24" height="24" patternUnits="userSpaceOnUse">' +
                    '<circle cx="1" cy="1" r="1" fill="rgba(255, 255, 255, 0.08)"/>' +
                    '</pattern>' +
                    '</defs>' +
                    '<rect width="100%" height="100%" fill="url(#bg)"/>' +
                    '<rect width="100%" height="100%" fill="url(#grid)"/>' +
                    '<path d="M 0 500 L 250 250 L 450 380 L 650 180 L 800 350 L 800 500 Z" fill="rgba(147, 197, 75, 0.08)"/>' +
                    '<path d="M 150 500 L 400 300 L 600 450 L 800 280 L 800 500 Z" fill="rgba(255, 122, 0, 0.05)"/>' +
                    '<text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="rgba(255, 255, 255, 0.6)" font-family="system-ui, -apple-system, sans-serif" font-size="28" font-weight="bold" letter-spacing="0.15em">BHUTAN JOURNEY</text>' +
                    '<text x="50%" y="58%" dominant-baseline="middle" text-anchor="middle" fill="rgba(255, 122, 0, 0.6)" font-family="system-ui, -apple-system, sans-serif" font-size="16" font-weight="600" letter-spacing="0.05em">Image Placeholder</text>' +
                    '</svg>'
                );

                // Global intercept for image errors (<img> tags)
                window.addEventListener('error', function(event) {
                    if (event.target && event.target.tagName === 'IMG') {
                        const img = event.target;
                        if (img.src && img.src.includes('unsplash.com') && !img.dataset.fallbackApplied) {
                            img.dataset.fallbackApplied = 'true';
                            img.src = FALLBACK_SVG;
                        }
                    }
                }, true);

                // Handle background images
                function checkBackgroundImages() {
                    const elements = document.querySelectorAll('*');
                    elements.forEach(function(el) {
                        const style = el.getAttribute('style');
                        if (style && style.includes('background-image') && style.includes('unsplash.com') && !el.dataset.fallbackApplied) {
                            const match = style.match(/url\(['"]?([^'"]+)['"]?\)/);
                            if (match && match[1]) {
                                const url = match[1];
                                const testImg = new Image();
                                testImg.onload = function() {
                                    // Loaded fine
                                };
                                testImg.onerror = function() {
                                    el.dataset.fallbackApplied = 'true';
                                    el.style.backgroundImage = "url('" + FALLBACK_SVG + "')";
                                };
                                testImg.src = url;
                            }
                        }
                    });
                }

                // Run on DOMContentLoaded and watch for mutations
                document.addEventListener('DOMContentLoaded', function() {
                    checkBackgroundImages();

                    // MutationObserver handles dynamic pages/AJAX transitions
                    const observer = new MutationObserver(function(mutations) {
                        mutations.forEach(function(mutation) {
                            if (mutation.type === 'childList' || mutation.type === 'attributes') {
                                checkBackgroundImages();
                            }
                        });
                    });
                    observer.observe(document.body, {
                        childList: true,
                        subtree: true,
                        attributes: true,
                        attributeFilter: ['style']
                    });
                });
            })();
        </script>
    </head>
    <body class="font-sans antialiased min-h-screen flex flex-col bg-background text-foreground transition-colors duration-300">
        
        <!-- Global Success Alert Banner -->
        @if(session('success'))
            <div class="bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border-b border-emerald-500/20 py-3 text-center text-sm font-semibold tracking-wide flex items-center justify-center gap-2 px-4">
                <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- Header / Navigation -->
        <header id="main-header" class="sticky top-0 z-40 w-full border-b border-border/60 glass transition-all duration-300">
            <div id="main-header-container" class="max-w-7xl mx-auto flex h-[72px] items-center justify-between px-4 sm:px-6 lg:px-8 relative transition-all duration-300">
                <!-- Left: Logo Column -->
                <div class="flex items-center justify-start flex-1 h-full">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <x-ui.logo size="small" />
                    </a>
                </div>

                <!-- Center: Navigation Links Column -->
                <nav class="hidden lg:flex items-center justify-center h-full gap-6 text-[13.5px] font-medium tracking-wide text-foreground/80 dark:text-foreground/90 xl:gap-8">
                    <a href="{{ route('home') }}" class="group relative h-full flex items-center transition-all duration-300 hover:text-primary dark:hover:text-accent {{ request()->routeIs('home') ? 'text-primary dark:text-accent font-semibold' : 'text-foreground/80' }}">
                        Home
                        <span class="absolute bottom-[6px] left-1/2 -translate-x-1/2 w-4 h-[2px] rounded-full bg-primary dark:bg-accent transition-all duration-300 origin-center {{ request()->routeIs('home') ? 'scale-x-100' : 'scale-x-0' }} group-hover:scale-x-100"></span>
                    </a>
                    
                    <!-- Bhutan Dropdown -->
                    <div class="group h-full flex items-center">
                        <button class="flex items-center gap-1 transition-all duration-300 hover:text-primary dark:hover:text-accent h-full {{ (request()->routeIs('tours*') || request()->routeIs('destinations*') || request()->routeIs('trekking*') || request()->routeIs('festivals*') || request()->routeIs('guide*')) && request()->route('slug') !== 'nepal' && request()->route('slug') !== 'tibet' ? 'text-primary dark:text-accent font-semibold' : 'text-foreground/80' }}">
                            <span>Bhutan</span>
                            <svg class="h-3 w-3 text-muted-foreground/80 transition-transform duration-300 group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <span class="absolute bottom-[6px] left-1/2 -translate-x-1/2 w-4 h-[2px] rounded-full bg-primary dark:bg-accent transition-all duration-300 origin-center {{ (request()->routeIs('tours*') || request()->routeIs('destinations*') || request()->routeIs('trekking*') || request()->routeIs('festivals*') || request()->routeIs('guide*')) && request()->route('slug') !== 'nepal' && request()->route('slug') !== 'tibet' ? 'scale-x-100' : 'scale-x-0' }} group-hover:scale-x-100"></span>
                        
                        <!-- Dropdown panel with bridge hover wrapper -->
                        <div class="absolute left-1/2 -translate-x-1/2 top-full pt-2 opacity-0 invisible translate-y-2 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 transition-all duration-300 z-50">
                            <div class="w-[840px] rounded-2xl border border-border bg-popover/95 dark:bg-card/95 backdrop-blur-2xl shadow-2xl p-6 grid grid-cols-3 gap-6">
                                <!-- Left Column: Tour Packages -->
                                <div class="space-y-4 border-r border-border/50 dark:border-border/20 pr-4">
                                    <span class="text-[10px] font-bold text-muted-foreground uppercase tracking-widest block border-b border-border/40 pb-1.5">Tour Packages</span>
                                    <div class="flex flex-col space-y-1">
                                        <a href="{{ route('tours') }}" class="group/item flex items-start gap-2.5 p-1.5 rounded-lg hover:bg-muted/50 transition-colors">
                                            <div class="h-7 w-7 rounded-md bg-primary/10 text-primary dark:text-accent dark:bg-accent/10 flex items-center justify-center shrink-0 group-hover/item:scale-110 transition-transform">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                                            </div>
                                            <div>
                                                <span class="block text-xs font-semibold text-foreground group-hover/item:text-primary dark:group-hover/item:text-accent transition-colors">All Packages</span>
                                                <span class="text-[10px] text-muted-foreground block leading-tight">Browse our complete list of itineraries</span>
                                            </div>
                                        </a>
                                        
                                        @foreach($categories as $cat)
                                            @php
                                                $catIcons = [
                                                    'cultural' => '<svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>',
                                                    'trekking' => '<svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>',
                                                    'festival' => '<svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/></svg>',
                                                    'hiking' => '<svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>',
                                                    'homestay' => '<svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>',
                                                    'special' => '<svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>',
                                                ];
                                                $catDesc = [
                                                    'cultural' => 'Ancient monasteries & heritage',
                                                    'trekking' => 'High-altitude mountain treks',
                                                    'festival' => 'Vibrant mask dances & Tsechus',
                                                    'hiking' => 'Scenic day walks in woods',
                                                    'homestay' => 'Stay in authentic local farmhouses',
                                                    'special' => 'Bird watching & photo tours',
                                                ];
                                                $icon = $catIcons[$cat->slug] ?? $catIcons['cultural'];
                                                $desc = $catDesc[$cat->slug] ?? 'Custom handpicked package';
                                                
                                                $badge = null;
                                                if ($cat->slug === 'cultural') {
                                                    $badge = '<span class="inline-flex items-center rounded bg-emerald-500/10 dark:bg-emerald-500/25 px-1 py-0.5 text-[8px] font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-wide shrink-0 leading-none">Popular</span>';
                                                } elseif ($cat->slug === 'trekking') {
                                                    $badge = '<span class="inline-flex items-center rounded bg-accent/15 px-1 py-0.5 text-[8px] font-bold text-accent uppercase tracking-wide shrink-0 leading-none">Epic</span>';
                                                }
                                            @endphp
                                            <a href="{{ route('tours.category', ['slug' => $cat->slug]) }}" class="group/item flex items-start gap-2.5 p-1.5 rounded-lg hover:bg-muted/50 transition-colors">
                                                <div class="h-7 w-7 rounded-md bg-primary/10 text-primary dark:text-accent dark:bg-accent/10 flex items-center justify-center shrink-0 group-hover/item:scale-110 transition-transform">
                                                    {!! $icon !!}
                                                </div>
                                                <div>
                                                    <span class="block text-xs font-semibold text-foreground group-hover/item:text-primary dark:group-hover/item:text-accent transition-colors flex items-center gap-1.5">
                                                        {{ $cat->title }}
                                                        @if($badge) {!! $badge !!} @endif
                                                    </span>
                                                    <span class="text-[10px] text-muted-foreground block leading-tight">{{ $desc }}</span>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                                
                                <!-- Middle Column: Scenic Valleys -->
                                <div class="space-y-4 border-r border-border/50 dark:border-border/20 pr-4">
                                    <span class="text-[10px] font-bold text-muted-foreground uppercase tracking-widest block border-b border-border/40 pb-1.5">Scenic Valleys</span>
                                    <div class="grid grid-cols-1 gap-1.5">
                                        @foreach($bhutanDest as $dest)
                                            @php
                                                $valIcons = [
                                                    'paro' => '<svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>',
                                                    'thimphu' => '<svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>',
                                                    'punakha' => '<svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>',
                                                    'bumthang' => '<svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>',
                                                    'haa-valley' => '<svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>',
                                                    'phobjikha' => '<svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m12.728 12.728l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/></svg>',
                                                ];
                                                $valD = [
                                                    'paro' => 'Gateway town, Tiger\'s Nest',
                                                    'thimphu' => 'The vibrant Himalayan capital',
                                                    'punakha' => 'Grand Dzong & warm climate',
                                                    'bumthang' => 'Spiritual heart & Swiss farm',
                                                    'haa-valley' => 'Traditional, remote borderlands',
                                                    'phobjikha' => 'Glacial vale, rare Cranes',
                                                    'eastern-bhutan' => 'Untracked hills & weaving'
                                                ];
                                                $icon = $valIcons[$dest->slug] ?? '<svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>';
                                                $desc = $valD[$dest->slug] ?? 'Explore Bhutanese valley';
                                            @endphp
                                            <a href="{{ route('destinations.show', ['slug' => $dest->slug]) }}" class="group/item flex items-center gap-2.5 p-1 rounded-lg hover:bg-muted/50 transition-colors">
                                                <div class="text-muted-foreground group-hover/item:text-primary dark:group-hover/item:text-accent transition-colors shrink-0">
                                                    {!! $icon !!}
                                                </div>
                                                <div class="min-w-0">
                                                    <span class="block text-xs font-semibold text-foreground group-hover/item:text-primary dark:group-hover/item:text-accent transition-colors truncate">{{ $dest->title }}</span>
                                                    <span class="text-[9px] text-muted-foreground block truncate leading-none mt-0.5">{{ $desc }}</span>
                                                </div>
                                            </a>
                                        @endforeach
                                        <a href="{{ route('destinations') }}" class="group/item flex items-center justify-between p-1.5 rounded-lg bg-muted/40 hover:bg-muted/80 transition-colors mt-1">
                                            <span class="text-[11px] font-bold text-foreground">Explore All Valleys</span>
                                            <svg class="h-3.5 w-3.5 text-muted-foreground group-hover/item:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                                        </a>
                                    </div>
                                </div>
                                
                                <!-- Right Column: Resources & Guides + Custom CTA -->
                                <div class="space-y-4 flex flex-col justify-between h-full">
                                    <div class="space-y-3">
                                        <span class="text-[10px] font-bold text-muted-foreground uppercase tracking-widest block border-b border-border/40 pb-1.5">Traveler Resources</span>
                                        <div class="flex flex-col space-y-1">
                                            <a href="{{ route('trekking') }}" class="group/item flex items-start gap-2.5 p-1.5 rounded-lg hover:bg-muted/50 transition-colors">
                                                <div class="h-7 w-7 rounded-md bg-primary/10 text-primary dark:text-accent dark:bg-accent/10 flex items-center justify-center shrink-0 group-hover/item:scale-110 transition-transform">
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                                                </div>
                                                <div>
                                                    <span class="block text-xs font-semibold text-foreground group-hover/item:text-primary dark:group-hover/item:text-accent transition-colors">Trekking Guides</span>
                                                    <span class="text-[10px] text-muted-foreground block leading-tight">Altitude details, trails & maps</span>
                                                </div>
                                            </a>
                                            <a href="{{ route('festivals') }}" class="group/item flex items-start gap-2.5 p-1.5 rounded-lg hover:bg-muted/50 transition-colors">
                                                <div class="h-7 w-7 rounded-md bg-primary/10 text-primary dark:text-accent dark:bg-accent/10 flex items-center justify-center shrink-0 group-hover/item:scale-110 transition-transform">
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                </div>
                                                <div>
                                                    <span class="block text-xs font-semibold text-foreground group-hover/item:text-primary dark:group-hover/item:text-accent transition-colors">Festival Calendar</span>
                                                    <span class="text-[10px] text-muted-foreground block leading-tight">Plan dates around masked dances</span>
                                                </div>
                                            </a>
                                            <a href="{{ route('guide') }}" class="group/item flex items-start gap-2.5 p-1.5 rounded-lg hover:bg-muted/50 transition-colors">
                                                <div class="h-7 w-7 rounded-md bg-primary/10 text-primary dark:text-accent dark:bg-accent/10 flex items-center justify-center shrink-0 group-hover/item:scale-110 transition-transform">
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                                </div>
                                                <div>
                                                    <span class="block text-xs font-semibold text-foreground group-hover/item:text-primary dark:group-hover/item:text-accent transition-colors">Travel Blog & Tips</span>
                                                    <span class="text-[10px] text-muted-foreground block leading-tight">Expert preparation & local insights</span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    
                                    <!-- Tailor-Made CTA Card -->
                                    <div class="relative overflow-hidden rounded-xl border border-primary/20 bg-gradient-to-br from-primary/5 via-accent/5 to-transparent p-4 mt-2">
                                        <!-- Abstract gradient background blur -->
                                        <div class="absolute -right-10 -bottom-10 h-24 w-24 rounded-full bg-accent/15 blur-2xl"></div>
                                        <div class="relative z-10 space-y-1.5">
                                            <span class="inline-flex items-center gap-1 rounded bg-accent/10 px-2 py-0.5 text-[8px] font-bold text-accent uppercase tracking-wider leading-none">Tailor-Made</span>
                                            <h4 class="text-xs font-bold text-foreground">Custom Bhutan Journeys</h4>
                                            <p class="text-[10px] text-muted-foreground leading-normal">
                                                Design a custom itinerary tailored specifically to your interests, pace, and budget.
                                            </p>
                                            <a href="{{ route('contact') }}" class="inline-flex items-center gap-1 text-[10px] font-bold text-primary dark:text-accent hover:underline pt-1 group/cta">
                                                Build your itinerary
                                                <svg class="h-3 w-3 transition-transform group-hover/cta:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
 
                    <!-- Nepal Link -->
                    @if($nepalDest)
                        <a href="{{ route('destinations.show', ['slug' => $nepalDest->slug]) }}" class="group relative h-full flex items-center transition-all duration-300 hover:text-primary dark:hover:text-accent {{ request()->routeIs('destinations.show') && request()->route('slug') === 'nepal' ? 'text-primary dark:text-accent font-semibold' : 'text-foreground/80' }}">
                            Nepal
                            <span class="absolute bottom-[6px] left-1/2 -translate-x-1/2 w-4 h-[2px] rounded-full bg-primary dark:bg-accent transition-all duration-300 origin-center {{ request()->routeIs('destinations.show') && request()->route('slug') === 'nepal' ? 'scale-x-100' : 'scale-x-0' }} group-hover:scale-x-100"></span>
                        </a>
                    @endif
 
                    <!-- Tibet Link -->
                    @if($tibetDest)
                        <a href="{{ route('destinations.show', ['slug' => $tibetDest->slug]) }}" class="group relative h-full flex items-center transition-all duration-300 hover:text-primary dark:hover:text-accent {{ request()->routeIs('destinations.show') && request()->route('slug') === 'tibet' ? 'text-primary dark:text-accent font-semibold' : 'text-foreground/80' }}">
                            Tibet
                            <span class="absolute bottom-[6px] left-1/2 -translate-x-1/2 w-4 h-[2px] rounded-full bg-primary dark:bg-accent transition-all duration-300 origin-center {{ request()->routeIs('destinations.show') && request()->route('slug') === 'tibet' ? 'scale-x-100' : 'scale-x-0' }} group-hover:scale-x-100"></span>
                        </a>
                    @endif
 
                    <!-- Traveler Info Dropdown -->
                    <div class="relative group h-full flex items-center">
                        <button class="flex items-center gap-1 transition-all duration-300 hover:text-primary dark:hover:text-accent h-full {{ (request()->routeIs('info*') || request()->routeIs('about*')) ? 'text-primary dark:text-accent font-semibold' : 'text-foreground/80' }}">
                            <span>Traveler Info</span>
                            <svg class="h-3 w-3 text-muted-foreground/80 transition-transform duration-300 group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <span class="absolute bottom-[6px] left-1/2 -translate-x-1/2 w-4 h-[2px] rounded-full bg-primary dark:bg-accent transition-all duration-300 origin-center {{ (request()->routeIs('info*') || request()->routeIs('about*')) ? 'scale-x-100' : 'scale-x-0' }} group-hover:scale-x-100"></span>
                        
                        <!-- Dropdown panel with bridge hover wrapper -->
                        <div class="absolute right-0 md:-right-4 top-full pt-2 opacity-0 invisible translate-y-2 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 transition-all duration-300 z-50">
                            <div class="w-80 rounded-2xl border border-border bg-popover/95 dark:bg-card/95 backdrop-blur-2xl shadow-xl p-2 flex flex-col gap-1">
                                <a href="{{ route('info', 'bhutanese-visa') }}" class="group/infoitem flex items-start gap-2.5 p-2 rounded-md hover:bg-muted/60 transition-colors">
                                    <div class="text-muted-foreground group-hover/infoitem:text-primary dark:group-hover/infoitem:text-accent shrink-0 pt-0.5">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-5l-2-2z"/></svg>
                                    </div>
                                    <div>
                                        <span class="block text-xs font-semibold text-foreground group-hover/infoitem:text-primary dark:group-hover/infoitem:text-accent">Planning & Visa Guide</span>
                                        <span class="text-[10px] text-muted-foreground block leading-tight">SDF requirements, procedures & clearances</span>
                                    </div>
                                </a>
                                <a href="{{ route('info', 'bhutan-tourism-policy-and-sdf') }}" class="group/infoitem flex items-start gap-2.5 p-2 rounded-md hover:bg-muted/60 transition-colors font-sans">
                                    <div class="text-muted-foreground group-hover/infoitem:text-primary dark:group-hover/infoitem:text-accent shrink-0 pt-0.5">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <div>
                                        <span class="block text-xs font-semibold text-foreground group-hover/infoitem:text-primary dark:group-hover/infoitem:text-accent">Tourism Policy & SDF</span>
                                        <span class="text-[10px] text-muted-foreground block leading-tight">Understanding the daily tourist fee</span>
                                    </div>
                                </a>
                                <a href="{{ route('info', 'bhutan-international-airlines') }}" class="group/infoitem flex items-start gap-2.5 p-2 rounded-md hover:bg-muted/60 transition-colors font-sans">
                                    <div class="text-muted-foreground group-hover/infoitem:text-primary dark:group-hover/infoitem:text-accent shrink-0 pt-0.5">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                                    </div>
                                    <div>
                                        <span class="block text-xs font-semibold text-foreground group-hover/infoitem:text-primary dark:group-hover/infoitem:text-accent">Flight Connections</span>
                                        <span class="text-[10px] text-muted-foreground block leading-tight">Drukair and Bhutan Airlines schedules</span>
                                    </div>
                                </a>
                                <a href="{{ route('info', 'bhutan-tour-payment') }}" class="group/infoitem flex items-start gap-2.5 p-2 rounded-md hover:bg-muted/60 transition-colors font-sans">
                                    <div class="text-muted-foreground group-hover/infoitem:text-primary dark:group-hover/infoitem:text-accent shrink-0 pt-0.5">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                    </div>
                                    <div>
                                        <span class="block text-xs font-semibold text-foreground group-hover/infoitem:text-primary dark:group-hover/infoitem:text-accent">Tour Payment Methods</span>
                                        <span class="text-[10px] text-muted-foreground block leading-tight">Secured bank wire & card transfers</span>
                                    </div>
                                </a>
                                <a href="{{ route('info', 'best-time-to-visit-bhutan') }}" class="group/infoitem flex items-start gap-2.5 p-2 rounded-md hover:bg-muted/60 transition-colors font-sans">
                                    <div class="text-muted-foreground group-hover/infoitem:text-primary dark:group-hover/infoitem:text-accent shrink-0 pt-0.5">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m12.728 12.728l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/></svg>
                                    </div>
                                    <div>
                                        <span class="block text-xs font-semibold text-foreground group-hover/infoitem:text-primary dark:group-hover/infoitem:text-accent">Best Time to Visit</span>
                                        <span class="text-[10px] text-muted-foreground block leading-tight">Weather breakdowns and dynamic seasons</span>
                                    </div>
                                </a>
                                <a href="{{ route('info', 'hotels-in-bhutan') }}" class="group/infoitem flex items-start gap-2.5 p-2 rounded-md hover:bg-muted/60 transition-colors font-sans">
                                    <div class="text-muted-foreground group-hover/infoitem:text-primary dark:group-hover/infoitem:text-accent shrink-0 pt-0.5">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                    </div>
                                    <div>
                                        <span class="block text-xs font-semibold text-foreground group-hover/infoitem:text-primary dark:group-hover/infoitem:text-accent">Partner Hotels & Stays</span>
                                        <span class="text-[10px] text-muted-foreground block leading-tight">3-star comfort to luxury 5-star upgrades</span>
                                    </div>
                                </a>
                                <div class="border-t my-1 border-border/40"></div>
                                <a href="{{ route('about') }}" class="group/infoitem flex items-start gap-2.5 p-2 rounded-md hover:bg-muted/60 transition-colors font-sans">
                                    <div class="text-muted-foreground group-hover/infoitem:text-primary dark:group-hover/infoitem:text-accent shrink-0 pt-0.5">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                    </div>
                                    <div>
                                        <span class="block text-xs font-semibold text-foreground group-hover/infoitem:text-primary dark:group-hover/infoitem:text-accent">About Bhutan Culture</span>
                                        <span class="text-[10px] text-muted-foreground block leading-tight">People, population, architecture & history</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <a href="{{ route('gallery') }}" class="group relative h-full flex items-center transition-all duration-300 hover:text-primary dark:hover:text-accent {{ request()->routeIs('gallery') ? 'text-primary dark:text-accent font-semibold' : 'text-foreground/80' }}">
                        Gallery
                        <span class="absolute bottom-[6px] left-1/2 -translate-x-1/2 w-4 h-[2px] rounded-full bg-primary dark:bg-accent transition-all duration-300 origin-center {{ request()->routeIs('gallery') ? 'scale-x-100' : 'scale-x-0' }} group-hover:scale-x-100"></span>
                    </a>
                    <a href="{{ route('contact') }}" class="group relative h-full flex items-center transition-all duration-300 hover:text-primary dark:hover:text-accent {{ request()->routeIs('contact') ? 'text-primary dark:text-accent font-semibold' : 'text-foreground/80' }}">
                        Contact Us
                        <span class="absolute bottom-[6px] left-1/2 -translate-x-1/2 w-4 h-[2px] rounded-full bg-primary dark:bg-accent transition-all duration-300 origin-center {{ request()->routeIs('contact') ? 'scale-x-100' : 'scale-x-0' }} group-hover:scale-x-100"></span>
                    </a>
                </nav>

                <!-- Right: Actions / Controls Column -->
                <div class="flex items-center justify-end flex-1 gap-3">
                    <!-- Light/Dark Toggle (Disabled) -->
                    <button id="theme-toggle" type="button" aria-label="Toggle color theme" title="Toggle color theme" class="hidden h-9 w-9 items-center justify-center rounded-full border border-border/40 bg-secondary/50 dark:bg-secondary/20 hover:bg-secondary hover:text-foreground focus:outline-none focus:ring-2 focus:ring-ring text-sm transition-all duration-200 hover:scale-105 shadow-sm">
                        <!-- Dark Icon -->
                        <svg id="theme-toggle-dark-icon" class="hidden w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                        <!-- Light Icon -->
                        <svg id="theme-toggle-light-icon" class="hidden w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464a1 1 0 10-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                    </button>

                    <!-- Mobile Menu Button -->
                    <button id="mobile-menu-button" type="button" aria-label="Open navigation menu" title="Open navigation menu" class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-border/40 bg-secondary/50 dark:bg-secondary/20 hover:bg-secondary hover:text-foreground focus:outline-none focus:ring-2 focus:ring-ring text-sm lg:hidden transition-all duration-200 hover:scale-105 shadow-sm" onclick="toggleMobileMenu()">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden lg:hidden border-t border-border/50 bg-background px-4 pt-2 pb-4 space-y-1">
                <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-muted {{ request()->routeIs('home') ? 'bg-primary/10 text-primary dark:text-accent font-semibold' : 'text-muted-foreground' }}">Home</a>
                
                <!-- Mobile Dropdown: Bhutan -->
                <div class="space-y-1">
                    <button onclick="toggleMobileSub('mobile-bhutan-sub')" class="w-full flex items-center justify-between px-3 py-2 rounded-md text-base font-medium hover:bg-muted text-muted-foreground">
                        <span>Bhutan</span>
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div id="mobile-bhutan-sub" class="hidden pl-6 space-y-1 border-l-2 ml-4">
                        <span class="block px-3 py-1 text-xs text-muted-foreground/60 uppercase font-bold tracking-wider">Tour Packages</span>
                        <a href="{{ route('tours') }}" class="block px-3 py-1.5 text-sm text-muted-foreground hover:text-foreground font-semibold">All Tour Packages</a>
                        @foreach($categories as $cat)
                            <a href="{{ route('tours.category', ['slug' => $cat->slug]) }}" class="block px-3 py-1.5 text-sm text-muted-foreground hover:text-foreground">{{ $cat->title }}</a>
                        @endforeach
                        <div class="border-t my-1 border-border/40"></div>
                        <span class="block px-3 py-1 text-xs text-muted-foreground/60 uppercase font-bold tracking-wider">Scenic Valleys</span>
                        @foreach($bhutanDest as $dest)
                            <a href="{{ route('destinations.show', ['slug' => $dest->slug]) }}" class="block px-3 py-1.5 text-sm text-muted-foreground hover:text-foreground">{{ $dest->title }}</a>
                        @endforeach
                        <a href="{{ route('destinations') }}" class="block px-3 py-1.5 text-sm text-muted-foreground hover:text-foreground font-semibold border-t border-dashed mt-1">All Destinations</a>
                        <div class="border-t my-1 border-border/40"></div>
                        <span class="block px-3 py-1 text-xs text-muted-foreground/60 uppercase font-bold tracking-wider">Traveler Resources</span>
                        <a href="{{ route('trekking') }}" class="block px-3 py-1.5 text-sm text-muted-foreground hover:text-foreground">Trekking Guides</a>
                        <a href="{{ route('festivals') }}" class="block px-3 py-1.5 text-sm text-muted-foreground hover:text-foreground">Festival Calendar</a>
                        <a href="{{ route('guide') }}" class="block px-3 py-1.5 text-sm text-muted-foreground hover:text-foreground">Travel Blogs & Guides</a>
                    </div>
                </div>

                <!-- Nepal Link -->
                @if($nepalDest)
                    <a href="{{ route('destinations.show', ['slug' => $nepalDest->slug]) }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-muted {{ request()->routeIs('destinations.show') && request()->route('slug') === 'nepal' ? 'bg-primary/10 text-primary dark:text-accent font-semibold' : 'text-muted-foreground' }}">Nepal</a>
                @endif

                <!-- Tibet Link -->
                @if($tibetDest)
                    <a href="{{ route('destinations.show', ['slug' => $tibetDest->slug]) }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-muted {{ request()->routeIs('destinations.show') && request()->route('slug') === 'tibet' ? 'bg-primary/10 text-primary dark:text-accent font-semibold' : 'text-muted-foreground' }}">Tibet</a>
                @endif

                <!-- Mobile Dropdown: Travel Info -->
                <div class="space-y-1">
                    <button onclick="toggleMobileSub('mobile-info-sub')" class="w-full flex items-center justify-between px-3 py-2 rounded-md text-base font-medium hover:bg-muted text-muted-foreground">
                        <span>Traveler Info</span>
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div id="mobile-info-sub" class="hidden pl-6 space-y-1 border-l-2 ml-4">
                        <a href="{{ route('info', 'bhutanese-visa') }}" class="block px-3 py-2 text-sm text-muted-foreground hover:text-foreground">Travel Planning & Visa</a>
                        <a href="{{ route('info', 'bhutan-tourism-policy-and-sdf') }}" class="block px-3 py-2 text-sm text-muted-foreground hover:text-foreground">Tourism Policy & SDF</a>
                        <a href="{{ route('info', 'bhutan-international-airlines') }}" class="block px-3 py-2 text-sm text-muted-foreground hover:text-foreground">Flight Connections</a>
                        <a href="{{ route('info', 'bhutan-tour-payment') }}" class="block px-3 py-2 text-sm text-muted-foreground hover:text-foreground">Tour Payment Options</a>
                        <a href="{{ route('info', 'best-time-to-visit-bhutan') }}" class="block px-3 py-2 text-sm text-muted-foreground hover:text-foreground">Best Time to Visit</a>
                        <a href="{{ route('info', 'hotels-in-bhutan') }}" class="block px-3 py-2 text-sm text-muted-foreground hover:text-foreground">Partner Hotels & Stays</a>
                        <a href="{{ route('about') }}" class="block px-3 py-2 text-sm text-muted-foreground hover:text-foreground">About Bhutan Culture</a>
                    </div>
                </div>

                <a href="{{ route('gallery') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-muted {{ request()->routeIs('gallery') ? 'bg-primary/10 text-primary dark:text-accent font-semibold' : 'text-muted-foreground' }}">Gallery</a>
                <a href="{{ route('contact') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-muted {{ request()->routeIs('contact') ? 'bg-primary/10 text-primary dark:text-accent font-semibold' : 'text-muted-foreground' }}">Contact Us</a>
            </div>
        </header>

        <!-- Dynamic Breadcrumbs Bar -->
        @if(!request()->routeIs('home'))
            @php
                $crumbs = [];
                $routeName = request()->route() ? request()->route()->getName() : null;
                
                if (request()->routeIs('tours*')) {
                    $crumbs[] = ['label' => 'Tours', 'url' => route('tours')];
                    if (request()->routeIs('tours.category') && isset($categoryPage)) {
                        $crumbs[] = ['label' => $categoryPage->title, 'url' => null];
                    } elseif (request()->routeIs('tours.show') && isset($tour)) {
                        $crumbs[] = ['label' => ucfirst($tour->category) . ' Journeys', 'url' => route('tours.category', ['slug' => $tour->category])];
                        $crumbs[] = ['label' => $tour->title, 'url' => null];
                    }
                } elseif (request()->routeIs('destinations*')) {
                    $crumbs[] = ['label' => 'Destinations', 'url' => route('destinations')];
                    if (request()->routeIs('destinations.show') && isset($destination)) {
                        $crumbs[] = ['label' => $destination->title, 'url' => null];
                    }
                } elseif (request()->routeIs('trekking*')) {
                    $crumbs[] = ['label' => 'Trekking Guides', 'url' => null];
                } elseif (request()->routeIs('festivals*')) {
                    $crumbs[] = ['label' => 'Festival Calendar', 'url' => null];
                } elseif (request()->routeIs('guide*')) {
                    $crumbs[] = ['label' => 'Travel Blogs & Tips', 'url' => null];
                } elseif (request()->routeIs('gallery*')) {
                    $crumbs[] = ['label' => 'Photo Gallery', 'url' => null];
                } elseif (request()->routeIs('contact*')) {
                    $crumbs[] = ['label' => 'Contact Us', 'url' => null];
                } elseif (request()->routeIs('info*') && isset($pageData)) {
                    $crumbs[] = ['label' => 'Traveler Info', 'url' => null];
                    $crumbs[] = ['label' => $pageData['title'], 'url' => null];
                } elseif (request()->routeIs('about*')) {
                    $crumbs[] = ['label' => 'About Bhutan', 'url' => null];
                } else {
                    // Fallback using path segments
                    $segments = request()->segments();
                    $url = '';
                    foreach ($segments as $segment) {
                        $url .= '/' . $segment;
                        $label = ucwords(str_replace(['-', '_'], ' ', $segment));
                        $crumbs[] = ['label' => $label, 'url' => url($url)];
                    }
                    if (!empty($crumbs)) {
                        $crumbs[count($crumbs) - 1]['url'] = null;
                    }
                }
            @endphp
            
            <div class="bg-muted/30 border-b border-border/50 py-3">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center gap-1.5 text-xs font-semibold text-muted-foreground">
                    <a href="{{ route('home') }}" class="hover:text-foreground transition-colors">Home</a>
                    @foreach($crumbs as $crumb)
                        <svg class="h-3 w-3 text-muted-foreground/45 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                        @if($crumb['url'])
                            <a href="{{ $crumb['url'] }}" class="hover:text-foreground transition-colors">{{ $crumb['label'] }}</a>
                        @else
                            <span class="text-foreground truncate font-bold">{{ $crumb['label'] }}</span>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Main Content Slot -->
        <main class="flex-grow">
            @isset($header)
                <section class="border-b border-border bg-background">
                    <div class="mx-auto max-w-7xl px-4 py-5 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </section>
            @endisset

            @yield('content')
            @isset($slot)
                {{ $slot }}
            @endisset
        </main>

        <!-- Footer -->
        <footer class="bg-muted border-t border-border mt-auto py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Brand / Intro -->
                <div class="flex flex-col space-y-4">
                    <x-ui.logo />
                    <p class="text-sm text-muted-foreground leading-relaxed">
                        Licensed local tour operator in Thimphu, Bhutan, providing customized cultural, trekking, festival, and luxury experiences across the kingdom.
                    </p>
                </div>
                
                <!-- Quick Contact -->
                <div class="flex flex-col space-y-3 text-sm">
                    <span class="font-semibold text-foreground">Contact Us</span>
                    <div class="space-y-2 text-muted-foreground">
                        <p><strong>Contact Person:</strong> Chimi Dem</p>
                        <p><strong>Mobile:</strong> +975 17110720 / 77176677</p>
                        <p><strong>Tel/Fax:</strong> +975 2 339813 / 340820</p>
                        <p><strong>Email:</strong> accessbhutan@gmail.com</p>
                        <p><strong>Address:</strong> Changlam Rd, Thimphu, Bhutan</p>
                    </div>
                </div>

                <!-- Chat & Support -->
                <div class="flex flex-col space-y-3 text-sm">
                    <span class="font-semibold text-foreground">Instant Connect</span>
                    <div class="space-y-2 text-muted-foreground">
                        <p><strong>Wechat:</strong> chimibhutan</p>
                        <p><strong>Skype:</strong> talktoaccessbhutan</p>
                        <p><strong>KakaoTalk:</strong> +975 17110720</p>
                        <a href="https://wa.me/97517110720?text=Hi,I%20would%20like%20to%20visit%20Bhutan" target="_blank" class="inline-flex items-center text-primary dark:text-accent font-semibold hover:underline mt-1 gap-1">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.455L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.825 1.451 5.436 0 9.86-4.37 9.864-9.799.002-2.63-1.023-5.101-2.885-6.966a9.9 9.9 0 00-6.98-2.879c-5.433 0-9.859 4.37-9.863 9.8-.001 1.802.493 3.557 1.433 5.12l-1.01 3.687 3.791-.983c1.52.88 3.012 1.366 4.625 1.366zm10.742-6.52c-.29-.145-1.716-.848-1.977-.942-.26-.096-.45-.144-.64.145-.19.285-.736.942-.902 1.13-.165.19-.33.213-.62.068-1.282-.64-2.115-1.12-2.954-2.558-.22-.377.22-.35.63-1.164.07-.146.035-.272-.017-.378-.053-.105-.45-1.085-.616-1.485-.162-.39-.33-.336-.45-.342-.116-.006-.25-.006-.385-.006-.135 0-.355.05-.54.26-.185.21-.706.69-.706 1.685t.726 1.956c.074.1.15.2.227.3a19.7 19.7 0 004.148 4.148c.84.6 1.54.89 2.1.99.63.11 1.2.08 1.66.01.5-.08 1.53-.63 1.74-1.23.21-.6.21-1.11.15-1.22-.06-.11-.23-.155-.52-.3z"/></svg>
                            WhatsApp: +975-17110720
                        </a>
                    </div>
                </div>

                <!-- Accreditation & Verification -->
                <div class="flex flex-col space-y-4">
                    <span class="font-semibold text-foreground">Accreditation</span>
                    <p class="text-xs text-muted-foreground">Registered and recognized by Department of Tourism and ABTO.</p>
                    <div class="flex items-center gap-4 bg-background dark:bg-slate-800 p-2.5 rounded-lg border">
                        <span class="text-xs font-bold text-primary dark:text-accent tracking-widest border-r pr-3">TCB</span>
                        <span class="text-xs font-bold text-foreground tracking-widest">ABTO</span>
                    </div>
                </div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 border-t border-border mt-8 pt-8 flex flex-col md:flex-row justify-between items-center text-xs text-muted-foreground">
                <p>&copy; {{ date('Y') }} Access Bhutan. All Rights Reserved.</p>
                <p class="mt-2 md:mt-0">Web Redesign Powered by Laravel & Tailwind</p>
            </div>
        </footer>

        <!-- Theme script logic -->
        <script>
            const themeToggleBtn = document.getElementById('theme-toggle');
            const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
            const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

            // Change the icons inside the button based on previous settings
            if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                themeToggleLightIcon.classList.remove('hidden');
            } else {
                themeToggleDarkIcon.classList.remove('hidden');
            }

            themeToggleBtn.addEventListener('click', function() {
                // toggle icons inside button
                themeToggleDarkIcon.classList.toggle('hidden');
                themeToggleLightIcon.classList.toggle('hidden');

                // if set via local storage previously
                if (localStorage.getItem('color-theme')) {
                    if (localStorage.getItem('color-theme') === 'light') {
                        document.documentElement.classList.add('dark');
                        document.documentElement.classList.remove('light');
                        localStorage.setItem('color-theme', 'dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                        document.documentElement.classList.add('light');
                        localStorage.setItem('color-theme', 'light');
                    }
                // if NOT set via local storage previously
                } else {
                    if (document.documentElement.classList.contains('dark')) {
                        document.documentElement.classList.remove('dark');
                        document.documentElement.classList.add('light');
                        localStorage.setItem('color-theme', 'light');
                    } else {
                        document.documentElement.classList.add('dark');
                        document.documentElement.classList.remove('light');
                        localStorage.setItem('color-theme', 'dark');
                    }
                }
            });

            function toggleMobileMenu() {
                const menu = document.getElementById('mobile-menu');
                menu.classList.toggle('hidden');
            }

            function toggleMobileSub(id) {
                const sub = document.getElementById(id);
                if (sub) {
                    sub.classList.toggle('hidden');
                }
            }

            // Exit Intent Trigger
            document.addEventListener('DOMContentLoaded', () => {
                let exitIntentShown = sessionStorage.getItem('exit-intent-shown') || false;

                if (!exitIntentShown) {
                    document.addEventListener('mouseleave', (e) => {
                        // Triggers when user mouse leaves top of window (potential tab close / address bar focus)
                        if (e.clientY < 20) {
                            const modal = document.getElementById('exit-intent-modal');
                            if (modal && typeof modal.showModal === 'function') {
                                modal.showModal();
                                sessionStorage.setItem('exit-intent-shown', 'true');
                            }
                        }
                    });
                }

                // Scroll morphing header logic
                const header = document.getElementById('main-header');
                const headerContainer = document.getElementById('main-header-container');
                if (header && headerContainer) {
                    const handleScroll = () => {
                        if (window.scrollY > 15) {
                            header.classList.add('scrolled');
                            headerContainer.classList.add('scrolled');
                        } else {
                            header.classList.remove('scrolled');
                            headerContainer.classList.remove('scrolled');
                        }
                    };
                    window.addEventListener('scroll', handleScroll, { passive: true });
                    handleScroll(); // Trigger initially in case page is loaded already scrolled
                }
            });
        </script>

        <!-- Exit Intent Dialog Modal -->
        <x-ui.dialog id="exit-intent-modal" title="Wait! Don't Miss Out on Your Bhutan Journey" description="Planning a trip to Bhutan can be complex. Let our destination specialists design a custom itinerary tailored to your exact tastes.">
            <form action="{{ route('contact.submit') }}" method="POST" class="space-y-4">
                @csrf
                <div style="display: none !important;"><input type="text" name="website_verification_token" id="exit_website_verification_token" autocomplete="off" tabindex="-1"></div>
                <input type="hidden" name="package" value="Exit Intent Lead Capture">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label for="exit-name" class="text-xs font-semibold text-foreground uppercase">Your Name *</label>
                        <input type="text" name="name" id="exit-name" required class="flex h-9 w-full rounded-md border border-input bg-background px-3 py-1 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring">
                    </div>
                    <div class="space-y-1">
                        <label for="exit-email" class="text-xs font-semibold text-foreground uppercase">Email Address *</label>
                        <input type="email" name="email" id="exit-email" required class="flex h-9 w-full rounded-md border border-input bg-background px-3 py-1 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring">
                    </div>
                </div>

                <div class="space-y-1">
                    <label for="exit-phone" class="text-xs font-semibold text-foreground uppercase">Phone Number (Optional)</label>
                    <input type="text" name="phone" id="exit-phone" class="flex h-9 w-full rounded-md border border-input bg-background px-3 py-1 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring">
                </div>

                <div class="space-y-1">
                    <label for="exit-message" class="text-xs font-semibold text-foreground uppercase">What interests you about Bhutan? *</label>
                    <textarea name="message" id="exit-message" rows="3" required placeholder="Describe your dream trip or ask any questions about SDF, visas, or packages..." class="flex min-h-[60px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"></textarea>
                </div>

                <div class="flex flex-col sm:flex-row items-center justify-between pt-4 border-t border-border mt-6 gap-4">
                    <span class="text-xs text-muted-foreground text-center sm:text-left">Free 24hr response from Chimi Dem.</span>
                    <x-ui.button type="submit" class="w-full sm:w-auto">
                        Get a Free Consultation
                    </x-ui.button>
                </div>
            </form>
        </x-ui.dialog>
    </body>
</html>
