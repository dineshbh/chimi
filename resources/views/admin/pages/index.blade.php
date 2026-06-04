<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight font-serif">
                {{ __('Dynamic Content Pages Manager') }}
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

            <!-- Content Card -->
            <div class="bg-card border rounded-xl shadow-sm overflow-hidden">
                <!-- Toolbar Header -->
                <div class="p-6 border-b flex flex-col md:flex-row gap-4 items-center justify-between bg-card">
                    <div>
                        <h3 class="text-lg font-bold text-foreground font-serif">General Content Pages</h3>
                        <p class="text-xs text-muted-foreground mt-0.5">Filter by category section to manage text guides and destinations.</p>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto">
                        <!-- Type Filter Selector -->
                        <form action="{{ route('admin.pages.index') }}" method="GET" class="relative w-full sm:max-w-xs">
                            <select 
                                name="type" 
                                onchange="this.form.submit()"
                                class="flex h-9 w-full rounded-md border border-input bg-background px-3 py-1 text-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
                            >
                                <option value="">-- All Content Sections --</option>
                                <option value="about" {{ $type === 'about' ? 'selected' : '' }}>About sections</option>
                                <option value="info" {{ $type === 'info' ? 'selected' : '' }}>Travel Info guides</option>
                                <option value="destination" {{ $type === 'destination' ? 'selected' : '' }}>Himalayan Valleys (Destinations)</option>
                                <option value="category" {{ $type === 'category' ? 'selected' : '' }}>Tour Categories</option>
                                <option value="trekking" {{ $type === 'trekking' ? 'selected' : '' }}>Trekking trail details</option>
                                <option value="festival" {{ $type === 'festival' ? 'selected' : '' }}>Festival schedules</option>
                                <option value="other" {{ $type === 'other' ? 'selected' : '' }}>Utility pages</option>
                            </select>
                        </form>
                        <a 
                            href="{{ route('admin.pages.create') }}" 
                            class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-xs font-semibold ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring bg-primary text-primary-foreground hover:bg-primary/90 h-9 px-4 w-full sm:w-auto"
                        >
                            Add Content Page
                        </a>
                    </div>
                </div>

                <!-- Table Content -->
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-muted-foreground">
                        <thead class="bg-muted/40 text-xs uppercase text-foreground border-b font-semibold">
                            <tr>
                                <th scope="col" class="px-6 py-4">Title</th>
                                <th scope="col" class="px-6 py-4">Section Type</th>
                                <th scope="col" class="px-6 py-4">Slug Identifier</th>
                                <th scope="col" class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border/60">
                            @forelse($pages as $page)
                                <tr class="hover:bg-muted/10 transition-colors">
                                    <td class="px-6 py-4 font-medium text-foreground max-w-xs truncate" title="{{ $page->title }}">
                                        {{ $page->title }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $badgeColor = 'bg-primary/10 text-primary dark:text-accent';
                                            if ($page->type === 'destination') $badgeColor = 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400';
                                            elseif ($page->type === 'trekking') $badgeColor = 'bg-cyan-500/10 text-cyan-600 dark:text-cyan-400';
                                            elseif ($page->type === 'festival') $badgeColor = 'bg-amber-500/10 text-amber-600 dark:text-amber-400';
                                            elseif ($page->type === 'about') $badgeColor = 'bg-indigo-500/10 text-indigo-600 dark:text-indigo-400';
                                        @endphp
                                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold uppercase tracking-wider {{ $badgeColor }}">
                                            {{ $page->type }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 font-mono text-xs">{{ $page->slug }}</td>
                                    <td class="px-6 py-4 text-right flex items-center justify-end gap-2">
                                        <a 
                                            href="{{ route('admin.pages.edit', ['id' => $page->id]) }}" 
                                            class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-xs font-semibold bg-secondary text-secondary-foreground hover:bg-secondary/80 h-8 px-3 transition-colors"
                                        >
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.pages.destroy', ['id' => $page->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this content page?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button 
                                                type="submit" 
                                                class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-xs font-semibold bg-destructive text-destructive-foreground hover:bg-destructive/90 h-8 px-3 transition-colors"
                                            >
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-muted-foreground font-medium">
                                        No content pages found matching your selections.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
