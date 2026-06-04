<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer('layouts.app', function ($view) {
            // Fetch all page destinations
            $destinations = \App\Models\Page::where('type', 'destination')->orderBy('title')->get();
            
            // Group destinations: Bhutan valleys vs foreign
            $bhutanDest = $destinations->filter(function($d) {
                return !in_array($d->slug, ['nepal', 'tibet']);
            });
            $nepalDest = $destinations->firstWhere('slug', 'nepal');
            $tibetDest = $destinations->firstWhere('slug', 'tibet');
            
            // Fetch categories
            $categories = \App\Models\Page::where('type', 'category')->orderBy('title')->get();
            
            // If no categories in DB (prevent crashes), define default ones
            if ($categories->isEmpty()) {
                $categories = collect([
                    (object)['slug' => 'cultural', 'title' => 'Cultural Journeys'],
                    (object)['slug' => 'trekking', 'title' => 'Trekking Adventures'],
                    (object)['slug' => 'festival', 'title' => 'Festival Packages'],
                    (object)['slug' => 'hiking', 'title' => 'Day Hikes & Walking'],
                    (object)['slug' => 'homestay', 'title' => 'Local Homestays'],
                    (object)['slug' => 'special', 'title' => 'Special Interest Tours'],
                ]);
            }
            
            $view->with(compact('destinations', 'bhutanDest', 'nepalDest', 'tibetDest', 'categories'));
        });
    }
}
