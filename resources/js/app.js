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
                toolbar: [

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
                    | NETTOYER LA MISE EN FORME
                    |----------------------------------------------------------
                    */

                    [
                        'clean',
                    ],
                ],
            },
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
    | Le précédent système utilisait directement innerHTML.
    | Sur un ancien texte brut, cela pouvait écraser les retours
    | à la ligne et certains espacements.
    |
    | Nous détectons donc maintenant si le contenu contient réellement
    | du HTML.
    |
    */

    const initialContent = contentInput.value;

    if (initialContent.trim() !== '') {

        /*
        |--------------------------------------------------------------------------
        | DÉTECTION D'UN CONTENU HTML
        |--------------------------------------------------------------------------
        |
        | Si le contenu possède une vraie balise HTML, nous le considérons
        | comme un contenu déjà généré par Quill.
        |
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
            |
            | setText() permet de transmettre le texte à Quill sans faire
            | interpréter les sauts de ligne comme du simple HTML.
            |
            | Les retours à la ligne sont ainsi transformés proprement
            | en lignes Quill.
            |
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