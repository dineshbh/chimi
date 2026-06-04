<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tour;
use App\Models\Page;
use App\Models\ContactInquiry;
use App\Models\Gallery;
use App\Models\VisitorLog;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard()
    {
        $toursCount = Tour::count();
        $pagesCount = Page::count();
        $inquiriesCount = ContactInquiry::count();
        $galleryCount = Gallery::count();

        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();
        $lastMonthStart = Carbon::now()->subMonthNoOverflow()->startOfMonth();
        $lastMonthEnd = Carbon::now()->subMonthNoOverflow()->endOfMonth();

        $inquiriesThisMonth = ContactInquiry::where('created_at', '>=', $startOfMonth)->count();
        $inquiriesLastMonth = ContactInquiry::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->count();
        $leadGrowth = $inquiriesLastMonth > 0
            ? round((($inquiriesThisMonth - $inquiriesLastMonth) / $inquiriesLastMonth) * 100)
            : ($inquiriesThisMonth > 0 ? 100 : 0);

        $newInquiriesToday = ContactInquiry::whereDate('created_at', $today)->count();
        $recentInquiries = ContactInquiry::latest()->take(6)->get();
        $recentTours = Tour::latest()->take(5)->get();
        $recentPages = Page::latest()->take(5)->get();

        $tourCategories = Tour::selectRaw('category, COUNT(*) as total')
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();

        $pageSections = Page::selectRaw('type, COUNT(*) as total')
            ->groupBy('type')
            ->orderByDesc('total')
            ->get();

        $missingTourImages = Tour::whereNull('hero_image')
            ->orWhere('hero_image', '')
            ->count();

        $missingSeoPages = Page::where(function ($query) {
                $query->whereNull('description')
                    ->orWhere('description', '')
                    ->orWhereNull('keywords')
                    ->orWhere('keywords', '');
            })
            ->count();

        $contentHealthChecks = collect([
            [
                'label' => 'Tour hero images',
                'complete' => max($toursCount - $missingTourImages, 0),
                'total' => $toursCount,
            ],
            [
                'label' => 'SEO-ready pages',
                'complete' => max($pagesCount - $missingSeoPages, 0),
                'total' => $pagesCount,
            ],
            [
                'label' => 'Cataloged media assets',
                'complete' => $galleryCount,
                'total' => $galleryCount,
            ],
        ])->map(function ($item) {
            $item['percent'] = $item['total'] > 0 ? round(($item['complete'] / $item['total']) * 100) : 0;
            return $item;
        });

        $priorityActions = collect([
            [
                'title' => 'Review new travel inquiries',
                'count' => $newInquiriesToday,
                'label' => $newInquiriesToday === 1 ? 'lead today' : 'leads today',
                'url' => route('admin.inquiries.index'),
                'level' => $newInquiriesToday > 0 ? 'high' : 'normal',
            ],
            [
                'title' => 'Complete missing tour images',
                'count' => $missingTourImages,
                'label' => $missingTourImages === 1 ? 'tour missing image' : 'tours missing images',
                'url' => route('admin.tours.index'),
                'level' => $missingTourImages > 0 ? 'medium' : 'normal',
            ],
            [
                'title' => 'Improve page SEO metadata',
                'count' => $missingSeoPages,
                'label' => $missingSeoPages === 1 ? 'page needs metadata' : 'pages need metadata',
                'url' => route('admin.pages.index'),
                'level' => $missingSeoPages > 0 ? 'medium' : 'normal',
            ],
        ]);

        $quickActions = [
            ['label' => 'Create tour', 'url' => route('admin.tours.create')],
            ['label' => 'Create page', 'url' => route('admin.pages.create')],
            ['label' => 'Upload media', 'url' => route('admin.gallery.create')],
            ['label' => 'View leads', 'url' => route('admin.inquiries.index')],
            ['label' => 'Preview site', 'url' => route('home')],
        ];

        // Visitor Analytics Statistics
        $analytics = [
            'total_views' => VisitorLog::count(),
            'unique_visitors' => VisitorLog::distinct('ip_address')->count('ip_address'),
            'proxy_views' => VisitorLog::where('is_proxy', true)->count(),
            'views_today' => VisitorLog::whereDate('created_at', Carbon::today())->count(),
            'unique_today' => VisitorLog::whereDate('created_at', Carbon::today())->distinct('ip_address')->count('ip_address'),
            
            // Devices split
            'devices' => VisitorLog::selectRaw('device_type, count(*) as total')
                ->groupBy('device_type')
                ->orderByDesc('total')
                ->get(),
                
            // Browsers split (top 5)
            'browsers' => VisitorLog::selectRaw('browser, count(*) as total')
                ->groupBy('browser')
                ->orderByDesc('total')
                ->take(5)
                ->get(),

            // Platforms split (top 5)
            'platforms' => VisitorLog::selectRaw('platform, count(*) as total')
                ->groupBy('platform')
                ->orderByDesc('total')
                ->take(5)
                ->get(),
                
            // Countries split (top 5)
            'countries' => VisitorLog::selectRaw('country, count(*) as total')
                ->groupBy('country')
                ->orderByDesc('total')
                ->take(5)
                ->get(),

            // Top pages (top 5)
            'pages' => VisitorLog::selectRaw('url_path, count(*) as total')
                ->groupBy('url_path')
                ->orderByDesc('total')
                ->take(5)
                ->get(),

            // Live stream (latest 15 logs)
            'live_stream' => VisitorLog::latest()->take(15)->get(),
        ];

        return view('dashboard', compact(
            'toursCount',
            'pagesCount',
            'inquiriesCount',
            'galleryCount',
            'inquiriesThisMonth',
            'leadGrowth',
            'newInquiriesToday',
            'recentInquiries',
            'recentTours',
            'recentPages',
            'tourCategories',
            'pageSections',
            'contentHealthChecks',
            'priorityActions',
            'quickActions',
            'analytics'
        ));
    }

    // ==========================================
    // TOURS CRUD
    // ==========================================

    public function toursIndex(Request $request)
    {
        $search = $request->input('search');
        
        $tours = Tour::query()
            ->when($search, function($query, $search) {
                $query->where('title', 'like', "%{$search}%")
                      ->orWhere('category', 'like', "%{$search}%");
            })
            ->orderBy('title')
            ->get();

        return view('admin.tours.index', compact('tours', 'search'));
    }

    public function toursCreate()
    {
        // Provide standard templates for departures, FAQs, and reviews
        $datesText = "Sept 12, 2026\nOct 05, 2026\nOct 22, 2026";
        $faqsJson = json_encode([
            ['q' => 'Is the Sustainable Development Fee (SDF) included?', 'a' => 'No, the SDF of USD $100 per night is paid separately, but we will process this for you.'],
            ['q' => 'What is the level of physical fitness required?', 'a' => 'This tour is categorized as moderate. While it includes daily walks, no technical skills are required.']
        ], JSON_PRETTY_PRINT);

        $reviewsJson = json_encode([
            ['name' => 'Sarah Mitchell', 'rating' => 5, 'date' => 'May 2026', 'text' => 'An absolute dream journey! Outstanding local transport and guide services.']
        ], JSON_PRETTY_PRINT);

        return view('admin.tours.create', compact('datesText', 'faqsJson', 'reviewsJson'));
    }

    public function toursStore(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'duration' => 'required|string|max:100',
            'price' => 'nullable|string|max:100',
            'hero_image' => 'nullable|string|max:500',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'snippet' => 'required|string',
            'content_html' => 'required|string',
            'content_text' => 'nullable|string',
        ]);

        $tour = new Tour();

        // Handle Image Upload or URL
        $imageUrl = $validated['hero_image'] ?? 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?q=80&w=800';
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('tours', 'public');
            $imageUrl = asset('storage/' . $path);
        }

        // Process Departure Dates
        $rawDates = $request->input('departure_dates', '');
        $datesArray = array_filter(array_map('trim', explode("\n", $rawDates)));
        $tour->departure_dates = json_encode(array_values($datesArray));

        // Process FAQs
        $rawFaqs = $request->input('faqs', '[]');
        $faqsDecoded = json_decode($rawFaqs, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return back()->withErrors(['faqs' => 'Invalid FAQs JSON formatting.'])->withInput();
        }
        $tour->faqs = json_encode($faqsDecoded);

        // Process Reviews
        $rawReviews = $request->input('reviews', '[]');
        $reviewsDecoded = json_decode($rawReviews, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return back()->withErrors(['reviews' => 'Invalid Reviews JSON formatting.'])->withInput();
        }
        $tour->reviews = json_encode($reviewsDecoded);

        // Save Tour
        $tour->slug = $this->uniqueSlug(Tour::class, $validated['title']);
        $tour->title = $validated['title'];
        $tour->category = $validated['category'];
        $tour->duration = $validated['duration'];
        $tour->price = $validated['price'] ?: 'USD $1,490 / person';
        $tour->hero_image = $imageUrl;
        $tour->snippet = $validated['snippet'];
        $tour->content_html = $validated['content_html'];
        $tour->content_text = $validated['content_text'] ?? strip_tags($validated['content_html']);
        $tour->save();

        return redirect()->route('admin.tours.index')->with('success', "New tour package '{$tour->title}' created successfully!");
    }

    public function toursEdit($id)
    {
        $tour = Tour::findOrFail($id);
        
        $datesArray = json_decode($tour->departure_dates, true) ?: [];
        $datesText = implode("\n", $datesArray);

        $faqsJson = json_encode(json_decode($tour->faqs, true) ?: [], JSON_PRETTY_PRINT);
        $reviewsJson = json_encode(json_decode($tour->reviews, true) ?: [], JSON_PRETTY_PRINT);

        return view('admin.tours.edit', compact('tour', 'datesText', 'faqsJson', 'reviewsJson'));
    }

    public function toursUpdate(Request $request, $id)
    {
        $tour = Tour::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'duration' => 'required|string|max:100',
            'price' => 'nullable|string|max:100',
            'hero_image' => 'nullable|string|max:500',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'snippet' => 'required|string',
            'content_html' => 'required|string',
            'content_text' => 'nullable|string',
        ]);

        // Process Image Update
        $imageUrl = $validated['hero_image'] ?: $tour->hero_image;
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('tours', 'public');
            $imageUrl = asset('storage/' . $path);
        }

        // Process Departure Dates
        $rawDates = $request->input('departure_dates', '');
        $datesArray = array_filter(array_map('trim', explode("\n", $rawDates)));
        $tour->departure_dates = json_encode(array_values($datesArray));

        // Process FAQs
        $rawFaqs = $request->input('faqs', '[]');
        $faqsDecoded = json_decode($rawFaqs, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return back()->withErrors(['faqs' => 'Invalid FAQs JSON formatting.'])->withInput();
        }
        $tour->faqs = json_encode($faqsDecoded);

        // Process Reviews
        $rawReviews = $request->input('reviews', '[]');
        $reviewsDecoded = json_decode($rawReviews, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return back()->withErrors(['reviews' => 'Invalid Reviews JSON formatting.'])->withInput();
        }
        $tour->reviews = json_encode($reviewsDecoded);

        // Update fields
        if ($tour->title !== $validated['title']) {
            $tour->slug = $this->uniqueSlug(Tour::class, $validated['title'], $tour->id);
        }
        $tour->title = $validated['title'];
        $tour->category = $validated['category'];
        $tour->duration = $validated['duration'];
        $tour->price = $validated['price'];
        $tour->hero_image = $imageUrl;
        $tour->snippet = $validated['snippet'];
        $tour->content_html = $validated['content_html'];
        $tour->content_text = $validated['content_text'] ?? strip_tags($validated['content_html']);
        $tour->save();

        return redirect()->route('admin.tours.index')->with('success', "Tour package '{$tour->title}' updated successfully!");
    }

    public function toursDestroy($id)
    {
        $tour = Tour::findOrFail($id);
        $title = $tour->title;
        $tour->delete();

        return redirect()->route('admin.tours.index')->with('success', "Tour package '{$title}' deleted successfully!");
    }

    // ==========================================
    // PAGES CRUD
    // ==========================================

    public function pagesIndex(Request $request)
    {
        $type = $request->input('type');
        
        $pages = Page::query()
            ->when($type, function($query, $type) {
                $query->where('type', $type);
            })
            ->orderBy('type')
            ->orderBy('title')
            ->get();

        return view('admin.pages.index', compact('pages', 'type'));
    }

    public function pagesCreate()
    {
        return view('admin.pages.create');
    }

    public function pagesStore(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|max:50',
            'description' => 'nullable|string|max:500',
            'keywords' => 'nullable|string|max:500',
            'content_html' => 'required|string',
            'content_text' => 'nullable|string',
        ]);

        $page = new Page();
        $page->title = $validated['title'];
        $page->type = $validated['type'];
        $page->slug = $this->uniqueSlug(Page::class, $validated['title']);
        $page->description = $validated['description'];
        $page->keywords = $validated['keywords'];
        $page->content_html = $validated['content_html'];
        $page->content_text = $validated['content_text'] ?? strip_tags($validated['content_html']);
        $page->save();

        return redirect()->route('admin.pages.index')->with('success', "New content page '{$page->title}' created successfully!");
    }

    public function pagesEdit($id)
    {
        $page = Page::findOrFail($id);
        return view('admin.pages.edit', compact('page'));
    }

    public function pagesUpdate(Request $request, $id)
    {
        $page = Page::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|max:50',
            'description' => 'nullable|string|max:500',
            'keywords' => 'nullable|string|max:500',
            'content_html' => 'required|string',
            'content_text' => 'nullable|string',
        ]);

        if ($page->title !== $validated['title']) {
            $page->slug = $this->uniqueSlug(Page::class, $validated['title'], $page->id);
        }
        $page->title = $validated['title'];
        $page->type = $validated['type'];
        $page->description = $validated['description'];
        $page->keywords = $validated['keywords'];
        $page->content_html = $validated['content_html'];
        $page->content_text = $validated['content_text'] ?? strip_tags($validated['content_html']);
        $page->save();

        return redirect()->route('admin.pages.index')->with('success', "Content page '{$page->title}' updated successfully!");
    }

    public function pagesDestroy($id)
    {
        $page = Page::findOrFail($id);
        $title = $page->title;
        $page->delete();

        return redirect()->route('admin.pages.index')->with('success', "Content page '{$title}' deleted successfully!");
    }

    // ==========================================
    // GALLERY CRUD
    // ==========================================

    public function galleryIndex(Request $request)
    {
        $search = $request->input('search');

        $images = Gallery::query()
            ->when($search, function($query, $search) {
                $query->where('title', 'like', "%{$search}%")
                      ->orWhere('desc', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.gallery.index', compact('images', 'search'));
    }

    public function galleryCreate()
    {
        return view('admin.gallery.create');
    }

    public function galleryStore(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'desc' => 'nullable|string|max:500',
            'url' => 'nullable|string|max:500',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        // Upload file or use URL
        $url = $validated['url'] ?? '';
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('gallery', 'public');
            $url = asset('storage/' . $path);
        }

        if (empty($url)) {
            return back()->withErrors(['url' => 'Please provide an external image URL or upload an image file.'])->withInput();
        }

        Gallery::create([
            'title' => $validated['title'],
            'desc' => $validated['desc'],
            'url' => $url,
        ]);

        return redirect()->route('admin.gallery.index')->with('success', "Image '{$validated['title']}' added to gallery successfully!");
    }

    public function galleryDestroy($id)
    {
        $img = Gallery::findOrFail($id);
        $title = $img->title;
        
        // Clean up stored file if it exists locally
        if (str_contains($img->url, asset('storage/'))) {
            $relativePath = str_replace(asset('storage/'), '', $img->url);
            Storage::disk('public')->delete($relativePath);
        }

        $img->delete();

        return redirect()->route('admin.gallery.index')->with('success', "Image '{$title}' deleted from gallery successfully!");
    }

    // ==========================================
    // INQUIRIES / LEADS
    // ==========================================

    public function inquiriesIndex(Request $request)
    {
        $search = $request->input('search');

        $inquiries = ContactInquiry::query()
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('package', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
            })
            ->latest()
            ->get();

        return view('admin.inquiries.index', compact('inquiries', 'search'));
    }

    public function inquiriesDestroy($id)
    {
        $inquiry = ContactInquiry::findOrFail($id);
        $name = $inquiry->name;
        $inquiry->delete();

        return redirect()->route('admin.inquiries.index')->with('success', "Inquiry from '{$name}' deleted successfully.");
    }

    private function uniqueSlug(string $modelClass, string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title) ?: Str::random(8);
        $slug = $baseSlug;
        $counter = 2;

        while ($modelClass::query()
            ->where('slug', $slug)
            ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
