@extends('layouts.admin')

@section('title', 'Edit Invoice #' . $invoice->id)

@section('content')
    <div class="mb-5 flex items-center gap-2">
        <a href="{{ route('admin.facturas.index') }}" class="text-sm text-slate-400 hover:text-brand-navy">Invoices</a>
        <svg class="h-4 w-4 text-slate-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('admin.facturas.show', $invoice) }}" class="text-sm text-slate-400 hover:text-brand-navy">#{{ $invoice->id }}</a>
        <svg class="h-4 w-4 text-slate-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span class="text-sm text-slate-500">Edit</span>
    </div>

    <form method="POST" action="{{ route('admin.facturas.update', $invoice) }}">
        @csrf
        @method('PUT')

        <div class="grid gap-5 lg:grid-cols-3">

            {{-- ── LEFT: Line items + notes ── --}}
            <div class="flex flex-col gap-5 lg:col-span-2">

                <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div class="border-b border-slate-100 px-5 py-4">
                        <p class="font-heading text-sm font-semibold text-brand-navy">Line Items</p>
                        <p class="text-xs text-slate-400">Add services or products billed on this invoice.</p>
                    </div>
                    <div class="p-5">
                        @include('admin.invoices._items', ['invoice' => $invoice])
                        @error('items')
                            <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <label for="notes" class="block text-xs font-semibold uppercase tracking-wide text-brand-navy">
                        Internal Notes
                        <span class="ml-1 font-normal normal-case text-slate-400">(optional)</span>
                    </label>
                    <textarea id="notes" name="notes" rows="3"
                              class="mt-1.5 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-brand-navy placeholder-slate-400 shadow-sm focus:border-brand-turquoise focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-turquoise/25"
                              placeholder="Scheduled time, special instructions…">{{ old('notes', $invoice->notes) }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- ── RIGHT: Details + actions sidebar ── --}}
            <div class="flex flex-col gap-5 lg:col-span-1">

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="mb-4 text-[10px] font-bold uppercase tracking-widest text-slate-400">Invoice Details</p>
                    <div class="space-y-4">
                        <div>
                            <label for="client_id" class="block text-xs font-semibold uppercase tracking-wide text-brand-navy">Client <span class="text-brand-fuchsia">*</span></label>
                            <select id="client_id" name="client_id" required
                                    class="mt-1.5 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-brand-navy shadow-sm focus:border-brand-turquoise focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-turquoise/25">
                                @foreach ($clients as $c)
                                    <option value="{{ $c->id }}" @selected(old('client_id', $invoice->client_id) == $c->id)>{{ $c->name }}</option>
                                @endforeach
                            </select>
                            @error('client_id')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="date" class="block text-xs font-semibold uppercase tracking-wide text-brand-navy">Date <span class="text-brand-fuchsia">*</span></label>
                            <input type="date" id="date" name="date"
                                   value="{{ old('date', $invoice->date->toDateString()) }}" required
                                   class="mt-1.5 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-brand-navy shadow-sm focus:border-brand-turquoise focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-turquoise/25" />
                            @error('date')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="status" class="block text-xs font-semibold uppercase tracking-wide text-brand-navy">Status</label>
                            <select id="status" name="status" required
                                    class="mt-1.5 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-brand-navy shadow-sm focus:border-brand-turquoise focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-turquoise/25">
                                @foreach ($statusLabels as $value => $label)
                                    <option value="{{ $value }}" @selected(old('status', $invoice->status) === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('status')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Total summary --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Summary</p>
                    <div class="mt-3 flex items-center justify-between">
                        <span class="text-sm text-slate-500">Estimated total</span>
                        <span id="invoice-live-total-sidebar" class="font-heading text-2xl font-bold text-brand-navy">$0.00</span>
                    </div>
                    <p class="mt-1 text-[10px] text-slate-400">Recalculates as you type.</p>
                </div>

                {{-- Action buttons --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex flex-col gap-3">
                        <button type="submit"
                                class="flex w-full items-center justify-center gap-2 rounded-xl bg-brand-fuchsia px-6 py-3 text-sm font-semibold text-white shadow-md shadow-brand-fuchsia/30 transition hover:bg-brand-fuchsia-dark active:scale-95">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                            </svg>
                            Save Changes
                        </button>
                        <a href="{{ route('admin.facturas.show', $invoice) }}"
                           class="flex w-full items-center justify-center rounded-xl border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                            Cancel
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </form>
@endsection

@push('scripts')
<script>
(function () {
    var sidebar = document.getElementById('invoice-live-total-sidebar');
    var main    = document.getElementById('invoice-live-total');
    if (!sidebar || !main) return;

    function sync() { sidebar.textContent = '$' + (main.textContent || '0.00'); }
    var prev = '';
    setInterval(function () {
        if (main.textContent !== prev) { prev = main.textContent; sync(); }
    }, 100);
    sync();
})();
</script>
@endpush
