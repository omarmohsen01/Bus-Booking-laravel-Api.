<?php

namespace App\Providers;

use App\Http\Controllers\Api\User\BookingController;
use App\Http\Controllers\Interface\AppointmentServiceInterface;
use App\Http\Controllers\Interface\BookingServiceInterface;
use App\Http\Controllers\Interface\BusServiceInterface;
use App\Http\Controllers\Interface\TicketServiceInterface;
use App\Http\Controllers\Interface\UserServiceInterface;
use App\Http\Controllers\Services\AppointmentServices;
use App\Http\Controllers\Services\BookingServices;
use App\Http\Controllers\Services\BusServices;
use App\Http\Controllers\Services\TicketServices;
use App\Http\Controllers\Services\UserServices;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserServiceInterface::class,UserServices::class);
        $this->app->bind(AppointmentServiceInterface::class,AppointmentServices::class);
        $this->app->bind(BusServiceInterface::class,BusServices::class);
        $this->app->bind(TicketServiceInterface::class,TicketServices::class);
        $this->app->bind(BookingServiceInterface::class,BookingServices::class);


    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}