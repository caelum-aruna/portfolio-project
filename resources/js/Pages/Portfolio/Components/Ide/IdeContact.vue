<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { 
    Terminal, 
    Send, 
    CheckCircle2, 
    AlertCircle, 
    Mail, 
    MapPin, 
    Phone, 
    Copy, 
    Check, 
    CornerDownLeft 
} from 'lucide-vue-next';

const props = defineProps({
    profile: {
        type: Object,
        default: () => ({}),
    },
    viewMode: {
        type: String,
        default: 'preview',
    },
});

const page = usePage();
const flashSuccess = computed(() => page.props.flash?.success);
const codeCopied = ref(false);

const form = useForm({
    name: '',
    email: '',
    subject: '',
    message: '',
});

const submitMessage = () => {
    form.post('/contact', {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
    });
};

const bashScriptContent = `#!/usr/bin/env bash
# ====================================================================
# Ikbal Muhammad - Message Dispatch Daemon
# Endpoint: https://ikbal.dev/contact
# ====================================================================

set -euo pipefail

echo "==> Initializing message gateway for Ikbal Muhammad..."
read -p "Enter sender name: " SENDER_NAME
read -p "Enter sender email: " SENDER_EMAIL
read -p "Enter inquiry subject: " SUBJECT
read -p "Enter message body: " MESSAGE_BODY

curl -X POST https://ikbal.dev/contact \\
  -H "Content-Type: application/json" \\
  -H "Accept: application/json" \\
  -d '{
    "name": "'"\$SENDER_NAME"'",
    "email": "'"\$SENDER_EMAIL"'",
    "subject": "'"\$SUBJECT"'",
    "message": "'"\$MESSAGE_BODY"'"
  }'

echo "==> Status 200 OK: Message dispatched successfully."
exit 0
`;

const copyCode = () => {
    navigator.clipboard.writeText(bashScriptContent);
    codeCopied.value = true;
    setTimeout(() => {
        codeCopied.value = false;
    }, 2000);
};
</script>

<template>
    <div class="flex-1 h-full overflow-y-auto bg-white dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 flex">
        
        <!-- ================= MODE 1: VISUAL PREVIEW ================= -->
        <div v-if="viewMode === 'preview'" class="w-full p-4 sm:p-8 max-w-4xl mx-auto space-y-8 font-sans">
            
            <!-- Terminal Header Banner -->
            <div class="border border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-900 rounded-xl p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <div class="flex items-center space-x-2 text-xs font-mono text-sky-600 dark:text-sky-400 uppercase tracking-wider mb-1">
                        <Terminal class="w-4 h-4" />
                        <span>Interactive Bash Dispatch</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold font-heading text-zinc-900 dark:text-white">
                        Contact.sh (Terminal Gateway)
                    </h1>
                </div>

                <div class="flex items-center space-x-2 text-xs font-mono text-zinc-600 dark:text-zinc-400 bg-white dark:bg-zinc-950 px-3 py-1.5 rounded-lg border border-zinc-200 dark:border-zinc-800 shrink-0">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 dark:bg-emerald-400 animate-ping"></span>
                    <span>Direct Delivery to Inbox</span>
                </div>
            </div>

            <!-- Main Terminal Frame -->
            <div class="bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl overflow-hidden shadow-2xl font-mono text-xs">
                
                <!-- Terminal Window Bar -->
                <div class="h-9 px-4 bg-white dark:bg-zinc-950 border-b border-zinc-200 dark:border-zinc-800 flex items-center justify-between select-none">
                    <div class="flex items-center space-x-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span>
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                    </div>
                    <div class="text-zinc-500 text-[11px] truncate">
                        bash - guest@portfolio-server: ~/contact.sh
                    </div>
                    <div class="text-zinc-500 text-[11px]">
                        utf-8
                    </div>
                </div>

                <!-- Terminal Body -->
                <div class="p-6 space-y-6">
                    <!-- Terminal Prompt Intro -->
                    <div class="space-y-1 text-zinc-600 dark:text-zinc-400">
                        <p class="text-emerald-600 dark:text-emerald-400">guest@ikbal-server:~$ <span class="text-zinc-900 dark:text-white">./contact.sh --recipient="Ikbal Muhammad"</span></p>
                        <p class="text-zinc-500 text-[11px] font-sans">
                            Fill out the required arguments below to trigger the backend message delivery pipeline.
                        </p>
                    </div>

                    <!-- Success Alert -->
                    <div 
                        v-if="form.wasSuccessful || flashSuccess" 
                        class="p-4 rounded-lg bg-emerald-50 dark:bg-emerald-950/80 border border-emerald-200 dark:border-emerald-600/60 text-emerald-800 dark:text-emerald-300 font-sans text-xs space-y-1"
                    >
                        <div class="flex items-center space-x-2 font-bold text-sm">
                            <CheckCircle2 class="w-4 h-4 text-emerald-600 dark:text-emerald-400" />
                            <span>Process Completed Successfully [200 OK]</span>
                        </div>
                        <p class="text-emerald-700 dark:text-emerald-200/90 font-mono text-[11px]">
                            {{ flashSuccess || 'Pesan Anda berhasil dikirim! Saya akan segera merespons ke email Anda.' }}
                        </p>
                    </div>

                    <!-- Interactive Form -->
                    <form @submit.prevent="submitMessage" class="space-y-5 font-sans">
                        
                        <!-- Row 1: Name and Email -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Name -->
                            <div class="space-y-1.5">
                                <label for="name" class="block text-xs font-mono font-medium text-zinc-700 dark:text-zinc-300">
                                    --name <span class="text-rose-500 dark:text-rose-400">*</span>
                                </label>
                                <input
                                    id="name"
                                    v-model="form.name"
                                    type="text"
                                    placeholder="John Doe"
                                    required
                                    :class="[
                                        'w-full px-3.5 py-2.5 rounded-lg bg-white dark:bg-zinc-950 border text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 dark:placeholder-zinc-600 text-xs focus:ring-1 focus:ring-indigo-500 focus:outline-none transition-colors font-mono',
                                        form.errors.name ? 'border-rose-500' : 'border-zinc-300 dark:border-zinc-800'
                                    ]"
                                />
                                <div v-if="form.errors.name" class="text-rose-500 dark:text-rose-400 text-[11px] font-mono">
                                    {{ form.errors.name }}
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="space-y-1.5">
                                <label for="email" class="block text-xs font-mono font-medium text-zinc-700 dark:text-zinc-300">
                                    --email <span class="text-rose-500 dark:text-rose-400">*</span>
                                </label>
                                <input
                                    id="email"
                                    v-model="form.email"
                                    type="email"
                                    placeholder="john@example.com"
                                    required
                                    :class="[
                                        'w-full px-3.5 py-2.5 rounded-lg bg-white dark:bg-zinc-950 border text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 dark:placeholder-zinc-600 text-xs focus:ring-1 focus:ring-indigo-500 focus:outline-none transition-colors font-mono',
                                        form.errors.email ? 'border-rose-500' : 'border-zinc-300 dark:border-zinc-800'
                                    ]"
                                />
                                <div v-if="form.errors.email" class="text-rose-500 dark:text-rose-400 text-[11px] font-mono">
                                    {{ form.errors.email }}
                                </div>
                            </div>
                        </div>

                        <!-- Subject -->
                        <div class="space-y-1.5">
                            <label for="subject" class="block text-xs font-mono font-medium text-zinc-700 dark:text-zinc-300">
                                --subject <span class="text-zinc-500">(optional)</span>
                            </label>
                            <input
                                id="subject"
                                v-model="form.subject"
                                type="text"
                                placeholder="New Project Collaboration / Full-time Role"
                                :class="[
                                    'w-full px-3.5 py-2.5 rounded-lg bg-white dark:bg-zinc-950 border text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 dark:placeholder-zinc-600 text-xs focus:ring-1 focus:ring-indigo-500 focus:outline-none transition-colors font-mono',
                                    form.errors.subject ? 'border-rose-500' : 'border-zinc-300 dark:border-zinc-800'
                                ]"
                            />
                            <div v-if="form.errors.subject" class="text-rose-500 dark:text-rose-400 text-[11px] font-mono">
                                {{ form.errors.subject }}
                            </div>
                        </div>

                        <!-- Message -->
                        <div class="space-y-1.5">
                            <label for="message" class="block text-xs font-mono font-medium text-zinc-700 dark:text-zinc-300">
                                --message <span class="text-rose-500 dark:text-rose-400">*</span>
                            </label>
                            <textarea
                                id="message"
                                v-model="form.message"
                                rows="5"
                                placeholder="Hi Ikbal, I came across your portfolio and would like to discuss..."
                                required
                                :class="[
                                    'w-full px-3.5 py-2.5 rounded-lg bg-white dark:bg-zinc-950 border text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 dark:placeholder-zinc-600 text-xs focus:ring-1 focus:ring-indigo-500 focus:outline-none transition-colors font-mono resize-none leading-relaxed',
                                    form.errors.message ? 'border-rose-500' : 'border-zinc-300 dark:border-zinc-800'
                                ]"
                            ></textarea>
                            <div v-if="form.errors.message" class="text-rose-500 dark:text-rose-400 text-[11px] font-mono">
                                {{ form.errors.message }}
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-between pt-2">
                            <div class="text-[11px] text-zinc-500 font-mono hidden sm:block">
                                press [ENTER] to execute
                            </div>

                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="inline-flex items-center space-x-2 px-6 py-2.5 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-xs font-mono transition-all disabled:opacity-50 shadow-sm"
                            >
                                <Send v-if="!form.processing" class="w-3.5 h-3.5" />
                                <span>{{ form.processing ? 'Executing dispatch...' : 'Execute: Send Message' }}</span>
                                <CornerDownLeft class="w-3 h-3 ml-1" />
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Alternative Quick Channels -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 font-mono text-xs">
                <div class="bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-4 space-y-1">
                    <div class="text-zinc-500 text-[10px] uppercase">DIRECT_EMAIL</div>
                    <div class="text-indigo-600 dark:text-indigo-400 font-semibold truncate">{{ profile.email || 'ikbal@email.com' }}</div>
                </div>

                <div class="bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-4 space-y-1">
                    <div class="text-zinc-500 text-[10px] uppercase">LOCATION</div>
                    <div class="text-zinc-800 dark:text-zinc-200 font-semibold">{{ profile.location || 'Indonesia' }}</div>
                </div>

                <div class="bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-4 space-y-1">
                    <div class="text-zinc-500 text-[10px] uppercase">AVAILABILITY</div>
                    <div class="text-emerald-600 dark:text-emerald-400 font-semibold">Immediate / Open</div>
                </div>
            </div>

        </div>

        <!-- ================= MODE 2: SOURCE CODE VIEW ================= -->
        <div v-else class="w-full flex font-mono text-xs overflow-x-auto bg-white dark:bg-zinc-950">
            <!-- Line Numbers Gutter -->
            <div class="w-12 py-4 select-none text-right pr-4 text-zinc-400 dark:text-zinc-600 bg-zinc-50 dark:bg-zinc-950 border-r border-zinc-200 dark:border-zinc-800 shrink-0 space-y-1">
                <div v-for="n in 30" :key="n">{{ n }}</div>
            </div>

            <!-- Code Content -->
            <div class="flex-1 p-4 relative text-zinc-800 dark:text-zinc-300">
                <button
                    @click="copyCode"
                    class="absolute top-4 right-4 flex items-center space-x-1 px-2.5 py-1 rounded bg-zinc-100 dark:bg-zinc-800 hover:bg-zinc-200 dark:hover:bg-zinc-700 text-zinc-700 dark:text-zinc-300 text-xs border border-zinc-300 dark:border-zinc-700"
                >
                    <Check v-if="codeCopied" class="w-3.5 h-3.5 text-emerald-500 dark:text-emerald-400" />
                    <Copy v-else class="w-3.5 h-3.5" />
                    <span>{{ codeCopied ? 'Copied' : 'Copy Script' }}</span>
                </button>

                <pre class="leading-relaxed whitespace-pre font-mono text-sky-700 dark:text-sky-300"><code>{{ bashScriptContent }}</code></pre>
            </div>
        </div>

    </div>
</template>
