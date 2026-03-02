<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\ImageController;

Route::get('/', [PersonController::class, 'view'])->name('people.view');
Route::post('/people/store', [PersonController::class, 'store'])->name('people.store');
Route::put('/people/{id}', [PersonController::class, 'update'])->name('people.update');
Route::delete('/people/{id}', [PersonController::class, 'destroy'])->name('people.destroy');

Route::get('/images', [ImageController::class, 'index']);
Route::post('/upload-image', [ImageController::class, 'upload']);
