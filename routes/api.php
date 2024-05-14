<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::resource('users', 'App\Http\Controllers\UserController');
    Route::resource('healthcare-professionals', 'App\Http\Controllers\HealthcareProfessionalController');
    Route::resource('appointments', 'App\Http\Controllers\AppointmentController');
    Route::post('/auth/logout', 'App\Http\Controllers\AuthController@logout');
    Route::get('/auth/user', 'App\Http\Controllers\AuthController@me');
    Route::put('/cancel-appointments-user/{appointmentId}', 'App\Http\Controllers\AuthController@cancelAppointment');
    Route::get('/view-all-appointments-user', 'App\Http\Controllers\AuthController@viewAllAppointments');
});

Route::post('/auth/register', 'App\Http\Controllers\AuthController@register');
Route::post('/auth/login', 'App\Http\Controllers\AuthController@login');
