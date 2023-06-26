<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeliController;
use App\Http\Controllers\WelcomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Rompe el MVC
// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', [WelcomeController::class, 'index'])->name('portada');

// CRUD de Pelis
Route::resource('pelis', PeliController::class);

// Ruta para la confirmación de eliminación
Route::get('pelis/{peli}/delete', [PeliController::class, 'delete'])->name('pelis.delete');
