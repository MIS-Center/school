<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\HallController ;
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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::group(['middleware' => 'auth'], function()
{
Route::resource('halls', HallController::class);
});
// Route::middleware(['role:admin|teacher', 'verified'])->get('/halls', function () {
//     return Inertia::render('halls');
// })->name('halls');

    // Route::resource('/auth', 'Laratrust\Http\Controllers\RolesAssignmentController', ['as' => 'laratrust','middleware' => ['role:admin']])
    // ->only(['index', 'edit', 'update']) ;


















    Route::group([ 'prefix' => 'auth','middleware' => ['role:admin']], function () {


    Route::resource('permissions', 'Laratrust\Http\Controllers\PermissionsController', ['as' => 'laratrust' ])
    ->only(['index', 'edit', 'update']);

Route::resource('roles', 'Laratrust\Http\Controllers\RolesController', ['as' => 'laratrust' ]);

Route::resource('roles-assignment', 'Laratrust\Http\Controllers\RolesAssignmentController', ['as' => 'laratrust' ])
    ->only(['index', 'edit', 'update']);

});




//Route::get('auth', HallController::class);
