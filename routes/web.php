<?php

use App\Http\Controllers\AdminCookieConsentController;
use App\Http\Controllers\AdminArticleController;
use App\Http\Controllers\AdminArticleImageController;
use App\Http\Controllers\AdminCommentController;
use App\Http\Controllers\AdminCommentReportController;
use App\Http\Controllers\AdminCourseController;
use App\Http\Controllers\AdminMemberController;
use App\Http\Controllers\AdminMessageController;
use App\Http\Controllers\ArticleLikeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommentReportController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CookieConsentController;
use App\Http\Controllers\MemberCourseController;
use App\Http\Controllers\MemberMessageController;
use App\Models\Article;
use App\Models\Comment;
use App\Models\CommentReport;
use App\Models\Conversation;
use App\Models\Course;
use App\Models\User;
use App\Notifications\RegistrationConfirmedNotification;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
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
| Pour publier un commentaire, l'utilisateur doit maintenant :
|
| - être connecté ;
| - avoir vérifié son adresse email.
|
| Les visiteurs peuvent toujours consulter les commentaires.
|
*/

Route::post(
    '/blog/{slug}/commentaires',
    [CommentController::class, 'store']
)
    ->middleware([
        'auth',
        'verified',
    ])
    ->name('comments.store');


/*
|--------------------------------------------------------------------------
| SIGNALER UN COMMENTAIRE
|--------------------------------------------------------------------------
|
| Cette route permet à un membre de signaler un commentaire.
|
| Le membre doit :
|
| - être authentifié ;
| - avoir vérifié son adresse email.
|
*/

Route::post(
    '/blog/{slug}/commentaires/{comment}/signaler',
    [CommentReportController::class, 'store']
)
    ->middleware([
        'auth',
        'verified',
    ])
    ->name('comments.reports.store');


/*
|--------------------------------------------------------------------------
| LIKER OU RETIRER SON LIKE
|--------------------------------------------------------------------------
|
| Pour utiliser le système de likes, l'utilisateur doit :
|
| - être connecté ;
| - avoir vérifié son adresse email.
|
| Le fonctionnement reste de type "toggle".
|
*/

Route::post(
    '/blog/{slug}/like',
    [ArticleLikeController::class, 'toggle']
)
    ->middleware([
        'auth',
        'verified',
    ])
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
 | PRÉFÉRENCES DE COOKIES
 |--------------------------------------------------------------------------
 |
 | Ces routes sont accessibles aux visiteurs anonymes et aux membres.
 | GET retourne le choix actuel du navigateur.
 | POST enregistre ou modifie les préférences (protection CSRF de Laravel).
 |
 */

Route::get(
    '/cookie-consent',
    [CookieConsentController::class, 'show']
)->name('cookie-consent.show');

Route::post(
    '/cookie-consent',
    [CookieConsentController::class, 'store']
)->name('cookie-consent.store');


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


    /*
    |--------------------------------------------------------------------------
    | ANCIENNE PAGE DE CONFIRMATION
    |--------------------------------------------------------------------------
    |
    | Cette route est conservée pour le moment afin de ne pas supprimer
    | brutalement une ancienne fonctionnalité du projet.
    |
    | Le nouveau processus d'inscription utilise désormais directement
    | la vérification de l'adresse email.
    |
    */

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
| VÉRIFICATION DE L'ADRESSE EMAIL
|--------------------------------------------------------------------------
|
| Ces routes utilisent le système natif de vérification fourni
| par Laravel.
|
| Fonctionnement :
|
| 1. l'utilisateur s'inscrit ;
| 2. il reçoit notre email BTT personnalisé ;
| 3. il clique sur le lien sécurisé ;
| 4. Laravel vérifie la signature ;
| 5. email_verified_at reçoit la date de vérification ;
| 6. notre email de confirmation BTT est envoyé ;
| 7. l'utilisateur peut accéder à son espace membre.
|
*/


/*
|--------------------------------------------------------------------------
| PAGE DE DEMANDE DE VÉRIFICATION
|--------------------------------------------------------------------------
|
| Cette route doit utiliser uniquement le middleware "auth".
|
| Il ne faut surtout pas utiliser "verified" ici puisque cette page
| est précisément destinée aux utilisateurs qui ne sont pas encore
| vérifiés.
|
*/

Route::get('/email/verification', function (Request $request) {

    /*
    |--------------------------------------------------------------------------
    | UTILISATEUR DÉJÀ VÉRIFIÉ
    |--------------------------------------------------------------------------
    */

    if ($request->user()->hasVerifiedEmail()) {
        return redirect()->route('member.dashboard');
    }


    /*
    |--------------------------------------------------------------------------
    | AFFICHAGE DE LA PAGE DE VÉRIFICATION
    |--------------------------------------------------------------------------
    */

    return view('auth.verify-email');
})
    ->middleware('auth')
    ->name('verification.notice');


/*
|--------------------------------------------------------------------------
| TRAITEMENT DU LIEN DE VÉRIFICATION
|--------------------------------------------------------------------------
|
| Cette route reçoit le lien contenu dans notre email BTT.
|
| EmailVerificationRequest contrôle notamment :
|
| - l'utilisateur connecté ;
| - son identifiant ;
| - le hash de son adresse email ;
| - la signature du lien ;
| - la date d'expiration.
|
*/

Route::get(
    '/email/verification/{id}/{hash}',
    function (EmailVerificationRequest $request) {

        /*
        |--------------------------------------------------------------------------
        | ADRESSE DÉJÀ VÉRIFIÉE
        |--------------------------------------------------------------------------
        |
        | Si le membre clique une deuxième fois sur son lien, nous ne
        | devons surtout pas lui envoyer une nouvelle confirmation
        | d'inscription.
        |
        */

        if ($request->user()->hasVerifiedEmail()) {
            return redirect()
                ->route('member.dashboard')
                ->with(
                    'success',
                    'Votre adresse email est déjà vérifiée.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | VALIDATION DE L'ADRESSE EMAIL
        |--------------------------------------------------------------------------
        |
        | fulfill() renseigne email_verified_at.
        |
        | Laravel considère alors officiellement l'adresse email
        | comme vérifiée.
        |
        */

        $request->fulfill();


        /*
        |--------------------------------------------------------------------------
        | EMAIL DE CONFIRMATION D'INSCRIPTION BTT
        |--------------------------------------------------------------------------
        |
        | L'adresse vient d'être vérifiée avec succès.
        |
        | Nous envoyons maintenant notre deuxième email personnalisé :
        |
        | "Bienvenue chez Brussels Top Team - Inscription confirmée"
        |
        | Cet email n'est donc jamais envoyé avant que l'utilisateur
        | ait réellement confirmé son adresse.
        |
        */

        $request->user()->notify(
            new RegistrationConfirmedNotification()
        );


        /*
        |--------------------------------------------------------------------------
        | REDIRECTION VERS L'ESPACE MEMBRE
        |--------------------------------------------------------------------------
        |
        | email_verified_at étant maintenant renseigné, le middleware
        | "verified" autorisera l'accès au tableau de bord membre.
        |
        */

        return redirect()
            ->route('member.dashboard')
            ->with(
                'success',
                'Votre adresse email a bien été vérifiée. Bienvenue chez BTT !'
            );
    }
)
    ->middleware([
        'auth',
        'signed',
        'throttle:6,1',
    ])
    ->name('verification.verify');


/*
|--------------------------------------------------------------------------
| RENVOYER L'EMAIL DE VÉRIFICATION
|--------------------------------------------------------------------------
|
| Cette route correspond au bouton :
|
| "Renvoyer l'email de vérification"
|
| présent sur auth.verify-email.
|
*/

Route::post(
    '/email/verification-notification',
    function (Request $request) {

        /*
        |--------------------------------------------------------------------------
        | ADRESSE DÉJÀ VÉRIFIÉE
        |--------------------------------------------------------------------------
        */

        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('member.dashboard');
        }


        /*
        |--------------------------------------------------------------------------
        | RENVOI DU LIEN
        |--------------------------------------------------------------------------
        |
        | Grâce à la surcharge effectuée dans User.php, cette méthode
        | utilise maintenant notre VerifyEmailNotification BTT.
        |
        */

        $request->user()->sendEmailVerificationNotification();


        /*
        |--------------------------------------------------------------------------
        | MESSAGE DE CONFIRMATION
        |--------------------------------------------------------------------------
        */

        return back()->with(
            'status',
            'verification-link-sent'
        );
    }
)
    ->middleware([
        'auth',
        'throttle:6,1',
    ])
    ->name('verification.send');


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
|
| L'espace membre nécessite désormais DEUX conditions :
|
| 1. auth
|    L'utilisateur doit être connecté.
|
| 2. verified
|    Son adresse email doit avoir été vérifiée.
|
| Un utilisateur connecté mais non vérifié sera automatiquement
| redirigé par Laravel vers la route "verification.notice".
|
*/

Route::middleware([
    'auth',
    'verified',
])
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
|
| Cette page reste en dehors du groupe "verified" puisque le compte
| vient précisément d'être déconnecté et supprimé logiquement.
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
| IMPORTANT :
|
| Nous ne rajoutons PAS encore le middleware "verified" ici.
|
| Les comptes administrateurs existants ont été créés avant la mise
| en place de la vérification email et certains pourraient donc avoir
| email_verified_at à NULL.
|
| Ajouter "verified" maintenant pourrait bloquer ton propre accès au
| back-office.
|
| Nous traiterons les comptes historiques séparément.
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

        Route::get('/', function (Request $request) {

            /*
            |--------------------------------------------------------------------------
            | ADMINISTRATEUR CONNECTÉ
            |--------------------------------------------------------------------------
            |
            | Les statistiques genrées respectent les mêmes droits que les pages
            | Adhérents et Calendrier :
            |
            | - Super Admin : toutes les données ;
            | - Admin : uniquement les données correspondant à son genre.
            |
            */

            $admin = $request->user();

            $now = now('Europe/Brussels');
            $nowSql = $now->format('Y-m-d H:i:s');


            /*
            |--------------------------------------------------------------------------
            | STATISTIQUES ADHÉRENTS
            |--------------------------------------------------------------------------
            */

            $membersScope = User::withTrashed()
                ->where('role', 'adherent');

            if (! $admin->isSuperAdmin()) {
                $membersScope->where(
                    'genre',
                    $admin->genre
                );
            }


            /*
            | Total :
            | comptes actifs + comptes archivés.
            */

            $totalMembersCount = (clone $membersScope)
                ->count();


            /*
            | Comptes actifs.
            */

            $activeMembersCount = (clone $membersScope)
                ->whereNull('deleted_at')
                ->count();


            /*
            | Comptes archivés.
            */

            $archivedMembersCount = (clone $membersScope)
                ->whereNotNull('deleted_at')
                ->count();


            /*
            | Nouvelles inscriptions du mois.
            |
            | Comme dans les statistiques détaillées des adhérents,
            | seuls les comptes actuellement actifs sont comptabilisés.
            */

            $newMembersThisMonthCount = (clone $membersScope)
                ->whereNull('deleted_at')
                ->whereYear(
                    'created_at',
                    $now->year
                )
                ->whereMonth(
                    'created_at',
                    $now->month
                )
                ->count();


            /*
            |--------------------------------------------------------------------------
            | ÉVOLUTION DES INSCRIPTIONS SUR SIX MOIS
            |--------------------------------------------------------------------------
            |
            | Ce tableau alimente directement le graphique du Dashboard.
            |
            | Aucune valeur n'est écrite en dur :
            | chaque mois est recalculé depuis la table users.
            |
            */

            $membersMonthlyEvolution = collect(
                range(5, 0)
            )
                ->map(
                    function (int $monthsAgo) use (
                        $membersScope,
                        $now
                    ) {
                        $month = $now
                            ->copy()
                            ->subMonths($monthsAgo);

                        return [
                            'label' => ucfirst(
                                $month->translatedFormat('M')
                            ),

                            'count' => (clone $membersScope)
                                ->whereNull('deleted_at')
                                ->whereYear(
                                    'created_at',
                                    $month->year
                                )
                                ->whereMonth(
                                    'created_at',
                                    $month->month
                                )
                                ->count(),
                        ];
                    }
                )
                ->values();


            /*
            |--------------------------------------------------------------------------
            | STATISTIQUES COURS
            |--------------------------------------------------------------------------
            */

            $coursesScope = Course::withTrashed();


            /*
            | Un Admin classique reste limité aux cours
            | correspondant à son genre.
            */

            if (! $admin->isSuperAdmin()) {
                $coursesScope->where(
                    'category',
                    $admin->genre
                );
            }


            /*
            | Total :
            | tous les cours, y compris les cours supprimés.
            */

            $totalCoursesCount = (clone $coursesScope)
                ->count();


            /*
            | Actifs :
            | - non supprimés ;
            | - is_active = true ;
            | - heure de fin encore dans le futur.
            */

            $activeCoursesCount = (clone $coursesScope)
                ->whereNull('deleted_at')
                ->where(
                    'is_active',
                    true
                )
                ->whereRaw(
                    'TIMESTAMP(course_date, end_time) > ?',
                    [$nowSql]
                )
                ->count();


            /*
            | Inactifs :
            | - non supprimés ;
            | - is_active = false ;
            | - heure de fin encore dans le futur.
            */

            $inactiveCoursesCount = (clone $coursesScope)
                ->whereNull('deleted_at')
                ->where(
                    'is_active',
                    false
                )
                ->whereRaw(
                    'TIMESTAMP(course_date, end_time) > ?',
                    [$nowSql]
                )
                ->count();


            /*
            | Terminés :
            | cours dont l'heure de fin est passée,
            | indépendamment de is_active.
            */

            $completedCoursesCount = (clone $coursesScope)
                ->whereNull('deleted_at')
                ->whereRaw(
                    'TIMESTAMP(course_date, end_time) <= ?',
                    [$nowSql]
                )
                ->count();


            /*
            | Supprimés logiquement.
            */

            $deletedCoursesCount = (clone $coursesScope)
                ->whereNotNull('deleted_at')
                ->count();


            /*
            |--------------------------------------------------------------------------
            | STATISTIQUES ARTICLES
            |--------------------------------------------------------------------------
            */

            $totalArticlesCount = Article::withTrashed()
                ->count();

            $publishedArticlesCount = Article::query()
                ->where(
                    'status',
                    'published'
                )
                ->count();

            $draftArticlesCount = Article::query()
                ->where(
                    'status',
                    'draft'
                )
                ->count();


            /*
            |--------------------------------------------------------------------------
            | STATISTIQUES COMMENTAIRES ET SIGNALEMENTS
            |--------------------------------------------------------------------------
            */

            $totalCommentsCount = Comment::withTrashed()
                ->count();

            $pendingReportsCount = CommentReport::query()
                ->where(
                    'status',
                    'pending'
                )
                ->count();


            /*
            |--------------------------------------------------------------------------
            | STATISTIQUES MESSAGERIE
            |--------------------------------------------------------------------------
            */

            $totalConversationsCount = Conversation::query()
                ->count();


            /*
            | Une conversation est considérée comme ayant un nouveau message
            | lorsqu'elle possède au moins un message entrant non lu provenant
            | d'un visiteur ou d'un adhérent.
            */

            $unreadConversationsCount = Conversation::query()
                ->whereHas(
                    'messages',
                    function ($query) {
                        $query
                            ->where(
                                'is_read',
                                false
                            )
                            ->whereIn(
                                'sender_type',
                                [
                                    'visitor',
                                    'member',
                                ]
                            );
                    }
                )
                ->count();


            /*
            |--------------------------------------------------------------------------
            | AFFICHAGE DU DASHBOARD
            |--------------------------------------------------------------------------
            */

            return view(
                'admin.dashboard',
                compact(
                    'totalMembersCount',
                    'activeMembersCount',
                    'archivedMembersCount',
                    'newMembersThisMonthCount',
                    'membersMonthlyEvolution',
                    'totalCoursesCount',
                    'activeCoursesCount',
                    'inactiveCoursesCount',
                    'completedCoursesCount',
                    'deletedCoursesCount',
                    'totalArticlesCount',
                    'publishedArticlesCount',
                    'draftArticlesCount',
                    'totalCommentsCount',
                    'pendingReportsCount',
                    'totalConversationsCount',
                    'unreadConversationsCount',
                )
            );
        })->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | STATISTIQUES DES COOKIES
        |--------------------------------------------------------------------------
        |
        | Consultation des préférences enregistrées par les visiteurs.
        | La route hérite des middlewares auth et admin du groupe.
        |
        */

        Route::get(
            '/cookies',
            [AdminCookieConsentController::class, 'index']
        )->name('cookies.index');


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
        | SIGNALEMENTS DES COMMENTAIRES
        |--------------------------------------------------------------------------
        |
        | Cette partie permet à l'administration de consulter et de
        | modérer les signalements envoyés par les membres concernant
        | les commentaires du blog.
        |
        | L'administration peut :
        |
        | - consulter tous les signalements ;
        | - marquer un signalement comme examiné ;
        | - rejeter un signalement non justifié ;
        | - masquer le commentaire et résoudre un signalement justifié.
        |
        */


        /*
        |--------------------------------------------------------------------------
        | LISTE DES SIGNALEMENTS
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/signalements-commentaires',
            [AdminCommentReportController::class, 'index']
        )->name('comment-reports.index');


        /*
        |--------------------------------------------------------------------------
        | MARQUER UN SIGNALEMENT COMME EXAMINÉ
        |--------------------------------------------------------------------------
        |
        | Cette action indique que l'administration a pris connaissance
        | du signalement sans encore prendre de décision définitive
        | concernant le commentaire.
        |
        */

        Route::patch(
            '/signalements-commentaires/{report}/examiner',
            [AdminCommentReportController::class, 'review']
        )->name('comment-reports.review');


        /*
        |--------------------------------------------------------------------------
        | REJETER UN SIGNALEMENT
        |--------------------------------------------------------------------------
        |
        | Cette action est utilisée lorsque l'administration considère
        | que le signalement n'est pas justifié.
        |
        | Le commentaire concerné reste alors dans son état actuel.
        |
        */

        Route::patch(
            '/signalements-commentaires/{report}/rejeter',
            [AdminCommentReportController::class, 'reject']
        )->name('comment-reports.reject');


        /*
        |--------------------------------------------------------------------------
        | MASQUER LE COMMENTAIRE ET TRAITER LE SIGNALEMENT
        |--------------------------------------------------------------------------
        |
        | Cette action est utilisée lorsqu'un signalement est considéré
        | comme justifié.
        |
        | Le commentaire passe au statut "hidden" et le signalement
        | passe au statut "resolved".
        |
        */

        Route::patch(
            '/signalements-commentaires/{report}/traiter',
            [AdminCommentReportController::class, 'resolve']
        )->name('comment-reports.resolve');


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