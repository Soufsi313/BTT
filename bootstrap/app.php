<?php

use App\Http\Middleware\AdminMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(
    basePath: dirname(__DIR__)
)
    /*
    |--------------------------------------------------------------------------
    | ROUTES DE L'APPLICATION
    |--------------------------------------------------------------------------
    */
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )


    /*
    |--------------------------------------------------------------------------
    | MIDDLEWARES
    |--------------------------------------------------------------------------
    |
    | Nous créons ici l'alias "admin".
    |
    | Grâce à cet alias, nous pourrons protéger les routes ainsi :
    |
    | ->middleware(['auth', 'admin'])
    |
    */
    ->withMiddleware(function (Middleware $middleware): void {

        $middleware->alias([
            'admin' => AdminMiddleware::class,
        ]);

    })


    /*
    |--------------------------------------------------------------------------
    | GESTION DES EXCEPTIONS
    |--------------------------------------------------------------------------
    */
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })


    /*
    |--------------------------------------------------------------------------
    | CRÉATION DE L'APPLICATION
    |--------------------------------------------------------------------------
    */
    ->create();