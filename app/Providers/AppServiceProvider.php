<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use League\Fractal\Manager;
use League\Fractal\Serializer\ArraySerializer;
use Dingo\Api\Transformer\Adapter\Fractal;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      $this->app['Dingo\Api\Transformer\Factory']->setAdapter(function ($app) {
        $manager = new Manager;
        $manager->setSerializer(new ArraySerializer);

        return new Fractal($manager, 'include', ',');
      });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
