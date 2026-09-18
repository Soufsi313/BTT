<?php

namespace App\Http\Controllers;

use App\Models\CommentReport;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;


/**
 * ================================================================
 * CONTRÔLEUR ADMINISTRATION DES SIGNALEMENTS DE COMMENTAIRES
 * ================================================================
 *
 * Ce contrôleur gère la modération des signalements effectués
 * par les membres sur les commentaires du blog BTT.
 *
 * L'administration peut :
 *
 * - consulter les signalements ;
 * - consulter les statistiques des signalements ;
 * - identifier le membre ayant effectué le signalement ;
 * - consulter le commentaire concerné ;
 * - connaître l'auteur du commentaire ;
 * - connaître l'article concerné ;
 * - examiner un signalement ;
 * - rejeter un signalement ;
 * - masquer un commentaire et résoudre le signalement.
 *
 * ================================================================
 */
class AdminCommentReportController extends Controller
{
    /**
     * ============================================================
     * LISTE DES SIGNALEMENTS
     * ============================================================
     *
     * Cette méthode récupère les signalements enregistrés dans
     * la base de données.
     *
     * Nous chargeons également :
     *
     * - le membre ayant effectué le signalement ;
     * - le commentaire signalé ;
     * - l'auteur du commentaire ;
     * - l'article auquel appartient le commentaire.
     *
     * Les signalements les plus récents sont affichés en premier.
     *
     * ============================================================
     */
    public function index(): View
    {
        /*
        |--------------------------------------------------------------------------
        | STATISTIQUES DES SIGNALEMENTS
        |--------------------------------------------------------------------------
        |
        | Les statistiques sont calculées indépendamment de la pagination.
        |
        | Elles permettent de connaître :
        |
        | - le nombre total de signalements ;
        | - le nombre de signalements en attente ;
        | - le nombre de signalements examinés ;
        | - le nombre de signalements traités ;
        | - le nombre de signalements rejetés.
        |
        */


        /*
        |--------------------------------------------------------------------------
        | TOTAL DES SIGNALEMENTS
        |--------------------------------------------------------------------------
        */

        $totalReportsCount = CommentReport::query()
            ->count();


        /*
        |--------------------------------------------------------------------------
        | SIGNALEMENTS EN ATTENTE
        |--------------------------------------------------------------------------
        |
        | Ces signalements n'ont pas encore été examinés par
        | l'administration.
        |
        */

        $pendingReportsCount = CommentReport::query()
            ->where(
                'status',
                'pending'
            )
            ->count();


        /*
        |--------------------------------------------------------------------------
        | SIGNALEMENTS EXAMINÉS
        |--------------------------------------------------------------------------
        |
        | L'administration a pris connaissance du signalement,
        | mais aucune décision définitive n'a encore été prise.
        |
        */

        $reviewedReportsCount = CommentReport::query()
            ->where(
                'status',
                'reviewed'
            )
            ->count();


        /*
        |--------------------------------------------------------------------------
        | SIGNALEMENTS TRAITÉS
        |--------------------------------------------------------------------------
        |
        | Ces signalements ont entraîné une action de modération.
        |
        | Dans le fonctionnement actuel du site, le commentaire
        | concerné a été masqué.
        |
        */

        $resolvedReportsCount = CommentReport::query()
            ->where(
                'status',
                'resolved'
            )
            ->count();


        /*
        |--------------------------------------------------------------------------
        | SIGNALEMENTS REJETÉS
        |--------------------------------------------------------------------------
        |
        | Ces signalements ont été étudiés mais n'ont pas entraîné
        | de modification du commentaire.
        |
        */

        $rejectedReportsCount = CommentReport::query()
            ->where(
                'status',
                'rejected'
            )
            ->count();


        /*
        |--------------------------------------------------------------------------
        | RÉCUPÉRATION DES SIGNALEMENTS
        |--------------------------------------------------------------------------
        |
        | with() charge les relations nécessaires à l'affichage de la
        | page afin d'éviter de multiplier les requêtes SQL.
        |
        */

        $reports = CommentReport::query()
            ->with([
                'user',
                'comment.user',
                'comment.article',
            ])
            ->latest()
            ->paginate(20);


        /*
        |--------------------------------------------------------------------------
        | AFFICHAGE DE LA VUE
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.comment-reports.index',
            [
                'reports' => $reports,

                /*
                |--------------------------------------------------------------------------
                | STATISTIQUES TRANSMISES À LA VUE
                |--------------------------------------------------------------------------
                */

                'totalReportsCount' => $totalReportsCount,

                'pendingReportsCount' => $pendingReportsCount,

                'reviewedReportsCount' => $reviewedReportsCount,

                'resolvedReportsCount' => $resolvedReportsCount,

                'rejectedReportsCount' => $rejectedReportsCount,
            ]
        );
    }


    /**
     * ============================================================
     * MARQUER UN SIGNALEMENT COMME EXAMINÉ
     * ============================================================
     *
     * Cette action permet à un administrateur d'indiquer qu'il a
     * pris connaissance du signalement.
     *
     * Le commentaire n'est pas modifié.
     *
     * Le signalement passe simplement :
     *
     * pending -> reviewed
     *
     * reviewed_at contient la date et l'heure de cette action.
     *
     * ============================================================
     */
    public function review(CommentReport $report): RedirectResponse
    {
        /*
        |--------------------------------------------------------------------------
        | Vérification du statut
        |--------------------------------------------------------------------------
        |
        | Un signalement déjà résolu ou rejeté ne doit pas pouvoir être
        | replacé dans l'état "reviewed" par cette action.
        |
        */

        if (in_array($report->status, ['resolved', 'rejected'], true)) {
            return redirect()
                ->route('admin.comment-reports.index')
                ->with(
                    'error',
                    'Ce signalement a déjà été traité.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Mise à jour du signalement
        |--------------------------------------------------------------------------
        */

        $report->update([
            'status' => 'reviewed',
            'reviewed_at' => now(),
        ]);


        /*
        |--------------------------------------------------------------------------
        | Retour vers la liste
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.comment-reports.index')
            ->with(
                'success',
                'Le signalement a été marqué comme examiné.'
            );
    }


    /**
     * ============================================================
     * REJETER UN SIGNALEMENT
     * ============================================================
     *
     * Cette action signifie que l'administration a étudié le
     * signalement mais considère qu'aucune intervention sur le
     * commentaire n'est nécessaire.
     *
     * Le commentaire reste donc dans son état actuel.
     *
     * Le signalement passe :
     *
     * pending/reviewed -> rejected
     *
     * ============================================================
     */
    public function reject(CommentReport $report): RedirectResponse
    {
        /*
        |--------------------------------------------------------------------------
        | Empêcher de retraiter un signalement résolu
        |--------------------------------------------------------------------------
        |
        | Un signalement ayant déjà entraîné une action de modération
        | ne doit pas pouvoir être rejeté ensuite.
        |
        */

        if ($report->status === 'resolved') {
            return redirect()
                ->route('admin.comment-reports.index')
                ->with(
                    'error',
                    'Ce signalement a déjà été résolu.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Signalement déjà rejeté
        |--------------------------------------------------------------------------
        */

        if ($report->status === 'rejected') {
            return redirect()
                ->route('admin.comment-reports.index')
                ->with(
                    'error',
                    'Ce signalement a déjà été rejeté.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Mise à jour
        |--------------------------------------------------------------------------
        */

        $report->update([
            'status' => 'rejected',
            'reviewed_at' => now(),
        ]);


        /*
        |--------------------------------------------------------------------------
        | Retour vers la liste
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.comment-reports.index')
            ->with(
                'success',
                'Le signalement a été rejeté. Le commentaire reste publié.'
            );
    }


    /**
     * ============================================================
     * MASQUER LE COMMENTAIRE ET RÉSOUDRE LE SIGNALEMENT
     * ============================================================
     *
     * Cette action est utilisée lorsque l'administration considère
     * que le signalement est justifié.
     *
     * Deux opérations doivent alors être réalisées :
     *
     * 1. masquer le commentaire ;
     * 2. passer le signalement au statut "resolved".
     *
     * Nous utilisons une transaction SQL afin que les deux opérations
     * soient considérées comme une seule action.
     *
     * Si une opération échoue, Laravel annule automatiquement
     * l'ensemble de la transaction.
     *
     * ============================================================
     */
    public function resolve(CommentReport $report): RedirectResponse
    {
        /*
        |--------------------------------------------------------------------------
        | Charger le commentaire
        |--------------------------------------------------------------------------
        |
        | Le signalement doit posséder un commentaire associé pour que
        | cette action puisse fonctionner.
        |
        */

        $report->loadMissing('comment');

        $comment = $report->comment;


        /*
        |--------------------------------------------------------------------------
        | Commentaire introuvable
        |--------------------------------------------------------------------------
        |
        | Cette situation pourrait notamment arriver si le commentaire
        | avait été définitivement supprimé.
        |
        */

        if (! $comment) {
            return redirect()
                ->route('admin.comment-reports.index')
                ->with(
                    'error',
                    'Le commentaire associé à ce signalement est introuvable.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Signalement déjà résolu
        |--------------------------------------------------------------------------
        */

        if ($report->status === 'resolved') {
            return redirect()
                ->route('admin.comment-reports.index')
                ->with(
                    'error',
                    'Ce signalement a déjà été résolu.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Signalement rejeté
        |--------------------------------------------------------------------------
        |
        | Une fois rejeté, nous considérons ici la décision comme
        | terminée. Cela évite qu'un simple clic ultérieur transforme
        | directement un rejet en suppression de contenu.
        |
        */

        if ($report->status === 'rejected') {
            return redirect()
                ->route('admin.comment-reports.index')
                ->with(
                    'error',
                    'Ce signalement a déjà été rejeté.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Transaction SQL
        |--------------------------------------------------------------------------
        |
        | Le commentaire et le signalement doivent être modifiés
        | ensemble.
        |
        */

        DB::transaction(function () use ($comment, $report) {

            /*
            |--------------------------------------------------------------------------
            | Masquer le commentaire
            |--------------------------------------------------------------------------
            |
            | Nous ne supprimons pas le commentaire.
            |
            | Son statut passe simplement à "hidden", ce qui permet de
            | conserver son historique et éventuellement de le republier
            | depuis la modération des commentaires.
            |
            */

            if ($comment->status !== 'hidden') {
                $comment->update([
                    'status' => 'hidden',
                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | Résoudre le signalement
            |--------------------------------------------------------------------------
            */

            $report->update([
                'status' => 'resolved',
                'reviewed_at' => now(),
            ]);
        });


        /*
        |--------------------------------------------------------------------------
        | Retour vers la liste
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.comment-reports.index')
            ->with(
                'success',
                'Le commentaire a été masqué et le signalement a été traité.'
            );
    }
}