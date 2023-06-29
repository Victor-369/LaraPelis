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


// Para buscar pelis por título y/o director
// Vigilar con solapamiento de rutas
Route::get('/pelis/search', [PeliController::class, 'search'])->name('pelis.search');

Route::get('/', [WelcomeController::class, 'index'])->name('portada');

// CRUD de Pelis
// Route::resource('pelis', PeliController::class);

// Se agrega el middleware "adulto" para editar, crear y borrar. De esta manera no podrá modificar datos.
Route::get('/pelis', [PeliController::class, 'index'])
    ->name('pelis.index');

Route::get('/pelis/create', [PeliController::class, 'create'])
    ->name('pelis.create')
    ->middleware('adulto');

Route::get('/pelis/{peli}', [PeliController::class, 'show'])
    ->name('pelis.show');

Route::post('/pelis', [PeliController::class, 'store'])
    ->name('pelis.store');

Route::get('/pelis/{peli}/edit', [PeliController::class, 'edit'])
    ->name('pelis.edit');

Route::match(['PUT', 'PATCH'], '/pelis/{peli}', [PeliController::class, 'update'])
    ->name('pelis.update')
    ->middleware('prohibido');

Route::delete('/pelis/{peli}', [PeliController::class, 'destroy'])
    ->name('pelis.destroy')
    ->middleware('signed');

// Ruta para la confirmación de eliminación
Route::get('pelis/{peli}/delete', [PeliController::class, 'delete'])
    ->name('pelis.delete');



// INICIO ZONA DE PRUEBAS
// Route::get('test', function() {
//     return "Estás haciendo la prueba por GET.";
// });

// Route::post('test', function() {
//     return "Estás haciendo la prueba por POST.";
// });

// Route::put('test', function() {
//     return "Estás haciendo la prueba por PUT.";
// });

// Route::delete('test', function() {
//     return "Estás haciendo la prueba por DELETE.";
// });
// FIN ZONA DE PRUEBAS