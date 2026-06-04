@extends('layouts.app')

@section('title', 'Photo Gallery - Bhutan Travel Showcase')
@section('meta_description', 'View stunning photos of Bhutan\'s landmarks, monasteries, dzongs, and local cultures. Experience the visual splendor of the Kingdom of Bhutan.')
@section('meta_keywords', 'Bhutan photos, Bhutan gallery, Bhutan landmarks, Tiger\'s Nest photo, Punakha Dzong gallery')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Header -->
    <div class="text-center mb-12 space-y-2">
        <span class="text-xs font-semibold text-primary dark:text-accent uppercase tracking-wider">Visual Highlights</span>
        <h1 class="text-4xl font-bold font-serif text-foreground">Bhutan Photo Gallery</h1>
        <p class="text-muted-foreground text-base max-w-xl mx-auto">
            A glimpse into the stunning landscapes, ancient fortresses, vibrant festivals, and local lives in the Kingdom of Bhutan.
        </p>
    </div>

    <!-- Gallery Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6" id="gallery-grid">
        @foreach($images as $index => $img)
            <!-- Gallery Item Card -->
            <div 
                class="group relative rounded-lg border bg-card text-card-foreground shadow-sm overflow-hidden aspect-square cursor-pointer hover:shadow-md transition-all duration-300"
                onclick="openLightbox({{ $index }})"
            >
                <img 
                    src="{{ $img['url'] }}" 
                    alt="{{ $img['title'] }}" 
                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105 select-none pointer-events-none"
                >
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/25 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-4">
                    <h3 class="text-white font-bold text-base leading-tight font-serif">{{ $img['title'] }}</h3>
                    <p class="text-slate-300 text-xs mt-1 line-clamp-2">{{ $img['desc'] }}</p>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Global Lightbox Modal -->
<x-ui.dialog id="lightbox-dialog" title="Photo Viewer">
    <div class="flex flex-col items-center">
        <!-- Image Container -->
        <div class="relative w-full overflow-hidden bg-slate-900 rounded-lg border flex items-center justify-center max-h-[60vh] aspect-[4/3]">
            <img id="lightbox-img" src="" alt="" class="max-w-full max-h-full object-contain select-none">
            
            <!-- Navigation controls -->
            <button onclick="prevImage()" class="absolute left-4 top-1/2 -translate-y-1/2 rounded-full bg-black/60 hover:bg-black/80 text-white p-2 text-sm focus:outline-none transition-colors">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <button onclick="nextImage()" class="absolute right-4 top-1/2 -translate-y-1/2 rounded-full bg-black/60 hover:bg-black/80 text-white p-2 text-sm focus:outline-none transition-colors">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/></svg>
            </button>
        </div>
        
        <!-- Info Footer -->
        <div class="w-full mt-4 text-center">
            <h3 id="lightbox-title" class="text-xl font-bold font-serif text-foreground"></h3>
            <p id="lightbox-desc" class="text-sm text-muted-foreground mt-1 max-w-lg mx-auto"></p>
        </div>
    </div>
</x-ui.dialog>

<!-- Script control panel -->
<script>
    const galleryImages = @json($images);
    let currentIndex = 0;

    function openLightbox(index) {
        currentIndex = index;
        updateLightbox();
        document.getElementById('lightbox-dialog').showModal();
    }

    function updateLightbox() {
        const item = galleryImages[currentIndex];
        if (!item) return;

        const dialog = document.getElementById('lightbox-dialog');
        const img = document.getElementById('lightbox-img');
        const title = document.getElementById('lightbox-title');
        const desc = document.getElementById('lightbox-desc');

        // Set properties
        img.src = item.url;
        img.alt = item.title;
        title.innerText = item.title;
        desc.innerText = item.desc;
        dialog.querySelector('h2').innerText = `Gallery Viewer (${currentIndex + 1}/${galleryImages.length})`;
    }

    function prevImage() {
        currentIndex = (currentIndex === 0) ? galleryImages.length - 1 : currentIndex - 1;
        updateLightbox();
    }

    function nextImage() {
        currentIndex = (currentIndex === galleryImages.length - 1) ? 0 : currentIndex + 1;
        updateLightbox();
    }

    // Keydown handlers inside modal for left/right keyboard arrows
    document.addEventListener('keydown', (e) => {
        const dialog = document.getElementById('lightbox-dialog');
        if (dialog && dialog.open) {
            if (e.key === 'ArrowLeft') {
                prevImage();
            } else if (e.key === 'ArrowRight') {
                nextImage();
            }
        }
    });
</script>
@endsection
