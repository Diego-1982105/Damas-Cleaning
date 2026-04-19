<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Company block (printed PDF invoice header)
    |--------------------------------------------------------------------------
    */

    'company_name' => env('INVOICE_COMPANY_NAME', 'DAMAS Cleaning Home Services'),

    'company_address' => env('INVOICE_COMPANY_ADDRESS', '717 Kestrel Dr. Loganville, GA 30052'),

    'company_phones' => env('INVOICE_COMPANY_PHONES', '678-525-6816 / 678-382-7724'),

    /*
    |--------------------------------------------------------------------------
    | Invoice number on PDF: optional prefix + zero-padded ID
    |--------------------------------------------------------------------------
    */

    'number_prefix' => env('INVOICE_NUMBER_PREFIX', ''),

    'number_pad' => (int) env('INVOICE_NUMBER_PAD', 8),

    'terms' => env('INVOICE_TERMS', 'Due on receipt'),

    'payment_method' => env('INVOICE_PAYMENT_METHOD', 'Cash only'),

];
