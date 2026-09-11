<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes Web de Brussels Top Team
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| PAGE D'ACCUEIL
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});


/*
|--------------------------------------------------------------------------
| PAGE DISCIPLINES
|--------------------------------------------------------------------------
*/
Route::get('/disciplines', function () {
    return view('disciplines');
})->name('disciplines');


/*
|--------------------------------------------------------------------------
| PAGE COACHS
|--------------------------------------------------------------------------
*/
Route::get('/coachs', function () {
    return view('coachs');
})->name('coachs');


/*
|--------------------------------------------------------------------------
| PAGE BLOG
|--------------------------------------------------------------------------
*/
Route::get('/blog', function () {
    return view('blog');
})->name('blog');


/*
|--------------------------------------------------------------------------
| PAGE HUMANITAIRE
|--------------------------------------------------------------------------
*/
Route::get('/humanitaire', function () {
    return view('humanitaire');
})->name('humanitaire');


/*
|--------------------------------------------------------------------------
| PAGE ABONNEMENTS
|--------------------------------------------------------------------------
*/
Route::get('/abonnements', function () {
    return view('abonnements');
})->name('abonnements');


/*
|--------------------------------------------------------------------------
| PAGE CONTACT
|--------------------------------------------------------------------------
*/
Route::get('/contact', function () {
    return view('contact');
})->name('contact');


/*
|--------------------------------------------------------------------------
| INSCRIPTION
|--------------------------------------------------------------------------
*/
Route::get(
    '/inscription',
    [AuthController::class, 'showRegister']
)->name('register');


Route::post(
    '/inscription',
    [AuthController::class, 'register']
)->name('register.store');


/*
|--------------------------------------------------------------------------
| CONFIRMATION D'INSCRIPTION
|--------------------------------------------------------------------------
*/
Route::get(
    '/inscription/confirmation',
    [AuthController::class, 'registerSuccess']
)
    ->middleware('auth')
    ->name('register.success');


/*
|--------------------------------------------------------------------------
| CONNEXION
|--------------------------------------------------------------------------
*/
Route::get(
    '/connexion',
    [AuthController::class, 'showLogin']
)->name('login');


Route::post(
    '/connexion',
    [AuthController::class, 'login']
)->name('login.store');


/*
|--------------------------------------------------------------------------
| DÉCONNEXION
|--------------------------------------------------------------------------
*/
Route::post(
    '/deconnexion',
    [AuthController::class, 'logout']
)
    ->middleware('auth')
    ->name('logout');