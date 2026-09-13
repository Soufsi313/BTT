<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Nouvelle réponse - Brussels Top Team
    </title>

</head>


<body
    style="
        margin: 0;
        padding: 0;
        background-color: #111111;
        font-family: Arial, Helvetica, sans-serif;
        color: #ffffff;
    "
>

    <!-- =========================================================
         CONTENEUR GLOBAL
         ========================================================= -->
    <table
        role="presentation"
        width="100%"
        cellspacing="0"
        cellpadding="0"
        border="0"
        style="
            width: 100%;
            background-color: #111111;
            padding: 40px 15px;
        "
    >

        <tr>

            <td align="center">


                <!-- =================================================
                     EMAIL
                     ================================================= -->
                <table
                    role="presentation"
                    width="100%"
                    cellspacing="0"
                    cellpadding="0"
                    border="0"
                    style="
                        width: 100%;
                        max-width: 620px;
                        background-color: #18181b;
                        border: 1px solid #27272a;
                    "
                >


                    <!-- =============================================
                         HEADER BTT
                         ============================================= -->
                    <tr>

                        <td
                            align="center"
                            style="
                                background-color: #000000;
                                border-bottom: 3px solid #e30613;
                                padding: 30px 25px;
                            "
                        >

                            <!-- =====================================
                                 LOGO
                                 =====================================
                                 Le logo est intégré directement
                                 dans l'email.
                                 ===================================== -->
                            <img
                                src="{{ $message->embed(
                                    public_path('images/BTTboxe.png')
                                ) }}"
                                alt="Brussels Top Team"
                                width="90"
                                style="
                                    display: block;
                                    width: 90px;
                                    max-width: 90px;
                                    height: auto;
                                    margin: 0 auto;
                                    border: 0;
                                "
                            >


                            <div
                                style="
                                    margin-top: 18px;
                                    font-size: 20px;
                                    font-weight: 900;
                                    text-transform: uppercase;
                                    letter-spacing: 1px;
                                    color: #ffffff;
                                "
                            >
                                Brussels Top Team
                            </div>


                            <div
                                style="
                                    margin-top: 6px;
                                    font-size: 11px;
                                    font-weight: bold;
                                    text-transform: uppercase;
                                    letter-spacing: 2px;
                                    color: #e30613;
                                "
                            >
                                Plus qu'un club
                            </div>

                        </td>

                    </tr>


                    <!-- =============================================
                         CONTENU PRINCIPAL
                         ============================================= -->
                    <tr>

                        <td
                            style="
                                padding: 40px 35px;
                            "
                        >

                            <!-- =====================================
                                 PETIT TITRE
                                 ===================================== -->
                            <div
                                style="
                                    margin-bottom: 12px;
                                    font-size: 11px;
                                    font-weight: 900;
                                    text-transform: uppercase;
                                    letter-spacing: 2px;
                                    color: #e30613;
                                "
                            >
                                Messagerie BTT
                            </div>


                            <!-- =====================================
                                 TITRE
                                 ===================================== -->
                            <h1
                                style="
                                    margin: 0;
                                    font-size: 26px;
                                    line-height: 1.2;
                                    font-weight: 900;
                                    text-transform: uppercase;
                                    color: #ffffff;
                                "
                            >
                                Vous avez reçu une nouvelle réponse
                            </h1>


                            <!-- =====================================
                                 SALUTATION
                                 ===================================== -->
                            <p
                                style="
                                    margin: 28px 0 0;
                                    font-size: 15px;
                                    line-height: 1.7;
                                    color: #d4d4d8;
                                "
                            >
                                Bonjour
                                <strong style="color: #ffffff;">
                                    {{ $conversation->name }}
                                </strong>,
                            </p>


                            <p
                                style="
                                    margin: 12px 0 0;
                                    font-size: 15px;
                                    line-height: 1.7;
                                    color: #a1a1aa;
                                "
                            >
                                L'administration Brussels Top Team vient
                                de répondre à votre conversation.
                            </p>


                            <!-- =====================================
                                 SUJET DE LA CONVERSATION
                                 ===================================== -->
                            <table
                                role="presentation"
                                width="100%"
                                cellspacing="0"
                                cellpadding="0"
                                border="0"
                                style="
                                    width: 100%;
                                    margin-top: 30px;
                                    border-left: 4px solid #e30613;
                                    background-color: #09090b;
                                "
                            >

                                <tr>

                                    <td
                                        style="
                                            padding: 18px 20px;
                                        "
                                    >

                                        <div
                                            style="
                                                font-size: 10px;
                                                font-weight: 900;
                                                text-transform: uppercase;
                                                letter-spacing: 1.5px;
                                                color: #71717a;
                                            "
                                        >
                                            Sujet
                                        </div>


                                        <div
                                            style="
                                                margin-top: 8px;
                                                font-size: 15px;
                                                font-weight: 700;
                                                color: #ffffff;
                                            "
                                        >

                                            @switch($conversation->subject)

                                                @case('abonnement')
                                                    Abonnements / Affiliation
                                                    @break

                                                @case('entrainements')
                                                    Nos entraînements
                                                    @break

                                                @case('compte')
                                                    Inscription / Compte
                                                    @break

                                                @default
                                                    Autre demande

                                            @endswitch

                                        </div>

                                    </td>

                                </tr>

                            </table>


                            <!-- =====================================
                                 RÉPONSE DE L'ADMINISTRATION
                                 ===================================== -->
                            <div
                                style="
                                    margin-top: 30px;
                                    font-size: 11px;
                                    font-weight: 900;
                                    text-transform: uppercase;
                                    letter-spacing: 1.5px;
                                    color: #71717a;
                                "
                            >
                                Réponse de l'administration
                            </div>


                            <div
                                style="
                                    margin-top: 12px;
                                    padding: 22px;
                                    border: 1px solid #3f3f46;
                                    background-color: #27272a;
                                    font-size: 15px;
                                    line-height: 1.7;
                                    color: #e4e4e7;
                                    white-space: pre-line;
                                "
                            >{{ $adminMessage->body }}</div>


                            <!-- =====================================
                                 BOUTON POUR LES ADHÉRENTS
                                 =====================================
                                 Le bouton n'est affiché que lorsque
                                 la conversation appartient à un
                                 compte utilisateur BTT.
                                 ===================================== -->
                            @if ($conversation->user_id)

                                <table
                                    role="presentation"
                                    cellspacing="0"
                                    cellpadding="0"
                                    border="0"
                                    style="
                                        margin-top: 35px;
                                    "
                                >

                                    <tr>

                                        <td
                                            align="center"
                                            style="
                                                background-color: #e30613;
                                            "
                                        >

                                            <a
                                                href="{{ route(
                                                    'member.messages.show',
                                                    $conversation
                                                ) }}"
                                                style="
                                                    display: inline-block;
                                                    padding: 15px 24px;
                                                    font-size: 12px;
                                                    font-weight: 900;
                                                    text-transform: uppercase;
                                                    letter-spacing: 1px;
                                                    text-decoration: none;
                                                    color: #ffffff;
                                                "
                                            >
                                                Consulter ma conversation
                                            </a>

                                        </td>

                                    </tr>

                                </table>

                            @endif


                            <!-- =====================================
                                 INFORMATION
                                 ===================================== -->
                            <p
                                style="
                                    margin: 30px 0 0;
                                    font-size: 13px;
                                    line-height: 1.7;
                                    color: #71717a;
                                "
                            >
                                Cet email est une notification automatique
                                envoyée par Brussels Top Team.
                            </p>

                        </td>

                    </tr>


                    <!-- =============================================
                         FOOTER
                         ============================================= -->
                    <tr>

                        <td
                            style="
                                border-top: 1px solid #27272a;
                                background-color: #09090b;
                                padding: 25px 35px;
                                text-align: center;
                            "
                        >

                            <div
                                style="
                                    font-size: 12px;
                                    font-weight: 900;
                                    text-transform: uppercase;
                                    letter-spacing: 1px;
                                    color: #ffffff;
                                "
                            >
                                Brussels Top Team
                            </div>


                            <div
                                style="
                                    margin-top: 6px;
                                    font-size: 11px;
                                    color: #71717a;
                                "
                            >
                                Plus qu'un club
                            </div>


                            <div
                                style="
                                    margin-top: 14px;
                                    font-size: 10px;
                                    line-height: 1.5;
                                    color: #52525b;
                                "
                            >
                                Vous recevez cet email car une nouvelle réponse
                                a été publiée dans une conversation BTT liée
                                à votre adresse email.
                            </div>

                        </td>

                    </tr>

                </table>

            </td>

        </tr>

    </table>

</body>

</html>