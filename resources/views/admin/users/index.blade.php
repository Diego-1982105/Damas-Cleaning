@extends('layouts.admin')

@section('title', 'Team')

@section('content')
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-heading text-2xl font-bold text-brand-navy">Team</h1>
            <p class="mt-0.5 text-sm text-slate-400">Admin accounts that can sign in to this panel.</p>
        </div>
        <a href="{{ route('admin.usuarios.create') }}"
           class="inline-flex items-center gap-2 self-start rounded-xl bg-brand-fuchsia px-5 py-2.5 text-sm font-semibold text-white shadow-md shadow-brand-fuchsia/30 transition hover:bg-brand-fuchsia-dark active:scale-95 sm:self-auto">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            New User
        </a>
    </div>

    {{-- Table (desktop) --}}
    <div class="mt-5 hidden overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm md:block">
        <table class="min-w-full divide-y divide-slate-100 text-sm">
            <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-400">
                <tr>
                    <th class="px-5 py-3 text-left">Name</th>
                    <th class="px-5 py-3 text-left">Email</th>
                    <th class="px-5 py-3 text-left">Role</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($users as $u)
                    <tr class="transition hover:bg-slate-50 {{ $u->active ? '' : 'opacity-50' }}">
                        <td class="px-5 py-3.5 font-medium text-brand-navy">
                            <div class="flex items-center gap-2">
                                {{ $u->name }}
                                @if ($u->is(auth()->user()))
                                    <span class="rounded-full bg-brand-navy/10 px-2 py-0.5 text-[10px] font-semibold text-brand-navy">you</span>
                                @endif
                                @unless ($u->active)
                                    <span class="rounded-full bg-slate-100 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide text-slate-400">Inactive</span>
                                @endunless
                            </div>
                        </td>
                        <td class="px-5 py-3.5 text-slate-500">{{ $u->email }}</td>
                        <td class="px-5 py-3.5">
                            <span class="inline-flex rounded-full bg-brand-turquoise/15 px-2.5 py-0.5 text-xs font-semibold text-brand-navy ring-1 ring-inset ring-brand-turquoise/20">
                                {{ $u->roleLabel() }}
                            </span>
                        </td>
                        <td class="whitespace-nowrap px-5 py-3.5 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('admin.usuarios.edit', $u) }}"
                                   title="Edit"
                                   class="flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 hover:bg-brand-turquoise/10 hover:text-brand-turquoise">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 0 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z"/>
                                    </svg>
                                </a>
                                @if (! $u->is(auth()->user()))
                                    {{-- Toggle active --}}
                                    <form method="POST" action="{{ route('admin.usuarios.toggle-active', $u) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        @if ($u->active)
                                            <button type="submit" title="Disable user"
                                                    class="flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 hover:bg-amber-50 hover:text-amber-500">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636"/>
                                                </svg>
                                            </button>
                                        @else
                                            <button type="submit" title="Enable user"
                                                    class="flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 hover:bg-emerald-50 hover:text-emerald-600">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                                </svg>
                                            </button>
                                        @endif
                                    </form>
                                    <form method="POST" action="{{ route('admin.usuarios.destroy', $u) }}" class="inline" onsubmit="return confirm('Delete this user account?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Delete"
                                                class="flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 hover:bg-red-50 hover:text-red-500">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-5 py-12 text-center text-slate-400">No users yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if ($users->hasPages())
            <div class="border-t border-slate-100 px-5 py-4">{{ $users->links() }}</div>
        @endif
    </div>

    {{-- Cards (mobile) --}}
    <div class="mt-5 space-y-2 md:hidden">
        @forelse ($users as $u)
            <div class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm {{ $u->active ? '' : 'opacity-60' }}">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-brand-navy text-sm font-bold text-white">
                    {{ strtoupper(substr($u->name, 0, 1)) }}
                </span>
                <div class="min-w-0 flex-1">
                    <div class="flex flex-wrap items-center gap-1.5">
                        <p class="truncate font-semibold text-brand-navy">{{ $u->name }}</p>
                        @if ($u->is(auth()->user()))
                            <span class="text-xs font-normal text-slate-400">(you)</span>
                        @endif
                        @unless ($u->active)
                            <span class="rounded-full bg-slate-100 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide text-slate-400">Inactive</span>
                        @endunless
                    </div>
                    <p class="truncate text-xs text-slate-400">{{ $u->email }}</p>
                    <span class="mt-1 inline-flex rounded-full bg-brand-turquoise/15 px-2 py-0.5 text-[10px] font-semibold text-brand-navy">{{ $u->roleLabel() }}</span>
                </div>
                <div class="flex shrink-0 items-center gap-1">
                    <a href="{{ route('admin.usuarios.edit', $u) }}" title="Edit"
                       class="flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 text-slate-400 hover:bg-brand-turquoise/10 hover:text-brand-turquoise">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 0 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z"/>
                        </svg>
                    </a>
                    @if (! $u->is(auth()->user()))
                        {{-- Toggle active --}}
                        <form method="POST" action="{{ route('admin.usuarios.toggle-active', $u) }}">
                            @csrf
                            @method('PATCH')
                            @if ($u->active)
                                <button type="submit" title="Disable"
                                        class="flex h-9 w-9 items-center justify-center rounded-xl border border-amber-100 bg-amber-50 text-amber-500 hover:bg-amber-100">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636"/>
                                    </svg>
                                </button>
                            @else
                                <button type="submit" title="Enable"
                                        class="flex h-9 w-9 items-center justify-center rounded-xl border border-emerald-100 bg-emerald-50 text-emerald-600 hover:bg-emerald-100">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                    </svg>
                                </button>
                            @endif
                        </form>
                        <form method="POST" action="{{ route('admin.usuarios.destroy', $u) }}" onsubmit="return confirm('Delete this user?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" title="Delete"
                                    class="flex h-9 w-9 items-center justify-center rounded-xl border border-red-100 bg-red-50 text-red-500 hover:bg-red-100">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                </svg>
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <div class="rounded-2xl border border-slate-200 bg-white py-12 text-center text-slate-400">No users yet.</div>
        @endforelse
        @if ($users->hasPages())
            <div class="mt-4">{{ $users->links() }}</div>
        @endif
    </div>
@endsection
