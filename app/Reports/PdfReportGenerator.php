<?php

/**
 * Author: Wendy Atehortua
 * Date: 2026-11-06
 * Description: Concrete implementation of ReportGenerator for producing PDF reports of reservations using DomPDF.
 */

namespace App\Reports;

use App\Interfaces\ReportGenerator;
use App\Models\Reservation;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class PdfReportGenerator implements ReportGenerator
{
    private PDF $pdf;

    public function __construct(PDF $pdf)
    {
        $this->pdf = $pdf;
    }

    public function generate(Collection $reservations, array $metadata = []): Response
    {
        $totalReservations = $reservations->count();
        $confirmedCount = 0;
        $pendingCount = 0;
        $cancelledCount = 0;
        $completedCount = 0;

        foreach ($reservations as $reservation) {
            $state = $reservation->getState();
            if ($state === Reservation::STATE_CONFIRMED) {
                $confirmedCount++;
            } elseif ($state === Reservation::STATE_PENDING) {
                $pendingCount++;
            } elseif ($state === Reservation::STATE_CANCELLED) {
                $cancelledCount++;
            } elseif ($state === Reservation::STATE_COMPLETED) {
                $completedCount++;
            }
        }

        $cancellationRanking = $reservations
            ->filter(function (Reservation $reservation): bool {
                return $reservation->getState() === Reservation::STATE_CANCELLED
                    && ! empty($reservation->getCancellationReason());
            })
            ->groupBy(function (Reservation $reservation): string {
                return (string) $reservation->getCancellationReason();
            })
            ->map(function ($group): int {
                return $group->count();
            })
            ->sortDesc();

        $confirmedReservations = $reservations->filter(function (Reservation $reservation): bool {
            return $reservation->getState() === Reservation::STATE_CONFIRMED;
        });

        $viewData = [];
        $viewData['title'] = $metadata['title'] ?? __('reservation.confirmed_report_title');
        $viewData['reservations'] = $confirmedReservations;
        $viewData['totalReservations'] = $totalReservations;
        $viewData['confirmedCount'] = $confirmedCount;
        $viewData['pendingCount'] = $pendingCount;
        $viewData['cancelledCount'] = $cancelledCount;
        $viewData['completedCount'] = $completedCount;
        $viewData['cancellationRanking'] = $cancellationRanking;
        $viewData['generatedAt'] = Carbon::now()->format('Y-m-d H:i');
        $viewData['isPrintableDocument'] = true;

        $titleSlug = Str::slug(__('reservation.confirmed_report_title'), '_');
        $dateFormatted = Carbon::now()->format('Y-m-d_H-i');
        $fileName = $titleSlug.'_'.$dateFormatted.'.pdf';

        return $this->pdf
            ->loadView('admin.report.pdf', ['viewData' => $viewData])
            ->setPaper('a4', 'landscape')
            ->download($fileName);
    }
}
