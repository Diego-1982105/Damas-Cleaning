<script setup>
import { motion } from 'motion-v';
import { fadeUp, scaleIn } from '../motion/presets';

const items = [
    {
        quote: 'They remembered the little things — kids\' rooms, our dog\'s bed area, and the pantry shelves. Every single time.',
        name: 'James & Priya K.',
        meta: 'Suburbs, IL',
        avatar: 'https://i.pravatar.cc/80?img=32',
        accent: 'border-brand-turquoise/50',
    },
    {
        quote: 'Professional from booking to lock-up. I work from home and barely notice they\'re here — but the difference is unmistakable.',
        name: 'Danielle F.',
        meta: 'Townhome, CO',
        avatar: 'https://i.pravatar.cc/80?img=5',
        accent: 'border-brand-fuchsia/40',
    },
    {
        quote: 'Deep clean before listing our condo helped us get showings within two days. Highly recommend for sellers.',
        name: 'Oscar T.',
        meta: 'Seller, FL',
        avatar: 'https://i.pravatar.cc/80?img=68',
        accent: 'border-brand-gold/50',
    },
];
</script>

<template>
    <section class="bg-brand-white py-20 sm:py-24" aria-labelledby="testimonials-heading">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">

            <!-- Section header -->
            <div class="mx-auto max-w-2xl text-center">
                <motion.p
                    class="mb-2 text-xs font-bold uppercase tracking-widest text-brand-turquoise"
                    v-bind="fadeUp(0)"
                >Happy customers</motion.p>
                <motion.h2
                    id="testimonials-heading"
                    class="font-heading text-3xl font-bold tracking-tight text-brand-navy sm:text-4xl"
                    v-bind="fadeUp(0.06)"
                >
                    Loved in neighborhoods nationwide
                </motion.h2>
                <!-- Aggregate rating -->
                <motion.div
                    class="mt-4 flex items-center justify-center gap-2"
                    v-bind="fadeUp(0.12)"
                >
                    <div class="flex items-center gap-0.5 text-brand-gold text-xl">★★★★★</div>
                    <span class="font-heading text-lg font-bold text-brand-navy">4.9</span>
                    <span class="text-sm text-brand-body">· 2,500+ reviews</span>
                </motion.div>
            </div>

            <!-- Testimonial cards -->
            <ul class="mt-14 grid gap-6 md:grid-cols-3">
                <motion.li
                    v-for="(t, index) in items"
                    :key="t.name"
                    class="relative flex flex-col overflow-hidden rounded-2xl border border-brand-navy/10 bg-brand-surface/60 p-6 shadow-sm transition hover:bg-brand-white hover:shadow-md"
                    v-bind="scaleIn(0.06 + index * 0.08)"
                    :whileHover="{ y: -4 }"
                    :transition="{ type: 'spring', stiffness: 350, damping: 24 }"
                >
                    <!-- Decorative large quote mark -->
                    <div
                        class="pointer-events-none absolute right-4 top-3 font-heading text-7xl font-bold leading-none text-brand-navy/5 select-none"
                        aria-hidden="true"
                    >"</div>

                    <!-- Stars -->
                    <div class="mb-4 flex items-center gap-0.5 text-brand-gold">★★★★★</div>

                    <!-- Quote -->
                    <p class="flex-1 text-sm leading-relaxed text-brand-body">"{{ t.quote }}"</p>

                    <!-- Author -->
                    <footer class="mt-6 flex items-center gap-3 border-t border-brand-navy/10 pt-4">
                        <img
                            :src="t.avatar"
                            :alt="t.name"
                            class="h-10 w-10 shrink-0 rounded-full object-cover ring-2"
                            :class="t.accent"
                            width="80"
                            height="80"
                            loading="lazy"
                            decoding="async"
                        >
                        <div>
                            <p class="font-heading font-semibold text-brand-navy">{{ t.name }}</p>
                            <p class="text-xs text-brand-body">{{ t.meta }}</p>
                        </div>
                    </footer>
                </motion.li>
            </ul>

            <!-- Trust badges row -->
            <motion.div
                class="mt-14 flex flex-wrap items-center justify-center gap-6 opacity-60"
                v-bind="fadeUp(0.18)"
                aria-label="Trust indicators"
            >
                <div class="flex items-center gap-2 text-sm font-medium text-brand-navy">
                    <svg class="h-5 w-5 text-brand-turquoise" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                    </svg>
                    Insured &amp; bonded
                </div>
                <div class="h-4 w-px bg-brand-navy/20" aria-hidden="true" />
                <div class="flex items-center gap-2 text-sm font-medium text-brand-navy">
                    <svg class="h-5 w-5 text-brand-turquoise" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                    </svg>
                    Eco-friendly products
                </div>
                <div class="h-4 w-px bg-brand-navy/20" aria-hidden="true" />
                <div class="flex items-center gap-2 text-sm font-medium text-brand-navy">
                    <svg class="h-5 w-5 text-brand-turquoise" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106a12.318 12.318 0 0 1-6.376 1.872c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                    Background-checked staff
                </div>
                <div class="h-4 w-px bg-brand-navy/20" aria-hidden="true" />
                <div class="flex items-center gap-2 text-sm font-medium text-brand-navy">
                    <svg class="h-5 w-5 text-brand-turquoise" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                    </svg>
                    Satisfaction guarantee
                </div>
            </motion.div>
        </div>
    </section>
</template>
