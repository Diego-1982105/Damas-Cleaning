<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Damas Cleaning — professional residential cleaning services across the United States. Book a spotless home today.">
    <title>{{ config('app.name') }} — Residential Cleaning</title>
    <x-brand-favicon />
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=lato:400,700|montserrat:500,600,700" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased font-sans text-brand-body bg-brand-white">
    <div id="app"
         data-csrf="{{ csrf_token() }}"
         data-sections="{{ json_encode(\App\Models\SiteSection::enabledKeys()) }}"
    ></div>
</body>
</html>
