<?php

namespace EPP\Providers;

use EPP\Domain\Model\Eyepiece\EyepieceRepository;
use EPP\Transformers\AuthJSONTransformer;
use EPP\Transformers\EyepieceJSONTransformer;
use EPP\Transformers\TelescopeJSONTransformer;
use Illuminate\Support\ServiceProvider;
use Auth;
use View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        View::composer('*', function ($view) {

            $eyepieceRepository = app(EyepieceRepository::class);

            $eyepieceTransformer = app(EyepieceJSONTransformer::class);
            $telescopeTransformer = app(TelescopeJSONTransformer::class);
            $authTransformer = app(AuthJSONTransformer::class);

            $eyepieces = $eyepieceRepository->getAll();
            $telescopes = Auth::check() ? Auth::user()->getTelescopes() : collect([]);

            $view->with([
                'auth' => $authTransformer->toJson(Auth::user()),
                'eyepieces' =>  $eyepieceTransformer->toJson($eyepieces),
                'telescopes_json' => $telescopeTransformer->toJson($telescopes)
            ]);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
