<?php

use App\Http\Controllers\AdminCourseController;
use App\Http\Controllers\AdminMemberController;
use App\Http\Controllers\AdminMessageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\MemberCourseController;
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
|
| La page Contact est accessible aussi bien :
|
| - aux visiteurs non connectés ;
| - aux adhérents connectés.
|
| Le formulaire enregistre une conversation et son premier message
| dans la base de données.
|
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
|
| Ces routes sont protégées par le middleware "guest".
|
| Un utilisateur déjà connecté ne doit normalement pas accéder
| aux pages de connexion ou d'inscription.
|
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
|
| Seul un utilisateur connecté peut utiliser cette route.
|
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
|
| Toutes les routes commençant par /membre sont réservées
| aux utilisateurs connectés.
|
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
| Cette page reste accessible après la déconnexion automatique
| provoquée par la suppression du compte.
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
| Toutes les routes de cette section sont protégées par :
|
| - auth  : l'utilisateur doit être connecté ;
| - admin : l'utilisateur doit être Admin ou Super Admin.
|
| Toutes les URL commencent par :
|
| /admin
|
| Tous les noms de routes commencent par :
|
| admin.
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
        | TABLEAU DE BORD ADMIN
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
        | RÉACTIVER UN ADHÉRENT
        |--------------------------------------------------------------------------
        |
        | Cette fonctionnalité utilise SoftDeletes.
        |
        | La protection Super Admin est également appliquée
        | directement dans le contrôleur.
        |
        */

        Route::patch(
            '/adherents/{id}/reactiver',
            [AdminMemberController::class, 'restore']
        )->name('members.restore');


        /*
        |--------------------------------------------------------------------------
        | PROMOUVOIR UN ADHÉRENT ADMIN
        |--------------------------------------------------------------------------
        |
        | Seul le Super Admin peut effectuer cette opération.
        |
        */

        Route::patch(
            '/adherents/{id}/promouvoir-admin',
            [AdminMemberController::class, 'promoteToAdmin']
        )->name('members.promote');



        /*
        |--------------------------------------------------------------------------
        | GESTION DES ADMINISTRATEURS
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
        |
        | Permet au Super Admin de transformer un Admin
        | en simple adhérent.
        |
        */

        Route::patch(
            '/administrateurs/{id}/retrograder',
            [AdminMemberController::class, 'demoteAdmin']
        )->name('administrators.demote');



        /*
        |--------------------------------------------------------------------------
        | MESSAGERIE ADMINISTRATION
        |--------------------------------------------------------------------------
        |
        | La messagerie permet aux administrateurs de consulter les
        | conversations envoyées :
        |
        | - par les visiteurs du site ;
        | - par les adhérents connectés.
        |
        | Tous les administrateurs consultent la même boîte de réception.
        |
        */


        /*
        |--------------------------------------------------------------------------
        | LISTE DES CONVERSATIONS
        |--------------------------------------------------------------------------
        |
        | Exemple :
        |
        | /admin/messages
        |
        */

        Route::get(
            '/messages',
            [AdminMessageController::class, 'index']
        )->name('messages.index');


        /*
        |--------------------------------------------------------------------------
        | DÉTAIL D'UNE CONVERSATION
        |--------------------------------------------------------------------------
        |
        | Exemple :
        |
        | /admin/messages/12
        |
        | Laravel récupère automatiquement la conversation grâce
        | au Route Model Binding.
        |
        */

        Route::get(
            '/messages/{conversation}',
            [AdminMessageController::class, 'show']
        )->name('messages.show');



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
        | RÉACTIVER UN COURS SUPPRIMÉ
        |--------------------------------------------------------------------------
        |
        | Cette action est protégée également dans le contrôleur.
        |
        | Seul le Super Admin peut restaurer un cours supprimé.
        |
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
        |
        | Grâce à SoftDeletes, cette suppression renseigne deleted_at
        | au lieu d'effacer définitivement la ligne.
        |
        */

        Route::delete(
            '/calendrier/{course}',
            [AdminCourseController::class, 'destroy']
        )->name('courses.destroy');

    });