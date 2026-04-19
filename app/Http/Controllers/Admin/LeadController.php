<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Lead;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class LeadController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status');

        $leads = Lead::query()
            ->when($status && array_key_exists($status, Lead::statusLabels()), fn ($q) => $q->where('status', $status))
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        return view('admin.leads.index', [
            'leads' => $leads,
            'statusFilter' => $status,
            'statusLabels' => Lead::statusLabels(),
        ]);
    }

    public function show(Lead $lead): View
    {
        $linkedClient = null;
        if ($lead->status === 'won') {
            $linkedClient = Client::query()
                ->whereRaw('LOWER(email) = ?', [Str::lower($lead->email)])
                ->first();
        }

        return view('admin.leads.show', [
            'lead' => $lead,
            'linkedClient' => $linkedClient,
            'statusLabels' => Lead::statusLabels(),
        ]);
    }

    public function update(Request $request, Lead $lead): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:'.implode(',', array_keys(Lead::statusLabels()))],
            'admin_notes' => ['nullable', 'string', 'max:5000'],
        ]);

        $previousStatus = $lead->status;

        DB::transaction(function () use ($lead, $validated): void {
            $lead->update($validated);
            $lead->syncToClientWhenWon();
        });

        $message = 'Lead updated successfully.';
        if ($lead->status === 'won' && $previousStatus !== 'won') {
            $message .= ' A matching client record was added or updated from this lead.';
        }

        return redirect()
            ->route('admin.leads.show', $lead)
            ->with('status', $message);
    }
}
