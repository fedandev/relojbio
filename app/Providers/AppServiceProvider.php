<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use DB;
use Log;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
     
    public function boot()
	{
		\App\Models\Menu::observe(\App\Observers\MenuObserver::class);

        //
         Schema::defaultStringLength(191);
         
        // \URL::forceScheme('https');

         
         app('view')->composer('layouts.app', function ($view) {
            $action = app('request')->route()->getAction();
    
            $controller = class_basename($action['controller']);
    
            list($controller, $action) = explode('@', $controller);
    
            $view->with(compact('controller', 'action'));
        });
        
        
        
        if (app()->environment() == 'local') {

            // DB::listen(function($query) {
            //     Log::info(
            //         $query->sql,
            //         $query->bindings,
            //         $query->time
            //     );
            // });
            
        }
        
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        
        require_once __DIR__ . '/../Http/helpers.php';
        
        
        if (app()->environment() == 'local' || app()->environment() == 'testing') {

            $this->app->register(\Summerblue\Generator\GeneratorsServiceProvider::class);

        }
    }
}
