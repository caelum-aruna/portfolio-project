<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { 
    FolderGit2, 
    Wrench, 
    Milestone, 
    Mail, 
    ArrowUpRight, 
    CheckCircle2, 
    Clock, 
    Eye,
    Plus,
    ExternalLink
} from 'lucide-vue-next';

const props = defineProps({
    stats: {
        type: Object,
        required: true,
    },
    recent_messages: {
        type: Array,
        required: true,
    },
    recent_projects: {
        type: Array,
        required: true,
    },
});

const toggleMessageRead = (message) => {
    router.patch(route('admin.messages.toggle', message.id), {}, {
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Admin Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                    Portfolio Overview
                </h1>
                <p class="text-xs text-slate-500 dark:text-slate-400 font-mono mt-0.5">
                    Welcome back, Ikbal Muhammad. Here is your portfolio activity summary.
                </p>
            </div>

            <!-- Quick Action Buttons -->
            <div class="flex items-center gap-3">
                <Link 
                    :href="route('admin.projects.index')"
                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-semibold bg-indigo-600 text-white shadow-md shadow-indigo-500/20 hover:bg-indigo-700 transition-colors"
                >
                    <Plus class="w-4 h-4" />
                    <span>Manage Projects</span>
                </Link>
            </div>
        </template>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <!-- Metric Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <!-- Total Projects -->
                <div class="p-6 rounded-3xl bg-white dark:bg-[#0E131F] border border-slate-200 dark:border-slate-800 shadow-sm flex items-center justify-between">
                    <div class="space-y-1">
                        <span class="text-xs font-mono uppercase tracking-wider text-slate-400">Total Projects</span>
                        <p class="text-3xl font-extrabold text-slate-900 dark:text-white">{{ stats.total_projects }}</p>
                        <Link :href="route('admin.projects.index')" class="text-xs text-indigo-500 font-medium hover:underline inline-flex items-center gap-1">
                            View all <ArrowUpRight class="w-3 h-3" />
                        </Link>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-500 flex items-center justify-center">
                        <FolderGit2 class="w-6 h-6" />
                    </div>
                </div>

                <!-- Total Skills -->
                <div class="p-6 rounded-3xl bg-white dark:bg-[#0E131F] border border-slate-200 dark:border-slate-800 shadow-sm flex items-center justify-between">
                    <div class="space-y-1">
                        <span class="text-xs font-mono uppercase tracking-wider text-slate-400">Technical Skills</span>
                        <p class="text-3xl font-extrabold text-slate-900 dark:text-white">{{ stats.total_skills }}</p>
                        <Link :href="route('admin.skills.index')" class="text-xs text-cyan-500 font-medium hover:underline inline-flex items-center gap-1">
                            View all <ArrowUpRight class="w-3 h-3" />
                        </Link>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-cyan-50 dark:bg-cyan-950/60 text-cyan-500 flex items-center justify-center">
                        <Wrench class="w-6 h-6" />
                    </div>
                </div>

                <!-- Career Timeline -->
                <div class="p-6 rounded-3xl bg-white dark:bg-[#0E131F] border border-slate-200 dark:border-slate-800 shadow-sm flex items-center justify-between">
                    <div class="space-y-1">
                        <span class="text-xs font-mono uppercase tracking-wider text-slate-400">Milestones</span>
                        <p class="text-3xl font-extrabold text-slate-900 dark:text-white">{{ stats.total_experiences }}</p>
                        <Link :href="route('admin.experiences.index')" class="text-xs text-purple-500 font-medium hover:underline inline-flex items-center gap-1">
                            View all <ArrowUpRight class="w-3 h-3" />
                        </Link>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-purple-50 dark:bg-purple-950/60 text-purple-500 flex items-center justify-center">
                        <Milestone class="w-6 h-6" />
                    </div>
                </div>

                <!-- Contact Messages -->
                <div class="p-6 rounded-3xl bg-white dark:bg-[#0E131F] border border-slate-200 dark:border-slate-800 shadow-sm flex items-center justify-between">
                    <div class="space-y-1">
                        <span class="text-xs font-mono uppercase tracking-wider text-slate-400">Contact Inbox</span>
                        <div class="flex items-center gap-2">
                            <p class="text-3xl font-extrabold text-slate-900 dark:text-white">{{ stats.total_messages }}</p>
                            <span v-if="stats.unread_messages > 0" class="px-2 py-0.5 rounded-full text-[10px] font-mono font-bold bg-rose-500/10 text-rose-500 border border-rose-500/20">
                                {{ stats.unread_messages }} unread
                            </span>
                        </div>
                        <Link :href="route('admin.messages.index')" class="text-xs text-emerald-500 font-medium hover:underline inline-flex items-center gap-1">
                            View inbox <ArrowUpRight class="w-3 h-3" />
                        </Link>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-500 flex items-center justify-center">
                        <Mail class="w-6 h-6" />
                    </div>
                </div>
            </div>

            <!-- Two-column Activity Area -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                
                <!-- Recent Contact Messages -->
                <div class="lg:col-span-7 rounded-3xl bg-white dark:bg-[#0E131F] border border-slate-200 dark:border-slate-800 shadow-sm p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="font-extrabold text-base text-slate-900 dark:text-white flex items-center gap-2">
                            <Mail class="w-4 h-4 text-emerald-500" />
                            Recent Messages
                        </h3>
                        <Link :href="route('admin.messages.index')" class="text-xs text-indigo-500 hover:underline">
                            View All Messages
                        </Link>
                    </div>

                    <div v-if="recent_messages.length === 0" class="py-12 text-center text-xs text-slate-400">
                        No messages received yet.
                    </div>

                    <div v-else class="space-y-3">
                        <div 
                            v-for="msg in recent_messages" 
                            :key="msg.id"
                            class="p-4 rounded-2xl border transition-colors flex items-start justify-between gap-4"
                            :class="[
                                msg.is_read 
                                    ? 'bg-slate-50/60 dark:bg-slate-900/40 border-slate-200/60 dark:border-slate-800/60' 
                                    : 'bg-indigo-50/50 dark:bg-indigo-950/30 border-indigo-200 dark:border-indigo-800'
                            ]"
                        >
                            <div class="space-y-1">
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-sm text-slate-900 dark:text-white">{{ msg.name }}</span>
                                    <span v-if="!msg.is_read" class="w-2 h-2 rounded-full bg-indigo-500"></span>
                                </div>
                                <p class="text-xs text-indigo-500 font-mono">{{ msg.email }}</p>
                                <p class="text-xs text-slate-600 dark:text-slate-300 line-clamp-2 mt-1">
                                    {{ msg.message }}
                                </p>
                            </div>

                            <button 
                                @click="toggleMessageRead(msg)"
                                type="button"
                                class="shrink-0 text-xs px-2.5 py-1 rounded-lg border border-slate-200 dark:border-slate-700 text-slate-500 hover:text-indigo-500 transition-colors"
                            >
                                {{ msg.is_read ? 'Mark Unread' : 'Mark Read' }}
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Recent Projects Showcase -->
                <div class="lg:col-span-5 rounded-3xl bg-white dark:bg-[#0E131F] border border-slate-200 dark:border-slate-800 shadow-sm p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="font-extrabold text-base text-slate-900 dark:text-white flex items-center gap-2">
                            <FolderGit2 class="w-4 h-4 text-indigo-500" />
                            Active Projects
                        </h3>
                        <Link :href="route('admin.projects.index')" class="text-xs text-indigo-500 hover:underline">
                            Manage All
                        </Link>
                    </div>

                    <div class="space-y-3">
                        <div 
                            v-for="p in recent_projects" 
                            :key="p.id"
                            class="p-3.5 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200/80 dark:border-slate-800/80 flex items-center gap-3.5"
                        >
                            <img 
                                :src="p.thumbnail || '/images/tech-stack.png'" 
                                :alt="p.title"
                                class="w-12 h-12 rounded-xl object-cover shrink-0 bg-slate-800"
                                onerror="this.src='/images/tech-stack.png'"
                            />
                            <div class="flex-1 min-w-0">
                                <h4 class="text-xs font-bold text-slate-900 dark:text-white truncate">
                                    {{ p.title }}
                                </h4>
                                <span class="text-[10px] font-mono text-indigo-500 block">
                                    {{ p.category }}
                                </span>
                            </div>
                            <span v-if="p.is_featured" class="px-2 py-0.5 rounded text-[10px] font-mono bg-amber-500/10 text-amber-500 border border-amber-500/20">
                                Featured
                            </span>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </AuthenticatedLayout>
</template>
