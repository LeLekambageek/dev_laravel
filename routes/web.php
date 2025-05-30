<?php

use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\EvaluationController;

Route::get('/', function () {
    return view('welcome');
});

//Routeq pour les etudiants et les evaluations
Route::resource('etudiant', EtudiantController::class);
Route::resource('evaluation', EvaluationController::class);

//routes supplementaires pour les notes
Route::get('/evaluations/{evaluation}/grade',[EvaluationController::class, 'grade'])->name('evaluation.grade');
Route::post('/evaluations/{evaluation}/update-grades', [EvaluationController::class, 'updateGrades'])->name('evaluations.update-grades');