@extends('layouts.app')

@section('title', 'Bhutan Travel Guides & Blogs - Expert Advice')
@section('meta_description', 'Read our expert travel articles on Bhutan visas, SDF tour costs, local foods, packing checklists, and cultural etiquette.')

@section('content')
<!-- Hero Header -->
<div class="relative bg-slate-900 text-white py-24 sm:py-32 overflow-hidden">
    @if(!app()->environment('production'))
        <div class="absolute inset-0 opacity-40 bg-[url('https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?q=80&w=1600')] bg-cover bg-center"></div>
    @endif
    <div class="absolute inset-0 bg-gradient-to-t from-background via-background/60 to-transparent"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
        <span class="text-xs font-bold tracking-widest text-primary dark:text-accent uppercase">Access Bhutan Travel Blog</span>
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold font-serif tracking-tight text-foreground">
            Bhutan Insider Guides
        </h1>
        <p class="max-w-2xl mx-auto text-base sm:text-lg text-muted-foreground">
            Expert insights, trip preparation guides, local customs, and practical tips from our travel specialists.
        </p>
    </div>
</div>

<!-- Guides Grid -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    @php
        $images = [
            'visa-guide' => 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?q=80&w=600',
            'cost-guide' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?q=80&w=600',
            'food-guide' => 'https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca?q=80&w=600',
            'packing-lists' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?q=80&w=600',
            'travel-tips' => 'https://images.unsplash.com/photo-1533105079780-92b9be482077?q=80&w=600'
        ];
        $categories = [
            'visa-guide' => 'Visa & Entry',
            'cost-guide' => 'Money & SDF Tax',
            'food-guide' => 'Food & Dining',
            'packing-lists' => 'Packing Advice',
            'travel-tips' => 'Cultural Etiquette'
        ];
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($guides as $guide)
            @php
                $imgUrl = app()->environment('production') ? null : ($images[$guide->slug] ?? 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?q=80&w=600');
                $tag = $categories[$guide->slug] ?? 'Travel Tip';
            @endphp
            <div class="group relative rounded-xl border bg-card text-card-foreground shadow-sm overflow-hidden flex flex-col justify-between hover:shadow-lg transition-all duration-300">
                <!-- Card Image -->
                <div class="relative h-56 w-full overflow-hidden shrink-0 bg-slate-900">
                    @if($imgUrl)
                        <img 
                            src="{{ $imgUrl }}" 
                            alt="{{ $guide->title }}" 
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                        >
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-[#0e2213] to-[#1c1106] flex items-center justify-center relative">
                            <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(rgba(255,255,255,0.15) 1px, transparent 1px); background-size: 12px 12px;"></div>
                            <span class="font-serif font-bold text-white/10 text-3xl select-none">{{ substr($guide->title, 0, 1) }}</span>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                    <div class="absolute top-4 left-4">
                        <span class="inline-flex items-center rounded-full bg-primary/90 text-primary-foreground text-[10px] font-bold px-2.5 py-0.5 uppercase tracking-wider">
                            {{ $tag }}
                        </span>
                    </div>
                </div>

                <!-- Description & Details -->
                <div class="p-6 flex-grow flex flex-col justify-between space-y-4">
                    <div class="space-y-2">
                        <h2 class="text-xl font-bold font-serif leading-snug text-foreground group-hover:text-primary dark:group-hover:text-accent transition-colors">
                            <a href="{{ route('guide.show', ['slug' => $guide->slug]) }}">{{ $guide->title }}</a>
                        </h2>
                        <p class="text-sm text-muted-foreground leading-relaxed line-clamp-3">
                            {{ $guide->description ?? 'Read our expert guide to help prepare you for an unforgettable journey into the kingdom of Bhutan.' }}
                        </p>
                    </div>
                    
                    <div class="pt-4 border-t border-border flex items-center justify-between">
                        <a 
                            href="{{ route('guide.show', ['slug' => $guide->slug]) }}" 
                            class="inline-flex items-center text-sm font-semibold text-primary dark:text-accent hover:underline gap-1 group-hover:translate-x-0.5 transition-transform"
                        >
                            Read Article
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
