<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DartsController; 
use App\Http\Controllers\TestController; 

Route::get('/test', function () {
  return view('home');
});

Route::post('/play', [DartsController::class, 'playMatch']);

Route::get('/', [TestController::class, 'test']);
Route::get('/prepare-match/{game}', [TestController::class, 'prepareMatch']);
Route::post('/prepare-match/{game}', [TestController::class, 'startMatch']);

Route::get('/save-stats', [TestController::class, 'saveStats']);
Route::get('/history', [TestController::class, 'history']);

Route::get('/delete-match/{id}', [TestController::class, 'deleteMatch']);
Route::get('/show-match/{id}', [TestController::class, 'showMatch']);

Route::get('/users', [TestController::class, 'showUsers']);
Route::get('/user/{id}', [TestController::class, 'showUser']);
Route::get('edit_player/{id}', [TestController::class, 'editUser']);
Route::post('edit_player/{id}', [TestController::class, 'editUser_POST']);
Route::get('delete/{id}', [TestController::class, 'deleteUser']);

Route::get('/add_user', [TestController::class, 'addUser']);
Route::post('/add_user', [TestController::class, 'addUser_POST']);


