import Quill from 'quill';
import 'quill/dist/quill.snow.css';


/*
|--------------------------------------------------------------------------
| MENU MOBILE
|--------------------------------------------------------------------------
|
| Gestion du menu principal sur mobile.
|
*/

document.addEventListener('DOMContentLoaded', () => {
    const menuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const openIcon = document.getElementById('menu-icon-open');
    const closeIcon = document.getElementById('menu-icon-close');

    if (!menuButton || !mobileMenu || !openIcon || !closeIcon) {
        return;
    }

    menuButton.addEventListener('click', () => {
        const menuIsOpen = !mobileMenu.classList.contains('hidden');

        mobileMenu.classList.toggle('hidden');
        openIcon.classList.toggle('hidden');
        closeIcon.classList.toggle('hidden');

        menuButton.setAttribute(
            'aria-expanded',
            String(!menuIsOpen)
        );

        menuButton.setAttribute(
            'aria-label',
            menuIsOpen
                ? 'Ouvrir le menu'
                : 'Fermer le menu'
        );
    });
});


/*
|--------------------------------------------------------------------------
| ÉDITEUR DE TEXTE RICHE QUILL
|--------------------------------------------------------------------------
|
| L'éditeur est chargé uniquement lorsque la page contient :
|
| #article-editor
|
| Il est donc utilisé sur :
|
| - la création d'un article ;
| - la modification d'un article.
|
*/

document.addEventListener('DOMContentLoaded', () => {
    const editorElement = document.getElementById('article-editor');

    if (!editorElement) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | ÉLÉMENTS DU FORMULAIRE
    |--------------------------------------------------------------------------
    */

    const contentInput = document.getElementById('article-content');
    const articleForm = document.getElementById('article-form');

    if (!contentInput || !articleForm) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | POLICES DISPONIBLES
    |--------------------------------------------------------------------------
    */

    const Font = Quill.import('formats/font');

    Font.whitelist = [
        'arial',
        'georgia',
        'times-new-roman',
        'verdana',
        'courier-new',
    ];

    Quill.register(
        Font,
        true
    );


    /*
    |--------------------------------------------------------------------------
    | TAILLES DISPONIBLES
    |--------------------------------------------------------------------------
    */

    const Size = Quill.import('formats/size');

    Size.whitelist = [
        'small',
        'large',
        'huge',
    ];

    Quill.register(
        Size,
        true
    );


    /*
    |--------------------------------------------------------------------------
    | INITIALISATION DE QUILL
    |--------------------------------------------------------------------------
    */

    const quill = new Quill(
        '#article-editor',
        {
            theme: 'snow',

            placeholder: 'Rédigez le contenu de votre article...',

            modules: {
                toolbar: {

                    /*
                    |--------------------------------------------------------------------------
                    | BOUTONS DE LA BARRE D'OUTILS
                    |--------------------------------------------------------------------------
                    */

                    container: [

                        /*
                        |----------------------------------------------------------
                        | TITRES
                        |----------------------------------------------------------
                        */

                        [
                            {
                                header: [
                                    1,
                                    2,
                                    3,
                                    false,
                                ],
                            },
                        ],


                        /*
                        |----------------------------------------------------------
                        | POLICES
                        |----------------------------------------------------------
                        */

                        [
                            {
                                font: [
                                    false,
                                    'arial',
                                    'georgia',
                                    'times-new-roman',
                                    'verdana',
                                    'courier-new',
                                ],
                            },
                        ],


                        /*
                        |----------------------------------------------------------
                        | TAILLES
                        |----------------------------------------------------------
                        */

                        [
                            {
                                size: [
                                    'small',
                                    false,
                                    'large',
                                    'huge',
                                ],
                            },
                        ],


                        /*
                        |----------------------------------------------------------
                        | STYLE DU TEXTE
                        |----------------------------------------------------------
                        */

                        [
                            'bold',
                            'italic',
                            'underline',
                            'strike',
                        ],


                        /*
                        |----------------------------------------------------------
                        | COULEURS
                        |----------------------------------------------------------
                        */

                        [
                            {
                                color: [],
                            },

                            {
                                background: [],
                            },
                        ],


                        /*
                        |----------------------------------------------------------
                        | ALIGNEMENT
                        |----------------------------------------------------------
                        */

                        [
                            {
                                align: [],
                            },
                        ],


                        /*
                        |----------------------------------------------------------
                        | LISTES
                        |----------------------------------------------------------
                        */

                        [
                            {
                                list: 'ordered',
                            },

                            {
                                list: 'bullet',
                            },
                        ],


                        /*
                        |----------------------------------------------------------
                        | INDENTATION
                        |----------------------------------------------------------
                        */

                        [
                            {
                                indent: '-1',
                            },

                            {
                                indent: '+1',
                            },
                        ],


                        /*
                        |----------------------------------------------------------
                        | CITATION
                        |----------------------------------------------------------
                        */

                        [
                            'blockquote',
                        ],


                        /*
                        |----------------------------------------------------------
                        | LIEN
                        |----------------------------------------------------------
                        */

                        [
                            'link',
                        ],


                        /*
                        |----------------------------------------------------------
                        | IMAGE
                        |----------------------------------------------------------
                        |
                        | Ce bouton ne va PAS utiliser l'insertion Base64
                        | proposée par défaut par Quill.
                        |
                        | Nous allons remplacer son comportement avec
                        | notre propre gestionnaire d'upload Laravel.
                        |
                        */

                        [
                            'image',
                        ],


                        /*
                        |----------------------------------------------------------
                        | NETTOYER LA MISE EN FORME
                        |----------------------------------------------------------
                        */

                        [
                            'clean',
                        ],
                    ],
                },
            },
        }
    );


    /*
    |--------------------------------------------------------------------------
    | RÉCUPÉRATION DE LA BARRE D'OUTILS
    |--------------------------------------------------------------------------
    */

    const toolbar = quill.getModule('toolbar');


    /*
    |--------------------------------------------------------------------------
    | GESTION PERSONNALISÉE DU BOUTON IMAGE
    |--------------------------------------------------------------------------
    |
    | Lorsque l'administrateur clique sur le bouton image :
    |
    | 1. on crée un champ <input type="file"> temporaire ;
    | 2. on ouvre l'explorateur de fichiers ;
    | 3. l'administrateur choisit une image ;
    | 4. l'image est envoyée à Laravel avec fetch() ;
    | 5. Laravel renvoie l'URL publique ;
    | 6. Quill insère cette URL dans l'article.
    |
    */

    toolbar.addHandler(
        'image',
        () => {

            /*
            |--------------------------------------------------------------------------
            | CRÉATION DU CHAMP DE FICHIER
            |--------------------------------------------------------------------------
            */

            const fileInput = document.createElement('input');

            fileInput.setAttribute(
                'type',
                'file'
            );

            fileInput.setAttribute(
                'accept',
                'image/jpeg,image/png,image/webp'
            );

            /*
            |--------------------------------------------------------------------------
            | CHAMP MASQUÉ
            |--------------------------------------------------------------------------
            */

            fileInput.style.display = 'none';

            document.body.appendChild(fileInput);


            /*
            |--------------------------------------------------------------------------
            | OUVERTURE DE L'EXPLORATEUR DE FICHIERS
            |--------------------------------------------------------------------------
            */

            fileInput.click();


            /*
            |--------------------------------------------------------------------------
            | SÉLECTION D'UNE IMAGE
            |--------------------------------------------------------------------------
            */

            fileInput.addEventListener(
                'change',
                async () => {

                    const imageFile = fileInput.files?.[0];

                    /*
                    |--------------------------------------------------------------------------
                    | AUCUN FICHIER SÉLECTIONNÉ
                    |--------------------------------------------------------------------------
                    */

                    if (!imageFile) {
                        fileInput.remove();
                        return;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | VÉRIFICATION DU TYPE
                    |--------------------------------------------------------------------------
                    */

                    const allowedTypes = [
                        'image/jpeg',
                        'image/png',
                        'image/webp',
                    ];

                    if (!allowedTypes.includes(imageFile.type)) {
                        alert(
                            'Format d’image non autorisé. Utilisez JPG, JPEG, PNG ou WEBP.'
                        );

                        fileInput.remove();

                        return;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | VÉRIFICATION DE LA TAILLE
                    |--------------------------------------------------------------------------
                    |
                    | La limite côté serveur est de 5 Mo.
                    |
                    | On effectue également la vérification côté navigateur
                    | pour éviter d'envoyer inutilement un fichier trop lourd.
                    |
                    */

                    const maximumFileSize = 5 * 1024 * 1024;

                    if (imageFile.size > maximumFileSize) {
                        alert(
                            'L’image est trop lourde. La taille maximale autorisée est de 5 Mo.'
                        );

                        fileInput.remove();

                        return;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | PRÉPARATION DES DONNÉES
                    |--------------------------------------------------------------------------
                    */

                    const formData = new FormData();

                    formData.append(
                        'image',
                        imageFile
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | TOKEN CSRF LARAVEL
                    |--------------------------------------------------------------------------
                    |
                    | Laravel protège les requêtes POST avec un token CSRF.
                    |
                    | Ce token est récupéré depuis la balise :
                    |
                    | <meta name="csrf-token" content="...">
                    |
                    | présente dans le layout principal.
                    |
                    */

                    const csrfToken = document
                        .querySelector('meta[name="csrf-token"]')
                        ?.getAttribute('content');


                    if (!csrfToken) {
                        alert(
                            'Le token de sécurité CSRF est introuvable.'
                        );

                        fileInput.remove();

                        return;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | POSITION DU CURSEUR
                    |--------------------------------------------------------------------------
                    |
                    | Nous mémorisons la position actuelle du curseur afin
                    | d'insérer l'image exactement à l'endroit choisi.
                    |
                    */

                    const currentSelection = quill.getSelection(true);

                    const insertionIndex = currentSelection
                        ? currentSelection.index
                        : quill.getLength();


                    /*
                    |--------------------------------------------------------------------------
                    | ENVOI DE L'IMAGE À LARAVEL
                    |--------------------------------------------------------------------------
                    */

                    try {

                        const response = await fetch(
                            '/admin/articles/images',
                            {
                                method: 'POST',

                                headers: {
                                    'X-CSRF-TOKEN': csrfToken,
                                    'Accept': 'application/json',
                                },

                                body: formData,
                            }
                        );


                        /*
                        |--------------------------------------------------------------------------
                        | RÉPONSE JSON
                        |--------------------------------------------------------------------------
                        */

                        const data = await response.json();


                        /*
                        |--------------------------------------------------------------------------
                        | ERREUR SERVEUR
                        |--------------------------------------------------------------------------
                        */

                        if (!response.ok) {

                            let errorMessage = 'Impossible d’envoyer l’image.';


                            /*
                            |--------------------------------------------------------------------------
                            | ERREURS DE VALIDATION LARAVEL
                            |--------------------------------------------------------------------------
                            */

                            if (data.errors?.image?.length) {
                                errorMessage = data.errors.image[0];
                            } else if (data.message) {
                                errorMessage = data.message;
                            }


                            throw new Error(
                                errorMessage
                            );
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | URL MANQUANTE
                        |--------------------------------------------------------------------------
                        */

                        if (!data.url) {
                            throw new Error(
                                'Le serveur n’a pas renvoyé l’URL de l’image.'
                            );
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | INSERTION DE L'IMAGE DANS QUILL
                        |--------------------------------------------------------------------------
                        */

                        quill.insertEmbed(
                            insertionIndex,
                            'image',
                            data.url,
                            'user'
                        );


                        /*
                        |--------------------------------------------------------------------------
                        | AJOUT D'UNE LIGNE APRÈS L'IMAGE
                        |--------------------------------------------------------------------------
                        |
                        | Cela permet de continuer facilement à rédiger
                        | sous l'image après son insertion.
                        |
                        */

                        quill.insertText(
                            insertionIndex + 1,
                            '\n',
                            'user'
                        );


                        /*
                        |--------------------------------------------------------------------------
                        | REPLACER LE CURSEUR APRÈS L'IMAGE
                        |--------------------------------------------------------------------------
                        */

                        quill.setSelection(
                            insertionIndex + 2,
                            0,
                            'silent'
                        );


                        /*
                        |--------------------------------------------------------------------------
                        | SYNCHRONISATION AVEC LE TEXTAREA CACHÉ
                        |--------------------------------------------------------------------------
                        */

                        contentInput.value = quill.root.innerHTML;

                    } catch (error) {

                        /*
                        |--------------------------------------------------------------------------
                        | MESSAGE D'ERREUR
                        |--------------------------------------------------------------------------
                        */

                        console.error(
                            'Erreur lors de l’upload de l’image :',
                            error
                        );

                        alert(
                            error.message
                            || 'Une erreur est survenue pendant l’envoi de l’image.'
                        );

                    } finally {

                        /*
                        |--------------------------------------------------------------------------
                        | NETTOYAGE DU CHAMP TEMPORAIRE
                        |--------------------------------------------------------------------------
                        */

                        fileInput.remove();

                    }

                },
                {
                    once: true,
                }
            );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | CHARGEMENT DU CONTENU EXISTANT
    |--------------------------------------------------------------------------
    |
    | Nous devons gérer deux types d'articles :
    |
    | 1. Les nouveaux articles :
    |    leur contenu est déjà enregistré sous forme de HTML Quill.
    |
    | 2. Les anciens articles :
    |    leur contenu était enregistré en texte brut avant l'arrivée
    |    de Quill.
    |
    */

    const initialContent = contentInput.value;

    if (initialContent.trim() !== '') {

        /*
        |--------------------------------------------------------------------------
        | DÉTECTION D'UN CONTENU HTML
        |--------------------------------------------------------------------------
        */

        const containsHtml = /<\/?[a-z][\s\S]*>/i.test(initialContent);


        if (containsHtml) {

            /*
            |--------------------------------------------------------------------------
            | ARTICLE DÉJÀ AU FORMAT QUILL / HTML
            |--------------------------------------------------------------------------
            */

            quill.clipboard.dangerouslyPasteHTML(
                initialContent
            );

        } else {

            /*
            |--------------------------------------------------------------------------
            | ANCIEN ARTICLE EN TEXTE BRUT
            |--------------------------------------------------------------------------
            */

            quill.setText(
                initialContent
            );

        }
    }


    /*
    |--------------------------------------------------------------------------
    | SYNCHRONISATION QUILL → FORMULAIRE
    |--------------------------------------------------------------------------
    |
    | À chaque modification dans Quill, nous enregistrons son contenu HTML
    | dans le textarea caché.
    |
    */

    quill.on(
        'text-change',
        () => {
            contentInput.value = quill.root.innerHTML;
        }
    );


    /*
    |--------------------------------------------------------------------------
    | ENVOI DU FORMULAIRE
    |--------------------------------------------------------------------------
    |
    | Nous effectuons une dernière synchronisation juste avant l'envoi.
    |
    */

    articleForm.addEventListener(
        'submit',
        () => {
            contentInput.value = quill.root.innerHTML;
        }
    );
});