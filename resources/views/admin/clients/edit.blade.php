@extends('layouts.admin')

@section('title', 'Edit Client')

@section('content')
    <div class="mb-5 flex items-center gap-2">
        <a href="{{ route('admin.clientes.index') }}" class="text-sm text-slate-400 hover:text-brand-navy">Clients</a>
        <svg class="h-4 w-4 text-slate-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span class="max-w-[180px] truncate text-sm text-slate-500">{{ $client->name }}</span>
    </div>

    <div class="mx-auto max-w-xl rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        <h1 class="font-heading text-xl font-bold text-brand-navy">Edit Client</h1>
        <p class="mt-0.5 text-sm text-slate-400">{{ $client->name }}</p>

        <form method="POST" action="{{ route('admin.clientes.update', $client) }}" class="mt-6 space-y-5">
            @csrf
            @method('PUT')
            @include('admin.clients._form', ['client' => $client])
            <div class="flex flex-wrap gap-3 pt-2">
                <button type="submit"
                        class="rounded-xl bg-brand-fuchsia px-6 py-2.5 text-sm font-semibold text-white shadow-md shadow-brand-fuchsia/30 transition hover:bg-brand-fuchsia-dark active:scale-95">
                    Update Client
                </button>
                <a href="{{ route('admin.clientes.index') }}"
                   class="rounded-xl border border-slate-200 px-5 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection
