<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight font-serif">
                {{ __('Edit Content Page') }}
            </h2>
            <a 
                href="{{ route('admin.pages.index') }}" 
                class="text-xs font-semibold text-primary dark:text-accent hover:underline flex items-center gap-1 uppercase tracking-wider"
            >
                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/></svg>
                Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 dark:bg-slate-900 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- validation errors alert -->
            @if($errors->any())
                <div class="mb-6 p-4 rounded-lg bg-destructive/10 border border-destructive/30 text-destructive text-sm space-y-1">
                    <p class="font-semibold">Please resolve the following errors:</p>
                    <ul class="list-disc list-inside text-xs">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Main Edit Form Card -->
            <x-ui.card class="p-6 md:p-8 bg-card shadow-sm">
                <form action="{{ route('admin.pages.update', ['id' => $page->id]) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <h3 class="text-lg font-bold font-serif border-b pb-3 text-foreground">Page Headers & Meta</h3>

                    <!-- Title & Type Row -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="space-y-1.5 md:col-span-2">
                            <label for="title" class="text-sm font-medium text-foreground">Page Title <span class="text-destructive">*</span></label>
                            <input 
                                type="text" 
                                name="title" 
                                id="title" 
                                required
                                value="{{ old('title', $page->title) }}"
                                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                            >
                        </div>

                        <div class="space-y-1.5">
                            <label for="type" class="text-sm font-medium text-foreground">Content Section <span class="text-destructive">*</span></label>
                            <select 
                                name="type" 
                                id="type" 
                                required
                                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                            >
                                <option value="about" {{ old('type', $page->type) === 'about' ? 'selected' : '' }}>About Section</option>
                                <option value="info" {{ old('type', $page->type) === 'info' ? 'selected' : '' }}>Travel Info guide</option>
                                <option value="destination" {{ old('type', $page->type) === 'destination' ? 'selected' : '' }}>Himalayan Valley</option>
                                <option value="category" {{ old('type', $page->type) === 'category' ? 'selected' : '' }}>Tour Category</option>
                                <option value="trekking" {{ old('type', $page->type) === 'trekking' ? 'selected' : '' }}>Trekking Details</option>
                                <option value="festival" {{ old('type', $page->type) === 'festival' ? 'selected' : '' }}>Festival Schedules</option>
                                <option value="other" {{ old('type', $page->type) === 'other' ? 'selected' : '' }}>Utility / Other</option>
                            </select>
                        </div>
                    </div>

                    <!-- Meta Description -->
                    <div class="space-y-1.5">
                        <label for="description" class="text-sm font-medium text-foreground">Meta Description (SEO)</label>
                        <textarea 
                            name="description" 
                            id="description" 
                            rows="2" 
                            placeholder="A brief summary of this page for search engines..." 
                            class="flex min-h-[50px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
                        >{{ old('description', $page->description) }}</textarea>
                    </div>

                    <!-- Meta Keywords -->
                    <div class="space-y-1.5">
                        <label for="keywords" class="text-sm font-medium text-foreground">Meta Keywords (SEO)</label>
                        <input 
                            type="text" 
                            name="keywords" 
                            id="keywords" 
                            placeholder="keyword1, keyword2, keyword3"
                            value="{{ old('keywords', $page->keywords) }}"
                            class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                        >
                    </div>

                    <h3 class="text-lg font-bold font-serif border-b pb-3 text-foreground pt-4">Page Content Block</h3>

                    <!-- Content HTML -->
                    <div class="space-y-1.5">
                        <label for="content_html" class="text-sm font-medium text-foreground">Detailed HTML Body Content <span class="text-destructive">*</span></label>
                        <x-admin.rich-editor
                            id="content_html"
                            name="content_html"
                            :value="old('content_html', $page->content_html)"
                            required
                        />
                        <span class="text-xs text-muted-foreground block">Use the toolbar for formatting, or switch to HTML mode for precise source editing.</span>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end gap-4 pt-6 border-t">
                        <a 
                            href="{{ route('admin.pages.index') }}" 
                            class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-semibold border hover:bg-muted h-10 px-4 transition-colors"
                        >
                            Cancel
                        </a>
                        <x-ui.button type="submit" class="shadow-md">
                            Save Page Content
                        </x-ui.button>
                    </div>
                </form>
            </x-ui.card>
        </div>
    </div>
</x-app-layout>
