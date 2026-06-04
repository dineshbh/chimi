<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight font-serif">
                {{ __('Add Gallery Image') }}
            </h2>
            <a 
                href="{{ route('admin.gallery.index') }}" 
                class="text-xs font-semibold text-primary dark:text-accent hover:underline flex items-center gap-1 uppercase tracking-wider"
            >
                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/></svg>
                Back to Gallery
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

            <!-- Main Form Card -->
            <x-ui.card class="p-6 md:p-8 bg-card shadow-sm">
                <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <h3 class="text-lg font-bold font-serif border-b pb-3 text-foreground">Media Metadata</h3>

                    <!-- Title -->
                    <div class="space-y-1.5">
                        <label for="title" class="text-sm font-medium text-foreground">Image Title <span class="text-destructive">*</span></label>
                        <input 
                            type="text" 
                            name="title" 
                            id="title" 
                            required
                            placeholder="e.g. Tiger's Nest Monastery Peak"
                            value="{{ old('title') }}"
                            class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                        >
                    </div>

                    <!-- Description -->
                    <div class="space-y-1.5">
                        <label for="desc" class="text-sm font-medium text-foreground">Short Caption / Description</label>
                        <textarea 
                            name="desc" 
                            id="desc" 
                            rows="3" 
                            placeholder="Describe what is captured in this image..." 
                            class="flex min-h-[60px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
                        >{{ old('desc') }}</textarea>
                    </div>

                    <h3 class="text-lg font-bold font-serif border-b pb-3 text-foreground pt-4">Image Source</h3>
                    <p class="text-xs text-muted-foreground mt-1">Please provide either an external photo URL or choose a local file from your system to upload.</p>

                    <!-- Image URL / Upload grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2">
                        <!-- Image URL -->
                        <div class="space-y-1.5">
                            <label for="url" class="text-sm font-medium text-foreground">External Image URL</label>
                            <input 
                                type="text" 
                                name="url" 
                                id="url" 
                                placeholder="https://images.unsplash.com/photo-..."
                                value="{{ old('url') }}"
                                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                            >
                        </div>

                        <!-- Image File Upload -->
                        <div class="space-y-1.5">
                            <label for="image_file" class="text-sm font-medium text-foreground">Or Upload Image File</label>
                            <input 
                                type="file" 
                                name="image_file" 
                                id="image_file" 
                                accept="image/*"
                                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-1.5 text-sm file:border-0 file:bg-transparent file:text-xs file:font-semibold text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                            >
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end gap-4 pt-6 border-t">
                        <a 
                            href="{{ route('admin.gallery.index') }}" 
                            class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-semibold border hover:bg-muted h-10 px-4 transition-colors"
                        >
                            Cancel
                        </a>
                        <x-ui.button type="submit" class="shadow-md">
                            Add Image to Gallery
                        </x-ui.button>
                    </div>
                </form>
            </x-ui.card>
        </div>
    </div>
</x-app-layout>
