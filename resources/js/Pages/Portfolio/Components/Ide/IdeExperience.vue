<script setup>
import { computed, ref } from 'vue';
import { 
    GitCommit, 
    Calendar, 
    Briefcase, 
    GraduationCap, 
    MapPin, 
    Copy, 
    Check, 
    Terminal, 
    GitBranch 
} from 'lucide-vue-next';

const props = defineProps({
    experiences: {
        type: Array,
        required: true,
    },
    viewMode: {
        type: String,
        default: 'preview',
    },
});

const activeFilter = ref('all');
const codeCopied = ref(false);

const filteredExperiences = computed(() => {
    if (activeFilter.value === 'all') return props.experiences;
    return props.experiences.filter(exp => (exp.type || 'work') === activeFilter.value);
});

const formatLogDate = (startDate, endDate, isCurrent) => {
    if (!startDate) return '';
    const start = startDate.substring(0, 7);
    if (isCurrent) return `${start} - PRESENT`;
    return `${start} - ${endDate ? endDate.substring(0, 7) : 'CONCLUDED'}`;
};

const rawLogText = computed(() => {
    return props.experiences.map((exp, idx) => {
        const hash = Math.random().toString(16).substring(2, 9);
        const dateStr = exp.start_date || '2023-01-01';
        return `commit ${hash} (tag: ${exp.type || 'work'}, order: ${exp.order || idx + 1})
Author: Ikbal Muhammad <ikbal@email.com>
Date:   ${dateStr} +0800

    [${exp.company || 'Enterprise'}] ${exp.role}
    Duration: ${formatLogDate(exp.start_date, exp.end_date, exp.is_current)}
    Type: ${exp.type || 'work'}
    
    ${exp.description || 'Executed full software lifecycle development and deployment.'}
`;
    }).join('\n--------------------------------------------------\n\n');
});

const copyCode = () => {
    navigator.clipboard.writeText(rawLogText.value);
    codeCopied.value = true;
    setTimeout(() => {
        codeCopied.value = false;
    }, 2000);
};
</script>

<template>
    <div class="flex-1 h-full overflow-y-auto bg-white dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 flex">
        
        <!-- ================= MODE 1: VISUAL PREVIEW ================= -->
        <div v-if="viewMode === 'preview'" class="w-full p-4 sm:p-8 max-w-4xl mx-auto space-y-6 font-sans">
            
            <!-- Section Header -->
            <div class="border border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-900 rounded-xl p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <div class="flex items-center space-x-2 text-xs font-mono text-purple-600 dark:text-purple-400 uppercase tracking-wider mb-1">
                        <Terminal class="w-4 h-4" />
                        <span>System Changelog & Career Trace</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold font-heading text-zinc-900 dark:text-white">
                        Journey & Milestones ({{ filteredExperiences.length }})
                    </h1>
                </div>

                <!-- Filter Pills -->
                <div class="flex items-center space-x-1.5 bg-zinc-100 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 p-1 rounded-lg">
                    <button
                        @click="activeFilter = 'all'"
                        :class="[
                            'px-3 py-1 rounded text-xs font-medium font-sans transition-colors',
                            activeFilter === 'all'
                                ? 'bg-indigo-600 text-white font-semibold'
                                : 'text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white'
                        ]"
                    >
                        All History
                    </button>
                    <button
                        @click="activeFilter = 'work'"
                        :class="[
                            'px-3 py-1 rounded text-xs font-medium font-sans transition-colors',
                            activeFilter === 'work'
                                ? 'bg-indigo-600 text-white font-semibold'
                                : 'text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white'
                        ]"
                    >
                        Work
                    </button>
                    <button
                        @click="activeFilter = 'education'"
                        :class="[
                            'px-3 py-1 rounded text-xs font-medium font-sans transition-colors',
                            activeFilter === 'education'
                                ? 'bg-indigo-600 text-white font-semibold'
                                : 'text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white'
                        ]"
                    >
                        Education
                    </button>
                </div>
            </div>

            <!-- Timeline Commit Logs -->
            <div class="relative pl-6 sm:pl-8 space-y-8 before:absolute before:left-2 sm:before:left-3 before:top-3 before:bottom-3 before:w-0.5 before:bg-zinc-200 dark:before:bg-zinc-800">
                <div
                    v-for="(item, idx) in filteredExperiences"
                    :key="item.id"
                    class="relative group"
                >
                    <!-- Node Bullet Dot -->
                    <div class="absolute -left-6 sm:-left-8 top-1.5 w-4 h-4 rounded-full bg-white dark:bg-zinc-900 border-2 border-indigo-500 flex items-center justify-center">
                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 dark:bg-indigo-400"></span>
                    </div>

                    <!-- Milestone Card -->
                    <div class="bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-5 hover:border-zinc-300 dark:hover:border-zinc-700 transition-colors space-y-3">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-zinc-200 dark:border-zinc-800/80 pb-3">
                            <div class="space-y-1">
                                <div class="flex items-center space-x-2">
                                    <h3 class="text-lg font-bold font-heading text-zinc-900 dark:text-white">
                                        {{ item.role }}
                                    </h3>
                                    <span 
                                        :class="[
                                            'text-[10px] font-mono px-2 py-0.5 rounded uppercase font-semibold border',
                                            item.type === 'education'
                                                ? 'bg-amber-500/10 text-amber-600 dark:text-amber-400 border-amber-500/20'
                                                : 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border-emerald-500/20'
                                        ]"
                                    >
                                        {{ item.type || 'work' }}
                                    </span>
                                </div>
                                <div class="text-sm font-medium text-indigo-600 dark:text-indigo-400">
                                    {{ item.company }}
                                </div>
                            </div>

                            <!-- Duration Badge -->
                            <div class="inline-flex items-center space-x-1.5 text-xs font-mono text-zinc-600 dark:text-zinc-400 bg-white dark:bg-zinc-950 px-2.5 py-1 rounded border border-zinc-200 dark:border-zinc-800 shrink-0">
                                <Calendar class="w-3.5 h-3.5 text-zinc-400 dark:text-zinc-500" />
                                <span>{{ formatLogDate(item.start_date, item.end_date, item.is_current) }}</span>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="text-xs sm:text-sm text-zinc-600 dark:text-zinc-300 leading-relaxed">
                            {{ item.description }}
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- ================= MODE 2: SOURCE CODE VIEW ================= -->
        <div v-else class="w-full flex font-mono text-xs overflow-x-auto bg-white dark:bg-zinc-950">
            <!-- Line Numbers Gutter -->
            <div class="w-12 py-4 select-none text-right pr-4 text-zinc-400 dark:text-zinc-600 bg-zinc-50 dark:bg-zinc-950 border-r border-zinc-200 dark:border-zinc-800 shrink-0 space-y-1">
                <div v-for="n in 50" :key="n">{{ n }}</div>
            </div>

            <!-- Code Content -->
            <div class="flex-1 p-4 relative text-zinc-800 dark:text-zinc-300">
                <button
                    @click="copyCode"
                    class="absolute top-4 right-4 flex items-center space-x-1 px-2.5 py-1 rounded bg-zinc-100 dark:bg-zinc-800 hover:bg-zinc-200 dark:hover:bg-zinc-700 text-zinc-700 dark:text-zinc-300 text-xs border border-zinc-300 dark:border-zinc-700"
                >
                    <Check v-if="codeCopied" class="w-3.5 h-3.5 text-emerald-500 dark:text-emerald-400" />
                    <Copy v-else class="w-3.5 h-3.5" />
                    <span>{{ codeCopied ? 'Copied' : 'Copy Log' }}</span>
                </button>

                <pre class="leading-relaxed whitespace-pre font-mono text-purple-700 dark:text-purple-300"><code>{{ rawLogText }}</code></pre>
            </div>
        </div>

    </div>
</template>
