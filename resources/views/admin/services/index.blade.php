@extends('layouts.admin')

@section('title', 'Services & Pricing')

@section('content')
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-heading text-2xl font-bold text-brand-navy">Services &amp; Pricing</h1>
            <p class="mt-0.5 text-sm text-slate-400">Catalog of services with reference prices for invoices.</p>
        </div>
        <a href="{{ route('admin.configuracion.servicios.create') }}"
           class="inline-flex items-center gap-2 self-start rounded-xl bg-brand-fuchsia px-5 py-2.5 text-sm font-semibold text-white shadow-md shadow-brand-fuchsia/30 transition hover:bg-brand-fuchsia-dark active:scale-95 sm:self-auto">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            New Service
        </a>
    </div>

    {{-- Table (desktop) --}}
    <div class="mt-5 hidden overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm md:block">
        <table class="min-w-full divide-y divide-slate-100 text-sm">
            <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-400">
                <tr>
                    <th class="px-5 py-3 text-left">Order</th>
                    <th class="px-5 py-3 text-left">Service</th>
                    <th class="px-5 py-3 text-right">Price</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($services as $service)
                    <tr class="transition hover:bg-slate-50">
                        <td class="whitespace-nowrap px-5 py-3.5 text-slate-400">{{ $service->sort_order }}</td>
                        <td class="px-5 py-3.5 font-medium text-brand-navy">{{ $service->name }}</td>
                        <td class="whitespace-nowrap px-5 py-3.5 text-right font-semibold text-brand-navy">${{ number_format((float) $service->price, 2) }}</td>
                        <td class="whitespace-nowrap px-5 py-3.5 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('admin.configuracion.servicios.edit', $service) }}"
                                   title="Edit"
                                   class="flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 hover:bg-brand-turquoise/10 hover:text-brand-turquoise">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 0 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z"/>
                                    </svg>
                                </a>
                                <form method="POST" action="{{ route('admin.configuracion.servicios.destroy', $service) }}" class="inline" onsubmit="return confirm('Remove this service?');">
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
                        <td colspan="4" class="px-5 py-12 text-center text-slate-400">No services yet. Add the first one with a price.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if ($services->hasPages())
            <div class="border-t border-slate-100 px-5 py-4">{{ $services->links() }}</div>
        @endif
    </div>

    {{-- Cards (mobile) --}}
    <div class="mt-5 space-y-2 md:hidden">
        @forelse ($services as $service)
            <div class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-xs font-bold text-slate-400">{{ $service->sort_order }}</span>
                <div class="min-w-0 flex-1">
                    <p class="font-semibold text-brand-navy">{{ $service->name }}</p>
                    <p class="text-sm font-bold text-brand-navy">${{ number_format((float) $service->price, 2) }}</p>
                </div>
                <div class="flex shrink-0 gap-1">
                    <a href="{{ route('admin.configuracion.servicios.edit', $service) }}"
                       title="Edit"
                       class="flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 text-slate-400 hover:bg-brand-turquoise/10 hover:text-brand-turquoise">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 0 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z"/>
                        </svg>
                    </a>
                    <form method="POST" action="{{ route('admin.configuracion.servicios.destroy', $service) }}" onsubmit="return confirm('Remove this service?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" title="Delete"
                                class="flex h-9 w-9 items-center justify-center rounded-xl border border-red-100 bg-red-50 text-red-500 hover:bg-red-100">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="rounded-2xl border border-slate-200 bg-white py-12 text-center text-slate-400">No services yet.</div>
        @endforelse
        @if ($services->hasPages())
            <div class="mt-4">{{ $services->links() }}</div>
        @endif
    </div>
@endsection
