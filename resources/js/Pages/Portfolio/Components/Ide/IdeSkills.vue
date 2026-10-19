<script setup>
import { computed, ref } from 'vue';
import { 
    Cpu, 
    Code2, 
    Server, 
    Database, 
    Wrench, 
    Copy, 
    Check, 
    Layers, 
    CheckCircle2 
} from 'lucide-vue-next';

const props = defineProps({
    skills: {
        type: Array,
        required: true,
    },
    profile: {
        type: Object,
        default: () => ({}),
    },
    viewMode: {
        type: String,
        default: 'preview',
    },
});

const codeCopied = ref(false);

const groupedSkills = computed(() => {
    const groups = {};
    props.skills.forEach(skill => {
        const cat = skill.category || 'General';
        if (!groups[cat]) {
            groups[cat] = [];
        }
        groups[cat].push(skill);
    });
    return groups;
});

const getCategoryIcon = (category) => {
    const c = category.toLowerCase();
    if (c.includes('front')) return Code2;
    if (c.includes('back')) return Server;
    if (c.includes('data')) return Database;
    return Wrench;
};

// Clean JSON representation without arbitrary percent numbers for code view
const skillsJsonClean = computed(() => {
    return props.skills.map(s => ({
        name: s.name,
        category: s.category,
        status: 'production-ready',
    }));
});

const skillsJsonString = computed(() => {
    return JSON.stringify(skillsJsonClean.value, null, 2);
});

const copyCode = () => {
    navigator.clipboard.writeText(skillsJsonString.value);
    codeCopied.value = true;
    setTimeout(() => {
        codeCopied.value = false;
    }, 2000);
};
</script>

<template>
    <div class="flex-1 h-full overflow-y-auto bg-white dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 flex">
        
        <!-- ================= MODE 1: VISUAL PREVIEW ================= -->
        <div v-if="viewMode === 'preview'" class="w-full p-4 sm:p-8 max-w-5xl mx-auto space-y-8 font-sans">
            
            <!-- Header Banner -->
            <div class="border border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-900 rounded-xl p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <div class="flex items-center space-x-2 text-xs font-mono text-amber-600 dark:text-amber-400 uppercase tracking-wider mb-1">
                        <Cpu class="w-4 h-4" />
                        <span>Core Competencies & Toolchain</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold font-heading text-zinc-900 dark:text-white">
                        Technical Arsenal ({{ skills.length }} Technologies)
                    </h1>
                </div>
                <div class="flex items-center space-x-2 text-xs font-mono text-zinc-600 dark:text-zinc-400 bg-white dark:bg-zinc-950 px-3 py-1.5 rounded-lg border border-zinc-200 dark:border-zinc-800 shrink-0">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 dark:bg-emerald-400"></span>
                    <span>Production Grade Stack</span>
                </div>
            </div>

            <!-- Grouped Skills Sections (No Progress Bar, No Percentages) -->
            <div class="space-y-6">
                <div
                    v-for="(skillList, category) in groupedSkills"
                    :key="category"
                    class="bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-6 space-y-4"
                >
                    <!-- Category Header -->
                    <div class="flex items-center space-x-2.5 border-b border-zinc-200 dark:border-zinc-800 pb-3">
                        <component :is="getCategoryIcon(category)" class="w-4 h-4 text-indigo-600 dark:text-indigo-400" />
                        <h2 class="text-base font-bold font-heading text-zinc-900 dark:text-white">
                            {{ category }} Engineering
                        </h2>
                        <span class="text-xs font-mono text-zinc-500">
                            ({{ skillList.length }})
                        </span>
                    </div>

                    <!-- Clean Solid Tech Badge Matrix -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                        <div
                            v-for="skill in skillList"
                            :key="skill.id"
                            class="flex items-center justify-between p-3.5 rounded-lg bg-white dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 hover:border-zinc-300 dark:hover:border-zinc-700 hover:bg-zinc-100/60 dark:hover:bg-zinc-900/60 transition-colors group"
                        >
                            <div class="flex items-center space-x-3 truncate">
                                <span class="w-2 h-2 rounded-full bg-indigo-500 group-hover:bg-emerald-500 dark:group-hover:bg-emerald-400 transition-colors shrink-0"></span>
                                <span class="font-heading font-semibold text-sm text-zinc-800 dark:text-zinc-200 group-hover:text-zinc-900 dark:group-hover:text-white truncate">
                                    {{ skill.name }}
                                </span>
                            </div>
                            <span class="text-[10px] font-mono uppercase px-2 py-0.5 rounded bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 border border-zinc-200 dark:border-zinc-700 shrink-0">
                                Active
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tech Stack Architecture Card (Using tech-stack.png) -->
            <div v-if="profile.tech_image" class="bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-6 space-y-4">
                <div class="flex items-center space-x-2 text-xs font-mono text-indigo-600 dark:text-indigo-400 uppercase tracking-wider">
                    <Layers class="w-4 h-4" />
                    <span>Stack Architecture Overview</span>
                </div>
                <div class="w-full rounded-lg overflow-hidden border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-950 max-h-[360px] flex items-center justify-center p-2">
                    <img 
                        :src="profile.tech_image" 
                        alt="Tech Stack Architecture" 
                        class="max-w-full max-h-[340px] object-contain rounded"
                    />
                </div>
            </div>

        </div>

        <!-- ================= MODE 2: SOURCE CODE VIEW ================= -->
        <div v-else class="w-full flex font-mono text-xs overflow-x-auto bg-white dark:bg-zinc-950">
            <!-- Line Numbers Gutter -->
            <div class="w-12 py-4 select-none text-right pr-4 text-zinc-400 dark:text-zinc-600 bg-zinc-50 dark:bg-zinc-950 border-r border-zinc-200 dark:border-zinc-800 shrink-0 space-y-1">
                <div v-for="n in 45" :key="n">{{ n }}</div>
            </div>

            <!-- Code Content -->
            <div class="flex-1 p-4 relative text-zinc-800 dark:text-zinc-300">
                <button
                    @click="copyCode"
                    class="absolute top-4 right-4 flex items-center space-x-1 px-2.5 py-1 rounded bg-zinc-100 dark:bg-zinc-800 hover:bg-zinc-200 dark:hover:bg-zinc-700 text-zinc-700 dark:text-zinc-300 text-xs border border-zinc-300 dark:border-zinc-700"
                >
                    <Check v-if="codeCopied" class="w-3.5 h-3.5 text-emerald-500 dark:text-emerald-400" />
                    <Copy v-else class="w-3.5 h-3.5" />
                    <span>{{ codeCopied ? 'Copied' : 'Copy JSON' }}</span>
                </button>

                <pre class="leading-relaxed whitespace-pre font-mono text-amber-700 dark:text-amber-300"><code>{{ skillsJsonString }}</code></pre>
            </div>
        </div>

    </div>
</template>
