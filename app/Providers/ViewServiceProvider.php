<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // view()->composer(['layouts.app'],function($view){
        //     $view->with([
        //         'total'=>30,
        //         'todoCount'=>10,
        //         'doneCount'=>20
        //     ]);    
        // });
        view()->composer(['layouts.app'],'App\Http\ViewComposer\TaskCountComposer@compose');
    }
}
