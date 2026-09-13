<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


/**
 * ================================================================
 * CONTRÔLEUR D'UPLOAD DES IMAGES INTERNES DES ARTICLES
 * ================================================================
 *
 * Ce contrôleur est destiné aux images ajoutées directement
 * à l'intérieur du contenu d'un article avec l'éditeur Quill.
 *
 * Exemple :
 *
 * Texte
 * Texte
 * [IMAGE]
 * Texte
 *
 * Les images ne sont PAS enregistrées directement dans MySQL.
 *
 * Elles sont enregistrées physiquement dans :
 *
 * storage/app/public/articles/content/
 *
 * Puis Quill reçoit l'URL publique de l'image et l'insère
 * dans le HTML de l'article.
 *
 * ================================================================
 */
class AdminArticleImageController extends Controller
{
    /**
     * ============================================================
     * ENREGISTRER UNE IMAGE
     * ============================================================
     *
     * Cette méthode reçoit l'image envoyée depuis Quill.
     *
     * Elle :
     *
     * 1. vérifie le fichier ;
     * 2. vérifie son format ;
     * 3. limite sa taille ;
     * 4. l'enregistre dans le stockage public ;
     * 5. renvoie son URL au JavaScript.
     *
     * ============================================================
     */
    public function store(Request $request): JsonResponse
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDATION DE L'IMAGE
        |--------------------------------------------------------------------------
        |
        | Le champ envoyé par notre JavaScript s'appellera "image".
        |
        | Formats autorisés :
        |
        | - JPG / JPEG
        | - PNG
        | - WEBP
        |
        | Taille maximale :
        |
        | 5 Mo
        |
        */

        $validated = $request->validate([
            'image' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | ENREGISTREMENT DU FICHIER
        |--------------------------------------------------------------------------
        |
        | Laravel génère automatiquement un nom de fichier unique.
        |
        | Le fichier sera placé dans :
        |
        | storage/app/public/articles/content/
        |
        */

        $path = $validated['image']->store(
            'articles/content',
            'public'
        );


        /*
        |--------------------------------------------------------------------------
        | URL PUBLIQUE
        |--------------------------------------------------------------------------
        |
        | Grâce au lien symbolique créé précédemment avec :
        |
        | php artisan storage:link
        |
        | l'image devient accessible depuis :
        |
        | /storage/articles/content/nom-image.jpg
        |
        */

        $url = asset(
            'storage/' . $path
        );


        /*
        |--------------------------------------------------------------------------
        | RÉPONSE JSON POUR QUILL
        |--------------------------------------------------------------------------
        |
        | Notre JavaScript récupérera cette URL et dira ensuite à Quill :
        |
        | "Insère cette image à l'endroit où se trouve le curseur."
        |
        */

        return response()->json([
            'success' => true,
            'url' => $url,
            'path' => $path,
        ]);
    }
}