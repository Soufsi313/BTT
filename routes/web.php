<?php

use App\Http\Controllers\AdminArticleController;
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
*/


/*
|--------------------------------------------------------------------------
| ACCUEIL
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');


/*
|--------------------------------------------------------------------------
| DISCIPLINES
|--------------------------------------------------------------------------
*/

Route::get('/disciplines', function () {
    return view('disciplines');
})->name('disciplines');


/*
|--------------------------------------------------------------------------
| COACHS
|--------------------------------------------------------------------------
*/

Route::get('/coachs', function () {
    return view('coachs');
})->name('coachs');


/*
|--------------------------------------------------------------------------
| BLOG
|--------------------------------------------------------------------------
|
| Pour le moment, cette route affiche encore la page temporaire
| du Blog.
|
| Elle sera plus tard reliée aux articles publiés.
|
*/

Route::get('/blog', function () {
    return view('blog');
})->name('blog');


/*
|--------------------------------------------------------------------------
| HUMANITAIRE
|--------------------------------------------------------------------------
*/

Route::get('/humanitaire', function () {
    return view('humanitaire');
})->name('humanitaire');


/*
|--------------------------------------------------------------------------
| ABONNEMENTS
|--------------------------------------------------------------------------
*/

Route::get('/abonnements', function () {
    return view('abonnements');
})->name('abonnements');


/*
|--------------------------------------------------------------------------
| CONTACT
|--------------------------------------------------------------------------
*/

Route::get('/contact', function () {
    return view('contact');
})->name('contact');


Route::post(
    '/contact',
    [ContactController::class, 'store']
)->name('contact.store');


/*
|--------------------------------------------------------------------------
| VISITEURS NON CONNECTÉS
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {


    /*
    |--------------------------------------------------------------------------
    | INSCRIPTION
    |--------------------------------------------------------------------------
    */

    Route::get('/inscription', function () {
        return view('register');
    })->name('register');


    Route::post(
        '/inscription',
        [AuthController::class, 'register']
    )->name('register.store');


    Route::get('/inscription-reussie', function () {
        return view('register-success');
    })->name('register.success');


    /*
    |--------------------------------------------------------------------------
    | CONNEXION
    |--------------------------------------------------------------------------
    */

    Route::get('/connexion', function () {
        return view('login');
    })->name('login');


    Route::post(
        '/connexion',
        [AuthController::class, 'login']
    )->name('login.store');
});


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

Route::middleware('auth')
    ->prefix('membre')
    ->name('member.')
    ->group(function () {


        /*
        |--------------------------------------------------------------------------
        | TABLEAU DE BORD
        |--------------------------------------------------------------------------
        */

        Route::get('/', function () {
            return view('member.dashboard');
        })->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | CALENDRIER
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/calendrier',
            [MemberCourseController::class, 'index']
        )->name('courses');


        /*
        |--------------------------------------------------------------------------
        | MESSAGERIE PRIVÉE
        |--------------------------------------------------------------------------
        |
        | IMPORTANT :
        |
        | La route /messages/nouveau doit rester placée avant
        | /messages/{conversation}.
        |
        */


        /*
        |--------------------------------------------------------------------------
        | LISTE DES CONVERSATIONS
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/messages',
            [MemberMessageController::class, 'index']
        )->name('messages.index');


        /*
        |--------------------------------------------------------------------------
        | NOUVELLE CONVERSATION
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/messages/nouveau',
            [MemberMessageController::class, 'create']
        )->name('messages.create');


        Route::post(
            '/messages',
            [MemberMessageController::class, 'store']
        )->name('messages.store');


        /*
        |--------------------------------------------------------------------------
        | CONSULTER UNE CONVERSATION
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/messages/{conversation}',
            [MemberMessageController::class, 'show']
        )->name('messages.show');


        /*
        |--------------------------------------------------------------------------
        | RÉPONDRE À UNE CONVERSATION
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/messages/{conversation}/repondre',
            [MemberMessageController::class, 'reply']
        )->name('messages.reply');


        /*
        |--------------------------------------------------------------------------
        | PROFIL
        |--------------------------------------------------------------------------
        */

        Route::get('/profil', function () {
            return view('member.profile');
        })->name('profile');


        Route::patch(
            '/profil',
            [AuthController::class, 'updateProfile']
        )->name('profile.update');


        /*
        |--------------------------------------------------------------------------
        | EMAIL
        |--------------------------------------------------------------------------
        */

        Route::get('/email', function () {
            return view('member.email');
        })->name('email');


        Route::patch(
            '/email',
            [AuthController::class, 'updateEmail']
        )->name('email.update');


        /*
        |--------------------------------------------------------------------------
        | MOT DE PASSE
        |--------------------------------------------------------------------------
        */

        Route::get('/mot-de-passe', function () {
            return view('member.password');
        })->name('password');


        Route::patch(
            '/mot-de-passe',
            [AuthController::class, 'updatePassword']
        )->name('password.update');


        /*
        |--------------------------------------------------------------------------
        | SUPPRESSION DU COMPTE
        |--------------------------------------------------------------------------
        */

        Route::get('/supprimer-mon-compte', function () {
            return view('member.delete-account');
        })->name('delete-account');


        Route::delete(
            '/supprimer-mon-compte',
            [AuthController::class, 'deleteAccount']
        )->name('delete-account.destroy');
    });


/*
|--------------------------------------------------------------------------
| CONFIRMATION APRÈS SUPPRESSION DU COMPTE
|--------------------------------------------------------------------------
|
| Cette page reste en dehors du middleware auth car l'utilisateur
| est automatiquement déconnecté lorsque son compte est supprimé.
|
*/

Route::get('/compte-supprime', function () {
    return view('member.account-deleted');
})->name('member.account-deleted');


/*
|--------------------------------------------------------------------------
| ESPACE ADMINISTRATION
|--------------------------------------------------------------------------
|
| Toutes les routes ci-dessous nécessitent :
|
| - une connexion ;
| - les droits administrateur.
|
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
        | GESTION DES ADHÉRENTS
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/adherents',
            [AdminMemberController::class, 'index']
        )->name('members.index');


        /*
        |--------------------------------------------------------------------------
        | RESTAURER UN ADHÉRENT
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
        | ADMINISTRATEURS
        |--------------------------------------------------------------------------
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


        /*
        |--------------------------------------------------------------------------
        | CALENDRIER ADMIN
        |--------------------------------------------------------------------------
        */


        /*
        |--------------------------------------------------------------------------
        | LISTE DES COURS
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/calendrier',
            [AdminCourseController::class, 'index']
        )->name('courses.index');


        /*
        |--------------------------------------------------------------------------
        | AJOUTER UN COURS
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/calendrier/ajouter',
            [AdminCourseController::class, 'create']
        )->name('courses.create');


        Route::post(
            '/calendrier',
            [AdminCourseController::class, 'store']
        )->name('courses.store');


        /*
        |--------------------------------------------------------------------------
        | RESTAURER UN COURS
        |--------------------------------------------------------------------------
        */

        Route::patch(
            '/calendrier/{id}/reactiver',
            [AdminCourseController::class, 'restore']
        )->name('courses.restore');


        /*
        |--------------------------------------------------------------------------
        | MODIFIER UN COURS
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/calendrier/{course}/modifier',
            [AdminCourseController::class, 'edit']
        )->name('courses.edit');


        Route::patch(
            '/calendrier/{course}',
            [AdminCourseController::class, 'update']
        )->name('courses.update');


        /*
        |--------------------------------------------------------------------------
        | SUPPRIMER UN COURS
        |--------------------------------------------------------------------------
        */

        Route::delete(
            '/calendrier/{course}',
            [AdminCourseController::class, 'destroy']
        )->name('courses.destroy');


        /*
        |--------------------------------------------------------------------------
        | MESSAGERIE ADMINISTRATION
        |--------------------------------------------------------------------------
        */


        /*
        |--------------------------------------------------------------------------
        | LISTE DES CONVERSATIONS
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/messages',
            [AdminMessageController::class, 'index']
        )->name('messages.index');


        /*
        |--------------------------------------------------------------------------
        | CONSULTER UNE CONVERSATION
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/messages/{conversation}',
            [AdminMessageController::class, 'show']
        )->name('messages.show');


        /*
        |--------------------------------------------------------------------------
        | RÉPONDRE À UNE CONVERSATION
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/messages/{conversation}/repondre',
            [AdminMessageController::class, 'reply']
        )->name('messages.reply');


        /*
        |--------------------------------------------------------------------------
        | FERMER UNE CONVERSATION
        |--------------------------------------------------------------------------
        */

        Route::patch(
            '/messages/{conversation}/fermer',
            [AdminMessageController::class, 'close']
        )->name('messages.close');


        /*
        |--------------------------------------------------------------------------
        | ROUVRIR UNE CONVERSATION
        |--------------------------------------------------------------------------
        */

        Route::patch(
            '/messages/{conversation}/rouvrir',
            [AdminMessageController::class, 'reopen']
        )->name('messages.reopen');


        /*
        |--------------------------------------------------------------------------
        | GESTION DES ARTICLES
        |--------------------------------------------------------------------------
        |
        | Cette partie gère progressivement le Blog BTT depuis
        | l'administration.
        |
        */


        /*
        |--------------------------------------------------------------------------
        | LISTE DES ARTICLES
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/articles',
            [AdminArticleController::class, 'index']
        )->name('articles.index');


        /*
        |--------------------------------------------------------------------------
        | NOUVEL ARTICLE
        |--------------------------------------------------------------------------
        |
        | Cette route affiche le formulaire permettant de rédiger
        | un nouvel article.
        |
        | Elle doit rester AVANT les futures routes du type :
        |
        | /articles/{article}
        |
        */

        Route::get(
            '/articles/nouveau',
            [AdminArticleController::class, 'create']
        )->name('articles.create');


        /*
        |--------------------------------------------------------------------------
        | ENREGISTRER UN ARTICLE
        |--------------------------------------------------------------------------
        |
        | Cette route reçoit les informations envoyées par le
        | formulaire puis appelle la méthode store() du contrôleur.
        |
        */

        Route::post(
            '/articles',
            [AdminArticleController::class, 'store']
        )->name('articles.store');
    });