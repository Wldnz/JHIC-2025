<?php

namespace App\Console\Commands;

use App\Http\Middleware\isAdmin;
use App\Http\Middleware\isLogin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use Spatie\Sitemap\Sitemap;

class GenerateSitemap extends Command
{
	protected $signature = 'sitemap:generate';
	protected $description = 'Generate the sitemap.';

	public function handle()
	{
        $routes = Route::getRoutes()->getRoutes();
		$sitemap = Sitemap::create();

        foreach ($routes as $route) {
            if (
                !in_array('GET', $route->methods()) ||
                in_array(isLogin::class, $route->middleware()) ||
                in_array(isAdmin::class, $route->middleware()) ||
                !str_starts_with($route->getAction('controller'), 'App\Http\Controllers') ||
                str_contains($route->uri, '{')
            ) {
                continue;
            }
            $sitemap->add($route->uri);
        }

		$sitemap->writeToFile(public_path('sitemap.xml'));

		$this->info('Sitemap generated successfully!');
	}
}

