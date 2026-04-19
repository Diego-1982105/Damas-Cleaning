<?php

namespace App\Support;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf as PdfFacade;
use Barryvdh\DomPDF\PDF;

final class InvoicePdfFactory
{
    public static function make(Invoice $invoice): PDF
    {
        $invoice->loadMissing(['client', 'items']);

        $relativeLogo = trim((string) config('branding.logo_path', ''));
        $logoPath = $relativeLogo !== '' ? public_path($relativeLogo) : '';
        $logoBase64 = null;
        if ($logoPath !== '' && is_readable($logoPath)) {
            $ext = strtolower(pathinfo($logoPath, PATHINFO_EXTENSION));
            $mime = match ($ext) {
                'jpg', 'jpeg' => 'image/jpeg',
                'gif' => 'image/gif',
                'webp' => 'image/webp',
                default => 'image/png',
            };
            $logoBase64 = 'data:'.$mime.';base64,'.base64_encode((string) file_get_contents($logoPath));
        }

        return PdfFacade::loadView('invoices.pdf', [
            'invoice' => $invoice,
            'company' => config('invoice'),
            'logoBase64' => $logoBase64,
        ])->setPaper('letter', 'portrait');
    }

    public static function downloadFilename(Invoice $invoice): string
    {
        return 'Damas-Invoice-'.$invoice->id.'.pdf';
    }
}
