<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
<<<<<<< HEAD
=======
use Illuminate\Support\Facades\Gate;
use App\Models\Document;
use App\Policies\DocumentPolicy;
use App\Models\Reclamation;
use App\Policies\ReclamationPolicy;
>>>>>>> ba423d4ca8b0b93271da5dafa3e306809b3ffcde

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
<<<<<<< HEAD
        //
=======
        Gate::policy(Document::class, DocumentPolicy::class);
        Gate::policy(Reclamation::class, ReclamationPolicy::class);
>>>>>>> ba423d4ca8b0b93271da5dafa3e306809b3ffcde
    }
}
