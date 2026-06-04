@extends('layouts.app')

@section('title', $categoryPage->title . ' - Access Bhutan Tours')
@section('meta_description', $categoryPage->description)
@section('meta_keywords', $categoryPage->keywords)

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
      "name": "Tours",
      "item": "{{ route('tours') }}"
    },
    {
      "@@type": "ListItem",
      "position": 3,
      "name": "{{ $categoryPage->title }}",
      "item": "{{ request()->url() }}"
    }
  ]
}
</script>
@endsection

@section('content')
<!-- Full Gradient Category Hero -->
<section class="relative isolate overflow-hidden bg-slate-950 text-white">
    @if($heroImage)
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ $heroImage }}');"></div>
    @endif
    <div class="absolute inset-0 bg-[linear-gradient(90deg,rgba(5,17,8,0.94)_0%,rgba(9,30,16,0.78)_44%,rgba(9,30,16,0.18)_74%,rgba(5,17,8,0.36)_100%)]"></div>
    <div class="absolute inset-0 bg-[linear-gradient(0deg,rgba(5,17,8,0.92)_0%,rgba(5,17,8,0.24)_46%,rgba(5,17,8,0.08)_100%)]"></div>
    <div class="absolute inset-0 opacity-18" style="background-image: linear-gradient(rgba(255,255,255,0.08) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.08) 1px, transparent 1px); background-size: 40px 40px;"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20 lg:py-24">
        <div class="max-w-3xl space-y-5">

            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold font-serif text-white tracking-tight leading-tight">
                {{ $categoryPage->title }}
            </h1>
            <p class="text-base sm:text-lg text-white/80 leading-relaxed max-w-2xl">
                {{ $categoryPage->description }}
            </p>
            <div class="flex flex-wrap items-center gap-3 pt-2">
                <span class="inline-flex items-center rounded-full border border-white/20 bg-white/10 px-3.5 py-1.5 text-sm font-semibold text-white backdrop-blur">
                    {{ $tours->count() }} {{ $tours->count() === 1 ? 'package' : 'packages' }}
                </span>
                <a href="{{ route('contact') }}" class="inline-flex items-center rounded-full bg-accent px-3.5 py-1.5 text-sm font-bold text-accent-foreground transition-colors hover:bg-accent/90">
                    Request custom itinerary
                </a>
            </div>
        </div>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Column: Tours Grid & Content -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Category Content Details -->
            @if($categoryPage->content_html)
                <article class="bg-card border rounded-xl p-6 sm:p-8 shadow-sm">
                    <div class="prose prose-slate dark:prose-invert max-w-none text-muted-foreground leading-relaxed text-sm sm:text-base">
                        {!! $categoryPage->content_html !!}
                    </div>
                </article>
            @endif

            <!-- Tours Listing -->
            <div class="space-y-6">
                <h3 class="text-xl font-bold font-serif text-foreground pb-2 border-b">
                    Available Tour Packages ({{ $tours->count() }})
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse($tours as $tour)
                        <div class="group relative rounded-xl border bg-card text-card-foreground shadow-sm overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
                            <!-- Card Content -->
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
                                <span class="text-xs font-bold text-foreground">
                                    {{ $tour->price ?: 'USD $1,490' }}
                                </span>
                                <a href="{{ route('tours.show', ['slug' => $tour->slug]) }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-semibold transition-colors bg-secondary text-secondary-foreground hover:bg-secondary/80 h-9 px-3">
                                    View Itinerary
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-12 border border-dashed rounded-xl bg-muted/20 text-muted-foreground">
                            <p class="text-sm">No packages currently available for this category.</p>
                            <a href="{{ route('contact') }}" class="text-xs text-primary dark:text-accent font-semibold hover:underline block mt-2">Request a Custom Itinerary</a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right Column: Booking Sidebar -->
        <aside class="lg:col-span-1">
            <x-ui.card class="sticky top-24">
                <x-ui.card.header>
                    <x-ui.card.title>Custom Travel Planner</x-ui.card.title>
                    <x-ui.card.description>Inquire about standard rates, customization, and group dates for {{ $categoryPage->title }}</x-ui.card.description>
                </x-ui.card.header>
                <x-ui.card.content>
                    <form action="{{ route('contact.submit') }}" method="POST" class="space-y-4">
                        @csrf
                        <div style="display: none !important;"><input type="text" name="website_verification_token" id="category_website_verification_token" autocomplete="off" tabindex="-1"></div>
                        <input type="hidden" name="package" value="Category Page: {{ $categoryPage->title }}">
                        
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
                            <label for="message" class="text-xs font-semibold text-foreground uppercase">Dates, Duration & Guests *</label>
                            <textarea name="message" id="message" rows="4" required placeholder="Let us know your expected travel window and group size..." class="flex min-h-[60px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"></textarea>
                        </div>

                        <x-ui.button type="submit" variant="accent" class="w-full">
                            Request {{ $categoryPage->title }} Quote
                        </x-ui.button>
                    </form>
                </x-ui.card.content>
            </x-ui.card>
        </aside>

    </div>
</div>
@endsection
