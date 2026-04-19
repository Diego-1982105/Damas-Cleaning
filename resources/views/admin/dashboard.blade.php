@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    {{-- Hero KPI strip --}}
    <section
        class="relative overflow-hidden rounded-2xl p-6 text-white shadow-xl ring-1 ring-white/10 sm:p-8"
        style="background: linear-gradient(135deg, #0d0208 0%, #3d0b1e 42%, #831843 78%, #9d1547 100%);"
    >
        {{-- Ambient glow orbs --}}
        <div class="pointer-events-none absolute -right-10 -top-10 h-64 w-64 rounded-full bg-brand-fuchsia/20 blur-3xl" aria-hidden="true"></div>
        <div class="pointer-events-none absolute -bottom-16 left-1/4 h-52 w-52 rounded-full bg-brand-turquoise/15 blur-3xl" aria-hidden="true"></div>
        <div class="pointer-events-none absolute right-1/4 -bottom-8 h-36 w-36 rounded-full bg-brand-gold/10 blur-2xl" aria-hidden="true"></div>

        {{-- Subtle dot-grid texture overlay --}}
        <div
            class="pointer-events-none absolute inset-0 opacity-[0.04]"
            style="background-image: radial-gradient(circle, #fff 1px, transparent 1px); background-size: 22px 22px;"
            aria-hidden="true"
        ></div>

        <div class="relative flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <span class="inline-flex items-center gap-1.5 rounded-full border border-brand-gold/30 bg-brand-gold/10 px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-widest text-brand-gold">
                    <span class="h-1.5 w-1.5 rounded-full bg-brand-gold"></span>
                    Overview
                </span>
                <h2 class="mt-3 font-heading text-2xl font-bold sm:text-3xl">Good morning 👋</h2>
                <p class="mt-1 text-sm text-white/65">Here's what's happening with Damas Cleaning today.</p>
            </div>
            <div class="flex shrink-0 flex-wrap gap-2">
                <a href="{{ route('admin.facturas.create') }}"
                   class="inline-flex items-center gap-2 rounded-xl bg-brand-fuchsia px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-brand-fuchsia/40 transition hover:bg-brand-fuchsia-dark active:scale-95">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                    </svg>
                    New Invoice
                </a>
                <a href="{{ route('admin.clientes.create') }}"
                   class="inline-flex items-center gap-2 rounded-xl border border-white/20 bg-white/8 px-4 py-2.5 text-sm font-semibold text-white/90 backdrop-blur-sm transition hover:bg-white/15 hover:text-white active:scale-95">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z"/>
                    </svg>
                    New Client
                </a>
            </div>
        </div>

        {{-- KPI Cards --}}
        <div class="relative mt-6 grid grid-cols-2 gap-3 sm:grid-cols-3">
            <div class="col-span-2 rounded-xl border border-white/10 bg-black/20 p-4 backdrop-blur-sm sm:col-span-1">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-medium text-white/60">Total Invoices</p>
                    <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-white/10">
                        <x-admin.sidebar-icon name="document" class="h-4 w-4 text-white/80" />
                    </span>
                </div>
                <p class="mt-3 font-heading text-3xl font-bold tracking-tight text-white">{{ number_format($invoicesTotalCount) }}</p>
                <p class="mt-1 text-xs text-white/45">All time</p>
            </div>
            <div class="rounded-xl border border-white/10 bg-black/20 p-4 backdrop-blur-sm">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-medium text-white/60">This Month</p>
                    <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-white/10">
                        <x-admin.sidebar-icon name="clipboard" class="h-4 w-4 text-white/80" />
                    </span>
                </div>
                <p class="mt-3 font-heading text-3xl font-bold tracking-tight text-white">{{ number_format($invoicesThisMonthCount) }}</p>
                <p class="mt-1 text-xs text-white/45">New invoices</p>
            </div>
            <div class="rounded-xl border border-brand-gold/25 bg-brand-gold/10 p-4 backdrop-blur-sm">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-medium text-brand-gold/80">Paid (YTD)</p>
                    <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-brand-gold/20">
                        <x-admin.sidebar-icon name="briefcase" class="h-4 w-4 text-brand-gold" />
                    </span>
                </div>
                <p class="mt-3 font-heading text-2xl font-bold tracking-tight text-brand-gold">${{ number_format((float) $ytdPaid, 2) }}</p>
                <p class="mt-1 text-xs text-brand-gold/50">Paid status only</p>
            </div>
        </div>
    </section>

    {{-- Charts + Lists --}}
    <div class="mt-6 grid gap-5 lg:grid-cols-12">

        {{-- Chart --}}
        <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm lg:col-span-7 sm:p-6">
            {{-- Header --}}
            <div class="flex flex-wrap items-center justify-between gap-2 border-b border-slate-100 pb-4">
                <div>
                    <h2 class="font-heading text-base font-semibold text-brand-navy sm:text-lg">Paid Revenue by Month</h2>
                    <p class="text-xs text-slate-400">Last 12 months · paid invoices only</p>
                </div>
                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center gap-1.5 text-[11px] text-slate-400">
                        <span class="inline-block h-2.5 w-3.5 rounded-sm" style="background: linear-gradient(to right, #831843, #e91e63);"></span>
                        Paid
                    </span>
                    <span class="rounded-full bg-brand-fuchsia/10 px-2.5 py-0.5 text-xs font-semibold text-brand-fuchsia">12 mo</span>
                </div>
            </div>

            {{-- Chart area --}}
            <div class="mt-5">
                @php
                    $barAreaH = 160; /* px — height reserved for bars */
                @endphp

                {{-- Wrapper: relative so grid lines + bars can overlap --}}
                <div class="relative">

                    {{-- Grid lines (4 horizontal dashes at 25/50/75/100 %) --}}
                    <div class="pointer-events-none absolute inset-x-0" style="top: 0; height: {{ $barAreaH }}px;">
                        @foreach ([0, 25, 50, 75] as $pct)
                            <div class="absolute inset-x-0 border-t border-dashed border-slate-200/80"
                                 style="top: {{ $pct }}%"></div>
                        @endforeach
                    </div>

                    {{-- Bars row --}}
                    <div class="relative flex items-end gap-1 sm:gap-1.5" style="height: {{ $barAreaH + 24 }}px;">
                        @foreach ($chart as $bar)
                            @php
                                $pct   = $maxChart > 0 ? ($bar['total'] / $maxChart) * 100 : 0;
                                $h     = max(2, $pct);
                                $isMax = $maxChart > 0 && abs($bar['total'] - $maxChart) < 0.01;
                                $isEmpty = $bar['total'] <= 0;
                                $shortAmt = $bar['total'] >= 1000
                                    ? '$' . number_format($bar['total'] / 1000, 1) . 'k'
                                    : '$' . number_format($bar['total'], 0);
                            @endphp
                            <div class="group relative flex min-w-0 flex-1 flex-col items-center justify-end">

                                {{-- Hover tooltip --}}
                                @unless ($isEmpty)
                                    <div class="pointer-events-none absolute z-20 whitespace-nowrap rounded-lg px-2 py-1 text-[10px] font-bold text-white opacity-0 shadow-lg transition-all duration-150 group-hover:opacity-100 group-hover:-translate-y-1"
                                         style="bottom: calc({{ $h }}% + 30px); left: 50%; transform: translateX(-50%); background: #3d0b1e;">
                                        {{ $shortAmt }}
                                        <span class="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent" style="border-top-color: #3d0b1e;"></span>
                                    </div>
                                @endunless

                                {{-- Bar --}}
                                <div class="flex w-full flex-col justify-end" style="height: {{ $barAreaH }}px;">
                                    @if ($isEmpty)
                                        <div class="w-full rounded-sm" style="height: 3px; background: #f1f5f9;"></div>
                                    @else
                                        <div
                                            class="w-full rounded-t-md transition-all duration-200 group-hover:brightness-110"
                                            style="height: {{ $h }}%;
                                                   background: linear-gradient(to top, #831843 0%, #c2185b 55%, #e91e63 100%);
                                                   {{ $isMax ? 'box-shadow: 0 -6px 16px rgba(233,30,99,.35), 0 0 0 1.5px rgba(255,215,64,.45);' : '' }}"
                                        ></div>
                                    @endif
                                </div>

                                {{-- Month label --}}
                                <span class="mt-1.5 max-w-full truncate text-center text-[9px] font-medium text-slate-400 sm:text-[10px]">
                                    {{ $bar['label'] }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Footer: peak month callout --}}
                @if ($maxChart > 0)
                    <div class="mt-3 flex items-center justify-end gap-1.5 border-t border-slate-100 pt-3 text-xs text-slate-400">
                        <svg class="h-3.5 w-3.5 shrink-0" style="color: #e91e63;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941"/>
                        </svg>
                        Peak month:
                        <span class="font-semibold text-brand-navy">${{ number_format($maxChart, 2) }}</span>
                    </div>
                @endif
            </div>
        </section>

        {{-- Side panels --}}
        <div class="flex flex-col gap-5 lg:col-span-5">

            {{-- By status --}}
            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <h2 class="font-heading text-base font-semibold text-brand-navy">By Status</h2>
                <p class="mt-0.5 text-xs text-slate-400">Count &amp; total per invoice status</p>
                <ul class="mt-3 divide-y divide-slate-100">
                    @foreach ($statusLabels as $key => $label)
                        @php
                            $row = $totalsByStatus->get($key);
                            $colors = match($key) {
                                'paid'      => 'bg-emerald-50 text-emerald-700',
                                'sent'      => 'bg-sky-50 text-sky-700',
                                'cancelled' => 'bg-red-50 text-red-600',
                                default     => 'bg-slate-100 text-slate-500',
                            };
                        @endphp
                        <li class="flex items-center justify-between gap-3 py-2.5 text-sm">
                            <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $colors }}">{{ $label }}</span>
                            <span class="text-right text-slate-600">
                                {{ $row ? (int) $row->c : 0 }}
                                <span class="text-slate-400">inv</span>
                                <span class="ml-2 font-semibold text-brand-navy">${{ number_format((float) ($row->sum_total ?? 0), 2) }}</span>
                            </span>
                        </li>
                    @endforeach
                </ul>
            </section>

            {{-- Top clients --}}
            <section class="flex-1 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between gap-2">
                    <div>
                        <h2 class="font-heading text-base font-semibold text-brand-navy">Top Clients</h2>
                        <p class="mt-0.5 text-xs text-slate-400">By volume (sent + paid)</p>
                    </div>
                    <a href="{{ route('admin.clientes.index') }}" class="text-xs font-medium text-brand-turquoise hover:underline">View all</a>
                </div>
                <ul class="mt-3 divide-y divide-slate-100">
                    @forelse ($topClients as $i => $c)
                        <li class="flex items-center gap-3 py-2.5 text-sm">
                            <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-slate-100 text-[10px] font-bold text-slate-500">{{ $i+1 }}</span>
                            <a href="{{ route('admin.clientes.edit', $c) }}" class="min-w-0 flex-1 truncate font-medium text-brand-navy hover:text-brand-turquoise hover:underline">{{ $c->name }}</a>
                            <span class="shrink-0 font-semibold text-brand-navy">${{ number_format((float) $c->revenue, 2) }}</span>
                        </li>
                    @empty
                        <li class="py-8 text-center text-sm text-slate-400">No invoices yet.</li>
                    @endforelse
                </ul>
            </section>
        </div>
    </div>

    {{-- Recent Invoices --}}
    <section class="mt-6 rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="flex items-center justify-between gap-3 border-b border-slate-100 px-5 py-4">
            <h2 class="font-heading text-base font-semibold text-brand-navy">Recent Invoices</h2>
            <a href="{{ route('admin.facturas.index') }}" class="text-sm font-medium text-brand-turquoise hover:underline">View all →</a>
        </div>

        {{-- Desktop table --}}
        <div class="hidden overflow-x-auto md:block">
            <table class="min-w-full divide-y divide-slate-100 text-sm">
                <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-400">
                    <tr>
                        <th class="px-5 py-3 text-left">#</th>
                        <th class="px-5 py-3 text-left">Date</th>
                        <th class="px-5 py-3 text-left">Client</th>
                        <th class="px-5 py-3 text-left">Status</th>
                        <th class="px-5 py-3 text-right">Total</th>
                        <th class="px-5 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($recentInvoices as $inv)
                        <tr class="transition hover:bg-slate-50">
                            <td class="whitespace-nowrap px-5 py-3.5 text-slate-400">{{ $inv->id }}</td>
                            <td class="whitespace-nowrap px-5 py-3.5 text-slate-500">{{ $inv->date->format('M j, Y') }}</td>
                            <td class="px-5 py-3.5 font-medium text-brand-navy">{{ $inv->client->name }}</td>
                            <td class="whitespace-nowrap px-5 py-3.5">
                                <x-admin.status-badge :invoice="$inv" />
                            </td>
                            <td class="whitespace-nowrap px-5 py-3.5 text-right font-semibold text-brand-navy">${{ number_format((float) $inv->total, 2) }}</td>
                            <td class="whitespace-nowrap px-5 py-3.5 text-right">
                                <a href="{{ route('admin.facturas.show', $inv) }}" class="text-xs font-semibold text-brand-turquoise hover:underline">View →</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-10 text-center text-sm text-slate-400">No invoices yet. <a href="{{ route('admin.facturas.create') }}" class="text-brand-turquoise hover:underline">Create one</a>.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile cards --}}
        <div class="divide-y divide-slate-100 md:hidden">
            @forelse ($recentInvoices as $inv)
                <a href="{{ route('admin.facturas.show', $inv) }}" class="flex items-center gap-3 px-4 py-3.5 transition hover:bg-slate-50">
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-xs font-bold text-slate-500">
                        #{{ $inv->id }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="truncate font-medium text-brand-navy">{{ $inv->client->name }}</p>
                        <p class="text-xs text-slate-400">{{ $inv->date->format('M j, Y') }}</p>
                    </div>
                    <div class="shrink-0 text-right">
                        <p class="font-semibold text-brand-navy">${{ number_format((float) $inv->total, 2) }}</p>
                        <x-admin.status-badge :invoice="$inv" />
                    </div>
                </a>
            @empty
                <p class="px-4 py-10 text-center text-sm text-slate-400">No invoices yet.</p>
            @endforelse
        </div>
    </section>
@endsection
