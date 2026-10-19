<script setup>
import { ref, computed } from 'vue';
import { 
    Wrench, 
    Code, 
    Server, 
    Terminal, 
    CheckCircle2
} from 'lucide-vue-next';

const props = defineProps({
    skills: {
        type: Array,
        required: true,
    },
});

const activeCategory = ref('All');

const categories = computed(() => {
    const list = ['All'];
    props.skills.forEach(skill => {
        if (skill.category && !list.includes(skill.category)) {
            list.push(skill.category);
        }
    });
    return list;
});

const filteredSkills = computed(() => {
    if (activeCategory.value === 'All') {
        return props.skills;
    }
    return props.skills.filter(s => s.category === activeCategory.value);
});

const getCategoryCount = (cat) => {
    if (cat === 'All') return props.skills.length;
    return props.skills.filter(s => s.category === cat).length;
};
</script>

<template>
    <section id="skills" class="py-24 relative bg-white dark:bg-zinc-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Section Header -->
            <div class="text-center max-w-3xl mx-auto space-y-3 mb-12">
                <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-zinc-100 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 text-zinc-800 dark:text-zinc-200 text-xs font-mono font-semibold uppercase tracking-wider">
                    <Wrench class="w-3.5 h-3.5 text-indigo-600 dark:text-indigo-400" />
                    <span>Skills & Expertise</span>
                </div>
                <h2 class="font-heading text-3xl sm:text-4xl lg:text-5xl font-extrabold text-zinc-900 dark:text-white tracking-tight">
                    Technologies I Use to Build the Web
                </h2>
                <p class="font-sans text-base sm:text-lg text-zinc-600 dark:text-zinc-400">
                    A comprehensive toolkit refined through production projects, continuous learning, and architecture best practices.
                </p>
            </div>

            <!-- Category Filter Tabs -->
            <div class="flex flex-wrap items-center justify-center gap-2 mb-12">
                <button 
                    v-for="cat in categories" 
                    :key="cat"
                    @click="activeCategory = cat"
                    type="button"
                    class="px-5 py-2 rounded-xl text-xs sm:text-sm font-semibold font-sans transition-colors flex items-center gap-2 border"
                    :class="[
                        activeCategory === cat
                            ? 'bg-zinc-900 border-zinc-900 text-white dark:bg-white dark:border-white dark:text-zinc-900 shadow-sm'
                            : 'bg-zinc-100 dark:bg-zinc-900 border-zinc-200 dark:border-zinc-800 text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white'
                    ]"
                >
                    <span>{{ cat }}</span>
                    <span 
                        class="text-[10px] px-2 py-0.5 rounded-full font-mono font-medium"
                        :class="activeCategory === cat ? 'bg-zinc-800 text-zinc-200 dark:bg-zinc-200 dark:text-zinc-800' : 'bg-zinc-200 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400'"
                    >
                        {{ getCategoryCount(cat) }}
                    </span>
                </button>
            </div>

            <!-- Skills Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                <div 
                    v-for="skill in filteredSkills" 
                    :key="skill.id"
                    class="p-5 rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-sm transition-colors hover:border-zinc-300 dark:hover:border-zinc-700"
                >
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 flex items-center justify-center shrink-0 border border-zinc-200/60 dark:border-zinc-700/60">
                                <Code v-if="skill.category === 'Frontend'" class="w-4 h-4 text-indigo-600 dark:text-indigo-400" />
                                <Server v-else-if="skill.category === 'Backend'" class="w-4 h-4 text-indigo-600 dark:text-indigo-400" />
                                <Terminal v-else class="w-4 h-4 text-indigo-600 dark:text-indigo-400" />
                            </div>
                            <div>
                                <h3 class="font-heading font-bold text-zinc-900 dark:text-white text-sm">
                                    {{ skill.name }}
                                </h3>
                                <span class="text-[10px] font-mono text-zinc-400 block">
                                    {{ skill.category }}
                                </span>
                            </div>
                        </div>

                        <!-- Active Stack Badge -->
                        <span class="text-[10px] font-mono font-medium px-2 py-0.5 rounded-full bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 border border-zinc-200 dark:border-zinc-700">
                            Production
                        </span>
                    </div>
                </div>
            </div>

            <!-- Bottom Proficiency Note -->
            <div class="mt-12 text-center text-xs font-mono text-zinc-400 flex items-center justify-center gap-2">
                <CheckCircle2 class="w-4 h-4 text-emerald-500" />
                <span>Proficiency assessed through hands-on architecture, code reviews, and production deployments.</span>
            </div>

        </div>
    </section>
</template>
