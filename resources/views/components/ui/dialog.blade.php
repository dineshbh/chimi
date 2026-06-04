@props([
    'id',
    'title' => '',
    'description' => '',
])

<dialog id="{{ $id }}" {{ $attributes->merge(['class' => 'fixed inset-0 z-50 m-auto max-h-[85vh] w-[90vw] max-w-2xl rounded-lg border bg-background p-6 shadow-lg outline-none transition-all duration-300 dark:border-slate-800']) }}>
    <div class="flex flex-col h-full max-h-[80vh]">
        <!-- Dialog Header -->
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
        
        <!-- Dialog Content -->
        <div class="flex-1 overflow-y-auto py-6 pr-2">
            {{ $slot }}
        </div>
    </div>
</dialog>

<script>
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
