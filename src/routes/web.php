<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProducerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\GenreController;

Route::get('/', [HomeController::class,'index']);

//Producers
Route::get('/producers', [ProducerController::class,'list']);
Route::get('/producers/create', [ProducerController::class,'create']);
Route::post('/producers/put', [ProducerController::class,'put']);
Route::get('/producers/update/{producer}', [ProducerController::class,'update']);
Route::post('/producers/patch/{producer}', [ProducerController::class,'patch']);
Route::post('/producers/delete/{producer}', [ProducerController::class,'delete']);

//Authentification
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/auth', [AuthController::class, 'authenticate']);
Route::get('/logout', [AuthController::class, 'logout']);

//Films
Route::get('/films', [FilmController::class,'list']);
Route::get('/films/create', [FilmController::class,'create']);
Route::post('/films/put', [FilmController::class,'put']);
Route::get('/films/update/{film}', [FilmController::class,'update']);
Route::post('/films/patch/{film}', [FilmController::class,'patch']);
Route::post('/films/delete/{film}', [FilmController::class,'delete']);

// Data/API
Route::get('/data/get-top-films', [DataController::class, 'getTopFilms']);
Route::get('/data/get-film/{film}', [DataController::class, 'getFilm']);
Route::get('/data/get-related-films/{film}', [DataController::class, 'getRelatedFilms']);

// Genres
Route::get('/genres', [GenreController::class, 'list']);
Route::get('/genres/create', [GenreController::class, 'create']);
Route::post('/genres/put', [GenreController::class, 'put']);
Route::get('/genres/update/{genre}', [GenreController::class, 'update']);
Route::post('/genres/patch/{genre}', [GenreController::class, 'patch']);
Route::post('/genres/delete/{genre}', [GenreController::class, 'delete']);
