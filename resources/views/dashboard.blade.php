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

            <!-- Visitor Traffic & Analytics -->
            <section class="space-y-6">
                <div class="border-b border-border pb-3">
                    <h2 class="text-xl font-extrabold tracking-tight text-foreground">Visitor Traffic Insights</h2>
                    <p class="text-xs text-muted-foreground">Real-time traffic statistics, geolocation, and device tracking details.</p>
                </div>

                <!-- Analytics Cards -->
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <!-- Views Today -->
                    <article class="rounded-lg border border-border bg-card p-5 shadow-sm">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">Views Today</p>
                                <p class="mt-3 text-3xl font-bold text-foreground">{{ number_format($analytics['views_today']) }}</p>
                                <p class="mt-1 text-xs text-muted-foreground">out of {{ number_format($analytics['total_views']) }} total views</p>
                            </div>
                            <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-md bg-indigo-500/10 text-indigo-500">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </span>
                        </div>
                    </article>

                    <!-- Unique Visitors Today -->
                    <article class="rounded-lg border border-border bg-card p-5 shadow-sm">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">Unique Visitors Today</p>
                                <p class="mt-3 text-3xl font-bold text-foreground">{{ number_format($analytics['unique_today']) }}</p>
                                <p class="mt-1 text-xs text-muted-foreground">out of {{ number_format($analytics['unique_visitors']) }} total uniques</p>
                            </div>
                            <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-md bg-sky-500/10 text-sky-500">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            </span>
                        </div>
                    </article>

                    <!-- Proxy Views -->
                    <article class="rounded-lg border border-border bg-card p-5 shadow-sm">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">Proxy Traffic</p>
                                <p class="mt-3 text-3xl font-bold text-foreground">{{ number_format($analytics['proxy_views']) }}</p>
                                <p class="mt-1 text-xs text-muted-foreground">
                                    @if($analytics['total_views'] > 0)
                                        {{ round(($analytics['proxy_views'] / $analytics['total_views']) * 100, 1) }}% of total page views
                                    @else
                                        0% of total page views
                                    @endif
                                </p>
                            </div>
                            <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-md bg-amber-500/10 text-amber-500">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            </span>
                        </div>
                    </article>

                    <!-- Total Pages / Efficiency -->
                    <article class="rounded-lg border border-border bg-card p-5 shadow-sm">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">Views per Visitor</p>
                                <p class="mt-3 text-3xl font-bold text-foreground">
                                    @if($analytics['unique_visitors'] > 0)
                                        {{ round($analytics['total_views'] / $analytics['unique_visitors'], 2) }}
                                    @else
                                        0
                                    @endif
                                </p>
                                <p class="mt-1 text-xs text-muted-foreground">Average page engagement depth</p>
                            </div>
                            <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-md bg-emerald-500/10 text-emerald-500">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                            </span>
                        </div>
                    </article>
                </div>

                <!-- Breakdown row -->
                <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                    <!-- Top Countries -->
                    <div class="rounded-lg border border-border bg-card p-5 shadow-sm">
                        <h3 class="text-sm font-bold text-foreground">Top Country Traffic</h3>
                        <div class="mt-4 space-y-3">
                            @forelse($analytics['countries'] as $country)
                                <div class="flex items-center justify-between gap-3 text-xs">
                                    <div class="flex items-center gap-2">
                                        <span class="inline-block h-2 w-2 rounded-full bg-indigo-500"></span>
                                        <span class="font-semibold text-foreground">{{ $country->country ?: 'Unknown' }}</span>
                                    </div>
                                    <span class="text-muted-foreground font-bold">{{ number_format($country->total) }} views</span>
                                </div>
                            @empty
                                <p class="py-6 text-center text-xs text-muted-foreground">No country data captured yet.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Device splits -->
                    <div class="rounded-lg border border-border bg-card p-5 shadow-sm">
                        <h3 class="text-sm font-bold text-foreground">Devices</h3>
                        <div class="mt-4 space-y-3">
                            @php
                                $deviceIcons = [
                                    'desktop' => 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
                                    'mobile' => 'M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z',
                                    'tablet' => 'M12 18h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z',
                                    'robot' => 'M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z',
                                ];
                                $deviceColors = [
                                    'desktop' => 'text-blue-500 bg-blue-500/10',
                                    'mobile' => 'text-emerald-500 bg-emerald-500/10',
                                    'tablet' => 'text-purple-500 bg-purple-500/10',
                                    'robot' => 'text-amber-500 bg-amber-500/10',
                                ];
                            @endphp
                            @forelse($analytics['devices'] as $device)
                                <div class="flex items-center justify-between gap-3 text-xs">
                                    <div class="flex items-center gap-2">
                                        <span class="inline-flex h-6 w-6 items-center justify-center rounded {{ $deviceColors[$device->device_type] ?? 'text-slate-500 bg-slate-500/10' }}">
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $deviceIcons[$device->device_type] ?? 'M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 009 11c0-1.28-.19-2.5-.54-3.648M12 11c0-3.517 1.009-6.799 2.753-9.571m3.44 2.04l-.054.09A13.916 13.916 0 0015 11c0 1.28.19 2.5.54 3.648M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z' }}"/>
                                            </svg>
                                        </span>
                                        <span class="font-semibold capitalize text-foreground">{{ $device->device_type }}</span>
                                    </div>
                                    <span class="text-muted-foreground font-bold">{{ number_format($device->total) }} views</span>
                                </div>
                            @empty
                                <p class="py-6 text-center text-xs text-muted-foreground">No device data captured yet.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Top Pages -->
                    <div class="rounded-lg border border-border bg-card p-5 shadow-sm">
                        <h3 class="text-sm font-bold text-foreground">Top Visited Paths</h3>
                        <div class="mt-4 space-y-3">
                            @forelse($analytics['pages'] as $page)
                                <div class="flex items-center justify-between gap-3 text-xs">
                                    <span class="truncate font-mono font-semibold text-foreground hover:text-primary dark:hover:text-accent" title="{{ $page->url_path }}">{{ $page->url_path }}</span>
                                    <span class="text-muted-foreground font-bold shrink-0 font-sans">{{ number_format($page->total) }} views</span>
                                </div>
                            @empty
                                <p class="py-6 text-center text-xs text-muted-foreground">No path traffic recorded yet.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Live traffic log stream -->
                <div class="rounded-lg border border-border bg-card shadow-sm">
                    <div class="border-b border-border p-5">
                        <h3 class="text-lg font-bold text-foreground">Live Traffic Stream</h3>
                        <p class="text-xs text-muted-foreground">Activity logs for the latest visitors browsing the portal.</p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="border-b border-border bg-muted/50 text-xs uppercase tracking-wider text-muted-foreground">
                                <tr>
                                    <th class="px-5 py-3 font-semibold">IP Address</th>
                                    <th class="px-5 py-3 font-semibold">Location</th>
                                    <th class="px-5 py-3 font-semibold">Platform & Agent</th>
                                    <th class="px-5 py-3 font-semibold">Destination Path</th>
                                    <th class="px-5 py-3 font-semibold text-right">Activity Time</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border">
                                @forelse($analytics['live_stream'] as $log)
                                    <tr class="align-middle hover:bg-muted/30">
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-2">
                                                <span class="font-mono font-bold text-foreground">{{ $log->ip_address }}</span>
                                                @if($log->is_proxy)
                                                    <span class="inline-flex items-center rounded-full bg-amber-500/10 px-2 py-0.5 text-[10px] font-semibold text-amber-600 dark:text-amber-400" title="Proxy connection detected: {{ json_encode($log->proxy_headers) }}">
                                                        Proxy
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-5 py-4">
                                            <p class="font-semibold text-foreground">{{ $log->city ?: 'Unknown' }}</p>
                                            <p class="text-xs text-muted-foreground">{{ $log->country ?: 'Unknown' }}</p>
                                        </td>
                                        <td class="px-5 py-4">
                                            <p class="font-semibold text-foreground">{{ $log->platform ?: 'Unknown' }} ({{ $log->device_type }})</p>
                                            <p class="text-xs text-muted-foreground max-w-[200px] truncate" title="{{ $log->user_agent }}">{{ $log->browser ?: 'Unknown' }}</p>
                                        </td>
                                        <td class="px-5 py-4">
                                            <span class="font-mono text-xs text-primary dark:text-accent font-semibold">{{ $log->url_path }}</span>
                                            @if($log->referer)
                                                <p class="text-[10px] text-muted-foreground max-w-[220px] truncate" title="{{ $log->referer }}">Ref: {{ $log->referer }}</p>
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-5 py-4 text-right text-xs text-muted-foreground font-medium">
                                            {{ $log->created_at->diffForHumans() }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-5 py-10 text-center text-sm font-medium text-muted-foreground">No traffic has been logged yet. Visit client pages to populate this.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
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
