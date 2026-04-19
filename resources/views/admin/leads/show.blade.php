@extends('layouts.admin')

@section('title', 'Lead #'.$lead->id)

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.leads.index') }}" class="text-sm font-medium text-brand-turquoise hover:underline">← Back to list</a>
    </div>

    <h1 class="font-heading text-3xl font-bold text-brand-navy">Lead #{{ $lead->id }}</h1>
    <p class="mt-1 text-sm text-brand-body">Received {{ $lead->created_at->timezone(config('app.timezone'))->format('M j, Y \a\t g:i A') }}</p>

    @if ($lead->status === 'won' && $linkedClient)
        <div class="mt-4 rounded-xl border border-brand-turquoise/40 bg-brand-turquoise/10 px-4 py-3 text-sm text-brand-navy">
            <span class="font-medium">Won:</span>
            this request is linked to the
            <a href="{{ route('admin.clientes.edit', $linkedClient) }}" class="font-semibold text-brand-turquoise hover:underline">matching client record</a>
            (same email). You can complete address or details there before invoicing.
        </div>
    @endif

    <div class="mt-8 grid gap-8 lg:grid-cols-2">
        <div class="rounded-2xl border border-brand-navy/10 bg-white p-6 shadow-sm">
            <h2 class="font-heading text-lg font-semibold text-brand-navy">Contact details</h2>
            <dl class="mt-4 space-y-3 text-sm">
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wide text-brand-turquoise">Name</dt>
                    <dd class="mt-0.5 text-brand-navy">{{ $lead->name }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wide text-brand-turquoise">Email</dt>
                    <dd class="mt-0.5"><a href="mailto:{{ $lead->email }}" class="text-brand-turquoise hover:underline">{{ $lead->email }}</a></dd>
                </div>
                @if ($lead->phone)
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-brand-turquoise">Phone</dt>
                        <dd class="mt-0.5"><a href="tel:{{ $lead->phone }}" class="text-brand-turquoise hover:underline">{{ $lead->phone }}</a></dd>
                    </div>
                @endif
                @if ($lead->address)
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-brand-turquoise">Service address</dt>
                        <dd class="mt-0.5 whitespace-pre-line text-brand-body">{{ $lead->address }}</dd>
                    </div>
                @endif
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wide text-brand-turquoise">Service interest</dt>
                    <dd class="mt-0.5 text-brand-body">{{ $lead->service_type ?: '—' }}</dd>
                </div>
                @if ($lead->message)
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-brand-turquoise">Message</dt>
                        <dd class="mt-0.5 whitespace-pre-wrap text-brand-body">{{ $lead->message }}</dd>
                    </div>
                @endif
            </dl>
        </div>

        <div class="rounded-2xl border border-brand-navy/10 bg-white p-6 shadow-sm">
            <h2 class="font-heading text-lg font-semibold text-brand-navy">Internal follow-up</h2>
            <form method="POST" action="{{ route('admin.leads.update', $lead) }}" class="mt-4 space-y-4">
                @csrf
                @method('PATCH')
                <div>
                    <label for="status" class="block text-sm font-medium text-brand-navy">Status</label>
                    <select
                        id="status"
                        name="status"
                        class="mt-1 w-full rounded-lg border border-brand-navy/15 px-3 py-2 text-brand-navy shadow-sm focus:border-brand-turquoise focus:outline-none focus:ring-2 focus:ring-brand-turquoise/30"
                    >
                        @foreach ($statusLabels as $value => $label)
                            <option value="{{ $value }}" @selected(old('status', $lead->status) === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="admin_notes" class="block text-sm font-medium text-brand-navy">Internal notes</label>
                    <textarea
                        id="admin_notes"
                        name="admin_notes"
                        rows="6"
                        class="mt-1 w-full rounded-lg border border-brand-navy/15 px-3 py-2 text-brand-navy shadow-sm focus:border-brand-turquoise focus:outline-none focus:ring-2 focus:ring-brand-turquoise/30"
                        placeholder="Scheduled call, quote sent, customer preferences…"
                    >{{ old('admin_notes', $lead->admin_notes) }}</textarea>
                    @error('admin_notes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <button
                    type="submit"
                    class="w-full rounded-full bg-brand-fuchsia py-3 text-sm font-semibold text-white shadow-md transition hover:bg-brand-fuchsia-dark"
                >
                    Save changes
                </button>
            </form>
        </div>
    </div>
@endsection
