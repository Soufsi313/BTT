<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;


/**
 * ================================================================
 * CONTRÔLEUR D'AUTHENTIFICATION
 * ================================================================
 *
 * Ce contrôleur gère notamment :
 *
 * - l'inscription ;
 * - la connexion ;
 * - la vérification de l'adresse email ;
 * - le profil de l'adhérent ;
 * - la modification de l'adresse email ;
 * - la modification du mot de passe ;
 * - la suppression logique du compte ;
 * - la déconnexion.
 *
 * ================================================================
 */
class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | AFFICHER LA PAGE D'INSCRIPTION
    |--------------------------------------------------------------------------
    */

    public function showRegister()
    {
        return view('register');
    }


    /*
    |--------------------------------------------------------------------------
    | ENREGISTRER UN NOUVEL ADHÉRENT
    |--------------------------------------------------------------------------
    */

    public function register(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDATION DES DONNÉES
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'nom' => [
                'required',
                'string',
                'max:100',
            ],

            'prenom' => [
                'required',
                'string',
                'max:100',
            ],

            'pseudo' => [
                'required',
                'string',
                'max:50',
                'unique:users,pseudo',
            ],

            'genre' => [
                'required',
                Rule::in([
                    'homme',
                    'femme',
                ]),
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'confirmed',
                Password::min(8),
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | CRÉATION DU COMPTE
        |--------------------------------------------------------------------------
        |
        | email_verified_at reste automatiquement à NULL.
        |
        | Le compte existe donc immédiatement, mais son adresse email
        | n'est pas encore considérée comme vérifiée.
        |
        */

        $user = User::create([
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'pseudo' => $validated['pseudo'],
            'genre' => $validated['genre'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);


        /*
        |--------------------------------------------------------------------------
        | CONNEXION AUTOMATIQUE
        |--------------------------------------------------------------------------
        |
        | L'utilisateur doit être authentifié afin que Laravel puisse
        | associer correctement le lien de vérification à son compte.
        |
        */

        Auth::login($user);

        $request->session()->regenerate();


        /*
        |--------------------------------------------------------------------------
        | ENVOI DE L'EMAIL DE VÉRIFICATION
        |--------------------------------------------------------------------------
        |
        | Le modèle User implémente maintenant MustVerifyEmail.
        |
        | Laravel génère donc une URL temporaire et signée permettant
        | de vérifier que l'utilisateur possède bien cette adresse.
        |
        */

        $user->sendEmailVerificationNotification();


        /*
        |--------------------------------------------------------------------------
        | REDIRECTION VERS LA PAGE DE VÉRIFICATION
        |--------------------------------------------------------------------------
        |
        | L'utilisateur reste connecté mais il est invité à vérifier
        | son adresse avant de poursuivre.
        |
        */

        return redirect()->route('verification.notice');
    }


    /*
    |--------------------------------------------------------------------------
    | PAGE DE CONFIRMATION D'INSCRIPTION
    |--------------------------------------------------------------------------
    |
    | Cette méthode est conservée afin de ne pas supprimer brutalement
    | une fonctionnalité existante du projet.
    |
    | Le nouveau processus d'inscription redirige cependant désormais
    | vers verification.notice.
    |
    */

    public function registerSuccess()
    {
        return view('register-success');
    }


    /*
    |--------------------------------------------------------------------------
    | AFFICHER LA PAGE DE CONNEXION
    |--------------------------------------------------------------------------
    */

    public function showLogin()
    {
        return view('login');
    }


    /*
    |--------------------------------------------------------------------------
    | CONNECTER UN UTILISATEUR
    |--------------------------------------------------------------------------
    */

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => [
                'required',
                'email',
            ],

            'password' => [
                'required',
                'string',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | CLÉ DU LIMITEUR DE TENTATIVES
        |--------------------------------------------------------------------------
        */

        $throttleKey =
            Str::lower($credentials['email'])
            . '|'
            . $request->ip();


        /*
        |--------------------------------------------------------------------------
        | UTILISATEUR DÉJÀ BLOQUÉ
        |--------------------------------------------------------------------------
        */

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {

            $seconds = RateLimiter::availableIn($throttleKey);

            return back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' =>
                        "Trop de tentatives de connexion. "
                        . "Réessayez dans {$seconds} seconde(s).",
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | OPTION "SE SOUVENIR DE MOI"
        |--------------------------------------------------------------------------
        */

        $remember = $request->boolean('remember');


        /*
        |--------------------------------------------------------------------------
        | TENTATIVE DE CONNEXION
        |--------------------------------------------------------------------------
        */

        if (Auth::attempt($credentials, $remember)) {

            RateLimiter::clear($throttleKey);

            $request->session()->regenerate();


            /*
            |--------------------------------------------------------------------------
            | UTILISATEUR NON ENCORE VÉRIFIÉ
            |--------------------------------------------------------------------------
            |
            | Si le compte existe mais que son adresse email n'est pas
            | encore vérifiée, l'utilisateur est envoyé vers la page
            | lui permettant de terminer la vérification.
            |
            */

            if (! $request->user()->hasVerifiedEmail()) {
                return redirect()->route('verification.notice');
            }


            /*
            |--------------------------------------------------------------------------
            | UTILISATEUR VÉRIFIÉ
            |--------------------------------------------------------------------------
            */

            return redirect('/');
        }


        /*
        |--------------------------------------------------------------------------
        | MAUVAISE TENTATIVE
        |--------------------------------------------------------------------------
        */

        RateLimiter::hit(
            $throttleKey,
            90
        );


        /*
        |--------------------------------------------------------------------------
        | CINQUIÈME MAUVAISE TENTATIVE
        |--------------------------------------------------------------------------
        */

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {

            $seconds = RateLimiter::availableIn($throttleKey);

            return back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' =>
                        "Trop de tentatives incorrectes. "
                        . "Connexion bloquée pendant {$seconds} seconde(s).",
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | ERREUR DE CONNEXION
        |--------------------------------------------------------------------------
        */

        return back()
            ->withInput($request->only('email'))
            ->withErrors([
                'email' => 'Adresse email ou mot de passe incorrect.',
            ]);
    }


    /*
    |--------------------------------------------------------------------------
    | AFFICHER LE PROFIL DE L'ADHÉRENT
    |--------------------------------------------------------------------------
    */

    public function showProfile()
    {
        return view('member.profile');
    }


    /*
    |--------------------------------------------------------------------------
    | METTRE À JOUR LE PROFIL DE L'ADHÉRENT
    |--------------------------------------------------------------------------
    */

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'nom' => [
                'required',
                'string',
                'max:100',
            ],

            'prenom' => [
                'required',
                'string',
                'max:100',
            ],

            'pseudo' => [
                'required',
                'string',
                'max:50',
                Rule::unique('users', 'pseudo')->ignore($user->id),
            ],

            'genre' => [
                'required',
                Rule::in([
                    'homme',
                    'femme',
                ]),
            ],
        ]);

        $user->update([
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'pseudo' => $validated['pseudo'],
            'genre' => $validated['genre'],
        ]);

        return redirect()
            ->route('member.profile')
            ->with(
                'success',
                'Vos informations ont bien été mises à jour.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | AFFICHER LA PAGE DE MODIFICATION DE L'EMAIL
    |--------------------------------------------------------------------------
    */

    public function showEmail()
    {
        return view('member.email');
    }


    /*
    |--------------------------------------------------------------------------
    | METTRE À JOUR L'ADRESSE EMAIL
    |--------------------------------------------------------------------------
    */

    public function updateEmail(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],

            'current_password' => [
                'required',
                'string',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | VÉRIFICATION DU MOT DE PASSE ACTUEL
        |--------------------------------------------------------------------------
        */

        if (! Hash::check(
            $validated['current_password'],
            $user->password
        )) {
            return back()
                ->withInput(
                    $request->only('email')
                )
                ->withErrors([
                    'current_password' =>
                        'Le mot de passe actuel est incorrect.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | ADRESSE EMAIL IDENTIQUE
        |--------------------------------------------------------------------------
        |
        | Si l'utilisateur soumet exactement la même adresse que celle
        | déjà enregistrée, nous ne devons pas remettre inutilement
        | email_verified_at à NULL.
        |
        */

        if (
            Str::lower($validated['email'])
            === Str::lower($user->email)
        ) {
            return redirect()
                ->route('member.email')
                ->with(
                    'success',
                    'Votre adresse email est déjà à jour.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | MISE À JOUR DE L'EMAIL
        |--------------------------------------------------------------------------
        |
        | Dès que l'adresse change, l'ancienne vérification ne doit plus
        | être considérée comme valable.
        |
        | email_verified_at est donc remis à NULL.
        |
        */

        $user->update([
            'email' => $validated['email'],
            'email_verified_at' => null,
        ]);


        /*
        |--------------------------------------------------------------------------
        | ENVOI DU NOUVEAU LIEN DE VÉRIFICATION
        |--------------------------------------------------------------------------
        |
        | Un nouveau lien est envoyé vers la nouvelle adresse email.
        |
        */

        $user->sendEmailVerificationNotification();


        /*
        |--------------------------------------------------------------------------
        | REDIRECTION
        |--------------------------------------------------------------------------
        |
        | L'utilisateur doit maintenant confirmer sa nouvelle adresse.
        |
        */

        return redirect()
            ->route('verification.notice')
            ->with(
                'status',
                'verification-link-sent'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | AFFICHER LA PAGE DE MODIFICATION DU MOT DE PASSE
    |--------------------------------------------------------------------------
    */

    public function showPassword()
    {
        return view('member.password');
    }


    /*
    |--------------------------------------------------------------------------
    | METTRE À JOUR LE MOT DE PASSE
    |--------------------------------------------------------------------------
    */

    public function updatePassword(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'current_password' => [
                'required',
                'string',
            ],

            'password' => [
                'required',
                'string',
                'confirmed',
                Password::min(8),
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | VÉRIFICATION DU MOT DE PASSE ACTUEL
        |--------------------------------------------------------------------------
        */

        if (! Hash::check(
            $validated['current_password'],
            $user->password
        )) {
            return back()
                ->withErrors([
                    'current_password' =>
                        'Le mot de passe actuel est incorrect.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | EMPÊCHER LA RÉUTILISATION DU MÊME MOT DE PASSE
        |--------------------------------------------------------------------------
        */

        if (Hash::check(
            $validated['password'],
            $user->password
        )) {
            return back()
                ->withErrors([
                    'password' =>
                        'Le nouveau mot de passe doit être différent du mot de passe actuel.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | MISE À JOUR DU MOT DE PASSE
        |--------------------------------------------------------------------------
        */

        $user->update([
            'password' => $validated['password'],
        ]);


        /*
        |--------------------------------------------------------------------------
        | RENOUVELLEMENT DE LA SESSION
        |--------------------------------------------------------------------------
        */

        $request->session()->regenerate();


        return redirect()
            ->route('member.password')
            ->with(
                'success',
                'Votre mot de passe a bien été modifié.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | AFFICHER LA PAGE DE SUPPRESSION DU COMPTE
    |--------------------------------------------------------------------------
    */

    public function showDeleteAccount()
    {
        return view('member.delete-account');
    }


    /*
    |--------------------------------------------------------------------------
    | SUPPRIMER LOGIQUEMENT LE COMPTE
    |--------------------------------------------------------------------------
    */

    public function deleteAccount(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | UTILISATEUR CONNECTÉ
        |--------------------------------------------------------------------------
        */

        $user = $request->user();


        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'current_password' => [
                'required',
                'string',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | VÉRIFICATION DU MOT DE PASSE
        |--------------------------------------------------------------------------
        */

        if (! Hash::check(
            $validated['current_password'],
            $user->password
        )) {
            return back()
                ->withErrors([
                    'current_password' =>
                        'Le mot de passe actuel est incorrect.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | SUPPRESSION LOGIQUE
        |--------------------------------------------------------------------------
        |
        | Comme le modèle User utilise SoftDeletes, Laravel ne supprime
        | pas immédiatement la ligne de la base de données.
        |
        | La colonne deleted_at reçoit une date.
        |
        | Le compte n'est ensuite plus considéré comme actif par Laravel.
        |
        */

        $user->delete();


        /*
        |--------------------------------------------------------------------------
        | DÉCONNEXION IMMÉDIATE
        |--------------------------------------------------------------------------
        */

        Auth::logout();


        /*
        |--------------------------------------------------------------------------
        | INVALIDATION DE LA SESSION
        |--------------------------------------------------------------------------
        */

        $request->session()->invalidate();

        $request->session()->regenerateToken();


        /*
        |--------------------------------------------------------------------------
        | PAGE DE CONFIRMATION
        |--------------------------------------------------------------------------
        */

        return redirect()->route('account.deleted');
    }


    /*
    |--------------------------------------------------------------------------
    | PAGE DE CONFIRMATION DE SUPPRESSION
    |--------------------------------------------------------------------------
    */

    public function accountDeleted()
    {
        return view('member.account-deleted');
    }


    /*
    |--------------------------------------------------------------------------
    | DÉCONNEXION
    |--------------------------------------------------------------------------
    */

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}