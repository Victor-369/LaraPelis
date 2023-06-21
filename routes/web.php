<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeliController;

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

Route::get('/', function () {
    return view('welcome');
});

// CRUD de Pelis
Route::resource('pelis', PeliController::class);

// Ruta para la confirmación de eliminación
Route::get('pelis/{peli}/delete', [PeliController::class, 'delete'])->name('pelis.delete');
