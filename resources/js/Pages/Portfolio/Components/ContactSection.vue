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
    Sparkles,
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
    <section id="contact" class="py-24 relative overflow-hidden bg-slate-100/50 dark:bg-slate-900/40 border-t border-slate-200/80 dark:border-slate-800/80">
        
        <!-- Ambient Background Glow -->
        <div class="absolute bottom-0 right-1/4 w-[500px] h-[300px] bg-indigo-500/10 rounded-full blur-[140px] pointer-events-none -z-10"></div>
        <div class="absolute top-1/3 left-0 w-[400px] h-[300px] bg-cyan-500/10 rounded-full blur-[140px] pointer-events-none -z-10"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Section Header -->
            <div class="text-center max-w-3xl mx-auto space-y-3 mb-16">
                <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 dark:text-emerald-400 text-xs font-mono font-semibold uppercase tracking-wider">
                    <MessageSquare class="w-3.5 h-3.5" />
                    <span>Let's Connect</span>
                </div>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                    Have an Idea or Project in Mind? Let's Talk!
                </h2>
                <p class="text-base sm:text-lg text-slate-600 dark:text-slate-400">
                    Whether you have an inquiry, freelance project, or full-time opportunity, my inbox is always open.
                </p>
            </div>

            <!-- 2-Column Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                
                <!-- Left Column: Contact Cards & Info -->
                <div class="lg:col-span-5 space-y-6">
                    <div class="p-8 rounded-3xl bg-white dark:bg-[#0B0F17] border border-slate-200 dark:border-slate-800 shadow-xl space-y-6">
                        <div class="space-y-2">
                            <h3 class="text-2xl font-bold text-slate-900 dark:text-white">
                                Contact Information
                            </h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400">
                                Reach out directly through any of these communication channels:
                            </p>
                        </div>

                        <!-- Info Items -->
                        <div class="space-y-4">
                            <!-- Email Item -->
                            <div class="flex items-center justify-between p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200/80 dark:border-slate-800/80 group">
                                <div class="flex items-center gap-3.5">
                                    <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-500 flex items-center justify-center shrink-0">
                                        <Mail class="w-5 h-5" />
                                    </div>
                                    <div>
                                        <span class="text-xs font-mono text-slate-400 block">Email Address</span>
                                        <a :href="'mailto:' + (profile.email || 'ikbal@email.com')" class="text-sm font-semibold text-slate-800 dark:text-slate-200 hover:text-indigo-500 transition-colors">
                                            {{ profile.email || 'ikbal@email.com' }}
                                        </a>
                                    </div>
                                </div>
                                <button 
                                    @click="copyEmail" 
                                    type="button"
                                    class="p-2 rounded-lg text-slate-400 hover:text-indigo-500 hover:bg-white dark:hover:bg-slate-800 transition-colors"
                                    :title="isCopied ? 'Copied!' : 'Copy to clipboard'"
                                >
                                    <Check v-if="isCopied" class="w-4 h-4 text-emerald-500" />
                                    <Copy v-else class="w-4 h-4" />
                                </button>
                            </div>

                            <!-- Phone / WhatsApp Item -->
                            <div class="flex items-center justify-between p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200/80 dark:border-slate-800/80">
                                <div class="flex items-center gap-3.5">
                                    <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-500 flex items-center justify-center shrink-0">
                                        <Phone class="w-5 h-5" />
                                    </div>
                                    <div>
                                        <span class="text-xs font-mono text-slate-400 block">Phone / WhatsApp</span>
                                        <a :href="'https://wa.me/' + (profile.phone || '').replace(/[^0-9]/g, '')" target="_blank" rel="noopener noreferrer" class="text-sm font-semibold text-slate-800 dark:text-slate-200 hover:text-emerald-500 transition-colors">
                                            {{ profile.phone || '+62 812 3456 7890' }}
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Location Item -->
                            <div class="flex items-center p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200/80 dark:border-slate-800/80">
                                <div class="flex items-center gap-3.5">
                                    <div class="w-10 h-10 rounded-xl bg-cyan-50 dark:bg-cyan-950/60 text-cyan-500 flex items-center justify-center shrink-0">
                                        <MapPin class="w-5 h-5" />
                                    </div>
                                    <div>
                                        <span class="text-xs font-mono text-slate-400 block">Current Location</span>
                                        <span class="text-sm font-semibold text-slate-800 dark:text-slate-200">
                                            {{ profile.location || 'Indonesia' }} (GMT+8)
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Response Time Notice -->
                        <div class="flex items-center gap-2.5 p-3.5 rounded-xl bg-indigo-50/70 dark:bg-indigo-950/30 border border-indigo-200/50 dark:border-indigo-800/40 text-xs font-mono text-indigo-700 dark:text-indigo-300">
                            <Clock class="w-4 h-4 shrink-0" />
                            <span>Average response time: within 24 hours</span>
                        </div>

                    </div>
                </div>

                <!-- Right Column: Interactive Form -->
                <div class="lg:col-span-7">
                    <div class="p-8 sm:p-10 rounded-3xl bg-white dark:bg-[#0B0F17] border border-slate-200 dark:border-slate-800 shadow-xl space-y-6">
                        
                        <div class="space-y-1">
                            <h3 class="text-2xl font-bold text-slate-900 dark:text-white">
                                Send a Message
                            </h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400">
                                Fill out the form below and I'll get back to you promptly.
                            </p>
                        </div>

                        <!-- Success Alert Banner -->
                        <transition
                            enter-active-class="transition duration-300 ease-out"
                            enter-from-class="opacity-0 -translate-y-2"
                            enter-to-class="opacity-100 translate-y-0"
                            leave-active-class="transition duration-200 ease-in"
                            leave-from-class="opacity-100 translate-y-0"
                            leave-to-class="opacity-0 -translate-y-2"
                        >
                            <div 
                                v-if="formSubmitted || $page.props.flash?.success"
                                class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-700 dark:text-emerald-300 flex items-start gap-3"
                            >
                                <CheckCircle2 class="w-5 h-5 shrink-0 text-emerald-500 mt-0.5" />
                                <div class="text-sm">
                                    <p class="font-bold">Message sent successfully!</p>
                                    <p class="text-xs text-emerald-600 dark:text-emerald-400 mt-0.5">
                                        {{ $page.props.flash?.success || 'Thank you! Your message has been received and will be answered shortly.' }}
                                    </p>
                                </div>
                            </div>
                        </transition>

                        <!-- Form -->
                        <form @submit.prevent="submitContact" class="space-y-5">
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <!-- Name -->
                                <div class="space-y-2">
                                    <label class="block text-xs font-mono uppercase tracking-wider text-slate-600 dark:text-slate-300 font-semibold">
                                        Your Name <span class="text-rose-500">*</span>
                                    </label>
                                    <input 
                                        v-model="form.name"
                                        type="text" 
                                        required
                                        placeholder="e.g. Alexandre Dubois"
                                        class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white placeholder-slate-400 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all outline-none"
                                        :class="{ 'border-rose-500': form.errors.name }"
                                    />
                                    <p v-if="form.errors.name" class="text-xs text-rose-500 flex items-center gap-1">
                                        <AlertCircle class="w-3.5 h-3.5" />
                                        {{ form.errors.name }}
                                    </p>
                                </div>

                                <!-- Email -->
                                <div class="space-y-2">
                                    <label class="block text-xs font-mono uppercase tracking-wider text-slate-600 dark:text-slate-300 font-semibold">
                                        Your Email <span class="text-rose-500">*</span>
                                    </label>
                                    <input 
                                        v-model="form.email"
                                        type="email" 
                                        required
                                        placeholder="e.g. alex@company.com"
                                        class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white placeholder-slate-400 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all outline-none"
                                        :class="{ 'border-rose-500': form.errors.email }"
                                    />
                                    <p v-if="form.errors.email" class="text-xs text-rose-500 flex items-center gap-1">
                                        <AlertCircle class="w-3.5 h-3.5" />
                                        {{ form.errors.email }}
                                    </p>
                                </div>
                            </div>

                            <!-- Subject -->
                            <div class="space-y-2">
                                <label class="block text-xs font-mono uppercase tracking-wider text-slate-600 dark:text-slate-300 font-semibold">
                                    Subject / Topic
                                </label>
                                <input 
                                    v-model="form.subject"
                                    type="text" 
                                    placeholder="e.g. Full-Stack Project Collaboration"
                                    class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white placeholder-slate-400 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all outline-none"
                                    :class="{ 'border-rose-500': form.errors.subject }"
                                />
                                <p v-if="form.errors.subject" class="text-xs text-rose-500 flex items-center gap-1">
                                    <AlertCircle class="w-3.5 h-3.5" />
                                    {{ form.errors.subject }}
                                </p>
                            </div>

                            <!-- Message -->
                            <div class="space-y-2">
                                <label class="block text-xs font-mono uppercase tracking-wider text-slate-600 dark:text-slate-300 font-semibold">
                                    Message <span class="text-rose-500">*</span>
                                </label>
                                <textarea 
                                    v-model="form.message"
                                    rows="5" 
                                    required
                                    placeholder="Tell me about your project, timeline, and requirements..."
                                    class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white placeholder-slate-400 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all outline-none resize-y"
                                    :class="{ 'border-rose-500': form.errors.message }"
                                ></textarea>
                                <p v-if="form.errors.message" class="text-xs text-rose-500 flex items-center gap-1">
                                    <AlertCircle class="w-3.5 h-3.5" />
                                    {{ form.errors.message }}
                                </p>
                            </div>

                            <!-- Submit Button -->
                            <button 
                                type="submit"
                                :disabled="form.processing"
                                class="w-full py-4 rounded-xl text-sm sm:text-base font-semibold text-white bg-gradient-to-r from-indigo-600 via-indigo-500 to-cyan-500 shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 hover:opacity-95 active:scale-[0.99] disabled:opacity-50 disabled:cursor-not-allowed transition-all flex items-center justify-center gap-2"
                            >
                                <Loader2 v-if="form.processing" class="w-5 h-5 animate-spin" />
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
