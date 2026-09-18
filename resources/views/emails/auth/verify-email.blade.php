{{-- 
|--------------------------------------------------------------------------
| EMAIL DE VÉRIFICATION BTT
|--------------------------------------------------------------------------
|
| Template HTML envoyé lorsqu'un nouvel adhérent doit confirmer
| son adresse email.
|
| IMPORTANT :
|
| Un email ne doit pas dépendre de Tailwind ou de Vite.
| Les styles sont donc directement intégrés dans le HTML afin
| d'améliorer la compatibilité avec les différents clients email.
|
--}}

<!DOCTYPE html>

<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Vérifiez votre adresse email - Brussels Top Team
    </title>

</head>


<body
    style="
        margin: 0;
        padding: 0;
        background-color: #09090b;
        font-family: Arial, Helvetica, sans-serif;
        color: #ffffff;
    "
>

    {{-- ============================================================
         FOND GÉNÉRAL
         ============================================================ --}}

    <table
        role="presentation"
        width="100%"
        cellspacing="0"
        cellpadding="0"
        border="0"
        style="
            width: 100%;
            background-color: #09090b;
            margin: 0;
            padding: 0;
        "
    >

        <tr>

            <td
                align="center"
                style="
                    padding: 32px 12px;
                "
            >


                {{-- =================================================
                     CONTENEUR PRINCIPAL
                     ================================================= --}}

                <table
                    role="presentation"
                    width="600"
                    cellspacing="0"
                    cellpadding="0"
                    border="0"
                    style="
                        width: 100%;
                        max-width: 600px;
                        background-color: #111113;
                        border-collapse: collapse;
                    "
                >


                    {{-- =============================================
                         BARRE ROUGE SUPÉRIEURE
                         ============================================= --}}

                    <tr>

                        <td
                            style="
                                height: 6px;
                                background-color: #dc2626;
                                font-size: 0;
                                line-height: 0;
                            "
                        >
                            &nbsp;
                        </td>

                    </tr>


                    {{-- =============================================
                         IDENTITÉ BTT
                         ============================================= --}}

                    <tr>

                        <td
                            align="center"
                            style="
                                padding: 36px 30px 28px 30px;
                                background-color: #0c0c0e;
                            "
                        >

                            <div
                                style="
                                    font-size: 44px;
                                    line-height: 48px;
                                    font-weight: 900;
                                    font-style: italic;
                                    letter-spacing: -3px;
                                "
                            >
                                <span style="color: #dc2626;">
                                    B
                                </span>

                                <span style="color: #ffffff;">
                                    T
                                </span>

                                <span style="color: #dc2626;">
                                    T
                                </span>
                            </div>


                            <div
                                style="
                                    margin-top: 6px;
                                    font-size: 18px;
                                    line-height: 24px;
                                    font-weight: 800;
                                    letter-spacing: 1px;
                                    color: #ffffff;
                                    text-transform: uppercase;
                                "
                            >
                                Brussels

                                <span style="color: #dc2626;">
                                    Top Team
                                </span>
                            </div>


                            <div
                                style="
                                    margin-top: 12px;
                                    font-size: 11px;
                                    line-height: 18px;
                                    letter-spacing: 3px;
                                    color: #a1a1aa;
                                    text-transform: uppercase;
                                "
                            >
                                Discipline • Respect • Progression
                            </div>

                        </td>

                    </tr>


                    {{-- =============================================
                         TITRE PRINCIPAL
                         ============================================= --}}

                    <tr>

                        <td
                            style="
                                padding:
                                    38px
                                    40px
                                    20px
                                    40px;
                            "
                        >

                            <div
                                style="
                                    width: 48px;
                                    height: 4px;
                                    margin-bottom: 18px;
                                    background-color: #dc2626;
                                "
                            >
                            </div>


                            <div
                                style="
                                    font-size: 28px;
                                    line-height: 36px;
                                    font-weight: 900;
                                    text-transform: uppercase;
                                    color: #ffffff;
                                "
                            >
                                Vérifiez votre

                                <br>

                                <span style="color: #ef4444;">
                                    adresse email
                                </span>
                            </div>

                        </td>

                    </tr>


                    {{-- =============================================
                         MESSAGE PERSONNALISÉ
                         ============================================= --}}

                    <tr>

                        <td
                            style="
                                padding:
                                    10px
                                    40px
                                    0
                                    40px;

                                font-size: 16px;
                                line-height: 26px;
                                color: #d4d4d8;
                            "
                        >

                            <p
                                style="
                                    margin:
                                        0
                                        0
                                        20px
                                        0;

                                    color: #ffffff;
                                    font-weight: 700;
                                "
                            >
                                Bonjour {{ $user->prenom }},
                            </p>


                            <p
                                style="
                                    margin:
                                        0
                                        0
                                        18px
                                        0;
                                "
                            >
                                Merci pour votre inscription sur

                                <strong style="color: #ef4444;">
                                    Brussels Top Team
                                </strong>.
                            </p>


                            <p
                                style="
                                    margin:
                                        0
                                        0
                                        18px
                                        0;
                                "
                            >
                                Votre compte a bien été créé.

                                Pour finaliser votre inscription et accéder
                                aux fonctionnalités réservées aux adhérents,
                                nous devons maintenant vérifier que cette
                                adresse email vous appartient.
                            </p>


                            {{-- =====================================
                                 ADRESSE CONCERNÉE
                                 ===================================== --}}

                            <div
                                style="
                                    margin:
                                        24px
                                        0
                                        0
                                        0;

                                    padding: 16px 18px;

                                    background-color: #09090b;

                                    border:
                                        1px
                                        solid
                                        #27272a;

                                    border-left:
                                        4px
                                        solid
                                        #dc2626;
                                "
                            >

                                <div
                                    style="
                                        margin-bottom: 5px;
                                        font-size: 11px;
                                        line-height: 16px;
                                        letter-spacing: 1px;
                                        text-transform: uppercase;
                                        color: #71717a;
                                    "
                                >
                                    Adresse à vérifier
                                </div>


                                <div
                                    style="
                                        font-size: 15px;
                                        line-height: 22px;
                                        font-weight: 700;
                                        color: #ffffff;
                                        word-break: break-all;
                                    "
                                >
                                    {{ $user->email }}
                                </div>

                            </div>

                        </td>

                    </tr>


                    {{-- =============================================
                         BOUTON DE VÉRIFICATION
                         ============================================= --}}

                    <tr>

                        <td
                            align="center"
                            style="
                                padding:
                                    34px
                                    40px
                                    26px
                                    40px;
                            "
                        >

                            <table
                                role="presentation"
                                cellspacing="0"
                                cellpadding="0"
                                border="0"
                                align="center"
                            >

                                <tr>

                                    <td
                                        align="center"
                                        bgcolor="#dc2626"
                                        style="
                                            background-color: #dc2626;
                                            border-radius: 6px;
                                        "
                                    >

                                        <a
                                            href="{{ $verificationUrl }}"
                                            target="_blank"
                                            style="
                                                display: inline-block;
                                                padding: 16px 28px;
                                                font-size: 14px;
                                                line-height: 20px;
                                                font-weight: 800;
                                                letter-spacing: 0.4px;
                                                color: #ffffff;
                                                text-decoration: none;
                                                text-transform: uppercase;
                                            "
                                        >
                                            Vérifier mon adresse email
                                        </a>

                                    </td>

                                </tr>

                            </table>

                        </td>

                    </tr>


                    {{-- =============================================
                         SÉCURITÉ
                         ============================================= --}}

                    <tr>

                        <td
                            align="center"
                            style="
                                padding:
                                    0
                                    40px
                                    34px
                                    40px;

                                font-size: 13px;
                                line-height: 21px;
                                color: #a1a1aa;
                            "
                        >

                            Ce lien est personnel et sécurisé.

                            <br>

                            Il restera valide pendant une durée limitée.

                            <br><br>

                            Si vous n'êtes pas à l'origine de cette
                            inscription, vous pouvez simplement ignorer
                            cet email.

                        </td>

                    </tr>


                    {{-- =============================================
                         SÉPARATEUR
                         ============================================= --}}

                    <tr>

                        <td
                            style="
                                padding:
                                    0
                                    40px;
                            "
                        >

                            <div
                                style="
                                    height: 1px;
                                    background-color: #27272a;
                                "
                            >
                            </div>

                        </td>

                    </tr>


                    {{-- =============================================
                         VALEURS BTT
                         ============================================= --}}

                    <tr>

                        <td
                            style="
                                padding:
                                    32px
                                    30px;
                            "
                        >

                            <table
                                role="presentation"
                                width="100%"
                                cellspacing="0"
                                cellpadding="0"
                                border="0"
                            >

                                <tr>


                                    {{-- COMMUNAUTÉ --}}

                                    <td
                                        width="33.33%"
                                        align="center"
                                        valign="top"
                                        style="
                                            padding: 8px;
                                        "
                                    >

                                        <div
                                            style="
                                                margin-bottom: 8px;
                                                font-size: 24px;
                                                color: #ef4444;
                                            "
                                        >
                                            ●●●
                                        </div>

                                        <div
                                            style="
                                                font-size: 11px;
                                                line-height: 16px;
                                                font-weight: 800;
                                                text-transform: uppercase;
                                                color: #ffffff;
                                            "
                                        >
                                            Une communauté
                                        </div>

                                        <div
                                            style="
                                                margin-top: 5px;
                                                font-size: 11px;
                                                line-height: 16px;
                                                color: #a1a1aa;
                                            "
                                        >
                                            Ensemble autour du sport
                                        </div>

                                    </td>


                                    {{-- PROGRESSION --}}

                                    <td
                                        width="33.33%"
                                        align="center"
                                        valign="top"
                                        style="
                                            padding: 8px;
                                        "
                                    >

                                        <div
                                            style="
                                                margin-bottom: 8px;
                                                font-size: 24px;
                                                font-weight: 900;
                                                color: #ef4444;
                                            "
                                        >
                                            ↑
                                        </div>

                                        <div
                                            style="
                                                font-size: 11px;
                                                line-height: 16px;
                                                font-weight: 800;
                                                text-transform: uppercase;
                                                color: #ffffff;
                                            "
                                        >
                                            Du progrès
                                        </div>

                                        <div
                                            style="
                                                margin-top: 5px;
                                                font-size: 11px;
                                                line-height: 16px;
                                                color: #a1a1aa;
                                            "
                                        >
                                            À chaque étape
                                        </div>

                                    </td>


                                    {{-- VALEURS --}}

                                    <td
                                        width="33.33%"
                                        align="center"
                                        valign="top"
                                        style="
                                            padding: 8px;
                                        "
                                    >

                                        <div
                                            style="
                                                margin-bottom: 8px;
                                                font-size: 24px;
                                                color: #ef4444;
                                            "
                                        >
                                            ★
                                        </div>

                                        <div
                                            style="
                                                font-size: 11px;
                                                line-height: 16px;
                                                font-weight: 800;
                                                text-transform: uppercase;
                                                color: #ffffff;
                                            "
                                        >
                                            Des valeurs
                                        </div>

                                        <div
                                            style="
                                                margin-top: 5px;
                                                font-size: 11px;
                                                line-height: 16px;
                                                color: #a1a1aa;
                                            "
                                        >
                                            Respect • Discipline
                                        </div>

                                    </td>

                                </tr>

                            </table>

                        </td>

                    </tr>


                    {{-- =============================================
                         SÉPARATEUR
                         ============================================= --}}

                    <tr>

                        <td
                            style="
                                padding:
                                    0
                                    40px;
                            "
                        >

                            <div
                                style="
                                    height: 1px;
                                    background-color: #27272a;
                                "
                            >
                            </div>

                        </td>

                    </tr>


                    {{-- =============================================
                         SIGNATURE
                         ============================================= --}}

                    <tr>

                        <td
                            align="center"
                            style="
                                padding:
                                    32px
                                    30px;

                                background-color: #0c0c0e;
                            "
                        >

                            <div
                                style="
                                    font-size: 18px;
                                    line-height: 26px;
                                    font-weight: 900;
                                    font-style: italic;
                                    letter-spacing: 1px;
                                    text-transform: uppercase;
                                    color: #ffffff;
                                "
                            >
                                Train harder

                                <span style="color: #ef4444;">
                                    together
                                </span>
                            </div>


                            <div
                                style="
                                    width: 44px;
                                    height: 3px;
                                    margin:
                                        14px
                                        auto;

                                    background-color: #dc2626;
                                "
                            >
                            </div>


                            <div
                                style="
                                    font-size: 13px;
                                    line-height: 20px;
                                    color: #a1a1aa;
                                "
                            >
                                L'équipe

                                <strong style="color: #ef4444;">
                                    Brussels Top Team
                                </strong>
                            </div>

                        </td>

                    </tr>


                    {{-- =============================================
                         LIEN DE SECOURS
                         =============================================
                         Certains clients email peuvent empêcher le bouton
                         de fonctionner correctement. Nous fournissons donc
                         également l'URL sous forme de texte.
                         ============================================= --}}

                    <tr>

                        <td
                            style="
                                padding:
                                    24px
                                    30px;

                                background-color: #18181b;

                                font-size: 11px;
                                line-height: 18px;
                                color: #71717a;
                            "
                        >

                            Si le bouton ne fonctionne pas, copiez et collez
                            le lien suivant dans votre navigateur :

                            <br><br>

                            <a
                                href="{{ $verificationUrl }}"
                                style="
                                    color: #ef4444;
                                    text-decoration: underline;
                                    word-break: break-all;
                                "
                            >
                                {{ $verificationUrl }}
                            </a>

                        </td>

                    </tr>


                    {{-- =============================================
                         PIED DE PAGE
                         ============================================= --}}

                    <tr>

                        <td
                            align="center"
                            style="
                                padding:
                                    22px
                                    30px;

                                background-color: #09090b;

                                font-size: 10px;
                                line-height: 17px;
                                letter-spacing: 1px;
                                color: #52525b;
                                text-transform: uppercase;
                            "
                        >
                            Brussels Top Team

                            <br>

                            Discipline • Respect • Progression
                        </td>

                    </tr>

                </table>

            </td>

        </tr>

    </table>

</body>

</html>