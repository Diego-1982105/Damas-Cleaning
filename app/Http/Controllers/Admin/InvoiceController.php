<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\InvoicePdfMail;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Support\InvoicePdfFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class InvoiceController extends Controller
{
    public function index(Request $request): View
    {
        $spec = $this->invoiceReportFilterSpec($request);

        $invoices = Invoice::query()
            ->with('client')
            ->tap($spec['apply'])
            ->orderByDesc('date')
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        $summary = Invoice::query()
            ->tap($spec['apply'])
            ->selectRaw('COUNT(*) as c, COALESCE(SUM(total), 0) as sum_total')
            ->first();

        $clients = Client::query()->orderBy('name')->get();

        return view('admin.invoices.index', [
            'invoices' => $invoices,
            'clients' => $clients,
            'statusLabels' => Invoice::statusLabels(),
            'monthFilter' => $request->query('month'),
            'dateFromFilter' => $request->query('date_from'),
            'dateToFilter' => $request->query('date_to'),
            'clientIdFilter' => $request->query('client_id'),
            'statusFilter' => $request->query('status'),
            'hasActiveFilters' => $spec['active'],
            'summaryCount' => (int) ($summary->c ?? 0),
            'summaryTotal' => (float) ($summary->sum_total ?? 0),
        ]);
    }

    /**
     * Filtros tipo reporte (mes, rango de fechas, cliente, estado). Se combinan con AND.
     *
     * @return array{apply: callable(Builder<\App\Models\Invoice>): void, active: bool}
     */
    private function invoiceReportFilterSpec(Request $request): array
    {
        $month = $request->query('month');
        $validMonth = is_string($month) && preg_match('/^\d{4}-\d{2}$/', $month);

        $dateFrom = $request->query('date_from');
        $validDateFrom = is_string($dateFrom) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateFrom);

        $dateTo = $request->query('date_to');
        $validDateTo = is_string($dateTo) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateTo);

        $clientId = $request->query('client_id');
        $validClientId = $clientId !== null && $clientId !== ''
            && ctype_digit((string) $clientId)
            && Client::query()->whereKey((int) $clientId)->exists();

        $status = $request->query('status');
        $validStatus = is_string($status) && array_key_exists($status, Invoice::statusLabels());

        $active = $validMonth || $validDateFrom || $validDateTo || $validClientId || $validStatus;

        $apply = function (Builder $q) use ($validMonth, $month, $validDateFrom, $dateFrom, $validDateTo, $dateTo, $validClientId, $clientId, $validStatus, $status): void {
            if ($validMonth) {
                [$y, $m] = explode('-', (string) $month);
                $q->whereYear('date', (int) $y)->whereMonth('date', (int) $m);
            }
            if ($validDateFrom) {
                $q->whereDate('date', '>=', $dateFrom);
            }
            if ($validDateTo) {
                $q->whereDate('date', '<=', $dateTo);
            }
            if ($validClientId) {
                $q->where('client_id', (int) $clientId);
            }
            if ($validStatus) {
                $q->where('status', $status);
            }
        };

        return ['apply' => $apply, 'active' => $active];
    }

    public function create(): View
    {
        $clients = Client::query()->orderBy('name')->get();

        return view('admin.invoices.create', [
            'clients' => $clients,
            'statusLabels' => Invoice::statusLabels(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatedInvoice($request);

        $invoice = DB::transaction(function () use ($validated): Invoice {
            $invoice = Invoice::create([
                'client_id' => $validated['client_id'],
                'date' => $validated['date'],
                'status' => $validated['status'],
                'notes' => $validated['notes'] ?? null,
                'total' => 0,
            ]);

            foreach ($validated['items'] as $idx => $row) {
                $line = InvoiceItem::lineTotal($row['quantity'], $row['price']);
                $invoice->items()->create([
                    'description' => $row['description'],
                    'quantity' => $row['quantity'],
                    'price' => $row['price'],
                    'total' => $line,
                    'sort_order' => $idx,
                ]);
            }

            $invoice->recalculateTotal();

            return $invoice->fresh(['items']);
        });

        return redirect()
            ->route('admin.facturas.show', $invoice)
            ->with('status', 'Invoice created successfully.');
    }

    public function show(Invoice $invoice): View
    {
        $invoice->load(['client', 'items']);

        return view('admin.invoices.show', [
            'invoice' => $invoice,
            'statusLabels' => Invoice::statusLabels(),
        ]);
    }

    public function pdfPreview(Invoice $invoice): Response
    {
        return InvoicePdfFactory::make($invoice)
            ->stream(InvoicePdfFactory::downloadFilename($invoice));
    }

    public function pdf(Invoice $invoice): Response
    {
        return InvoicePdfFactory::make($invoice)
            ->download(InvoicePdfFactory::downloadFilename($invoice));
    }

    public function emailPdf(Request $request, Invoice $invoice): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:254'],
        ]);

        try {
            Mail::to($validated['email'])->send(new InvoicePdfMail($invoice));
        } catch (Throwable $e) {
            report($e);

            return redirect()
                ->route('admin.facturas.show', $invoice)
                ->with('error', 'Could not send email. Check your mail configuration and try again.');
        }

        return redirect()
            ->route('admin.facturas.show', $invoice)
            ->with('status', 'Invoice PDF sent to '.$validated['email'].'.');
    }

    public function edit(Invoice $invoice): View
    {
        $invoice->load('items');
        $clients = Client::query()->orderBy('name')->get();

        return view('admin.invoices.edit', [
            'invoice' => $invoice,
            'clients' => $clients,
            'statusLabels' => Invoice::statusLabels(),
        ]);
    }

    public function update(Request $request, Invoice $invoice): RedirectResponse
    {
        $validated = $this->validatedInvoice($request);

        DB::transaction(function () use ($validated, $invoice): void {
            $invoice->update([
                'client_id' => $validated['client_id'],
                'date' => $validated['date'],
                'status' => $validated['status'],
                'notes' => $validated['notes'] ?? null,
            ]);

            $invoice->items()->delete();

            foreach ($validated['items'] as $idx => $row) {
                $line = InvoiceItem::lineTotal($row['quantity'], $row['price']);
                $invoice->items()->create([
                    'description' => $row['description'],
                    'quantity' => $row['quantity'],
                    'price' => $row['price'],
                    'total' => $line,
                    'sort_order' => $idx,
                ]);
            }

            $invoice->recalculateTotal();
        });

        return redirect()
            ->route('admin.facturas.show', $invoice)
            ->with('status', 'Invoice updated successfully.');
    }

    public function destroy(Invoice $invoice): RedirectResponse
    {
        $invoice->delete();

        return redirect()
            ->route('admin.facturas.index')
            ->with('status', 'Invoice deleted.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedInvoice(Request $request): array
    {
        return $request->validate([
            'client_id' => ['required', 'exists:clients,id'],
            'date' => ['required', 'date'],
            'status' => ['required', 'string', Rule::in(array_keys(Invoice::statusLabels()))],
            'notes' => ['nullable', 'string', 'max:10000'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.description' => ['required', 'string', 'max:500'],
            'items.*.quantity' => ['required', 'numeric', 'min:0.01'],
            'items.*.price' => ['required', 'numeric', 'min:0'],
        ]);
    }
}
