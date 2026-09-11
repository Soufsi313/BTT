<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /*
    |--------------------------------------------------------------------------
    | PROTECTION DE L'ESPACE ADMINISTRATION
    |--------------------------------------------------------------------------
    |
    | Ce middleware vérifie que :
    |
    | 1. Un utilisateur est bien connecté.
    | 2. Son rôle lui permet d'accéder à l'administration.
    |
    | Les rôles autorisés sont :
    |
    | - admin
    | - super_admin
    |
    | Un simple adhérent ne peut donc jamais accéder aux routes protégées
    | par ce middleware.
    |
    */
    public function handle(
        Request $request,
        Closure $next
    ): Response {
        /*
        |--------------------------------------------------------------------------
        | RÉCUPÉRATION DE L'UTILISATEUR CONNECTÉ
        |--------------------------------------------------------------------------
        */
        $user = $request->user();


        /*
        |--------------------------------------------------------------------------
        | AUCUN UTILISATEUR CONNECTÉ
        |--------------------------------------------------------------------------
        |
        | Normalement le middleware "auth" interviendra déjà avant celui-ci.
        | Cette vérification supplémentaire garde néanmoins notre middleware
        | sécurisé même s'il était utilisé seul par erreur.
        |
        */
        if (! $user) {
            return redirect()->route('login');
        }


        /*
        |--------------------------------------------------------------------------
        | VÉRIFICATION DU DROIT D'ACCÈS
        |--------------------------------------------------------------------------
        |
        | La méthode canAccessAdmin() se trouve dans le modèle User.
        |
        | Elle autorise :
        |
        | - les Admins
        | - les Super Admins
        |
        */
        if (! $user->canAccessAdmin()) {
            abort(
                403,
                'Vous n’êtes pas autorisé à accéder à l’administration.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | ACCÈS AUTORISÉ
        |--------------------------------------------------------------------------
        */
        return $next($request);
    }
}