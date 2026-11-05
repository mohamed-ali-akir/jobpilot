<?php

namespace App\Providers;

use App\Enums\Role;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

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
        $this->configureDefaults();

        // Gates : autorisations générales, qui ne portent pas sur un modèle précis
        Gate::define('gerer-utilisateurs', fn (User $user) => $user->isAdmin());
        Gate::define('gerer-donnees', fn (User $user) => $user->hasRole(Role::Editeur, Role::Admin));

        // Erreur explicite si on oublie un with() (problème N+1), sauf en production
        Model::preventLazyLoading(! $this->app->isProduction());
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }
}
