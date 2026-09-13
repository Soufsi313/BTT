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
        | MESSAGERIE ADHÉRENT
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/messages',
            [MemberMessageController::class, 'index']
        )->name('messages.index');


        /*
         * Cette route doit rester avant :
         *
         * /messages/{conversation}
         *
         * afin que Laravel n'interprète pas "nouveau"
         * comme l'identifiant d'une conversation.
         */
        Route::get(
            '/messages/nouveau',
            [MemberMessageController::class, 'create']
        )->name('messages.create');


        Route::post(
            '/messages',
            [MemberMessageController::class, 'store']
        )->name('messages.store');


        Route::get(
            '/messages/{conversation}',
            [MemberMessageController::class, 'show']
        )->name('messages.show');


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
*/

Route::get('/compte-supprime', function () {
    return view('member.account-deleted');
})->name('member.account-deleted');


/*
|--------------------------------------------------------------------------
| ESPACE ADMINISTRATION
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


        Route::patch(
            '/adherents/{id}/reactiver',
            [AdminMemberController::class, 'restore']
        )->name('members.restore');


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
        | RÉACTIVER UN COURS SUPPRIMÉ
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

        Route::get(
            '/messages',
            [AdminMessageController::class, 'index']
        )->name('messages.index');


        Route::get(
            '/messages/{conversation}',
            [AdminMessageController::class, 'show']
        )->name('messages.show');


        Route::post(
            '/messages/{conversation}/repondre',
            [AdminMessageController::class, 'reply']
        )->name('messages.reply');


        Route::patch(
            '/messages/{conversation}/fermer',
            [AdminMessageController::class, 'close']
        )->name('messages.close');


        Route::patch(
            '/messages/{conversation}/rouvrir',
            [AdminMessageController::class, 'reopen']
        )->name('messages.reopen');


        /*
        |--------------------------------------------------------------------------
        | ARTICLES DU BLOG
        |--------------------------------------------------------------------------
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
        | CRÉER UN ARTICLE
        |--------------------------------------------------------------------------
        |
        | Cette route reste avant les routes dynamiques
        | contenant {article}.
        |
        */

        Route::get(
            '/articles/nouveau',
            [AdminArticleController::class, 'create']
        )->name('articles.create');


        Route::post(
            '/articles',
            [AdminArticleController::class, 'store']
        )->name('articles.store');


        /*
        |--------------------------------------------------------------------------
        | RESTAURER UN ARTICLE SUPPRIMÉ
        |--------------------------------------------------------------------------
        |
        | Nous utilisons ici l'ID directement.
        |
        | Le contrôleur utilise ensuite :
        |
        | Article::withTrashed()->findOrFail($id)
        |
        | afin de pouvoir retrouver un article supprimé.
        |
        */

        Route::patch(
            '/articles/{id}/reactiver',
            [AdminArticleController::class, 'restore']
        )->name('articles.restore');


        /*
        |--------------------------------------------------------------------------
        | MODIFIER UN ARTICLE
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/articles/{article}/modifier',
            [AdminArticleController::class, 'edit']
        )->name('articles.edit');


        /*
        |--------------------------------------------------------------------------
        | ENREGISTRER LES MODIFICATIONS
        |--------------------------------------------------------------------------
        */

        Route::patch(
            '/articles/{article}',
            [AdminArticleController::class, 'update']
        )->name('articles.update');


        /*
        |--------------------------------------------------------------------------
        | SUPPRIMER UN ARTICLE
        |--------------------------------------------------------------------------
        |
        | Cette suppression utilise SoftDeletes.
        |
        | L'article ne sera donc pas effacé définitivement.
        |
        */

        Route::delete(
            '/articles/{article}',
            [AdminArticleController::class, 'destroy']
        )->name('articles.destroy');
    });