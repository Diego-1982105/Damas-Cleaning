<script setup>
import { motion } from 'motion-v';
import { fadeUp, scaleIn } from '../motion/presets';
import { illustrations } from '../data/illustrations';

const team = [
    {
        name: 'Elena Damas',
        role: 'Founder & operations',
        bio: 'Started Damas Cleaning to bring dependable, respectful service to busy families.',
        photoUrl: illustrations.team.elena,
        photoAlt: 'Portrait placeholder — Elena Damas',
    },
    {
        name: 'Marcus Chen',
        role: 'Lead trainer',
        bio: 'Ensures every specialist meets our checklist and eco-product standards.',
        photoUrl: illustrations.team.marcus,
        photoAlt: 'Portrait placeholder — Marcus Chen',
    },
    {
        name: 'Sofia Ramirez',
        role: 'Customer success',
        bio: 'Your go-to for scheduling, special requests, and follow-up after visits.',
        photoUrl: illustrations.team.sofia,
        photoAlt: 'Portrait placeholder — Sofia Ramirez',
    },
    {
        name: 'Jordan Lee',
        role: 'Quality lead',
        bio: 'Spot-checks visits and gathers feedback so we keep improving every week.',
        photoUrl: illustrations.team.jordan,
        photoAlt: 'Portrait placeholder — Jordan Lee',
    },
];
</script>

<template>
    <section id="about" class="scroll-mt-24 border-y border-brand-navy/10 bg-brand-surface py-20 sm:py-24">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-14 lg:grid-cols-12 lg:gap-12">
                <motion.div
                    class="flex flex-col gap-8 lg:col-span-5"
                    v-bind="fadeUp(0)"
                >
                    <motion.div
                        class="overflow-hidden rounded-2xl border border-brand-navy/10 shadow-lg"
                        v-bind="scaleIn(0.04)"
                    >
                        <img
                            :src="illustrations.aboutStory"
                            :alt="illustrations.aboutStoryAlt"
                            class="aspect-[4/3] w-full object-cover sm:aspect-[16/11]"
                            width="900"
                            height="620"
                            loading="lazy"
                            decoding="async"
                        >
                    </motion.div>
                    <div>
                        <p class="mb-2 text-xs font-semibold uppercase tracking-wider text-brand-turquoise">Our story</p>
                        <h2 class="font-heading text-3xl font-bold tracking-tight text-brand-navy sm:text-4xl">
                            A small team with a big standard for “done right”
                        </h2>
                        <div class="mt-6 space-y-4 text-brand-body leading-relaxed">
                            <p>
                                Damas Cleaning began with a simple frustration: great people, inconsistent results.
                                We built a company where training, supplies, and communication are never optional — so you
                                always know what to expect when we walk through your door.
                            </p>
                            <p>
                                Today we serve homeowners across multiple metros, but we still operate like a neighborhood
                                crew: on time, thorough, and genuinely glad to leave your home brighter than we found it.
                            </p>
                        </div>
                    </div>
                </motion.div>

                <motion.div
                    class="lg:col-span-7"
                    v-bind="fadeUp(0.1)"
                >
                    <p class="mb-4 text-xs font-semibold uppercase tracking-wider text-brand-navy">Meet the team</p>
                    <ul class="grid gap-6 sm:grid-cols-2">
                        <motion.li
                            v-for="(member, index) in team"
                            :key="member.name"
                            class="flex gap-4 rounded-2xl border border-brand-navy/10 bg-brand-white p-5 shadow-sm"
                            v-bind="scaleIn(0.06 + index * 0.06)"
                            :whileHover="{ y: -4 }"
                            :transition="{ type: 'spring', stiffness: 300, damping: 20 }"
                        >
                            <img
                                :src="member.photoUrl"
                                :alt="member.photoAlt"
                                class="h-16 w-16 shrink-0 rounded-xl object-cover ring-2 ring-brand-turquoise/20"
                                width="128"
                                height="128"
                                loading="lazy"
                                decoding="async"
                            >
                            <div>
                                <h3 class="font-heading font-semibold text-brand-navy">{{ member.name }}</h3>
                                <p class="text-xs font-medium uppercase tracking-wide text-brand-turquoise">{{ member.role }}</p>
                                <p class="mt-2 text-sm leading-relaxed text-brand-body">{{ member.bio }}</p>
                            </div>
                        </motion.li>
                    </ul>
                </motion.div>
            </div>
        </div>
    </section>
</template>
