<?php

namespace EPP\Providers;

use EPP\Domain\Model\Eyepiece\EyepieceRepository;
use EPP\EyepieceSet\EyepieceSetRepository;
use EPP\Transformers\AuthJSONTransformer;
use EPP\Transformers\EyepieceSetJSONTransformer;
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
            $telescopeTransformer = app(TelescopeJSONTransformer::class);
            $authTransformer = app(AuthJSONTransformer::class);

            $eyepieces = $eyepieceRepository->getJSONList();
            $telescopes = Auth::check() ? Auth::user()->getTelescopes() : collect([]);

            $view->with([
                'auth' => $authTransformer->toJson(Auth::user()),
                'eyepieces' =>  $eyepieces,
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
