<?php

use App\Http\Controllers\AdminCourseController;
use App\Http\Controllers\AdminMemberController;
use App\Http\Controllers\AdminMessageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\MemberCourseController;
use App\Http\Controllers\MemberMessageController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| PAGES PUBLIQUES
|--------------------------------------------------------------------------
|
| Ces pages sont accessibles à tous les visiteurs,
| qu'ils soient connectés ou non.
|
*/

Route::get(
    '/',
    function () {
        return view('welcome');
    }
)->name('home');


Route::get(
    '/disciplines',
    function () {
        return view('disciplines');
    }
)->name('disciplines');


Route::get(
    '/coachs',
    function () {
        return view('coachs');
    }
)->name('coachs');


Route::get(
    '/blog',
    function () {
        return view('blog');
    }
)->name('blog');


Route::get(
    '/humanitaire',
    function () {
        return view('humanitaire');
    }
)->name('humanitaire');


Route::get(
    '/abonnements',
    function () {
        return view('abonnements');
    }
)->name('abonnements');


/*
|--------------------------------------------------------------------------
| CONTACT PUBLIC
|--------------------------------------------------------------------------
|
| La page Contact peut être utilisée :
|
| - par un visiteur non connecté ;
| - par un adhérent connecté.
|
| Si l'utilisateur est connecté, ContactController utilise
| automatiquement les informations de son compte.
|
*/

Route::get(
    '/contact',
    function () {
        return view('contact');
    }
)->name('contact');


Route::post(
    '/contact',
    [
        ContactController::class,
        'store',
    ]
)->name('contact.store');


/*
|--------------------------------------------------------------------------
| ROUTES RÉSERVÉES AUX VISITEURS NON CONNECTÉS
|--------------------------------------------------------------------------
|
| Les pages d'inscription et de connexion ne doivent être accessibles
| qu'aux visiteurs qui ne sont pas déjà connectés.
|
*/

Route::middleware('guest')->group(
    function () {

        /*
        |--------------------------------------------------------------------------
        | INSCRIPTION
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/inscription',
            function () {
                return view('register');
            }
        )->name('register');


        Route::post(
            '/inscription',
            [
                AuthController::class,
                'register',
            ]
        )->name('register.store');


        Route::get(
            '/inscription-reussie',
            function () {
                return view('register-success');
            }
        )->name('register.success');


        /*
        |--------------------------------------------------------------------------
        | CONNEXION
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/connexion',
            function () {
                return view('login');
            }
        )->name('login');


        Route::post(
            '/connexion',
            [
                AuthController::class,
                'login',
            ]
        )->name('login.store');
    }
);


/*
|--------------------------------------------------------------------------
| DÉCONNEXION
|--------------------------------------------------------------------------
|
| La déconnexion nécessite obligatoirement une session utilisateur active.
|
*/

Route::post(
    '/deconnexion',
    [
        AuthController::class,
        'logout',
    ]
)
    ->middleware('auth')
    ->name('logout');


/*
|--------------------------------------------------------------------------
| ESPACE ADHÉRENT
|--------------------------------------------------------------------------
|
| Toutes les routes placées ici nécessitent une authentification.
|
| Exemple :
|
| /membre
| /membre/calendrier
| /membre/messages
| /membre/profil
|
*/

Route::middleware('auth')
    ->prefix('membre')
    ->name('member.')
    ->group(
        function () {

            /*
            |--------------------------------------------------------------------------
            | TABLEAU DE BORD ADHÉRENT
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/',
                function () {
                    return view('member.dashboard');
                }
            )->name('dashboard');


            /*
            |--------------------------------------------------------------------------
            | CALENDRIER ADHÉRENT
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/calendrier',
                [
                    MemberCourseController::class,
                    'index',
                ]
            )->name('courses');


            /*
            |--------------------------------------------------------------------------
            | MESSAGERIE ADHÉRENT
            |--------------------------------------------------------------------------
            |
            | L'adhérent peut :
            |
            | - consulter ses conversations ;
            | - démarrer une nouvelle conversation ;
            | - consulter l'historique d'une conversation ;
            | - répondre à une conversation ouverte.
            |
            */


            /*
            |--------------------------------------------------------------------------
            | LISTE DES CONVERSATIONS
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/messages',
                [
                    MemberMessageController::class,
                    'index',
                ]
            )->name('messages.index');


            /*
            |--------------------------------------------------------------------------
            | NOUVELLE CONVERSATION
            |--------------------------------------------------------------------------
            |
            | Cette route affichera le formulaire permettant à l'adhérent
            | de contacter directement l'administration depuis son espace.
            |
            */

            Route::get(
                '/messages/nouveau',
                [
                    MemberMessageController::class,
                    'create',
                ]
            )->name('messages.create');


            /*
            |--------------------------------------------------------------------------
            | ENREGISTRER UNE NOUVELLE CONVERSATION
            |--------------------------------------------------------------------------
            |
            | Cette route reçoit le formulaire précédent et crée :
            |
            | - la conversation ;
            | - le premier message de l'adhérent.
            |
            */

            Route::post(
                '/messages',
                [
                    MemberMessageController::class,
                    'store',
                ]
            )->name('messages.store');


            /*
            |--------------------------------------------------------------------------
            | AFFICHER UNE CONVERSATION
            |--------------------------------------------------------------------------
            |
            | IMPORTANT :
            |
            | Cette route doit rester APRÈS /messages/nouveau.
            |
            | Sinon Laravel pourrait interpréter le mot "nouveau"
            | comme étant l'identifiant d'une conversation.
            |
            */

            Route::get(
                '/messages/{conversation}',
                [
                    MemberMessageController::class,
                    'show',
                ]
            )->name('messages.show');


            /*
            |--------------------------------------------------------------------------
            | RÉPONDRE À UNE CONVERSATION
            |--------------------------------------------------------------------------
            */

            Route::post(
                '/messages/{conversation}/repondre',
                [
                    MemberMessageController::class,
                    'reply',
                ]
            )->name('messages.reply');


            /*
            |--------------------------------------------------------------------------
            | PROFIL
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/profil',
                [
                    AuthController::class,
                    'editProfile',
                ]
            )->name('profile');


            Route::patch(
                '/profil',
                [
                    AuthController::class,
                    'updateProfile',
                ]
            )->name('profile.update');


            /*
            |--------------------------------------------------------------------------
            | MODIFICATION DE L'EMAIL
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/email',
                [
                    AuthController::class,
                    'editEmail',
                ]
            )->name('email');


            Route::patch(
                '/email',
                [
                    AuthController::class,
                    'updateEmail',
                ]
            )->name('email.update');


            /*
            |--------------------------------------------------------------------------
            | MODIFICATION DU MOT DE PASSE
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/mot-de-passe',
                [
                    AuthController::class,
                    'editPassword',
                ]
            )->name('password');


            Route::patch(
                '/mot-de-passe',
                [
                    AuthController::class,
                    'updatePassword',
                ]
            )->name('password.update');


            /*
            |--------------------------------------------------------------------------
            | SUPPRESSION DU COMPTE
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/supprimer-mon-compte',
                [
                    AuthController::class,
                    'deleteAccount',
                ]
            )->name('delete-account');


            Route::delete(
                '/supprimer-mon-compte',
                [
                    AuthController::class,
                    'destroyAccount',
                ]
            )->name('delete-account.destroy');
        }
    );


/*
|--------------------------------------------------------------------------
| CONFIRMATION DE SUPPRESSION DU COMPTE
|--------------------------------------------------------------------------
|
| Cette page reste publique car l'utilisateur est automatiquement
| déconnecté après la suppression de son compte.
|
*/

Route::get(
    '/compte-supprime',
    function () {
        return view('member.account-deleted');
    }
)->name('member.account-deleted');


/*
|--------------------------------------------------------------------------
| ESPACE ADMINISTRATION
|--------------------------------------------------------------------------
|
| Deux protections sont appliquées :
|
| - auth  : l'utilisateur doit être connecté ;
| - admin : l'utilisateur doit avoir accès à l'administration.
|
*/

Route::middleware([
    'auth',
    'admin',
])
    ->prefix('admin')
    ->name('admin.')
    ->group(
        function () {

            /*
            |--------------------------------------------------------------------------
            | TABLEAU DE BORD ADMIN
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/',
                function () {
                    return view('admin.dashboard');
                }
            )->name('dashboard');


            /*
            |--------------------------------------------------------------------------
            | GESTION DES ADHÉRENTS
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/adherents',
                [
                    AdminMemberController::class,
                    'index',
                ]
            )->name('members.index');


            Route::patch(
                '/adherents/{id}/reactiver',
                [
                    AdminMemberController::class,
                    'restore',
                ]
            )->name('members.restore');


            Route::patch(
                '/adherents/{id}/promouvoir-admin',
                [
                    AdminMemberController::class,
                    'promote',
                ]
            )->name('members.promote');


            /*
            |--------------------------------------------------------------------------
            | GESTION DES ADMINISTRATEURS
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/administrateurs',
                [
                    AdminMemberController::class,
                    'administrators',
                ]
            )->name('administrators.index');


            Route::patch(
                '/administrateurs/{id}/retrograder',
                [
                    AdminMemberController::class,
                    'demote',
                ]
            )->name('administrators.demote');


            /*
            |--------------------------------------------------------------------------
            | MESSAGERIE ADMINISTRATION
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/messages',
                [
                    AdminMessageController::class,
                    'index',
                ]
            )->name('messages.index');


            Route::get(
                '/messages/{conversation}',
                [
                    AdminMessageController::class,
                    'show',
                ]
            )->name('messages.show');


            Route::post(
                '/messages/{conversation}/repondre',
                [
                    AdminMessageController::class,
                    'reply',
                ]
            )->name('messages.reply');


            Route::patch(
                '/messages/{conversation}/fermer',
                [
                    AdminMessageController::class,
                    'close',
                ]
            )->name('messages.close');


            Route::patch(
                '/messages/{conversation}/rouvrir',
                [
                    AdminMessageController::class,
                    'reopen',
                ]
            )->name('messages.reopen');


            /*
            |--------------------------------------------------------------------------
            | CALENDRIER ADMINISTRATION
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/calendrier',
                [
                    AdminCourseController::class,
                    'index',
                ]
            )->name('courses.index');


            Route::get(
                '/calendrier/ajouter',
                [
                    AdminCourseController::class,
                    'create',
                ]
            )->name('courses.create');


            Route::post(
                '/calendrier',
                [
                    AdminCourseController::class,
                    'store',
                ]
            )->name('courses.store');


            Route::patch(
                '/calendrier/{id}/reactiver',
                [
                    AdminCourseController::class,
                    'restore',
                ]
            )->name('courses.restore');


            Route::get(
                '/calendrier/{course}/modifier',
                [
                    AdminCourseController::class,
                    'edit',
                ]
            )->name('courses.edit');


            Route::put(
                '/calendrier/{course}',
                [
                    AdminCourseController::class,
                    'update',
                ]
            )->name('courses.update');


            Route::delete(
                '/calendrier/{course}',
                [
                    AdminCourseController::class,
                    'destroy',
                ]
            )->name('courses.destroy');
        }
    );