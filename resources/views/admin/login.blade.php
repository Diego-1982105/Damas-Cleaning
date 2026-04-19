@extends('layouts.admin')

@section('title', 'Sign in')

@section('content')
    <div class="w-full max-w-sm">
        {{-- Logo + brand --}}
        <div class="mb-8 flex flex-col items-center gap-3">
            <img
                src="{{ config('branding.logo_href') }}"
                alt="{{ config('app.name') }}"
                class="h-20 w-20 rounded-2xl object-cover shadow-lg ring-4 ring-white"
            />
            <div class="text-center">
                <h1 class="font-heading text-2xl font-bold text-brand-navy">Welcome back</h1>
                <p class="mt-1 text-sm text-slate-500">Sign in to your admin panel</p>
            </div>
        </div>

        {{-- Card --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-7 shadow-lg shadow-slate-200/60">
            <form method="POST" action="{{ route('admin.login.store') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-semibold uppercase tracking-wide text-brand-navy">Email</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="username"
                        class="mt-1.5 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-brand-navy placeholder-slate-400 shadow-sm transition focus:border-brand-turquoise focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-turquoise/25"
                        placeholder="you@damascleaning.com"
                    />
                    @error('email')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-xs font-semibold uppercase tracking-wide text-brand-navy">Password</label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        class="mt-1.5 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-brand-navy placeholder-slate-400 shadow-sm transition focus:border-brand-turquoise focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-turquoise/25"
                        placeholder="••••••••"
                    />
                </div>

                <label class="flex cursor-pointer select-none items-center gap-2.5 text-sm text-slate-600">
                    <input
                        type="checkbox"
                        name="remember"
                        value="1"
                        class="h-4 w-4 rounded border-slate-300 text-brand-turquoise focus:ring-brand-turquoise"
                    />
                    Remember me on this device
                </label>

                <button
                    type="submit"
                    class="flex w-full items-center justify-center gap-2 rounded-xl bg-brand-navy py-3 text-sm font-semibold text-white shadow-md shadow-brand-navy/30 transition hover:bg-brand-navy/90 focus:outline-none focus:ring-2 focus:ring-brand-navy focus:ring-offset-2 active:scale-[.98]"
                >
                    Sign in
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                </button>
            </form>
        </div>

        <p class="mt-6 text-center text-xs text-slate-400">
            <a href="{{ url('/') }}" class="font-medium text-brand-turquoise hover:underline">← Back to public site</a>
        </p>
    </div>

    {{-- Easter egg: rooster, schnauzer & dog --}}
    <div aria-hidden="true" class="pointer-events-none fixed bottom-0 left-0 right-0 flex justify-between px-4 sm:px-10 select-none z-0">

        {{-- Rooster (left) --}}
        <div class="login-critter translate-y-3 transition-transform duration-500 ease-out hover:translate-y-0"
             style="pointer-events: auto; cursor: default;"
             title="¡Quiquiriquí! 🐓">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 96" class="h-20 w-20 sm:h-24 sm:w-24 drop-shadow-md" fill="none">
                {{-- Body --}}
                <ellipse cx="38" cy="66" rx="18" ry="20" fill="#f97316" opacity=".9"/>
                {{-- Wing --}}
                <ellipse cx="30" cy="68" rx="10" ry="14" fill="#ea580c" opacity=".7" transform="rotate(-15 30 68)"/>
                {{-- Tail feathers --}}
                <path d="M54 58 Q68 44 72 32 Q60 48 56 58Z" fill="#dc2626" opacity=".8"/>
                <path d="M54 62 Q70 52 76 42 Q62 54 56 62Z" fill="#b91c1c" opacity=".7"/>
                <path d="M54 66 Q68 62 74 54 Q62 60 56 66Z" fill="#7c3aed" opacity=".6"/>
                {{-- Neck --}}
                <ellipse cx="38" cy="48" rx="9" ry="11" fill="#f97316"/>
                {{-- Head --}}
                <circle cx="37" cy="37" r="11" fill="#f97316"/>
                {{-- Comb --}}
                <path d="M32 27 Q33 20 35 18 Q34 23 37 21 Q36 26 39 24 Q38 28 41 26 Q39 30 37 28Z" fill="#dc2626"/>
                {{-- Wattle --}}
                <ellipse cx="35" cy="44" rx="3.5" ry="5" fill="#dc2626"/>
                {{-- Beak --}}
                <path d="M46 37 L52 35 L46 39Z" fill="#fbbf24"/>
                {{-- Eye --}}
                <circle cx="40" cy="34" r="2.5" fill="white"/>
                <circle cx="40.8" cy="33.8" r="1.2" fill="#1e293b"/>
                {{-- Feet --}}
                <line x1="34" y1="84" x2="30" y2="94" stroke="#f97316" stroke-width="2" stroke-linecap="round"/>
                <line x1="28" y1="94" x2="26" y2="94" stroke="#f97316" stroke-width="2" stroke-linecap="round"/>
                <line x1="30" y1="94" x2="32" y2="96" stroke="#f97316" stroke-width="2" stroke-linecap="round"/>
                <line x1="42" y1="84" x2="46" y2="94" stroke="#f97316" stroke-width="2" stroke-linecap="round"/>
                <line x1="48" y1="94" x2="50" y2="94" stroke="#f97316" stroke-width="2" stroke-linecap="round"/>
                <line x1="46" y1="94" x2="44" y2="96" stroke="#f97316" stroke-width="2" stroke-linecap="round"/>
            </svg>
        </div>

        {{-- Schnauzer (center) --}}
        <div class="login-critter translate-y-3 transition-transform duration-500 ease-out hover:translate-y-0"
             style="pointer-events: auto; cursor: default;"
             title="¡Woof! Soy un Schnauzer 🧔">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 96" class="h-20 w-20 sm:h-24 sm:w-24 drop-shadow-md" fill="none">
                {{-- Body --}}
                <ellipse cx="40" cy="68" rx="19" ry="17" fill="#6b7280"/>
                {{-- Belly lighter patch --}}
                <ellipse cx="40" cy="72" rx="11" ry="9" fill="#9ca3af" opacity=".6"/>
                {{-- Tail (short, docked schnauzer style, upright) --}}
                <rect x="57" y="52" width="5" height="10" rx="2.5" fill="#4b5563" transform="rotate(20 57 52)"/>
                {{-- Front legs --}}
                <rect x="27" y="81" width="8" height="14" rx="4" fill="#4b5563"/>
                <rect x="45" y="81" width="8" height="14" rx="4" fill="#4b5563"/>
                {{-- Paw highlights --}}
                <ellipse cx="31" cy="94" rx="4" ry="2" fill="#9ca3af" opacity=".5"/>
                <ellipse cx="49" cy="94" rx="4" ry="2" fill="#9ca3af" opacity=".5"/>
                {{-- Neck --}}
                <ellipse cx="40" cy="52" rx="10" ry="9" fill="#6b7280"/>
                {{-- Head --}}
                <rect x="26" y="28" width="28" height="26" rx="8" fill="#6b7280"/>
                {{-- Left ear (pointy, upright) --}}
                <path d="M28 30 L22 14 L32 24Z" fill="#374151"/>
                {{-- Right ear (pointy, upright) --}}
                <path d="M52 30 L58 14 L48 24Z" fill="#374151"/>
                {{-- Forehead fur texture --}}
                <path d="M30 30 Q40 26 50 30" stroke="#9ca3af" stroke-width="1.5" fill="none" stroke-linecap="round"/>
                {{-- Muzzle box (rectangular — schnauzer trademark) --}}
                <rect x="28" y="44" width="24" height="16" rx="5" fill="#9ca3af"/>
                {{-- Beard! (the schnauzer's signature) --}}
                <ellipse cx="40" cy="62" rx="10" ry="7" fill="#e5e7eb"/>
                <path d="M32 58 Q40 66 48 58" fill="#e5e7eb"/>
                {{-- Moustache wisps --}}
                <path d="M28 52 Q33 50 36 53" stroke="#d1d5db" stroke-width="2" stroke-linecap="round" fill="none"/>
                <path d="M52 52 Q47 50 44 53" stroke="#d1d5db" stroke-width="2" stroke-linecap="round" fill="none"/>
                {{-- Nose --}}
                <rect x="35" y="44" width="10" height="6" rx="3" fill="#1e293b"/>
                {{-- Nostrils --}}
                <circle cx="37.5" cy="47" r="1" fill="#374151"/>
                <circle cx="42.5" cy="47" r="1" fill="#374151"/>
                {{-- Eyes --}}
                <circle cx="33" cy="38" r="3.5" fill="white"/>
                <circle cx="33.8" cy="37.5" r="1.8" fill="#1e293b"/>
                <circle cx="47" cy="38" r="3.5" fill="white"/>
                <circle cx="47.8" cy="37.5" r="1.8" fill="#1e293b"/>
                {{-- Eye shine --}}
                <circle cx="35" cy="36.5" r="0.8" fill="white"/>
                <circle cx="49" cy="36.5" r="0.8" fill="white"/>
                {{-- EYEBROWS — the schnauzer's most iconic feature --}}
                <path d="M28 33 Q33 29 37 32" stroke="#e5e7eb" stroke-width="3" stroke-linecap="round" fill="none"/>
                <path d="M43 32 Q47 29 52 33" stroke="#e5e7eb" stroke-width="3" stroke-linecap="round" fill="none"/>
            </svg>
        </div>

        {{-- Dog (right) --}}
        <div class="login-critter translate-y-3 transition-transform duration-500 ease-out hover:translate-y-0"
             style="pointer-events: auto; cursor: default;"
             title="¡Guau! 🐶">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 96" class="h-20 w-20 sm:h-24 sm:w-24 drop-shadow-md" fill="none">
                {{-- Body --}}
                <ellipse cx="40" cy="68" rx="20" ry="18" fill="#d97706" opacity=".9"/>
                {{-- Tail --}}
                <path d="M58 60 Q72 50 74 38 Q66 52 58 64Z" fill="#b45309" opacity=".8"/>
                {{-- Front legs --}}
                <rect x="28" y="82" width="8" height="13" rx="4" fill="#b45309"/>
                <rect x="44" y="82" width="8" height="13" rx="4" fill="#b45309"/>
                {{-- Belly patch --}}
                <ellipse cx="40" cy="72" rx="12" ry="10" fill="#fef3c7" opacity=".7"/>
                {{-- Neck --}}
                <ellipse cx="40" cy="52" rx="10" ry="10" fill="#d97706"/>
                {{-- Head --}}
                <circle cx="40" cy="40" r="14" fill="#d97706"/>
                {{-- Left ear --}}
                <ellipse cx="28" cy="34" rx="6" ry="10" fill="#b45309" transform="rotate(-15 28 34)"/>
                {{-- Right ear --}}
                <ellipse cx="52" cy="34" rx="6" ry="10" fill="#b45309" transform="rotate(15 52 34)"/>
                {{-- Muzzle --}}
                <ellipse cx="40" cy="47" rx="9" ry="7" fill="#fef3c7"/>
                {{-- Nose --}}
                <ellipse cx="40" cy="43" rx="4" ry="2.5" fill="#1e293b"/>
                {{-- Nostrils --}}
                <circle cx="38.2" cy="43.5" r="0.8" fill="#374151"/>
                <circle cx="41.8" cy="43.5" r="0.8" fill="#374151"/>
                {{-- Mouth --}}
                <path d="M36 48 Q40 52 44 48" stroke="#92400e" stroke-width="1.5" stroke-linecap="round" fill="none"/>
                {{-- Eyes --}}
                <circle cx="34" cy="37" r="3" fill="white"/>
                <circle cx="34.8" cy="36.5" r="1.6" fill="#1e293b"/>
                <circle cx="46" cy="37" r="3" fill="white"/>
                <circle cx="46.8" cy="36.5" r="1.6" fill="#1e293b"/>
                {{-- Eye shine --}}
                <circle cx="35.6" cy="35.8" r="0.7" fill="white"/>
                <circle cx="47.6" cy="35.8" r="0.7" fill="white"/>
            </svg>
        </div>
    </div>

    <style>
        .login-critter { opacity: 0.55; }
        .login-critter:hover { opacity: 1; }
    </style>
@endsection
