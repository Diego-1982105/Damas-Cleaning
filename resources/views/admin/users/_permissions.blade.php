{{--
  Permissions panel — right column.
  Requires $permissionLabels and optionally $user (for current values).
--}}
@php $currentRole = old('role', $user->role ?? 'staff'); @endphp

<div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

    {{-- Header --}}
    <div class="flex items-center gap-3 border-b border-slate-100 px-6 py-4">
        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-brand-turquoise/10">
            <svg class="h-4 w-4 text-brand-turquoise" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/>
            </svg>
        </span>
        <div>
            <p class="text-sm font-semibold text-brand-navy">Panel Permissions</p>
            <p class="text-xs text-slate-400">Active when role is <strong>Staff</strong></p>
        </div>
    </div>

    {{-- Owner banner --}}
    <div id="owner-permissions-note" class="{{ $currentRole === 'owner' ? '' : 'hidden' }} px-6 py-5">
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3.5">
            <div class="flex items-center gap-2">
                <svg class="h-4 w-4 shrink-0 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                <p class="text-sm font-semibold text-emerald-800">Full access — all permissions</p>
            </div>
            <p class="mt-1 text-xs text-emerald-700">Owners have unrestricted access to every section. Individual permissions don't apply.</p>
        </div>
    </div>

    {{-- Permissions list --}}
    <div id="permissions-panel" class="{{ $currentRole === 'owner' ? 'hidden' : '' }} px-6 pb-6 pt-4">
        <p class="mb-4 text-xs text-slate-500">
            Check each section this user can access. Unchecked sections are hidden from their sidebar and blocked at the route level.
        </p>

        <div class="space-y-2">
            @foreach ($permissionLabels as $key => $description)
                @php
                    [$sectionName, $sectionDesc] = array_pad(explode(' — ', $description, 2), 2, '');
                    $checked = old('permissions')
                        ? in_array($key, (array) old('permissions'))
                        : (isset($user) ? $user->hasPermission($key) : false);
                @endphp
                <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-slate-200 bg-slate-50/60 p-3.5 transition hover:border-brand-turquoise/40 hover:bg-brand-turquoise/5 has-[:checked]:border-brand-turquoise/30 has-[:checked]:bg-brand-turquoise/5">
                    <input
                        type="checkbox"
                        name="permissions[]"
                        value="{{ $key }}"
                        @checked($checked)
                        class="mt-0.5 h-4 w-4 shrink-0 rounded border-slate-300 text-brand-turquoise focus:ring-brand-turquoise"
                    />
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-brand-navy">{{ $sectionName }}</p>
                        @if ($sectionDesc)
                            <p class="text-xs text-slate-400">{{ $sectionDesc }}</p>
                        @endif
                    </div>
                </label>
            @endforeach
        </div>

        <div class="mt-3 flex gap-3 border-t border-slate-100 pt-3">
            <button type="button" id="perm-select-all"
                    class="text-xs font-medium text-brand-turquoise hover:underline">
                Select all
            </button>
            <span class="text-xs text-slate-300">·</span>
            <button type="button" id="perm-deselect-all"
                    class="text-xs font-medium text-slate-400 hover:underline hover:text-brand-navy">
                Deselect all
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
(function () {
    var roleSelect  = document.getElementById('role');
    var panel       = document.getElementById('permissions-panel');
    var ownerNote   = document.getElementById('owner-permissions-note');
    var checkboxes  = panel ? panel.querySelectorAll('input[type=checkbox]') : [];
    var selectAll   = document.getElementById('perm-select-all');
    var deselectAll = document.getElementById('perm-deselect-all');

    function syncVisibility() {
        if (!roleSelect || !panel) return;
        var isOwner = roleSelect.value === 'owner';
        panel.classList.toggle('hidden', isOwner);
        if (ownerNote) ownerNote.classList.toggle('hidden', !isOwner);
    }

    if (roleSelect) roleSelect.addEventListener('change', syncVisibility);
    syncVisibility();

    if (selectAll) {
        selectAll.addEventListener('click', function () {
            checkboxes.forEach(function (cb) { cb.checked = true; });
        });
    }
    if (deselectAll) {
        deselectAll.addEventListener('click', function () {
            checkboxes.forEach(function (cb) { cb.checked = false; });
        });
    }
})();
</script>
@endpush
