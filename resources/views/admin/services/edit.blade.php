@extends('layouts.admin')

@section('title', 'Edit Service')

@section('content')
    <div class="mb-5 flex items-center gap-2">
        <a href="{{ route('admin.configuracion.servicios.index') }}" class="text-sm text-slate-400 hover:text-brand-navy">Services</a>
        <svg class="h-4 w-4 text-slate-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span class="max-w-[160px] truncate text-sm text-slate-500">{{ $service->name }}</span>
    </div>

    <div class="mx-auto max-w-lg rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        <h1 class="font-heading text-xl font-bold text-brand-navy">Edit Service</h1>
        <p class="mt-0.5 text-sm text-slate-400">{{ $service->name }}</p>

        <form method="POST" action="{{ route('admin.configuracion.servicios.update', $service) }}" class="mt-6 space-y-5">
            @csrf
            @method('PUT')
            <div>
                <label for="name" class="block text-xs font-semibold uppercase tracking-wide text-brand-navy">Service Name *</label>
                <input type="text" id="name" name="name" value="{{ old('name', $service->name) }}" required autofocus
                       class="mt-1.5 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-brand-navy placeholder-slate-400 shadow-sm transition focus:border-brand-turquoise focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-turquoise/25" />
                @error('name')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label for="price" class="block text-xs font-semibold uppercase tracking-wide text-brand-navy">Price *</label>
                    <div class="relative mt-1.5">
                        <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-sm text-slate-400">$</span>
                        <input type="number" id="price" name="price" value="{{ old('price', $service->price) }}" step="0.01" min="0" required
                               class="w-full rounded-xl border border-slate-200 bg-slate-50 py-2.5 pl-7 pr-4 text-sm text-brand-navy shadow-sm transition focus:border-brand-turquoise focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-turquoise/25" />
                    </div>
                    @error('price')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="sort_order" class="block text-xs font-semibold uppercase tracking-wide text-brand-navy">Sort Order</label>
                    <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $service->sort_order) }}" min="0" max="65535"
                           class="mt-1.5 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-brand-navy shadow-sm transition focus:border-brand-turquoise focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-turquoise/25" />
                    @error('sort_order')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="flex flex-wrap gap-3 pt-2">
                <button type="submit"
                        class="rounded-xl bg-brand-fuchsia px-6 py-2.5 text-sm font-semibold text-white shadow-md shadow-brand-fuchsia/30 transition hover:bg-brand-fuchsia-dark active:scale-95">
                    Update Service
                </button>
                <a href="{{ route('admin.configuracion.servicios.index') }}"
                   class="rounded-xl border border-slate-200 px-5 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection
