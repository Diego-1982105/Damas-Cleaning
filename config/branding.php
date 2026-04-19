<?php

$logoPath = env('BRAND_LOGO_PATH', 'images/damas-logo.png');

return [

    /*
    |--------------------------------------------------------------------------
    | Company logo (served from public/)
    |--------------------------------------------------------------------------
    |
    | Used for favicon / apple-touch-icon, site header & footer, and invoice PDF.
    | logo_href is root-relative so it stays HTTPS when the page is HTTPS even if
    | APP_URL is misconfigured (e.g. http behind a TLS-terminating proxy).
    |
    */

    'logo_path' => $logoPath,

    'logo_href' => '/'.ltrim((string) $logoPath, '/'),

];
