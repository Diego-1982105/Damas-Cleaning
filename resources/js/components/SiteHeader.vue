<script setup>
import { ref } from 'vue';
import { motion } from 'motion-v';
import { easeOut } from '../motion/presets';

const open = ref(false);
const showBanner = ref(true);

const links = [
    { href: '#services', label: 'Services' },
    { href: '#before-after', label: 'Results' },
    { href: '#about', label: 'Our story' },
    { href: '#why-us', label: 'Why us' },
    { href: '#process', label: 'How it works' },
    { href: '#contact', label: 'Get a quote' },
];

function closeMenu() { open.value = false; }
</script>

<template>
    <!-- Announcement bar (non-sticky, scrolls away) -->
    <div
        v-show="showBanner"
        class="relative z-50 bg-gradient-to-r from-brand-fuchsia via-[#d81b60] to-[#c2185b] px-4 py-2.5 text-center text-sm font-medium text-white"
    >
        <span class="hidden sm:inline">🎉 10% off your first cleaning service — </span>
        <span class="sm:hidden">🎉 10% off first clean — </span>
        <a
            href="#contact"
            class="font-bold underline underline-offset-2 hover:no-underline"
            @click="showBanner = false"
        >Claim your discount →</a>
        <button
            type="button"
            class="absolute right-3 top-1/2 -translate-y-1/2 rounded-full p-1 opacity-70 transition hover:bg-white/20 hover:opacity-100"
            aria-label="Dismiss banner"
            @click="showBanner = false"
        >
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Sticky nav -->
    <motion.header
        class="sticky top-0 z-40 border-b border-brand-navy/10 bg-white/95 shadow-sm backdrop-blur-md"
        :initial="{ opacity: 0, y: -16 }"
        :animate="{ opacity: 1, y: 0 }"
        :transition="{ duration: 0.5, ease: easeOut }"
    >
        <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-8">
            <!-- Logo -->
            <motion.a
                href="#"
                class="group flex items-center gap-2.5"
                aria-label="Damas Cleaning — Home"
                :whileHover="{ scale: 1.02 }"
                :whileTap="{ scale: 0.98 }"
                :transition="{ type: 'spring', stiffness: 420, damping: 22 }"
            >
                <img
                    src="/images/damas-logo.png"
                    alt=""
                    width="44"
                    height="44"
                    class="h-11 w-11 shrink-0 rounded-2xl border border-brand-navy/10 object-cover shadow-md shadow-brand-turquoise/20 ring-2 ring-white transition group-hover:shadow-lg"
                />
                <span class="font-heading text-lg font-semibold tracking-tight text-brand-navy">
                    Damas <span class="text-brand-turquoise">Cleaning</span>
                </span>
            </motion.a>

            <!-- Desktop nav -->
            <nav class="hidden items-center gap-1 lg:flex" aria-label="Primary">
                <motion.a
                    v-for="l in links.slice(0, -1)"
                    :key="l.href"
                    :href="l.href"
                    class="rounded-lg px-3 py-2 text-sm font-medium text-brand-body transition hover:bg-brand-surface hover:text-brand-navy"
                    :whileHover="{ y: -1 }"
                    :transition="{ type: 'spring', stiffness: 400, damping: 25 }"
                >{{ l.label }}</motion.a>
            </nav>

            <!-- Right side -->
            <div class="flex items-center gap-3">
                <a
                    href="tel:+16783827724"
                    class="hidden items-center gap-1.5 text-sm font-medium text-brand-body transition hover:text-brand-navy sm:flex"
                >
                    <svg class="h-4 w-4 text-brand-turquoise" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z"/>
                    </svg>
                    678-382-7724
                </a>
                <motion.a
                    href="#contact"
                    class="rounded-full bg-brand-fuchsia px-5 py-2 text-sm font-semibold text-white shadow-md shadow-brand-fuchsia/25 transition hover:bg-brand-fuchsia-dark hover:shadow-lg"
                    :whileHover="{ scale: 1.05 }"
                    :whileTap="{ scale: 0.96 }"
                    :transition="{ type: 'spring', stiffness: 450, damping: 20 }"
                >Free estimate</motion.a>

                <!-- Mobile menu button -->
                <button
                    type="button"
                    class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-brand-surface text-brand-navy transition hover:bg-brand-surface lg:hidden"
                    :aria-expanded="open"
                    aria-label="Open menu"
                    @click="open = !open"
                >
                    <svg v-if="!open" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg v-else class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile menu -->
        <div
            v-show="open"
            class="border-t border-brand-surface/80 bg-white/98 px-4 pb-5 pt-3 shadow-lg backdrop-blur-sm lg:hidden"
        >
            <nav class="flex flex-col gap-1" aria-label="Mobile navigation">
                <a
                    v-for="l in links"
                    :key="l.href"
                    :href="l.href"
                    class="flex items-center rounded-xl px-4 py-3 text-sm font-medium text-brand-navy transition hover:bg-brand-surface"
                    @click="closeMenu"
                >{{ l.label }}</a>
            </nav>
            <a
                href="tel:+16783827724"
                class="mt-3 flex items-center gap-2.5 rounded-xl border border-brand-surface px-4 py-3 text-sm font-medium text-brand-body transition hover:bg-brand-surface"
            >
                <svg class="h-4 w-4 text-brand-turquoise" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z"/>
                </svg>
                678-382-7724            
            </a>
        </div>
    </motion.header>
</template>
