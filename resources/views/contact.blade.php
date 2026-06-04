@extends('layouts.app')

@section('title', 'Contact Us - Access Bhutan Tours & Treks')
@section('meta_description', 'Get in touch with Access Bhutan Tours. Ask about visas, SDF fees, itinerary custom quotes, and flight bookings from our Thimphu office.')
@section('meta_keywords', 'contact Access Bhutan, Bhutan travel planner, Bhutan visa inquiry, travel agency Thimphu')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Header -->
    <div class="text-center md:text-left mb-12 space-y-2">
        <h1 class="text-4xl font-bold font-serif text-foreground">Contact Access Bhutan</h1>
        <p class="text-muted-foreground text-base max-w-xl">
            Have questions about visas, SDF fees, or itineraries? Contact us directly or send an inquiry and our team will get back to you immediately.
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        
        <!-- Left Column: Contact Methods & Badges -->
        <div class="lg:col-span-1 space-y-8">
            <!-- Details Card -->
            <x-ui.card>
                <x-ui.card.header>
                    <x-ui.card.title>Office Contact</x-ui.card.title>
                    <x-ui.card.description>Chimi Dem, Travel Planner</x-ui.card.description>
                </x-ui.card.header>
                <x-ui.card.content class="space-y-4 text-sm text-muted-foreground leading-relaxed">
                    <div>
                        <strong class="text-foreground">Office Address:</strong>
                        <p>Changlam Road, Thimphu, Kingdom of Bhutan</p>
                    </div>
                    <div>
                        <strong class="text-foreground">Mobile & Phone:</strong>
                        <p>+975 17110720 / +975 77176677</p>
                        <p>Tel/Fax: +975 2 339813 / 340820</p>
                    </div>
                    <div>
                        <strong class="text-foreground">Email Address:</strong>
                        <p>accessbhutan@gmail.com</p>
                    </div>
                </x-ui.card.content>
            </x-ui.card>

            <!-- Instant Messaging Shortcuts -->
            <x-ui.card>
                <x-ui.card.header>
                    <x-ui.card.title>Instant Messaging</x-ui.card.title>
                    <x-ui.card.description>Click to connect with us instantly</x-ui.card.description>
                </x-ui.card.header>
                <x-ui.card.content class="flex flex-col gap-3">
                    <!-- WhatsApp Green Button -->
                    <x-ui.button 
                        href="https://wa.me/97517110720?text=Hi,I%20would%20like%20to%20visit%20Bhutan" 
                        target="_blank" 
                        class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold flex items-center justify-center gap-2"
                    >
                        <svg class="h-5 w-5 fill-white" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.455L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.825 1.451 5.436 0 9.86-4.37 9.864-9.799.002-2.63-1.023-5.101-2.885-6.966a9.9 9.9 0 00-6.98-2.879c-5.433 0-9.859 4.37-9.863 9.8-.001 1.802.493 3.557 1.433 5.12l-1.01 3.687 3.791-.983c1.52.88 3.012 1.366 4.625 1.366zm10.742-6.52c-.29-.145-1.716-.848-1.977-.942-.26-.096-.45-.144-.64.145-.19.285-.736.942-.902 1.13-.165.19-.33.213-.62.068-1.282-.64-2.115-1.12-2.954-2.558-.22-.377.22-.35.63-1.164.07-.146.035-.272-.017-.378-.053-.105-.45-1.085-.616-1.485-.162-.39-.33-.336-.45-.342-.116-.006-.25-.006-.385-.006-.135 0-.355.05-.54.26-.185.21-.706.69-.706 1.685t.726 1.956c.074.1.15.2.227.3a19.7 19.7 0 004.148 4.148c.84.6 1.54.89 2.1.99.63.11 1.2.08 1.66.01.5-.08 1.53-.63 1.74-1.23.21-.6.21-1.11.15-1.22-.06-.11-.23-.155-.52-.3z"/></svg>
                        WhatsApp Message
                    </x-ui.button>
                    <div class="grid grid-cols-2 gap-2 text-xs font-semibold">
                        <div class="border rounded bg-muted/30 p-2.5 text-center">
                            <span class="text-muted-foreground block text-[10px] uppercase">WeChat</span>
                            <span class="text-foreground">chimibhutan</span>
                        </div>
                        <div class="border rounded bg-muted/30 p-2.5 text-center">
                            <span class="text-muted-foreground block text-[10px] uppercase">Skype</span>
                            <span class="text-foreground">talktoaccess</span>
                        </div>
                    </div>
                </x-ui.card.content>
            </x-ui.card>
        </div>

        <!-- Right Column: Interactive Form -->
        <div class="lg:col-span-2">
            <x-ui.card class="p-6">
                <!-- Laravel success alert -->
                @if(session('success'))
                    <div class="mb-6 p-4 rounded-lg bg-emerald-500/10 border border-emerald-500/30 text-emerald-600 dark:text-emerald-400 text-sm flex gap-3">
                        <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <form action="{{ route('contact.submit') }}" method="POST" class="space-y-6">
                    @csrf
                    <div style="display: none !important;"><input type="text" name="website_verification_token" id="contact_website_verification_token" autocomplete="off" tabindex="-1"></div>
                    
                    <!-- Name & Email Row -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="name" class="text-sm font-medium text-foreground">Your Name <span class="text-destructive">*</span></label>
                            <input 
                                type="text" 
                                name="name" 
                                id="name" 
                                required
                                value="{{ old('name') }}"
                                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 @error('name') border-destructive @enderror"
                            >
                            @error('name')
                                <p class="text-xs text-destructive">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="email" class="text-sm font-medium text-foreground">Email Address <span class="text-destructive">*</span></label>
                            <input 
                                type="email" 
                                name="email" 
                                id="email" 
                                required
                                value="{{ old('email') }}"
                                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 @error('email') border-destructive @enderror"
                            >
                            @error('email')
                                <p class="text-xs text-destructive">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Phone & Selected Package -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="phone" class="text-sm font-medium text-foreground">Phone Number</label>
                            <input 
                                type="text" 
                                name="phone" 
                                id="phone" 
                                placeholder="+1 123 456 789"
                                value="{{ old('phone') }}"
                                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                            >
                        </div>

                        <div class="space-y-2">
                            <label for="package" class="text-sm font-medium text-foreground">Tour Package Interest</label>
                            <select 
                                name="package" 
                                id="package" 
                                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                            >
                                <option value="">-- Select Package (Optional) --</option>
                                @foreach($tourOptions as $opt)
                                    <option 
                                        value="{{ $opt }}" 
                                        {{ (old('package') === $opt || request()->query('package') === $opt) ? 'selected' : '' }}
                                    >
                                        {{ $opt }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Message text -->
                    <div class="space-y-2">
                        <label for="message" class="text-sm font-medium text-foreground">Travel Inquiry / Message <span class="text-destructive">*</span></label>
                        <textarea 
                            name="message" 
                            id="message" 
                            rows="6"
                            required
                            placeholder="Please tell us about your travel dates, group size, and interests..."
                            class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 @error('message') border-destructive @enderror"
                        >{{ old('message', request()->query('custom_packages') ? "I am interested in compiling a custom itinerary based on the following tour packages: " . request()->query('custom_packages') : '') }}</textarea>
                        @error('message')
                            <p class="text-xs text-destructive">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit -->
                    <x-ui.button type="submit" variant="accent" class="w-full">
                        Submit Travel Inquiry
                    </x-ui.button>
                </form>
            </x-ui.card>
        </div>
        
    </div>
</div>
@endsection
