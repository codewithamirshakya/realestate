<?php

namespace App\Providers;

use App\Support\Cms;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(Cms::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->make(Cms::class)->applyToConfig();

        // @cms('key') prints a piece of editable copy where a wrapping tag is
        // not possible (attributes, mailto links, the <title> tag, ...).
        Blade::directive('cms', fn (string $expression) => "<?php echo e(app(\App\Support\Cms::class)->value({$expression})); ?>");
    }
}
