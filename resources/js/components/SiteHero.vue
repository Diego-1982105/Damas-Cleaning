<script setup>
import { motion } from 'motion-v';
import { fadeUp, easeOut } from '../motion/presets';
import { illustrations } from '../data/illustrations';
</script>

<template>
    <section class="relative overflow-hidden bg-gradient-to-br from-[#1e0510] via-[#4a0e28] to-brand-navy text-white">
        <!-- Background dot pattern -->
        <div
            class="pointer-events-none absolute inset-0 opacity-[0.08]"
            style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%2300BCD4\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"
            aria-hidden="true"
        />
        <!-- Glow orbs -->
        <div class="pointer-events-none absolute -left-32 -top-32 h-[32rem] w-[32rem] rounded-full bg-brand-fuchsia/20 blur-3xl" aria-hidden="true" />
        <div class="pointer-events-none absolute -right-40 top-1/2 h-80 w-80 rounded-full bg-brand-turquoise/15 blur-3xl" aria-hidden="true" />
        <div class="pointer-events-none absolute bottom-0 left-1/2 h-64 w-64 -translate-x-1/2 rounded-full bg-brand-fuchsia/10 blur-3xl" aria-hidden="true" />

        <!-- Content -->
        <div class="relative mx-auto max-w-6xl px-4 pb-32 pt-16 sm:px-6 sm:pb-36 sm:pt-20 lg:px-8 lg:pb-40 lg:pt-24">
            <div class="grid gap-12 lg:grid-cols-2 lg:items-center lg:gap-16">

                <!-- ── Left: Text ── -->
                <div>
                    <!-- Eyebrow badge -->
                    <motion.p
                        class="mb-5 inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-1.5 text-xs font-semibold uppercase tracking-wider text-brand-gold backdrop-blur-sm"
                        v-bind="fadeUp(0)"
                    >
                        <span class="inline-block h-1.5 w-1.5 animate-pulse rounded-full bg-brand-gold" aria-hidden="true" />
                        Reliable · Efficient · Trusted professionals
                    </motion.p>

                    <!-- Headline -->
                    <motion.h1
                        class="font-heading text-4xl font-bold leading-tight tracking-tight sm:text-5xl lg:text-[3.5rem] xl:text-6xl"
                        v-bind="fadeUp(0.08)"
                    >
                        Your home, spotless.<br>
                        <span class="bg-gradient-to-r from-brand-turquoise to-[#67e8f9] bg-clip-text text-transparent">
                            Your time, valued.
                        </span>
                    </motion.h1>

                    <!-- Description -->
                    <motion.ul
                        class="mt-6 space-y-2 text-white/80"
                        v-bind="fadeUp(0.16)"
                    >
                        <li class="flex items-start gap-2.5 text-base sm:text-lg">
                            <svg class="mt-0.5 h-5 w-5 shrink-0 text-brand-turquoise" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/></svg>
                            High-quality cleaning for you and your loved ones
                        </li>
                        <li class="flex items-start gap-2.5 text-base sm:text-lg">
                            <svg class="mt-0.5 h-5 w-5 shrink-0 text-brand-turquoise" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/></svg>
                            Fully customized cleaning plans for every home
                        </li>
                        <li class="flex items-start gap-2.5 text-base font-semibold text-brand-gold sm:text-lg">
                            <svg class="mt-0.5 h-5 w-5 shrink-0 text-brand-gold" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/></svg>
                            10% off on your first service!
                        </li>
                    </motion.ul>

                    <!-- CTAs -->
                    <motion.div
                        class="mt-10 flex flex-col gap-4 sm:flex-row"
                        v-bind="fadeUp(0.22)"
                    >
                        <motion.a
                            href="#contact"
                            class="inline-flex items-center justify-center rounded-full bg-brand-fuchsia px-8 py-3.5 text-base font-semibold text-white shadow-xl shadow-brand-fuchsia/30 transition hover:bg-brand-fuchsia-dark"
                            :whileHover="{ scale: 1.04, boxShadow: '0 16px 40px rgba(233, 30, 99, 0.45)' }"
                            :whileTap="{ scale: 0.97 }"
                            :transition="{ type: 'spring', stiffness: 400, damping: 18 }"
                        >
                            Request a free quote
                        </motion.a>
                        <motion.a
                            href="#services"
                            class="inline-flex items-center justify-center rounded-full border-2 border-white/25 bg-white/10 px-8 py-3.5 text-base font-semibold text-white backdrop-blur-sm transition hover:border-white/50 hover:bg-white/15"
                            :whileHover="{ scale: 1.03 }"
                            :whileTap="{ scale: 0.98 }"
                            :transition="{ type: 'spring', stiffness: 380, damping: 22 }"
                        >
                            Explore services
                        </motion.a>
                    </motion.div>

                    <!-- Stats -->
                    <motion.dl
                        class="mt-12 grid grid-cols-3 gap-4 border-t border-white/15 pt-10 sm:gap-8"
                        v-bind="fadeUp(0.3)"
                    >
                        <div>
                            <dd class="font-heading text-2xl font-bold text-white sm:text-3xl">2.5k+</dd>
                            <dt class="mt-1 text-xs font-medium uppercase tracking-wide text-white/55">Happy homes</dt>
                        </div>
                        <div>
                            <dd class="font-heading text-2xl font-bold text-white sm:text-3xl">
                                4.9<span class="text-brand-gold">★</span>
                            </dd>
                            <dt class="mt-1 text-xs font-medium uppercase tracking-wide text-white/55">Rating</dt>
                        </div>
                        <div>
                            <dd class="font-heading text-2xl font-bold text-white sm:text-3xl">40+</dd>
                            <dt class="mt-1 text-xs font-medium uppercase tracking-wide text-white/55">Cities served</dt>
                        </div>
                    </motion.dl>
                </div>

                <!-- ── Right: Image ── -->
                <motion.div
                    class="relative"
                    :initial="{ opacity: 0, x: 48 }"
                    :whileInView="{ opacity: 1, x: 0 }"
                    :viewport="{ once: true }"
                    :transition="{ duration: 0.7, ease: easeOut, delay: 0.18 }"
                >
                    <!-- Decorative ring behind image -->
                    <div class="pointer-events-none absolute -inset-3 rounded-3xl border border-brand-turquoise/25" aria-hidden="true" />
                    <!-- Glow behind image -->
                    <div class="pointer-events-none absolute -inset-8 rounded-3xl bg-brand-fuchsia/20 blur-3xl opacity-50" aria-hidden="true" />

                    <!-- Image card -->
                    <div class="relative overflow-hidden rounded-3xl border border-white/15 shadow-2xl">
                        <img
                            :src="illustrations.heroBanner"
                            :alt="illustrations.heroBannerAlt"
                            class="aspect-[4/3] w-full object-cover"
                            width="900"
                            height="675"
                            loading="eager"
                            decoding="async"
                            fetchpriority="high"
                        >
                        <!-- Subtle dark gradient overlay -->
                        <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-brand-navy/40 via-transparent to-transparent" aria-hidden="true" />

                        <!-- Floating: social proof card -->
                        <motion.div
                            class="absolute bottom-4 left-4 flex items-center gap-3 rounded-2xl bg-white/95 px-4 py-3 shadow-xl backdrop-blur-sm sm:bottom-5 sm:left-5"
                            :initial="{ opacity: 0, y: 16, scale: 0.9 }"
                            :animate="{ opacity: 1, y: 0, scale: 1 }"
                            :transition="{ duration: 0.55, ease: easeOut, delay: 0.9 }"
                        >
                            <div class="flex -space-x-1.5">
                                <img src="https://i.pravatar.cc/40?img=47" class="h-8 w-8 rounded-full border-2 border-white object-cover" alt="" loading="lazy" />
                                <img src="https://i.pravatar.cc/40?img=12" class="h-8 w-8 rounded-full border-2 border-white object-cover" alt="" loading="lazy" />
                                <img src="https://i.pravatar.cc/40?img=45" class="h-8 w-8 rounded-full border-2 border-white object-cover" alt="" loading="lazy" />
                            </div>
                            <div>
                                <div class="flex items-center gap-0.5 text-sm text-brand-gold">★★★★★</div>
                                <p class="text-xs font-semibold text-brand-navy">2,500+ happy clients</p>
                            </div>
                        </motion.div>

                        <!-- Floating: eco badge -->
                        <motion.div
                            class="absolute right-4 top-4 flex items-center gap-1.5 rounded-xl bg-brand-turquoise px-3 py-2 text-white shadow-lg sm:right-5 sm:top-5"
                            :initial="{ opacity: 0, x: 16 }"
                            :animate="{ opacity: 1, x: 0 }"
                            :transition="{ duration: 0.5, ease: easeOut, delay: 1.05 }"
                        >
                            <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-xs font-bold">Eco-friendly</span>
                        </motion.div>
                    </div>
                </motion.div>
            </div>
        </div>

        <!-- Wave separator — fill matches brand-surface (#fdf3f7) -->
        <div class="absolute bottom-0 left-0 right-0 overflow-hidden" style="height: 60px;" aria-hidden="true">
            <svg viewBox="0 0 1440 60" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" class="h-full w-full">
                <path d="M0,30 C360,60 1080,0 1440,30 L1440,60 L0,60 Z" fill="#fdf3f7" />
            </svg>
        </div>
    </section>
</template>
