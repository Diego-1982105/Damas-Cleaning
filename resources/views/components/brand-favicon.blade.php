@php
    $logoUrl = asset(config('branding.logo_path'));
@endphp
<link rel="icon" type="image/png" href="{{ $logoUrl }}">
<link rel="apple-touch-icon" href="{{ $logoUrl }}">
