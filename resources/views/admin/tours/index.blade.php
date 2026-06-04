<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight font-serif">
                {{ __('Tour Packages Manager') }}
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
            <!-- Session success feedback banner -->
            @if(session('success'))
                <div class="p-4 rounded-lg bg-emerald-500/10 border border-emerald-500/30 text-emerald-600 dark:text-emerald-400 text-sm flex gap-3">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Table Card -->
            <div class="bg-card border rounded-xl shadow-sm overflow-hidden">
                <!-- Toolbar Header -->
                <div class="p-6 border-b flex flex-col md:flex-row gap-4 items-center justify-between bg-card">
                    <div>
                        <h3 class="text-lg font-bold text-foreground font-serif">Seeded Travel Packages</h3>
                        <p class="text-xs text-muted-foreground mt-0.5">Filter or select an itinerary package to modify settings.</p>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto">
                        <!-- Search Input -->
                        <form action="{{ route('admin.tours.index') }}" method="GET" class="relative w-full sm:max-w-xs">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-muted-foreground">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </span>
                            <input 
                                type="text" 
                                name="search" 
                                value="{{ $search }}"
                                placeholder="Search by title..." 
                                class="flex h-9 w-full rounded-md border border-input bg-background px-3 py-1 pl-10 text-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
                            >
                        </form>
                        <a 
                            href="{{ route('admin.tours.create') }}" 
                            class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-xs font-semibold ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring bg-primary text-primary-foreground hover:bg-primary/90 h-9 px-4 w-full sm:w-auto"
                        >
                            Add Tour Package
                        </a>
                    </div>
                </div>

                <!-- Table Content -->
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-muted-foreground">
                        <thead class="bg-muted/40 text-xs uppercase text-foreground border-b font-semibold">
                            <tr>
                                <th scope="col" class="px-6 py-4">Title</th>
                                <th scope="col" class="px-6 py-4">Category</th>
                                <th scope="col" class="px-6 py-4">Duration</th>
                                <th scope="col" class="px-6 py-4">Price</th>
                                <th scope="col" class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border/60">
                            @forelse($tours as $tour)
                                <tr class="hover:bg-muted/10 transition-colors">
                                    <td class="px-6 py-4 font-medium text-foreground max-w-xs truncate" title="{{ $tour->title }}">
                                        {{ $tour->title }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $badgeColor = 'bg-primary/10 text-primary dark:text-accent';
                                            if ($tour->category === 'trekking') $badgeColor = 'bg-cyan-500/10 text-cyan-600 dark:text-cyan-400';
                                            elseif ($tour->category === 'festival') $badgeColor = 'bg-amber-500/10 text-amber-600 dark:text-amber-400';
                                            elseif ($tour->category === 'hiking') $badgeColor = 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400';
                                            elseif ($tour->category === 'homestay') $badgeColor = 'bg-indigo-500/10 text-indigo-600 dark:text-indigo-400';
                                            elseif ($tour->category === 'luxury') $badgeColor = 'bg-rose-500/10 text-rose-600 dark:text-rose-400';
                                        @endphp
                                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold uppercase tracking-wider {{ $badgeColor }}">
                                            {{ $tour->category }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-foreground">{{ $tour->duration }}</td>
                                    <td class="px-6 py-4 font-semibold text-foreground">{{ $tour->price ?: 'Not Set' }}</td>
                                    <td class="px-6 py-4 text-right flex items-center justify-end gap-2">
                                        <a 
                                            href="{{ route('admin.tours.edit', ['id' => $tour->id]) }}" 
                                            class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-xs font-semibold bg-secondary text-secondary-foreground hover:bg-secondary/80 h-8 px-3 transition-colors"
                                        >
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.tours.destroy', ['id' => $tour->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this tour package?');" class="inline">
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
                                    <td colspan="5" class="px-6 py-12 text-center text-muted-foreground font-medium">
                                        No tour packages found matching your criteria.
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
