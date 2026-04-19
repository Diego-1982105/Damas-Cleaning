<script setup>
import SiteHeader from './components/SiteHeader.vue';
import SiteHero from './components/SiteHero.vue';
import SiteServices from './components/SiteServices.vue';
import SiteBeforeAfter from './components/SiteBeforeAfter.vue';
import SiteAbout from './components/SiteAbout.vue';
import SiteWhy from './components/SiteWhy.vue';
import SiteProcess from './components/SiteProcess.vue';
import SiteTestimonials from './components/SiteTestimonials.vue';
import SiteContact from './components/SiteContact.vue';
import SiteFooter from './components/SiteFooter.vue';
import WhatsAppBubble from './components/WhatsAppBubble.vue';
import { provide } from 'vue';

const root = typeof document !== 'undefined' ? document.getElementById('app') : null;

provide(
    'csrfToken',
    root?.dataset?.csrf ?? document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? ''
);

// Section visibility — falls back to showing all if data-sections is absent
const rawSections = root?.dataset?.sections;
const enabledSections = rawSections ? new Set(JSON.parse(rawSections)) : null;
const show = (key) => enabledSections === null || enabledSections.has(key);
</script>

<template>
    <div class="min-h-screen bg-brand-white text-brand-body">
        <SiteHeader />
        <main>
            <SiteHero        v-if="show('hero')" />
            <SiteServices    v-if="show('services')" />
            <SiteBeforeAfter v-if="show('before_after')" />
            <SiteAbout       v-if="show('about')" />
            <SiteWhy         v-if="show('why_us')" />
            <SiteProcess     v-if="show('process')" />
            <SiteTestimonials v-if="show('testimonials')" />
            <SiteContact     v-if="show('contact')" />
        </main>
        <SiteFooter />
        <WhatsAppBubble />
    </div>
</template>
