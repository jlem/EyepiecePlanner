<?php

namespace EPP\Providers;

use EPP\Eyepiece\EyepieceRepository;
use EPP\EyepieceSet\EyepieceSetRepository;
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
            $eyepieces = $eyepieceRepository->getJSONList();
            $telescopes = Auth::check() ? Auth::user()->getTelescopes() : collect([]);
            $pupil_size = Auth::check() ? Auth::user()->getPupilSize() : 7;

            $view->with([
                'eyepieces' =>  $eyepieces,
                'telescopes_json' => $telescopeTransformer->toJson($telescopes),
                'pupil_size' => $pupil_size
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
