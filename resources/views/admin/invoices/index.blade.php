@extends('layouts.admin')

@section('title', 'Invoices')

@section('content')
    {{-- Page header --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-heading text-2xl font-bold text-brand-navy">Invoices</h1>
            <p class="mt-0.5 text-sm text-slate-400">Combine filters to drill into any period, client or status.</p>
        </div>
        <div class="flex items-center gap-2 self-start sm:self-auto">
            {{-- Filter button --}}
            <button
                id="filter-modal-btn"
                type="button"
                class="relative inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 shadow-sm transition hover:bg-slate-50 hover:text-brand-navy"
            >
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z"/>
                </svg>
                Filters
                @php
                    $activeCount = collect([$monthFilter, $dateFromFilter, $dateToFilter, $clientIdFilter, $statusFilter])->filter()->count();
                @endphp
                @if ($activeCount > 0)
                    <span class="absolute -right-1.5 -top-1.5 flex h-5 w-5 items-center justify-center rounded-full bg-brand-fuchsia text-[10px] font-bold text-white">{{ $activeCount }}</span>
                @endif
            </button>

            <a href="{{ route('admin.facturas.create') }}"
               class="inline-flex items-center gap-2 rounded-xl bg-brand-fuchsia px-5 py-2.5 text-sm font-semibold text-white shadow-md shadow-brand-fuchsia/30 transition hover:bg-brand-fuchsia-dark active:scale-95">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
                New Invoice
            </a>
        </div>
    </div>

    {{-- Active filter chips --}}
    @if ($hasActiveFilters)
        <div class="mt-3 flex flex-wrap items-center gap-2">
            @if ($monthFilter)
                <span class="inline-flex items-center gap-1.5 rounded-full bg-brand-turquoise/10 px-3 py-1 text-xs font-medium text-brand-navy">
                    Month: {{ \Carbon\Carbon::parse($monthFilter)->format('M Y') }}
                    <a href="{{ route('admin.facturas.index', array_merge(request()->except('month', 'page'), ['month' => ''])) }}" class="ml-0.5 text-slate-400 hover:text-red-500">✕</a>
                </span>
            @endif
            @if ($dateFromFilter)
                <span class="inline-flex items-center gap-1.5 rounded-full bg-brand-turquoise/10 px-3 py-1 text-xs font-medium text-brand-navy">
                    From: {{ \Carbon\Carbon::parse($dateFromFilter)->format('M j, Y') }}
                    <a href="{{ route('admin.facturas.index', array_merge(request()->except('date_from', 'page'), ['date_from' => ''])) }}" class="ml-0.5 text-slate-400 hover:text-red-500">✕</a>
                </span>
            @endif
            @if ($dateToFilter)
                <span class="inline-flex items-center gap-1.5 rounded-full bg-brand-turquoise/10 px-3 py-1 text-xs font-medium text-brand-navy">
                    To: {{ \Carbon\Carbon::parse($dateToFilter)->format('M j, Y') }}
                    <a href="{{ route('admin.facturas.index', array_merge(request()->except('date_to', 'page'), ['date_to' => ''])) }}" class="ml-0.5 text-slate-400 hover:text-red-500">✕</a>
                </span>
            @endif
            @if ($clientIdFilter)
                <span class="inline-flex items-center gap-1.5 rounded-full bg-brand-turquoise/10 px-3 py-1 text-xs font-medium text-brand-navy">
                    Client: {{ $clients->firstWhere('id', $clientIdFilter)?->name }}
                    <a href="{{ route('admin.facturas.index', array_merge(request()->except('client_id', 'page'), ['client_id' => ''])) }}" class="ml-0.5 text-slate-400 hover:text-red-500">✕</a>
                </span>
            @endif
            @if ($statusFilter)
                <span class="inline-flex items-center gap-1.5 rounded-full bg-brand-turquoise/10 px-3 py-1 text-xs font-medium text-brand-navy">
                    Status: {{ $statusLabels[$statusFilter] ?? $statusFilter }}
                    <a href="{{ route('admin.facturas.index', array_merge(request()->except('status', 'page'), ['status' => ''])) }}" class="ml-0.5 text-slate-400 hover:text-red-500">✕</a>
                </span>
            @endif
            <a href="{{ route('admin.facturas.index') }}" class="text-xs font-medium text-slate-400 hover:text-red-500">Clear all</a>
        </div>
    @endif

    {{-- ── FILTER MODAL ── --}}
    <div
        id="filter-modal-backdrop"
        class="pointer-events-none fixed inset-0 z-40 flex items-end justify-center bg-brand-navy/50 opacity-0 backdrop-blur-sm transition-opacity duration-200 sm:items-center"
        aria-hidden="true"
    >
        <div
            id="filter-modal"
            class="pointer-events-auto w-full translate-y-4 rounded-t-2xl bg-white p-6 shadow-2xl transition-transform duration-200 sm:max-w-lg sm:rounded-2xl sm:translate-y-0"
        >
            {{-- Modal header --}}
            <div class="mb-5 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg class="h-5 w-5 text-brand-navy" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z"/>
                    </svg>
                    <h2 class="font-heading text-base font-bold text-brand-navy">Filter Invoices</h2>
                </div>
                <button id="filter-modal-close" type="button" aria-label="Close filters"
                        class="flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Filter form --}}
            <form method="GET" action="{{ route('admin.facturas.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label for="month" class="block text-xs font-semibold uppercase tracking-wide text-brand-navy">Month</label>
                        <input type="month" id="month" name="month" value="{{ $monthFilter }}"
                               class="mt-1.5 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-brand-navy shadow-sm focus:border-brand-turquoise focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-turquoise/25" />
                    </div>
                    <div>
                        <label for="status" class="block text-xs font-semibold uppercase tracking-wide text-brand-navy">Status</label>
                        <select id="status" name="status"
                                class="mt-1.5 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-brand-navy shadow-sm focus:border-brand-turquoise focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-turquoise/25">
                            <option value="">All statuses</option>
                            @foreach ($statusLabels as $value => $label)
                                <option value="{{ $value }}" @selected((string) $statusFilter === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="date_from" class="block text-xs font-semibold uppercase tracking-wide text-brand-navy">From</label>
                        <input type="date" id="date_from" name="date_from" value="{{ $dateFromFilter }}"
                               class="mt-1.5 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-brand-navy shadow-sm focus:border-brand-turquoise focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-turquoise/25" />
                    </div>
                    <div>
                        <label for="date_to" class="block text-xs font-semibold uppercase tracking-wide text-brand-navy">To</label>
                        <input type="date" id="date_to" name="date_to" value="{{ $dateToFilter }}"
                               class="mt-1.5 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-brand-navy shadow-sm focus:border-brand-turquoise focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-turquoise/25" />
                    </div>
                    <div class="sm:col-span-2">
                        <label for="client_id" class="block text-xs font-semibold uppercase tracking-wide text-brand-navy">Client</label>
                        <select id="client_id" name="client_id"
                                class="mt-1.5 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-brand-navy shadow-sm focus:border-brand-turquoise focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-turquoise/25">
                            <option value="">All clients</option>
                            @foreach ($clients as $c)
                                <option value="{{ $c->id }}" @selected((string) $clientIdFilter === (string) $c->id)>{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-1">
                    <button type="submit"
                            class="flex-1 rounded-xl bg-brand-navy py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-navy/90">
                        Apply Filters
                    </button>
                    @if ($hasActiveFilters)
                        <a href="{{ route('admin.facturas.index') }}"
                           class="flex-1 rounded-xl border border-slate-200 py-2.5 text-center text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                            Clear All
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- Summary --}}
    <div class="mt-3 flex items-center gap-3 rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-sm">
        <span class="text-slate-500">Results:</span>
        <span class="font-semibold text-brand-navy">{{ $summaryCount }}</span>
        <span class="text-slate-400">invoice(s)</span>
        <span class="mx-1 text-slate-200">|</span>
        <span class="font-semibold text-brand-navy">${{ number_format($summaryTotal, 2) }}</span>
        <span class="text-slate-400">total</span>
    </div>

    {{-- Table (desktop) --}}
    <div class="mt-4 hidden overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm md:block">
        <div class="overflow-x-auto">
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
                    @forelse ($invoices as $invoice)
                        <tr class="transition hover:bg-slate-50">
                            <td class="whitespace-nowrap px-5 py-3.5 text-slate-400">{{ $invoice->id }}</td>
                            <td class="whitespace-nowrap px-5 py-3.5 text-slate-500">{{ $invoice->date->format('M j, Y') }}</td>
                            <td class="px-5 py-3.5 font-medium text-brand-navy">{{ $invoice->client->name }}</td>
                            <td class="whitespace-nowrap px-5 py-3.5">
                                <x-admin.status-badge :invoice="$invoice" />
                            </td>
                            <td class="whitespace-nowrap px-5 py-3.5 text-right font-semibold text-brand-navy">${{ number_format((float) $invoice->total, 2) }}</td>
                            <td class="whitespace-nowrap px-5 py-3.5 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('admin.facturas.show', $invoice) }}"
                                       title="View"
                                       class="flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 hover:bg-brand-turquoise/10 hover:text-brand-turquoise">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.facturas.edit', $invoice) }}"
                                       title="Edit"
                                       class="flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 hover:bg-brand-turquoise/10 hover:text-brand-turquoise">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 0 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z"/>
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center text-slate-400">No invoices match these filters.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($invoices->hasPages())
            <div class="border-t border-slate-100 px-5 py-4">
                {{ $invoices->links() }}
            </div>
        @endif
    </div>

    {{-- Cards (mobile) --}}
    <div class="mt-4 md:hidden">
        @forelse ($invoices as $invoice)
            <a href="{{ route('admin.facturas.show', $invoice) }}"
               class="mb-2 flex items-center gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:border-brand-turquoise/40 hover:shadow-md">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-xs font-bold text-slate-500">
                    #{{ $invoice->id }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="truncate font-semibold text-brand-navy">{{ $invoice->client->name }}</p>
                    <p class="text-xs text-slate-400">{{ $invoice->date->format('M j, Y') }}</p>
                </div>
                <div class="shrink-0 text-right">
                    <p class="font-bold text-brand-navy">${{ number_format((float) $invoice->total, 2) }}</p>
                    <x-admin.status-badge :invoice="$invoice" />
                </div>
            </a>
        @empty
            <div class="rounded-2xl border border-slate-200 bg-white py-12 text-center text-slate-400">
                No invoices match these filters.
            </div>
        @endforelse
        @if ($invoices->hasPages())
            <div class="mt-4">{{ $invoices->links() }}</div>
        @endif
    </div>

    @push('scripts')
    <script>
    (function () {
        var btn      = document.getElementById('filter-modal-btn');
        var backdrop = document.getElementById('filter-modal-backdrop');
        var modal    = document.getElementById('filter-modal');
        var closeBtn = document.getElementById('filter-modal-close');
        if (!btn || !backdrop || !modal) return;

        function openModal() {
            backdrop.classList.remove('pointer-events-none', 'opacity-0');
            backdrop.classList.add('pointer-events-auto', 'opacity-100');
            modal.classList.remove('translate-y-4');
            modal.classList.add('translate-y-0');
            document.body.style.overflow = 'hidden';
            backdrop.removeAttribute('aria-hidden');
        }
        function closeModal() {
            backdrop.classList.add('pointer-events-none', 'opacity-0');
            backdrop.classList.remove('pointer-events-auto', 'opacity-100');
            modal.classList.add('translate-y-4');
            modal.classList.remove('translate-y-0');
            document.body.style.overflow = '';
            backdrop.setAttribute('aria-hidden', 'true');
        }

        btn.addEventListener('click', openModal);
        if (closeBtn) closeBtn.addEventListener('click', closeModal);

        backdrop.addEventListener('click', function (e) {
            if (e.target === backdrop) closeModal();
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeModal();
        });
    })();
    </script>
    @endpush
@endsection
