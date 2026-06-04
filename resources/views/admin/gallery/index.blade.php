<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight font-serif">
                {{ __('Gallery & Media Manager') }}
            </h2>
            <a 
                href="{{ route('dashboard') }}" 
                class="text-xs font-semibold text-primary dark:text-accent hover:underline flex items-center gap-1 uppercase tracking-wider"
            >
                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/></svg>
                Control Panel
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 dark:bg-slate-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Session Success Banner -->
            @if(session('success'))
                <div class="p-4 rounded-lg bg-emerald-500/10 border border-emerald-500/30 text-emerald-600 dark:text-emerald-400 text-sm flex gap-3">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Toolbar Header Card -->
            <div class="bg-card border rounded-xl shadow-sm p-6 flex flex-col md:flex-row gap-4 items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-foreground font-serif">Bhutan Photo Gallery</h3>
                    <p class="text-xs text-muted-foreground mt-0.5">Upload new local photos or manage existing background sliders and tour photos.</p>
                </div>
                
                <div class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto">
                    <!-- Search Input -->
                    <form action="{{ route('admin.gallery.index') }}" method="GET" class="relative w-full sm:max-w-xs">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-muted-foreground">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </span>
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ $search }}"
                            placeholder="Search gallery..." 
                            class="flex h-9 w-full rounded-md border border-input bg-background px-3 py-1 pl-10 text-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
                        >
                    </form>
                    <a 
                        href="{{ route('admin.gallery.create') }}" 
                        class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-xs font-semibold ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring bg-primary text-primary-foreground hover:bg-primary/90 h-9 px-4 w-full sm:w-auto"
                    >
                        Add Gallery Image
                    </a>
                </div>
            </div>

            <!-- Media Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($images as $img)
                    <div class="bg-card border rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between group">
                        <!-- Image Preview -->
                        <div class="relative aspect-video w-full bg-slate-100 overflow-hidden">
                            <img 
                                src="{{ $img->url }}" 
                                alt="{{ $img->title }}" 
                                class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-300"
                                loading="lazy"
                            >
                            <span class="absolute bottom-2 right-2 bg-slate-900/80 text-[10px] text-white font-medium px-2 py-0.5 rounded backdrop-blur-xs">
                                {{ str_contains($img->url, 'storage/') ? 'Uploaded' : 'Remote' }}
                            </span>
                        </div>

                        <!-- Card Body -->
                        <div class="p-4 flex-grow space-y-1">
                            <h4 class="font-bold text-sm text-foreground truncate" title="{{ $img->title }}">
                                {{ $img->title }}
                            </h4>
                            <p class="text-xs text-muted-foreground line-clamp-2" title="{{ $img->desc }}">
                                {{ $img->desc ?: 'No description provided.' }}
                            </p>
                        </div>

                        <!-- Actions Footer -->
                        <div class="p-4 pt-0 border-t border-border/50 flex items-center justify-between mt-3">
                            <a 
                                href="{{ $img->url }}" 
                                target="_blank"
                                class="text-[11px] font-semibold text-primary dark:text-accent hover:underline"
                            >
                                View Original
                            </a>
                            <form action="{{ route('admin.gallery.destroy', ['id' => $img->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this image from the gallery?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button 
                                    type="submit" 
                                    class="text-[11px] font-semibold text-destructive hover:underline"
                                >
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-card border rounded-xl p-12 text-center text-muted-foreground">
                        <svg class="h-10 w-10 mx-auto text-muted-foreground/60 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <p class="text-sm font-semibold text-foreground">No media assets found</p>
                        <p class="text-xs text-muted-foreground mt-1">Upload a photo to get started with the travel gallery.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
