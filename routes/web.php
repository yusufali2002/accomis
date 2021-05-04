<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

Auth::routes();

//Dashboard routes
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


//Cbo get routes
Route::get('/cbo', [App\Http\Controllers\CboController::class, 'cbo_index'])->name('cbo');
Route::get('/cbo_monthly', [App\Http\Controllers\CboController::class, 'cbo_monthly'])->name('cbo.monthly');
Route::get('/add_cbo/', [App\Http\Controllers\CboController::class, 'add_cbo_view'])->name('cbo.add.view');

//Cbo post routes
Route::post('/cbo', [App\Http\Controllers\CboController::class, 'add_cbo'])->name('cbo.add');
Route::post('/cbo/cat_add', [App\Http\Controllers\CatController::class, 'add_cat'])->name('cat.add');
Route::post('/cbo/fetch', [App\Http\Controllers\CboController::class, 'fetch'])->name('lga.fetch');
Route::post('/cat/fetch', [App\Http\Controllers\CboController::class, 'cbo_fetch'])->name('cbo.fetch');
Route::post('/cbo_monthly/add', [App\Http\Controllers\CboController::class, 'add_cbo_monthly'])->name('cbo.add_monthly');

//Spo get routes
Route::get('/spo_add', [App\Http\Controllers\SpoController::class, 'spo_index'])->name('spo.monthly');
Route::get('/spo_monthly/', [App\Http\Controllers\SpoController::class, 'spo_monthly'])->name('spo_add_monthly');

//Spo post routes
Route::post('/spo/add', [App\Http\Controllers\SpoController::class, 'add_spo'])->name('spo.add');
Route::post('/spo_monthly/add', [App\Http\Controllers\SpoController::class, 'add_spomonthly'])->name('spo.add_monthly');

//Remidial get routes
Route::get('/remidialfeedback', [App\Http\Controllers\RemidialController::class, 'remidial'])->name('remidial');

//Remidial post routes
Route::post('/remidialfeedback', [App\Http\Controllers\RemidialController::class, 'add_remidial'])->name('add_remidial');

//Health-facilities get routes
Route::get('/healthfacilities', [App\Http\Controllers\HealthFacilitiesController::class, 'health_facility'])->name('health_facility');

//Health-facilities post routes
Route::post('/healthfacilities/', [App\Http\Controllers\HealthFacilitiesController::class, 'add_health_facility'])->name('add_health_facility');
Route::post('/healthfacilities/fetch', [App\Http\Controllers\HealthFacilitiesController::class, 'fetch'])->name('healthfacilities.lga.fetch');
Route::post('/healthfacilities/cbo/fetch', [App\Http\Controllers\HealthFacilitiesController::class, 'cbo_fetch'])->name('healthfacilities.cbo.fetch');

//Remidial get routes
Route::get('/clientexit', [App\Http\Controllers\ClientExitController::class, 'client_exit'])->name('client.exit');

//Remidial post routes
Route::post('/clientexit', [App\Http\Controllers\ClientExitController::class, 'client_exit_add'])->name('client_exit.add');
