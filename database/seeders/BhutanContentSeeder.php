<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;
use App\Models\Tour;
use Illuminate\Support\Facades\File;

class BhutanContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = storage_path('app/bhutan_content.json');
        if (!File::exists($path)) {
            $this->command->error("Content file bhutan_content.json not found in storage/app/.");
            return;
        }

        $content = json_decode(File::get($path), true);
        if (!$content) {
            $this->command->error("Failed to parse JSON content.");
            return;
        }

        // Clean tables to avoid duplicates
        Page::truncate();
        Tour::truncate();

        $pageCount = 0;
        $tourCount = 0;

        // 1. Seed Scraped General Pages & Info Pages
        foreach ($content as $key => $item) {
            if (str_starts_with($key, 'modules_') || str_starts_with($key, 'templates_')) {
                continue;
            }

            $isPage = false;
            $type = 'other';

            if (in_array($key, ['home', 'contact-us', 'photo-gallery', 'travelers-information', 'bhutan-festivals'])) {
                $isPage = true;
                $type = 'other';
            } elseif (str_starts_with($key, 'about-us_')) {
                $isPage = true;
                $type = 'about';
            } elseif (str_starts_with($key, 'travelers-information_')) {
                $isPage = true;
                $type = 'info';
            } elseif (str_starts_with($key, 'bhutan-festivals_')) {
                $isPage = true;
                $type = 'festival';
            }

            if ($isPage) {
                Page::create([
                    'slug' => $key,
                    'title' => $item['title'],
                    'description' => $item['description'] ?? null,
                    'keywords' => $item['keywords'] ?? null,
                    'content_html' => $item['content_html'],
                    'content_text' => $item['content_text'],
                    'type' => $type,
                ]);
                $pageCount++;
            } else {
                // Seed as a Tour Package
                // Categorize based on luxury parameters
                $category = 'cultural'; 
                $titleLower = strtolower($item['title']);

                if (str_contains($titleLower, 'luxury')) {
                    $category = 'luxury';
                } elseif (str_contains($titleLower, 'honeymoon') || str_contains($titleLower, 'honey')) {
                    $category = 'honeymoon';
                } elseif (str_contains($titleLower, 'family') || str_contains($titleLower, 'children')) {
                    $category = 'family';
                } elseif (str_contains($titleLower, 'phot') || str_contains($titleLower, 'photo')) {
                    $category = 'photography';
                } elseif (str_contains($titleLower, 'custom') || str_contains($titleLower, 'tailor')) {
                    $category = 'custom';
                } elseif (str_contains($titleLower, 'trek') || str_contains($titleLower, 'hike')) {
                    $category = 'trekking';
                } elseif (str_contains($titleLower, 'festival') || str_contains($titleLower, 'tshechu') || str_contains($titleLower, 'tsechu') || str_contains($titleLower, 'drup') || str_contains($titleLower, 'kora') || str_contains($titleLower, 'wangyel') || str_contains($titleLower, 'yakchoe') || str_contains($titleLower, 'mewang')) {
                    $category = 'festival';
                } elseif (str_contains($titleLower, 'mountain') || str_contains($titleLower, 'rafting') || str_contains($titleLower, 'textile') || str_contains($titleLower, 'bird') || str_contains($titleLower, 'village') || str_contains($titleLower, 'special')) {
                    $category = 'special';
                }

                // Extract Duration
                $duration = '7-10 Days';
                if (preg_match('/(\d+)\s*(?:Night|Day)/i', $item['title'], $matches)) {
                    $duration = $matches[0];
                } elseif (preg_match('/(\d+)\s*N\s*(\d+)\s*D/i', $item['title'], $matches)) {
                    $duration = $matches[0];
                }

                $text = strip_tags($item['content_text']);
                $words = explode(' ', $text);
                $snippet = count($words) > 25 
                    ? implode(' ', array_slice($words, 0, 22)) . '...' 
                    : $text;

                $tourImages = [
                    'cultural' => 'https://images.unsplash.com/photo-1578593139888-39622e2047de?q=80&w=800',
                    'trekking' => 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?q=80&w=800',
                    'festival' => 'https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca?q=80&w=800',
                    'hiking' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?q=80&w=800',
                    'homestay' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?q=80&w=800',
                    'luxury' => 'https://images.unsplash.com/photo-1533105079780-92b9be482077?q=80&w=800',
                ];
                $hero_image = $tourImages[$category] ?? 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?q=80&w=800';

                $priceVal = 1490;
                if ($category === 'luxury') {
                    $priceVal = 3450;
                } elseif ($category === 'trekking') {
                    $priceVal = 1980;
                } elseif ($category === 'festival') {
                    $priceVal = 1650;
                }
                $price = "USD $" . number_format($priceVal) . " / person";

                $departure_dates = json_encode([
                    'Sept 12, 2026', 'Oct 05, 2026', 'Oct 22, 2026', 'Nov 14, 2026', 'Mar 15, 2027', 'Apr 10, 2027'
                ]);

                $faqs = json_encode([
                    ['q' => 'Is the Sustainable Development Fee (SDF) included?', 'a' => 'No, the SDF of USD $100 per night is paid separately to the government, but we will collect and process this for you alongside visa fees.'],
                    ['q' => 'What is the level of physical fitness required?', 'a' => 'This tour is categorized as moderate. While it includes daily walks and a climb to Tiger\'s Nest (approx. 4-5 hours round trip), no technical mountaineering skill is required.'],
                    ['q' => 'Are meals and accommodation included?', 'a' => 'Yes, our tour price includes standard 3-star accommodations (upgradable to 5-star luxury like Amankora), all meals (breakfast, lunch, dinner), dynamic local transport, and a certified English-speaking guide.']
                ]);

                $reviews = json_encode([
                    ['name' => 'Sarah Mitchell', 'rating' => 5, 'date' => 'May 2026', 'text' => 'An absolute dream journey! Access Bhutan coordinated everything flawlessly, from the visa processing to the accommodations. Climbing Tiger\'s Nest was the highlight of our life.'],
                    ['name' => 'Hans Gruber', 'rating' => 5, 'date' => 'April 2026', 'text' => 'Chimi Dem was an incredible planner. The food was spicy and delicious, the hotels were authentic, and our guide Karma was highly knowledgeable about Buddhist history.'],
                    ['name' => 'David & Emily L.', 'rating' => 4.5, 'date' => 'Oct 2025', 'text' => 'Very well-supported trek and cultural tour. The views of the Bhutanese valleys were breathtaking. Highly recommend upgrading to their partner boutique hotel Access Suites in Thimphu.']
                ]);

                Tour::create([
                    'slug' => $key,
                    'title' => $item['title'],
                    'category' => $category,
                    'duration' => $duration,
                    'snippet' => $snippet,
                    'price' => $price,
                    'hero_image' => $hero_image,
                    'departure_dates' => $departure_dates,
                    'faqs' => $faqs,
                    'reviews' => $reviews,
                    'content_html' => $item['content_html'],
                    'content_text' => $item['content_text'],
                ]);
                $tourCount++;
            }
        }

        // 2. Seed Luxury Destination Pages
        $destinations = [
            [
                'slug' => 'paro',
                'title' => 'Paro Valley',
                'description' => 'The gateway to Bhutan, home to terraced fields, ancient temples, and the legendary Tigers Nest.',
                'keywords' => 'Paro, Tigers Nest, Paro Dzong, Bhutan gateway',
                'type' => 'destination',
                'content_html' => '<h3>About Paro</h3><p>Paro is a historic town with many sacred sites and historical buildings scattered through the valley. It is home to Bhutan\'s only international airport. The valley is wide and fertile, considered one of the most beautiful in the country.</p><h4>Top Attractions</h4><ul><li><strong>Taktshang Goemba (Tiger\'s Nest):</strong> Perched on a cliff 900m above the valley floor. It is Bhutan\'s most iconic spiritual site.</li><li><strong>Rinpung Dzong:</strong> A massive fortress and monastery, meaning "Fortress on a Heap of Jewels".</li><li><strong>National Museum (Ta Dzong):</strong> An ancient watchtower displaying Bhutanese art, heritage, and stamps.</li></ul><h4>Best Time to Visit</h4><p>March to May (Spring) and September to November (Autumn) offer clear skies and excellent hiking weather.</p>',
                'content_text' => "About Paro\nParo is a historic town with many sacred sites..."
            ],
            [
                'slug' => 'thimphu',
                'title' => 'Thimphu Capital',
                'description' => 'The modern capital of Bhutan, blending traditional Buddhist culture with contemporary cafes and monuments.',
                'keywords' => 'Thimphu, Buddha Dordenma, Tashichho Dzong, capital',
                'type' => 'destination',
                'content_html' => '<h3>About Thimphu</h3><p>Thimphu is the capital and largest city of Bhutan. It lies in the western-central part of the country. Unlike most capital cities, Thimphu has no traffic lights, maintaining its unique traditional charm.</p><h4>Top Attractions</h4><ul><li><strong>Buddha Dordenma (Buddha Point):</strong> A gigantic 51.5-meter bronze statue of Shakyamuni Buddha overlooking the valley.</li><li><strong>Tashichho Dzong:</strong> A majestic fortress housing the throne room, government offices, and the central monastic body.</li><li><strong>Motithang Takin Preserve:</strong> The wildlife reserve dedicated to the Takin, Bhutan\'s unique national animal.</li></ul><h4>Best Time to Visit</h4><p>Spring (March-May) for the Rhododendron blooms, and Autumn (September-November) for the Thimphu Tshechu festival.</p>',
                'content_text' => "About Thimphu\nThimphu is the capital..."
            ],
            [
                'slug' => 'punakha',
                'title' => 'Punakha Valley',
                'description' => 'The former winter capital of Bhutan, famous for its majestic river confluence and warm sub-tropical climate.',
                'keywords' => 'Punakha, Punakha Dzong, Chimi Lhakhang, suspension bridge',
                'type' => 'destination',
                'content_html' => '<h3>About Punakha</h3><p>Punakha was the capital of Bhutan and the seat of government until 1955. It is known for its warm, fertile valley where two major rivers meet.</p><h4>Top Attractions</h4><ul><li><strong>Punakha Dzong:</strong> Arguably the most beautiful dzong in Bhutan, located at the junction of the Pho Chhu (father) and Mo Chhu (mother) rivers.</li><li><strong>Chimi Lhakhang (Temple of Fertility):</strong> The sacred temple dedicated to Lama Drukpa Kunley, the "Divine Madman".</li><li><strong>Punakha Suspension Bridge:</strong> One of the longest and most scenic footbridges in Bhutan, adorned with prayer flags.</li></ul><h4>Best Time to Visit</h4><p>Punakha is warmer and lower in altitude, making it a perfect winter destination from December to February.</p>',
                'content_text' => "About Punakha\nPunakha was the capital..."
            ],
            [
                'slug' => 'bumthang',
                'title' => 'Bumthang Valley',
                'description' => 'The spiritual heartland of Bhutan, home to some of the country\'s oldest Buddhist temples and scenic pine forests.',
                'keywords' => 'Bumthang, Jakar Dzong, Kurjey Lhakhang, spiritual',
                'type' => 'destination',
                'content_html' => '<h3>About Bumthang</h3><p>Bumthang consists of four valleys: Chumey, Choekhor, Tang, and Ura. It is considered the religious heartland of Bhutan, where Guru Rinpoche first visited and cured the local king.</p><h4>Top Attractions</h4><ul><li><strong>Jakar Dzong:</strong> The "Castle of the White Bird" overlooking the town.</li><li><strong>Kurjey Lhakhang:</strong> The temple containing the body print of Guru Rinpoche.</li><li><strong>Jambay Lhakhang:</strong> One of the 108 temples built by King Songtsen Gampo in the 7th century.</li></ul><h4>Best Time to Visit</h4><p>Autumn (September-November) is popular for the Jambay Lhakhang Drup and Ura Yakchoe festivals.</p>',
                'content_text' => "About Bumthang\nBumthang is the religious heartland..."
            ],
            [
                'slug' => 'haa-valley',
                'title' => 'Haa Valley',
                'description' => 'A remote, pristine valley bordering Tibet, offering untamed alpine landscapes and ancient animist culture.',
                'keywords' => 'Haa, Haa valley, remote Bhutan, Black temple',
                'type' => 'destination',
                'content_html' => '<h3>About Haa Valley</h3><p>Opened to tourists only in 2002, Haa remains one of the most pristine and least visited valleys in Bhutan, maintaining its traditional lifestyle and gorgeous pine-studded peaks.</p><h4>Top Attractions</h4><ul><li><strong>Lhakhang Karpo & Nagpo:</strong> The White and Black temples built in the 7th century protecting the valley.</li><li><strong>Chele La Pass:</strong> The highest drivable mountain pass in Bhutan (3,988m), separating Paro and Haa valleys.</li><li><strong>Haa Summer Festival:</strong> An annual celebration of nomadic life, local yak butter dishes, and archery.</li></ul><h4>Best Time to Visit</h4><p>Summer (June-August) for the lush green pastures and alpine flowers.</p>',
                'content_text' => "About Haa Valley\nHaa is one of the most pristine..."
            ],
            [
                'slug' => 'phobjikha',
                'title' => 'Phobjikha Valley (Gangtey)',
                'description' => 'A beautiful glacial valley, winter home of the rare black-necked cranes and Gangtey Monastery.',
                'keywords' => 'Phobjikha, Gangtey, black-necked cranes, valley',
                'type' => 'destination',
                'content_html' => '<h3>About Phobjikha</h3><p>Phobjikha is a wide U-shaped glacial valley at an elevation of 3,000 meters. It is a designated conservation area because of the migratory cranes arriving from Tibet.</p><h4>Top Attractions</h4><ul><li><strong>Gangtey Monastery:</strong> An important 17th-century monastery of the Nyingmapa sect.</li><li><strong>Black-Necked Crane Information Center:</strong> Observation decks equipped with binoculars to view the cranes.</li><li><strong>Gangtey Nature Trail:</strong> A beautiful 2-hour walk starting from the monastery down across the valley floor.</li></ul><h4>Best Time to Visit</h4><p>Late October to February when the black-necked cranes winter in the valley.</p>',
                'content_text' => "About Phobjikha\nPhobjikha is a wide glacial valley..."
            ],
            [
                'slug' => 'eastern-bhutan',
                'title' => 'Eastern Bhutan (Trashigang & Mongar)',
                'description' => 'The wild and rugged east, featuring dense sub-tropical forests, unique tribal weavers, and majestic dzongs.',
                'keywords' => 'Eastern Bhutan, Trashigang, Mongar, weavers, Radhi',
                'type' => 'destination',
                'content_html' => '<h3>About Eastern Bhutan</h3><p>Eastern Bhutan is rarely visited by tourists, offering a rugged, wild landscape, deep gorges, and highly unique craft traditions such as raw silk weaving.</p><h4>Top Attractions</h4><ul><li><strong>Trashigang Dzong:</strong> Perched on a cliff edge, historically commanding the eastern routes.</li><li><strong>Radhi Village:</strong> Famous for its skilled weavers who make hand-spun raw silk textiles.</li><li><strong>Aja Ney:</strong> A sacred pilgrimage site containing Guru Rinpoche\'s prints on rocks.</li></ul><h4>Best Time to Visit</h4><p>October to April when the roads are clear and passes are not blocked by winter snows.</p>',
                'content_text' => "About Eastern Bhutan\nEastern Bhutan is rugged and rarely visited..."
            ],
            [
                'slug' => 'nepal',
                'title' => 'Nepal (Kathmandu & Everest)',
                'description' => 'The ultimate Himalayan destination, home to Mount Everest, historic Kathmandu temples, and Pokhara.',
                'keywords' => 'Nepal, Kathmandu, Everest, Pokhara',
                'type' => 'destination',
                'content_html' => '<h3>About Nepal</h3><p>Nepal is a landlocked country in South Asia, situated in the Himalayas. It is home to eight of the world\'s ten tallest mountains, including Mount Everest. It is a major spiritual and adventure destination.</p><h4>Top Attractions</h4><ul><li><strong>Kathmandu Durbar Square:</strong> Historic palaces and temples in the heart of the capital city.</li><li><strong>Boudhanath Stupa:</strong> One of the largest spherical stupas in the world.</li><li><strong>Pokhara:</strong> The scenic lakeside city serving as the gateway to the Annapurna region.</li></ul><h4>Best Time to Visit</h4><p>October to November (Autumn) and March to April (Spring) offer the best trekking weather.</p>',
                'content_text' => "About Nepal\nNepal is a landlocked country in South Asia, situated in the Himalayas..."
            ],
            [
                'slug' => 'tibet',
                'title' => 'Tibet (Lhasa & Mount Kailash)',
                'description' => 'The Roof of the World, featuring the majestic Potala Palace, sacred Jokhang Temple, and Mount Kailash.',
                'keywords' => 'Tibet, Lhasa, Potala Palace, Mount Kailash, Roof of the World',
                'type' => 'destination',
                'content_html' => '<h3>About Tibet</h3><p>Tibet, situated on the Tibetan Plateau, is the highest region on Earth, with an average elevation of 4,380 meters. Known as the "Roof of the World", it offers spectacular views of the Himalayas, historic Buddhist monasteries, and deep spiritual traditions.</p><h4>Top Attractions</h4><ul><li><strong>Potala Palace:</strong> The winter palace of the Dalai Lama since the 7th century, a symbol of Tibetan Buddhism and historic administration.</li><li><strong>Jokhang Temple:</strong> Located in Barkhor Square, it is considered the most sacred temple in Tibet.</li><li><strong>Mount Kailash & Lake Manasarovar:</strong> The sacred mountain and lake, prime pilgrimage site for Hindus, Buddhists, and Jains.</li></ul><h4>Best Time to Visit</h4><p>May to October offers the warmest temperatures, clear skies, and easiest travel conditions across the plateau.</p>',
                'content_text' => "About Tibet\nTibet, situated on the Tibetan Plateau, is the highest region on Earth, with an average elevation of 4,380 meters..."
            ]
        ];

        foreach ($destinations as $dest) {
            Page::create($dest);
            $pageCount++;
        }

        // 3. Seed Trekking Guides
        $treks = [
            [
                'slug' => 'snowman-trek',
                'title' => 'Snowman Trek Guide',
                'description' => 'Ultimate guide to the hardest trek in the world, crossing 11 high-altitude passes in the Himalayas.',
                'keywords' => 'Snowman trek, hardest trek, altitude, packing list',
                'type' => 'trekking',
                'content_html' => '<h3>Snowman Trek - The Ultimate Expedition</h3><p>The Snowman Trek is widely considered the most difficult trek in the world, taking 25 days and crossing 11 high passes over 4,500 meters, along the border of Tibet.</p><div class="grid grid-cols-2 gap-4 my-6 bg-muted p-4 rounded-lg"><p><strong>Difficulty:</strong> <span class="text-destructive font-bold">Strenuous / Extreme</span></p><p><strong>Duration:</strong> 25 Days</p><p><strong>Max Altitude:</strong> 5,230 meters (Rinchen Zoe La)</p><p><strong>Best Season:</strong> October (Clear autumn window)</p></div><h4>Trek Itinerary & Highlights</h4><p>Starting from Paro, you cross the wilderness of Laya and enter Lunana, the most isolated valley in Bhutan. Highlights include glacial lakes, nomadic yak herder interactions, and views of unclimbed peaks like Gangkhar Puensum.</p><h4>Packing Checklist</h4><ul><li>Heavy expedition-grade down jacket (-20C)</li><li>Sturdy waterproof alpine trekking boots</li><li>4-season sleeping bag</li><li>Water purification tablets and personal first-aid kit</li></ul>',
                'content_text' => "Snowman Trek Guide\nDifficulty: Extreme\nDuration: 25 Days..."
            ],
            [
                'slug' => 'jomolhari-trek',
                'title' => 'Jomolhari Trek Guide',
                'description' => 'Scenic trek to Mount Jomolhari basecamp, offering spectacular views of alpine lakes and snowy peaks.',
                'keywords' => 'Jomolhari, trek, basecamp, mountain, altitude',
                'type' => 'trekking',
                'content_html' => '<h3>Jomolhari Trek - Mount Jomolhari Basecamp</h3><p>The Jomolhari Trek is one of the most popular treks in Bhutan, offering stunning views of Mount Jomolhari (7,326m) from Jangothang basecamp.</p><div class="grid grid-cols-2 gap-4 my-6 bg-muted p-4 rounded-lg"><p><strong>Difficulty:</strong> <span class="text-amber-500 font-bold">Moderate / Demanding</span></p><p><strong>Duration:</strong> 9 - 12 Days</p><p><strong>Max Altitude:</strong> 4,890 meters (Bhonte La Pass)</p><p><strong>Best Season:</strong> April-May & October-November</p></div><h4>Trek Highlights</h4><p>Following the Paro Chhu river, the trail rises through alpine meadows, pine forests, and leads to the base of Jomolhari where yak herders graze their herds.</p><h4>Packing Checklist</h4><ul><li>Light-weight hiking boots</li><li>Thermal base layers</li><li>Windproof shell jacket</li><li>Walking poles</li></ul>',
                'content_text' => "Jomolhari Trek Guide\nDifficulty: Moderate\nDuration: 9-12 Days..."
            ],
            [
                'slug' => 'druk-path-trek',
                'title' => 'Druk Path Trek Guide',
                'description' => 'A classic, scenic trek connecting Paro and Thimphu, crossing alpine lakes and ancient fortresses.',
                'keywords' => 'Druk Path, trek, Paro Thimphu, alpine lakes',
                'type' => 'trekking',
                'content_html' => '<h3>Druk Path Trek - The Classic Route</h3><p>The Druk Path Trek is a short, beautiful trek connecting Paro and Thimphu valleys, suitable for beginner trekkers with good fitness.</p><div class="grid grid-cols-2 gap-4 my-6 bg-muted p-4 rounded-lg"><p><strong>Difficulty:</strong> <span class="text-primary dark:text-accent font-bold">Easy / Moderate</span></p><p><strong>Duration:</strong> 6 Days</p><p><strong>Max Altitude:</strong> 4,200 meters (Phume La Pass)</p><p><strong>Best Season:</strong> March-May & September-November</p></div><h4>Trek Highlights</h4><p>The trail passes through dwarf rhododendron forests, ruined castles, and the stunning Jimilang Tsho (lake), famous for its giant trout. You get views of Mt. Gangkar Puensum on clear days.</p><h4>Packing Checklist</h4><ul><li>Standard waterproof hiking jacket</li><li>Sleeping bag (0C rated)</li><li>Comfortable trail shoes</li></ul>',
                'content_text' => "Druk Path Trek Guide\nDifficulty: Moderate\nDuration: 6 Days..."
            ],
            [
                'slug' => 'dagala-trek',
                'title' => 'Dagala Thousand Lakes Trek Guide',
                'description' => 'Trek across alpine meadows and numerous high-altitude lakes with views of the entire Bhutanese Himalayas.',
                'keywords' => 'Dagala, thousand lakes, trek, altitude, lakes',
                'type' => 'trekking',
                'content_html' => '<h3>Dagala Thousand Lakes Trek</h3><p>This scenic trek leads across the Dagala ridge, passing through dozens of clear mountain lakes, and offers views of Everest, Kanchenjunga, and Jomolhari on clear days.</p><div class="grid grid-cols-2 gap-4 my-6 bg-muted p-4 rounded-lg"><p><strong>Difficulty:</strong> <span class="text-amber-500 font-bold">Moderate</span></p><p><strong>Duration:</strong> 6 Days</p><p><strong>Max Altitude:</strong> 4,720 meters</p><p><strong>Best Season:</strong> October-November</p></div><h4>Trek Highlights</h4><p>Explore high pasture lands, fish for trout in the glacial lakes, and camp under the starry Himalayan skies.</p><h4>Packing Checklist</h4><ul><li>Waterproof tent floor lining</li><li>Warm fleece jacket</li><li>Good sunglasses & sun protection</li></ul>',
                'content_text' => "Dagala Trek Guide\nDifficulty: Moderate\nDuration: 6 Days..."
            ]
        ];

        foreach ($treks as $trek) {
            Page::create($trek);
            $pageCount++;
        }

        // 4. Seed Travel Guides (Blog-style info hub)
        $guides = [
            [
                'slug' => 'visa-guide',
                'title' => 'Bhutan Visa Guide & Requirements',
                'description' => 'Complete guide on how to get a Bhutan visa, processing times, fees, and travel documents needed.',
                'keywords' => 'Bhutan visa, requirements, online visa application, travel guide',
                'type' => 'info',
                'content_html' => '<h3>Bhutan Visa Requirements & Guide</h3><p>All tourists (except citizens of India, Bangladesh, and Maldives) require a visa to enter Bhutan. The visa must be cleared before your travel date.</p><h4>How to Apply</h4><p>We handle the entire visa clearance process for you. You only need to send us a color copy of your passport photo page (valid for at least 6 months) and proof of travel insurance.</p><h4>Visa Fee</h4><p>The visa clearance fee is USD $40 per traveler. This is a one-time fee paid alongside your tour payment.</p>',
                'content_text' => "Bhutan Visa Guide\nAll tourists require a visa..."
            ],
            [
                'slug' => 'cost-guide',
                'title' => 'Bhutan Travel Costs and SDF Explained',
                'description' => 'Understanding the Sustainable Development Fee (SDF), tour costs, daily spending, and payment methods.',
                'keywords' => 'SDF, SDF fee, tour costs, Bhutan daily fee, payment',
                'type' => 'info',
                'content_html' => '<h3>Understanding Bhutan Tour Costs and SDF</h3><p>Bhutan uses a unique "High Value, Low Volume" tourism model. The cost of visiting Bhutan includes a daily tax known as the Sustainable Development Fee (SDF).</p><h4>What is the SDF?</h4><p>The SDF is USD $100 per adult per night. Children aged 6-12 receive a 50% discount. This tax is used directly by the government for free healthcare, education, and carbon-neutral infrastructure.</p><h4>Other Incurred Costs</h4><p>On top of the SDF, you pay for your hotels, meals, transport, guide services, and entrance tickets, which average USD $150-$250 per night depending on luxury level.</p>',
                'content_text' => "Bhutan Travel Cost\nSDF is USD 100 per night..."
            ],
            [
                'slug' => 'food-guide',
                'title' => 'Bhutan Food Guide: What to Eat',
                'description' => 'A delicious journey into Bhutanese cuisine, from cheese-chili (Ema Datshi) to butter tea and local beverages.',
                'keywords' => 'Ema Datshi, Bhutan food, momos, local cuisine',
                'type' => 'info',
                'content_html' => '<h3>A Guide to Bhutanese Cuisine</h3><p>Bhutanese food is unique, rustic, and heavily features chilies and cheese (datshi). Most meals are served with red rice, which has a nutty flavor.</p><h4>Must-Try Dishes</h4><ul><li><strong>Ema Datshi:</strong> The national dish of Bhutan made of chilies and melted cheese. Beware: it is spicy!</li><li><strong>Momos:</strong> Steamed dumplings filled with minced meat, cheese, or vegetables.</li><li><strong>Suja:</strong> Traditional butter tea brewed with salt, tea leaves, and butter.</li></ul>',
                'content_text' => "Bhutan Food Guide\nBhutanese food features chilies and cheese..."
            ],
            [
                'slug' => 'packing-lists',
                'title' => 'The Complete Bhutan Packing List',
                'description' => 'What to pack for Bhutan, including clothing requirements for temple visits, mountain trails, and accessories.',
                'keywords' => 'what to pack, dress code, clothing, accessories, temples',
                'type' => 'info',
                'content_html' => '<h3>What to Pack for Your Bhutan Trip</h3><p>Bhutan\'s climate varies greatly with altitude. Dressing in layers is essential.</p><h4>Temple Dress Code</h4><p>When entering temples, dzongs, and monasteries, you must wear modest clothing. Long trousers, long-sleeved shirts, and closed shoes are required. Hats and sunglasses must be removed.</p><h4>Essentials List</h4><ul><li>Light hiking fleece/sweater</li><li>Modest shirts and pants</li><li>Sturdy walking shoes</li><li>Sun protection (hat, sunscreen, sunglasses)</li><li>Universal adapter</li></ul>',
                'content_text' => "Bhutan Packing List\nDressing in layers is essential..."
            ],
            [
                'slug' => 'travel-tips',
                'title' => 'Bhutan Travel Tips & Cultural Etiquette',
                'description' => 'Essential travel tips for visiting Bhutan, currency exchange, SIM cards, and cultural etiquette.',
                'keywords' => 'currency, SIM cards, etiquette, tips, customs',
                'type' => 'info',
                'content_html' => '<h3>Bhutan Travel Tips & Etiquette</h3><p>Here are some essential tips to keep in mind for a smooth and respectful trip.</p><h4>Currency & ATMs</h4><p>Bhutan\'s currency is the Ngultrum (Nu), pegged to the Indian Rupee. Indian Rupees (except 500/2000 notes) are widely accepted. ATMs are available in major towns but can be unreliable; carrying USD cash to exchange is recommended.</p><h4>SIM Cards</h4><p>We will help you purchase a tourist SIM card from TashiCell or B-Mobile upon arrival for mobile data.</p><h4>Cultural Etiquette</h4><ul><li>Walk clockwise around stupas, chortens, and prayer wheels.</li><li>Always ask before taking photos of people or inside temples (photography is prohibited inside altar rooms).</li></ul>',
                'content_text' => "Bhutan Travel Tips\nCurrency is Ngultrum..."
            ]
        ];

        foreach ($guides as $guide) {
            Page::create($guide);
            $pageCount++;
        }

        // 5. Seed Tour Categories as Pages
        $categories = [
            [
                'slug' => 'cultural',
                'title' => 'Cultural Journeys',
                'description' => 'Immerse yourself in Bhutan\'s ancient culture, spectacular dzongs, and spiritual traditions with our custom itineraries.',
                'keywords' => 'Bhutan culture, cultural tours, Bhutan monasteries, dzongs',
                'type' => 'category',
                'content_html' => '<h3>About Cultural Journeys</h3><p>Cultural tours are designed to bring you in close contact with the people, history, and spiritual heritage of the Himalayas. You will visit ancient fortresses (dzongs), climb cliffside monasteries, and experience local farm hospitality.</p>',
                'content_text' => 'About Cultural Journeys: Cultural tours bring you close to people and history.'
            ],
            [
                'slug' => 'trekking',
                'title' => 'Trekking Adventures',
                'description' => 'Trek through the untouched wilderness of the Himalayas, camping by glacial lakes under towering unclimbed peaks.',
                'keywords' => 'Bhutan trekking, Himalayan treks, Snowman trek, hiking Bhutan',
                'type' => 'category',
                'content_html' => '<h3>About Trekking Adventures</h3><p>Our trekking tours range from moderate hikes to extreme high-altitude alpine expeditions. You will camp in pristine locations, cross high mountain passes, and see stunning vistas of snow-capped peaks.</p>',
                'content_text' => 'About Trekking Adventures: Moderate to extreme alpine expeditions.'
            ],
            [
                'slug' => 'festival',
                'title' => 'Festival Packages',
                'description' => 'Experience the vibrant colors, masked dances, and sacred Buddhist rituals of Bhutan\'s annual Tshechus.',
                'keywords' => 'Bhutan festivals, Tshechu, masked dance, Buddhist festival, Paro Tsechu',
                'type' => 'category',
                'content_html' => '<h3>About Festival Packages</h3><p>Experience the spectacular Tshechus of Bhutan. These annual festivals bring local communities together for sacred Cham (masked) dances, traditional music, and blessings, celebrating the deeds of Guru Rinpoche.</p>',
                'content_text' => 'About Festival Packages: Spectacular annual Tshechus with masked dances.'
            ],
            [
                'slug' => 'hiking',
                'title' => 'Day Hikes & Walking',
                'description' => 'Walk along serene pine-forested trails, sacred cliffside hermits, and scenic valleys, including the famous Tiger\'s Nest.',
                'keywords' => 'Bhutan day hikes, walking tours, Tiger\'s Nest walk, nature trails',
                'type' => 'category',
                'content_html' => '<h3>About Day Hikes & Walking</h3><p>Perfect for travelers who want to explore Bhutan\'s nature on foot without high-altitude camping. Enjoy daily walks through local villages, pine forests, and climbing to landmarks like the Tiger\'s Nest.</p>',
                'content_text' => 'About Day Hikes: Daily walks and nature trails.'
            ],
            [
                'slug' => 'homestay',
                'title' => 'Local Homestays',
                'description' => 'Stay with local families in traditional farmhouses, sample authentic cuisine, and soak in hot stone baths.',
                'keywords' => 'Bhutan homestay, local farmhouse stay, rural Bhutan, Bhutanese food',
                'type' => 'category',
                'content_html' => '<h3>About Local Homestays</h3><p>Experience rural life firsthand. Stay with welcoming families in traditional farmhouses, participate in daily farming tasks, eat home-cooked Bhutanese food, and relax in hot stone baths.</p>',
                'content_text' => 'About Local Homestays: Authentic farmhouse stays and rural hospitality.'
            ],
            [
                'slug' => 'special',
                'title' => 'Special Interest Tours',
                'description' => 'Customized tours for photography, bird watching, river rafting, mountain biking, and luxury wellness.',
                'keywords' => 'bird watching Bhutan, photography tours, rafting, mountain biking Bhutan',
                'type' => 'category',
                'content_html' => '<h3>About Special Interest Tours</h3><p>Tailored tours designed for active or specialized travel, including bird watching in diverse biomes, rafting glacial rivers, mountain biking off-road, or photographic expeditions.</p>',
                'content_text' => 'About Special Interest: Bird watching, photography, rafting, and biking.'
            ]
        ];

        foreach ($categories as $cat) {
            Page::create($cat);
            $pageCount++;
        }

        // 6. Seed Dynamic Gallery Images
        $galleryImages = [
            ['url' => 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?q=80&w=1000', 'title' => 'Taktshang Goemba (Tiger’s Nest)', 'desc' => 'The iconic monastery perched on a cliffside in Paro.'],
            ['url' => 'https://images.unsplash.com/photo-1578593139888-39622e2047de?q=80&w=1000', 'title' => 'Punakha Dzong', 'desc' => 'The palace of great happiness, located at the confluence of two rivers.'],
            ['url' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?q=80&w=1000', 'title' => 'Himalayan Valleys', 'desc' => 'Scenic landscape of rural Bhutan nestled in mountains.'],
            ['url' => 'https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca?q=80&w=1000', 'title' => 'Masked Festival Dance', 'desc' => 'Traditional Cham dance performed at festival Tshechus.'],
            ['url' => 'https://images.unsplash.com/photo-1472214222541-d510753a8707?q=80&w=1000', 'title' => 'Phobjikha Valley', 'desc' => 'The winter nesting ground for endangered black-necked cranes.'],
            ['url' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?q=80&w=1000', 'title' => 'Trongsa Dzong', 'desc' => 'The massive fortress serving as the gateway to the east.'],
            ['url' => 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?q=80&w=1000', 'title' => 'Traditional Archery', 'desc' => 'Bhutanese archers playing the national sport of Bhutan.'],
            ['url' => 'https://images.unsplash.com/photo-1533105079780-92b9be482077?q=80&w=1000', 'title' => 'Dochula Chortens', 'desc' => 'The 108 stupas built on Dochula Pass.'],
        ];

        \App\Models\Gallery::truncate();
        foreach ($galleryImages as $img) {
            \App\Models\Gallery::create($img);
        }

        $this->command->info("Seeded {$pageCount} pages, {$tourCount} tours, and gallery images successfully.");
    }
}
