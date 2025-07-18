<?php

namespace App\Providers;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Faq;
use App\Models\Page;
use App\Models\Portfolio;
use App\Models\Slider;
use App\Models\Service;
use App\Policies\BlogCategoryPolicy;
use App\Policies\BlogPolicy;
use App\Policies\PagePolicy;
use App\Policies\PortfolioPolicy;
use App\Policies\SliderPolicy;
use App\Policies\FaqPolicy;
use App\Policies\ServicePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Page::class => PagePolicy::class,
        Slider::class => SliderPolicy::class,
        Portfolio::class => PortfolioPolicy::class,
        Blog::class => BlogPolicy::class,
        BlogCategory::class => BlogCategoryPolicy::class,
        Faq::class => FaqPolicy::class,
        Service::class => ServicePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
