<?php

use App\Http\Controllers\Api\Admin\AppointmentController;
use App\Http\Controllers\Api\Admin\BusController;
use App\Http\Controllers\Api\Admin\TicketController;
use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Api\Auth\AuthenticationController;
use App\Http\Controllers\Api\User\BookingController;
use App\Http\Controllers\Api\User\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::controller(AuthenticationController::class)->group(function(){
    Route::post('register','register');
    Route::post('login','login');
    Route::post('logout','logout');
    Route::get('userProfile','userProfile');
});

Route::controller(UserController::class)->group(function(){
    Route::get('admin/manageUser','index');
    Route::post('admin/addUser','store');
    Route::get('admin/showUser/{id}','show');
    Route::post('admin/updateUser/{id}','update');
    Route::post('admin/deleteUser/{id}','destroy');
})->middleware('admin');

Route::controller(AppointmentController::class)->group(function(){
    Route::get('/admin/manageAppointment','index');
    Route::post('/admin/addAppointment','store');
    Route::get('/admin/showAppointment/{id}','show');
    Route::post('/admin/updateAppointment/{id}','update');
    Route::post('/admin/deleteAppointment/{id}','destroy');
})->middleware('admin');


Route::controller(BusController::class)->group(function(){
    Route::get('/admin/manageBus','index');
    Route::post('/admin/addBus','store');
    Route::get('/admin/showBus/{id}','show');
    Route::post('/admin/updateBus/{id}','update');
    Route::post('/admin/deleteBus/{id}','destroy');
})->middleware('admin');

Route::controller(TicketController::class)->group(function(){
    Route::get('/admin/manageTicket','index');
    Route::get('/admin/showInactiveTicket','showInactiveTicket');
    Route::post('/admin/activeAllTickets','activeAllTickets');
    Route::post('admin/activeTicket/{id}','activeTicket');
    Route::post('admin/addTicket','store');
    Route::get('/admin/showTicket/{id}','show');
    Route::post('/admin/updateTicket/{id}','update');
    Route::post('/admin/deleteTicket/{id}','destroy');
    
})->middleware('admin');

Route::controller(ProfileController::class)->group(function(){
    Route::get('/profile','show');
    Route::post('/updateProfile','update');
})->middleware('auth:sunctum');

Route::controller(BookingController::class)->group(function(){
    Route::get('index','index');
    Route::get('showAppointment/{id}','show');
    Route::post('bookTicket','bookTicket');
    Route::Post('cancelTicket','cancelTicket');
})->middleware('auth:sanctum');