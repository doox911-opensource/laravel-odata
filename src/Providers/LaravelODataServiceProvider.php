<?php

  namespace Doox911Opensource\LaravelOData\Providers;

  use Illuminate\Support\ServiceProvider;
  use Doox911Opensource\LaravelOData\Classes\OdataService;
  use Doox911Opensource\LaravelOData\Contracts\LaravelODataServiceContract;

  class LaravelODataServiceProvider extends ServiceProvider
  {

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
      $this->app->bind(LaravelODataServiceContract::class, OdataService::class);

      $this->mergeConfigFrom(__DIR__ . '/../../config/laravel-odata.php', 'laravel-odata');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

      /*
      |--------------------------------------------------------------------------
      | Публикация
      |--------------------------------------------------------------------------
      |
      | Конфигурация
      */
      $this->publishes([
        __DIR__ . '/../../config/laravel-odata.php' => config_path('laravel-odata.php'),
      ], 'doox911-opensource-odata-config');
    }
  }
