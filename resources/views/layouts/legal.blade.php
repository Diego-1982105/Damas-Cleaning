<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, follow">
    <title>@yield('title') — {{ config('app.name') }}</title>
    <x-brand-favicon />
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=lato:400,700|montserrat:500,600,700" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="antialiased font-sans text-brand-body bg-brand-white">

    {{-- Simple header --}}
    <header class="sticky top-0 z-40 border-b border-brand-navy/10 bg-white/95 shadow-sm backdrop-blur-md">
        <div class="mx-auto flex max-w-4xl items-center justify-between gap-4 px-4 py-3 sm:px-6">
            <a href="/" class="flex items-center gap-2.5" aria-label="Damas Cleaning — Home">
                <img
                    src="{{ asset(config('branding.logo_path')) }}"
                    alt=""
                    width="40"
                    height="40"
                    class="h-10 w-10 shrink-0 rounded-xl border border-brand-navy/10 object-cover shadow-sm"
                />
                <span class="font-heading text-base font-semibold tracking-tight text-brand-navy">
                    Damas <span class="text-brand-turquoise">Cleaning</span>
                </span>
            </a>
            <a
                href="/"
                class="rounded-full border border-brand-navy/15 px-4 py-2 text-sm font-medium text-brand-body transition hover:bg-brand-surface hover:text-brand-navy"
            >← Back to site</a>
        </div>
    </header>

    {{-- Page content --}}
    <main class="mx-auto max-w-4xl px-4 py-12 sm:px-6 sm:py-16 lg:py-20">
        @yield('content')
    </main>

    {{-- Simple footer --}}
    <footer class="border-t border-brand-navy/10 bg-brand-surface py-8">
        <div class="mx-auto max-w-4xl px-4 sm:px-6">
            <div class="flex flex-col items-center justify-between gap-4 text-sm text-brand-body sm:flex-row">
                <p>© {{ date('Y') }} Damas Cleaning. All rights reserved.</p>
                <nav class="flex gap-5">
                    <a href="/privacy-policy" class="transition hover:text-brand-navy">Privacy Policy</a>
                    <a href="/terms-of-service" class="transition hover:text-brand-navy">Terms of Service</a>
                    <a href="/#contact" class="transition hover:text-brand-navy">Contact Us</a>
                </nav>
            </div>
        </div>
    </footer>

</body>
</html>
