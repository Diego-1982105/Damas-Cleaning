@extends('layouts.admin')

@section('title', 'Clients')

@section('content')
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-heading text-2xl font-bold text-brand-navy">Clients</h1>
            <p class="mt-0.5 text-sm text-slate-400">Directory of billing contacts and properties.</p>
        </div>
        <a href="{{ route('admin.clientes.create') }}"
           class="inline-flex items-center gap-2 self-start rounded-xl bg-brand-fuchsia px-5 py-2.5 text-sm font-semibold text-white shadow-md shadow-brand-fuchsia/30 transition hover:bg-brand-fuchsia-dark active:scale-95 sm:self-auto">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            New Client
        </a>
    </div>

    {{-- Table (desktop) --}}
    <div class="mt-5 hidden overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm md:block">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100 text-sm">
                <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-400">
                    <tr>
                        <th class="px-5 py-3 text-left">Name</th>
                        <th class="px-5 py-3 text-left">Address</th>
                        <th class="px-5 py-3 text-left">Phone</th>
                        <th class="px-5 py-3 text-left">Email</th>
                        <th class="px-5 py-3 text-center">Invoices</th>
                        <th class="px-5 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($clients as $client)
                        <tr class="transition hover:bg-slate-50 {{ $client->active ? '' : 'opacity-50' }}">
                            <td class="px-5 py-3.5 font-medium text-brand-navy">
                                <div class="flex items-center gap-2">
                                    {{ $client->name }}
                                    @unless ($client->active)
                                        <span class="rounded-full bg-slate-100 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide text-slate-400">Inactive</span>
                                    @endunless
                                </div>
                            </td>
                            <td class="max-w-xs truncate px-5 py-3.5 text-slate-500" title="{{ $client->address }}">{{ $client->address ?: '—' }}</td>
                            <td class="whitespace-nowrap px-5 py-3.5 text-slate-500">{{ $client->phone ?: '—' }}</td>
                            <td class="px-5 py-3.5 text-slate-500">{{ $client->email ?: '—' }}</td>
                            <td class="whitespace-nowrap px-5 py-3.5 text-center text-slate-500">{{ $client->invoices_count }}</td>
                            <td class="whitespace-nowrap px-5 py-3.5 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('admin.clientes.edit', $client) }}"
                                       title="Edit"
                                       class="flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 hover:bg-brand-turquoise/10 hover:text-brand-turquoise">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 0 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z"/>
                                        </svg>
                                    </a>
                                    {{-- Toggle active --}}
                                    <form method="POST" action="{{ route('admin.clientes.toggle-active', $client) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        @if ($client->active)
                                            <button type="submit" title="Disable client"
                                                    class="flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 hover:bg-amber-50 hover:text-amber-500">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636"/>
                                                </svg>
                                            </button>
                                        @else
                                            <button type="submit" title="Enable client"
                                                    class="flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 hover:bg-emerald-50 hover:text-emerald-600">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                                </svg>
                                            </button>
                                        @endif
                                    </form>
                                    <form method="POST" action="{{ route('admin.clientes.destroy', $client) }}" class="inline" onsubmit="return confirm('Delete this client and all their invoices?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Delete"
                                                class="flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 hover:bg-red-50 hover:text-red-500">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center text-slate-400">No clients yet. <a href="{{ route('admin.clientes.create') }}" class="text-brand-turquoise hover:underline">Create one</a> to start invoicing.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($clients->hasPages())
            <div class="border-t border-slate-100 px-5 py-4">
                {{ $clients->links() }}
            </div>
        @endif
    </div>

    {{-- Cards (mobile) --}}
    <div class="mt-5 space-y-2 md:hidden">
        @forelse ($clients as $client)
            <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm {{ $client->active ? '' : 'opacity-60' }}">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center gap-2">
                            <p class="font-semibold text-brand-navy">{{ $client->name }}</p>
                            @unless ($client->active)
                                <span class="rounded-full bg-slate-100 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide text-slate-400">Inactive</span>
                            @endunless
                        </div>
                        @if ($client->phone)
                            <p class="mt-0.5 text-xs text-slate-400">{{ $client->phone }}</p>
                        @endif
                        @if ($client->email)
                            <p class="mt-0.5 truncate text-xs text-slate-400">{{ $client->email }}</p>
                        @endif
                    </div>
                    <span class="shrink-0 rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-semibold text-slate-500">{{ $client->invoices_count }} inv.</span>
                </div>
                <div class="mt-3 flex gap-2 border-t border-slate-100 pt-3">
                    <a href="{{ route('admin.clientes.edit', $client) }}"
                       class="flex flex-1 items-center justify-center gap-1.5 rounded-xl border border-slate-200 py-2 text-xs font-semibold text-brand-navy hover:bg-slate-50">
                        <svg class="h-3.5 w-3.5 text-brand-turquoise" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 0 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z"/>
                        </svg>
                        Edit
                    </a>
                    {{-- Toggle active --}}
                    <form method="POST" action="{{ route('admin.clientes.toggle-active', $client) }}" class="flex-1">
                        @csrf
                        @method('PATCH')
                        @if ($client->active)
                            <button type="submit" class="flex w-full items-center justify-center gap-1.5 rounded-xl border border-amber-100 bg-amber-50 py-2 text-xs font-semibold text-amber-600 hover:bg-amber-100">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636"/>
                                </svg>
                                Disable
                            </button>
                        @else
                            <button type="submit" class="flex w-full items-center justify-center gap-1.5 rounded-xl border border-emerald-100 bg-emerald-50 py-2 text-xs font-semibold text-emerald-600 hover:bg-emerald-100">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                                Enable
                            </button>
                        @endif
                    </form>
                    <form method="POST" action="{{ route('admin.clientes.destroy', $client) }}" class="flex-1" onsubmit="return confirm('Delete this client?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="flex w-full items-center justify-center gap-1.5 rounded-xl border border-red-100 bg-red-50 py-2 text-xs font-semibold text-red-600 hover:bg-red-100">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                            </svg>
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="rounded-2xl border border-slate-200 bg-white py-12 text-center text-slate-400">
                No clients yet.
            </div>
        @endforelse
        @if ($clients->hasPages())
            <div class="mt-4">{{ $clients->links() }}</div>
        @endif
    </div>
@endsection
