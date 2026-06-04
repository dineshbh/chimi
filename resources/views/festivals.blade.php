@extends('layouts.app')

@section('title', 'Bhutan Festival Schedules 2026/2027 - Access Bhutan Tours')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Header -->
    <div class="text-center mb-16 space-y-2">
        <span class="text-xs font-semibold text-primary dark:text-accent uppercase tracking-wider">Traditional Calendars</span>
        <h1 class="text-4xl font-bold font-serif text-foreground">Bhutanese Festival Schedules</h1>
        <p class="text-muted-foreground text-base max-w-xl mx-auto">
            Experience the colors, music, and sacred cham dances by planning your tour around one of these authentic cultural festivals.
        </p>
    </div>

    <!-- Timeline Wrapper -->
    <div class="relative border-l-2 border-muted pl-6 md:pl-10 space-y-12 ml-4">
        @foreach($festivals as $index => $fest)
            <!-- Timeline Item -->
            <div class="relative">
                <!-- Node Icon/Dot -->
                <span class="absolute -left-[35px] md:-left-[51px] mt-1.5 flex h-6 w-6 items-center justify-center rounded-full bg-background border-2 border-primary dark:border-accent">
                    <span class="h-2 w-2 rounded-full bg-primary dark:bg-accent animate-pulse"></span>
                </span>
                
                <!-- Card Container -->
                <div class="bg-card border rounded-lg p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-2 mb-3">
                        <span class="text-sm font-bold text-primary dark:text-accent tracking-wide uppercase">
                            {{ $fest['date'] }}
                        </span>
                        <span class="inline-flex items-center gap-1 text-xs text-muted-foreground bg-muted px-2.5 py-1 rounded-full font-medium">
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ $fest['loc'] }}
                        </span>
                    </div>
                    
                    <h3 class="text-xl font-bold font-serif text-foreground mb-2">
                        {{ $fest['name'] }}
                    </h3>
                    
                    <!-- Short summary -->
                    <p class="text-sm text-muted-foreground leading-relaxed line-clamp-3 mb-4">
                        {{ count(explode(' ', strip_tags($fest['content_text']))) > 30 
                            ? implode(' ', array_slice(explode(' ', strip_tags($fest['content_text'])), 0, 26)) . '...' 
                            : strip_tags($fest['content_text']) }}
                    </p>

                    <div class="flex items-center gap-4">
                        <x-ui.button size="sm" variant="outline" onclick="openFestivalDetails('{{ $fest['slug'] }}')">
                            Read Festival Details
                        </x-ui.button>
                        <x-ui.button size="sm" href="{{ route('contact', ['package' => $fest['name']]) }}">
                            Inquire for This Date
                        </x-ui.button>
                    </div>
                </div>
            </div>
            
            <!-- Centered Dialog Modal for each festival -->
            <x-ui.dialog id="dialog-{{ $fest['slug'] }}" title="{{ $fest['name'] }}" description="FESTIVAL DETAILS & INFORMATION">
                <div class="prose prose-slate dark:prose-invert max-w-none text-sm text-muted-foreground leading-relaxed">
                    <div class="flex flex-wrap gap-x-6 gap-y-2 py-3 bg-muted/40 border-y mb-6 rounded px-4 text-xs font-medium uppercase tracking-wide">
                        <p><strong>Scheduled Date:</strong> <span class="text-primary dark:text-accent font-semibold">{{ $fest['date'] }}</span></p>
                        <p><strong>Location:</strong> <span class="text-foreground font-semibold">{{ $fest['loc'] }}</span></p>
                    </div>
                    <div>
                        {!! $fest['content_html'] !!}
                    </div>
                </div>
                <div class="mt-6 pt-4 border-t flex justify-end gap-2">
                    <x-ui.button variant="outline" onclick="document.getElementById('dialog-{{ $fest['slug'] }}').close()">Close</x-ui.button>
                    <x-ui.button href="{{ route('contact', ['package' => $fest['name']]) }}">Book This Tour</x-ui.button>
                </div>
            </x-ui.dialog>
        @endforeach
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        window.openFestivalDetails = (slug) => {
            const dialog = document.getElementById(`dialog-${slug}`);
            if (dialog) {
                dialog.showModal();
            }
        };

        // Format injected links/images inside modals
        const dialogs = document.querySelectorAll('dialog');
        dialogs.forEach(dialog => {
            const images = dialog.querySelectorAll('img');
            images.forEach(img => {
                img.className = "rounded-lg border shadow-sm my-4 max-w-full mx-auto object-cover h-auto";
            });
            const links = dialog.querySelectorAll('a');
            links.forEach(link => {
                link.className = "text-primary dark:text-accent font-semibold hover:underline";
            });
        });
    });
</script>
@endsection
