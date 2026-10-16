<script setup>
import { ref } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { 
    Mail, 
    Send, 
    Phone, 
    MapPin, 
    MessageSquare, 
    CheckCircle2, 
    AlertCircle, 
    Copy, 
    Check, 
    Clock, 
    Loader2
} from 'lucide-vue-next';

const props = defineProps({
    profile: {
        type: Object,
        required: true,
    },
});

const isCopied = ref(false);
const formSubmitted = ref(false);

const form = useForm({
    name: '',
    email: '',
    subject: '',
    message: '',
});

const submitContact = () => {
    form.post(route('portfolio.contact'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            formSubmitted.value = true;
            setTimeout(() => {
                formSubmitted.value = false;
            }, 6000);
        },
    });
};

const copyEmail = () => {
    if (props.profile.email) {
        navigator.clipboard.writeText(props.profile.email);
        isCopied.value = true;
        setTimeout(() => {
            isCopied.value = false;
        }, 2500);
    }
};
</script>

<template>
    <section id="contact" class="py-24 relative bg-zinc-50 dark:bg-zinc-900/50 border-t border-zinc-200 dark:border-zinc-800/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Section Header -->
            <div class="text-center max-w-3xl mx-auto space-y-3 mb-16">
                <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-zinc-100 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 text-zinc-800 dark:text-zinc-200 text-xs font-mono font-semibold uppercase tracking-wider">
                    <MessageSquare class="w-3.5 h-3.5 text-indigo-600 dark:text-indigo-400" />
                    <span>Let's Connect</span>
                </div>
                <h2 class="font-heading text-3xl sm:text-4xl lg:text-5xl font-extrabold text-zinc-900 dark:text-white tracking-tight">
                    Have an Idea or Project in Mind? Let's Talk!
                </h2>
                <p class="font-sans text-base sm:text-lg text-zinc-600 dark:text-zinc-400">
                    Whether you have an inquiry, freelance project, or full-time opportunity, my inbox is always open.
                </p>
            </div>

            <!-- 2-Column Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
                
                <!-- Left Column: Contact Cards & Info -->
                <div class="lg:col-span-5 space-y-6">
                    <div class="p-8 rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-sm space-y-6">
                        <div class="space-y-1.5">
                            <h3 class="font-heading text-xl sm:text-2xl font-bold text-zinc-900 dark:text-white">
                                Contact Information
                            </h3>
                            <p class="font-sans text-sm text-zinc-600 dark:text-zinc-400">
                                Reach out directly through any of these communication channels:
                            </p>
                        </div>

                        <!-- Info Items -->
                        <div class="space-y-3">
                            <!-- Email Item -->
                            <div class="flex items-center justify-between p-4 rounded-xl bg-zinc-50 dark:bg-zinc-800/50 border border-zinc-200 dark:border-zinc-700/60">
                                <div class="flex items-center gap-3.5">
                                    <div class="w-9 h-9 rounded-lg bg-zinc-200/80 dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200 flex items-center justify-center shrink-0">
                                        <Mail class="w-4 h-4 text-indigo-600 dark:text-indigo-400" />
                                    </div>
                                    <div>
                                        <span class="text-[11px] font-mono text-zinc-400 block">Email Address</span>
                                        <a :href="'mailto:' + (profile.email || 'ikbal@email.com')" class="text-sm font-semibold font-sans text-zinc-800 dark:text-zinc-200 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                                            {{ profile.email || 'ikbal@email.com' }}
                                        </a>
                                    </div>
                                </div>
                                <button 
                                    @click="copyEmail" 
                                    type="button"
                                    class="p-2 rounded-lg text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-200 transition-colors"
                                    :title="isCopied ? 'Copied!' : 'Copy to clipboard'"
                                >
                                    <Check v-if="isCopied" class="w-4 h-4 text-emerald-500" />
                                    <Copy v-else class="w-4 h-4" />
                                </button>
                            </div>

                            <!-- Phone / WhatsApp Item -->
                            <div class="flex items-center justify-between p-4 rounded-xl bg-zinc-50 dark:bg-zinc-800/50 border border-zinc-200 dark:border-zinc-700/60">
                                <div class="flex items-center gap-3.5">
                                    <div class="w-9 h-9 rounded-lg bg-zinc-200/80 dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200 flex items-center justify-center shrink-0">
                                        <Phone class="w-4 h-4 text-emerald-500" />
                                    </div>
                                    <div>
                                        <span class="text-[11px] font-mono text-zinc-400 block">Phone / WhatsApp</span>
                                        <a :href="'https://wa.me/' + (profile.phone || '').replace(/[^0-9]/g, '')" target="_blank" rel="noopener noreferrer" class="text-sm font-semibold font-sans text-zinc-800 dark:text-zinc-200 hover:text-emerald-500 transition-colors">
                                            {{ profile.phone || '+62 812 3456 7890' }}
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Location Item -->
                            <div class="flex items-center p-4 rounded-xl bg-zinc-50 dark:bg-zinc-800/50 border border-zinc-200 dark:border-zinc-700/60">
                                <div class="flex items-center gap-3.5">
                                    <div class="w-9 h-9 rounded-lg bg-zinc-200/80 dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200 flex items-center justify-center shrink-0">
                                        <MapPin class="w-4 h-4 text-indigo-500" />
                                    </div>
                                    <div>
                                        <span class="text-[11px] font-mono text-zinc-400 block">Current Location</span>
                                        <span class="text-sm font-semibold font-sans text-zinc-800 dark:text-zinc-200">
                                            {{ profile.location || 'Indonesia' }} (GMT+8)
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Response Time Notice -->
                        <div class="flex items-center gap-2 p-3 rounded-lg bg-zinc-100 dark:bg-zinc-800 text-xs font-mono text-zinc-600 dark:text-zinc-300 border border-zinc-200 dark:border-zinc-700">
                            <Clock class="w-3.5 h-3.5 shrink-0 text-indigo-500" />
                            <span>Average response time: within 24 hours</span>
                        </div>

                    </div>
                </div>

                <!-- Right Column: Interactive Form -->
                <div class="lg:col-span-7">
                    <div class="p-8 sm:p-10 rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-sm space-y-6">
                        
                        <div class="space-y-1">
                            <h3 class="font-heading text-xl sm:text-2xl font-bold text-zinc-900 dark:text-white">
                                Send a Message
                            </h3>
                            <p class="font-sans text-sm text-zinc-600 dark:text-zinc-400">
                                Fill out the form below and I'll get back to you promptly.
                            </p>
                        </div>

                        <!-- Success Alert Banner -->
                        <div 
                            v-if="formSubmitted || $page.props.flash?.success"
                            class="p-4 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-300 dark:border-emerald-800 text-emerald-800 dark:text-emerald-200 flex items-start gap-3"
                        >
                            <CheckCircle2 class="w-5 h-5 shrink-0 text-emerald-600 dark:text-emerald-400 mt-0.5" />
                            <div class="text-sm font-sans">
                                <p class="font-bold">Message sent successfully!</p>
                                <p class="text-xs text-emerald-700 dark:text-emerald-300 mt-0.5">
                                    {{ $page.props.flash?.success || 'Thank you! Your message has been received and will be answered shortly.' }}
                                </p>
                            </div>
                        </div>

                        <!-- Form -->
                        <form @submit.prevent="submitContact" class="space-y-4">
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Name -->
                                <div class="space-y-1.5">
                                    <label class="block text-xs font-mono uppercase tracking-wider text-zinc-600 dark:text-zinc-300 font-semibold">
                                        Your Name <span class="text-rose-500">*</span>
                                    </label>
                                    <input 
                                        v-model="form.name"
                                        type="text" 
                                        required
                                        placeholder="e.g. Alexandre Dubois"
                                        class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 text-zinc-900 dark:text-white placeholder-zinc-400 text-sm focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600 transition-colors outline-none font-sans"
                                        :class="{ 'border-rose-500': form.errors.name }"
                                    />
                                    <p v-if="form.errors.name" class="text-xs text-rose-500 flex items-center gap-1 font-sans">
                                        <AlertCircle class="w-3.5 h-3.5" />
                                        {{ form.errors.name }}
                                    </p>
                                </div>

                                <!-- Email -->
                                <div class="space-y-1.5">
                                    <label class="block text-xs font-mono uppercase tracking-wider text-zinc-600 dark:text-zinc-300 font-semibold">
                                        Your Email <span class="text-rose-500">*</span>
                                    </label>
                                    <input 
                                        v-model="form.email"
                                        type="email" 
                                        required
                                        placeholder="e.g. alex@company.com"
                                        class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 text-zinc-900 dark:text-white placeholder-zinc-400 text-sm focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600 transition-colors outline-none font-sans"
                                        :class="{ 'border-rose-500': form.errors.email }"
                                    />
                                    <p v-if="form.errors.email" class="text-xs text-rose-500 flex items-center gap-1 font-sans">
                                        <AlertCircle class="w-3.5 h-3.5" />
                                        {{ form.errors.email }}
                                    </p>
                                </div>
                            </div>

                            <!-- Subject -->
                            <div class="space-y-1.5">
                                <label class="block text-xs font-mono uppercase tracking-wider text-zinc-600 dark:text-zinc-300 font-semibold">
                                    Subject / Topic
                                </label>
                                <input 
                                    v-model="form.subject"
                                    type="text" 
                                    placeholder="e.g. Full-Stack Project Collaboration"
                                    class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 text-zinc-900 dark:text-white placeholder-zinc-400 text-sm focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600 transition-colors outline-none font-sans"
                                    :class="{ 'border-rose-500': form.errors.subject }"
                                />
                                <p v-if="form.errors.subject" class="text-xs text-rose-500 flex items-center gap-1 font-sans">
                                    <AlertCircle class="w-3.5 h-3.5" />
                                    {{ form.errors.subject }}
                                </p>
                            </div>

                            <!-- Message -->
                            <div class="space-y-1.5">
                                <label class="block text-xs font-mono uppercase tracking-wider text-zinc-600 dark:text-zinc-300 font-semibold">
                                    Message <span class="text-rose-500">*</span>
                                </label>
                                <textarea 
                                    v-model="form.message"
                                    rows="4" 
                                    required
                                    placeholder="Tell me about your project, timeline, and requirements..."
                                    class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 text-zinc-900 dark:text-white placeholder-zinc-400 text-sm focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600 transition-colors outline-none font-sans resize-y"
                                    :class="{ 'border-rose-500': form.errors.message }"
                                ></textarea>
                                <p v-if="form.errors.message" class="text-xs text-rose-500 flex items-center gap-1 font-sans">
                                    <AlertCircle class="w-3.5 h-3.5" />
                                    {{ form.errors.message }}
                                </p>
                            </div>

                            <!-- Solid High-Contrast Submit Button -->
                            <button 
                                type="submit"
                                :disabled="form.processing"
                                class="w-full py-3.5 rounded-xl text-sm font-semibold font-sans text-white bg-zinc-900 hover:bg-zinc-800 dark:bg-white dark:text-zinc-900 dark:hover:bg-zinc-100 shadow-sm disabled:opacity-50 disabled:cursor-not-allowed transition-colors flex items-center justify-center gap-2 active:scale-95"
                            >
                                <Loader2 v-if="form.processing" class="w-4 h-4 animate-spin" />
                                <Send v-else class="w-4 h-4" />
                                <span>{{ form.processing ? 'Sending Message...' : 'Send Message' }}</span>
                            </button>

                        </form>

                    </div>
                </div>

            </div>

        </div>
    </section>
</template>
