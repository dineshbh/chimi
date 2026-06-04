@props([
    'id',
    'title' => '',
    'description' => '',
])

<dialog id="{{ $id }}" {{ $attributes->merge(['class' => 'sheet-right fixed inset-y-0 right-0 z-50 h-full w-full max-w-md border-l bg-background p-6 shadow-lg outline-none sm:max-w-lg md:max-w-xl transition-all duration-300 dark:border-slate-800']) }}>
    <div class="flex flex-col h-full">
        <!-- Sheet Header -->
        <div class="flex items-center justify-between pb-4 border-b border-border">
            <div>
                @if($title)
                    <h2 class="text-lg font-semibold text-foreground font-serif leading-none tracking-tight">{{ $title }}</h2>
                @endif
                @if($description)
                    <p class="text-sm text-muted-foreground mt-1.5">{{ $description }}</p>
                @endif
            </div>
            <button onclick="document.getElementById('{{ $id }}').close()" class="rounded-sm opacity-70 ring-offset-background transition-opacity hover:opacity-100 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2">
                <svg class="h-5 w-5 text-foreground" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                <span class="sr-only">Close</span>
            </button>
        </div>
        
        <!-- Sheet Content -->
        <div class="flex-1 overflow-y-auto py-6 pr-2">
            {{ $slot }}
        </div>
    </div>
</dialog>

<script>
    // Self-contained script to handle clicking on the backdrop of native dialog to close it
    (function() {
        const dialog = document.getElementById('{{ $id }}');
        if (dialog && !dialog.hasAttribute('data-backdrop-registered')) {
            dialog.setAttribute('data-backdrop-registered', 'true');
            dialog.addEventListener('click', (e) => {
                const rect = dialog.getBoundingClientRect();
                const isInDialog = (
                    rect.top <= e.clientY &&
                    e.clientY <= rect.top + rect.height &&
                    rect.left <= e.clientX &&
                    e.clientX <= rect.left + rect.width
                );
                if (!isInDialog) {
                    dialog.close();
                }
            });
        }
    })();
</script>
