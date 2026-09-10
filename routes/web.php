<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes Web de Brussels Top Team
|--------------------------------------------------------------------------
|
| Ce fichier contient les routes principales du site public BTT.
| Chaque route associe une URL à une vue Blade.
|
*/


/*
|--------------------------------------------------------------------------
| PAGE D'ACCUEIL
|--------------------------------------------------------------------------
|
| URL :
| http://127.0.0.1:8000/
|
*/
Route::get('/', function () {
    return view('welcome');
});


/*
|--------------------------------------------------------------------------
| PAGE DISCIPLINES
|--------------------------------------------------------------------------
|
| URL :
| http://127.0.0.1:8000/disciplines
|
| Cette page présente les différentes disciplines proposées
| par Brussels Top Team.
|
*/
Route::get('/disciplines', function () {
    return view('disciplines');
})->name('disciplines');