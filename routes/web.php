<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Auth::routes(['register' => false, 'verify' =>  false]);
Route::get('/', 'HomeController@index')->name('home');
Route::resource('company', 'CompanyController');
Route::resource('user', 'UserController');
Route::resource('truck', 'TruckController');
Route::resource('truckdriver', 'TruckDriverController');
Route::resource('driver', 'DriverController');
Route::resource('drivertype', 'DriverTypeController');
Route::resource('order', 'OrderController');
Route::resource('status', 'StatusController');
