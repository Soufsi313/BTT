<?php

use App\Http\Controllers\AdminMemberController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MemberCourseController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| ROUTES WEB - BRUSSELS TOP TEAM
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


/*
|--------------------------------------------------------------------------
| ESPACE ADHÉRENT
|--------------------------------------------------------------------------
*/
Route::get('/mon-compte', function () {

    return view('member.dashboard');

})
    ->middleware('auth')
    ->name('member.dashboard');


/*
|--------------------------------------------------------------------------
| PROFIL ADHÉRENT
|--------------------------------------------------------------------------
*/
Route::get(
    '/mon-compte/profil',
    [AuthController::class, 'showProfile']
)
    ->middleware('auth')
    ->name('member.profile');


Route::put(
    '/mon-compte/profil',
    [AuthController::class, 'updateProfile']
)
    ->middleware('auth')
    ->name('member.profile.update');


/*
|--------------------------------------------------------------------------
| MODIFICATION DE L'ADRESSE EMAIL
|--------------------------------------------------------------------------
*/
Route::get(
    '/mon-compte/email',
    [AuthController::class, 'showEmail']
)
    ->middleware('auth')
    ->name('member.email');


Route::put(
    '/mon-compte/email',
    [AuthController::class, 'updateEmail']
)
    ->middleware('auth')
    ->name('member.email.update');


/*
|--------------------------------------------------------------------------
| MODIFICATION DU MOT DE PASSE
|--------------------------------------------------------------------------
*/
Route::get(
    '/mon-compte/mot-de-passe',
    [AuthController::class, 'showPassword']
)
    ->middleware('auth')
    ->name('member.password');


Route::put(
    '/mon-compte/mot-de-passe',
    [AuthController::class, 'updatePassword']
)
    ->middleware('auth')
    ->name('member.password.update');


/*
|--------------------------------------------------------------------------
| CALENDRIER PRIVÉ DES ENTRAÎNEMENTS
|--------------------------------------------------------------------------
*/
Route::get(
    '/mon-compte/calendrier',
    [MemberCourseController::class, 'index']
)
    ->middleware('auth')
    ->name('member.courses');


/*
|--------------------------------------------------------------------------
| SUPPRESSION DU COMPTE
|--------------------------------------------------------------------------
*/
Route::get(
    '/mon-compte/supprimer',
    [AuthController::class, 'showDeleteAccount']
)
    ->middleware('auth')
    ->name('member.delete-account');


Route::delete(
    '/mon-compte/supprimer',
    [AuthController::class, 'deleteAccount']
)
    ->middleware('auth')
    ->name('member.delete-account.destroy');


/*
|--------------------------------------------------------------------------
| CONFIRMATION DE SUPPRESSION DU COMPTE
|--------------------------------------------------------------------------
*/
Route::get(
    '/compte-supprime',
    [AuthController::class, 'accountDeleted']
)->name('account.deleted');


/*
|--------------------------------------------------------------------------
| ADMINISTRATION
|--------------------------------------------------------------------------
*/
Route::middleware([
    'auth',
    'admin',
])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {


        /*
        |--------------------------------------------------------------------------
        | TABLEAU DE BORD
        |--------------------------------------------------------------------------
        */
        Route::get('/', function () {

            return view('admin.dashboard');

        })->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | LISTE DES ADHÉRENTS
        |--------------------------------------------------------------------------
        */
        Route::get(
            '/adherents',
            [AdminMemberController::class, 'index']
        )->name('members.index');


        /*
        |--------------------------------------------------------------------------
        | RÉACTIVER UN ADHÉRENT
        |--------------------------------------------------------------------------
        */
        Route::patch(
            '/adherents/{id}/reactiver',
            [AdminMemberController::class, 'restore']
        )->name('members.restore');


        /*
        |--------------------------------------------------------------------------
        | PROMOUVOIR UN ADHÉRENT
        |--------------------------------------------------------------------------
        */
        Route::patch(
            '/adherents/{id}/promouvoir-admin',
            [AdminMemberController::class, 'promoteToAdmin']
        )->name('members.promote');


        /*
        |--------------------------------------------------------------------------
        | LISTE DES ADMINISTRATEURS
        |--------------------------------------------------------------------------
        |
        | La vérification Super Admin est également effectuée dans
        | le contrôleur.
        |
        */
        Route::get(
            '/administrateurs',
            [AdminMemberController::class, 'administrators']
        )->name('administrators.index');


        /*
        |--------------------------------------------------------------------------
        | RÉTROGRADER UN ADMINISTRATEUR
        |--------------------------------------------------------------------------
        */
        Route::patch(
            '/administrateurs/{id}/retrograder',
            [AdminMemberController::class, 'demoteAdmin']
        )->name('administrators.demote');

    });