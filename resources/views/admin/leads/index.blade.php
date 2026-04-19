@extends('layouts.admin')

@section('title', 'Leads')

@section('content')
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-heading text-2xl font-bold text-brand-navy">Leads</h1>
            <p class="mt-0.5 text-sm text-slate-400">Requests submitted from the website contact form.</p>
        </div>
        <form method="GET" action="{{ route('admin.leads.index') }}" class="flex items-center gap-2">
            <select name="status"
                    onchange="this.form.submit()"
                    class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-brand-navy shadow-sm focus:border-brand-turquoise focus:outline-none focus:ring-2 focus:ring-brand-turquoise/25">
                <option value="">All statuses</option>
                @foreach ($statusLabels as $value => $label)
                    <option value="{{ $value }}" @selected($statusFilter === $value)>{{ $label }}</option>
                @endforeach
            </select>
            @if ($statusFilter)
                <a href="{{ route('admin.leads.index') }}" class="text-sm font-medium text-slate-400 hover:text-brand-navy">Clear</a>
            @endif
        </form>
    </div>

    {{-- Table (desktop) --}}
    <div class="mt-5 hidden overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm md:block">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100 text-sm">
                <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-400">
                    <tr>
                        <th class="px-5 py-3 text-left">#</th>
                        <th class="px-5 py-3 text-left">Name</th>
                        <th class="px-5 py-3 text-left">Email</th>
                        <th class="px-5 py-3 text-left">Phone</th>
                        <th class="px-5 py-3 text-left">Service</th>
                        <th class="px-5 py-3 text-left">Status</th>
                        <th class="px-5 py-3 text-left">Date</th>
                        <th class="px-5 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($leads as $lead)
                        @php
                            $statusColors = match($lead->status) {
                                'new'         => 'bg-sky-100 text-sky-700 ring-sky-200',
                                'contacted'   => 'bg-amber-100 text-amber-700 ring-amber-200',
                                'converted'   => 'bg-emerald-100 text-emerald-700 ring-emerald-200',
                                'closed'      => 'bg-slate-100 text-slate-500 ring-slate-200',
                                default       => 'bg-slate-100 text-slate-500 ring-slate-200',
                            };
                        @endphp
                        <tr class="transition hover:bg-slate-50">
                            <td class="whitespace-nowrap px-5 py-3.5 text-slate-400">{{ $lead->id }}</td>
                            <td class="px-5 py-3.5 font-medium text-brand-navy">{{ $lead->name }}</td>
                            <td class="px-5 py-3.5 text-slate-500">{{ $lead->email }}</td>
                            <td class="whitespace-nowrap px-5 py-3.5 text-slate-500">{{ $lead->phone ?? '—' }}</td>
                            <td class="max-w-[140px] truncate px-5 py-3.5 text-slate-500" title="{{ $lead->service_type }}">{{ $lead->service_type ?: '—' }}</td>
                            <td class="whitespace-nowrap px-5 py-3.5">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold ring-1 ring-inset {{ $statusColors }}">
                                    {{ $lead->statusLabel() }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-5 py-3.5 text-slate-400">{{ $lead->created_at->timezone(config('app.timezone'))->format('M j, Y g:i A') }}</td>
                            <td class="whitespace-nowrap px-5 py-3.5 text-right">
                                <a href="{{ route('admin.leads.show', $lead) }}"
                                   title="View"
                                   class="flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 hover:bg-brand-turquoise/10 hover:text-brand-turquoise">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-5 py-12 text-center text-slate-400">No leads yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($leads->hasPages())
            <div class="border-t border-slate-100 px-5 py-4">
                {{ $leads->links() }}
            </div>
        @endif
    </div>

    {{-- Cards (mobile) --}}
    <div class="mt-5 space-y-2 md:hidden">
        @forelse ($leads as $lead)
            @php
                $statusColors = match($lead->status) {
                    'new'       => 'bg-sky-100 text-sky-700 ring-sky-200',
                    'contacted' => 'bg-amber-100 text-amber-700 ring-amber-200',
                    'converted' => 'bg-emerald-100 text-emerald-700 ring-emerald-200',
                    'closed'    => 'bg-slate-100 text-slate-500 ring-slate-200',
                    default     => 'bg-slate-100 text-slate-500 ring-slate-200',
                };
            @endphp
            <a href="{{ route('admin.leads.show', $lead) }}"
               class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:border-brand-turquoise/40 hover:shadow-md">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-sm font-bold text-slate-500">
                    {{ strtoupper(substr($lead->name, 0, 1)) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="truncate font-semibold text-brand-navy">{{ $lead->name }}</p>
                    <p class="truncate text-xs text-slate-400">{{ $lead->email }}</p>
                </div>
                <div class="shrink-0 text-right">
                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold ring-1 ring-inset {{ $statusColors }}">
                        {{ $lead->statusLabel() }}
                    </span>
                    <p class="mt-1 text-[10px] text-slate-400">{{ $lead->created_at->format('M j, Y') }}</p>
                </div>
            </a>
        @empty
            <div class="rounded-2xl border border-slate-200 bg-white py-12 text-center text-slate-400">
                No leads yet.
            </div>
        @endforelse
        @if ($leads->hasPages())
            <div class="mt-4">{{ $leads->links() }}</div>
        @endif
    </div>
@endsection
