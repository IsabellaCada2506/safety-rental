<?php

/**
 * Author: Wendy Atehortua
 * Date: 2026-11-06
 * Description: Concrete implementation of ReportGenerator producing professional styled Microsoft Excel (.xlsx) OpenXML workbooks.
 */

namespace App\Reports;

use App\Interfaces\ReportGenerator;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use ZipArchive;

class ExcelReportGenerator implements ReportGenerator
{
    public function generate(Collection $reservations, array $metadata = []): SymfonyResponse
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

        $grid = [];

        $title = $metadata['title'] ?? __('reservation.report_title');
        $grid[] = [
            ['value' => $title, 'style' => 1],
        ];

        $grid[] = [
            ['value' => __('reservation.generated_at').': '.Carbon::now()->format('Y-m-d H:i'), 'style' => 2],
        ];
        $grid[] = [];

        $grid[] = [
            ['value' => __('reservation.executive_summary_title'), 'style' => 3],
            ['value' => '', 'style' => 3],
        ];

        $summaryMetrics = [
            [__('reservation.total_reservations'), (string) $totalReservations],
            [__('reservation.state_confirmed'), (string) $confirmedCount],
            [__('reservation.state_pending'), (string) $pendingCount],
            [__('reservation.state_cancelled'), (string) $cancelledCount],
            [__('reservation.state_completed'), (string) $completedCount],
        ];

        foreach ($summaryMetrics as $metric) {
            $grid[] = [
                ['value' => $metric[0], 'style' => 5],
                ['value' => $metric[1], 'style' => 6],
            ];
        }

        $grid[] = [];

        if ($cancellationRanking->isNotEmpty()) {
            $grid[] = [
                ['value' => __('reservation.cancellation_ranking_title'), 'style' => 3],
                ['value' => '', 'style' => 3],
            ];
            $grid[] = [
                ['value' => __('reservation.cancellation_reason_label'), 'style' => 4],
                ['value' => __('reservation.cancellation_count'), 'style' => 4],
            ];
            $rankIndex = 0;
            foreach ($cancellationRanking as $reason => $count) {
                $rowStyle = ($rankIndex % 2 === 1) ? 7 : 0;
                $grid[] = [
                    ['value' => (string) $reason, 'style' => $rowStyle],
                    ['value' => (string) $count, 'style' => $rowStyle],
                ];
                $rankIndex++;
            }
            $grid[] = [];
        }

        $grid[] = [
            ['value' => __('reservation.reservations_list_title'), 'style' => 3],
            ['value' => '', 'style' => 3],
            ['value' => '', 'style' => 3],
            ['value' => '', 'style' => 3],
            ['value' => '', 'style' => 3],
            ['value' => '', 'style' => 3],
            ['value' => '', 'style' => 3],
            ['value' => '', 'style' => 3],
            ['value' => '', 'style' => 3],
        ];

        $headers = [
            __('reservation.code'),
            __('reservation.customer'),
            __('reservation.vehicle'),
            __('reservation.car_license_plate'),
            __('reservation.pickup_location'),
            __('reservation.start_date'),
            __('reservation.end_date'),
            __('reservation.status'),
            __('reservation.cancellation_reason_label'),
        ];

        $headerRow = [];
        foreach ($headers as $headerText) {
            $headerRow[] = ['value' => $headerText, 'style' => 4];
        }
        $grid[] = $headerRow;

        $dataRowIndex = 0;
        foreach ($reservations as $reservation) {
            $car = $reservation->getCar();
            $category = $car?->getCategory();
            $user = $reservation->getUser();
            $location = $reservation->getLocation();

            $vehicleName = $category ? trim($category->getBrand().' '.$category->getModel()) : 'N/A';
            $startDate = $reservation->getStartDate() ? $reservation->getStartDate()->format('Y-m-d') : 'N/A';
            $endDate = $reservation->getEndDate() ? $reservation->getEndDate()->format('Y-m-d') : 'N/A';

            $stateKey = 'reservation.state_'.$reservation->getState();
            $stateLabel = __($stateKey);

            $rowStyle = ($dataRowIndex % 2 === 1) ? 7 : 0;

            $grid[] = [
                ['value' => '#'.$reservation->getCode(), 'style' => $rowStyle],
                ['value' => $user ? $user->getName() : 'N/A', 'style' => $rowStyle],
                ['value' => $vehicleName, 'style' => $rowStyle],
                ['value' => $car ? $car->getPlate() : 'N/A', 'style' => $rowStyle],
                ['value' => $location ? $location->getName() : 'N/A', 'style' => $rowStyle],
                ['value' => $startDate, 'style' => $rowStyle],
                ['value' => $endDate, 'style' => $rowStyle],
                ['value' => $stateLabel, 'style' => $rowStyle],
                ['value' => $reservation->getCancellationReason() ?? '—', 'style' => $rowStyle],
            ];
            $dataRowIndex++;
        }

        $xlsxContent = $this->buildXlsx($grid);

        $titleSlug = Str::slug(__('reservation.report_title'), '_');
        $dateFormatted = Carbon::now()->format('Y-m-d_H-i');
        $fileName = $titleSlug.'_'.$dateFormatted.'.xlsx';

        return new Response($xlsxContent, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="'.$fileName.'"',
            'Cache-Control' => 'max-age=0, no-cache, no-store, must-revalidate',
            'Pragma' => 'public',
        ]);
    }

    /**
     * Build an OpenXML Spreadsheet (.xlsx) binary buffer.
     *
     * @param  array<int, array<int, array<string, mixed>>>  $grid
     */
    private function buildXlsx(array $grid): string
    {
        $sheetXml = $this->buildSheetXml($grid);
        $tempFilePath = tempnam(sys_get_temp_dir(), 'SR_XLSX_');

        $zip = new ZipArchive;
        $zip->open($tempFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        $zip->addFromString('[Content_Types].xml', $this->getContentTypesXml());
        $zip->addFromString('_rels/.rels', $this->getRootRelsXml());
        $zip->addFromString('xl/_rels/workbook.xml.rels', $this->getWorkbookRelsXml());
        $zip->addFromString('xl/workbook.xml', $this->getWorkbookXml());
        $zip->addFromString('xl/styles.xml', $this->getStylesXml());
        $zip->addFromString('xl/worksheets/sheet1.xml', $sheetXml);

        $zip->close();

        $content = (string) file_get_contents($tempFilePath);
        @unlink($tempFilePath);

        return $content;
    }

    /**
     * Build the worksheet XML representation for the grid.
     *
     * @param  array<int, array<int, array<string, mixed>>>  $grid
     */
    private function buildSheetXml(array $grid): string
    {
        $xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'."\n";
        $xml .= '<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'."\n";
        $xml .= '<sheetViews><sheetView tabSelected="1" workbookViewId="0"/></sheetViews>'."\n";
        $xml .= '<sheetFormatPr defaultRowHeight="20"/>'."\n";
        $xml .= '<cols>';
        $xml .= '<col min="1" max="1" width="16" customWidth="1"/>';
        $xml .= '<col min="2" max="2" width="28" customWidth="1"/>';
        $xml .= '<col min="3" max="3" width="30" customWidth="1"/>';
        $xml .= '<col min="4" max="4" width="18" customWidth="1"/>';
        $xml .= '<col min="5" max="5" width="24" customWidth="1"/>';
        $xml .= '<col min="6" max="6" width="16" customWidth="1"/>';
        $xml .= '<col min="7" max="7" width="16" customWidth="1"/>';
        $xml .= '<col min="8" max="8" width="18" customWidth="1"/>';
        $xml .= '<col min="9" max="9" width="32" customWidth="1"/>';
        $xml .= '</cols>'."\n";
        $xml .= '<sheetData>'."\n";

        $rowIndex = 1;
        foreach ($grid as $row) {
            $xml .= '<row r="'.$rowIndex.'">'."\n";

            $colIndex = 0;
            foreach ($row as $cell) {
                $cellRef = $this->getColumnLetter($colIndex).$rowIndex;
                $cellValue = (string) ($cell['value'] ?? '');
                $styleIndex = (string) ($cell['style'] ?? '0');
                $escapedValue = htmlspecialchars($cellValue, ENT_XML1 | ENT_QUOTES, 'UTF-8');
                $xml .= '<c r="'.$cellRef.'" s="'.$styleIndex.'" t="inlineStr"><is><t>'.$escapedValue.'</t></is></c>'."\n";
                $colIndex++;
            }

            $xml .= '</row>'."\n";
            $rowIndex++;
        }

        $xml .= '</sheetData>'."\n";
        $xml .= '</worksheet>';

        return $xml;
    }

    private function getColumnLetter(int $colIndex): string
    {
        $letters = '';
        while ($colIndex >= 0) {
            $letters = chr(($colIndex % 26) + 65).$letters;
            $colIndex = intval($colIndex / 26) - 1;
        }

        return $letters;
    }

    private function getContentTypesXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'."\n"
            .'<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">'."\n"
            .'<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>'."\n"
            .'<Default Extension="xml" ContentType="application/xml"/>'."\n"
            .'<Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>'."\n"
            .'<Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>'."\n"
            .'<Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/>'."\n"
            .'</Types>';
    }

    private function getRootRelsXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'."\n"
            .'<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'."\n"
            .'<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>'."\n"
            .'</Relationships>';
    }

    private function getWorkbookRelsXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'."\n"
            .'<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'."\n"
            .'<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>'."\n"
            .'<Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/>'."\n"
            .'</Relationships>';
    }

    private function getWorkbookXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'."\n"
            .'<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'."\n"
            .'<sheets><sheet name="Reservations Report" sheetId="1" r:id="rId1"/></sheets>'."\n"
            .'</workbook>';
    }

    /**
     * Styles configuration with borders, corporate fills and typography hierarchy.
     */
    private function getStylesXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'."\n"
            .'<styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'."\n"
            .'<fonts count="5">'."\n"
            .'<font><sz val="10"/><name val="Segoe UI"/></font>'."\n"
            .'<font><b/><sz val="15"/><color rgb="FF0F172A"/><name val="Segoe UI"/></font>'."\n"
            .'<font><i/><sz val="9"/><color rgb="FF64748B"/><name val="Segoe UI"/></font>'."\n"
            .'<font><b/><sz val="11"/><color rgb="FFFFFFFF"/><name val="Segoe UI"/></font>'."\n"
            .'<font><b/><sz val="10"/><color rgb="FF1E293B"/><name val="Segoe UI"/></font>'."\n"
            .'</fonts>'."\n"
            .'<fills count="6">'."\n"
            .'<fill><patternFill patternType="none"/></fill>'."\n"
            .'<fill><patternFill patternType="gray125"/></fill>'."\n"
            .'<fill><patternFill patternType="solid"><fgColor rgb="FF0F2A4A"/></patternFill></fill>'."\n"
            .'<fill><patternFill patternType="solid"><fgColor rgb="FF2563EB"/></patternFill></fill>'."\n"
            .'<fill><patternFill patternType="solid"><fgColor rgb="FFF1F5F9"/></patternFill></fill>'."\n"
            .'<fill><patternFill patternType="solid"><fgColor rgb="FFF8FAFC"/></patternFill></fill>'."\n"
            .'</fills>'."\n"
            .'<borders count="2">'."\n"
            .'<border><left/><right/><top/><bottom/></border>'."\n"
            .'<border>'."\n"
            .'<left style="thin"><color rgb="FFCBD5E1"/></left>'."\n"
            .'<right style="thin"><color rgb="FFCBD5E1"/></right>'."\n"
            .'<top style="thin"><color rgb="FFCBD5E1"/></top>'."\n"
            .'<bottom style="thin"><color rgb="FFCBD5E1"/></bottom>'."\n"
            .'</border>'."\n"
            .'</borders>'."\n"
            .'<cellStyleXfs count="1">'."\n"
            .'<xf numFmtId="0" fontId="0" fillId="0" borderId="0"/>'."\n"
            .'</cellStyleXfs>'."\n"
            .'<cellXfs count="8">'."\n"
            .'<xf numFmtId="0" fontId="0" fillId="0" borderId="1" xfId="0" applyFont="1" applyBorder="1"/>'."\n"
            .'<xf numFmtId="0" fontId="1" fillId="0" borderId="0" xfId="0" applyFont="1"/>'."\n"
            .'<xf numFmtId="0" fontId="2" fillId="0" borderId="0" xfId="0" applyFont="1"/>'."\n"
            .'<xf numFmtId="0" fontId="3" fillId="2" borderId="1" xfId="0" applyFont="1" applyFill="1" applyBorder="1"/>'."\n"
            .'<xf numFmtId="0" fontId="3" fillId="3" borderId="1" xfId="0" applyFont="1" applyFill="1" applyBorder="1"/>'."\n"
            .'<xf numFmtId="0" fontId="4" fillId="4" borderId="1" xfId="0" applyFont="1" applyFill="1" applyBorder="1"/>'."\n"
            .'<xf numFmtId="0" fontId="4" fillId="0" borderId="1" xfId="0" applyFont="1" applyBorder="1"/>'."\n"
            .'<xf numFmtId="0" fontId="0" fillId="5" borderId="1" xfId="0" applyFont="1" applyFill="1" applyBorder="1"/>'."\n"
            .'</cellXfs>'."\n"
            .'</styleSheet>';
    }
}
