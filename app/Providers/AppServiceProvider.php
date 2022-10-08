<?php

namespace App\Providers;

use App\Models\Employee;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view) {

            if (Auth::user()) {
                if (Auth::user()->type != 'super admin') {
                    $employee = Employee::where('user_id', Auth::user()->id)->get('id');
                    $check = count($employee) != 0;
                    if ($check) {
                        $notification = Notification::where(['employee_id' => $employee->first()->id, 'is_read' => false])->orderBy('created_at', 'desc')->get();
                    }

                    $view->with([
                        'notifEmployee' => $check ? $notification : [],
                    ]);
                }
            }
        });

        if (config('app.env') === 'production' | config('app.env') === 'development') {
            URL::forceScheme('https');
        }
    }
}

