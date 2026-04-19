<script setup>
import { motion } from 'motion-v';
import { fadeUp } from '../motion/presets';

const year = new Date().getFullYear();

const serviceLinks = [
    { href: '#services', label: 'Standard Clean' },
    { href: '#services', label: 'Deep Clean' },
    { href: '#services', label: 'Move-In / Move-Out' },
    { href: '#services', label: 'Recurring Service' },
    { href: '#services', label: 'Office Cleaning' },
];

const companyLinks = [
    { href: '#about', label: 'Our story' },
    { href: '#why-us', label: 'Why us' },
    { href: '#process', label: 'How it works' },
    { href: '#before-after', label: 'Before &amp; after' },
    { href: '#contact', label: 'Contact us' },
];
</script>

<template>
    <footer class="border-t border-white/10 bg-gradient-to-b from-[#4a0e28] to-[#1e0510] text-white" aria-labelledby="footer-heading">
        <h2 id="footer-heading" class="sr-only">Footer</h2>

        <div class="mx-auto max-w-6xl px-4 pb-10 pt-14 sm:px-6 lg:px-8 lg:pt-16">
            <!-- Main grid -->
            <div class="grid gap-10 sm:grid-cols-2 lg:grid-cols-4">

                <!-- Column 1: Brand -->
                <motion.div v-bind="fadeUp(0)">
                    <a href="#" class="group flex items-center gap-2.5" aria-label="Damas Cleaning — Home">
                        <img
                            src="/images/damas-logo.png"
                            alt=""
                            width="40"
                            height="40"
                            class="h-10 w-10 shrink-0 rounded-xl border border-white/15 object-cover shadow-md"
                        />
                        <span class="font-heading text-lg font-semibold tracking-tight text-white">
                            Damas <span class="text-brand-turquoise">Cleaning</span>
                        </span>
                    </a>
                    <p class="mt-4 text-sm leading-relaxed text-white/65">
                        Professional residential cleaning services tailored to your home and schedule.
                        Eco-conscious, vetted, and trusted by 2,500+ families nationwide.
                    </p>
                    <!-- Social links -->
                    <div class="mt-6 flex gap-3">
                        <a
                            href="#"
                            class="flex h-9 w-9 items-center justify-center rounded-lg border border-white/15 text-white/60 transition hover:border-brand-turquoise/50 hover:bg-brand-turquoise/10 hover:text-brand-turquoise"
                            aria-label="Facebook"
                        >
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878V14.89h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" />
                            </svg>
                        </a>
                        <a
                            href="https://www.instagram.com/damas_cleaning_home_service_"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="flex h-9 w-9 items-center justify-center rounded-lg border border-white/15 text-white/60 transition hover:border-brand-fuchsia/50 hover:bg-brand-fuchsia/10 hover:text-brand-fuchsia"
                            aria-label="Instagram"
                        >
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 0 1 1.772 1.153 4.902 4.902 0 0 1 1.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 0 1-1.153 1.772 4.902 4.902 0 0 1-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 0 1-1.772-1.153 4.902 4.902 0 0 1-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 0 1 1.153-1.772A4.902 4.902 0 0 1 5.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 0 0-.748-1.15 3.098 3.098 0 0 0-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 1 1 0 10.27 5.135 5.135 0 0 1 0-10.27zm0 1.802a3.333 3.333 0 1 0 0 6.666 3.333 3.333 0 0 0 0-6.666zm5.338-3.205a1.2 1.2 0 1 1 0 2.4 1.2 1.2 0 0 1 0-2.4z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a
                            href="#"
                            class="flex h-9 w-9 items-center justify-center rounded-lg border border-white/15 text-white/60 transition hover:border-brand-gold/40 hover:bg-brand-gold/10 hover:text-brand-gold"
                            aria-label="Google"
                        >
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M12.545 10.239v3.821h5.445c-.712 2.315-2.647 3.972-5.445 3.972a6.033 6.033 0 1 1 0-12.064c1.498 0 2.866.549 3.921 1.453l2.814-2.814A9.969 9.969 0 0 0 12.545 2C7.021 2 2.543 6.477 2.543 12s4.478 10 10.002 10c8.396 0 10.249-7.85 9.426-11.748l-9.426-.013z" />
                            </svg>
                        </a>
                    </div>
                </motion.div>

                <!-- Column 2: Services -->
                <motion.div v-bind="fadeUp(0.06)">
                    <h3 class="mb-4 text-sm font-semibold uppercase tracking-widest text-white/40">Services</h3>
                    <ul class="space-y-3">
                        <li v-for="l in serviceLinks" :key="l.label">
                            <a
                                :href="l.href"
                                class="text-sm text-white/65 transition hover:text-brand-turquoise"
                                v-html="l.label"
                            />
                        </li>
                    </ul>
                </motion.div>

                <!-- Column 3: Company -->
                <motion.div v-bind="fadeUp(0.1)">
                    <h3 class="mb-4 text-sm font-semibold uppercase tracking-widest text-white/40">Company</h3>
                    <ul class="space-y-3">
                        <li v-for="l in companyLinks" :key="l.label">
                            <a
                                :href="l.href"
                                class="text-sm text-white/65 transition hover:text-brand-turquoise"
                                v-html="l.label"
                            />
                        </li>
                    </ul>
                </motion.div>

                <!-- Column 4: Contact CTA -->
                <motion.div v-bind="fadeUp(0.14)">
                    <h3 class="mb-4 text-sm font-semibold uppercase tracking-widest text-white/40">Get in touch</h3>
                    <ul class="space-y-3 text-sm text-white/65">
                        <li>
                            <a href="tel:+16783827724" class="flex items-center gap-2 transition hover:text-brand-turquoise">
                                <svg class="h-4 w-4 text-brand-turquoise/70" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z"/>
                                </svg>
                                678-382-7724
                            </a>
                        </li>
                        <li>
                            <a href="tel:+16785256816" class="flex items-center gap-2 transition hover:text-brand-turquoise">
                                <svg class="h-4 w-4 text-brand-turquoise/70" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z"/>
                                </svg>
                                678-525-6816
                            </a>
                        </li>
                        <li>
                            <a href="mailto:danieldavano@aol.com" class="flex items-center gap-2 transition hover:text-brand-turquoise">
                                <svg class="h-4 w-4 text-brand-turquoise/70" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"/>
                                </svg>
                                danieldavano@aol.com
                            </a>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="mt-0.5 h-4 w-4 shrink-0 text-brand-turquoise/70" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                            </svg>
                            Mon–Sat, 8 am – 6 pm local time
                        </li>
                    </ul>

                    <!-- CTA -->
                    <motion.a
                        href="#contact"
                        class="mt-6 flex items-center justify-center gap-2 rounded-xl bg-brand-fuchsia px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-brand-fuchsia/30 transition hover:bg-brand-fuchsia-dark"
                        :whileHover="{ scale: 1.03 }"
                        :whileTap="{ scale: 0.97 }"
                        :transition="{ type: 'spring', stiffness: 400, damping: 20 }"
                    >
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z"/>
                        </svg>
                        Get a free estimate
                    </motion.a>
                </motion.div>
            </div>

            <!-- Divider -->
            <div class="mt-14 border-t border-white/10 pt-8">
            <div class="flex flex-col items-center justify-between gap-4 text-xs text-white/40 sm:flex-row">
                <p>© {{ year }} Damas Cleaning. Residential cleaning services in the United States.</p>
                <div class="flex gap-5">
                    <a href="/privacy-policy" class="transition hover:text-white/70">Privacy Policy</a>
                    <a href="/terms-of-service" class="transition hover:text-white/70">Terms of Service</a>
                </div>
            </div>
            </div>
        </div>
    </footer>
</template>
