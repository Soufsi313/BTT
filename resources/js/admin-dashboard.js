import Chart from 'chart.js/auto';


/*
|--------------------------------------------------------------------------
| DASHBOARD STATISTIQUE ADMINISTRATION
|--------------------------------------------------------------------------
|
| Ce fichier gère exclusivement les graphiques Chart.js du Dashboard
| d'administration Brussels Top Team.
|
| Les valeurs ne sont jamais écrites en dur ici.
|
| Laravel récupère les données depuis MariaDB puis les transmet aux
| éléments <canvas> grâce à leurs attributs data-*.
|
| Les graphiques s'adaptent donc automatiquement aux entrées et sorties
| de données du site.
|
*/


document.addEventListener('DOMContentLoaded', () => {


    /*
    |--------------------------------------------------------------------------
    | COULEURS BTT
    |--------------------------------------------------------------------------
    |
    | Les graphiques reprennent le style actuel du back-office :
    |
    | - rouge BTT ;
    | - noir / zinc ;
    | - gris clair.
    |
    */

    const colors = {
        red: '#dc2626',
        redLight: 'rgba(220, 38, 38, 0.12)',
        black: '#18181b',
        zinc: '#71717a',
        zincLight: '#d4d4d8',
        background: '#f4f4f5',
        white: '#ffffff',
    };


    /*
    |--------------------------------------------------------------------------
    | OPTIONS COMMUNES
    |--------------------------------------------------------------------------
    */

    const commonPlugins = {
        legend: {
            labels: {
                color: colors.black,
                font: {
                    family: 'Arial',
                    size: 12,
                    weight: 'bold',
                },
                usePointStyle: true,
                pointStyle: 'circle',
                padding: 18,
            },
        },

        tooltip: {
            backgroundColor: colors.black,
            titleColor: colors.white,
            bodyColor: colors.white,
            padding: 12,
            displayColors: true,
        },
    };


    /*
    |--------------------------------------------------------------------------
    | 1. ÉVOLUTION DES INSCRIPTIONS
    |--------------------------------------------------------------------------
    |
    | Graphique en courbe sur les six derniers mois.
    |
    | Les labels et les valeurs proviennent directement de Laravel.
    |
    */

    const membersEvolutionChart = document.getElementById(
        'members-evolution-chart'
    );

    if (membersEvolutionChart) {

        const labels = JSON.parse(
            membersEvolutionChart.dataset.labels || '[]'
        );

        const values = JSON.parse(
            membersEvolutionChart.dataset.values || '[]'
        );

        new Chart(
            membersEvolutionChart,
            {
                type: 'line',

                data: {
                    labels,

                    datasets: [
                        {
                            label: 'Nouvelles inscriptions',
                            data: values,
                            borderColor: colors.red,
                            backgroundColor: colors.redLight,
                            borderWidth: 3,
                            pointBackgroundColor: colors.red,
                            pointBorderColor: colors.white,
                            pointBorderWidth: 2,
                            pointRadius: 5,
                            pointHoverRadius: 7,
                            fill: true,
                            tension: 0.35,
                        },
                    ],
                },

                options: {
                    responsive: true,
                    maintainAspectRatio: false,

                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },

                    plugins: {
                        ...commonPlugins,

                        legend: {
                            display: false,
                        },
                    },

                    scales: {
                        x: {
                            grid: {
                                display: false,
                            },

                            border: {
                                display: false,
                            },

                            ticks: {
                                color: colors.zinc,
                                font: {
                                    weight: 'bold',
                                },
                            },
                        },

                        y: {
                            beginAtZero: true,

                            border: {
                                display: false,
                            },

                            grid: {
                                color: colors.background,
                            },

                            ticks: {
                                color: colors.zinc,
                                precision: 0,
                                stepSize: 1,
                            },
                        },
                    },
                },
            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | 2. RÉPARTITION DES ADHÉRENTS
    |--------------------------------------------------------------------------
    |
    | Doughnut :
    |
    | - comptes actifs ;
    | - comptes archivés.
    |
    */

    const membersStatusChart = document.getElementById(
        'members-status-chart'
    );

    if (membersStatusChart) {

        const active = Number(
            membersStatusChart.dataset.active || 0
        );

        const archived = Number(
            membersStatusChart.dataset.archived || 0
        );

        new Chart(
            membersStatusChart,
            {
                type: 'doughnut',

                data: {
                    labels: [
                        'Actifs',
                        'Archivés',
                    ],

                    datasets: [
                        {
                            data: [
                                active,
                                archived,
                            ],

                            backgroundColor: [
                                colors.black,
                                colors.red,
                            ],

                            borderColor: colors.white,
                            borderWidth: 4,
                            hoverOffset: 8,
                        },
                    ],
                },

                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '68%',

                    plugins: {
                        ...commonPlugins,

                        legend: {
                            ...commonPlugins.legend,
                            position: 'bottom',
                        },
                    },
                },
            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | 3. ÉTAT DES COURS
    |--------------------------------------------------------------------------
    |
    | Histogramme représentant :
    |
    | - les cours actifs ;
    | - les cours inactifs ;
    | - les cours terminés ;
    | - les cours supprimés.
    |
    */

    const coursesStatusChart = document.getElementById(
        'courses-status-chart'
    );

    if (coursesStatusChart) {

        const active = Number(
            coursesStatusChart.dataset.active || 0
        );

        const inactive = Number(
            coursesStatusChart.dataset.inactive || 0
        );

        const completed = Number(
            coursesStatusChart.dataset.completed || 0
        );

        const deleted = Number(
            coursesStatusChart.dataset.deleted || 0
        );

        new Chart(
            coursesStatusChart,
            {
                type: 'bar',

                data: {
                    labels: [
                        'Actifs',
                        'Inactifs',
                        'Terminés',
                        'Supprimés',
                    ],

                    datasets: [
                        {
                            label: 'Cours',

                            data: [
                                active,
                                inactive,
                                completed,
                                deleted,
                            ],

                            backgroundColor: [
                                colors.red,
                                colors.black,
                                colors.zinc,
                                colors.zincLight,
                            ],

                            borderRadius: 4,
                            borderSkipped: false,
                        },
                    ],
                },

                options: {
                    responsive: true,
                    maintainAspectRatio: false,

                    plugins: {
                        ...commonPlugins,

                        legend: {
                            display: false,
                        },
                    },

                    scales: {
                        x: {
                            grid: {
                                display: false,
                            },

                            border: {
                                display: false,
                            },

                            ticks: {
                                color: colors.zinc,
                                font: {
                                    weight: 'bold',
                                },
                            },
                        },

                        y: {
                            beginAtZero: true,

                            border: {
                                display: false,
                            },

                            grid: {
                                color: colors.background,
                            },

                            ticks: {
                                color: colors.zinc,
                                precision: 0,
                                stepSize: 1,
                            },
                        },
                    },
                },
            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | 4. ACTIVITÉ DU SITE
    |--------------------------------------------------------------------------
    |
    | Ce graphique rassemble plusieurs indicateurs généraux :
    |
    | - articles publiés ;
    | - brouillons ;
    | - commentaires ;
    | - signalements en attente ;
    | - conversations ;
    | - conversations avec nouveaux messages.
    |
    */

    const websiteActivityChart = document.getElementById(
        'website-activity-chart'
    );

    if (websiteActivityChart) {

        const publishedArticles = Number(
            websiteActivityChart.dataset.publishedArticles || 0
        );

        const draftArticles = Number(
            websiteActivityChart.dataset.draftArticles || 0
        );

        const comments = Number(
            websiteActivityChart.dataset.comments || 0
        );

        const pendingReports = Number(
            websiteActivityChart.dataset.pendingReports || 0
        );

        const conversations = Number(
            websiteActivityChart.dataset.conversations || 0
        );

        const unreadConversations = Number(
            websiteActivityChart.dataset.unreadConversations || 0
        );

        new Chart(
            websiteActivityChart,
            {
                type: 'bar',

                data: {
                    labels: [
                        'Articles publiés',
                        'Brouillons',
                        'Commentaires',
                        'Signalements',
                        'Conversations',
                        'Nouveaux messages',
                    ],

                    datasets: [
                        {
                            label: 'Nombre',

                            data: [
                                publishedArticles,
                                draftArticles,
                                comments,
                                pendingReports,
                                conversations,
                                unreadConversations,
                            ],

                            backgroundColor: colors.red,
                            borderRadius: 4,
                            borderSkipped: false,
                        },
                    ],
                },

                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,

                    plugins: {
                        ...commonPlugins,

                        legend: {
                            display: false,
                        },
                    },

                    scales: {
                        x: {
                            beginAtZero: true,

                            border: {
                                display: false,
                            },

                            grid: {
                                color: colors.background,
                            },

                            ticks: {
                                color: colors.zinc,
                                precision: 0,
                                stepSize: 1,
                            },
                        },

                        y: {
                            grid: {
                                display: false,
                            },

                            border: {
                                display: false,
                            },

                            ticks: {
                                color: colors.zinc,
                                font: {
                                    weight: 'bold',
                                },
                            },
                        },
                    },
                },
            }
        );

    }

});