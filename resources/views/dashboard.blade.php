<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">Access Bhutan Operations</p>
                <h1 class="mt-1 text-2xl font-bold text-foreground">Enterprise Admin Panel</h1>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                @foreach($quickActions as $action)
                    <a href="{{ $action['url'] }}" class="inline-flex h-9 items-center justify-center rounded-md border border-border bg-background px-3 text-xs font-semibold text-foreground transition-colors hover:bg-muted focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring">
                        {{ $action['label'] }}
                    </a>
                @endforeach
            </div>
        </div>
    </x-slot>

    <div class="min-h-screen bg-slate-50 py-8 dark:bg-slate-950">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="flex items-start gap-3 rounded-lg border border-emerald-500/30 bg-emerald-500/10 p-4 text-sm font-medium text-emerald-700 dark:text-emerald-300">
                    <svg class="mt-0.5 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <section class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
                @php
                    $metrics = [
                        ['label' => 'Tour packages', 'value' => $toursCount, 'caption' => 'Sellable itineraries', 'icon' => 'M12 19l9 2-9-18-9 18 9-2zm0 0v-8'],
                        ['label' => 'Content pages', 'value' => $pagesCount, 'caption' => 'Destinations and guides', 'icon' => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 4a2 2 0 012 2v6a2 2 0 01-2 2h-2'],
                        ['label' => 'Total leads', 'value' => $inquiriesCount, 'caption' => $inquiriesThisMonth . ' this month', 'icon' => 'M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.86 9.86 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z'],
                        ['label' => 'Media assets', 'value' => $galleryCount, 'caption' => 'Gallery inventory', 'icon' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z'],
                    ];
                @endphp

                @foreach($metrics as $metric)
                    <article class="rounded-lg border border-border bg-card p-5 shadow-sm">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ $metric['label'] }}</p>
                                <p class="mt-3 text-3xl font-bold text-foreground">{{ number_format($metric['value']) }}</p>
                                <p class="mt-1 text-xs text-muted-foreground">{{ $metric['caption'] }}</p>
                            </div>
                            <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-md bg-primary/10 text-primary dark:text-accent">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $metric['icon'] }}"/></svg>
                            </span>
                        </div>
                    </article>
                @endforeach
            </section>

            <section class="grid grid-cols-1 gap-6 xl:grid-cols-[minmax(0,1.35fr)_minmax(360px,0.65fr)]">
                <div class="rounded-lg border border-border bg-card shadow-sm">
                    <div class="flex flex-col gap-3 border-b border-border p-5 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h2 class="text-lg font-bold text-foreground">Lead Pipeline</h2>
                            <p class="text-xs text-muted-foreground">Recent inquiries from contact and planning forms.</p>
                        </div>
                        <div class="flex flex-wrap items-center gap-2">
                            <a href="{{ route('admin.inquiries.index') }}" class="inline-flex h-9 items-center rounded-md border border-border bg-background px-3 text-xs font-semibold text-foreground transition-colors hover:bg-muted">
                                View all leads
                            </a>
                            <div class="inline-flex items-center gap-2 rounded-md bg-muted px-3 py-2 text-xs font-semibold text-foreground">
                                <span class="{{ $leadGrowth >= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-destructive' }}">{{ $leadGrowth >= 0 ? '+' : '' }}{{ $leadGrowth }}%</span>
                                month over month
                            </div>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="border-b border-border bg-muted/50 text-xs uppercase tracking-wider text-muted-foreground">
                                <tr>
                                    <th class="px-5 py-3 font-semibold">Contact</th>
                                    <th class="px-5 py-3 font-semibold">Package</th>
                                    <th class="px-5 py-3 font-semibold">Message</th>
                                    <th class="px-5 py-3 font-semibold text-right">Received</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border">
                                @forelse($recentInquiries as $inquiry)
                                    <tr class="align-top hover:bg-muted/30">
                                        <td class="px-5 py-4">
                                            <p class="font-semibold text-foreground">{{ $inquiry->name }}</p>
                                            <a href="mailto:{{ $inquiry->email }}" class="text-xs text-primary hover:underline dark:text-accent">{{ $inquiry->email }}</a>
                                            @if($inquiry->phone)
                                                <p class="mt-1 text-xs text-muted-foreground">{{ $inquiry->phone }}</p>
                                            @endif
                                        </td>
                                        <td class="px-5 py-4">
                                            <span class="inline-flex max-w-[180px] items-center rounded-md bg-secondary px-2 py-1 text-xs font-semibold text-secondary-foreground">
                                                {{ $inquiry->package ?: 'Custom inquiry' }}
                                            </span>
                                        </td>
                                        <td class="max-w-md px-5 py-4 text-xs leading-relaxed text-muted-foreground">
                                            {{ \Illuminate\Support\Str::limit($inquiry->message, 120) }}
                                        </td>
                                        <td class="whitespace-nowrap px-5 py-4 text-right text-xs text-muted-foreground">
                                            {{ $inquiry->created_at->diffForHumans() }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-5 py-10 text-center text-sm font-medium text-muted-foreground">No inquiries have been submitted yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <aside class="space-y-6">
                    <div class="rounded-lg border border-border bg-card p-5 shadow-sm">
                        <h2 class="text-lg font-bold text-foreground">Priority Queue</h2>
                        <div class="mt-4 space-y-3">
                            @foreach($priorityActions as $action)
                                <a href="{{ $action['url'] }}" class="flex items-center justify-between gap-4 rounded-md border border-border p-3 transition-colors hover:bg-muted/40">
                                    <div>
                                        <p class="text-sm font-semibold text-foreground">{{ $action['title'] }}</p>
                                        <p class="mt-1 text-xs text-muted-foreground">{{ $action['count'] }} {{ $action['label'] }}</p>
                                    </div>
                                    <span class="h-2.5 w-2.5 shrink-0 rounded-full {{ $action['level'] === 'high' ? 'bg-destructive' : ($action['level'] === 'medium' ? 'bg-amber-500' : 'bg-emerald-500') }}"></span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <div class="rounded-lg border border-border bg-card p-5 shadow-sm">
                        <h2 class="text-lg font-bold text-foreground">Content Health</h2>
                        <div class="mt-5 space-y-5">
                            @foreach($contentHealthChecks as $check)
                                <div>
                                    <div class="flex items-center justify-between gap-3 text-xs">
                                        <span class="font-semibold text-foreground">{{ $check['label'] }}</span>
                                        <span class="text-muted-foreground">{{ $check['complete'] }}/{{ $check['total'] }}</span>
                                    </div>
                                    <div class="mt-2 h-2 rounded-full bg-muted">
                                        <div class="h-2 rounded-full bg-primary dark:bg-accent" style="width: {{ $check['percent'] }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </aside>
            </section>

            <section class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
                @php
                    $managementModules = [
                        ['title' => 'Product Pages', 'caption' => 'Tours, pricing, itineraries, FAQs, reviews', 'count' => $toursCount, 'index' => route('admin.tours.index'), 'create' => route('admin.tours.create')],
                        ['title' => 'Content Pages', 'caption' => 'Destinations, guide pages, categories, SEO copy', 'count' => $pagesCount, 'index' => route('admin.pages.index'), 'create' => route('admin.pages.create')],
                        ['title' => 'Media Library', 'caption' => 'Gallery images and reusable hero assets', 'count' => $galleryCount, 'index' => route('admin.gallery.index'), 'create' => route('admin.gallery.create')],
                        ['title' => 'Customer Leads', 'caption' => 'Submitted contact and trip planning requests', 'count' => $inquiriesCount, 'index' => route('admin.inquiries.index'), 'create' => null],
                    ];
                @endphp

                @foreach($managementModules as $module)
                    <div class="rounded-lg border border-border bg-card p-5 shadow-sm">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h2 class="text-base font-bold text-foreground">{{ $module['title'] }}</h2>
                                <p class="mt-1 text-xs leading-relaxed text-muted-foreground">{{ $module['caption'] }}</p>
                            </div>
                            <span class="rounded-md bg-muted px-2.5 py-1 text-xs font-bold text-foreground">{{ $module['count'] }}</span>
                        </div>
                        <div class="mt-5 flex gap-2">
                            <a href="{{ $module['index'] }}" class="inline-flex h-9 flex-1 items-center justify-center rounded-md bg-primary px-3 text-xs font-semibold text-primary-foreground transition-colors hover:bg-primary/90">
                                Manage
                            </a>
                            @if($module['create'])
                                <a href="{{ $module['create'] }}" class="inline-flex h-9 flex-1 items-center justify-center rounded-md border border-border bg-background px-3 text-xs font-semibold text-foreground transition-colors hover:bg-muted">
                                    Add new
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </section>

            <section class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <div class="rounded-lg border border-border bg-card p-5 shadow-sm">
                    <div class="flex items-center justify-between gap-3">
                        <h2 class="text-lg font-bold text-foreground">Tour Mix</h2>
                        <a href="{{ route('admin.tours.index') }}" class="text-xs font-semibold text-primary hover:underline dark:text-accent">Manage</a>
                    </div>
                    <div class="mt-4 space-y-3">
                        @forelse($tourCategories as $category)
                            <div class="flex items-center justify-between gap-3 rounded-md bg-muted/40 px-3 py-2">
                                <span class="text-sm font-medium capitalize text-foreground">{{ $category->category }}</span>
                                <span class="text-xs font-bold text-muted-foreground">{{ $category->total }}</span>
                            </div>
                        @empty
                            <p class="py-6 text-center text-sm text-muted-foreground">No tour categories yet.</p>
                        @endforelse
                    </div>
                </div>

                <div class="rounded-lg border border-border bg-card p-5 shadow-sm">
                    <div class="flex items-center justify-between gap-3">
                        <h2 class="text-lg font-bold text-foreground">Page Sections</h2>
                        <a href="{{ route('admin.pages.index') }}" class="text-xs font-semibold text-primary hover:underline dark:text-accent">Manage</a>
                    </div>
                    <div class="mt-4 space-y-3">
                        @forelse($pageSections as $section)
                            <div class="flex items-center justify-between gap-3 rounded-md bg-muted/40 px-3 py-2">
                                <span class="text-sm font-medium capitalize text-foreground">{{ $section->type }}</span>
                                <span class="text-xs font-bold text-muted-foreground">{{ $section->total }}</span>
                            </div>
                        @empty
                            <p class="py-6 text-center text-sm text-muted-foreground">No dynamic page sections yet.</p>
                        @endforelse
                    </div>
                </div>

                <div class="rounded-lg border border-border bg-card p-5 shadow-sm">
                    <div class="flex items-center justify-between gap-3">
                        <h2 class="text-lg font-bold text-foreground">Recent Content</h2>
                        <a href="{{ route('admin.pages.create') }}" class="text-xs font-semibold text-primary hover:underline dark:text-accent">Add page</a>
                    </div>
                    <div class="mt-4 space-y-4">
                        @foreach($recentPages as $page)
                            <a href="{{ route('admin.pages.edit', ['id' => $page->id]) }}" class="block rounded-md border border-border p-3 transition-colors hover:bg-muted/40">
                                <div class="flex items-center justify-between gap-3">
                                    <p class="truncate text-sm font-semibold text-foreground">{{ $page->title }}</p>
                                    <span class="shrink-0 text-xs capitalize text-muted-foreground">{{ $page->type }}</span>
                                </div>
                                <p class="mt-1 text-xs text-muted-foreground">{{ $page->updated_at->diffForHumans() }}</p>
                            </a>
                        @endforeach
                        @foreach($recentTours as $tour)
                            <a href="{{ route('admin.tours.edit', ['id' => $tour->id]) }}" class="block rounded-md border border-border p-3 transition-colors hover:bg-muted/40">
                                <div class="flex items-center justify-between gap-3">
                                    <p class="truncate text-sm font-semibold text-foreground">{{ $tour->title }}</p>
                                    <span class="shrink-0 text-xs capitalize text-muted-foreground">{{ $tour->category }}</span>
                                </div>
                                <p class="mt-1 text-xs text-muted-foreground">{{ $tour->updated_at->diffForHumans() }}</p>
                            </a>
                        @endforeach
                        @if($recentPages->isEmpty() && $recentTours->isEmpty())
                            <p class="py-6 text-center text-sm text-muted-foreground">No content updates yet.</p>
                        @endif
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
