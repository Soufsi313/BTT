<?php

use App\Http\Controllers\AdminArticleController;
use App\Http\Controllers\AdminArticleImageController;
use App\Http\Controllers\AdminCommentController;
use App\Http\Controllers\AdminCourseController;
use App\Http\Controllers\AdminMemberController;
use App\Http\Controllers\AdminMessageController;
use App\Http\Controllers\ArticleLikeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommentReportController;
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
| Le blog public fonctionne avec BlogController.
|
| La première route affiche la bibliothèque des articles.
|
| La seconde route affiche un article individuel grâce à son slug.
|
| Exemple :
|
| /blog
|
| /blog/retour-sur-notre-entrainement-boxe
|
*/


/*
|--------------------------------------------------------------------------
| LISTE DES ARTICLES
|--------------------------------------------------------------------------
*/

Route::get(
    '/blog',
    [BlogController::class, 'index']
)->name('blog');


/*
|--------------------------------------------------------------------------
| LECTURE D'UN ARTICLE
|--------------------------------------------------------------------------
|
| Le paramètre {slug} correspond à l'URL propre générée lors de
| la création ou de la modification de l'article.
|
*/

Route::get(
    '/blog/{slug}',
    [BlogController::class, 'show']
)->name('blog.show');


/*
|--------------------------------------------------------------------------
| PUBLIER UN COMMENTAIRE
|--------------------------------------------------------------------------
|
| Seuls les utilisateurs connectés peuvent publier un commentaire.
|
| Les visiteurs non connectés peuvent lire les commentaires,
| mais ils ne peuvent pas utiliser cette route.
|
*/

Route::post(
    '/blog/{slug}/commentaires',
    [CommentController::class, 'store']
)
    ->middleware('auth')
    ->name('comments.store');


/*
|--------------------------------------------------------------------------
| SIGNALER UN COMMENTAIRE
|--------------------------------------------------------------------------
|
| Cette route permet à un membre connecté de signaler un commentaire
| publié sous un article du blog.
|
| Le slug permet de vérifier que le commentaire appartient bien
| à l'article actuellement consulté.
|
| Le paramètre {comment} utilise le Route Model Binding de Laravel
| afin de récupérer automatiquement le commentaire concerné.
|
| Seuls les utilisateurs authentifiés peuvent effectuer
| un signalement.
|
*/

Route::post(
    '/blog/{slug}/commentaires/{comment}/signaler',
    [CommentReportController::class, 'store']
)
    ->middleware('auth')
    ->name('comments.reports.store');


/*
|--------------------------------------------------------------------------
| LIKER OU RETIRER SON LIKE
|--------------------------------------------------------------------------
|
| Seuls les utilisateurs connectés peuvent utiliser cette route.
|
| Le fonctionnement est de type "toggle" :
|
| - si l'utilisateur n'a pas encore liké l'article :
|   le like est créé ;
|
| - s'il a déjà liké l'article :
|   son like est supprimé.
|
| Les visiteurs non connectés pourront voir le nombre de likes,
| mais ne pourront pas en ajouter.
|
*/

Route::post(
    '/blog/{slug}/like',
    [ArticleLikeController::class, 'toggle']
)
    ->middleware('auth')
    ->name('article.likes.toggle');


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
        | MODÉRATION DES COMMENTAIRES
        |--------------------------------------------------------------------------
        |
        | L'administration peut :
        |
        | - consulter tous les commentaires ;
        | - masquer un commentaire ;
        | - republier un commentaire ;
        | - supprimer logiquement un commentaire ;
        | - restaurer un commentaire supprimé.
        |
        */


        /*
        |--------------------------------------------------------------------------
        | LISTE DES COMMENTAIRES
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/commentaires',
            [AdminCommentController::class, 'index']
        )->name('comments.index');


        /*
        |--------------------------------------------------------------------------
        | RESTAURER UN COMMENTAIRE SUPPRIMÉ
        |--------------------------------------------------------------------------
        |
        | Cette route utilise directement l'identifiant afin de pouvoir
        | retrouver un commentaire supprimé avec onlyTrashed().
        |
        */

        Route::patch(
            '/commentaires/{id}/restaurer',
            [AdminCommentController::class, 'restore']
        )->name('comments.restore');


        /*
        |--------------------------------------------------------------------------
        | MASQUER UN COMMENTAIRE
        |--------------------------------------------------------------------------
        */

        Route::patch(
            '/commentaires/{comment}/masquer',
            [AdminCommentController::class, 'hide']
        )->name('comments.hide');


        /*
        |--------------------------------------------------------------------------
        | RÉAFFICHER UN COMMENTAIRE
        |--------------------------------------------------------------------------
        */

        Route::patch(
            '/commentaires/{comment}/publier',
            [AdminCommentController::class, 'publish']
        )->name('comments.publish');


        /*
        |--------------------------------------------------------------------------
        | SUPPRIMER UN COMMENTAIRE
        |--------------------------------------------------------------------------
        */

        Route::delete(
            '/commentaires/{comment}',
            [AdminCommentController::class, 'destroy']
        )->name('comments.destroy');


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
        | UPLOAD D'UNE IMAGE DANS LE CONTENU D'UN ARTICLE
        |--------------------------------------------------------------------------
        |
        | Cette route est utilisée par Quill lorsqu'un administrateur
        | insère directement une image dans le corps de l'article.
        |
        | Elle doit rester avant les routes dynamiques utilisant
        | {article}.
        |
        */

        Route::post(
            '/articles/images',
            [AdminArticleImageController::class, 'store']
        )->name('articles.images.store');


        /*
        |--------------------------------------------------------------------------
        | RESTAURER UN ARTICLE SUPPRIMÉ
        |--------------------------------------------------------------------------
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
        */

        Route::delete(
            '/articles/{article}',
            [AdminArticleController::class, 'destroy']
        )->name('articles.destroy');
    });