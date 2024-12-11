<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/fibonacci', function () {
    return view('fibonacci');
});

Route::get('/fibonacci-no-worker', function () {
    return view('fibonacci-not-user-worker');
});
