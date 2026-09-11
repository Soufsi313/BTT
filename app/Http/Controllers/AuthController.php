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
        | CLÉ DU LIMITEUR
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
        |
        | Pour le pseudo, on vérifie qu'il reste unique.
        |
        | Mais Laravel doit ignorer le pseudo de l'utilisateur actuel,
        | sinon il considérerait son propre pseudo comme un doublon.
        |
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


        /*
        |--------------------------------------------------------------------------
        | MISE À JOUR DES INFORMATIONS
        |--------------------------------------------------------------------------
        */
        $user->update([
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'pseudo' => $validated['pseudo'],
            'genre' => $validated['genre'],
        ]);


        /*
        |--------------------------------------------------------------------------
        | RETOUR SUR LA PAGE PROFIL
        |--------------------------------------------------------------------------
        */
        return redirect()
            ->route('member.profile')
            ->with(
                'success',
                'Vos informations ont bien été mises à jour.'
            );
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