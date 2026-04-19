<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — {{ config('app.name') }}</title>
    <x-brand-favicon />
    @vite(['resources/css/app.css'])
    @stack('styles')
    {{-- Prevent dark-mode flash before CSS loads --}}
    <script>
    (function(){try{var d=localStorage.getItem('admin-dark-mode');if(d==='1'||(d===null&&window.matchMedia('(prefers-color-scheme: dark)').matches)){document.documentElement.classList.add('dark');}}catch(e){}})();
    </script>
    <style>
        /* ── Sidebar transitions ── */
        #admin-sidebar {
            transition: width .22s cubic-bezier(.4,0,.2,1), transform .22s cubic-bezier(.4,0,.2,1);
            width: 16rem; /* 256px expanded */
        }
        #sidebar-overlay { transition: opacity .22s ease; }

        /* ── Mobile: oculto por defecto, visible cuando is-open ── */
        @media (max-width: 1023px) {
            #admin-sidebar              { transform: translateX(-100%); }
            #admin-sidebar.is-open      { transform: translateX(0); }
        }

        /* ── Collapsed desktop state ── */
        @media (min-width: 1024px) {
            #admin-sidebar              { transform: translateX(0) !important; }
            #admin-shell[data-collapsed="true"] #admin-sidebar { width: 4.5rem; }

            /* Hide text labels when collapsed */
            #admin-shell[data-collapsed="true"] .sb-label,
            #admin-shell[data-collapsed="true"] .sb-section,
            #admin-shell[data-collapsed="true"] .sb-brand-text,
            #admin-shell[data-collapsed="true"] .sb-footer { display: none; }

            /* Center nav icons when collapsed */
            #admin-shell[data-collapsed="true"] #admin-sidebar nav a {
                justify-content: center;
                padding-left: 0;
                padding-right: 0;
            }

            /* Center logo when collapsed */
            #admin-shell[data-collapsed="true"] .sb-brand-row {
                justify-content: center;
                padding: 1rem 0;
            }

            /* Center footer avatar */
            #admin-shell[data-collapsed="true"] .sb-footer-row {
                justify-content: center;
                padding: 1rem 0;
            }
        }

        /* ══════════════════════════════════════════════════
           DARK MODE — applied when <html class="dark">
           CSS overrides cover all 21 admin view files
           ══════════════════════════════════════════════════ */

        html.dark { color-scheme: dark; }
        html.dark body { background-color: #0f172a; color: #cbd5e1; }

        /* Backgrounds */
        html.dark .bg-white           { background-color: #1e293b; }
        html.dark .bg-white\/90       { background-color: rgba(15,23,42,.92); }
        html.dark .bg-white\/95       { background-color: rgba(15,23,42,.95); }
        html.dark .bg-slate-50        { background-color: #0f172a; }
        html.dark .bg-slate-100       { background-color: #1e293b; }
        html.dark .bg-slate-200       { background-color: #334155; }
        html.dark .bg-gray-50         { background-color: #0f172a; }
        html.dark .bg-gray-100        { background-color: #1e293b; }
        html.dark .bg-gray-200        { background-color: #334155; }
        html.dark .bg-brand-surface   { background-color: #2d1528; }
        html.dark .bg-brand-turquoise\/15 { background-color: rgba(77,184,208,.12); }

        /* Borders */
        html.dark .border-slate-100   { border-color: #334155; }
        html.dark .border-slate-200   { border-color: #334155; }
        html.dark .border-slate-300   { border-color: #475569; }
        html.dark .border-gray-200    { border-color: #334155; }
        html.dark .border-gray-300    { border-color: #475569; }
        html.dark .ring-black\/5      { --tw-ring-color: rgba(255,255,255,.05); }

        /* Dividers */
        html.dark .divide-slate-100 > :not([hidden]) ~ :not([hidden]) { border-color: #334155; }
        html.dark .divide-slate-200 > :not([hidden]) ~ :not([hidden]) { border-color: #334155; }
        html.dark .divide-gray-200  > :not([hidden]) ~ :not([hidden]) { border-color: #334155; }

        /* Text */
        html.dark .text-slate-900, html.dark .text-gray-900 { color: #f1f5f9; }
        html.dark .text-slate-800, html.dark .text-gray-800 { color: #e2e8f0; }
        html.dark .text-slate-700, html.dark .text-gray-700 { color: #cbd5e1; }
        html.dark .text-slate-600, html.dark .text-gray-600 { color: #94a3b8; }
        html.dark .text-slate-500, html.dark .text-gray-500 { color: #64748b; }
        html.dark .text-slate-400, html.dark .text-gray-400 { color: #94a3b8; }
        html.dark .text-brand-navy  { color: #fda4af; }
        html.dark .text-brand-body  { color: #cbd5e1; }

        /* Hover backgrounds */
        html.dark .hover\:bg-slate-50:hover   { background-color: #1e293b; }
        html.dark .hover\:bg-slate-100:hover  { background-color: #334155; }
        html.dark .hover\:bg-slate-200:hover  { background-color: #475569; }
        html.dark .hover\:bg-gray-50:hover    { background-color: #1e293b; }
        html.dark .hover\:bg-gray-100:hover   { background-color: #334155; }
        html.dark .hover\:text-brand-navy:hover  { color: #fda4af; }
        html.dark .hover\:text-slate-600:hover   { color: #94a3b8; }
        html.dark .hover\:bg-red-100:hover    { background-color: rgba(69,10,10,.5); }

        /* Form elements */
        html.dark input:not([type="checkbox"]):not([type="radio"]):not([type="submit"]):not([type="button"]):not([type="range"]):not([type="color"]),
        html.dark select,
        html.dark textarea {
            background-color: #0f172a;
            border-color: #475569;
            color: #e2e8f0;
        }
        html.dark input::placeholder,
        html.dark textarea::placeholder { color: #475569; }

        /* Status / semantic colours */
        html.dark .bg-emerald-50,
        html.dark .bg-emerald-100      { background-color: rgba(6,78,59,.25); }
        html.dark .border-emerald-200  { border-color: #065f46; }
        html.dark .text-emerald-800,
        html.dark .text-emerald-700    { color: #6ee7b7; }
        html.dark .text-emerald-600    { color: #34d399; }

        html.dark .bg-red-50,
        html.dark .bg-red-100          { background-color: rgba(69,10,10,.3); }
        html.dark .border-red-200      { border-color: #991b1b; }
        html.dark .text-red-700,
        html.dark .text-red-800        { color: #fca5a5; }
        html.dark .text-red-600        { color: #f87171; }

        html.dark .bg-yellow-50,
        html.dark .bg-yellow-100       { background-color: rgba(78,52,8,.3); }
        html.dark .text-yellow-800,
        html.dark .text-yellow-700     { color: #fcd34d; }

        html.dark .bg-blue-50,
        html.dark .bg-blue-100         { background-color: rgba(23,37,84,.4); }
        html.dark .text-blue-800,
        html.dark .text-blue-700       { color: #93c5fd; }

        html.dark .bg-purple-50,
        html.dark .bg-purple-100       { background-color: rgba(46,16,101,.3); }
        html.dark .text-purple-800,
        html.dark .text-purple-700     { color: #c4b5fd; }

        html.dark .bg-orange-50,
        html.dark .bg-orange-100       { background-color: rgba(67,20,7,.3); }
        html.dark .text-orange-800,
        html.dark .text-orange-700     { color: #fdba74; }

        html.dark .bg-green-50,
        html.dark .bg-green-100        { background-color: rgba(6,78,59,.25); }
        html.dark .text-green-800,
        html.dark .text-green-700      { color: #6ee7b7; }
        html.dark .border-green-200    { border-color: #065f46; }
        html.dark .text-green-600      { color: #34d399; }

        html.dark .bg-rose-50,
        html.dark .bg-rose-100         { background-color: rgba(76,5,25,.3); }
        html.dark .text-rose-800,
        html.dark .text-rose-700       { color: #fda4af; }
        html.dark .text-rose-600       { color: #fb7185; }

        /* Shadows */
        html.dark .shadow-sm  { box-shadow: 0 1px 2px 0 rgba(0,0,0,.6); }
        html.dark .shadow     { box-shadow: 0 1px 3px 0 rgba(0,0,0,.6),0 1px 2px -1px rgba(0,0,0,.5); }
        html.dark .shadow-md  { box-shadow: 0 4px 6px -1px rgba(0,0,0,.6),0 2px 4px -2px rgba(0,0,0,.5); }
        html.dark .shadow-lg  { box-shadow: 0 10px 15px -3px rgba(0,0,0,.7),0 4px 6px -4px rgba(0,0,0,.5); }
        html.dark .shadow-xl  { box-shadow: 0 20px 25px -5px rgba(0,0,0,.75),0 8px 10px -6px rgba(0,0,0,.6); }

        /* ── Toasts ── */
        .toast {
            position: relative;
            transform: translateX(0);
            opacity: 1;
        }
        .toast.toast-hide {
            transform: translateX(110%);
            opacity: 0;
            pointer-events: none;
        }
        .toast-bar {
            transition: transform linear;
            transform-origin: left;
        }
    </style>
</head>

@php
    $opOpen   = request()->routeIs('admin.clientes.*', 'admin.facturas.*', 'admin.leads.*');
    $cfgOpen  = request()->routeIs('admin.configuracion.*');
    $tmOpen   = request()->routeIs('admin.usuarios.*');
    $user     = auth()->user();
    $initials = $user ? strtoupper(substr($user->name ?? 'A', 0, 1)) : 'A';
@endphp

<body class="min-h-screen bg-slate-50 font-sans text-brand-body antialiased">
@auth
<div id="admin-shell" class="flex min-h-screen" data-collapsed="false">

    {{-- ─── MOBILE OVERLAY ─── --}}
    <div
        id="sidebar-overlay"
        class="pointer-events-none fixed inset-0 z-20 bg-brand-navy/50 opacity-0 backdrop-blur-sm lg:hidden"
        aria-hidden="true"
    ></div>

    {{-- ─── SIDEBAR ─── --}}
    <aside
        id="admin-sidebar"
        class="fixed inset-y-0 left-0 z-30 flex flex-col overflow-hidden bg-white shadow-xl ring-1 ring-black/5 lg:sticky lg:top-0 lg:h-screen lg:shadow-none lg:ring-0 lg:border-r lg:border-slate-200"
    >
        {{-- Brand header --}}
        <div class="sb-brand-row flex shrink-0 items-center gap-3 border-b border-slate-100 px-5 py-4">
            <img
                src="{{ config('branding.logo_href') }}"
                alt="Logo"
                class="h-9 w-9 shrink-0 rounded-xl object-cover"
            />
            <div class="sb-brand-text min-w-0 flex-1 leading-tight">
                <p class="truncate font-heading text-sm font-bold text-brand-navy">{{ config('app.name') }}</p>
                <p class="text-[10px] font-medium uppercase tracking-widest text-brand-turquoise">Admin Panel</p>
            </div>
            {{-- Close button (mobile only) --}}
            <button
                id="sidebar-close-btn"
                type="button"
                aria-label="Close menu"
                class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg text-slate-400 hover:bg-slate-100 lg:hidden"
            >
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Navigation --}}
        <nav class="flex min-h-0 flex-1 flex-col gap-0.5 overflow-y-auto overflow-x-hidden px-3 py-4 text-[13px]" aria-label="Main">

            <a href="{{ route('admin.dashboard') }}" title="Dashboard"
               class="flex items-center gap-3 rounded-xl px-3 py-2.5 font-medium transition-colors
                      {{ request()->routeIs('admin.dashboard') ? 'bg-brand-navy text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-brand-navy' }}">
                <x-admin.sidebar-icon name="home" class="h-4 w-4 shrink-0" />
                <span class="sb-label">Dashboard</span>
            </a>

            @canany(['manage_clients', 'manage_invoices', 'manage_leads'])
            <p class="sb-section mt-4 mb-1 px-3 text-[10px] font-semibold uppercase tracking-widest text-slate-400">Operations</p>
            @endcanany

            @can('manage_clients')
            <a href="{{ route('admin.clientes.index') }}" title="Clients"
               class="flex items-center gap-3 rounded-xl px-3 py-2.5 font-medium transition-colors
                      {{ request()->routeIs('admin.clientes.*') ? 'bg-brand-turquoise/15 text-brand-navy' : 'text-slate-600 hover:bg-slate-100 hover:text-brand-navy' }}">
                <x-admin.sidebar-icon name="users" class="h-4 w-4 shrink-0" />
                <span class="sb-label">Clients</span>
            </a>
            @endcan

            @can('manage_invoices')
            <a href="{{ route('admin.facturas.index') }}" title="Invoices"
               class="flex items-center gap-3 rounded-xl px-3 py-2.5 font-medium transition-colors
                      {{ request()->routeIs('admin.facturas.*') ? 'bg-brand-turquoise/15 text-brand-navy' : 'text-slate-600 hover:bg-slate-100 hover:text-brand-navy' }}">
                <x-admin.sidebar-icon name="document" class="h-4 w-4 shrink-0" />
                <span class="sb-label">Invoices</span>
            </a>
            @endcan

            @can('manage_leads')
            <a href="{{ route('admin.leads.index') }}" title="Leads"
               class="flex items-center gap-3 rounded-xl px-3 py-2.5 font-medium transition-colors
                      {{ request()->routeIs('admin.leads.*') ? 'bg-brand-turquoise/15 text-brand-navy' : 'text-slate-600 hover:bg-slate-100 hover:text-brand-navy' }}">
                <x-admin.sidebar-icon name="clipboard" class="h-4 w-4 shrink-0" />
                <span class="sb-label">Leads</span>
            </a>
            @endcan

            @canany(['manage_services', 'manage_site_sections'])
            <p class="sb-section mt-4 mb-1 px-3 text-[10px] font-semibold uppercase tracking-widest text-slate-400">Settings</p>
            @endcanany

            @can('manage_services')
            <a href="{{ route('admin.configuracion.servicios.index') }}" title="Services & Pricing"
               class="flex items-center gap-3 rounded-xl px-3 py-2.5 font-medium transition-colors
                      {{ request()->routeIs('admin.configuracion.servicios.*') ? 'bg-brand-turquoise/15 text-brand-navy' : 'text-slate-600 hover:bg-slate-100 hover:text-brand-navy' }}">
                <x-admin.sidebar-icon name="cog" class="h-4 w-4 shrink-0" />
                <span class="sb-label">Services &amp; Pricing</span>
            </a>
            @endcan

            @can('manage_site_sections')
            <a href="{{ route('admin.configuracion.secciones.index') }}" title="Secciones del Sitio"
               class="flex items-center gap-3 rounded-xl px-3 py-2.5 font-medium transition-colors
                      {{ request()->routeIs('admin.configuracion.secciones.*') ? 'bg-brand-turquoise/15 text-brand-navy' : 'text-slate-600 hover:bg-slate-100 hover:text-brand-navy' }}">
                <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 7.125C2.25 6.504 2.754 6 3.375 6h6c.621 0 1.125.504 1.125 1.125v3.75c0 .621-.504 1.125-1.125 1.125h-6a1.125 1.125 0 0 1-1.125-1.125v-3.75ZM14.25 8.625c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v8.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 0 1-1.125-1.125v-8.25ZM3.75 16.125c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v2.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 0 1-1.125-1.125v-2.25Z"/>
                </svg>
                <span class="sb-label">Secciones del Sitio</span>
            </a>
            @endcan

            @if ($user?->isOwner())
                <a href="{{ route('admin.usuarios.index') }}" title="Team"
                   class="flex items-center gap-3 rounded-xl px-3 py-2.5 font-medium transition-colors
                          {{ request()->routeIs('admin.usuarios.*') ? 'bg-brand-turquoise/15 text-brand-navy' : 'text-slate-600 hover:bg-slate-100 hover:text-brand-navy' }}">
                    <x-admin.sidebar-icon name="user-group" class="h-4 w-4 shrink-0" />
                    <span class="sb-label">Team</span>
                </a>
            @endif
        </nav>

        {{-- User footer --}}
        <div class="shrink-0 border-t border-slate-100 p-4">
            <div class="sb-footer-row flex items-center gap-3">
                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-brand-navy text-sm font-bold text-white">{{ $initials }}</span>
                <div class="sb-footer min-w-0 flex-1">
                    <p class="truncate text-sm font-semibold text-brand-navy">{{ $user?->name }}</p>
                    <p class="truncate text-xs text-slate-400">{{ $user?->roleLabel() }}</p>
                </div>
            </div>
            <div class="sb-footer mt-3 flex gap-2">
                <a href="{{ url('/') }}" target="_blank" rel="noopener"
                   class="flex flex-1 items-center justify-center gap-1.5 rounded-lg border border-slate-200 py-1.5 text-xs font-medium text-slate-600 hover:bg-slate-50">
                    <x-admin.sidebar-icon name="external" class="h-3.5 w-3.5" />
                    Public site
                </a>
                <form method="POST" action="{{ route('admin.logout') }}" class="flex-1">
                    @csrf
                    <button type="submit"
                            class="flex w-full items-center justify-center gap-1.5 rounded-lg bg-red-50 py-1.5 text-xs font-medium text-red-600 hover:bg-red-100">
                        <x-admin.sidebar-icon name="logout" class="h-3.5 w-3.5" />
                        Sign out
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- ─── MAIN COLUMN ─── --}}
    <div class="flex min-w-0 flex-1 flex-col">

        {{-- TOP BAR --}}
        <header class="sticky top-0 z-10 flex h-14 shrink-0 items-center gap-3 border-b border-slate-200 bg-white/90 px-4 backdrop-blur-sm sm:px-6">

            {{-- Desktop collapse toggle --}}
            <button
                id="sidebar-collapse-btn"
                type="button"
                aria-label="Toggle sidebar"
                class="hidden h-9 w-9 shrink-0 items-center justify-center rounded-xl border border-slate-200 text-slate-500 hover:bg-slate-100 lg:flex"
            >
                <svg id="collapse-icon-expand" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5"/>
                </svg>
                <svg id="collapse-icon-collapse" class="hidden h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12H12m-8.25 5.25h16.5"/>
                </svg>
            </button>

            {{-- Mobile hamburger --}}
            <button
                id="sidebar-open-btn"
                type="button"
                aria-label="Open menu"
                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl border border-slate-200 text-slate-500 hover:bg-slate-100 lg:hidden"
            >
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            <div class="flex min-w-0 flex-1 items-center gap-2">
                <img src="{{ config('branding.logo_href') }}" alt="" class="h-7 w-7 shrink-0 rounded-lg object-cover lg:hidden" />
                <h1 class="truncate font-heading text-sm font-semibold text-brand-navy sm:text-base">
                    @yield('title', 'Dashboard')
                </h1>
            </div>

            <div class="flex shrink-0 items-center gap-2">
                <a href="{{ url('/') }}" target="_blank" rel="noopener"
                   class="hidden items-center gap-1.5 rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-medium text-slate-600 hover:bg-slate-50 sm:inline-flex">
                    <x-admin.sidebar-icon name="external" class="h-3.5 w-3.5" />
                    <span class="hidden md:inline">Public site</span>
                </a>

                {{-- ── Dark mode toggle ── --}}
                <button
                    id="dark-mode-toggle"
                    type="button"
                    aria-label="Toggle dark mode"
                    class="flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 text-slate-500 hover:bg-slate-100 transition-colors"
                    title="Toggle dark mode"
                >
                    {{-- Moon: shown in light mode --}}
                    <svg id="dm-moon" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z"/>
                    </svg>
                    {{-- Sun: shown in dark mode --}}
                    <svg id="dm-sun" class="hidden h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z"/>
                    </svg>
                </button>

                {{-- ── Bell notification ── --}}
                <div id="notif-wrapper" class="relative">
                    <button
                        id="notif-btn"
                        type="button"
                        aria-label="Notifications"
                        aria-haspopup="true"
                        aria-expanded="false"
                        class="relative flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 text-slate-500 hover:bg-slate-100"
                    >
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.715 0"/>
                        </svg>
                        @if ($unseenLeadsCount > 0)
                            <span
                                id="notif-badge"
                                class="absolute -right-1 -top-1 flex h-4 w-4 items-center justify-center rounded-full bg-brand-fuchsia text-[9px] font-bold text-white ring-2 ring-white"
                            >{{ $unseenLeadsCount > 9 ? '9+' : $unseenLeadsCount }}</span>
                        @endif
                    </button>

                    {{-- Dropdown --}}
                    <div
                        id="notif-dropdown"
                        role="menu"
                        class="absolute right-0 top-11 z-50 hidden w-80 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-xl shadow-slate-200/60"
                    >
                        <div class="flex items-center justify-between border-b border-slate-100 px-4 py-3">
                            <div>
                                <p class="text-sm font-semibold text-brand-navy">Quote Requests</p>
                                @if ($unseenLeadsCount > 0)
                                    <p class="text-xs text-brand-fuchsia">{{ $unseenLeadsCount }} new {{ Str::plural('request', $unseenLeadsCount) }}</p>
                                @else
                                    <p class="text-xs text-slate-400">All caught up!</p>
                                @endif
                            </div>
                            @if ($unseenLeadsCount > 0)
                                <button
                                    id="notif-mark-read"
                                    type="button"
                                    class="rounded-lg bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600 hover:bg-slate-200"
                                >
                                    Mark all read
                                </button>
                            @endif
                        </div>

                        <ul class="max-h-72 divide-y divide-slate-100 overflow-y-auto">
                            @forelse ($unseenLeads as $nl)
                                <li>
                                    <a href="{{ route('admin.leads.show', $nl) }}"
                                       class="flex items-start gap-3 px-4 py-3 transition hover:bg-slate-50">
                                        <span class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-brand-fuchsia/10 text-xs font-bold text-brand-fuchsia">
                                            {{ strtoupper(substr($nl->name, 0, 1)) }}
                                        </span>
                                        <div class="min-w-0 flex-1">
                                            <p class="truncate text-sm font-semibold text-brand-navy">{{ $nl->name }}</p>
                                            @if ($nl->service_type)
                                                <p class="truncate text-xs text-slate-500">{{ $nl->service_type }}</p>
                                            @endif
                                            <p class="mt-0.5 text-[10px] text-slate-400">{{ $nl->created_at->diffForHumans() }}</p>
                                        </div>
                                        <span class="mt-1.5 h-2 w-2 shrink-0 rounded-full bg-brand-fuchsia"></span>
                                    </a>
                                </li>
                            @empty
                                <li class="px-4 py-8 text-center text-sm text-slate-400">No new requests.</li>
                            @endforelse
                        </ul>

                        <div class="border-t border-slate-100 px-4 py-3">
                            <a href="{{ route('admin.leads.index') }}"
                               class="flex items-center justify-center gap-1.5 text-sm font-medium text-brand-turquoise hover:underline">
                                View all leads →
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Schnauzer easter egg --}}
                <div aria-hidden="true" class="group relative hidden sm:block" title="¡Woof! 🧔">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40" class="h-8 w-8 cursor-default select-none opacity-40 transition-all duration-300 group-hover:opacity-100 group-hover:scale-110" fill="none">
                        {{-- Body --}}
                        <ellipse cx="20" cy="30" rx="9" ry="7.5" fill="#6b7280"/>
                        <ellipse cx="20" cy="32" rx="5.5" ry="4.5" fill="#9ca3af" opacity=".5"/>
                        {{-- Tail --}}
                        <rect x="28" y="23" width="2.5" height="5" rx="1.25" fill="#4b5563" transform="rotate(20 28 23)"/>
                        {{-- Legs --}}
                        <rect x="14" y="35" width="3.5" height="5" rx="1.75" fill="#4b5563"/>
                        <rect x="22.5" y="35" width="3.5" height="5" rx="1.75" fill="#4b5563"/>
                        {{-- Neck --}}
                        <ellipse cx="20" cy="22" rx="5" ry="4.5" fill="#6b7280"/>
                        {{-- Head --}}
                        <rect x="13" y="10" width="14" height="13" rx="4" fill="#6b7280"/>
                        {{-- Ears --}}
                        <path d="M14 12 L10 4 L16 9Z" fill="#374151"/>
                        <path d="M26 12 L30 4 L24 9Z" fill="#374151"/>
                        {{-- Muzzle --}}
                        <rect x="14" y="18" width="12" height="7" rx="2.5" fill="#9ca3af"/>
                        {{-- Beard --}}
                        <ellipse cx="20" cy="27" rx="5" ry="3" fill="#e5e7eb"/>
                        {{-- Moustache --}}
                        <path d="M14 21 Q16.5 20 18 22" stroke="#d1d5db" stroke-width="1" stroke-linecap="round" fill="none"/>
                        <path d="M26 21 Q23.5 20 22 22" stroke="#d1d5db" stroke-width="1" stroke-linecap="round" fill="none"/>
                        {{-- Nose --}}
                        <rect x="17" y="18" width="6" height="3.5" rx="1.75" fill="#1e293b"/>
                        {{-- Eyes --}}
                        <circle cx="16.5" cy="15" r="2" fill="white"/>
                        <circle cx="16.9" cy="14.8" r="1" fill="#1e293b"/>
                        <circle cx="23.5" cy="15" r="2" fill="white"/>
                        <circle cx="23.9" cy="14.8" r="1" fill="#1e293b"/>
                        {{-- Eye shine --}}
                        <circle cx="17.6" cy="14.2" r="0.45" fill="white"/>
                        <circle cx="24.6" cy="14.2" r="0.45" fill="white"/>
                        {{-- Eyebrows --}}
                        <path d="M13.5 12.5 Q16 10.5 18.5 12" stroke="#e5e7eb" stroke-width="1.5" stroke-linecap="round" fill="none"/>
                        <path d="M21.5 12 Q24 10.5 26.5 12.5" stroke="#e5e7eb" stroke-width="1.5" stroke-linecap="round" fill="none"/>
                    </svg>
                </div>

                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-brand-navy text-xs font-bold text-white" title="{{ $user?->name }}">{{ $initials }}</span>
            </div>
        </header>

        {{-- CONTENT --}}
        <main class="flex-1 px-4 py-6 sm:px-6 sm:py-8">
            @yield('content')
        </main>
    </div>

    {{-- ── TOAST CONTAINER ── --}}
    @if (session('status') || session('error'))
        <div id="toast-container" class="pointer-events-none fixed top-16 right-4 z-50 flex flex-col items-end gap-3 sm:right-6">

            @if (session('status'))
                <div
                    data-toast="success"
                    role="status"
                    class="toast pointer-events-auto flex w-full max-w-sm items-start gap-3 rounded-2xl border border-emerald-200 bg-white px-4 py-3.5 shadow-lg shadow-slate-200/60 ring-1 ring-black/5 transition-all duration-300"
                >
                    <span class="mt-0.5 flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-emerald-100">
                        <svg class="h-4 w-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                    </span>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-semibold text-emerald-800">Done!</p>
                        <p class="mt-0.5 text-sm text-slate-600">{{ session('status') }}</p>
                    </div>
                    <button type="button" data-dismiss-toast aria-label="Dismiss" class="ml-1 mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-lg text-slate-400 hover:bg-slate-100 hover:text-slate-600">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                    {{-- progress bar --}}
                    <div data-toast-progress class="absolute bottom-0 left-0 h-1 w-full overflow-hidden rounded-b-2xl">
                        <div class="toast-bar h-full w-full bg-emerald-400 origin-left"></div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div
                    data-toast="error"
                    role="alert"
                    class="toast pointer-events-auto flex w-full max-w-sm items-start gap-3 rounded-2xl border border-red-200 bg-white px-4 py-3.5 shadow-lg shadow-slate-200/60 ring-1 ring-black/5 transition-all duration-300"
                >
                    <span class="mt-0.5 flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-red-100">
                        <svg class="h-4 w-4 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z"/>
                        </svg>
                    </span>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-semibold text-red-700">Error</p>
                        <p class="mt-0.5 text-sm text-slate-600">{{ session('error') }}</p>
                    </div>
                    <button type="button" data-dismiss-toast aria-label="Dismiss" class="ml-1 mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-lg text-slate-400 hover:bg-slate-100 hover:text-slate-600">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                    {{-- progress bar --}}
                    <div data-toast-progress class="absolute bottom-0 left-0 h-1 w-full overflow-hidden rounded-b-2xl">
                        <div class="toast-bar h-full w-full bg-red-400 origin-left"></div>
                    </div>
                </div>
            @endif

        </div>
    @endif

</div>

{{-- ── Notification bell JavaScript ── --}}
<script>
(function () {
    var btn      = document.getElementById('notif-btn');
    var dropdown = document.getElementById('notif-dropdown');
    var markRead = document.getElementById('notif-mark-read');
    var badge    = document.getElementById('notif-badge');
    if (!btn || !dropdown) return;

    function openDropdown() {
        dropdown.classList.remove('hidden');
        btn.setAttribute('aria-expanded', 'true');
    }
    function closeDropdown() {
        dropdown.classList.add('hidden');
        btn.setAttribute('aria-expanded', 'false');
    }
    function toggle() {
        dropdown.classList.contains('hidden') ? openDropdown() : closeDropdown();
    }

    btn.addEventListener('click', function (e) { e.stopPropagation(); toggle(); });

    document.addEventListener('click', function (e) {
        var wrapper = document.getElementById('notif-wrapper');
        if (wrapper && !wrapper.contains(e.target)) closeDropdown();
    });

    if (markRead) {
        markRead.addEventListener('click', function () {
            fetch('{{ route('admin.notifications.seen') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                    'Accept': 'application/json',
                },
            }).then(function (r) {
                if (!r.ok) return;
                // Remove badge and update UI immediately
                if (badge) badge.remove();
                markRead.remove();
                var countEl = markRead.closest('[id=notif-dropdown]')
                    ?.querySelector('p.text-brand-fuchsia');
                if (countEl) countEl.textContent = 'All caught up!';

                // Remove pink dots from items
                dropdown.querySelectorAll('.bg-brand-fuchsia.rounded-full.h-2').forEach(function (dot) {
                    dot.remove();
                });
            });
        });
    }
})();
</script>

{{-- ── Sidebar JavaScript ── --}}
<script>
(function () {
    var shell       = document.getElementById('admin-shell');
    var sidebar     = document.getElementById('admin-sidebar');
    var overlay     = document.getElementById('sidebar-overlay');
    var openBtn     = document.getElementById('sidebar-open-btn');
    var closeBtn    = document.getElementById('sidebar-close-btn');
    var collapseBtn = document.getElementById('sidebar-collapse-btn');
    var iconExpand  = document.getElementById('collapse-icon-expand');
    var iconCollapse= document.getElementById('collapse-icon-collapse');
    var STORAGE_KEY = 'admin-sidebar-collapsed';

    /* ── Mobile drawer ── */
    function mobileOpen() {
        if (!sidebar || !overlay) return;
        sidebar.classList.add('is-open');
        overlay.style.opacity       = '1';
        overlay.style.pointerEvents = 'auto';
        document.body.style.overflow = 'hidden';
    }
    function mobileClose() {
        if (!sidebar || !overlay) return;
        sidebar.classList.remove('is-open');
        overlay.style.opacity       = '0';
        overlay.style.pointerEvents = 'none';
        document.body.style.overflow = '';
    }

    if (openBtn)  openBtn.addEventListener('click', mobileOpen);
    if (closeBtn) closeBtn.addEventListener('click', mobileClose);
    if (overlay)  overlay.addEventListener('click', mobileClose);

    sidebar && sidebar.querySelectorAll('a[href]').forEach(function (a) {
        a.addEventListener('click', function () {
            if (window.innerWidth < 1024) mobileClose();
        });
    });

    window.addEventListener('resize', function () {
        if (window.innerWidth >= 1024) mobileClose();
    });

    /* ── Desktop collapse ── */
    function isCollapsed() {
        return shell.dataset.collapsed === 'true';
    }

    function syncCollapseIcons() {
        if (!iconExpand || !iconCollapse) return;
        if (isCollapsed()) {
            iconExpand.classList.remove('hidden');
            iconCollapse.classList.add('hidden');
        } else {
            iconExpand.classList.add('hidden');
            iconCollapse.classList.remove('hidden');
        }
    }

    function setCollapsed(collapsed) {
        shell.dataset.collapsed = collapsed ? 'true' : 'false';
        try { localStorage.setItem(STORAGE_KEY, collapsed ? '1' : '0'); } catch(e) {}
        syncCollapseIcons();
    }

    /* Restore from localStorage on page load */
    try {
        if (localStorage.getItem(STORAGE_KEY) === '1') {
            shell.dataset.collapsed = 'true';
        }
    } catch(e) {}
    syncCollapseIcons();

    if (collapseBtn) {
        collapseBtn.addEventListener('click', function () {
            setCollapsed(!isCollapsed());
        });
    }
})();
</script>

{{-- ── Dark mode JavaScript ── --}}
<script>
(function () {
    var html   = document.documentElement;
    var toggle = document.getElementById('dark-mode-toggle');
    var sun    = document.getElementById('dm-sun');
    var moon   = document.getElementById('dm-moon');
    var KEY    = 'admin-dark-mode';

    function applyDark(isDark) {
        if (isDark) {
            html.classList.add('dark');
        } else {
            html.classList.remove('dark');
        }
        if (sun)  sun.classList.toggle('hidden', !isDark);
        if (moon) moon.classList.toggle('hidden', isDark);
        try { localStorage.setItem(KEY, isDark ? '1' : '0'); } catch (e) {}
    }

    /* Sync icons on first load (dark class may already be set by the anti-flash script) */
    var isDark = html.classList.contains('dark');
    if (sun)  sun.classList.toggle('hidden', !isDark);
    if (moon) moon.classList.toggle('hidden', isDark);

    if (toggle) {
        toggle.addEventListener('click', function () {
            applyDark(!html.classList.contains('dark'));
        });
    }

    /* React to system preference changes (only when no explicit override) */
    try {
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function (e) {
            if (localStorage.getItem(KEY) === null) applyDark(e.matches);
        });
    } catch (e) {}
})();
</script>

@else
{{-- ─── GUEST (login) ─── --}}
<main class="flex min-h-screen items-center justify-center bg-slate-50 px-4 py-12">
    @if (session('status'))
        <div class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800" role="status">
            {{ session('status') }}
        </div>
    @endif
    @if (session('error'))
        <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800" role="alert">
            {{ session('error') }}
        </div>
    @endif
    @yield('content')
</main>
@endauth

@stack('scripts')

{{-- ── Toast auto-dismiss ── --}}
<script>
(function () {
    var DURATION = 5000; // ms visible before auto-dismiss

    document.querySelectorAll('.toast').forEach(function (toast) {
        var bar = toast.querySelector('.toast-bar');

        function dismiss() {
            toast.classList.add('toast-hide');
            setTimeout(function () { toast.remove(); }, 320);
        }

        // Start progress bar shrink
        if (bar) {
            bar.style.transitionDuration = DURATION + 'ms';
            // Tiny delay so the transition plays after paint
            requestAnimationFrame(function () {
                requestAnimationFrame(function () {
                    bar.style.transform = 'scaleX(0)';
                });
            });
        }

        // Auto-dismiss
        var timer = setTimeout(dismiss, DURATION);

        // Pause on hover
        toast.addEventListener('mouseenter', function () {
            clearTimeout(timer);
            if (bar) bar.style.animationPlayState = 'paused';
        });
        toast.addEventListener('mouseleave', function () {
            timer = setTimeout(dismiss, 1200);
        });

        // Manual close button
        var btn = toast.querySelector('[data-dismiss-toast]');
        if (btn) btn.addEventListener('click', dismiss);
    });
})();
</script>
</body>
</html>
