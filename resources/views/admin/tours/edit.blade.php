<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight font-serif">
                {{ __('Edit Tour Package') }}
            </h2>
            <a 
                href="{{ route('admin.tours.index') }}" 
                class="text-xs font-semibold text-primary dark:text-accent hover:underline flex items-center gap-1 uppercase tracking-wider"
            >
                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/></svg>
                Back to Catalog
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 dark:bg-slate-900 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- validation error alerts -->
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
                <form action="{{ route('admin.tours.update', ['id' => $tour->id]) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Wizard Progress Header -->
                    <div class="mb-8 border-b pb-6">
                        <div class="flex items-center justify-between max-w-2xl mx-auto">
                            <!-- Step 1 -->
                            <div class="flex flex-col items-center gap-1.5 flex-1 relative step-indicator" data-step="1">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition-all duration-200 border-2 border-primary bg-primary text-white shadow-sm ring-4 ring-primary/10">1</div>
                                <span class="text-[10px] font-bold uppercase tracking-wider text-primary">Metadata</span>
                            </div>
                            <div class="w-full h-0.5 bg-slate-200 dark:bg-slate-700 flex-1 -mt-5 line-indicator" data-line="1"></div>
                            
                            <!-- Step 2 -->
                            <div class="flex flex-col items-center gap-1.5 flex-1 relative step-indicator" data-step="2">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition-all duration-200 border-2 border-slate-300 dark:border-slate-700 bg-card text-slate-400">2</div>
                                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Itinerary</span>
                            </div>
                            <div class="w-full h-0.5 bg-slate-200 dark:bg-slate-700 flex-1 -mt-5 line-indicator" data-line="2"></div>

                            <!-- Step 3 -->
                            <div class="flex flex-col items-center gap-1.5 flex-1 relative step-indicator" data-step="3">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition-all duration-200 border-2 border-slate-300 dark:border-slate-700 bg-card text-slate-400">3</div>
                                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Departures</span>
                            </div>
                            <div class="w-full h-0.5 bg-slate-200 dark:bg-slate-700 flex-1 -mt-5 line-indicator" data-line="3"></div>

                            <!-- Step 4 -->
                            <div class="flex flex-col items-center gap-1.5 flex-1 relative step-indicator" data-step="4">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition-all duration-200 border-2 border-slate-300 dark:border-slate-700 bg-card text-slate-400">4</div>
                                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">FAQs & Reviews</span>
                            </div>
                        </div>
                    </div>

                    <!-- STEP 1: METADATA -->
                    <div class="wizard-step-content space-y-6" data-step-content="1">
                        <h3 class="text-lg font-bold font-serif border-b pb-3 text-foreground">Itinerary Metadata</h3>

                        <!-- Title -->
                        <div class="space-y-1.5">
                            <label for="title" class="text-sm font-medium text-foreground">Package Title <span class="text-destructive">*</span></label>
                            <input 
                                type="text" 
                                name="title" 
                                id="title" 
                                required
                                value="{{ old('title', $tour->title) }}"
                                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                            >
                        </div>

                        <!-- Category, Duration & Price Row -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Category -->
                            <div class="space-y-1.5">
                                <label for="category" class="text-sm font-medium text-foreground">Category <span class="text-destructive">*</span></label>
                                <select 
                                    name="category" 
                                    id="category" 
                                    required
                                    class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                                >
                                    <option value="cultural" {{ old('category', $tour->category) === 'cultural' ? 'selected' : '' }}>Cultural</option>
                                    <option value="luxury" {{ old('category', $tour->category) === 'luxury' ? 'selected' : '' }}>Luxury</option>
                                    <option value="trekking" {{ old('category', $tour->category) === 'trekking' ? 'selected' : '' }}>Trekking</option>
                                    <option value="festival" {{ old('category', $tour->category) === 'festival' ? 'selected' : '' }}>Festival</option>
                                    <option value="hiking" {{ old('category', $tour->category) === 'hiking' ? 'selected' : '' }}>Hiking</option>
                                    <option value="homestay" {{ old('category', $tour->category) === 'homestay' ? 'selected' : '' }}>Homestay</option>
                                    <option value="special" {{ old('category', $tour->category) === 'special' ? 'selected' : '' }}>Special</option>
                                </select>
                            </div>

                            <!-- Duration -->
                            <div class="space-y-1.5">
                                <label for="duration" class="text-sm font-medium text-foreground">Duration <span class="text-destructive">*</span></label>
                                <input 
                                    type="text" 
                                    name="duration" 
                                    id="duration" 
                                    required
                                    placeholder="10 Days / 9 Nights"
                                    value="{{ old('duration', $tour->duration) }}"
                                    class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                                >
                            </div>

                            <!-- Price -->
                            <div class="space-y-1.5">
                                <label for="price" class="text-sm font-medium text-foreground">Starting Price</label>
                                <input 
                                    type="text" 
                                    name="price" 
                                    id="price" 
                                    placeholder="USD $1,890 / person"
                                    value="{{ old('price', $tour->price) }}"
                                    class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                                >
                            </div>
                        </div>

                        <!-- Cover Photo Image -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-1.5">
                                <label for="hero_image" class="text-sm font-medium text-foreground">Cover Image URL</label>
                                <input 
                                    type="text" 
                                    name="hero_image" 
                                    id="hero_image" 
                                    placeholder="https://images.unsplash.com/photo-..."
                                    value="{{ old('hero_image', $tour->hero_image) }}"
                                    class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                                >
                            </div>
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

                        <!-- Snippet -->
                        <div class="space-y-1.5">
                            <label for="snippet" class="text-sm font-medium text-foreground">Short Snippet <span class="text-destructive">*</span></label>
                            <textarea 
                                name="snippet" 
                                id="snippet" 
                                rows="3" 
                                required 
                                placeholder="A concise, high-impact overview of this trip package..." 
                                class="flex min-h-[60px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
                            >{{ old('snippet', $tour->snippet) }}</textarea>
                        </div>
                    </div>

                    <!-- STEP 2: ITINERARY -->
                    <div class="wizard-step-content space-y-6 hidden" data-step-content="2">
                        <h3 class="text-lg font-bold font-serif border-b pb-3 text-foreground">Itinerary & Content Details</h3>

                        <!-- Hidden Compiled Inputs -->
                        <input type="hidden" name="content_html" id="content_html" value="{{ old('content_html', $tour->content_html) }}">

                        <!-- Visual Itinerary Days Manager -->
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <label class="text-sm font-semibold text-foreground uppercase tracking-wider">Day-by-Day Itinerary</label>
                                    <p class="text-xs text-muted-foreground mt-0.5">Manage itinerary items day-by-day. Description lines will be converted to paragraphs automatically.</p>
                                </div>
                                <button type="button" id="add-day-btn" class="inline-flex items-center gap-1 text-xs font-bold text-primary dark:text-accent hover:underline">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                                    Add Itinerary Day
                                </button>
                            </div>
                            <div id="itinerary-days-container" class="space-y-4">
                                <!-- Dynamic Day Elements -->
                            </div>
                        </div>
                    </div>

                    <!-- STEP 3: DEPARTURES -->
                    <div class="wizard-step-content space-y-6 hidden" data-step-content="3">
                        <h3 class="text-lg font-bold font-serif border-b pb-3 text-foreground">Pricing & Departures</h3>

                        <!-- Departure Dates -->
                        <div class="space-y-1.5">
                            <label for="departure_dates" class="text-sm font-medium text-foreground">Upcoming Departure Dates (One per line)</label>
                            <textarea 
                                name="departure_dates" 
                                id="departure_dates" 
                                rows="5" 
                                placeholder="Sept 12, 2026&#10;Oct 05, 2026&#10;Oct 22, 2026" 
                                class="flex min-h-[100px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
                            >{{ old('departure_dates', $datesText) }}</textarea>
                            <span class="text-xs text-muted-foreground block">Enter list items separated by newlines.</span>
                        </div>
                    </div>

                    <!-- STEP 4: FAQS & REVIEWS -->
                    <div class="wizard-step-content space-y-6 hidden" data-step-content="4">
                        <h3 class="text-lg font-bold font-serif border-b pb-3 text-foreground">Reviews & FAQs</h3>

                        <input type="hidden" name="faqs" id="faqs" value="{{ old('faqs', $faqsJson) }}">
                        <input type="hidden" name="reviews" id="reviews" value="{{ old('reviews', $reviewsJson) }}">

                        <!-- Visual FAQs Manager -->
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <label class="text-sm font-semibold text-foreground uppercase tracking-wider">Frequently Asked Questions (FAQs)</label>
                                    <p class="text-xs text-muted-foreground mt-0.5">Add Q&A pairs for this trip package. They display inside collapsible accordions.</p>
                                </div>
                                <button type="button" id="add-faq-btn" class="inline-flex items-center gap-1 text-xs font-bold text-primary dark:text-accent hover:underline">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                                    Add FAQ Item
                                </button>
                            </div>
                            <div id="faqs-container" class="space-y-4">
                                <!-- Dynamic FAQ Elements -->
                            </div>
                        </div>

                        <!-- Visual Reviews Manager -->
                        <div class="space-y-4 pt-2">
                            <div class="flex items-center justify-between">
                                <div>
                                    <label class="text-sm font-semibold text-foreground uppercase tracking-wider">Traveler Reviews</label>
                                    <p class="text-xs text-muted-foreground mt-0.5">Manage customer testimonials, travel periods, and star ratings.</p>
                                </div>
                                <button type="button" id="add-review-btn" class="inline-flex items-center gap-1 text-xs font-bold text-primary dark:text-accent hover:underline">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                                    Add Review Item
                                </button>
                            </div>
                            <div id="reviews-container" class="space-y-4">
                                <!-- Dynamic Review Elements -->
                            </div>
                        </div>
                    </div>

                    <!-- Actions Footer -->
                    <div class="flex items-center justify-between pt-6 border-t mt-8">
                        <div>
                            <button type="button" id="prev-step-btn" class="hidden inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-semibold border hover:bg-muted h-10 px-4 transition-colors">
                                Back
                            </button>
                        </div>
                        <div class="flex items-center gap-3">
                            <a href="{{ route('admin.tours.index') }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-semibold border hover:bg-muted h-10 px-4 transition-colors">
                                Cancel
                            </a>
                            <button type="button" id="next-step-btn" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-bold bg-primary text-white hover:bg-primary/90 h-10 px-4 shadow-sm transition-colors">
                                Next Step
                            </button>
                            <x-ui.button type="submit" id="submit-form-btn" class="hidden shadow-md">
                                Save Tour Settings
                            </x-ui.button>
                        </div>
                    </div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Hidden inputs
    const contentHtmlInput = document.getElementById('content_html');
    const faqsInput = document.getElementById('faqs');
    const reviewsInput = document.getElementById('reviews');

    // Containers
    const daysContainer = document.getElementById('itinerary-days-container');
    const faqsContainer = document.getElementById('faqs-container');
    const reviewsContainer = document.getElementById('reviews-container');

    // Buttons
    const addDayBtn = document.getElementById('add-day-btn');
    const addFaqBtn = document.getElementById('add-faq-btn');
    const addReviewBtn = document.getElementById('add-review-btn');

    // ----------------------------------------------------
    // ITINERARY DYNAMIC MANAGER
    // ----------------------------------------------------
    function createDayElement(title = '', desc = '') {
        const div = document.createElement('div');
        div.className = 'day-item border border-border rounded-xl p-4 bg-muted/10 relative space-y-3';
        div.innerHTML = `
            <button type="button" class="remove-day-btn absolute top-3 right-3 text-xs font-bold text-destructive hover:underline">Remove</button>
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-foreground uppercase">Day Title</label>
                <input type="text" value="${title}" placeholder="e.g. Day 1: Arrive Paro & Explore" class="day-title flex h-9 w-full rounded-md border border-input bg-background px-3 py-1 text-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring">
            </div>
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-foreground uppercase">Description & Activities</label>
                <textarea rows="3" placeholder="Describe the activities for this day..." class="day-desc flex min-h-[60px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring">${desc}</textarea>
            </div>
        `;
        div.querySelector('.remove-day-btn').addEventListener('click', () => {
            div.remove();
            syncItinerary();
        });
        div.querySelectorAll('input, textarea').forEach(el => {
            el.addEventListener('input', syncItinerary);
        });
        return div;
    }

    function syncItinerary() {
        const days = [];
        daysContainer.querySelectorAll('.day-item').forEach(item => {
            const title = item.querySelector('.day-title').value.trim();
            const desc = item.querySelector('.day-desc').value.trim();
            if (title || desc) {
                days.push({ title, desc });
            }
        });

        const html = days.map(d => {
            const paragraphs = d.desc.split('\n\n')
                .map(p => p.trim())
                .filter(p => p)
                .map(p => `<p>${p.replace(/\n/g, '<br>')}</p>`)
                .join('\n');
            return `<h3>${d.title}</h3>\n${paragraphs}`;
        }).join('\n\n');

        contentHtmlInput.value = html;
    }

    function initItinerary() {
        const rawHTML = contentHtmlInput.value;
        const temp = document.createElement('div');
        temp.innerHTML = rawHTML;
        const children = Array.from(temp.children);
        
        const parsedDays = [];
        let currentDay = null;

        children.forEach(child => {
            const text = child.textContent.trim();
            const isHeader = child.tagName === 'H3' || child.tagName === 'H4' || 
                             /^(Day\s*\d+|D\s*a\s*y\s*\d+)/i.test(text);

            if (isHeader) {
                if (currentDay) parsedDays.push(currentDay);
                currentDay = { title: text, paragraphs: [] };
            } else {
                if (!currentDay) {
                    currentDay = { title: 'Overview', paragraphs: [] };
                }
                currentDay.paragraphs.push(child.innerHTML.replace(/<br\s*\/?>/gi, '\n').replace(/<\/?[^>]+(>|$)/g, ""));
            }
        });
        if (currentDay) parsedDays.push(currentDay);

        if (parsedDays.length > 0) {
            parsedDays.forEach(d => {
                const descText = d.paragraphs.join('\n\n');
                daysContainer.appendChild(createDayElement(d.title, descText));
            });
        } else {
            daysContainer.appendChild(createDayElement('Day 1: Arrive Paro', 'Transfer to Thimphu...'));
        }
    }

    addDayBtn.addEventListener('click', () => {
        const nextDayNum = daysContainer.querySelectorAll('.day-item').length + 1;
        daysContainer.appendChild(createDayElement(`Day ${nextDayNum}: `, ''));
        syncItinerary();
    });

    // ----------------------------------------------------
    // FAQS DYNAMIC MANAGER
    // ----------------------------------------------------
    function createFaqElement(q = '', a = '') {
        const div = document.createElement('div');
        div.className = 'faq-item border border-border rounded-xl p-4 bg-muted/10 relative space-y-3';
        div.innerHTML = `
            <button type="button" class="remove-faq-btn absolute top-3 right-3 text-xs font-bold text-destructive hover:underline">Remove</button>
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-foreground uppercase">Question</label>
                <input type="text" value="${q}" placeholder="e.g. Is wifi available?" class="faq-q flex h-9 w-full rounded-md border border-input bg-background px-3 py-1 text-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring">
            </div>
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-foreground uppercase">Answer</label>
                <textarea rows="2" placeholder="FAQ Answer..." class="faq-a flex min-h-[50px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring">${a}</textarea>
            </div>
        `;
        div.querySelector('.remove-faq-btn').addEventListener('click', () => {
            div.remove();
            syncFaqs();
        });
        div.querySelectorAll('input, textarea').forEach(el => {
            el.addEventListener('input', syncFaqs);
        });
        return div;
    }

    function syncFaqs() {
        const items = [];
        faqsContainer.querySelectorAll('.faq-item').forEach(item => {
            const q = item.querySelector('.faq-q').value.trim();
            const a = item.querySelector('.faq-a').value.trim();
            if (q || a) {
                items.push({ q, a });
            }
        });
        faqsInput.value = JSON.stringify(items);
    }

    function initFaqs() {
        let faqsArr = [];
        try {
            faqsArr = JSON.parse(faqsInput.value || '[]');
        } catch(e) {
            faqsArr = [];
        }
        if (faqsArr.length > 0) {
            faqsArr.forEach(item => {
                faqsContainer.appendChild(createFaqElement(item.q, item.a));
            });
        } else {
            faqsContainer.appendChild(createFaqElement('', ''));
        }
    }

    addFaqBtn.addEventListener('click', () => {
        faqsContainer.appendChild(createFaqElement('', ''));
        syncFaqs();
    });

    // ----------------------------------------------------
    // REVIEWS DYNAMIC MANAGER
    // ----------------------------------------------------
    function createReviewElement(name = '', rating = 5, date = '', text = '') {
        const div = document.createElement('div');
        div.className = 'review-item border border-border rounded-xl p-4 bg-muted/10 relative space-y-3';
        div.innerHTML = `
            <button type="button" class="remove-review-btn absolute top-3 right-3 text-xs font-bold text-destructive hover:underline">Remove</button>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-foreground uppercase">Reviewer Name</label>
                    <input type="text" value="${name}" placeholder="e.g. John Doe" class="review-name flex h-9 w-full rounded-md border border-input bg-background px-3 py-1 text-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring">
                </div>
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-foreground uppercase">Date / Season</label>
                    <input type="text" value="${date}" placeholder="e.g. Oct 2026" class="review-date flex h-9 w-full rounded-md border border-input bg-background px-3 py-1 text-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring">
                </div>
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-foreground uppercase">Rating (1-5 Stars)</label>
                    <input type="number" min="1" max="5" step="0.5" value="${rating}" class="review-rating flex h-9 w-full rounded-md border border-input bg-background px-3 py-1 text-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring">
                </div>
            </div>
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-foreground uppercase">Review Text</label>
                <textarea rows="2" placeholder="Their review comment..." class="review-text flex min-h-[50px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring">${text}</textarea>
            </div>
        `;
        div.querySelector('.remove-review-btn').addEventListener('click', () => {
            div.remove();
            syncReviews();
        });
        div.querySelectorAll('input, textarea').forEach(el => {
            el.addEventListener('input', syncReviews);
        });
        return div;
    }

    function syncReviews() {
        const items = [];
        reviewsContainer.querySelectorAll('.review-item').forEach(item => {
            const name = item.querySelector('.review-name').value.trim();
            const date = item.querySelector('.review-date').value.trim();
            const rating = parseFloat(item.querySelector('.review-rating').value) || 5;
            const text = item.querySelector('.review-text').value.trim();
            if (name || text) {
                items.push({ name, rating, date, text });
            }
        });
        reviewsInput.value = JSON.stringify(items);
    }

    function initReviews() {
        let reviewsArr = [];
        try {
            reviewsArr = JSON.parse(reviewsInput.value || '[]');
        } catch(e) {
            reviewsArr = [];
        }
        if (reviewsArr.length > 0) {
            reviewsArr.forEach(item => {
                reviewsContainer.appendChild(createReviewElement(item.name, item.rating, item.date, item.text));
            });
        } else {
            reviewsContainer.appendChild(createReviewElement('', 5, '', ''));
        }
    }

    addReviewBtn.addEventListener('click', () => {
        reviewsContainer.appendChild(createReviewElement('', 5, '', ''));
        syncReviews();
    });

    // ----------------------------------------------------
    // WIZARD MULTI-STEP LOGIC
    // ----------------------------------------------------
    let currentStep = 1;
    const totalSteps = 4;

    const prevBtn = document.getElementById('prev-step-btn');
    const nextBtn = document.getElementById('next-step-btn');
    const submitBtn = document.getElementById('submit-form-btn');

    function updateWizardUI() {
        // Toggle step contents
        document.querySelectorAll('[data-step-content]').forEach(el => {
            const stepNum = parseInt(el.getAttribute('data-step-content'));
            if (stepNum === currentStep) {
                el.classList.remove('hidden');
            } else {
                el.classList.add('hidden');
            }
        });

        // Toggle button visibility
        if (currentStep === 1) {
            prevBtn.classList.add('hidden');
        } else {
            prevBtn.classList.remove('hidden');
        }

        if (currentStep === totalSteps) {
            nextBtn.classList.add('hidden');
            submitBtn.classList.remove('hidden');
        } else {
            nextBtn.classList.remove('hidden');
            submitBtn.classList.add('hidden');
        }

        // Update step indicators
        document.querySelectorAll('.step-indicator').forEach(el => {
            const stepNum = parseInt(el.getAttribute('data-step'));
            const circle = el.querySelector('div');
            const label = el.querySelector('span');

            if (stepNum === currentStep) {
                circle.className = 'w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition-all duration-200 border-2 border-primary bg-primary text-white shadow-sm ring-4 ring-primary/10';
                label.className = 'text-[10px] font-bold uppercase tracking-wider text-primary';
            } else if (stepNum < currentStep) {
                circle.className = 'w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition-all duration-200 border-2 border-emerald-500 bg-emerald-500 text-white shadow-sm';
                label.className = 'text-[10px] font-bold uppercase tracking-wider text-emerald-500';
            } else {
                circle.className = 'w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition-all duration-200 border-2 border-slate-300 dark:border-slate-700 bg-card text-slate-400';
                label.className = 'text-[10px] font-bold uppercase tracking-wider text-slate-400';
            }
        });

        // Update progress line indicators
        document.querySelectorAll('.line-indicator').forEach(el => {
            const lineNum = parseInt(el.getAttribute('data-line'));
            if (lineNum < currentStep) {
                el.className = 'w-full h-0.5 bg-emerald-500 flex-1 -mt-5 line-indicator';
            } else {
                el.className = 'w-full h-0.5 bg-slate-200 dark:bg-slate-700 flex-1 -mt-5 line-indicator';
            }
        });
    }

    function isStepValid(step) {
        const stepEl = document.querySelector(`[data-step-content="${step}"]`);
        if (!stepEl) return true;
        const inputs = stepEl.querySelectorAll('input[required], select[required], textarea[required]');
        let isValid = true;
        const isVisible = !stepEl.classList.contains('hidden');
        
        for (let input of inputs) {
            if (isVisible) {
                if (!input.reportValidity()) {
                    isValid = false;
                    break;
                }
            } else {
                if (!input.checkValidity()) {
                    isValid = false;
                    break;
                }
            }
        }
        return isValid;
    }

    nextBtn.addEventListener('click', () => {
        if (isStepValid(currentStep)) {
            if (currentStep < totalSteps) {
                currentStep++;
                updateWizardUI();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        }
    });

    prevBtn.addEventListener('click', () => {
        if (currentStep > 1) {
            currentStep--;
            updateWizardUI();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    });

    // ----------------------------------------------------
    // INITIALIZATION & SUBMIT SYNC
    // ----------------------------------------------------
    initItinerary();
    initFaqs();
    initReviews();
    updateWizardUI();

    const form = daysContainer.closest('form');
    if (form) {
        form.addEventListener('submit', (e) => {
            // Validate all steps programmatically
            let firstInvalidStep = -1;
            for (let s = 1; s <= totalSteps; s++) {
                if (!isStepValid(s)) {
                    firstInvalidStep = s;
                    break;
                }
            }

            if (firstInvalidStep !== -1) {
                e.preventDefault();
                currentStep = firstInvalidStep;
                updateWizardUI();
                // Trigger reportValidity on the now visible step
                setTimeout(() => {
                    isStepValid(currentStep);
                }, 50);
                window.scrollTo({ top: 0, behavior: 'smooth' });
                return;
            }

            syncItinerary();
            syncFaqs();
            syncReviews();
        });
    }
});
</script>
                </form>
            </x-ui.card>
        </div>
    </div>
</x-app-layout>
