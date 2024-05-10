<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProducerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FilmController;

Route::get('/', [HomeController::class,'index']);

Route::get('/producers', [ProducerController::class,'list']);
Route::get('/producers/create', [ProducerController::class,'create']);
Route::post('/producers/put', [ProducerController::class,'put']);
Route::get('/producers/update/{producer}', [ProducerController::class,'update']);
Route::post('/producers/patch/{producer}', [ProducerController::class,'patch']);
Route::post('/producers/delete/{producer}', [ProducerController::class,'delete']);

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/auth', [AuthController::class, 'authenticate']);
Route::get('/logout', [AuthController::class, 'logout']);


Route::get('/films', [FilmController::class,'list']);
Route::get('/films/create', [FilmController::class,'create']);
Route::post('/films/put', [FilmController::class,'put']);
Route::get('/films/update/{film}', [FilmController::class,'update']);
Route::post('/films/patch/{film}', [FilmController::class,'patch']);
Route::post('/films/delete/{film}', [FilmController::class,'delete']);
