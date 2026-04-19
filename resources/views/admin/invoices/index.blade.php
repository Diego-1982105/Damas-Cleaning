@extends('layouts.admin')

@section('title', 'Invoices')

@section('content')
    {{-- Page header --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-heading text-2xl font-bold text-brand-navy">Invoices</h1>
            <p class="mt-0.5 text-sm text-slate-400">Combine filters to drill into any period, client or status.</p>
        </div>
        <a href="{{ route('admin.facturas.create') }}"
           class="inline-flex items-center gap-2 self-start rounded-xl bg-brand-fuchsia px-5 py-2.5 text-sm font-semibold text-white shadow-md shadow-brand-fuchsia/30 transition hover:bg-brand-fuchsia-dark active:scale-95 sm:self-auto">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            New Invoice
        </a>
    </div>

    {{-- Filters --}}
    <form method="GET" action="{{ route('admin.facturas.index') }}" class="mt-5 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
        <p class="mb-3 text-[10px] font-semibold uppercase tracking-widest text-slate-400">Filters</p>
        <div class="flex flex-wrap items-end gap-3">
            <div>
                <label for="month" class="block text-xs font-medium text-brand-navy">Month</label>
                <input type="month" id="month" name="month" value="{{ $monthFilter }}"
                       class="mt-1 rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-brand-navy shadow-sm focus:border-brand-turquoise focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-turquoise/25" />
            </div>
            <div>
                <label for="date_from" class="block text-xs font-medium text-brand-navy">From</label>
                <input type="date" id="date_from" name="date_from" value="{{ $dateFromFilter }}"
                       class="mt-1 rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-brand-navy shadow-sm focus:border-brand-turquoise focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-turquoise/25" />
            </div>
            <div>
                <label for="date_to" class="block text-xs font-medium text-brand-navy">To</label>
                <input type="date" id="date_to" name="date_to" value="{{ $dateToFilter }}"
                       class="mt-1 rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-brand-navy shadow-sm focus:border-brand-turquoise focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-turquoise/25" />
            </div>
            <div>
                <label for="client_id" class="block text-xs font-medium text-brand-navy">Client</label>
                <select id="client_id" name="client_id"
                        class="mt-1 min-w-[10rem] rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-brand-navy shadow-sm focus:border-brand-turquoise focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-turquoise/25">
                    <option value="">All clients</option>
                    @foreach ($clients as $c)
                        <option value="{{ $c->id }}" @selected((string) $clientIdFilter === (string) $c->id)>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="status" class="block text-xs font-medium text-brand-navy">Status</label>
                <select id="status" name="status"
                        class="mt-1 rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-brand-navy shadow-sm focus:border-brand-turquoise focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-turquoise/25">
                    <option value="">All statuses</option>
                    @foreach ($statusLabels as $value => $label)
                        <option value="{{ $value }}" @selected((string) $statusFilter === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-center gap-2">
                <button type="submit"
                        class="rounded-xl bg-brand-navy px-4 py-2 text-sm font-semibold text-white transition hover:bg-brand-navy/90">
                    Apply
                </button>
                @if ($hasActiveFilters)
                    <a href="{{ route('admin.facturas.index') }}" class="text-sm font-medium text-slate-400 hover:text-brand-navy">Clear</a>
                @endif
            </div>
        </div>
    </form>

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
@endsection
