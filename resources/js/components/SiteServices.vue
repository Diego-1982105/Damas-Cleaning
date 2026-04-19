<script setup>
import { computed, onMounted, ref } from 'vue';
import { motion } from 'motion-v';
import { fadeUp, scaleIn } from '../motion/presets';
import { illustrations } from '../data/illustrations';
import { fetchServicesCatalog } from '../api/servicesCatalog';

const raw = ref([]);
const loading = ref(true);

onMounted(async () => {
    raw.value = await fetchServicesCatalog();
    loading.value = false;
});

const defaultCardDesc =
    'Custom checklist for your space. We confirm scope and timing when you request your free estimate.';

// Cycling accent palettes for cards
const accents = [
    { ring: 'ring-brand-turquoise/30', icon: 'bg-brand-turquoise/15 text-brand-turquoise', hover: 'group-hover:bg-brand-turquoise group-hover:text-white', border: 'group-hover:border-brand-turquoise/50' },
    { ring: 'ring-brand-fuchsia/25', icon: 'bg-brand-fuchsia/10 text-brand-fuchsia', hover: 'group-hover:bg-brand-fuchsia group-hover:text-white', border: 'group-hover:border-brand-fuchsia/40' },
    { ring: 'ring-brand-gold/30', icon: 'bg-brand-gold/20 text-[#b45309]', hover: 'group-hover:bg-brand-gold group-hover:text-brand-navy', border: 'group-hover:border-brand-gold/50' },
    { ring: 'ring-emerald-200', icon: 'bg-emerald-50 text-emerald-600', hover: 'group-hover:bg-emerald-500 group-hover:text-white', border: 'group-hover:border-emerald-300' },
    { ring: 'ring-violet-200', icon: 'bg-violet-50 text-violet-600', hover: 'group-hover:bg-violet-500 group-hover:text-white', border: 'group-hover:border-violet-300' },
    { ring: 'ring-sky-200', icon: 'bg-sky-50 text-sky-600', hover: 'group-hover:bg-sky-500 group-hover:text-white', border: 'group-hover:border-sky-300' },
];

const serviceIcons = [
    // sparkles
    'M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456ZM16.894 20.567 16.5 21.75l-.394-1.183a2.25 2.25 0 0 0-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 0 0 1.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 0 0 1.423 1.423l1.183.394-1.183.394a2.25 2.25 0 0 0-1.423 1.423Z',
    // home-modern
    'M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.06l8.69-8.689ZM12 5.432l8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z',
    // sun
    'M12 2.25a.75.75 0 0 1 .75.75v2.25a.75.75 0 0 1-1.5 0V3a.75.75 0 0 1 .75-.75ZM7.5 12a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM18.894 6.166a.75.75 0 0 0-1.06-1.06l-1.591 1.59a.75.75 0 1 0 1.06 1.061l1.591-1.59ZM21.75 12a.75.75 0 0 1-.75.75h-2.25a.75.75 0 0 1 0-1.5H21a.75.75 0 0 1 .75.75ZM17.834 18.894a.75.75 0 0 0 1.06-1.06l-1.59-1.591a.75.75 0 1 0-1.061 1.06l1.59 1.591ZM12 18a.75.75 0 0 1 .75.75V21a.75.75 0 0 1-1.5 0v-2.25A.75.75 0 0 1 12 18ZM7.758 17.303a.75.75 0 0 0-1.061-1.06l-1.591 1.59a.75.75 0 0 0 1.06 1.061l1.591-1.59ZM6 12a.75.75 0 0 1-.75.75H3a.75.75 0 0 1 0-1.5h2.25A.75.75 0 0 1 6 12ZM6.697 7.757a.75.75 0 0 0 1.06-1.06l-1.59-1.591a.75.75 0 0 0-1.061 1.06l1.59 1.591Z',
    // beaker
    'M9.75 3.104v5.714a2.25 2.25 0 0 1-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 0 1 4.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0 1 12 15a9.065 9.065 0 0 1-6.23-.693L4.2 13.9m15.6 1.4-.645 2.585A.75.75 0 0 1 18.43 18H5.57a.75.75 0 0 1-.724-.553L4.2 15.3m0 0a9.077 9.077 0 0 1-.21-1.5',
    // shield-check
    'M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z',
    // arrow-path (recurring)
    'M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99',
];

const services = computed(() =>
    raw.value.map((s, i) => ({
        id: s.id,
        title: s.name,
        desc: s.description || defaultCardDesc,
        accent: accents[i % accents.length],
        iconPath: serviceIcons[i % serviceIcons.length],
    })),
);
</script>

<template>
    <section id="services" class="scroll-mt-24 bg-brand-surface py-20 sm:py-24">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">

            <!-- Section header -->
            <div class="mx-auto max-w-2xl text-center">
                <motion.p
                    class="mb-2 text-xs font-bold uppercase tracking-widest text-brand-turquoise"
                    v-bind="fadeUp(0)"
                >Our services</motion.p>
                <motion.h2
                    class="font-heading text-3xl font-bold tracking-tight text-brand-navy sm:text-4xl"
                    v-bind="fadeUp(0.06)"
                >
                    Residential cleaning, built around your home
                </motion.h2>
                <motion.p
                    class="mt-4 text-lg text-brand-body"
                    v-bind="fadeUp(0.12)"
                >
                    From cozy apartments to multi-level houses, we scale our checklist to match your priorities.
                </motion.p>
            </div>

            <!-- Banner image -->
            <motion.div
                class="relative mx-auto mt-10 max-w-5xl overflow-hidden rounded-2xl border border-brand-navy/10 shadow-lg"
                v-bind="fadeUp(0.1)"
            >
                <img
                    :src="illustrations.servicesBanner"
                    :alt="illustrations.servicesBannerAlt"
                    class="h-48 w-full object-cover sm:h-56"
                    width="1400"
                    height="480"
                    loading="lazy"
                    decoding="async"
                >
                <div
                    class="pointer-events-none absolute inset-0 bg-gradient-to-t from-brand-navy/25 to-transparent"
                    aria-hidden="true"
                />
            </motion.div>

            <!-- Loading state -->
            <div v-if="loading" class="mt-14 flex justify-center gap-2">
                <div v-for="i in 3" :key="i" class="h-48 w-full animate-pulse rounded-2xl bg-brand-navy/5 sm:max-w-[280px]" />
            </div>

            <!-- Empty state -->
            <p
                v-else-if="services.length === 0"
                class="mt-14 rounded-2xl border border-brand-navy/10 bg-brand-white px-6 py-10 text-center text-sm text-brand-body"
            >
                Service list will appear here once entries are added in
                <strong class="text-brand-navy">Admin → Settings → Services</strong>.
            </p>

            <!-- Service cards -->
            <ul v-else class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <motion.li
                    v-for="(item, index) in services"
                    :key="item.id"
                    class="group relative overflow-hidden rounded-2xl border border-brand-navy/10 bg-brand-white p-6 shadow-sm transition"
                    :class="item.accent.border"
                    v-bind="scaleIn(index * 0.06)"
                    :whileHover="{ y: -5, boxShadow: '0 20px 40px rgba(26, 35, 126, 0.09)' }"
                    :transition="{ type: 'spring', stiffness: 300, damping: 20 }"
                >
                    <!-- Subtle top accent line -->
                    <div
                        class="absolute inset-x-0 top-0 h-0.5 scale-x-0 rounded-t-2xl transition-transform duration-300 group-hover:scale-x-100"
                        :class="item.accent.icon.split(' ')[0].replace('bg-', 'bg-').replace('/15', '').replace('/10', '').replace('/20', '')"
                        style="background: currentColor;"
                        aria-hidden="true"
                    />

                    <!-- Icon -->
                    <div
                        class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-xl transition-colors duration-300"
                        :class="[item.accent.icon, item.accent.hover]"
                    >
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" :d="item.iconPath" />
                        </svg>
                    </div>

                    <!-- Content -->
                    <h3 class="font-heading text-lg font-semibold text-brand-navy">{{ item.title }}</h3>
                    <p class="mt-2 text-sm leading-relaxed text-brand-body">{{ item.desc }}</p>

                    <!-- CTA link -->
                    <a
                        href="#contact"
                        class="mt-4 inline-flex items-center gap-1.5 text-xs font-semibold uppercase tracking-wide text-brand-turquoise opacity-0 transition-opacity duration-200 group-hover:opacity-100 hover:underline"
                    >
                        Get a quote
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </motion.li>
            </ul>

            <!-- Bottom CTA -->
            <motion.div
                class="mt-12 text-center"
                v-bind="fadeUp(0.2)"
            >
                <a
                    href="#contact"
                    class="inline-flex items-center gap-2 rounded-full border-2 border-brand-navy/20 bg-brand-white px-6 py-3 text-sm font-semibold text-brand-navy shadow-sm transition hover:border-brand-turquoise/50 hover:shadow-md"
                >
                    All services included in your free estimate
                    <svg class="h-4 w-4 text-brand-turquoise" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </a>
            </motion.div>
        </div>
    </section>
</template>
