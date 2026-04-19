@extends('layouts.admin')

@section('title', 'New User')

@section('content')
    {{-- Breadcrumb --}}
    <div class="mb-5 flex items-center gap-2">
        <a href="{{ route('admin.usuarios.index') }}" class="text-sm text-slate-400 hover:text-brand-navy">Team</a>
        <svg class="h-4 w-4 text-slate-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span class="text-sm text-slate-500">New User</span>
    </div>

    <form method="POST" action="{{ route('admin.usuarios.store') }}">
        @csrf

        <div class="grid gap-6 lg:grid-cols-2 lg:items-start">

            {{-- ── Left column: Account fields ── --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                <div class="mb-6">
                    <h1 class="font-heading text-xl font-bold text-brand-navy">New User</h1>
                    <p class="mt-0.5 text-sm text-slate-400">They'll sign in using the admin login URL.</p>
                </div>

                <div class="space-y-5">
                    <div>
                        <label for="name" class="block text-xs font-semibold uppercase tracking-wide text-brand-navy">Full Name *</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                               class="mt-1.5 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-brand-navy placeholder-slate-400 shadow-sm transition focus:border-brand-turquoise focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-turquoise/25"
                               placeholder="Maria Garcia" />
                        @error('name')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-semibold uppercase tracking-wide text-brand-navy">Email *</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                               class="mt-1.5 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-brand-navy placeholder-slate-400 shadow-sm transition focus:border-brand-turquoise focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-turquoise/25"
                               placeholder="maria@damascleaning.com" />
                        @error('email')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label for="password" class="block text-xs font-semibold uppercase tracking-wide text-brand-navy">Password *</label>
                            <input type="password" id="password" name="password" required autocomplete="new-password"
                                   class="mt-1.5 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-brand-navy shadow-sm transition focus:border-brand-turquoise focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-turquoise/25"
                                   placeholder="••••••••" />
                            @error('password')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-xs font-semibold uppercase tracking-wide text-brand-navy">Confirm Password *</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password"
                                   class="mt-1.5 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-brand-navy shadow-sm transition focus:border-brand-turquoise focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-turquoise/25"
                                   placeholder="••••••••" />
                        </div>
                    </div>

                    <div>
                        <label for="role" class="block text-xs font-semibold uppercase tracking-wide text-brand-navy">Role *</label>
                        <select id="role" name="role" required
                                class="mt-1.5 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-brand-navy shadow-sm transition focus:border-brand-turquoise focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-turquoise/25">
                            @foreach ($roleLabels as $value => $label)
                                <option value="{{ $value }}" @selected(old('role', 'staff') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('role')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Action buttons --}}
                <div class="mt-8 flex flex-wrap gap-3 border-t border-slate-100 pt-6">
                    <button type="submit"
                            class="rounded-xl bg-brand-fuchsia px-6 py-2.5 text-sm font-semibold text-white shadow-md shadow-brand-fuchsia/30 transition hover:bg-brand-fuchsia-dark active:scale-95">
                        Create User
                    </button>
                    <a href="{{ route('admin.usuarios.index') }}"
                       class="rounded-xl border border-slate-200 px-5 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                        Cancel
                    </a>
                </div>
            </div>

            {{-- ── Right column: Permissions ── --}}
            <div class="lg:sticky lg:top-6">
                @include('admin.users._permissions')
            </div>

        </div>
    </form>
@endsection
