<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


/**
 * ================================================================
 * CONTRÔLEUR DES COMMENTAIRES PUBLICS
 * ================================================================
 *
 * Ce contrôleur gère les commentaires publiés sous les articles
 * du blog Brussels Top Team.
 *
 * Pour le moment, il permet :
 *
 * - à un utilisateur connecté de publier un commentaire ;
 * - de vérifier que l'article est bien public ;
 * - de valider le contenu avant enregistrement.
 *
 * Plus tard, nous ajouterons :
 *
 * - la modération administrateur ;
 * - les signalements ;
 * - éventuellement la suppression par l'auteur si on le souhaite.
 *
 * ================================================================
 */
class CommentController extends Controller
{
    /**
     * ============================================================
     * ENREGISTRER UN NOUVEAU COMMENTAIRE
     * ============================================================
     */
    public function store(
        Request $request,
        string $slug
    ): RedirectResponse {

        /*
        |--------------------------------------------------------------------------
        | VÉRIFICATION DE L'ARTICLE
        |--------------------------------------------------------------------------
        |
        | On autorise les commentaires uniquement sur un article :
        |
        | - existant ;
        | - publié ;
        | - possédant une date de publication ;
        | - déjà visible publiquement.
        |
        */

        $article = Article::query()
            ->where('slug', $slug)
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where(
                'published_at',
                '<=',
                now()
            )
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | VALIDATION DU COMMENTAIRE
        |--------------------------------------------------------------------------
        |
        | Pour commencer :
        |
        | - commentaire obligatoire ;
        | - texte uniquement ;
        | - maximum 2000 caractères.
        |
        */

        $validated = $request->validate([
            'body' => [
                'required',
                'string',
                'max:2000',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | CRÉATION DU COMMENTAIRE
        |--------------------------------------------------------------------------
        |
        | L'utilisateur est récupéré directement depuis la session Laravel.
        |
        | On ne fait donc jamais confiance à un user_id envoyé
        | par le navigateur.
        |
        */

        Comment::create([
            'article_id' => $article->id,
            'user_id' => $request->user()->id,
            'body' => $validated['body'],
            'status' => 'published',
        ]);


        /*
        |--------------------------------------------------------------------------
        | RETOUR SUR L'ARTICLE
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'blog.show',
                $article->slug
            )
            ->with(
                'success',
                'Votre commentaire a bien été publié.'
            );
    }
}