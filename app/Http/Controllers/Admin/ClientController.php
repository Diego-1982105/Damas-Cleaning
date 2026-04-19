<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientController extends Controller
{
    public function index(): View
    {
        $clients = Client::query()
            ->withCount('invoices')
            ->orderBy('name')
            ->paginate(25);

        return view('admin.clients.index', compact('clients'));
    }

    public function create(): View
    {
        return view('admin.clients.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:2000'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
        ]);

        Client::create($validated);

        return redirect()
            ->route('admin.clientes.index')
            ->with('status', 'Client created successfully.');
    }

    public function edit(Client $client): View
    {
        return view('admin.clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:2000'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
        ]);

        $client->update($validated);

        return redirect()
            ->route('admin.clientes.index')
            ->with('status', 'Client updated successfully.');
    }

    public function toggleActive(Client $client): RedirectResponse
    {
        $client->update(['active' => ! $client->active]);

        $label = $client->active ? 'enabled' : 'disabled';

        return redirect()
            ->route('admin.clientes.index')
            ->with('status', "Client \"{$client->name}\" {$label}.");
    }

    public function destroy(Client $client): RedirectResponse
    {
        if ($client->invoices()->exists()) {
            return redirect()
                ->route('admin.clientes.index')
                ->with('error', 'Cannot delete: this client has invoices linked to them.');
        }

        $client->delete();

        return redirect()
            ->route('admin.clientes.index')
            ->with('status', 'Client deleted.');
    }
}
