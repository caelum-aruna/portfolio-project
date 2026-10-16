<script setup>
import { ref, computed } from 'vue';
import { 
    Wrench, 
    Code, 
    Server, 
    Layers, 
    Terminal, 
    Sparkles,
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

const getCategoryBadgeClass = (category) => {
    switch (category) {
        case 'Frontend':
            return 'bg-cyan-500/10 text-cyan-500 border-cyan-500/20';
        case 'Backend':
            return 'bg-indigo-500/10 text-indigo-500 border-indigo-500/20';
        case 'Tools & DevOps':
            return 'bg-purple-500/10 text-purple-500 border-purple-500/20';
        default:
            return 'bg-slate-500/10 text-slate-500 border-slate-500/20';
    }
};

const getProgressBarGradient = (category) => {
    switch (category) {
        case 'Frontend':
            return 'from-cyan-500 to-blue-500';
        case 'Backend':
            return 'from-indigo-500 to-purple-600';
        case 'Tools & DevOps':
            return 'from-purple-500 to-pink-500';
        default:
            return 'from-indigo-500 to-cyan-500';
    }
};
</script>

<template>
    <section id="skills" class="py-24 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Section Header -->
            <div class="text-center max-w-3xl mx-auto space-y-3 mb-12">
                <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-cyan-500/10 border border-cyan-500/20 text-cyan-600 dark:text-cyan-400 text-xs font-mono font-semibold uppercase tracking-wider">
                    <Wrench class="w-3.5 h-3.5" />
                    <span>Skills & Expertise</span>
                </div>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                    Technologies I Use to Build the Web
                </h2>
                <p class="text-base sm:text-lg text-slate-600 dark:text-slate-400">
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
                    class="px-5 py-2.5 rounded-full text-xs sm:text-sm font-semibold transition-all duration-200 flex items-center gap-2 border"
                    :class="[
                        activeCategory === cat
                            ? 'bg-indigo-600 border-indigo-600 text-white shadow-lg shadow-indigo-500/25 scale-105'
                            : 'bg-white/80 dark:bg-slate-900/80 border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-300 hover:border-indigo-400 dark:hover:border-slate-700'
                    ]"
                >
                    <span>{{ cat }}</span>
                    <span 
                        class="text-[11px] px-2 py-0.5 rounded-full font-mono font-medium"
                        :class="activeCategory === cat ? 'bg-indigo-800/80 text-indigo-100' : 'bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400'"
                    >
                        {{ getCategoryCount(cat) }}
                    </span>
                </button>
            </div>

            <!-- Skills Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                <div 
                    v-for="skill in filteredSkills" 
                    :key="skill.id"
                    class="group p-5 rounded-2xl bg-white/90 dark:bg-[#0B0F17]/90 border border-slate-200 dark:border-slate-800 shadow-md hover:shadow-xl hover:border-indigo-500/40 dark:hover:border-indigo-500/40 transition-all duration-300 hover:-translate-y-1"
                >
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800/80 border border-slate-200/60 dark:border-slate-700/60 flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-bold group-hover:scale-110 group-hover:bg-indigo-50 dark:group-hover:bg-indigo-950/40 transition-all duration-200">
                                <Code v-if="skill.category === 'Frontend'" class="w-5 h-5 text-cyan-500" />
                                <Server v-else-if="skill.category === 'Backend'" class="w-5 h-5 text-indigo-500" />
                                <Terminal v-else class="w-5 h-5 text-purple-500" />
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-900 dark:text-white text-base group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                    {{ skill.name }}
                                </h3>
                                <span class="text-[11px] font-mono px-2 py-0.5 rounded-md border inline-block mt-0.5" :class="getCategoryBadgeClass(skill.category)">
                                    {{ skill.category }}
                                </span>
                            </div>
                        </div>

                        <!-- Numeric Proficiency -->
                        <span class="font-mono text-xs font-bold text-slate-500 dark:text-slate-400">
                            {{ skill.proficiency }}%
                        </span>
                    </div>

                    <!-- Animated Progress Bar -->
                    <div class="w-full h-2 rounded-full bg-slate-100 dark:bg-slate-800 overflow-hidden relative">
                        <div 
                            class="h-full rounded-full bg-gradient-to-r transition-all duration-1000 ease-out"
                            :class="getProgressBarGradient(skill.category)"
                            :style="{ width: `${skill.proficiency}%` }"
                        ></div>
                    </div>
                </div>
            </div>

            <!-- Bottom Proficiency Note -->
            <div class="mt-12 text-center text-xs font-mono text-slate-500 dark:text-slate-400 flex items-center justify-center gap-2">
                <CheckCircle2 class="w-4 h-4 text-emerald-500" />
                <span>Proficiency assessed through hands-on architecture, code reviews, and production deployments.</span>
            </div>

        </div>
    </section>
</template>
