<script setup>
import { motion } from 'motion-v';
import { fadeUp, scaleIn } from '../motion/presets';
import { illustrations } from '../data/illustrations';

const { beforeAfter: img } = illustrations;

const pairs = [
    {
        title: 'Kitchen refresh',
        caption: 'Grease, fingerprints, and high-traffic zones — brought back to a move-in feel.',
        beforeSrc: img.kitchenBefore,
        afterSrc: img.kitchenAfter,
        beforeAlt: 'Kitchen area before deep cleaning — illustrative stock photo',
        afterAlt: 'Bright kitchen after professional cleaning — illustrative stock photo',
    },
    {
        title: 'Bathroom detail',
        caption: 'Tile, fixtures, and glass — sanitized and polished for everyday comfort.',
        beforeSrc: img.bathBefore,
        afterSrc: img.bathAfter,
        beforeAlt: 'Bathroom before cleaning — illustrative stock photo',
        afterAlt: 'Modern bathroom after cleaning — illustrative stock photo',
    },
];
</script>

<template>
    <section id="before-after" class="scroll-mt-24 bg-brand-white py-20 sm:py-24">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <motion.p
                    class="mb-2 text-xs font-semibold uppercase tracking-wider text-brand-turquoise"
                    v-bind="fadeUp(0)"
                >Real results</motion.p>
                <motion.h2
                    class="font-heading text-3xl font-bold tracking-tight text-brand-navy sm:text-4xl"
                    v-bind="fadeUp(0.06)"
                >
                    Before &amp; after
                </motion.h2>
                <motion.p
                    class="mt-4 text-lg text-brand-body"
                    v-bind="fadeUp(0.12)"
                >
                    Illustrative photos for layout — swap them anytime for your own before/after shots of real jobs.
                </motion.p>
            </div>

            <div class="mt-14 space-y-16">
                <article
                    v-for="(pair, index) in pairs"
                    :key="pair.title"
                    class="grid gap-8 lg:grid-cols-2 lg:gap-10 lg:items-center"
                >
                    <motion.div
                        class="text-center lg:text-left"
                        v-bind="fadeUp(0.05 + index * 0.08)"
                    >
                        <h3 class="font-heading text-xl font-semibold text-brand-navy">{{ pair.title }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-brand-body sm:text-base">{{ pair.caption }}</p>
                    </motion.div>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <motion.figure
                            class="overflow-hidden rounded-2xl border border-brand-navy/10 bg-brand-surface shadow-sm"
                            v-bind="scaleIn(0.08 + index * 0.1)"
                            :whileHover="{ y: -3 }"
                            :transition="{ type: 'spring', stiffness: 320, damping: 22 }"
                        >
                            <div class="bg-brand-fuchsia/90 px-3 py-1.5 text-center text-xs font-bold uppercase tracking-wide text-white">
                                Before
                            </div>
                            <img
                                :src="pair.beforeSrc"
                                :alt="pair.beforeAlt"
                                class="aspect-[4/3] w-full object-cover"
                                width="800"
                                height="520"
                                loading="lazy"
                                decoding="async"
                            >
                        </motion.figure>
                        <motion.figure
                            class="overflow-hidden rounded-2xl border border-brand-turquoise/30 bg-brand-white shadow-md ring-1 ring-brand-turquoise/20"
                            v-bind="scaleIn(0.14 + index * 0.1)"
                            :whileHover="{ y: -3 }"
                            :transition="{ type: 'spring', stiffness: 320, damping: 22 }"
                        >
                            <div class="bg-brand-turquoise px-3 py-1.5 text-center text-xs font-bold uppercase tracking-wide text-white">
                                After
                            </div>
                            <img
                                :src="pair.afterSrc"
                                :alt="pair.afterAlt"
                                class="aspect-[4/3] w-full object-cover"
                                width="800"
                                height="520"
                                loading="lazy"
                                decoding="async"
                            >
                        </motion.figure>
                    </div>
                </article>
            </div>
        </div>
    </section>
</template>
