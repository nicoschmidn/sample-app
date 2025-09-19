<?php

use App\Http\Controllers\SampleController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SampleController::class, 'index'])->name('samples.index');
Route::post('/upload', [SampleController::class, 'upload'])->name('samples.upload');
