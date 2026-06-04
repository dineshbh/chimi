@extends('layouts.app')

@section('title', $tour->title . ' - Access Bhutan Tours')
@section('meta_description', $tour->snippet)

@section('seo_schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@graph": [
    {
      "@@type": "BreadcrumbList",
      "@@id": "{{ request()->url() }}#breadcrumb",
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
          "name": "Tours",
          "item": "{{ route('tours') }}"
        },
        {
          "@@type": "ListItem",
          "position": 3,
          "name": "{{ $tour->title }}",
          "item": "{{ request()->url() }}"
        }
      ]
    },
    {
      "@@type": "Product",
      "@@id": "{{ request()->url() }}#product",
      "name": "{{ $tour->title }}",
      "description": "{{ $tour->snippet }}",
      "image": "{{ $heroImage }}",
      "offers": {
        "@@type": "Offer",
        "price": "{{ preg_replace('/[^\d]/', '', $tour->price) ?: '1490' }}",
        "priceCurrency": "USD",
        "availability": "https://schema.org/InStock",
        "validFrom": "{{ date('Y-m-d') }}",
        "url": "{{ request()->url() }}"
      },
      "provider": {
        "@@type": "TravelAgency",
        "name": "Access Bhutan Tours & Treks",
        "url": "{{ route('home') }}"
      }
    }
    @php
        $faqsList = json_decode($tour->faqs, true) ?: [];
    @endphp
    @if(!empty($faqsList))
    ,
    {
      "@@type": "FAQPage",
      "@@id": "{{ request()->url() }}#faq",
      "mainEntity": [
        @foreach($faqsList as $index => $faq)
          {
            "@@type": "Question",
            "name": "{{ $faq['q'] }}",
            "acceptedAnswer": {
              "@@type": "Answer",
              "text": "{{ $faq['a'] }}"
            }
          }{{ $index < count($faqsList) - 1 ? ',' : '' }}
        @endforeach
      ]
    }
    @endif
  ]
}
</script>
@endsection

@section('content')


<!-- Full Width Hero Section -->
<section class="relative isolate overflow-hidden text-white py-10 sm:py-12 lg:py-14" style="background: linear-gradient(135deg, #051108 0%, #0e2213 50%, #1c1106 100%);">
    <!-- Subtle dot grid pattern -->
    <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(rgba(255, 255, 255, 0.08) 1px, transparent 1px); background-size: 24px 24px;"></div>
    <!-- Dynamic radial glows -->
    <div class="absolute inset-0 opacity-35" style="background-image: radial-gradient(circle at 82% 35%, rgba(255, 122, 0, 0.22), transparent 35%);"></div>
    <div class="absolute inset-0 opacity-45" style="background-image: radial-gradient(circle at 15% 50%, rgba(147, 197, 75, 0.25), transparent 40%);"></div>
    <!-- Decorative blurred lighting spheres -->
    <div class="absolute top-0 right-0 w-96 h-96 rounded-full blur-[100px] -mr-20 -mt-20" style="background: rgba(255, 122, 0, 0.15);"></div>
    <div class="absolute bottom-0 left-1/4 w-96 h-96 rounded-full blur-[120px] -ml-24 -mb-24" style="background: rgba(147, 197, 75, 0.2);"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 grid grid-cols-1 lg:grid-cols-3 gap-8 items-center">
        <!-- Left Side: Title, Stats -->
        <div class="lg:col-span-2 space-y-4">
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center rounded-full bg-accent/25 px-2.5 py-0.5 text-xs font-bold text-accent uppercase tracking-wider">
                    {{ ucfirst($tour->category) }} Journey
                </span>
                <span class="inline-flex items-center rounded-full bg-white/10 px-2.5 py-0.5 text-xs font-bold text-white uppercase tracking-wider">
                    Bhutan
                </span>
            </div>
            
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold font-serif text-white tracking-tight leading-tight max-w-4xl">
                {{ $tour->title }}
            </h1>
            <p class="max-w-2xl text-base sm:text-lg leading-relaxed text-white/80">
                {{ $tour->snippet }}
            </p>

            <!-- Stats Bar -->
            <div class="pt-2 flex flex-wrap gap-4 items-center text-sm">
                <span class="inline-flex items-center gap-1.5 font-semibold bg-white/10 text-white border border-white/20 px-3.5 py-1.5 rounded-full backdrop-blur leading-none">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ $tour->duration }}
                </span>
                <span class="inline-flex items-center gap-1.5 font-bold bg-accent text-accent-foreground px-3.5 py-1.5 rounded-full shadow-md leading-none">
                    Starting from {{ $tour->price ?: 'USD $1,490' }}
                </span>
            </div>
        </div>

        <!-- Right Side: Quick Overview Card -->
        <div class="lg:col-span-1 bg-white/10 dark:bg-black/35 backdrop-blur-md rounded-2xl border border-white/20 p-6 space-y-4 shadow-lg animate-fade-in-up">
            <h3 class="text-sm font-bold uppercase tracking-wider text-white border-b border-white/10 pb-2 flex items-center gap-2">
                <svg class="h-4.5 w-4.5 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 1.125rem; height: 1.125rem;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                Quick Overview
            </h3>
            <div class="grid grid-cols-2 gap-x-4 gap-y-3 text-[11px] leading-snug">
                @foreach($tourOverview as $item)
                    <div>
                        <span class="text-white/60 block">{{ $item['label'] }}</span>
                        @if(isset($item['url']))
                            <a href="{{ $item['url'] }}" class="font-semibold text-accent hover:underline block">{{ $item['value'] }}</a>
                        @else
                            <span class="font-semibold text-white">{{ $item['value'] }}</span>
                        @endif
                    </div>
                @endforeach
            </div>
            <div class="border-t border-white/10 pt-3 flex items-center justify-between text-xs">
                <span class="text-white/60">Base Price</span>
                <span class="text-sm font-bold text-accent">{{ $tour->price ?: 'USD $1,490' }}</span>
            </div>
        </div>
    </div>
</section>

<!-- Custom UI Timeline Styles -->
<style>
    #itinerary-content {
        position: relative;
        padding-left: 1.25rem;
    }
    #itinerary-content::before {
        content: '';
        position: absolute;
        left: 0.35rem;
        top: 1rem;
        bottom: 1.5rem;
        width: 2px;
        background-color: hsl(var(--border) / 0.8);
    }
    #itinerary-content h3 {
        position: relative;
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        color: hsl(var(--foreground));
        margin-top: 2rem;
        padding-left: 1.25rem;
    }
    #itinerary-content h3::before {
        content: '';
        position: absolute;
        left: -1.2rem;
        top: 0.35rem;
        width: 0.75rem;
        height: 0.75rem;
        border-radius: 9999px;
        background-color: hsl(var(--primary));
        border: 2px solid hsl(var(--accent));
        box-shadow: 0 0 0 3px hsl(var(--background));
    }
    #itinerary-content p, #itinerary-content ul, #itinerary-content ol, #itinerary-content table {
        padding-left: 1.25rem;
    }
</style>

<!-- Main Details Layout -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        
        <!-- Left: Tabbed Details (2/3 width) -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Tabs Navigation -->
            @php
                $tabConfig = [
                    'overview' => 'Overview',
                    'itinerary' => 'Daily Itinerary',
                    'departures' => 'Pricing & Departures',
                    'reviews' => 'Traveler Reviews',
                    'faqs' => 'FAQs'
                ];
            @endphp
            
            <x-ui.tabs id="product-tabs" :tabs="$tabConfig" active="overview">
                <!-- Tab: Overview -->
                <div data-tab-content="overview" class="space-y-6">
                    <div class="bg-card border rounded-lg p-6 sm:p-8 shadow-sm space-y-6">
                        <div class="space-y-2">
                            <h3 class="text-xl font-bold font-serif text-foreground">Journey Overview</h3>
                            <p class="text-sm sm:text-base text-muted-foreground leading-relaxed">
                                {{ $tour->snippet }}
                            </p>
                        </div>

                        <!-- Highlights Section -->
                        <div class="pt-6 border-t space-y-3">
                            <h4 class="text-sm font-bold text-foreground uppercase tracking-wider">Experience Inclusions</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm text-muted-foreground">
                                <div class="flex items-center gap-2">
                                    <svg class="h-5 w-5 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                    All meals (breakfast, lunch, dinner) included
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="h-5 w-5 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                    Department of Tourism approved 3-star hotels
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="h-5 w-5 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                    Certified local English-speaking guides
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="h-5 w-5 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                    Private SUV/Mini-bus transport & transfers
                                </div>
                            </div>
                        </div>

                        <!-- Bhutan SDF disclaimer -->
                        <div class="p-4 rounded-lg bg-muted/40 border text-xs text-muted-foreground leading-relaxed">
                            <strong>Note on SDF government fees:</strong> Bhutan's mandatory Sustainable Development Fee (SDF) of USD $100 per adult per night is not pre-packaged directly in the starting price to allow custom duration quotes. However, we collect and submit it to the Department of Tourism on your behalf when booking.
                        </div>
                    </div>
                </div>

                <!-- Tab: Itinerary -->
                <div data-tab-content="itinerary" class="hidden">
                    <article class="bg-card border rounded-lg p-6 sm:p-8 shadow-sm space-y-6">
                        <h3 class="text-xl font-bold font-serif text-foreground">Day-by-Day Itinerary</h3>
                        
                        <div id="itinerary-content" class="prose prose-slate dark:prose-invert max-w-none text-muted-foreground leading-relaxed text-sm sm:text-base space-y-6">
                            {!! $tour->content_html !!}
                        </div>
                    </article>
                </div>

                <!-- Tab: Pricing & Departures -->
                <div data-tab-content="departures" class="hidden space-y-8">
                    <!-- Pricing Table -->
                    <div class="bg-card border rounded-lg p-6 sm:p-8 shadow-sm space-y-4">
                        <h3 class="text-xl font-bold font-serif text-foreground">Hotel Tier Pricing & Upgrades</h3>
                        <p class="text-xs text-muted-foreground">Prices below represent standard guides per person. Final totals may vary with visa processing and customization preferences.</p>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm border-collapse">
                                <thead>
                                    <tr class="border-b text-left text-foreground bg-muted/30 font-semibold">
                                        <th class="p-4">Hotel Standard</th>
                                        <th class="p-4">Inclusions</th>
                                        <th class="p-4 text-right">Price per Person</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y text-muted-foreground">
                                    <tr>
                                        <td class="p-4 font-bold text-foreground">Standard 3-Star</td>
                                        <td class="p-4 text-xs">Authentic local lodges (Access Suites or equivalent). Full Board.</td>
                                        <td class="p-4 text-right font-semibold text-foreground">Included in Base</td>
                                    </tr>
                                    <tr>
                                        <td class="p-4 font-bold text-foreground">Boutique 4-Star</td>
                                        <td class="p-4 text-xs">Handpicked premium properties (Zhiwa Ling, Dhensa). Full Board.</td>
                                        <td class="p-4 text-right font-semibold text-foreground">+ USD $250 / night</td>
                                    </tr>
                                    <tr>
                                        <td class="p-4 font-bold text-foreground">Luxury 5-Star</td>
                                        <td class="p-4 text-xs">World-class properties (Amankora, Six Senses, COMO Uma). Luxury Board.</td>
                                        <td class="p-4 text-right font-semibold text-foreground">+ USD $850 / night</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Departures Checklist -->
                    <div class="bg-card border rounded-lg p-6 sm:p-8 shadow-sm space-y-4">
                        <h3 class="text-xl font-bold font-serif text-foreground">Upcoming Small Group Departures</h3>
                        <p class="text-xs text-muted-foreground">Join one of our scheduled small-group tours, or choose custom private dates for your party.</p>
                        
                        @php
                            $departures = json_decode($tour->departure_dates, true) ?: [];
                        @endphp
                        @if($departures)
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                                @foreach($departures as $date)
                                    <div class="flex items-center gap-2.5 p-3.5 border rounded-lg bg-muted/20">
                                        <svg class="h-5 w-5 text-primary dark:text-accent shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        <span class="text-xs font-semibold text-foreground">{{ $date }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-xs text-muted-foreground italic">No upcoming group departures. Inquire below to schedule a private travel date.</p>
                        @endif
                    </div>
                </div>

                <!-- Tab: Reviews -->
                <div data-tab-content="reviews" class="hidden">
                    <div class="space-y-6">
                        @php
                            $reviews = json_decode($tour->reviews, true) ?: [];
                        @endphp
                        @forelse($reviews as $rev)
                            <div class="bg-card border rounded-lg p-6 shadow-sm space-y-3 hover:shadow-md transition-shadow">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h4 class="text-sm font-bold text-foreground">{{ $rev['name'] }}</h4>
                                        <span class="text-[10px] text-muted-foreground font-semibold uppercase tracking-wide">{{ $rev['date'] }}</span>
                                    </div>
                                    <div class="flex items-center text-amber-500 gap-0.5">
                                        @for($i = 0; $i < floor($rev['rating']); $i++)
                                            <svg class="h-4 w-4 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                        @endfor
                                        @if($rev['rating'] - floor($rev['rating']) > 0)
                                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" style="clip-path: polygon(0 0, 50% 0, 50% 100%, 0 100%);"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                        @endif
                                    </div>
                                </div>
                                <p class="text-sm text-muted-foreground leading-relaxed italic">
                                    "{{ $rev['text'] }}"
                                </p>
                            </div>
                        @empty
                            <p class="text-sm text-muted-foreground italic text-center py-8">No reviews yet for this itinerary.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Tab: FAQs -->
                <div data-tab-content="faqs" class="hidden">
                    <div class="bg-card border rounded-lg p-6 sm:p-8 shadow-sm space-y-4">
                        <h3 class="text-xl font-bold font-serif text-foreground">Frequently Asked Questions</h3>
                        
                        <div class="divide-y">
                            @php
                                $faqs = json_decode($tour->faqs, true) ?: [];
                            @endphp
                            @forelse($faqs as $index => $faq)
                                <x-ui.accordion :title="$faq['q']" :open="$index === 0">
                                    <p class="text-sm leading-relaxed text-muted-foreground">{{ $faq['a'] }}</p>
                                </x-ui.accordion>
                            @empty
                                <p class="text-sm text-muted-foreground italic text-center py-8">No FAQs loaded for this trip.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </x-ui.tabs>
        </div>

        <!-- Right: Inquiry Form (1/3 width) -->
        <aside class="lg:col-span-1 space-y-8">

            <!-- Sticky Booking Card Container -->
            <div class="sticky top-28 z-20 space-y-6" id="booking-card">
                <x-ui.card class="shadow-sm border bg-card">
                    <x-ui.card.header>
                        <x-ui.card.title>Book This Journey</x-ui.card.title>
                        <x-ui.card.description>Inquire about pricing, dates, and customization for {{ $tour->title }}</x-ui.card.description>
                    </x-ui.card.header>
                    <x-ui.card.content>
                        <form action="{{ route('contact.submit') }}" method="POST" class="space-y-4">
                            @csrf
                            <div style="display: none !important;"><input type="text" name="website_verification_token" id="tour_website_verification_token" autocomplete="off" tabindex="-1"></div>
                            <input type="hidden" name="package" value="{{ $tour->title }}">
                            
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
                                <label for="message" class="text-xs font-semibold text-foreground uppercase">Travel Dates & Notes *</label>
                                <textarea name="message" id="message" rows="4" required placeholder="Please let us know your expected travel window and group size..." class="flex min-h-[60px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"></textarea>
                            </div>

                            <x-ui.button type="submit" variant="accent" class="w-full shadow">
                                Send Booking Inquiry
                            </x-ui.button>
                        </form>
                    </x-ui.card.content>
                </x-ui.card>
            </div>
        </aside>

    </div>
</div>

<!-- Related Tour Packages (Bottom Section) -->
@if($relatedTours->isNotEmpty())
    <div class="border-t bg-muted/20 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <div class="text-center sm:text-left space-y-2">
                <span class="text-xs font-bold text-primary dark:text-accent uppercase tracking-widest block">Recommended Journeys</span>
                <h2 class="text-2xl sm:text-3xl font-bold font-serif text-foreground">Related Tour Packages</h2>
                <p class="text-muted-foreground text-sm max-w-xl">If you liked this itinerary, consider these other custom options in the {{ ucfirst($tour->category) }} category.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($relatedTours as $rel)
                    <div class="group relative rounded-lg border bg-card text-card-foreground shadow-sm overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
                        <!-- Content -->
                        <div class="p-6 space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider bg-primary/10 text-primary dark:text-accent">
                                    {{ $rel->category }}
                                </span>
                                <span class="text-xs font-medium text-muted-foreground flex items-center gap-1">
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $rel->duration }}
                                </span>
                            </div>
                            <h3 class="text-base font-bold font-serif leading-tight text-foreground line-clamp-1 group-hover:text-primary dark:group-hover:text-accent transition-colors">
                                <a href="{{ route('tours.show', ['slug' => $rel->slug]) }}">{{ $rel->title }}</a>
                            </h3>
                            <p class="text-xs text-muted-foreground leading-relaxed line-clamp-3">
                                {{ $rel->snippet }}
                            </p>
                        </div>
                        <div class="flex items-center justify-between px-6 pb-6 border-t mt-auto pt-4 border-muted/50">
                            <span class="text-xs font-bold text-foreground">
                                {{ $rel->price ?: 'USD $1,490' }}
                            </span>
                            <a href="{{ route('tours.show', ['slug' => $rel->slug]) }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-xs font-semibold transition-colors bg-secondary text-secondary-foreground hover:bg-secondary/80 h-9 px-3">
                                View Itinerary
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif

<!-- Floating Bottom-Left Contact/Inquiry Button for Mobile -->
<div class="fixed bottom-6 left-6 z-40 lg:hidden">
    <button 
        onclick="document.getElementById('booking-card').scrollIntoView({ behavior: 'smooth', block: 'center' });"
        class="bg-accent text-accent-foreground font-bold text-xs tracking-wider uppercase shadow-xl hover:shadow-2xl transition-all hover:scale-105 active:scale-95 px-5 py-3.5 rounded-full flex items-center gap-2 border border-black/5"
    >
        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
        Inquire Now
    </button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const container = document.getElementById('itinerary-content');
        if (container) {
            // Apply standard global styles to injected tables, links, and images
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

            // Parse detailed HTML blocks dynamically into structured Day-by-Day slides
            const children = Array.from(container.children);
            const slides = [];
            let currentSlide = null;

            children.forEach(child => {
                const text = child.textContent.trim();
                // Check if the current element constitutes a Day header
                const hasDayHeader = 
                    child.tagName === 'H3' || 
                    child.tagName === 'H4' || 
                    /^(Day\s*\d+|D\s*a\s*y\s*\d+|Detailed\s*Tour\s*Itinerary)/i.test(text) ||
                    (child.querySelector('strong') && /^(Day\s*\d+|D\s*a\s*y\s*\d+)/i.test(child.querySelector('strong').textContent.trim()));

                const isDayDivider = hasDayHeader && 
                                     !text.toLowerCase().includes('packing checklist') && 
                                     !text.toLowerCase().includes('tour prices') &&
                                     !text.toLowerCase().includes('prices &');

                if (isDayDivider) {
                    if (currentSlide) {
                        slides.push(currentSlide);
                    }
                    currentSlide = {
                        title: text,
                        content: []
                    };
                } else {
                    if (!currentSlide) {
                        currentSlide = {
                            title: "Overview",
                            content: []
                        };
                    }
                    currentSlide.content.push(child.outerHTML);
                }
            });

            if (currentSlide) {
                slides.push(currentSlide);
            }

            // Render interactive carousel if parsed itinerary has multiple days/sections
            if (slides.length > 1) {
                // Remove absolute lines timeline graphics style
                const styleBlocks = document.querySelectorAll('style');
                styleBlocks.forEach(style => {
                    if (style.innerHTML.includes('#itinerary-content::before')) {
                        style.remove();
                    }
                });

                // Render horizontal day badges navigation
                let tabsHTML = `<div class="flex items-center gap-1.5 overflow-x-auto pb-3 border-b border-border/50 scrollbar-none" id="carousel-tabs-container">`;
                slides.forEach((slide, idx) => {
                    const shortName = slide.title.split(':')[0].trim();
                    tabsHTML += `
                        <button 
                            type="button" 
                            data-slide-index="${idx}" 
                            class="itinerary-tab-btn shrink-0 h-9 px-3.5 text-xs font-semibold rounded-md border transition-all duration-200 uppercase tracking-wider ${idx === 0 ? 'bg-primary text-primary-foreground border-primary' : 'bg-background text-muted-foreground border-border hover:text-foreground hover:bg-secondary'}"
                        >
                            ${shortName}
                        </button>
                    `;
                });
                tabsHTML += `</div>`;

                // Render dynamic content panes container
                let slidesHTML = `<div class="relative overflow-hidden min-h-[250px] border border-border/50 bg-muted/10 rounded-2xl p-6 sm:p-8 mt-4" id="carousel-viewer">`;
                slides.forEach((slide, idx) => {
                    const bodyHTML = slide.content.join('\n');
                    slidesHTML += `
                        <div 
                            data-slide-content="${idx}" 
                            class="itinerary-slide-pane transition-all duration-300 ${idx === 0 ? 'block opacity-100 translate-x-0' : 'hidden opacity-0 translate-x-4'}"
                        >
                            <h4 class="text-base sm:text-lg font-bold font-serif text-foreground mb-4 border-b pb-2.5 flex items-center gap-2">
                                <span class="bg-primary/10 text-primary dark:text-accent px-2 py-0.5 rounded text-xs font-semibold">${slide.title.split(':')[0].trim()}</span>
                                <span class="text-foreground">${slide.title.includes(':') ? slide.title.split(':').slice(1).join(':').trim() : ''}</span>
                            </h4>
                            <div class="prose prose-slate dark:prose-invert max-w-none text-muted-foreground text-sm sm:text-base space-y-4">
                                ${bodyHTML || '<p class="italic text-xs text-muted-foreground">Relax and explore the valley.</p>'}
                            </div>
                        </div>
                    `;
                });
                slidesHTML += `</div>`;

                // Render controls (prev, indicator, next)
                let controlsHTML = `
                    <div class="flex items-center justify-between mt-5">
                        <button 
                            type="button" 
                            id="carousel-prev" 
                            class="inline-flex items-center gap-1.5 text-xs font-bold text-muted-foreground hover:text-foreground transition-colors disabled:opacity-30 disabled:pointer-events-none"
                            disabled
                        >
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                            Previous Day
                        </button>
                        <span class="text-xs text-muted-foreground font-semibold uppercase tracking-wider" id="carousel-indicator">
                            Day 1 of ${slides.length}
                        </span>
                        <button 
                            type="button" 
                            id="carousel-next" 
                            class="inline-flex items-center gap-1.5 text-xs font-bold text-muted-foreground hover:text-foreground transition-colors disabled:opacity-30 disabled:pointer-events-none"
                        >
                            Next Day
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                `;

                // Update container with custom slider UI
                container.innerHTML = tabsHTML + slidesHTML + controlsHTML;

                // Bind UI interactions
                let activeIdx = 0;
                const tabButtons = container.querySelectorAll('.itinerary-tab-btn');
                const slidePanes = container.querySelectorAll('.itinerary-slide-pane');
                const prevBtn = container.querySelector('#carousel-prev');
                const nextBtn = container.querySelector('#carousel-next');
                const indicator = container.querySelector('#carousel-indicator');

                const showSlide = (idx) => {
                    activeIdx = idx;

                    // Update Tab Navigation Active State
                    tabButtons.forEach((btn, bIdx) => {
                        if (bIdx === idx) {
                            btn.className = "itinerary-tab-btn shrink-0 h-9 px-3.5 text-xs font-semibold rounded-md border transition-all duration-200 uppercase tracking-wider bg-primary text-primary-foreground border-primary";
                            btn.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
                        } else {
                            btn.className = "itinerary-tab-btn shrink-0 h-9 px-3.5 text-xs font-semibold rounded-md border transition-all duration-200 uppercase tracking-wider bg-background text-muted-foreground border-border hover:text-foreground hover:bg-secondary";
                        }
                    });

                    // Hide/Show Content Panes with slide transitions
                    slidePanes.forEach((pane, pIdx) => {
                        if (pIdx === idx) {
                            pane.classList.remove('hidden');
                            setTimeout(() => {
                                pane.className = "itinerary-slide-pane transition-all duration-300 block opacity-100 translate-x-0";
                            }, 50);
                        } else {
                            pane.className = "itinerary-slide-pane transition-all duration-300 hidden opacity-0 translate-x-4";
                        }
                    });

                    // Update Control Buttons state
                    prevBtn.disabled = idx === 0;
                    nextBtn.disabled = idx === slides.length - 1;

                    // Update Day Indicators text
                    const activeShortName = slides[idx].title.split(':')[0].trim();
                    indicator.textContent = `${activeShortName} of ${slides.length}`;
                };

                // Attach Action Listeners
                tabButtons.forEach(btn => {
                    btn.addEventListener('click', () => {
                        const idx = parseInt(btn.getAttribute('data-slide-index'), 10);
                        showSlide(idx);
                    });
                });

                prevBtn.addEventListener('click', () => {
                    if (activeIdx > 0) {
                        showSlide(activeIdx - 1);
                    }
                });

                nextBtn.addEventListener('click', () => {
                    if (activeIdx < slides.length - 1) {
                        showSlide(activeIdx + 1);
                    }
                });
            }
        }
    });
</script>
@endsection
