@props([
    'id',
    'tabs' => [], // Array of associative arrays, e.g. ['key' => 'label']
    'active' => '',
])

<div id="{{ $id }}" class="w-full">
    <!-- Tabs Header List -->
    <div class="mb-6 overflow-x-auto rounded-lg border border-border bg-muted/45 p-1 shadow-sm no-scrollbar">
        <div class="flex min-w-max gap-1 whitespace-nowrap">
        @foreach($tabs as $key => $label)
            <button 
                type="button"
                data-tab-trigger="{{ $key }}"
                class="h-10 rounded-md px-3.5 text-[13px] font-semibold leading-none transition-all duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-ring {{ $key === $active ? 'bg-card text-primary shadow-sm dark:text-accent' : 'text-muted-foreground hover:bg-background/70 hover:text-foreground' }}"
            >
                {{ $label }}
            </button>
        @endforeach
        </div>
    </div>

    <!-- Tabs Content Container -->
    <div class="tabs-content">
        {{ $slot }}
    </div>
</div>

<script>
    (function() {
        const container = document.getElementById('{{ $id }}');
        if (container && !container.hasAttribute('data-tabs-registered')) {
            container.setAttribute('data-tabs-registered', 'true');
            const triggers = container.querySelectorAll('[data-tab-trigger]');
            const contents = container.querySelectorAll('[data-tab-content]');
            
            triggers.forEach(trigger => {
                trigger.addEventListener('click', () => {
                    const target = trigger.getAttribute('data-tab-trigger');
                    
                    // Update active trigger styling
                    triggers.forEach(t => {
                        if (t.getAttribute('data-tab-trigger') === target) {
                            t.className = "h-10 rounded-md px-3.5 text-[13px] font-semibold leading-none transition-all duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-ring bg-card text-primary shadow-sm dark:text-accent";
                        } else {
                            t.className = "h-10 rounded-md px-3.5 text-[13px] font-semibold leading-none transition-all duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-ring text-muted-foreground hover:bg-background/70 hover:text-foreground";
                        }
                    });
                    
                    // Show target content, hide others
                    contents.forEach(content => {
                        if (content.getAttribute('data-tab-content') === target) {
                            content.classList.remove('hidden');
                        } else {
                            content.classList.add('hidden');
                        }
                    });
                });
            });
        }
    })();
</script>
