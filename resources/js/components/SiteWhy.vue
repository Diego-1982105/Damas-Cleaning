<script setup>
import { motion } from 'motion-v';
import { fadeUp, scaleIn } from '../motion/presets';
import { illustrations } from '../data/illustrations';

const features = [
    {
        icon: 'M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z',
        title: 'Background-checked staff',
        desc: 'Every specialist is vetted, insured, and trained to our standards before their first visit.',
        color: 'bg-brand-turquoise/15 text-brand-turquoise',
    },
    {
        icon: 'M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z',
        title: 'On-time, every time',
        desc: 'Arrival windows you can plan around, with text updates so you\'re never left guessing.',
        color: 'bg-brand-gold/25 text-[#b45309]',
    },
    {
        icon: 'M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z',
        title: 'Eco-friendly products',
        desc: 'Safe for kids, pets, and the planet — without compromising on clean.',
        color: 'bg-emerald-100 text-emerald-600',
    },
    {
        icon: 'M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z',
        title: 'Satisfaction guarantee',
        desc: 'Not happy? We return within 24 h to make it right — no questions asked.',
        color: 'bg-brand-fuchsia/10 text-brand-fuchsia',
    },
    {
        icon: 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5',
        title: 'Flexible scheduling',
        desc: 'Weekly, biweekly, monthly, or one-time — you choose, we adapt to your routine.',
        color: 'bg-sky-100 text-sky-600',
    },
    {
        icon: 'M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z',
        title: 'Clear communication',
        desc: 'Appointment reminders, arrival ETAs, and post-visit summaries keep you in the loop.',
        color: 'bg-violet-100 text-violet-600',
    },
];
</script>

<template>
    <section id="why-us" class="scroll-mt-24 bg-brand-white py-20 sm:py-24">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">

            <!-- Section header -->
            <div class="mx-auto max-w-2xl text-center">
                <motion.p
                    class="mb-2 text-xs font-bold uppercase tracking-widest text-brand-turquoise"
                    v-bind="fadeUp(0)"
                >Why choose us</motion.p>
                <motion.h2
                    class="font-heading text-3xl font-bold tracking-tight text-brand-navy sm:text-4xl"
                    v-bind="fadeUp(0.06)"
                >
                    Why families choose Damas Cleaning
                </motion.h2>
                <motion.p
                    class="mt-4 text-lg text-brand-body"
                    v-bind="fadeUp(0.12)"
                >
                    We treat your space with the same care we would our own — clear communication,
                    respectful teams, and spotless finishes that hold up to real life.
                </motion.p>
            </div>

            <!-- Feature grid -->
            <ul class="mt-14 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                <motion.li
                    v-for="(f, i) in features"
                    :key="f.title"
                    class="group flex gap-4 rounded-2xl border border-brand-navy/8 bg-brand-surface/50 p-5 shadow-sm transition hover:bg-brand-white hover:shadow-md"
                    v-bind="scaleIn(0.04 + i * 0.05)"
                    :whileHover="{ y: -3 }"
                    :transition="{ type: 'spring', stiffness: 320, damping: 22 }"
                >
                    <div
                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl"
                        :class="f.color"
                    >
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" :d="f.icon" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-heading font-semibold text-brand-navy">{{ f.title }}</h3>
                        <p class="mt-1.5 text-sm leading-relaxed text-brand-body">{{ f.desc }}</p>
                    </div>
                </motion.li>
            </ul>

            <!-- Featured testimonial -->
            <motion.blockquote
                class="relative mt-16 overflow-hidden rounded-3xl bg-gradient-to-br from-[#4a0e28] to-brand-navy p-8 text-white shadow-2xl sm:p-10"
                v-bind="fadeUp(0.1)"
            >
                <!-- Decorative quote mark -->
                <div
                    class="pointer-events-none absolute -left-2 -top-4 font-heading text-[10rem] font-bold leading-none text-white/5 select-none"
                    aria-hidden="true"
                >"</div>

                <div class="relative grid gap-8 lg:grid-cols-3 lg:items-center">
                    <div class="lg:col-span-2">
                        <div class="mb-4 flex items-center gap-1 text-brand-gold text-lg">★★★★★</div>
                        <p class="text-lg font-medium leading-relaxed text-white/90 sm:text-xl">
                            "We switched after two disappointing agencies. Damas is punctual, thorough,
                            and the house still smells fresh days later. Worth every penny."
                        </p>
                    </div>
                    <div class="flex items-center gap-4 lg:justify-end">
                        <img
                            :src="illustrations.testimonialPortrait"
                            :alt="illustrations.testimonialPortraitAlt"
                            class="h-16 w-16 shrink-0 rounded-2xl object-cover ring-2 ring-brand-gold/50 shadow-md"
                            width="128"
                            height="128"
                            loading="lazy"
                            decoding="async"
                        >
                        <div>
                            <cite class="not-italic font-heading text-lg font-bold text-white">Maria R.</cite>
                            <p class="text-sm text-white/60">Homeowner, Austin metro</p>
                            <div class="mt-1.5 inline-flex items-center gap-1.5 rounded-full border border-brand-gold/30 bg-brand-gold/15 px-2.5 py-1 text-xs font-semibold text-brand-gold">
                                <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                </svg>
                                Verified customer
                            </div>
                        </div>
                    </div>
                </div>
            </motion.blockquote>
        </div>
    </section>
</template>
