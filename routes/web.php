<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes Web de Brussels Top Team
|--------------------------------------------------------------------------
|
| Ce fichier contient toutes les routes principales
| du site public Brussels Top Team.
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
| La structure définitive du blog sera développée plus tard avec :
|
| - l'espace administrateur ;
| - la création d'articles ;
| - les commentaires ;
| - les likes ;
| - le partage sur les réseaux sociaux.
|
| Pour le moment, cette route affiche la page temporaire
| "Page en construction".
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
| Le contenu définitif sera développé lorsque les différents
| projets humanitaires de Brussels Top Team auront été définis
| avec la structure.
|
| Pour le moment, cette route affiche la page temporaire
| "Page en construction".
|
*/
Route::get('/humanitaire', function () {
    return view('humanitaire');
})->name('humanitaire');


/*
|--------------------------------------------------------------------------
| PAGE ABONNEMENTS / AFFILIATION
|--------------------------------------------------------------------------
|
| Cette page présente le fonctionnement de l'affiliation BTT :
|
| - 5 € par séance ;
| - paiement en espèces ;
| - possibilité de créditer plusieurs séances ;
| - crédit valable pendant un an ;
| - aucun abonnement mensuel obligatoire.
|
*/
Route::get('/abonnements', function () {
    return view('abonnements');
})->name('abonnements');


/*
|--------------------------------------------------------------------------
| PAGE CONTACT
|--------------------------------------------------------------------------
|
| Cette page permet aux visiteurs et, plus tard, aux adhérents
| de contacter l'administration de Brussels Top Team.
|
| Pour le moment :
|
| - le formulaire est affiché ;
| - aucun message n'est encore enregistré ;
| - aucun email n'est encore envoyé.
|
| Le système complet sera développé avec :
|
| - les comptes utilisateurs ;
| - les rôles adhérent / administrateur ;
| - la messagerie interne ;
| - la boîte de réception administrateur ;
| - la boîte de réception adhérent ;
| - les confirmations et notifications par email.
|
*/
Route::get('/contact', function () {
    return view('contact');
})->name('contact');