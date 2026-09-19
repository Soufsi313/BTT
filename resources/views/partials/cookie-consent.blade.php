
{{-- 
    Composant de consentement aux cookies - Brussels Top Team.

    Ce composant :
    - vérifie les préférences enregistrées ;
    - affiche le bandeau si aucun choix valide n'existe ;
    - permet d'accepter, de refuser ou de personnaliser ;
    - permet de rouvrir les paramètres depuis le footer.

    Les catégories optionnelles restent désactivées tant qu'aucun
    consentement n'a été enregistré.

    Lors de la première ouverture des paramètres, les cases optionnelles
    sont précochées dans le formulaire, sans activer ces catégories.
--}}

<div
    id="btt-cookie-consent"
    class="fixed inset-x-0 bottom-0 z-[100] hidden"
    data-show-url="{{ route('cookie-consent.show') }}"
    data-store-url="{{ route('cookie-consent.store') }}"
    data-csrf-token="{{ csrf_token() }}"
    aria-live="polite"
>
    {{-- Fond assombri affiché pendant la personnalisation. --}}
    <div
        id="btt-cookie-overlay"
        class="fixed inset-0 hidden bg-black/75"
        aria-hidden="true"
    ></div>

    {{-- Bandeau principal. --}}
    <section
        id="btt-cookie-banner"
        class="relative mx-auto w-full border-t-2 border-red-600 bg-zinc-950 p-5 text-white shadow-2xl sm:p-7"
        aria-labelledby="btt-cookie-title"
        aria-describedby="btt-cookie-description"
    >
        <div class="mx-auto flex max-w-7xl flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div class="max-w-3xl">
                <p class="mb-2 text-xs font-bold uppercase tracking-[0.2em] text-red-500">
                    Brussels Top Team
                </p>

                <h2
                    id="btt-cookie-title"
                    class="mb-3 text-xl font-extrabold uppercase tracking-wide sm:text-2xl"
                >
                    Vos préférences de cookies
                </h2>

                <p
                    id="btt-cookie-description"
                    class="text-sm leading-relaxed text-zinc-300"
                >
                    Nous utilisons des cookies nécessaires au fonctionnement
                    du site. Avec votre accord, nous pourrons également
                    utiliser des cookies de mesure d'audience et afficher
                    des contenus provenant de services externes.
                    Vous pouvez accepter, refuser ou personnaliser
                    ces usages à tout moment.
                </p>
            </div>

            <div class="flex w-full flex-col gap-3 sm:flex-row lg:w-auto lg:shrink-0">
                <button
                    type="button"
                    id="btt-cookie-reject"
                    class="min-h-12 rounded-lg border border-zinc-500 px-5 py-3 text-sm font-bold text-white transition hover:border-white hover:bg-zinc-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white"
                >
                    Tout refuser
                </button>

                <button
                    type="button"
                    id="btt-cookie-settings"
                    class="min-h-12 rounded-lg border border-zinc-500 px-5 py-3 text-sm font-bold text-white transition hover:border-white hover:bg-zinc-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white"
                >
                    Paramétrer
                </button>

                <button
                    type="button"
                    id="btt-cookie-accept"
                    class="min-h-12 rounded-lg bg-red-600 px-5 py-3 text-sm font-extrabold text-white transition hover:bg-red-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white"
                >
                    Tout accepter
                </button>
            </div>
        </div>
    </section>

    {{-- Fenêtre de personnalisation. --}}
    <section
        id="btt-cookie-panel"
        class="fixed inset-x-4 top-1/2 z-[101] hidden max-h-[90vh] -translate-y-1/2 overflow-y-auto rounded-xl border border-zinc-700 bg-zinc-950 p-5 text-white shadow-2xl sm:left-1/2 sm:w-full sm:max-w-xl sm:-translate-x-1/2 sm:p-7"
        role="dialog"
        aria-modal="true"
        aria-labelledby="btt-cookie-panel-title"
        aria-describedby="btt-cookie-panel-description"
        tabindex="-1"
    >
        <div class="mb-5 flex items-start justify-between gap-4">
            <div>
                <p class="mb-2 text-xs font-bold uppercase tracking-[0.2em] text-red-500">
                    Brussels Top Team
                </p>

                <h2
                    id="btt-cookie-panel-title"
                    class="text-xl font-extrabold uppercase sm:text-2xl"
                >
                    Personnaliser mes cookies
                </h2>
            </div>

            <button
                type="button"
                id="btt-cookie-close"
                class="rounded-lg p-2 text-zinc-300 transition hover:bg-zinc-800 hover:text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-red-500"
                aria-label="Fermer les paramètres"
            >
                <span aria-hidden="true" class="text-2xl leading-none">&times;</span>
            </button>
        </div>

        <p
            id="btt-cookie-panel-description"
            class="mb-6 text-sm leading-relaxed text-zinc-300"
        >
            Choisissez les catégories que vous souhaitez autoriser.
            Les cookies nécessaires restent actifs pour assurer
            le fonctionnement et la sécurité du site.
        </p>

        <div class="space-y-4">
            {{-- Cookies nécessaires : toujours actifs. --}}
            <div class="rounded-lg border border-zinc-700 bg-zinc-900 p-4">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h3 class="font-bold text-white">
                            Cookies nécessaires
                        </h3>

                        <p class="mt-1 text-sm leading-relaxed text-zinc-400">
                            Indispensables à la navigation, à la sécurité,
                            aux sessions et à l'enregistrement de votre choix.
                        </p>
                    </div>

                    <span class="shrink-0 rounded-full bg-zinc-700 px-3 py-1 text-xs font-bold text-white">
                        Toujours actifs
                    </span>
                </div>
            </div>

            {{-- Mesure d'audience : état déterminé à l'ouverture des paramètres. --}}
            <label class="flex cursor-pointer items-start justify-between gap-4 rounded-lg border border-zinc-700 bg-zinc-900 p-4">
                <span>
                    <span class="block font-bold text-white">
                        Mesure d'audience
                    </span>

                    <span class="mt-1 block text-sm leading-relaxed text-zinc-400">
                        Autorise les éventuels outils de statistiques
                        destinés à comprendre l'utilisation du site.
                    </span>
                </span>

                <input
                    type="checkbox"
                    id="btt-cookie-analytics"
                    class="mt-1 h-5 w-5 shrink-0 accent-red-600"
                >
            </label>

            {{-- Médias externes : état déterminé à l'ouverture des paramètres. --}}
            <label class="flex cursor-pointer items-start justify-between gap-4 rounded-lg border border-zinc-700 bg-zinc-900 p-4">
                <span>
                    <span class="block font-bold text-white">
                        Contenus externes
                    </span>

                    <span class="mt-1 block text-sm leading-relaxed text-zinc-400">
                        Autorise le chargement des éventuelles vidéos,
                        cartes ou autres contenus intégrés depuis
                        des services tiers.
                    </span>
                </span>

                <input
                    type="checkbox"
                    id="btt-cookie-external-media"
                    class="mt-1 h-5 w-5 shrink-0 accent-red-600"
                >
            </label>
        </div>

        <p
            id="btt-cookie-error"
            class="mt-5 hidden rounded-lg border border-red-700 bg-red-950 p-3 text-sm text-red-100"
            role="alert"
        ></p>

        <div class="mt-6 grid gap-3 sm:grid-cols-2">
            <button
                type="button"
                id="btt-cookie-panel-reject"
                class="min-h-12 rounded-lg border border-zinc-500 px-4 py-3 text-sm font-bold transition hover:bg-zinc-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white"
            >
                Tout refuser
            </button>

            <button
                type="button"
                id="btt-cookie-save"
                class="min-h-12 rounded-lg bg-red-600 px-4 py-3 text-sm font-extrabold transition hover:bg-red-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white"
            >
                Enregistrer mes préférences
            </button>
        </div>
    </section>
</div>

<script>
    /*
     * Gestion du bandeau de consentement BTT.
     *
     * Aucun outil optionnel n'est chargé par ce script.
     * Les autres intégrations devront vérifier les préférences
     * avant de charger des ressources non nécessaires.
     */
    (() => {
        'use strict';

        const root = document.getElementById('btt-cookie-consent');

        if (!root) {
            return;
        }

        const banner = document.getElementById('btt-cookie-banner');
        const overlay = document.getElementById('btt-cookie-overlay');
        const panel = document.getElementById('btt-cookie-panel');
        const analyticsInput = document.getElementById('btt-cookie-analytics');
        const externalMediaInput = document.getElementById('btt-cookie-external-media');
        const errorMessage = document.getElementById('btt-cookie-error');

        const acceptButton = document.getElementById('btt-cookie-accept');
        const rejectButton = document.getElementById('btt-cookie-reject');
        const settingsButton = document.getElementById('btt-cookie-settings');
        const closeButton = document.getElementById('btt-cookie-close');
        const panelRejectButton = document.getElementById('btt-cookie-panel-reject');
        const saveButton = document.getElementById('btt-cookie-save');

        const actionButtons = [
            acceptButton,
            rejectButton,
            settingsButton,
            closeButton,
            panelRejectButton,
            saveButton,
        ];

        let hasConsent = false;
        let isSaving = false;
        let previousFocus = null;

        let currentPreferences = {
            necessary_allowed: true,
            analytics_allowed: false,
            external_media_allowed: false,
            decision: null,
        };

        /*
         * Affiche ou masque le composant.
         */
        function showRoot() {
            root.classList.remove('hidden');
        }

        function hideRoot() {
            root.classList.add('hidden');
            overlay.classList.add('hidden');
            panel.classList.add('hidden');
            banner.classList.remove('hidden');

            document.body.style.overflow = '';
        }

        /*
         * Affiche le bandeau principal.
         */
        function showBanner() {
            showRoot();

            overlay.classList.add('hidden');
            panel.classList.add('hidden');
            banner.classList.remove('hidden');

            document.body.style.overflow = '';
        }

        /*
         * Affiche la fenêtre de personnalisation.
         *
         * Sans consentement enregistré, les deux cases sont cochées
         * dans le formulaire uniquement.
         *
         * Avec un consentement enregistré, les cases reprennent
         * exactement les préférences sauvegardées.
         */
        function openSettings() {
            previousFocus = document.activeElement;

            analyticsInput.checked = hasConsent
                ? currentPreferences.analytics_allowed
                : true;

            externalMediaInput.checked = hasConsent
                ? currentPreferences.external_media_allowed
                : true;

            clearError();

            showRoot();

            banner.classList.add('hidden');
            overlay.classList.remove('hidden');
            panel.classList.remove('hidden');

            document.body.style.overflow = 'hidden';

            panel.focus();
        }

        /*
         * Ferme les paramètres.
         *
         * Si le visiteur n'a encore fait aucun choix, le bandeau
         * reste affiché. Fermer les paramètres ne vaut pas consentement.
         */
        function closeSettings() {
            overlay.classList.add('hidden');
            panel.classList.add('hidden');

            document.body.style.overflow = '';

            if (hasConsent) {
                hideRoot();
            } else {
                showBanner();
            }

            if (previousFocus && previousFocus.isConnected) {
                previousFocus.focus();
            }
        }

        /*
         * Affiche une erreur compréhensible en cas d'échec.
         */
        function showError(message) {
            errorMessage.textContent = message;
            errorMessage.classList.remove('hidden');

            showRoot();
            overlay.classList.remove('hidden');
            panel.classList.remove('hidden');
            banner.classList.add('hidden');

            document.body.style.overflow = 'hidden';
        }

        function clearError() {
            errorMessage.textContent = '';
            errorMessage.classList.add('hidden');
        }

        /*
         * Empêche les doubles enregistrements.
         */
        function setSaving(saving) {
            isSaving = saving;

            actionButtons.forEach((button) => {
                button.disabled = saving;
                button.classList.toggle('opacity-60', saving);
                button.classList.toggle('cursor-not-allowed', saving);
            });
        }

        /*
         * Informe les autres scripts du site du choix actuel.
         *
         * Un futur script de statistiques ou de médias externes
         * pourra écouter cet événement et appliquer les préférences.
         */
        function publishPreferences() {
            window.bttCookieConsent = {
                ...currentPreferences,
                has_consent: hasConsent,
            };

            window.dispatchEvent(
                new CustomEvent('btt:cookie-consent-updated', {
                    detail: window.bttCookieConsent,
                })
            );
        }

        /*
         * Charge les préférences enregistrées depuis Laravel.
         */
        async function loadPreferences() {
            try {
                const response = await fetch(root.dataset.showUrl, {
                    method: 'GET',
                    credentials: 'same-origin',
                    headers: {
                        'Accept': 'application/json',
                    },
                });

                if (!response.ok) {
                    throw new Error('Impossible de récupérer les préférences.');
                }

                const data = await response.json();

                hasConsent = data.has_consent === true;

                currentPreferences = {
                    necessary_allowed: true,
                    analytics_allowed: data.consent?.analytics_allowed === true,
                    external_media_allowed: data.consent?.external_media_allowed === true,
                    decision: data.consent?.decision ?? null,
                };

                publishPreferences();

                if (hasConsent) {
                    hideRoot();
                } else {
                    showBanner();
                }
            } catch (error) {
                /*
                 * En cas d'erreur réseau, aucune catégorie optionnelle
                 * n'est autorisée et le bandeau reste accessible.
                 */
                hasConsent = false;

                currentPreferences = {
                    necessary_allowed: true,
                    analytics_allowed: false,
                    external_media_allowed: false,
                    decision: null,
                };

                publishPreferences();
                showBanner();
            }
        }

        /*
         * Enregistre une décision auprès du contrôleur Laravel.
         */
        async function savePreferences(decision) {
            if (isSaving) {
                return;
            }

            clearError();
            setSaving(true);

            const payload = {
                decision: decision,
            };

            if (decision === 'customized') {
                payload.analytics_allowed = analyticsInput.checked;
                payload.external_media_allowed = externalMediaInput.checked;
            }

            try {
                const response = await fetch(root.dataset.storeUrl, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': root.dataset.csrfToken,
                    },
                    body: JSON.stringify(payload),
                });

                if (!response.ok) {
                    throw new Error('Enregistrement impossible.');
                }

                const data = await response.json();

                if (data.success !== true || !data.consent) {
                    throw new Error('Réponse invalide du serveur.');
                }

                hasConsent = true;

                currentPreferences = {
                    necessary_allowed: true,
                    analytics_allowed: data.consent.analytics_allowed === true,
                    external_media_allowed: data.consent.external_media_allowed === true,
                    decision: data.consent.decision,
                };

                publishPreferences();
                hideRoot();
            } catch (error) {
                showError(
                    'Impossible d’enregistrer vos préférences pour le moment. Veuillez réessayer.'
                );
            } finally {
                setSaving(false);
            }
        }

        /*
         * Actions du bandeau principal.
         */
        acceptButton.addEventListener('click', () => {
            savePreferences('accepted');
        });

        rejectButton.addEventListener('click', () => {
            savePreferences('rejected');
        });

        settingsButton.addEventListener('click', openSettings);

        /*
         * Actions de la fenêtre de personnalisation.
         */
        closeButton.addEventListener('click', closeSettings);

        panelRejectButton.addEventListener('click', () => {
            savePreferences('rejected');
        });

        saveButton.addEventListener('click', () => {
            savePreferences('customized');
        });

        /*
         * Fermeture avec la touche Échap.
         */
        document.addEventListener('keydown', (event) => {
            if (
                event.key === 'Escape'
                && !panel.classList.contains('hidden')
                && !isSaving
            ) {
                closeSettings();
            }
        });

        /*
         * Permet au futur lien du footer de rouvrir les paramètres.
         *
         * Exemple d'utilisation dans un autre script :
         * window.dispatchEvent(new Event('btt:open-cookie-settings'));
         */
        window.addEventListener('btt:open-cookie-settings', openSettings);

        /*
         * Initialisation après chargement du composant.
         */
        loadPreferences();
    })();
</script>