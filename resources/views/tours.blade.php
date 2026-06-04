@extends('layouts.app')

@section('title', 'Tour Packages - Access Bhutan Tours & Treks')
@section('meta_description', 'Explore our hand-crafted, customizable Bhutan tour packages. From cultural sightseeing and hikes to high-altitude treks and local festival journeys.')
@section('meta_keywords', 'Bhutan tour packages, Bhutan itineraries, Bhutan cultural tours, Tiger\'s nest hike, Bhutan group departures')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Header -->
    <div class="text-center md:text-left mb-10 space-y-2">
        <h1 class="text-4xl font-bold font-serif text-foreground">Explore Bhutan Tour Packages</h1>
        <p class="text-muted-foreground text-base max-w-xl">
            Choose from our pre-designed itineraries or use them as a starting point to craft your own custom tour.
        </p>
    </div>

    <!-- Search & Filters Toolbar -->
    <div class="flex flex-col gap-6 md:flex-row md:items-center justify-between pb-8 border-b border-border">
        <!-- Category Filters (Shadcn-Style Tab list) -->
        <div class="flex overflow-x-auto whitespace-nowrap bg-muted p-1 rounded-lg border max-w-max gap-1 no-scrollbar" id="category-filters">
            <button data-cat-filter="all" class="px-4 py-2 text-sm font-medium rounded-md transition-colors bg-background text-foreground shadow-sm">All Tours</button>
            <button data-cat-filter="cultural" class="px-4 py-2 text-sm font-medium rounded-md transition-colors text-muted-foreground hover:text-foreground">Cultural</button>
            <button data-cat-filter="trekking" class="px-4 py-2 text-sm font-medium rounded-md transition-colors text-muted-foreground hover:text-foreground">Trekking</button>
            <button data-cat-filter="festival" class="px-4 py-2 text-sm font-medium rounded-md transition-colors text-muted-foreground hover:text-foreground">Festivals</button>
            <button data-cat-filter="hiking" class="px-4 py-2 text-sm font-medium rounded-md transition-colors text-muted-foreground hover:text-foreground">Hiking</button>
            <button data-cat-filter="homestay" class="px-4 py-2 text-sm font-medium rounded-md transition-colors text-muted-foreground hover:text-foreground">Homestays</button>
            <button data-cat-filter="special" class="px-4 py-2 text-sm font-medium rounded-md transition-colors text-muted-foreground hover:text-foreground">Special</button>
        </div>

        <!-- Keyword Search Input -->
        <div class="relative w-full md:max-w-xs">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-muted-foreground">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </span>
            <input 
                type="text" 
                id="search-input" 
                placeholder="Search tours..." 
                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 pl-10 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
            >
        </div>
    </div>

    <!-- Tours Counter & Results -->
    <div class="py-6 flex items-center justify-between text-sm text-muted-foreground">
        <p><span id="count-display">0</span> tours found</p>
    </div>

    <!-- Tours Grid -->
    <div id="tours-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 min-h-[300px]">
        <!-- Loading placeholder -->
        <div class="col-span-full text-center py-20 text-muted-foreground">Loading tours catalog...</div>
    </div>
</div>

<!-- Floating Saved Favorites FAB -->
<div class="fixed bottom-6 right-6 z-30">
    <button 
        onclick="document.getElementById('favorites-sheet').showModal()" 
        class="flex items-center gap-2 bg-primary dark:bg-accent text-primary-foreground dark:text-accent-foreground px-4 py-3 rounded-full shadow-lg hover:shadow-xl hover:scale-105 active:scale-95 transition-all duration-300 font-semibold text-sm animate-bounce"
        style="animation-duration: 3s;"
    >
        <svg class="h-4.5 w-4.5 text-red-500 fill-current" viewBox="0 0 24 24" style="width: 1.125rem; height: 1.125rem;">
            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
        </svg>
        <span>Saved Journeys (<span id="saved-count">0</span>)</span>
    </button>
</div>

<!-- Favorites Drawer Sheet -->
<x-ui.sheet id="favorites-sheet" title="Your Saved Journeys" description="Compare your bookmarked travel packages and request a combined custom quote.">
    <div id="saved-list" class="space-y-4">
        <p class="text-sm text-muted-foreground text-center py-8">No saved journeys yet. Click the heart icon on any tour package to save it here!</p>
    </div>
    
    <div id="saved-actions" class="border-t pt-4 mt-6 hidden">
        <form action="{{ route('contact') }}" method="GET" class="space-y-3">
            <input type="hidden" name="custom_packages" id="custom-packages-input" value="">
            <x-ui.button type="submit" class="w-full">
                Plan Custom Trip with Favorites
            </x-ui.button>
        </form>
        <button onclick="clearAllFavorites()" class="text-xs text-muted-foreground hover:text-destructive w-full text-center mt-3 font-semibold underline">
            Clear all saved
        </button>
    </div>
</x-ui.sheet>

<!-- JSON Data Injection -->
<script>
    window.toursData = @json($tours);
</script>

<!-- Vanilla JS Controller -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const tours = window.toursData || [];
        const grid = document.getElementById('tours-grid');
        const countDisplay = document.getElementById('count-display');
        const searchInput = document.getElementById('search-input');
        const filterButtons = document.querySelectorAll('[data-cat-filter]');
        
        let activeCategory = 'all';
        let searchQuery = '';

        // Read initial category from URL query parameters if present
        const urlParams = new URLSearchParams(window.location.search);
        const catParam = urlParams.get('cat');
        if (catParam) {
            activeCategory = catParam;
            // Update active state in UI
            filterButtons.forEach(btn => {
                const btnCat = btn.getAttribute('data-cat-filter');
                if (btnCat === activeCategory) {
                    btn.className = "px-4 py-2 text-sm font-medium rounded-md transition-colors bg-background text-foreground shadow-sm";
                } else {
                    btn.className = "px-4 py-2 text-sm font-medium rounded-md transition-colors text-muted-foreground hover:text-foreground";
                }
            });
        }

        // Render tours grid
        function render() {
            const saved = JSON.parse(localStorage.getItem('savedTours') || '[]');

            // Filter
            const filtered = tours.filter(tour => {
                const matchesCat = activeCategory === 'all' || tour.category === activeCategory;
                const matchesSearch = searchQuery === '' || 
                    tour.title.toLowerCase().includes(searchQuery.toLowerCase()) ||
                    tour.content_text.toLowerCase().includes(searchQuery.toLowerCase());
                return matchesCat && matchesSearch;
            });

            // Update count
            countDisplay.innerText = filtered.length;

            if (filtered.length === 0) {
                grid.innerHTML = `
                    <div class="col-span-full flex flex-col items-center justify-center py-20 text-center space-y-4">
                        <svg class="h-10 w-10 text-muted-foreground" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-muted-foreground font-medium">No tour packages match your criteria.</p>
                        <button onclick="resetFilters()" class="text-sm font-semibold text-primary dark:text-accent hover:underline">Reset search and filters</button>
                    </div>
                `;
                return;
            }

            // Build HTML
            grid.innerHTML = filtered.map(tour => {
                let badgeColor = 'bg-primary/10 text-primary dark:text-primary-foreground';
                if (tour.category === 'trekking') badgeColor = 'bg-cyan-500/10 text-cyan-600 dark:text-cyan-400';
                else if (tour.category === 'festival') badgeColor = 'bg-amber-500/10 text-amber-600 dark:text-amber-400';
                else if (tour.category === 'hiking') badgeColor = 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400';
                else if (tour.category === 'homestay') badgeColor = 'bg-indigo-500/10 text-indigo-600 dark:text-indigo-400';
                else if (tour.category === 'special') badgeColor = 'bg-rose-500/10 text-rose-600 dark:text-rose-400';

                const isBookmarked = saved.includes(tour.slug);
                const heartFill = isBookmarked ? 'currentColor' : 'none';
                const heartColorClass = isBookmarked ? 'text-red-500' : 'text-muted-foreground hover:text-red-500';

                return `
                    <div class="relative rounded-lg border bg-card text-card-foreground shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between h-[360px] overflow-hidden">
                        <!-- Bookmark Toggle Button -->
                        <button 
                            onclick="toggleFavorite('${tour.slug}')" 
                            class="absolute top-4 right-4 z-10 p-2 bg-background/90 hover:bg-background rounded-full border border-border/80 shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-ring"
                            title="${isBookmarked ? 'Remove from Saved' : 'Save Itinerary'}"
                        >
                            <svg class="h-3.5 w-3.5 ${heartColorClass}" fill="${heartFill}" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </button>

                        <!-- Top details -->
                        <div class="p-6 pr-12 space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold uppercase tracking-wider ${badgeColor}">
                                    ${tour.category}
                                </span>
                                <span class="text-xs font-medium text-muted-foreground flex items-center gap-1">
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    ${tour.duration}
                                </span>
                            </div>
                            <h3 class="text-lg font-bold font-serif leading-tight text-foreground line-clamp-2" title="${tour.title}">
                                <a href="/tours/${tour.slug}" class="hover:text-primary dark:hover:text-accent">
                                    ${tour.title}
                                </a>
                            </h3>
                            <p class="text-sm text-muted-foreground leading-relaxed line-clamp-4">
                                ${tour.snippet}
                            </p>
                        </div>
                        
                        <!-- Bottom Action -->
                        <div class="flex items-center justify-between px-6 pb-6 border-t mt-auto pt-4 border-muted/50">
                            <a 
                                href="/tours/${tour.slug}" 
                                class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-semibold ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 bg-secondary text-secondary-foreground hover:bg-secondary/80 h-9 px-3 w-full"
                            >
                                View Itinerary
                            </a>
                        </div>
                    </div>
                `;
            }).join('');
        }

        // Initialize Filter triggers
        filterButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                // Update active trigger styling
                filterButtons.forEach(b => {
                    b.className = "px-4 py-2 text-sm font-medium rounded-md transition-colors text-muted-foreground hover:text-foreground";
                });
                btn.className = "px-4 py-2 text-sm font-medium rounded-md transition-colors bg-background text-foreground shadow-sm";
                
                activeCategory = btn.getAttribute('data-cat-filter');

                // Update URL query parameters to make category selections bookmarkable/shareable
                const newUrl = new URL(window.location.href);
                if (activeCategory === 'all') {
                    newUrl.searchParams.delete('cat');
                } else {
                    newUrl.searchParams.set('cat', activeCategory);
                }
                window.history.pushState({}, '', newUrl);

                render();
            });
        });

        // Search trigger
        searchInput.addEventListener('input', (e) => {
            searchQuery = e.target.value;
            render();
        });

        // Reset helpers
        window.resetFilters = () => {
            activeCategory = 'all';
            searchQuery = '';
            searchInput.value = '';
            
            filterButtons.forEach(b => {
                b.className = "px-4 py-2 text-sm font-medium rounded-md transition-colors text-muted-foreground hover:text-foreground";
            });
            document.querySelector('[data-cat-filter="all"]').className = "px-4 py-2 text-sm font-medium rounded-md transition-colors bg-background text-foreground shadow-sm";
            
            // Clear URL parameters on reset
            const newUrl = new URL(window.location.href);
            newUrl.searchParams.delete('cat');
            window.history.pushState({}, '', newUrl);

            render();
        };

        // Toggle Bookmark state
        window.toggleFavorite = (slug) => {
            let saved = JSON.parse(localStorage.getItem('savedTours') || '[]');
            if (saved.includes(slug)) {
                saved = saved.filter(s => s !== slug);
            } else {
                saved.push(slug);
            }
            localStorage.setItem('savedTours', JSON.stringify(saved));
            updateFavoritesUI();
            render();
        };

        // Clear all Bookmarks
        window.clearAllFavorites = () => {
            localStorage.setItem('savedTours', JSON.stringify([]));
            updateFavoritesUI();
            render();
        };

        // Update Bookmarks Sheet UI
        function updateFavoritesUI() {
            const saved = JSON.parse(localStorage.getItem('savedTours') || '[]');
            
            // Update counter labels
            const counts = document.querySelectorAll('#saved-count');
            counts.forEach(el => el.innerText = saved.length);

            const listEl = document.getElementById('saved-list');
            const actionsEl = document.getElementById('saved-actions');
            const inputEl = document.getElementById('custom-packages-input');

            if (saved.length === 0) {
                listEl.innerHTML = `<p class="text-sm text-muted-foreground text-center py-8">No saved journeys yet. Click the heart icon on any tour package to save it here!</p>`;
                actionsEl.classList.add('hidden');
                if (inputEl) inputEl.value = '';
                return;
            }

            actionsEl.classList.remove('hidden');
            if (inputEl) {
                const titles = saved.map(slug => {
                    const found = tours.find(t => t.slug === slug);
                    return found ? found.title : slug;
                });
                inputEl.value = titles.join(', ');
            }

            listEl.innerHTML = saved.map(slug => {
                const tour = tours.find(t => t.slug === slug);
                if (!tour) return '';
                return `
                    <div class="border rounded-lg p-4 bg-muted/40 flex justify-between items-start gap-4">
                        <div class="space-y-1 min-w-0">
                            <span class="text-[10px] font-semibold uppercase tracking-wider text-primary dark:text-accent">${tour.duration} • ${tour.category}</span>
                            <h4 class="text-sm font-bold text-foreground truncate"><a href="/tours/${tour.slug}" class="hover:underline">${tour.title}</a></h4>
                            <p class="text-xs text-muted-foreground line-clamp-2 leading-relaxed">${tour.snippet}</p>
                        </div>
                        <button 
                            onclick="toggleFavorite('${tour.slug}')" 
                            class="text-muted-foreground hover:text-destructive shrink-0 p-1.5 hover:bg-muted rounded transition-colors"
                            title="Remove Favorite"
                        >
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                `;
            }).join('');
        }

        // Render initially
        updateFavoritesUI();
        render();
    });
</script>
@endsection
