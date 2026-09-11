<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

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
        */
        Auth::login($user);

        $request->session()->regenerate();


        /*
        |--------------------------------------------------------------------------
        | REDIRECTION
        |--------------------------------------------------------------------------
        */
        return redirect()->route('register.success');
    }


    /*
    |--------------------------------------------------------------------------
    | PAGE DE CONFIRMATION
    |--------------------------------------------------------------------------
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
    |
    | 5 mauvaises tentatives maximum.
    |
    | Après la cinquième mauvaise tentative :
    |
    | blocage pendant 90 secondes.
    |
    */
    public function login(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */
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
        | CLÉ DU LIMITEUR
        |--------------------------------------------------------------------------
        |
        | Le compteur dépend :
        |
        | - de l'adresse email ;
        | - de l'adresse IP.
        |
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

            /*
            |--------------------------------------------------------------------------
            | CONNEXION RÉUSSIE
            |--------------------------------------------------------------------------
            */
            RateLimiter::clear($throttleKey);

            $request->session()->regenerate();

            return redirect('/');
        }


        /*
        |--------------------------------------------------------------------------
        | MAUVAISE TENTATIVE
        |--------------------------------------------------------------------------
        |
        | On ajoute une tentative et Laravel conserve ce compteur
        | pendant 90 secondes.
        |
        */
        RateLimiter::hit(
            $throttleKey,
            90
        );


        /*
        |--------------------------------------------------------------------------
        | CINQUIÈME MAUVAISE TENTATIVE
        |--------------------------------------------------------------------------
        |
        | Si nous venons d'atteindre cinq erreurs,
        | on affiche immédiatement le blocage.
        |
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
        | ERREUR CLASSIQUE AVANT LE BLOCAGE
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