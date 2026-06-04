<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactInquiry;
use App\Models\Gallery;
use App\Models\Page;
use App\Models\Tour;

class BhutanController extends Controller
{
    public function home()
    {
        // Load home page content from pages table
        $homePage = Page::where('slug', 'home')->first();
        $homeTitle = $homePage?->title && strtolower($homePage->title) !== 'home'
            ? $homePage->title
            : 'Discover the Magic of Bhutan';
        $homeHero = [
            'eyebrow' => 'Land of the Thunder Dragon',
            'title' => $homeTitle,
            'description' => $homePage?->description ?: 'Crafting bespoke, authentic, and high-end journeys with Bhutan\'s top local tour operator. Fully customizable private and small group tours with transparent local prices.',
            'image' => $this->homeHeroImage(),
        ];
        $showcaseImage = $this->galleryImage('Punakha Dzong', $this->imageLibrary()['punakha']);
        
        // Load featured tours from tours table
        $featuredTours = Tour::whereIn('slug', [
            '5-day-4-night-bhutan-splendor-tour',
            '11-days-10-nights-druk-path-trek',
            'paro-tsechu-festival-tours'
        ])->get();

        if ($featuredTours->isEmpty()) {
            $featuredTours = Tour::take(3)->get();
        }

        // Fetch a few popular destinations for the home section showcase
        $featuredDestinations = Page::where('type', 'destination')->take(3)->get();
        $destinationImages = $this->pageImageMap($featuredDestinations, 600);

        // Fetch a few guides
        $recentGuides = Page::where('type', 'info')->take(3)->get();
        $guideImages = $this->pageImageMap($recentGuides, 600);

        return view('home', compact('homePage', 'homeHero', 'showcaseImage', 'featuredTours', 'featuredDestinations', 'destinationImages', 'recentGuides', 'guideImages'));
    }

    public function tours()
    {
        // Load all tours from database
        $tours = Tour::orderBy('title')->get();

        return view('tours', compact('tours'));
    }

    public function showCategory($slug)
    {
        // Fetch category page details from pages table where type = 'category'
        $categoryPage = Page::where('type', 'category')->where('slug', $slug)->first();

        // Fallback to dynamic creation if not found in db
        if (!$categoryPage) {
            $titles = [
                'cultural' => 'Cultural Journeys',
                'trekking' => 'Trekking Adventures',
                'festival' => 'Festival Packages',
                'hiking' => 'Day Hikes & Walking',
                'homestay' => 'Local Homestays',
                'special' => 'Special Interest Tours',
            ];
            $descriptions = [
                'cultural' => 'Explore Bhutanese culture, fortresses, and heritage.',
                'trekking' => 'Trek through pristine high-altitude paths.',
                'festival' => 'Experience vibrant annual festivals.',
                'hiking' => 'Sacred day hikes in peaceful valleys.',
                'homestay' => 'Stay in traditional farmhouses.',
                'special' => 'Rafting, bird watching, photography.',
            ];

            $categoryPage = new Page([
                'slug' => $slug,
                'title' => $titles[$slug] ?? ucfirst($slug) . ' Tours',
                'description' => $descriptions[$slug] ?? 'Explore our handpicked itineraries.',
                'keywords' => $slug . ' tours, bhutan ' . $slug,
                'content_html' => '<p>Explore our custom ' . $slug . ' tour packages.</p>',
                'content_text' => 'Explore our custom ' . $slug . ' tour packages.',
                'type' => 'category'
            ]);
        }

        // Fetch all tours in this category
        $tours = Tour::where('category', $slug)->orderBy('title')->get();
        $heroImage = $this->categoryImage($slug, 1200);

        return view('tours.category', compact('categoryPage', 'tours', 'slug', 'heroImage'));
    }

    public function showTour($slug)
    {
        // Load specific tour package from database
        $tour = Tour::where('slug', $slug)->firstOrFail();
        
        // Fetch 3 related tours in the same category (excluding current)
        $relatedTours = Tour::where('category', $tour->category)
                            ->where('id', '!=', $tour->id)
                            ->take(3)
                            ->get();
        $tourOverview = $this->tourOverview($tour);
        $heroImage = $tour->hero_image ?: $this->categoryImage($tour->category, 1600);

        return view('tours.show', compact('tour', 'relatedTours', 'tourOverview', 'heroImage'));
    }

    public function about($slug = null)
    {
        $aboutSlugs = [
            'about-us_area-and-population' => 'Area & Population',
            'about-us_history-of-bhutan' => 'History of Bhutan',
            'about-us_political-systems-in-bhutan' => 'Political Systems',
            'about-us_bhutanese-culture-and-architecture' => 'Culture & Architecture',
            'about-us_bhutanese-people-and-economy' => 'People & Economy',
            'about-us_more-about-bhutan' => 'More About Bhutan',
        ];

        if (!$slug) {
            $slug = 'about-us_area-and-population';
        } else {
            if (!str_contains($slug, 'about-us_')) {
                $slug = 'about-us_' . $slug;
            }
        }

        // Fetch page from pages table
        $pageData = Page::where('slug', $slug)->firstOrFail();

        return view('about', compact('pageData', 'aboutSlugs', 'slug'));
    }

    public function info($slug = null)
    {
        $infoSlugs = [
            'travelers-information' => 'Overview & Information',
            'travelers-information_bhutan-international-airlines' => 'Flight Information',
            'travelers-information_bhutanese-visa' => 'Bhutan Visa & Entry',
            'travelers-information_bhutan-tourism-policy-and-sdf' => 'Tourism Policy & SDF',
            'travelers-information_bhutan-tour-costs' => 'Bhutan Tour Cost',
            'travelers-information_bhutan-tour-payment' => 'Payment Methods',
            'travelers-information_best-time-to-visit-bhutan' => 'Best Time to Visit',
            'travelers-information_transportation-within-bhutan' => 'Vehicles & Transport',
            'travelers-information_hotels-in-bhutan' => 'Our Partner Hotels',
            'travelers-information_tour-cancellation-refund-policy' => 'Cancellation & Refund',
        ];

        if (!$slug) {
            $slug = 'travelers-information';
        } else {
            if ($slug === 'overview') {
                $slug = 'travelers-information';
            } elseif (!str_contains($slug, 'travelers-information_')) {
                $slug = 'travelers-information_' . $slug;
            }
        }

        // Fetch page from pages table
        $pageData = Page::where('slug', $slug)->firstOrFail();

        return view('info', compact('pageData', 'infoSlugs', 'slug'));
    }

    public function destinations()
    {
        // Fetch all pages of type destination
        $destinations = Page::where('type', 'destination')->orderBy('title')->get();
        $heroImage = $this->galleryImage('Himalayan Valleys', $this->imageLibrary()['thimphu']);
        $destinationImages = $this->pageImageMap($destinations, 800);
        return view('destinations.index', compact('destinations', 'heroImage', 'destinationImages'));
    }

    public function showDestination($slug)
    {
        // Fetch specific destination guide
        $destination = Page::where('slug', $slug)->where('type', 'destination')->firstOrFail();
        
        // Fetch suggested tours containing destination name
        $destName = str_replace(' Valley', '', $destination->title);
        $suggestedTours = Tour::where('title', 'like', "%{$destName}%")
                              ->orWhere('content_text', 'like', "%{$destName}%")
                              ->take(3)
                              ->get();
                              
        if ($suggestedTours->isEmpty()) {
            $suggestedTours = Tour::where('category', 'cultural')->take(3)->get();
        }
        $heroImage = $this->pageImage($destination, 1200);

        return view('destinations.show', compact('destination', 'suggestedTours', 'heroImage'));
    }

    public function trekking()
    {
        // Fetch trekking guides and packages
        $trekGuides = Page::where('type', 'trekking')->orderBy('title')->get();
        $trekPackages = Tour::where('category', 'trekking')->orderBy('title')->get();
        
        return view('trekking.index', compact('trekGuides', 'trekPackages'));
    }

    public function showTrek($slug)
    {
        // Fetch specific trek guide
        $trek = Page::where('slug', $slug)->where('type', 'trekking')->firstOrFail();
        
        // Fetch matching tour package
        $trekName = str_replace(' Guide', '', $trek->title);
        $package = Tour::where('title', 'like', "%{$trekName}%")
                       ->orWhere('content_text', 'like', "%{$trekName}%")
                       ->first();
                       
        if (!$package) {
            $package = Tour::where('category', 'trekking')->first();
        }

        return view('trekking.show', compact('trek', 'package'));
    }

    public function guides()
    {
        // Fetch travel blogs (info pages)
        $guides = Page::where('type', 'info')->orderBy('title')->get();
        return view('guide.index', compact('guides'));
    }

    public function showGuide($slug)
    {
        // Fetch specific travel blog
        $guide = Page::where('slug', $slug)->where('type', 'info')->firstOrFail();
        
        // Fetch related travel guides
        $allGuides = Page::where('type', 'info')->where('id', '!=', $guide->id)->take(3)->get();
        
        return view('guide.show', compact('guide', 'allGuides'));
    }

    public function festivals()
    {
        // Load all festival tours from database
        $festivalsData = Tour::where('category', 'festival')->orderBy('title')->get();
        
        // Define timeline dates map based on metadata
        $datesMap = [
            'punakha-tshechu-festival-tours' => ['date' => 'Feb 16-18, 2027', 'loc' => 'Punakha Dzong'],
            'gomphu-kora-festival' => ['date' => 'Mar 16-24, 2027', 'loc' => 'Talo / Paro Dzong'],
            'paro-tsechu-festival-tours' => ['date' => 'Mar 19-27, 2027', 'loc' => 'Paro Dzong'],
            'ura-yakchoe-festival' => ['date' => 'April 18-22, 2027', 'loc' => 'Bumthang Ura'],
            'haa-summer-festival' => ['date' => 'April 7-9, 2025', 'loc' => 'Haa Valley'],
            'thimphu-drubchen-festival-tour' => ['date' => 'Sept 14-20, 2026', 'loc' => 'Thimphu Dzong'],
            'thimphu-festival-tours' => ['date' => 'Sept 18-26, 2026', 'loc' => 'Thimphu / Gangtey Dzong'],
            'nomad-festival-in-bumthang' => ['date' => 'Sept 26-27, 2026', 'loc' => 'Bumthang'],
            'bumthang-jambhay-lhakhang-festival-tours' => ['date' => 'Nov 1-11, 2025', 'loc' => 'Bumthang Jambay'],
            'dochula-druk-wangyel-festival-tours' => ['date' => 'Dec 12-18, 2025', 'loc' => 'Dochula Pass'],
            'trongsa-festival-tours' => ['date' => 'Dec 17-21, 2026', 'loc' => 'Trongsa Dzong'],
        ];

        $festivals = [];
        foreach ($festivalsData as $fest) {
            $meta = $datesMap[$fest->slug] ?? ['date' => 'Upcoming 2026/2027', 'loc' => 'Bhutan'];
            $festivals[] = [
                'slug' => $fest->slug,
                'name' => $fest->title,
                'date' => $meta['date'],
                'loc' => $meta['loc'],
                'content_html' => $fest->content_html,
                'content_text' => $fest->content_text
            ];
        }

        return view('festivals', compact('festivals'));
    }

    public function gallery()
    {
        $images = \App\Models\Gallery::orderBy('created_at', 'desc')->get();
        return view('gallery', compact('images'));
    }

    public function contact()
    {
        // Get list of tours for the dropdown selector
        $tourOptions = Tour::orderBy('title')->pluck('title')->toArray();

        return view('contact', compact('tourOptions'));
    }

    public function submitInquiry(Request $request)
    {
        // Spambot Honeypot Check
        if ($request->filled('website_verification_token')) {
            return back()->with('success', 'Thank you! Your travel inquiry has been successfully received. Chimi Dem or one of our planners will get back to you within 24 hours.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'package' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        ContactInquiry::create($validated);

        return back()->with('success', 'Thank you! Your travel inquiry has been successfully received. Chimi Dem or one of our planners will get back to you within 24 hours.');
    }

    private function homeHeroImage(): ?string
    {
        $url = Gallery::latest()->value('url');
        if ($url) {
            return $url;
        }
        if (app()->environment('production')) {
            return null;
        }
        return $this->galleryImage('Taktshang Goemba', $this->imageLibrary()['paro']);
    }

    private function galleryImage(string $title, ?string $fallback): ?string
    {
        $url = Gallery::where('title', 'like', "%{$title}%")->value('url');
        if ($url) {
            return $url;
        }
        if (app()->environment('production')) {
            return null;
        }
        return $fallback;
    }

    private function pageImageMap($pages, int $width = 800): array
    {
        return $pages->mapWithKeys(fn ($page) => [
            $page->slug => $this->pageImage($page, $width),
        ])->all();
    }

    private function pageImage(Page $page, int $width = 800): ?string
    {
        return $this->imageForSlug($page->slug, $width);
    }

    private function categoryImage(string $category, int $width = 1200): ?string
    {
        return $this->imageForSlug($category, $width);
    }

    private function imageForSlug(string $slug, int $width = 800): ?string
    {
        if (app()->environment('production')) {
            return null;
        }
        $library = $this->imageLibrary($width);
        return $library[$slug] ?? $library['default'];
    }

    private function imageLibrary(int $width = 800): array
    {
        return [
            'paro' => "https://images.unsplash.com/photo-1544735716-392fe2489ffa?q=80&w={$width}",
            'thimphu' => "https://images.unsplash.com/photo-1533105079780-92b9be482077?q=80&w={$width}",
            'punakha' => "https://images.unsplash.com/photo-1578593139888-39622e2047de?q=80&w={$width}",
            'bumthang' => "https://images.unsplash.com/photo-1506744038136-46273834b3fb?q=80&w={$width}",
            'haa-valley' => "https://images.unsplash.com/photo-1507525428034-b723cf961d3e?q=80&w={$width}",
            'phobjikha' => "https://images.unsplash.com/photo-1472214222541-d510753a8707?q=80&w={$width}",
            'eastern-bhutan' => "https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca?q=80&w={$width}",
            'nepal' => "https://images.unsplash.com/photo-1526718583451-e877f3905b4e?q=80&w={$width}",
            'tibet' => "https://images.unsplash.com/photo-1605649487212-47bdab064df7?q=80&w={$width}",
            'cultural' => "https://images.unsplash.com/photo-1578593139888-39622e2047de?q=80&w={$width}",
            'trekking' => "https://images.unsplash.com/photo-1544735716-392fe2489ffa?q=80&w={$width}",
            'festival' => "https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca?q=80&w={$width}",
            'hiking' => "https://images.unsplash.com/photo-1507525428034-b723cf961d3e?q=80&w={$width}",
            'homestay' => "https://images.unsplash.com/photo-1506744038136-46273834b3fb?q=80&w={$width}",
            'special' => "https://images.unsplash.com/photo-1533105079780-92b9be482077?q=80&w={$width}",
            'default' => "https://images.unsplash.com/photo-1507525428034-b723cf961d3e?q=80&w={$width}",
        ];
    }

    private function tourOverview(Tour $tour): array
    {
        $category = strtolower($tour->category);

        return [
            ['label' => 'Duration', 'value' => $tour->duration],
            ['label' => 'Category', 'value' => ucfirst($tour->category), 'url' => route('tours.category', ['slug' => $tour->category])],
            ['label' => 'Activity Level', 'value' => match ($category) {
                'trekking' => 'Strenuous',
                'hiking', 'special' => 'Moderate',
                default => 'Easy to Moderate',
            }],
            ['label' => 'Group Size', 'value' => 'Min 1 / Private'],
            ['label' => 'Accommodation', 'value' => str_contains(strtolower($tour->title), 'luxury') ? 'Luxury Upgrade' : '3-Star Standard'],
            ['label' => 'Meals', 'value' => 'Full Board Included'],
        ];
    }
}
