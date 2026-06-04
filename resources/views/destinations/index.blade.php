@extends('layouts.app')

@section('title', 'Explore Bhutan Destinations - Access Bhutan Tours')
@section('meta_description', 'Discover Bhutan\'s most beautiful valleys: Paro, Thimphu, Punakha, Bumthang, Haa, and the remote Eastern regions.')

@section('content')
<!-- Full Gradient Destinations Hero -->
<section class="relative isolate overflow-hidden bg-slate-950 text-white">
    @if($heroImage)
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ $heroImage }}');"></div>
    @endif
    <div class="absolute inset-0 bg-[linear-gradient(90deg,rgba(5,17,8,0.94)_0%,rgba(9,30,16,0.78)_44%,rgba(9,30,16,0.18)_74%,rgba(5,17,8,0.36)_100%)]"></div>
    <div class="absolute inset-0 bg-[linear-gradient(0deg,rgba(5,17,8,0.92)_0%,rgba(5,17,8,0.24)_46%,rgba(5,17,8,0.08)_100%)]"></div>
    <div class="absolute inset-0 opacity-18" style="background-image: linear-gradient(rgba(255,255,255,0.08) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.08) 1px, transparent 1px); background-size: 40px 40px;"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24 lg:py-28">
        <div class="max-w-3xl space-y-5">
            <span class="text-xs font-bold tracking-widest text-accent uppercase">The Land of the Thunder Dragon</span>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold font-serif tracking-tight text-white leading-tight">
                Bhutan Destinations
            </h1>
            <p class="max-w-2xl text-base sm:text-lg text-white/80 leading-relaxed">
                Explore the majestic dzongs, sacred temples, glacial valleys, and pristine Himalayan landscapes of the Last Shangri-La.
            </p>
            <a href="{{ route('contact') }}" class="inline-flex items-center rounded-full bg-accent px-3.5 py-1.5 text-sm font-bold text-accent-foreground transition-colors hover:bg-accent/90">
                Plan a custom route
            </a>
        </div>
    </div>
</section>

<!-- Destinations Grid -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($destinations as $dest)
            @php
                $imgUrl = $destinationImages[$dest->slug] ?? $heroImage;
            @endphp
            <div class="group relative rounded-xl border bg-card text-card-foreground shadow-sm overflow-hidden flex flex-col justify-between hover:shadow-lg transition-all duration-300">
                <!-- Card Image -->
                <div class="relative h-64 w-full overflow-hidden bg-slate-900">
                    @if($imgUrl)
                        <img 
                            src="{{ $imgUrl }}" 
                            alt="{{ $dest->title }}" 
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out"
                        >
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-[#0e2213] to-[#1c1106] flex items-center justify-center relative">
                            <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(rgba(255,255,255,0.15) 1px, transparent 1px); background-size: 12px 12px;"></div>
                            <span class="font-serif font-bold text-white/10 text-3xl select-none">{{ substr($dest->title, 0, 1) }}</span>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="absolute bottom-4 left-4 right-4 text-white">
                        <h2 class="text-xl font-bold font-serif">{{ $dest->title }}</h2>
                    </div>
                </div>

                <!-- Description & Details -->
                <div class="p-6 flex-grow flex flex-col justify-between space-y-4">
                    <p class="text-sm text-muted-foreground leading-relaxed line-clamp-3">
                        {{ $dest->description ?? 'Explore the cultural wonders, scenic beauty, and unique architecture of this legendary Bhutanese valley.' }}
                    </p>
                    
                    <div class="pt-4 border-t border-border flex items-center justify-between">
                        <a 
                            href="{{ route('destinations.show', ['slug' => $dest->slug]) }}" 
                            class="inline-flex items-center text-sm font-semibold text-primary dark:text-accent hover:underline gap-1 group-hover:translate-x-0.5 transition-transform"
                        >
                            Read Travel Guide
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
