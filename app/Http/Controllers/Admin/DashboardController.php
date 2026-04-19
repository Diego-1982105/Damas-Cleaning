<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $driver = DB::getDriverName();
        $monthExpr = $driver === 'sqlite'
            ? "strftime('%Y-%m', invoices.date)"
            : "DATE_FORMAT(invoices.date, '%Y-%m')";

        $from = now()->subMonths(11)->startOfMonth();

        $paidByMonth = Invoice::query()
            ->where('status', 'paid')
            ->where('date', '>=', $from->toDateString())
            ->selectRaw("{$monthExpr} as ym, SUM(invoices.total) as sum_total")
            ->groupByRaw($monthExpr)
            ->orderByRaw($monthExpr)
            ->pluck('sum_total', 'ym');

        $months = collect(range(0, 11))->map(function (int $i) use ($from): array {
            $d = $from->copy()->addMonths($i)->locale('en');

            return [
                'ym' => $d->format('Y-m'),
                'label' => $d->translatedFormat('M Y'),
            ];
        });

        $chart = $months->map(function (array $row) use ($paidByMonth): array {
            $total = (float) ($paidByMonth[$row['ym']] ?? 0);

            return [
                'ym' => $row['ym'],
                'label' => $row['label'],
                'total' => $total,
            ];
        });

        $maxChart = max($chart->max('total') ?: 0, 1);

        $topClients = Client::query()
            ->selectRaw('clients.id, clients.name, SUM(invoices.total) as revenue')
            ->join('invoices', 'invoices.client_id', '=', 'clients.id')
            ->whereIn('invoices.status', ['paid', 'sent'])
            ->groupBy('clients.id', 'clients.name')
            ->orderByDesc('revenue')
            ->limit(5)
            ->get();

        $totalsByStatus = Invoice::query()
            ->selectRaw('status, COUNT(*) as c, COALESCE(SUM(total), 0) as sum_total')
            ->groupBy('status')
            ->get()
            ->keyBy('status');

        $recentInvoices = Invoice::query()
            ->with('client')
            ->orderByDesc('date')
            ->orderByDesc('id')
            ->limit(10)
            ->get();

        $ytdPaid = Invoice::query()
            ->where('status', 'paid')
            ->whereYear('date', now()->year)
            ->sum('total');

        $invoicesTotalCount = Invoice::query()->count();
        $invoicesThisMonthCount = Invoice::query()
            ->whereYear('date', now()->year)
            ->whereMonth('date', now()->month)
            ->count();

        return view('admin.dashboard', [
            'chart' => $chart,
            'maxChart' => $maxChart,
            'topClients' => $topClients,
            'totalsByStatus' => $totalsByStatus,
            'recentInvoices' => $recentInvoices,
            'ytdPaid' => $ytdPaid,
            'invoicesTotalCount' => $invoicesTotalCount,
            'invoicesThisMonthCount' => $invoicesThisMonthCount,
            'statusLabels' => Invoice::statusLabels(),
        ]);
    }
}
