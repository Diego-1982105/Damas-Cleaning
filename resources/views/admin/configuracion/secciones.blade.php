@extends('layouts.admin')

@section('title', 'Secciones del Sitio')

@section('content')
    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <h1 class="font-heading text-2xl font-bold text-brand-navy">Secciones del Sitio</h1>
            <p class="mt-0.5 text-sm text-slate-400">Controla qué secciones son visibles en el sitio público. Los cambios se aplican de inmediato.</p>
        </div>
        <a href="{{ url('/') }}" target="_blank" rel="noopener"
           class="inline-flex items-center gap-2 self-start rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-600 shadow-sm transition hover:bg-slate-50 sm:self-auto">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
            </svg>
            Ver sitio público
        </a>
    </div>

    {{-- Stats bar --}}
    <div class="mt-5 grid grid-cols-2 gap-3 sm:grid-cols-4">
        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Total</p>
            <p class="mt-1 text-2xl font-bold text-brand-navy">{{ $sections->count() }}</p>
        </div>
        <div class="rounded-2xl border border-emerald-100 bg-emerald-50 p-4">
            <p class="text-xs font-semibold uppercase tracking-wide text-emerald-600">Visibles</p>
            <p class="mt-1 text-2xl font-bold text-emerald-700" id="count-enabled">{{ $sections->where('enabled', true)->count() }}</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Ocultas</p>
            <p class="mt-1 text-2xl font-bold text-brand-navy" id="count-disabled">{{ $sections->where('enabled', false)->count() }}</p>
        </div>
        <div class="rounded-2xl border border-blue-100 bg-blue-50 p-4">
            <p class="text-xs font-semibold uppercase tracking-wide text-blue-600">Sitio activo</p>
            <p class="mt-1 text-sm font-semibold text-blue-700">En línea</p>
        </div>
    </div>

    {{-- Section cards --}}
    <div class="mt-5 space-y-2">
        @foreach ($sections as $section)
            @php
                $icons = [
                    'hero'         => '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>',
                    'services'     => '<path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z"/>',
                    'before_after' => '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/>',
                    'about'        => '<path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z"/>',
                    'why_us'       => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z"/>',
                    'process'      => '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z"/>',
                    'testimonials' => '<path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z"/>',
                    'contact'      => '<path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"/>',
                ];
                $icon = $icons[$section->key] ?? '<path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z"/>';
            @endphp

            <div
                id="section-row-{{ $section->key }}"
                data-key="{{ $section->key }}"
                data-update-url="{{ route('admin.configuracion.secciones.update', $section) }}"
                data-csrf="{{ csrf_token() }}"
                class="flex items-center gap-4 rounded-2xl border bg-white p-5 shadow-sm transition
                       {{ $section->enabled ? 'border-slate-200' : 'border-slate-200 opacity-60' }}"
            >
                {{-- Icon --}}
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl
                            {{ $section->enabled ? 'bg-brand-turquoise/10' : 'bg-slate-100' }}">
                    <svg class="h-5 w-5 {{ $section->enabled ? 'text-brand-turquoise' : 'text-slate-400' }}"
                         fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24" aria-hidden="true">
                        {!! $icon !!}
                    </svg>
                </div>

                {{-- Info --}}
                <div class="min-w-0 flex-1">
                    <div class="flex flex-wrap items-center gap-2">
                        <p class="font-semibold text-brand-navy section-label">{{ $section->label }}</p>
                        <span class="section-badge rounded-full px-2 py-0.5 text-xs font-semibold
                                     {{ $section->enabled ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                            {{ $section->enabled ? 'Visible' : 'Oculta' }}
                        </span>
                    </div>
                    <p class="mt-0.5 text-sm text-slate-400">{{ $section->description }}</p>
                </div>

                {{-- Toggle --}}
                <button
                    type="button"
                    role="switch"
                    aria-checked="{{ $section->enabled ? 'true' : 'false' }}"
                    aria-label="Toggle {{ $section->label }}"
                    class="section-toggle relative inline-flex h-6 w-11 shrink-0 cursor-pointer items-center rounded-full border-2 border-transparent transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-brand-turquoise focus:ring-offset-2
                           {{ $section->enabled ? 'bg-brand-turquoise' : 'bg-slate-200' }}"
                >
                    <span class="pointer-events-none inline-block h-4 w-4 translate-x-0 rounded-full bg-white shadow-md transition-transform duration-200
                                 {{ $section->enabled ? 'translate-x-5' : 'translate-x-0.5' }}">
                    </span>
                </button>
            </div>
        @endforeach
    </div>

    <p class="mt-4 text-xs text-slate-400">
        Los cambios son inmediatos. Los visitantes del sitio ven los cambios en la próxima carga de página.
    </p>
@endsection

@push('scripts')
<script>
(function () {
    var csrfToken = document.querySelector('meta[name=csrf-token]').content;

    document.querySelectorAll('[data-update-url]').forEach(function (row) {
        var toggle    = row.querySelector('.section-toggle');
        var badge     = row.querySelector('.section-badge');
        var icon      = row.querySelector('svg');
        var iconWrap  = icon ? icon.parentElement : null;
        var countOn   = document.getElementById('count-enabled');
        var countOff  = document.getElementById('count-disabled');

        if (!toggle) return;

        toggle.addEventListener('click', function () {
            var url     = row.dataset.updateUrl;
            var enabled = toggle.getAttribute('aria-checked') === 'true';
            var newVal  = !enabled;

            // Optimistic UI update
            applyState(newVal);

            fetch(url, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
            })
            .then(function (r) {
                if (!r.ok) {
                    applyState(enabled); // revert on error
                }
                return r.json();
            })
            .then(function (data) {
                // Sync counters
                var on  = parseInt(countOn.textContent, 10)  + (data.enabled ? 1 : -1);
                var off = parseInt(countOff.textContent, 10) + (data.enabled ? -1 : 1);
                countOn.textContent  = Math.max(0, on);
                countOff.textContent = Math.max(0, off);
            })
            .catch(function () { applyState(enabled); });
        });

        function applyState(isEnabled) {
            toggle.setAttribute('aria-checked', isEnabled ? 'true' : 'false');
            toggle.classList.toggle('bg-brand-turquoise', isEnabled);
            toggle.classList.toggle('bg-slate-200', !isEnabled);

            var thumb = toggle.querySelector('span');
            if (thumb) {
                thumb.classList.toggle('translate-x-5',   isEnabled);
                thumb.classList.toggle('translate-x-0.5', !isEnabled);
            }

            if (badge) {
                badge.textContent = isEnabled ? 'Visible' : 'Oculta';
                badge.className = badge.className
                    .replace(/bg-\S+ text-\S+/g, '')
                    .trim();
                badge.classList.add(
                    ...(isEnabled
                        ? ['bg-emerald-100', 'text-emerald-700']
                        : ['bg-slate-100',   'text-slate-500'])
                );
            }

            if (iconWrap) {
                iconWrap.classList.toggle('bg-brand-turquoise/10', isEnabled);
                iconWrap.classList.toggle('bg-slate-100', !isEnabled);
            }
            if (icon) {
                icon.classList.toggle('text-brand-turquoise', isEnabled);
                icon.classList.toggle('text-slate-400', !isEnabled);
            }

            row.classList.toggle('opacity-60', !isEnabled);
        }
    });
})();
</script>
@endpush
