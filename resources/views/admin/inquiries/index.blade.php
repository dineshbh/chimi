<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">Lead Management</p>
                <h1 class="mt-1 text-2xl font-bold text-foreground">Travel Inquiries</h1>
            </div>
            <a 
                href="{{ route('dashboard') }}" 
                class="inline-flex h-9 items-center justify-center rounded-md border border-border bg-background px-3 text-xs font-semibold text-foreground transition-colors hover:bg-muted"
            >
                Control Panel
            </a>
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

            <div class="rounded-lg border border-border bg-card shadow-sm">
                <div class="flex flex-col gap-4 border-b border-border p-5 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-foreground">Inbox</h2>
                        <p class="text-xs text-muted-foreground">Review, contact, and clean up submitted travel inquiries.</p>
                    </div>
                    <form action="{{ route('admin.inquiries.index') }}" method="GET" class="relative w-full md:max-w-sm">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-muted-foreground">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </span>
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ $search }}"
                            placeholder="Search name, email, package, message..." 
                            class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 pl-10 text-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
                        >
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="border-b border-border bg-muted/50 text-xs uppercase tracking-wider text-muted-foreground">
                            <tr>
                                <th class="px-5 py-3 font-semibold">Lead</th>
                                <th class="px-5 py-3 font-semibold">Package</th>
                                <th class="px-5 py-3 font-semibold">Message</th>
                                <th class="px-5 py-3 font-semibold">Received</th>
                                <th class="px-5 py-3 text-right font-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border">
                            @forelse($inquiries as $inquiry)
                                <tr class="align-top hover:bg-muted/30">
                                    <td class="px-5 py-4">
                                        <p class="font-semibold text-foreground">{{ $inquiry->name }}</p>
                                        <div class="mt-1 space-y-1 text-xs">
                                            <a href="mailto:{{ $inquiry->email }}" class="block text-primary hover:underline dark:text-accent">{{ $inquiry->email }}</a>
                                            @if($inquiry->phone)
                                                <a href="tel:{{ $inquiry->phone }}" class="block text-muted-foreground hover:text-foreground">{{ $inquiry->phone }}</a>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-5 py-4">
                                        <span class="inline-flex max-w-[220px] items-center rounded-md bg-secondary px-2 py-1 text-xs font-semibold text-secondary-foreground">
                                            {{ $inquiry->package ?: 'Custom inquiry' }}
                                        </span>
                                    </td>
                                    <td class="max-w-xl px-5 py-4 text-xs leading-relaxed text-muted-foreground">
                                        {{ $inquiry->message }}
                                    </td>
                                    <td class="whitespace-nowrap px-5 py-4 text-xs text-muted-foreground">
                                        <span class="block font-semibold text-foreground">{{ $inquiry->created_at->format('M j, Y') }}</span>
                                        <span>{{ $inquiry->created_at->format('g:i A') }}</span>
                                    </td>
                                    <td class="px-5 py-4 text-right">
                                        <div class="flex justify-end gap-2">
                                            <a 
                                                href="mailto:{{ $inquiry->email }}?subject={{ rawurlencode('Access Bhutan inquiry: ' . ($inquiry->package ?: 'Custom trip')) }}"
                                                class="inline-flex h-8 items-center rounded-md bg-secondary px-3 text-xs font-semibold text-secondary-foreground transition-colors hover:bg-secondary/80"
                                            >
                                                Reply
                                            </a>
                                            <form action="{{ route('admin.inquiries.destroy', ['id' => $inquiry->id]) }}" method="POST" onsubmit="return confirm('Delete this inquiry?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex h-8 items-center rounded-md bg-destructive px-3 text-xs font-semibold text-destructive-foreground transition-colors hover:bg-destructive/90">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-5 py-12 text-center text-sm font-medium text-muted-foreground">
                                        No inquiries found.
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
