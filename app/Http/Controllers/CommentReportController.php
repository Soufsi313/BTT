<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentReport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


/**
 * ================================================================
 * CONTRÔLEUR DES SIGNALEMENTS DE COMMENTAIRES
 * ================================================================
 *
 * Ce contrôleur gère les signalements effectués par les membres
 * connectés sur les commentaires du blog Brussels Top Team.
 *
 * Pour cette première version, il permet :
 *
 * - de vérifier que le commentaire existe ;
 * - de vérifier que le commentaire appartient bien à l'article ;
 * - de valider le motif du signalement ;
 * - d'enregistrer le signalement ;
 * - d'empêcher un membre de signaler plusieurs fois
 *   le même commentaire.
 *
 * La modération des signalements sera ajoutée ensuite
 * dans l'espace administration.
 *
 * ================================================================
 */
class CommentReportController extends Controller
{
    /**
     * ============================================================
     * ENREGISTRER UN SIGNALEMENT
     * ============================================================
     *
     * Cette méthode sera appelée depuis le bouton "Signaler"
     * affiché sous un commentaire.
     *
     * Seuls les utilisateurs authentifiés pourront atteindre
     * cette méthode grâce au middleware "auth" qui sera ajouté
     * sur la route.
     *
     * ============================================================
     */
    public function store(
        Request $request,
        string $slug,
        Comment $comment
    ): RedirectResponse {

        /*
        |--------------------------------------------------------------------------
        | Vérification du commentaire
        |--------------------------------------------------------------------------
        |
        | Nous vérifions que le commentaire appartient réellement
        | à l'article présent dans l'URL.
        |
        | Cela évite qu'une personne tente de modifier manuellement
        | l'identifiant du commentaire dans l'URL pour signaler
        | un commentaire appartenant à un autre article.
        |
        */

        $comment->loadMissing('article');

        if (
            !$comment->article
            || $comment->article->slug !== $slug
        ) {
            abort(404);
        }


        /*
        |--------------------------------------------------------------------------
        | Vérification de la visibilité de l'article
        |--------------------------------------------------------------------------
        |
        | Un signalement public ne doit pouvoir être effectué que
        | depuis un article actuellement publié.
        |
        */

        if (
            $comment->article->status !== 'published'
            || $comment->article->published_at === null
            || $comment->article->published_at->isFuture()
        ) {
            abort(404);
        }


        /*
        |--------------------------------------------------------------------------
        | Vérification du commentaire
        |--------------------------------------------------------------------------
        |
        | Un commentaire masqué par l'administration ne doit plus
        | pouvoir recevoir de nouveaux signalements depuis le site.
        |
        */

        if (!$comment->isPublished()) {
            abort(404);
        }


        /*
        |--------------------------------------------------------------------------
        | Validation du formulaire
        |--------------------------------------------------------------------------
        |
        | Les motifs autorisés correspondent aux valeurs que nous
        | proposerons dans le futur formulaire de signalement.
        |
        | "details" reste facultatif et permet au membre d'expliquer
        | plus précisément la raison de son signalement.
        |
        */

        $validated = $request->validate([
            'reason' => [
                'required',
                'string',
                'in:insultes,harcelement,spam,contenu_inapproprie,autre',
            ],

            'details' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Utilisateur connecté
        |--------------------------------------------------------------------------
        */

        $user = $request->user();


        /*
        |--------------------------------------------------------------------------
        | Vérification d'un éventuel signalement existant
        |--------------------------------------------------------------------------
        |
        | La base de données possède déjà une contrainte UNIQUE sur :
        |
        | comment_id + user_id
        |
        | Nous faisons néanmoins cette vérification ici afin
        | d'afficher un message propre au membre plutôt qu'une
        | erreur SQL si celui-ci essaie de signaler deux fois
        | le même commentaire.
        |
        */

        $existingReport = CommentReport::query()
            ->where('comment_id', $comment->id)
            ->where('user_id', $user->id)
            ->exists();


        /*
        |--------------------------------------------------------------------------
        | Signalement déjà effectué
        |--------------------------------------------------------------------------
        */

        if ($existingReport) {
            return redirect()
                ->route(
                    'blog.show',
                    $comment->article->slug
                )
                ->with(
                    'report_error',
                    'Vous avez déjà signalé ce commentaire.'
                )
                ->withFragment('commentaires');
        }


        /*
        |--------------------------------------------------------------------------
        | Création du signalement
        |--------------------------------------------------------------------------
        |
        | Tout nouveau signalement reçoit automatiquement le statut
        | "pending".
        |
        | Même si la base de données possède déjà cette valeur
        | par défaut, nous l'indiquons explicitement ici afin que
        | le comportement du contrôleur reste facile à comprendre.
        |
        */

        CommentReport::create([
            'comment_id' => $comment->id,
            'user_id' => $user->id,
            'reason' => $validated['reason'],
            'details' => $validated['details'] ?? null,
            'status' => 'pending',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Retour vers les commentaires
        |--------------------------------------------------------------------------
        |
        | Après le signalement, le membre revient directement
        | dans la section commentaires de l'article.
        |
        */

        return redirect()
            ->route(
                'blog.show',
                $comment->article->slug
            )
            ->with(
                'report_success',
                'Merci. Votre signalement a bien été transmis à l’administration.'
            )
            ->withFragment('commentaires');
    }
}