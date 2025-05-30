<?php

use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\Route;


Route::get('/', function () {
    return view('welcome');
});


Route::middle