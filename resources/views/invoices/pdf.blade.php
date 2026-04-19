@php
    /** @var \App\Models\Invoice $invoice */
    $company      = is_array($company ?? null) ? $company : config('invoice');
    $pad          = max(1, (int) ($company['number_pad'] ?? 8));
    $prefix       = (string) ($company['number_prefix'] ?? '');
    $displayNumber = $prefix . str_pad((string) $invoice->id, $pad, '0', STR_PAD_LEFT);
    $serviceDate  = $invoice->date->format('M d, Y');
    $invoiceDate  = $invoice->date->format('M d, Y');
    $total        = (float) $invoice->total;
    $isPaid       = $invoice->status === 'paid';
    $amountDue    = $isPaid ? 0.0 : $total;
    $fmtMoney     = fn (float $n): string => '$' . number_format($n, 2);
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice {{ $displayNumber }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: DejaVu Sans, Helvetica, Arial, sans-serif;
            font-size: 10.5px;
            color: #374151;
            background: #ffffff;
        }

        /* ── Brand header ── */
        .header-table { width: 100%; background-color: #831843; }
        .header-left  { padding: 22px 28px 22px 32px; vertical-align: middle; width: 58%; }
        .header-right { padding: 22px 32px 22px 0;    vertical-align: middle; width: 42%; text-align: right; }

        .company-name {
            font-size: 14px;
            font-weight: bold;
            color: #ffffff;
            letter-spacing: 0.4px;
        }
        .company-sub {
            font-size: 8.5px;
            color: #fda4af;       /* soft rose-300 */
            margin-top: 3px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .invoice-word {
            font-size: 28px;
            font-weight: bold;
            color: #ffffff;
            letter-spacing: 2px;
            text-transform: uppercase;
            line-height: 1;
        }
        .invoice-num {
            font-size: 9.5px;
            color: #fda4af;
            margin-top: 5px;
            letter-spacing: 0.5px;
        }

        /* ── Accent stripe: brand fuchsia ── */
        .stripe { height: 4px; background-color: #e91e63; }

        /* ── Body wrap ── */
        .wrap { padding: 26px 32px 0; }

        /* ── Section label ── */
        .label {
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: #831843;
            border-bottom: 1px solid #fce7f3;
            padding-bottom: 4px;
            margin-bottom: 8px;
        }

        /* ── Info cards ── */
        .card {
            background-color: #fdf3f7;   /* brand-surface */
            border: 1px solid #fce7f3;
            border-left: 3px solid #831843;
            padding: 13px 15px;
        }
        .card-name {
            font-size: 11.5px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 5px;
        }
        .card-detail {
            font-size: 10px;
            color: #6b7280;
            line-height: 1.65;
        }
        .meta-lbl {
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #9d174d;
            margin-bottom: 2px;
        }
        .meta-val {
            font-size: 10.5px;
            font-weight: bold;
            color: #1f2937;
        }

        /* ── Line items ── */
        .items { width: 100%; border-collapse: collapse; }
        .items thead tr { background-color: #831843; }
        .items thead th {
            padding: 9px 12px;
            font-size: 8.5px;
            font-weight: bold;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            color: #ffffff;
            text-align: left;
        }
        .items thead th.r { text-align: right; }

        .items tbody tr { border-bottom: 1px solid #f3e8ef; }
        .items tbody tr.alt { background-color: #fdf3f7; }
        .items tbody td {
            padding: 9px 12px;
            color: #374151;
            font-size: 10.5px;
            vertical-align: top;
        }
        .items tbody td.r    { text-align: right; }
        .items tbody td.dim  { color: #9ca3af; }
        .col-date { width: 15%; white-space: nowrap; }
        .col-amt  { width: 17%; }
        .col-pay  { width: 17%; }

        /* ── Payment received row ── */
        .pay-row td {
            background-color: #f0fdf4 !important;
            color: #166534 !important;
            font-weight: bold;
        }

        /* ── Totals ── */
        .totals-wrap {
            margin-top: 0;
            padding: 0 32px 0;
        }
        .totals-inner {
            width: 44%;
            margin-left: auto;
            border-collapse: collapse;
        }
        .totals-inner td { padding: 5px 10px; font-size: 10.5px; }
        .totals-inner .tl { color: #6b7280; text-align: right; }
        .totals-inner .tv { text-align: right; font-weight: bold; color: #1f2937; width: 38%; }

        .due-box {
            background-color: #fdf3f7;
            border: 1px solid #fce7f3;
            border-top: 3px solid #831843;
            padding: 12px 14px;
            text-align: right;
        }
        .due-lbl { font-size: 10px; font-weight: bold; color: #831843; letter-spacing: 0.5px; text-transform: uppercase; }
        .due-amt { font-size: 18px; font-weight: bold; color: #831843; margin-top: 3px; }

        /* ── Paid badge ── */
        .paid-stamp {
            display: inline-block;
            background-color: #dcfce7;
            border: 2px solid #16a34a;
            color: #15803d;
            font-size: 10.5px;
            font-weight: bold;
            letter-spacing: 2px;
            text-transform: uppercase;
            padding: 5px 14px;
        }

        /* ── Notes ── */
        .notes-box {
            background-color: #fdf3f7;
            border-left: 3px solid #e91e63;
            padding: 10px 14px;
            font-size: 10px;
            color: #6b7280;
            line-height: 1.6;
        }

        /* ── Footer ── */
        .footer-stripe { height: 3px; background-color: #831843; margin-top: 28px; }
        .footer-bar {
            background-color: #fdf3f7;
            padding: 11px 32px;
            text-align: center;
            font-size: 9px;
            color: #9d174d;
            letter-spacing: 0.4px;
        }

        .spacer-sm { height: 14px; }
        .spacer-md { height: 22px; }
        .w-full { width: 100%; }
    </style>
</head>
<body>

{{-- ── Brand header ── --}}
<table class="header-table" cellspacing="0" cellpadding="0">
    <tr>
        <td class="header-left">
            @if (! empty($logoBase64))
                <img src="{{ $logoBase64 }}" alt=""
                     style="max-height: 46px; max-width: 46px; border-radius: 6px;
                            vertical-align: middle; margin-right: 11px;
                            border: 2px solid rgba(255,255,255,.25);"/>
            @endif
            <span class="company-name">{{ $company['company_name'] ?? 'Damas Cleaning Home Services' }}</span>
            <div class="company-sub">Professional Cleaning Services</div>
        </td>
        <td class="header-right">
            <div class="invoice-word">Invoice</div>
            <div class="invoice-num">{{ $displayNumber }}</div>
        </td>
    </tr>
</table>

{{-- Fuchsia accent stripe --}}
<div class="stripe"></div>

{{-- ── Body ── --}}
<div class="wrap">

    <div class="spacer-sm"></div>

    {{-- ── Bill To + Invoice meta ── --}}
    <table class="w-full" cellspacing="0" cellpadding="0">
        <tr>
            {{-- Bill To --}}
            <td style="width: 52%; vertical-align: top; padding-right: 14px;">
                <div class="label">Bill To</div>
                <div class="card">
                    <div class="card-name">{{ $invoice->client->name }}</div>
                    <div class="card-detail">
                        @if ($invoice->client->address)
                            {!! nl2br(e($invoice->client->address)) !!}<br>
                        @endif
                        @if ($invoice->client->phone)
                            {{ $invoice->client->phone }}<br>
                        @endif
                        @if ($invoice->client->email)
                            {{ $invoice->client->email }}
                        @endif
                    </div>
                </div>
            </td>
            {{-- Invoice meta --}}
            <td style="width: 48%; vertical-align: top;">
                <div class="label">Invoice Details</div>
                <div class="card">
                    <table class="w-full" cellspacing="0" cellpadding="0">
                        <tr>
                            <td style="padding-bottom: 9px; width: 50%;">
                                <div class="meta-lbl">Date</div>
                                <div class="meta-val">{{ $invoiceDate }}</div>
                            </td>
                            <td style="padding-bottom: 9px;">
                                <div class="meta-lbl">Terms</div>
                                <div class="meta-val">{{ $company['terms'] ?? 'Due on receipt' }}</div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="border-top: 1px solid #fce7f3; padding-top: 9px;">
                                <div class="meta-lbl">From</div>
                                <div class="card-detail" style="margin-top: 3px;">
                                    {{ $company['company_address'] ?? '' }}<br>
                                    {{ $company['company_phones'] ?? '' }}<br>
                                    <strong>{{ $company['payment_method'] ?? 'Cash only' }}</strong>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>

    <div class="spacer-md"></div>

    {{-- ── Line items ── --}}
    <div class="label">Services</div>
    <table class="items" cellspacing="0" cellpadding="0">
        <thead>
            <tr>
                <th class="col-date">Date</th>
                <th>Description</th>
                <th class="col-amt r">Amount</th>
                <th class="col-pay r">Payment</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoice->items as $i => $line)
                <tr class="{{ $i % 2 === 1 ? 'alt' : '' }}">
                    <td class="col-date dim">{{ $serviceDate }}</td>
                    <td>{{ $line->description }}</td>
                    <td class="col-amt r">{{ $fmtMoney((float) $line->total) }}</td>
                    <td class="col-pay r dim">—</td>
                </tr>
            @endforeach
            @if ($isPaid)
                <tr class="pay-row">
                    <td class="col-date">{{ $serviceDate }}</td>
                    <td>Payment received ({{ $company['payment_method'] ?? 'Cash' }})</td>
                    <td class="col-amt r">—</td>
                    <td class="col-pay r">{{ $fmtMoney($total) }}</td>
                </tr>
            @endif
        </tbody>
    </table>

    <div class="spacer-md"></div>

    {{-- ── Totals ── --}}
    <table class="w-full" cellspacing="0" cellpadding="0">
        <tr>
            {{-- Left: paid stamp or empty --}}
            <td style="vertical-align: bottom; padding-bottom: 4px;">
                @if ($isPaid)
                    <span class="paid-stamp">✓ Paid in full</span>
                @endif
            </td>
            {{-- Right: subtotals + due box --}}
            <td style="width: 46%; vertical-align: top;">
                <table class="w-full" cellspacing="0" cellpadding="0"
                       style="margin-bottom: 6px; border-bottom: 1px solid #fce7f3;">
                    <tr>
                        <td style="text-align:right; padding: 4px 10px; color:#6b7280; font-size:10.5px;">Subtotal</td>
                        <td style="text-align:right; padding: 4px 10px; font-weight:bold; color:#1f2937; font-size:10.5px; width:38%;">{{ $fmtMoney($total) }}</td>
                    </tr>
                    <tr>
                        <td style="text-align:right; padding: 4px 10px; color:#15803d; font-size:10.5px;">Payments</td>
                        <td style="text-align:right; padding: 4px 10px; font-weight:bold; color:#15803d; font-size:10.5px; width:38%;">{{ $isPaid ? '– '.$fmtMoney($total) : $fmtMoney(0) }}</td>
                    </tr>
                </table>
                <div class="due-box">
                    <div class="due-lbl">Amount Due</div>
                    <div class="due-amt">{{ $fmtMoney($amountDue) }}</div>
                </div>
            </td>
        </tr>
    </table>

    {{-- ── Notes ── --}}
    @if ($invoice->notes)
        <div class="spacer-md"></div>
        <div class="label">Notes</div>
        <div class="notes-box">{{ $invoice->notes }}</div>
    @endif

</div>

{{-- ── Footer ── --}}
<div class="footer-stripe"></div>
<div class="footer-bar">
    Thank you for choosing {{ $company['company_name'] ?? 'Damas Cleaning Home Services' }} — we appreciate your business.
</div>

</body>
</html>
