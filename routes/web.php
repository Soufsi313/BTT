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
|
| La structure définitive du blog sera développée plus tard avec
| l'espace d'administration, la gestion des articles, commentaires,
| likes et autres fonctionnalités associées.
|
| Pour le moment, cette route affiche une page "En construction".
|
*/
Route::get('/blog', function () {
    return view('blog');
})->name('blog');


/*
|--------------------------------------------------------------------------
| PAGE HUMANITAIRE
|--------------------------------------------------------------------------
|
| Le contenu définitif sera développé lorsque les différents projets
| humanitaires de Brussels Top Team auront été définis avec la structure.
|
| Pour le moment, cette route affiche une page "En construction".
|
*/
Route::get('/humanitaire', function () {
    return view('humanitaire');
})->name('humanitaire');