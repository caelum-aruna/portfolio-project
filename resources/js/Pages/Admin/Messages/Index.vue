<script setup>
import { ref, computed } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { 
    Mail, 
    Trash2, 
    Check, 
    Reply, 
    Clock, 
    User,
    CheckCircle2,
    Inbox
} from 'lucide-vue-next';

const props = defineProps({
    messages: {
        type: Array,
        required: true,
    },
});

const activeFilter = ref('all'); // all, unread

const filteredMessages = computed(() => {
    if (activeFilter.value === 'unread') {
        return props.messages.filter(m => !m.is_read);
    }
    return props.messages;
});

const unreadCount = computed(() => {
    return props.messages.filter(m => !m.is_read).length;
});

const toggleRead = (msg) => {
    router.patch(route('admin.messages.toggle', msg.id), {}, {
        preserveScroll: true,
    });
};

const deleteMessage = (msg) => {
    if (confirm(`Hapus pesan dari ${msg.name}?`)) {
        router.delete(route('admin.messages.destroy', msg.id), {
            preserveScroll: true,
        });
    }
};

const formatDate = (dateStr) => {
    if (!dateStr) return '';
    const date = new Date(dateStr);
    return date.toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'short',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    });
};
</script>

<template>
    <Head title="Contact Inbox - Admin" />

    <AuthenticatedLayout>
        <template #header>
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                    Visitor Contact Inbox
                </h1>
                <p class="text-xs text-slate-500 dark:text-slate-400 font-mono mt-0.5">
                    Read and respond to inquiries submitted through your portfolio contact form.
                </p>
            </div>

            <!-- Filter Tabs -->
            <div class="flex items-center gap-2">
                <button 
                    @click="activeFilter = 'all'"
                    class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition-colors"
                    :class="[
                        activeFilter === 'all' 
                            ? 'bg-indigo-600 text-white shadow-sm' 
                            : 'bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700'
                    ]"
                >
                    All Messages ({{ messages.length }})
                </button>
                <button 
                    @click="activeFilter = 'unread'"
                    class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition-colors"
                    :class="[
                        activeFilter === 'unread' 
                            ? 'bg-indigo-600 text-white shadow-sm' 
                            : 'bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700'
                    ]"
                >
                    Unread ({{ unreadCount }})
                </button>
            </div>
        </template>

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
            
            <div v-if="filteredMessages.length === 0" class="py-16 text-center rounded-3xl bg-white dark:bg-[#0E131F] border border-slate-200 dark:border-slate-800">
                <Inbox class="w-12 h-12 mx-auto text-slate-400 mb-3" />
                <h3 class="text-base font-bold text-slate-900 dark:text-white">No messages found</h3>
                <p class="text-xs text-slate-500 mt-1">There are no messages matching your current filter.</p>
            </div>

            <div v-else class="space-y-4">
                <div 
                    v-for="msg in filteredMessages" 
                    :key="msg.id"
                    class="p-6 rounded-3xl bg-white dark:bg-[#0E131F] border shadow-sm transition-all space-y-4"
                    :class="[
                        msg.is_read 
                            ? 'border-slate-200 dark:border-slate-800' 
                            : 'border-indigo-500/50 shadow-indigo-500/5 dark:bg-slate-900/40'
                    ]"
                >
                    <!-- Header -->
                    <div class="flex flex-wrap items-start justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-500 flex items-center justify-center font-bold">
                                {{ msg.name.charAt(0) }}
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <h4 class="font-extrabold text-base text-slate-900 dark:text-white">{{ msg.name }}</h4>
                                    <span v-if="!msg.is_read" class="px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-indigo-500/10 text-indigo-500 border border-indigo-500/20">
                                        NEW
                                    </span>
                                </div>
                                <a :href="'mailto:' + msg.email" class="text-xs text-indigo-500 font-mono hover:underline block">
                                    {{ msg.email }}
                                </a>
                            </div>
                        </div>

                        <!-- Date -->
                        <span class="text-xs font-mono text-slate-400 flex items-center gap-1.5">
                            <Clock class="w-3.5 h-3.5" />
                            {{ formatDate(msg.created_at) }}
                        </span>
                    </div>

                    <!-- Subject & Body -->
                    <div class="space-y-1.5 p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-100 dark:border-slate-800/80">
                        <p v-if="msg.subject" class="text-xs font-mono font-bold uppercase tracking-wider text-slate-400">
                            Subject: <span class="text-slate-800 dark:text-slate-200 font-sans normal-case">{{ msg.subject }}</span>
                        </p>
                        <p class="text-sm text-slate-700 dark:text-slate-300 leading-relaxed whitespace-pre-line">
                            {{ msg.message }}
                        </p>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-between pt-1">
                        <button 
                            @click="toggleRead(msg)"
                            type="button"
                            class="text-xs font-semibold text-slate-500 hover:text-indigo-500 flex items-center gap-1.5 transition-colors"
                        >
                            <Check class="w-4 h-4 text-emerald-500" />
                            <span>{{ msg.is_read ? 'Mark as Unread' : 'Mark as Read' }}</span>
                        </button>

                        <div class="flex items-center gap-2">
                            <a 
                                :href="`mailto:${msg.email}?subject=Re: ${encodeURIComponent(msg.subject || 'Portfolio Inquiry')}`"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 border border-indigo-200/60 dark:border-indigo-800/60 hover:bg-indigo-100 transition-colors"
                            >
                                <Reply class="w-3.5 h-3.5" />
                                <span>Reply</span>
                            </a>
                            <button 
                                @click="deleteMessage(msg)"
                                type="button"
                                class="p-1.5 rounded-lg text-slate-400 hover:text-rose-500 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
                                title="Delete Message"
                            >
                                <Trash2 class="w-4 h-4" />
                            </button>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </AuthenticatedLayout>
</template>
