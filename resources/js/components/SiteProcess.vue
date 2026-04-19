<script setup>
import { motion } from 'motion-v';
import { fadeUp, scaleIn } from '../motion/presets';

const steps = [
    {
        n: '01',
        icon: 'M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 0 1 1.927-.184',
        title: 'Tell us about your home',
        body: 'Share square footage, pets, priorities, and preferred cadence — online or by phone in minutes.',
        color: 'bg-brand-turquoise text-white',
        glow: 'shadow-brand-turquoise/30',
    },
    {
        n: '02',
        icon: 'M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25Z',
        title: 'Receive a tailored plan',
        body: 'A clear checklist and schedule aligned to your rooms, add-ons, and budget — ready in one business day.',
        color: 'bg-brand-fuchsia text-white',
        glow: 'shadow-brand-fuchsia/30',
    },
    {
        n: '03',
        icon: 'M2.25 12 11.2 3.05a.75.75 0 0 1 1.06 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875a1.125 1.125 0 0 1 1.125-1.125h2.25a1.125 1.125 0 0 1 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M4.5 9.75 12 4.5l7.5 5.25',
        title: 'Relax — we handle the rest',
        body: 'Same team when possible, quality spot-checks after every visit, and easy rescheduling in a few taps.',
        color: 'bg-brand-gold text-brand-navy',
        glow: 'shadow-brand-gold/30',
    },
];
</script>

<template>
    <section id="process" class="scroll-mt-24 border-y border-brand-navy/10 bg-brand-surface py-20 sm:py-24">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">

            <!-- Section header -->
            <div class="mx-auto max-w-2xl text-center">
                <motion.p
                    class="mb-2 text-xs font-bold uppercase tracking-widest text-brand-turquoise"
                    v-bind="fadeUp(0)"
                >Simple process</motion.p>
                <motion.h2
                    class="font-heading text-3xl font-bold tracking-tight text-brand-navy sm:text-4xl"
                    v-bind="fadeUp(0.06)"
                >How it works</motion.h2>
                <motion.p
                    class="mt-4 text-lg text-brand-body"
                    v-bind="fadeUp(0.12)"
                >
                    A simple path from first message to a home you're proud to walk into.
                </motion.p>
            </div>

            <!-- Steps -->
            <div class="relative mt-14">
                <!-- Connecting line (desktop only) -->
                <div
                    class="pointer-events-none absolute left-1/6 right-1/6 top-10 hidden border-t-2 border-dashed border-brand-navy/15 md:block"
                    aria-hidden="true"
                />

                <ol class="grid gap-8 md:grid-cols-3">
                    <motion.li
                        v-for="(step, index) in steps"
                        :key="step.n"
                        class="relative flex flex-col rounded-2xl border border-brand-navy/10 bg-brand-white p-6 shadow-sm"
                        v-bind="scaleIn(index * 0.1)"
                        :whileHover="{ y: -6, boxShadow: '0 20px 44px rgba(26, 35, 126, 0.09)' }"
                        :transition="{ type: 'spring', stiffness: 320, damping: 22 }"
                    >
                        <!-- Step icon circle -->
                        <div
                            class="mb-5 flex h-14 w-14 items-center justify-center rounded-2xl shadow-lg"
                            :class="[step.color, step.glow]"
                        >
                            <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" :d="step.icon" />
                            </svg>
                        </div>

                        <!-- Step number badge -->
                        <span
                            class="pointer-events-none absolute right-5 top-5 font-heading text-5xl font-extrabold tabular-nums text-brand-navy/6 select-none"
                            aria-hidden="true"
                        >{{ step.n }}</span>

                        <!-- Content -->
                        <h3 class="font-heading text-lg font-semibold text-brand-navy">{{ step.title }}</h3>
                        <p class="mt-2 flex-1 text-sm leading-relaxed text-brand-body">{{ step.body }}</p>
                    </motion.li>
                </ol>
            </div>

            <!-- Bottom CTA -->
            <motion.div
                class="mt-14 text-center"
                v-bind="fadeUp(0.2)"
            >
                <motion.a
                    href="#contact"
                    class="inline-flex items-center gap-2 rounded-full bg-brand-navy px-8 py-3.5 text-base font-semibold text-white shadow-lg shadow-brand-navy/20 transition hover:bg-[#0d1560]"
                    :whileHover="{ scale: 1.04, boxShadow: '0 14px 36px rgba(26, 35, 126, 0.28)' }"
                    :whileTap="{ scale: 0.97 }"
                    :transition="{ type: 'spring', stiffness: 400, damping: 18 }"
                >
                    Start with step 1 — it's free
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </motion.a>
            </motion.div>
        </div>
    </section>
</template>
