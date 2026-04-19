@php $client = $client ?? null; @endphp

<div>
    <label for="name" class="block text-xs font-semibold uppercase tracking-wide text-brand-navy">Name *</label>
    <input
        type="text" id="name" name="name"
        value="{{ old('name', $client?->name) }}"
        required autofocus
        class="mt-1.5 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-brand-navy placeholder-slate-400 shadow-sm transition focus:border-brand-turquoise focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-turquoise/25"
        placeholder="Jane Smith"
    />
    @error('name')
        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="address" class="block text-xs font-semibold uppercase tracking-wide text-brand-navy">Address</label>
    <textarea
        id="address" name="address" rows="3"
        class="mt-1.5 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-brand-navy placeholder-slate-400 shadow-sm transition focus:border-brand-turquoise focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-turquoise/25"
        placeholder="123 Main St, Miami FL 33101"
    >{{ old('address', $client?->address) }}</textarea>
    @error('address')
        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
    @enderror
</div>

<div class="grid gap-4 sm:grid-cols-2">
    <div>
        <label for="phone" class="block text-xs font-semibold uppercase tracking-wide text-brand-navy">Phone</label>
        <input
            type="text" id="phone" name="phone"
            value="{{ old('phone', $client?->phone) }}"
            class="mt-1.5 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-brand-navy placeholder-slate-400 shadow-sm transition focus:border-brand-turquoise focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-turquoise/25"
            placeholder="+1 (305) 555-0100"
        />
        @error('phone')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label for="email" class="block text-xs font-semibold uppercase tracking-wide text-brand-navy">Email</label>
        <input
            type="email" id="email" name="email"
            value="{{ old('email', $client?->email) }}"
            class="mt-1.5 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-brand-navy placeholder-slate-400 shadow-sm transition focus:border-brand-turquoise focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-turquoise/25"
            placeholder="jane@example.com"
        />
        @error('email')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>
