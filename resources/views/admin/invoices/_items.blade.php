@php
    if (old('items')) {
        $rows = collect(old('items'))->map(fn (array $r): object => (object) $r);
    } elseif (isset($invoice) && $invoice?->items->isNotEmpty()) {
        $rows = $invoice->items;
    } else {
        $rows = collect([(object) ['description' => '', 'quantity' => '1', 'price' => '']]);
    }
@endphp

<div class="overflow-x-auto rounded-xl border border-slate-200">
    <table class="min-w-full divide-y divide-slate-100 text-sm">
        <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-400">
            <tr>
                <th class="px-4 py-2.5 text-left">Description</th>
                <th class="w-24 px-4 py-2.5 text-right">Qty</th>
                <th class="w-28 px-4 py-2.5 text-right">Unit price</th>
                <th class="w-24 px-4 py-2.5 text-right">Amount</th>
                <th class="w-10 px-2 py-2.5"></th>
            </tr>
        </thead>
        <tbody id="invoice-items-rows" class="divide-y divide-slate-100 bg-white">
            @foreach ($rows as $index => $item)
                <tr class="invoice-item-row">
                    <td class="px-4 py-2.5">
                        <input
                            type="text"
                            name="items[{{ $index }}][description]"
                            value="{{ old('items.'.$index.'.description', $item->description ?? '') }}"
                            required
                            class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-brand-navy focus:border-brand-turquoise focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-turquoise/25"
                            placeholder="e.g. Deep clean — living room"
                        />
                    </td>
                    <td class="px-4 py-2.5">
                        <input
                            type="number"
                            name="items[{{ $index }}][quantity]"
                            value="{{ old('items.'.$index.'.quantity', $item->quantity ?? '1') }}"
                            step="0.01" min="0.01" required
                            class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-right text-sm text-brand-navy focus:border-brand-turquoise focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-turquoise/25"
                        />
                    </td>
                    <td class="px-4 py-2.5">
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-2.5 flex items-center text-slate-400 text-xs">$</span>
                            <input
                                type="number"
                                name="items[{{ $index }}][price]"
                                value="{{ old('items.'.$index.'.price', $item->price ?? '') }}"
                                step="0.01" min="0" required
                                class="w-full rounded-lg border border-slate-200 bg-slate-50 py-2 pl-6 pr-3 text-right text-sm text-brand-navy focus:border-brand-turquoise focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-turquoise/25"
                                placeholder="0.00"
                            />
                        </div>
                    </td>
                    <td class="px-4 py-2.5 text-right font-medium text-brand-navy item-amount">—</td>
                    <td class="px-2 py-2.5 text-center">
                        <button
                            type="button"
                            title="Remove row"
                            class="flex h-7 w-7 items-center justify-center rounded-lg text-slate-300 hover:bg-red-50 hover:text-red-500 transition-colors"
                            onclick="window.removeInvoiceItemRow(this)"
                        >
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot class="border-t-2 border-slate-200 bg-slate-50">
            <tr>
                <td colspan="3" class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-400">Total</td>
                <td class="px-4 py-3 text-right font-heading text-base font-bold text-brand-navy">
                    $<span id="invoice-live-total">0.00</span>
                </td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</div>

<button
    type="button"
    onclick="window.addInvoiceItemRow()"
    class="mt-3 inline-flex items-center gap-2 rounded-xl border border-brand-turquoise/30 bg-brand-turquoise/5 px-4 py-2 text-sm font-semibold text-brand-navy hover:bg-brand-turquoise/10 transition-colors"
>
    <svg class="h-4 w-4 text-brand-turquoise" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
    </svg>
    Add line item
</button>

@push('scripts')
    <script>
        (function () {
            const tbody = document.getElementById('invoice-items-rows');
            if (!tbody) return;

            const totalEl = document.getElementById('invoice-live-total');

            function rowAmount(tr) {
                const q = parseFloat(tr.querySelector('input[name*="[quantity]"]')?.value) || 0;
                const p = parseFloat(tr.querySelector('input[name*="[price]"]')?.value) || 0;
                return q * p;
            }

            function invoiceLiveRecalc() {
                let sum = 0;
                tbody.querySelectorAll('tr.invoice-item-row').forEach(function (tr) {
                    const amt = rowAmount(tr);
                    sum += amt;
                    const amtCell = tr.querySelector('.item-amount');
                    if (amtCell) amtCell.textContent = amt > 0 ? '$' + amt.toFixed(2) : '—';
                });
                if (totalEl) totalEl.textContent = sum.toFixed(2);
            }

            window.invoiceLiveRecalc = invoiceLiveRecalc;

            function reindexInvoiceItems() {
                tbody.querySelectorAll('tr.invoice-item-row').forEach(function (tr, i) {
                    tr.querySelectorAll('input').forEach(function (inp) {
                        if (!inp.name) return;
                        inp.name = inp.name.replace(/items\[\d+\]/, 'items[' + i + ']');
                    });
                });
                invoiceLiveRecalc();
            }

            tbody.addEventListener('input', function (e) {
                if (e.target?.matches('input[name*="[quantity]"], input[name*="[price]"]')) {
                    invoiceLiveRecalc();
                }
            });

            function buildRow(i) {
                const tr = document.createElement('tr');
                tr.className = 'invoice-item-row';
                tr.innerHTML =
                    '<td class="px-4 py-2.5">' +
                    '<input type="text" name="items[' + i + '][description]" required ' +
                    'class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-brand-navy focus:border-brand-turquoise focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-turquoise/25" placeholder="Description" />' +
                    '</td>' +
                    '<td class="px-4 py-2.5">' +
                    '<input type="number" name="items[' + i + '][quantity]" value="1" step="0.01" min="0.01" required ' +
                    'class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-right text-sm text-brand-navy focus:border-brand-turquoise focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-turquoise/25" />' +
                    '</td>' +
                    '<td class="px-4 py-2.5">' +
                    '<div class="relative">' +
                    '<span class="pointer-events-none absolute inset-y-0 left-2.5 flex items-center text-slate-400 text-xs">$</span>' +
                    '<input type="number" name="items[' + i + '][price]" value="" step="0.01" min="0" required ' +
                    'class="w-full rounded-lg border border-slate-200 bg-slate-50 py-2 pl-6 pr-3 text-right text-sm text-brand-navy focus:border-brand-turquoise focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-turquoise/25" placeholder="0.00" />' +
                    '</div>' +
                    '</td>' +
                    '<td class="px-4 py-2.5 text-right font-medium text-brand-navy item-amount">—</td>' +
                    '<td class="px-2 py-2.5 text-center">' +
                    '<button type="button" title="Remove row" onclick="window.removeInvoiceItemRow(this)" ' +
                    'class="flex h-7 w-7 items-center justify-center rounded-lg text-slate-300 hover:bg-red-50 hover:text-red-500 transition-colors">' +
                    '<svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>' +
                    '</button>' +
                    '</td>';
                return tr;
            }

            window.addInvoiceItemRow = function () {
                const i = tbody.querySelectorAll('tr.invoice-item-row').length;
                tbody.appendChild(buildRow(i));
                tbody.lastElementChild.querySelector('input[type=text]')?.focus();
                invoiceLiveRecalc();
            };

            window.removeInvoiceItemRow = function (btn) {
                const rows = tbody.querySelectorAll('tr.invoice-item-row');
                if (rows.length <= 1) return;
                btn.closest('tr').remove();
                reindexInvoiceItems();
            };

            invoiceLiveRecalc();
        })();
    </script>
@endpush
