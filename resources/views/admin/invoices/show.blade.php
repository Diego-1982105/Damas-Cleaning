@extends('layouts.admin')

@section('title', 'Invoice #' . $invoice->id)

@push('styles')
    <style>
        #invoice-pdf-dialog::backdrop {
            background: rgb(15 23 42 / 0.55);
            backdrop-filter: blur(4px);
        }
        #invoice-pdf-dialog {
            margin: auto;
            max-width: min(56rem, calc(100vw - 1rem));
            max-height: calc(100dvh - 1.5rem);
            width: 100%;
            border: none;
            padding: 0;
            background: transparent;
            border-radius: 1rem;
            overflow: hidden;
        }
        #invoice-pdf-dialog:not([open]) { display: none; }
    </style>
@endpush

@section('content')
    {{-- Page header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('admin.facturas.index') }}" class="text-sm text-slate-400 hover:text-brand-navy">Invoices</a>
                <svg class="h-4 w-4 text-slate-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                <span class="text-sm text-slate-500">#{{ $invoice->id }}</span>
            </div>
            <h1 class="mt-1 font-heading text-2xl font-bold text-brand-navy">Invoice #{{ $invoice->id }}</h1>
            <div class="mt-1.5 flex flex-wrap items-center gap-2">
                <span class="text-sm text-slate-500">{{ $invoice->date->format('M j, Y') }}</span>
                <span class="text-slate-300">·</span>
                <x-admin.status-badge :invoice="$invoice" />
            </div>
        </div>

        <div class="flex items-center gap-1.5">
            <button type="button" id="invoice-pdf-open" title="Preview PDF"
                    class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-brand-navy shadow-sm transition hover:border-brand-turquoise/40 hover:shadow-md">
                <svg class="h-4 w-4 text-brand-turquoise" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                </svg>
                <span class="hidden sm:inline">Preview PDF</span>
            </button>
            <a href="{{ route('admin.facturas.edit', $invoice) }}" title="Edit"
               class="flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-500 shadow-sm transition hover:bg-brand-turquoise/10 hover:text-brand-turquoise">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 0 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z"/>
                </svg>
            </a>
            <form method="POST" action="{{ route('admin.facturas.destroy', $invoice) }}" onsubmit="return confirm('Delete this invoice? This cannot be undone.');">
                @csrf
                @method('DELETE')
                <button type="submit" title="Delete"
                        class="flex h-9 w-9 items-center justify-center rounded-xl border border-red-100 bg-red-50 text-red-500 shadow-sm transition hover:bg-red-100">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>

    {{-- Client + Notes --}}
    <div class="mt-5 grid gap-4 sm:grid-cols-2">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Bill To</p>
            <p class="mt-2 font-heading text-lg font-semibold text-brand-navy">{{ $invoice->client->name }}</p>
            @if ($invoice->client->address)
                <p class="mt-1.5 whitespace-pre-line text-sm text-slate-500">{{ $invoice->client->address }}</p>
            @endif
            <p class="mt-1.5 space-y-0.5 text-sm text-slate-500">
                @if ($invoice->client->phone)
                    <span class="block">📞 {{ $invoice->client->phone }}</span>
                @endif
                @if ($invoice->client->email)
                    <span class="block">✉ {{ $invoice->client->email }}</span>
                @endif
            </p>
        </div>

        @if ($invoice->notes)
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Notes</p>
                <p class="mt-2 whitespace-pre-line text-sm text-slate-600">{{ $invoice->notes }}</p>
            </div>
        @endif
    </div>

    {{-- Line items --}}
    <div class="mt-4 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100 text-sm">
                <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-400">
                    <tr>
                        <th class="px-5 py-3 text-left">Description</th>
                        <th class="px-5 py-3 text-right">Qty</th>
                        <th class="px-5 py-3 text-right">Unit Price</th>
                        <th class="px-5 py-3 text-right">Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($invoice->items as $line)
                        <tr>
                            <td class="px-5 py-3.5 text-brand-navy">{{ $line->description }}</td>
                            <td class="whitespace-nowrap px-5 py-3.5 text-right text-slate-500">{{ number_format((float) $line->quantity, 2) }}</td>
                            <td class="whitespace-nowrap px-5 py-3.5 text-right text-slate-500">${{ number_format((float) $line->price, 2) }}</td>
                            <td class="whitespace-nowrap px-5 py-3.5 text-right font-medium text-brand-navy">${{ number_format((float) $line->total, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="border-t-2 border-slate-200 bg-slate-50">
                    <tr>
                        <td colspan="3" class="px-5 py-4 text-right font-heading font-bold text-brand-navy">Total</td>
                        <td class="whitespace-nowrap px-5 py-4 text-right font-heading text-xl font-bold text-brand-navy">${{ number_format((float) $invoice->total, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {{-- PDF Dialog --}}
    <dialog id="invoice-pdf-dialog" aria-labelledby="invoice-pdf-dialog-title">
        <div class="flex max-h-[calc(100dvh-1.5rem)] flex-col overflow-hidden rounded-2xl bg-white shadow-2xl">
            <div class="flex shrink-0 items-center justify-between gap-3 border-b border-slate-100 bg-slate-50 px-5 py-3.5">
                <div>
                    <h2 id="invoice-pdf-dialog-title" class="font-heading text-sm font-semibold text-brand-navy">Invoice #{{ $invoice->id }} — Preview</h2>
                    <p class="text-xs text-slate-400">{{ $invoice->client->name }} · {{ $invoice->date->format('M j, Y') }}</p>
                </div>
                <button type="button" id="invoice-pdf-close"
                        class="flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 text-slate-400 hover:bg-slate-100">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <iframe
                id="invoice-pdf-frame"
                title="Invoice PDF preview"
                class="min-h-[min(55vh,30rem)] w-full flex-1 border-0 bg-slate-100"
                data-preview-url="{{ route('admin.facturas.pdf.preview', $invoice) }}"
            ></iframe>
            <div class="shrink-0 border-t border-slate-100 bg-white px-5 py-4">
                <p class="mb-3 text-xs text-slate-400">Send this invoice by email or download the PDF.</p>
                <form id="invoice-pdf-email-form" method="POST" action="{{ route('admin.facturas.pdf.email', $invoice) }}">
                    @csrf
                    <div class="flex gap-2">
                        <input
                            type="email"
                            id="invoice-pdf-modal-email"
                            name="email"
                            value="{{ old('email', $invoice->client->email) }}"
                            required
                            placeholder="client@example.com"
                            class="flex-1 rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-brand-navy shadow-sm focus:border-brand-turquoise focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-turquoise/25"
                        />
                        <button type="submit" form="invoice-pdf-email-form"
                                class="rounded-xl bg-brand-navy px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-brand-navy/90">
                            Send
                        </button>
                    </div>
                    @error('email')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </form>
                <div class="mt-3">
                    <a href="{{ route('admin.facturas.pdf', $invoice) }}"
                       class="flex w-full items-center justify-center gap-2 rounded-xl border border-slate-200 py-2.5 text-sm font-semibold text-brand-navy hover:bg-slate-50"
                       download="Damas-Invoice-{{ $invoice->id }}.pdf">
                        <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/>
                        </svg>
                        Download PDF
                    </a>
                </div>
            </div>
        </div>
    </dialog>
@endsection

@push('scripts')
    <script>
        (function () {
            var dialog  = document.getElementById('invoice-pdf-dialog');
            var frame   = document.getElementById('invoice-pdf-frame');
            var openBtn = document.getElementById('invoice-pdf-open');
            var closeBtn= document.getElementById('invoice-pdf-close');
            if (!dialog || !frame || !openBtn) return;

            function ensureLoaded() {
                var url = frame.dataset.previewUrl;
                if (url && !frame.getAttribute('src')) frame.setAttribute('src', url);
            }

            openBtn.addEventListener('click', function () { ensureLoaded(); dialog.showModal(); });
            if (closeBtn) closeBtn.addEventListener('click', function () { dialog.close(); });
            dialog.addEventListener('click', function (e) { if (e.target === dialog) dialog.close(); });
        })();
    </script>
@endpush
