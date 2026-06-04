@extends('layouts.app')

@section('title', $homePage->title ?? 'Access Bhutan Tours & Treks - Trusted Local Tour Operator')
@section('meta_description', $homePage->description ?? 'Plan your luxury Bhutan journey with Access Bhutan Tours & Treks. Over 20 years of expert local operators, customizable itineraries, culture tours, and treks.')
@section('meta_keywords', $homePage->keywords ?? 'Bhutan travel operator, Access Bhutan Tours, Bhutan tours, Bhutan treks, custom Bhutan itinerary, travel to Bhutan')

@section('seo_schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "TravelAgency",
  "name": "Access Bhutan Tours & Treks",
  "image": "{{ $homeHero['image'] }}",
  "url": "{{ route('home') }}",
  "telephone": "+97517110720",
  "email": "accessbhutan@gmail.com",
  "address": {
    "@@type": "PostalAddress",
    "streetAddress": "Changlam Rd",
    "addressLocality": "Thimphu",
    "addressCountry": "Bhutan"
  },
  "sameAs": [
    "https://wa.me/97517110720"
  ],
  "founder": {
    "@@type": "Person",
    "name": "Chimi Dem"
  },
  "areaServed": ["Bhutan", "Nepal", "Tibet"],
  "priceRange": "$$"
}
</script>
@endsection

@section('content')
<!-- Hero Section -->
<div class="relative overflow-hidden bg-slate-950 text-white py-24 sm:py-32">
    <!-- Background overlay gradient -->
    @if($homeHero['image'])
        <div class="absolute inset-0 z-0 bg-cover bg-center opacity-40 select-none pointer-events-none" style="background-image: url('{{ $homeHero['image'] }}')"></div>
    @endif
    <div class="absolute inset-0 z-0 bg-gradient-to-t from-background via-transparent to-transparent"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center flex flex-col items-center">
        <span class="inline-flex items-center gap-1.5 rounded-full bg-accent/25 px-3 py-1 text-xs font-semibold text-accent border border-accent/30 tracking-wide uppercase mb-6">
            {{ $homeHero['eyebrow'] }}
        </span>
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold font-serif tracking-tight text-white max-w-4xl leading-tight">
            {{ $homeHero['title'] }}
        </h1>
        <p class="mt-6 text-lg sm:text-xl text-slate-300 max-w-2xl leading-relaxed">
            {{ $homeHero['description'] }}
        </p>
        <div class="mt-10 flex flex-wrap gap-4 justify-center">
            <x-ui.button href="{{ route('tours') }}" variant="accent" size="lg" class="shadow-lg">
                Explore Tour Packages
            </x-ui.button>
            <x-ui.button href="{{ route('contact') }}" variant="hero-outline" size="lg">
                Plan Your Journey
            </x-ui.button>
        </div>
    </div>
</div>

<!-- Welcome Section -->
<section class="py-16 sm:py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <!-- Content -->
        <div class="space-y-6">
            <span class="text-sm font-semibold tracking-wider text-primary dark:text-accent uppercase">
                About Access Bhutan Tours
            </span>
            @if($homePage && $homePage->content_html && strlen($homePage->content_html) > 100)
                <div id="homepage-welcome-content" class="prose prose-slate dark:prose-invert max-w-none text-muted-foreground leading-relaxed text-sm sm:text-base space-y-4">
                    {!! $homePage->content_html !!}
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        const container = document.getElementById('homepage-welcome-content');
                        if (container) {
                            container.querySelectorAll('img').forEach(img => img.className = "rounded-lg border shadow-sm my-4 max-w-full mx-auto");
                            container.querySelectorAll('a').forEach(a => a.className = "text-primary dark:text-accent font-semibold hover:underline");
                        }
                    });
                </script>
            @else
                <h2 class="text-3xl sm:text-4xl font-bold font-serif text-foreground leading-tight">
                    Trusted Local Tour Operator & Treks in Thimphu
                </h2>
                <div class="text-muted-foreground space-y-4 leading-relaxed">
                    <p>
                        <strong>Access Bhutan Tours & Treks</strong> is a leading local tour agency based in Thimphu, Bhutan’s capital. Licensed by the <strong>Department of Tourism</strong> and managed by experienced travel planners with over 20 years of experience, we specialize in offering authentic, customizable, and high-quality travel itineraries across the Kingdom.
                    </p>
                    <p>
                        From cultural heritage journeys and trekking through the Himalayan peaks to colorful festivals, nature safaris, and spiritual retreats—our tours are designed with transparent pricing, excellent logistics, and local guides who adapt to your pace.
                    </p>
                    <p class="border-l-4 border-accent pl-4 italic bg-muted/30 py-2 rounded-r-lg">
                        We also operate <strong>Access Suites Thimphu</strong>, a 4-star boutique hotel blending traditional Bhutanese architecture with modern luxury, providing our guests with premium stays in the capital.
                    </p>
                </div>
            @endif
            <div class="pt-4 flex gap-4">
                <x-ui.button href="{{ route('about') }}">Learn More About Bhutan</x-ui.button>
                <x-ui.button href="{{ route('contact') }}" variant="ghost">Get In Touch</x-ui.button>
            </div>
        </div>
        
        <!-- Showcase Image / Feature Panel -->
        <div class="relative">
            <div class="absolute -inset-4 rounded-xl bg-gradient-to-tr from-primary to-accent opacity-10 blur-xl"></div>
            <div class="relative rounded-xl border bg-card text-card-foreground shadow-xl overflow-hidden aspect-[4/3]">
                @if($showcaseImage)
                    <img src="{{ $showcaseImage }}" alt="Bhutan destination showcase" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-[#0e2213] to-[#1c1106] flex items-center justify-center relative">
                        <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(rgba(255,255,255,0.15) 1px, transparent 1px); background-size: 12px 12px;"></div>
                        <span class="font-serif font-bold text-white/10 text-3xl select-none">Showcase</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Featured Journeys Section -->
<section class="py-16 sm:py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 border-t border-border">
    <div class="text-center mb-12">
        <span class="text-xs font-semibold text-primary dark:text-accent uppercase tracking-wider">Handpicked Itineraries</span>
        <h2 class="text-3xl font-bold font-serif text-foreground mt-2">Featured Journeys</h2>
        <p class="text-muted-foreground mt-3 max-w-xl mx-auto text-sm">Our most popular itineraries, from cultural highlights to wilderness treks. Fully customizable.</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach($featuredTours as $tour)
            <div class="group relative rounded-xl border bg-card text-card-foreground shadow-sm overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
                <div class="p-6 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider bg-primary/10 text-primary dark:text-accent">
                            {{ $tour->category }}
                        </span>
                        <span class="text-xs font-medium text-muted-foreground flex items-center gap-1">
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $tour->duration }}
                        </span>
                    </div>
                    <h3 class="text-lg font-bold font-serif leading-tight text-foreground line-clamp-2 group-hover:text-primary dark:group-hover:text-accent transition-colors">
                        <a href="{{ route('tours.show', ['slug' => $tour->slug]) }}">{{ $tour->title }}</a>
                    </h3>
                    <p class="text-xs text-muted-foreground leading-relaxed line-clamp-3">
                        {{ $tour->snippet }}
                      </p>
                </div>
                <div class="flex items-center justify-between px-6 pb-6 border-t mt-auto pt-4 border-muted/50">
                    <a href="{{ route('tours.show', ['slug' => $tour->slug]) }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-semibold transition-colors bg-secondary text-secondary-foreground hover:bg-secondary/80 h-9 px-3 w-full">
                        View Itinerary
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</section>

<!-- Scenic Valleys Section -->
<section class="py-16 sm:py-24 bg-muted/20 border-y border-border">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <span class="text-xs font-semibold text-primary dark:text-accent uppercase tracking-wider">Himalayan Valleys</span>
            <h2 class="text-3xl font-bold font-serif text-foreground mt-2">Discover Scenic Destinations</h2>
            <p class="text-muted-foreground mt-3 max-w-xl mx-auto text-sm">Explore the legendary valleys and cities that form the heart of Bhutan's history.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($featuredDestinations as $dest)
                @php
                    $img = $destinationImages[$dest->slug] ?? $showcaseImage;
                @endphp
                <div class="group relative rounded-xl border bg-card text-card-foreground shadow-sm overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
                    <div class="relative h-48 w-full overflow-hidden shrink-0">
                        <img src="{{ $img }}" alt="{{ $dest->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                        <div class="absolute bottom-4 left-4 text-white">
                            <h4 class="font-serif font-bold text-lg leading-tight">{{ $dest->title }}</h4>
                        </div>
                    </div>
                    <div class="p-6 flex-grow flex flex-col justify-between">
                        <p class="text-xs text-muted-foreground leading-relaxed line-clamp-3">
                            {{ $dest->description }}
                        </p>
                        <a href="{{ route('destinations.show', ['slug' => $dest->slug]) }}" class="inline-flex items-center text-xs font-semibold text-primary dark:text-accent hover:underline gap-1 mt-4">
                            Explore Guide
                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-center mt-10">
            <x-ui.button href="{{ route('destinations') }}" variant="outline">View All Destinations</x-ui.button>
        </div>
    </div>
</section>

<!-- Travel Resource Guides Section -->
<section class="py-16 sm:py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-12">
        <span class="text-xs font-semibold text-primary dark:text-accent uppercase tracking-wider">Traveler Insights</span>
        <h2 class="text-3xl font-bold font-serif text-foreground mt-2">Bhutan Travel Tips & Resources</h2>
        <p class="text-muted-foreground mt-3 max-w-xl mx-auto text-sm">Essential guides written by our local experts to help plan and prepare for your adventure.</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach($recentGuides as $g)
            @php
                $img = $guideImages[$g->slug] ?? $showcaseImage;
            @endphp
            <div class="group relative rounded-xl border bg-card text-card-foreground shadow-sm overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
                <div class="relative h-44 w-full overflow-hidden shrink-0">
                    <img src="{{ $img }}" alt="{{ $g->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-6 flex-grow flex flex-col justify-between">
                    <div class="space-y-1">
                        <h4 class="font-serif font-bold text-base leading-snug group-hover:text-primary dark:group-hover:text-accent transition-colors">
                            <a href="{{ route('guide.show', ['slug' => $g->slug]) }}">{{ $g->title }}</a>
                        </h4>
                        <p class="text-xs text-muted-foreground leading-relaxed line-clamp-3">
                            {{ $g->description }}
                        </p>
                    </div>
                    <a href="{{ route('guide.show', ['slug' => $g->slug]) }}" class="inline-flex items-center text-xs font-semibold text-primary dark:text-accent hover:underline gap-1 mt-4">
                        Read Guide
                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
    <div class="text-center mt-10">
        <x-ui.button href="{{ route('guide') }}" variant="outline">View Travel Guides</x-ui.button>
    </div>
</section>

<!-- Tour Categories Grid -->
<section class="py-16 bg-muted/30 border-y border-border">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center mb-12">
        <span class="text-xs font-semibold text-primary dark:text-accent uppercase tracking-wider">Curated Experiences</span>
        <h2 class="text-3xl font-bold font-serif text-foreground mt-2">What We Offer</h2>
        <p class="text-muted-foreground mt-4 max-w-xl mx-auto">
            Choose from a wide variety of specialty tours led by local experts, tailored to match your specific interests.
        </p>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Category Card 1 -->
        <x-ui.card class="hover:shadow-md transition-shadow">
            <x-ui.card.header>
                <x-ui.card.title>Cultural Tours</x-ui.card.title>
                <x-ui.card.description>Explore Bhutanese culture, stupas, and heritage.</x-ui.card.description>
            </x-ui.card.header>
            <x-ui.card.content>
                <p class="text-sm text-muted-foreground">Close contact with local families, exploring ancient fortresses, monasteries, and deep spiritual landmarks.</p>
            </x-ui.card.content>
            <x-ui.card.footer>
                <x-ui.button href="{{ route('tours.category', ['slug' => 'cultural']) }}" variant="link" class="p-0 text-primary dark:text-accent font-semibold flex items-center gap-1">
                    View Cultural Tours
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </x-ui.button>
            </x-ui.card.footer>
        </x-ui.card>

        <!-- Category Card 2 -->
        <x-ui.card class="hover:shadow-md transition-shadow">
            <x-ui.card.header>
                <x-ui.card.title>Trekking Adventures</x-ui.card.title>
                <x-ui.card.description>Trek through scenic Himalayan paths.</x-ui.card.description>
            </x-ui.card.header>
            <x-ui.card.content>
                <p class="text-sm text-muted-foreground">High-altitude mountain expeditions, camping near crystal clear glacial lakes, and sweeping vistas of unclimbed peaks.</p>
            </x-ui.card.content>
            <x-ui.card.footer>
                <x-ui.button href="{{ route('tours.category', ['slug' => 'trekking']) }}" variant="link" class="p-0 text-primary dark:text-accent font-semibold flex items-center gap-1">
                    View Trekking Tours
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </x-ui.button>
            </x-ui.card.footer>
        </x-ui.card>

        <!-- Category Card 3 -->
        <x-ui.card class="hover:shadow-md transition-shadow">
            <x-ui.card.header>
                <x-ui.card.title>Festival Packages</x-ui.card.title>
                <x-ui.card.description>Experience vibrant Tshechus and dances.</x-ui.card.description>
            </x-ui.card.header>
            <x-ui.card.content>
                <p class="text-sm text-muted-foreground">Attend spectacular religious festivals, traditional masked dances, and sacred ceremonies honoring Guru Rinpoche.</p>
            </x-ui.card.content>
            <x-ui.card.footer>
                <x-ui.button href="{{ route('tours.category', ['slug' => 'festival']) }}" variant="link" class="p-0 text-primary dark:text-accent font-semibold flex items-center gap-1">
                    View Festival Tours
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </x-ui.button>
            </x-ui.card.footer>
        </x-ui.card>

        <!-- Category Card 4 -->
        <x-ui.card class="hover:shadow-md transition-shadow">
            <x-ui.card.header>
                <x-ui.card.title>Hiking & Walking</x-ui.card.title>
                <x-ui.card.description>Day hikes in sacred, peaceful valleys.</x-ui.card.description>
            </x-ui.card.header>
            <x-ui.card.content>
                <p class="text-sm text-muted-foreground">Scenic day trails through pine forests, climbing to spectacular lookouts and cliffside temples like Tiger's Nest.</p>
            </x-ui.card.content>
            <x-ui.card.footer>
                <x-ui.button href="{{ route('tours.category', ['slug' => 'hiking']) }}" variant="link" class="p-0 text-primary dark:text-accent font-semibold flex items-center gap-1">
                    View Hiking Tours
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </x-ui.button>
            </x-ui.card.footer>
        </x-ui.card>

        <!-- Category Card 5 -->
        <x-ui.card class="hover:shadow-md transition-shadow">
            <x-ui.card.header>
                <x-ui.card.title>Local Homestays</x-ui.card.title>
                <x-ui.card.description>Stay in traditional farmhouses.</x-ui.card.description>
            </x-ui.card.header>
            <x-ui.card.content>
                <p class="text-sm text-muted-foreground">Stay in remote agricultural villages, sample homemade Butter Tea, soak in traditional hot stone baths, and enjoy farm hospitality.</p>
            </x-ui.card.content>
            <x-ui.card.footer>
                <x-ui.button href="{{ route('tours.category', ['slug' => 'homestay']) }}" variant="link" class="p-0 text-primary dark:text-accent font-semibold flex items-center gap-1">
                    View Homestay Tours
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </x-ui.button>
            </x-ui.card.footer>
        </x-ui.card>

        <!-- Category Card 6 -->
        <x-ui.card class="hover:shadow-md transition-shadow">
            <x-ui.card.header>
                <x-ui.card.title>Special Interest</x-ui.card.title>
                <x-ui.card.description>Rafting, bird watching, photography.</x-ui.card.description>
            </x-ui.card.header>
            <x-ui.card.content>
                <p class="text-sm text-muted-foreground">Tailor-made itineraries for mountain biking, kayaking, flora/textile tours, serious photography, and peaceful honeymoons.</p>
            </x-ui.card.content>
            <x-ui.card.footer>
                <x-ui.button href="{{ route('tours.category', ['slug' => 'special']) }}" variant="link" class="p-0 text-primary dark:text-accent font-semibold flex items-center gap-1">
                    View Special Tours
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </x-ui.button>
            </x-ui.card.footer>
        </x-ui.card>
    </div>
</section>

<!-- Call To Action -->
<section class="py-16 sm:py-24 text-center max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
    <h2 class="text-3xl font-bold font-serif text-foreground">Ready to Plan Your Bhutan Journey?</h2>
    <p class="text-muted-foreground mt-4 max-w-xl mx-auto leading-relaxed">
        Tell us your travel dates, preferred pace, and interests. Our local travel experts will craft a personalized itinerary for you with no booking obligations.
    </p>
    <div class="mt-8">
        <x-ui.button href="{{ route('contact') }}" size="lg" class="shadow-lg px-8">
            Create Custom Itinerary
        </x-ui.button>
    </div>
</section>
@endsection
