<script setup>
import { inject, onMounted, reactive, ref } from 'vue';
import { motion } from 'motion-v';
import { fadeUp, easeOut } from '../motion/presets';
import { fetchServicesCatalog } from '../api/servicesCatalog';

const csrfToken = inject('csrfToken', '');

const catalogServices = ref([]);
const catalogLoading = ref(true);

onMounted(async () => {
    catalogServices.value = await fetchServicesCatalog();
    catalogLoading.value = false;
});

const form = reactive({
    name: '',
    email: '',
    phone: '',
    address: '',
    service_type: '',
    message: '',
});

const submitting = ref(false);
const success = ref('');
const errors = ref({});

async function submit() {
    success.value = '';
    errors.value = {};
    submitting.value = true;
    try {
        const res = await fetch('/leads', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                Accept: 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
            },
            credentials: 'same-origin',
            body: JSON.stringify({ ...form }),
        });
        const data = await res.json().catch(() => ({}));
        if (!res.ok) {
            if (res.status === 422 && data.errors) {
                errors.value = data.errors;
            } else {
                errors.value = { _form: [data.message || 'Something went wrong. Please try again.'] };
            }
            return;
        }
        success.value = data.message || 'Thank you!';
        form.name = '';
        form.email = '';
        form.phone = '';
        form.address = '';
        form.service_type = '';
        form.message = '';
    } finally {
        submitting.value = false;
    }
}
</script>

<template>
    <section id="contact" class="scroll-mt-24 bg-gradient-to-b from-[#4a0e28] via-brand-navy to-[#3a0d1f] py-20 text-white sm:py-24">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-12 lg:grid-cols-2 lg:gap-16">
                <motion.div
                    v-bind="fadeUp(0)"
                >
                    <p class="mb-2 text-xs font-semibold uppercase tracking-wider text-brand-gold">Get started</p>
                    <h2 class="font-heading text-3xl font-bold tracking-tight text-white sm:text-4xl">Get your free estimate</h2>
                    <p class="mt-4 text-lg text-white/85">
                        Share a few details and our team will follow up with availability — usually within one business day.
                    </p>
                    <!-- 10% off badge -->
                    <div class="mt-6 inline-flex items-center gap-2 rounded-xl border border-brand-gold/40 bg-brand-gold/15 px-4 py-2.5">
                        <svg class="h-5 w-5 text-brand-gold" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm font-semibold text-brand-gold">10% off your first service — mention this when you call!</span>
                    </div>

                    <dl class="mt-8 space-y-4 text-white/80">
                        <div class="flex items-center gap-3">
                            <dt class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-white/10">
                                <svg class="h-4 w-4 text-brand-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z"/></svg>
                            </dt>
                            <dd class="flex flex-col gap-0.5">
                                <a href="tel:+16783827724" class="font-semibold text-white hover:text-brand-gold">678-382-7724</a>
                                <a href="tel:+16785256816" class="text-sm hover:text-brand-gold">678-525-6816</a>
                            </dd>
                        </div>
                        <div class="flex items-center gap-3">
                            <dt class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-white/10">
                                <svg class="h-4 w-4 text-brand-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"/></svg>
                            </dt>
                            <dd><a href="mailto:danieldavano@aol.com" class="hover:text-brand-gold">danieldavano@aol.com</a></dd>
                        </div>
                        <div class="flex items-center gap-3">
                            <dt class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-white/10">
                                <svg class="h-4 w-4 text-brand-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                            </dt>
                            <dd>Mon–Sat, 8am – 6pm local time</dd>
                        </div>
                       
                    </dl>
                </motion.div>
                <motion.div
                    class="rounded-2xl bg-brand-white p-6 text-brand-body shadow-xl sm:p-8"
                    :initial="{ opacity: 0, x: 36 }"
                    :whileInView="{ opacity: 1, x: 0 }"
                    :viewport="{ once: true, amount: 0.25 }"
                    :transition="{ duration: 0.6, ease: easeOut }"
                >
                    <form class="space-y-5" @submit.prevent="submit">
                        <p
                            v-if="errors._form"
                            class="rounded-lg bg-red-50 px-3 py-2 text-sm text-red-700"
                            role="alert"
                        >{{ errors._form[0] }}</p>
                        <p
                            v-if="success"
                            class="rounded-lg border border-brand-turquoise/30 bg-brand-turquoise/10 px-3 py-2 text-sm text-brand-navy"
                            role="status"
                        >{{ success }}</p>

                        <div>
                            <label for="lead-name" class="block text-sm font-medium text-brand-navy">Full name</label>
                            <input
                                id="lead-name"
                                v-model="form.name"
                                type="text"
                                autocomplete="name"
                                required
                                class="mt-1 w-full rounded-lg border border-brand-navy/15 px-3 py-2 text-brand-navy shadow-sm focus:border-brand-turquoise focus:outline-none focus:ring-2 focus:ring-brand-turquoise/30"
                            >
                            <p v-if="errors.name" class="mt-1 text-xs text-red-600">{{ errors.name[0] }}</p>
                        </div>
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label for="lead-email" class="block text-sm font-medium text-brand-navy">Email</label>
                                <input
                                    id="lead-email"
                                    v-model="form.email"
                                    type="email"
                                    autocomplete="email"
                                    required
                                    class="mt-1 w-full rounded-lg border border-brand-navy/15 px-3 py-2 text-brand-navy shadow-sm focus:border-brand-turquoise focus:outline-none focus:ring-2 focus:ring-brand-turquoise/30"
                                >
                                <p v-if="errors.email" class="mt-1 text-xs text-red-600">{{ errors.email[0] }}</p>
                            </div>
                            <div>
                                <label for="lead-phone" class="block text-sm font-medium text-brand-navy">Phone <span class="font-normal text-brand-body/70">(optional)</span></label>
                                <input
                                    id="lead-phone"
                                    v-model="form.phone"
                                    type="tel"
                                    autocomplete="tel"
                                    class="mt-1 w-full rounded-lg border border-brand-navy/15 px-3 py-2 text-brand-navy shadow-sm focus:border-brand-turquoise focus:outline-none focus:ring-2 focus:ring-brand-turquoise/30"
                                >
                                <p v-if="errors.phone" class="mt-1 text-xs text-red-600">{{ errors.phone[0] }}</p>
                            </div>
                        </div>
                        <div>
                            <label for="lead-address" class="block text-sm font-medium text-brand-navy">Service address <span class="font-normal text-brand-body/70">(optional)</span></label>
                            <textarea
                                id="lead-address"
                                v-model="form.address"
                                rows="2"
                                autocomplete="street-address"
                                class="mt-1 w-full rounded-lg border border-brand-navy/15 px-3 py-2 text-brand-navy shadow-sm focus:border-brand-turquoise focus:outline-none focus:ring-2 focus:ring-brand-turquoise/30"
                                placeholder="123 Main St, Miami FL 33101"
                            />
                            <p v-if="errors.address" class="mt-1 text-xs text-red-600">{{ errors.address[0] }}</p>
                        </div>
                        <div>
                            <label for="lead-service" class="block text-sm font-medium text-brand-navy">Service interest</label>
                            <select
                                id="lead-service"
                                v-model="form.service_type"
                                class="mt-1 w-full rounded-lg border border-brand-navy/15 px-3 py-2 text-brand-navy shadow-sm focus:border-brand-turquoise focus:outline-none focus:ring-2 focus:ring-brand-turquoise/30"
                            >
                                <option value="">{{ catalogLoading ? 'Loading services…' : 'Select…' }}</option>
                                <option
                                    v-for="s in catalogServices"
                                    :key="s.id"
                                    :value="s.name"
                                >
                                    {{ s.name }}
                                </option>
                                <option value="Other / not sure">Other / not sure</option>
                            </select>
                            <p v-if="errors.service_type" class="mt-1 text-xs text-red-600">{{ errors.service_type[0] }}</p>
                        </div>
                        <div>
                            <label for="lead-message" class="block text-sm font-medium text-brand-navy">Notes <span class="font-normal text-brand-body/70">(optional)</span></label>
                            <textarea
                                id="lead-message"
                                v-model="form.message"
                                rows="3"
                                class="mt-1 w-full rounded-lg border border-brand-navy/15 px-3 py-2 text-brand-navy shadow-sm focus:border-brand-turquoise focus:outline-none focus:ring-2 focus:ring-brand-turquoise/30"
                                placeholder="Home size, pets, best time to call…"
                            />
                            <p v-if="errors.message" class="mt-1 text-xs text-red-600">{{ errors.message[0] }}</p>
                        </div>
                        <motion.button
                            type="submit"
                            class="w-full rounded-full bg-brand-fuchsia py-3 text-sm font-semibold text-white shadow-md transition hover:bg-brand-fuchsia-dark disabled:cursor-not-allowed disabled:opacity-60"
                            :disabled="submitting"
                            :whileHover="!submitting ? { scale: 1.02 } : undefined"
                            :whileTap="!submitting ? { scale: 0.97 } : undefined"
                            :transition="{ type: 'spring', stiffness: 450, damping: 18 }"
                        >
                            {{ submitting ? 'Sending…' : 'Send request' }}
                        </motion.button>
                        <p class="text-center text-xs text-brand-body">
                            By submitting, you agree to be contacted about Damas Cleaning services and accept our
                            <a href="/privacy-policy" target="_blank" class="underline hover:text-brand-navy">Privacy Policy</a>
                            and
                            <a href="/terms-of-service" target="_blank" class="underline hover:text-brand-navy">Terms of Service</a>.
                        </p>
                    </form>
                </motion.div>
            </div>
        </div>
    </section>
</template>
