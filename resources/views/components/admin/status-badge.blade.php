@props(['invoice'])
@php
    $cls   = $invoice->statusBadgeClass();
    $label = $invoice->statusLabel();
@endphp
<span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold ring-1 ring-inset {{ $cls }}">
    {{ $label }}
</span>
