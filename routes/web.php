<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeliController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

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

// eliminación definitiva de la película
// va por DELETE por:
// - coherencia con las operaciones delete en Laravel
// - evita los borrados accidentales
Route::delete('/pelis/purge', [PeliController::class, 'purge'])
    ->name('pelis.purge');

// restauración de la película
Route::get('/pelis/{peli}/restore', [PeliController::class, 'restore'])
    ->name('pelis.restore');


// ruta de usuarios bloqueados
Route::get('/bloqueado', [UserController::class, 'blocked'])->name('user.blocked');

// Para buscar pelis por título y/o director
// Vigilar con solapamiento de rutas
Route::get('/pelis/search', [PeliController::class, 'search'])->name('pelis.search');

Route::get('/', [WelcomeController::class, 'index'])->name('portada');

// CRUD de Pelis
// Route::resource('pelis', PeliController::class);

// Se agrega el middleware "adulto" para evita editar, crear y borrar. De esta manera no podrá modificar datos un menor de edad.
Route::get('/pelis', [PeliController::class, 'index'])
    ->name('pelis.index');

Route::get('/pelis/create', [PeliController::class, 'create'])
    ->name('pelis.create');
    //->middleware('auth', 'throttle:3,1') // crear tres películas por minuto

Route::get('/pelis/{peli}', [PeliController::class, 'show'])
    ->name('pelis.show');

Route::post('/pelis', [PeliController::class, 'store'])
    ->name('pelis.store');

Route::get('/pelis/{peli}/edit', [PeliController::class, 'edit'])
    ->name('pelis.edit')
    /*->middleware('prohibido')*/;

Route::match(['PUT', 'PATCH'], '/pelis/{peli}', [PeliController::class, 'update'])
    ->name('pelis.update')
    /*->middleware('prohibido')*/;


Route::delete('/pelis/{peli}', [PeliController::class, 'destroy'])
    ->name('pelis.destroy')
    ->middleware('signed');

// Ruta para la confirmación de eliminación
Route::get('pelis/{peli}/delete', [PeliController::class, 'delete'])
    ->name('pelis.delete');

Route::get('/contacto', [ContactoController::class, 'index'])
    ->name('contacto');

Route::post('/contacto', [ContactoController::class, 'send'])
    ->name('contacto.email');

// group de rutas para el administrador. Llevan el prefijo "admin"
Route::prefix('admin')->middleware('auth', 'is_admin')->group(function() {

    // ver las películas eliminadas (/admin/deletedpelis)
    Route::get('deletedpelis', [AdminController::class, 'deletedPelis'])
        ->name('admin.deleted.pelis');
    
    // detalle de un usuario
    Route::get('usuario/{user}/detalles', [AdminController::class, 'userShow'])
        ->name('admin.user.show');
    
    // listado de usuarios
    Route::get('usuarios', [AdminController::class, 'userList'])
        ->name('admin.users');
    
    // búsqueda de usuarios
    Route::get('usuario/buscar', [AdminController::class, 'userSearch'])
        ->name('admin.users.search');
    
    // añade rol
    Route::post('role', [AdminController::class, 'setRole'])
        ->name('admin.user.setRole');
    
    // Elimina rol
    Route::delete('role', [AdminController::class, 'removeRole'])
        ->name('admin.user.removeRole');
});



// Autenticación
Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

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
