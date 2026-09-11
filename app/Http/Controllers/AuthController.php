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
    | PAGE DE CONFIRMATION D'INSCRIPTION
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
        | MISE À JOUR DE L'EMAIL
        |--------------------------------------------------------------------------
        */
        $user->update([
            'email' => $validated['email'],
        ]);

        return redirect()
            ->route('member.email')
            ->with(
                'success',
                'Votre adresse email a bien été mise à jour.'
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
        /*
        |--------------------------------------------------------------------------
        | UTILISATEUR CONNECTÉ
        |--------------------------------------------------------------------------
        */
        $user = $request->user();


        /*
        |--------------------------------------------------------------------------
        | VALIDATION DU FORMULAIRE
        |--------------------------------------------------------------------------
        |
        | "confirmed" vérifie automatiquement que :
        |
        | password
        |
        | correspond bien à :
        |
        | password_confirmation
        |
        */
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
        | EMPÊCHER DE RÉUTILISER LE MÊME MOT DE PASSE
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
        |
        | Le modèle User possède le cast "hashed".
        |
        | Laravel chiffre donc automatiquement le nouveau mot de passe
        | avant son enregistrement dans la base de données.
        |
        */
        $user->update([
            'password' => $validated['password'],
        ]);


        /*
        |--------------------------------------------------------------------------
        | RENOUVELLEMENT DE LA SESSION
        |--------------------------------------------------------------------------
        |
        | On régénère l'identifiant de session après cette opération
        | sensible.
        |
        */
        $request->session()->regenerate();


        /*
        |--------------------------------------------------------------------------
        | CONFIRMATION
        |--------------------------------------------------------------------------
        */
        return redirect()
            ->route('member.password')
            ->with(
                'success',
                'Votre mot de passe a bien été modifié.'
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