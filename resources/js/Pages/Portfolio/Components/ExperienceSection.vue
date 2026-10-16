<script setup>
import { 
    Briefcase, 
    GraduationCap, 
    Calendar, 
    Building2, 
    ChevronRight,
    Milestone
} from 'lucide-vue-next';

const props = defineProps({
    experiences: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <section id="experience" class="py-24 relative overflow-hidden">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Section Header -->
            <div class="text-center max-w-3xl mx-auto space-y-3 mb-16">
                <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-600 dark:text-indigo-400 text-xs font-mono font-semibold uppercase tracking-wider">
                    <Milestone class="w-3.5 h-3.5" />
                    <span>Career & Journey</span>
                </div>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                    Professional Experience & Education
                </h2>
                <p class="text-base sm:text-lg text-slate-600 dark:text-slate-400">
                    A chronicle of roles, academic milestones, and hands-on software development milestones.
                </p>
            </div>

            <!-- Timeline Container -->
            <div class="relative border-l-2 border-indigo-500/20 dark:border-indigo-500/30 ml-4 sm:ml-8 pl-6 sm:pl-10 space-y-12">
                
                <div 
                    v-for="(item, idx) in experiences" 
                    :key="item.id"
                    class="relative group"
                >
                    <!-- Timeline Node Indicator -->
                    <div class="absolute -left-[31px] sm:-left-[47px] top-1.5 w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-white dark:bg-[#0B0F17] border-2 border-indigo-500 flex items-center justify-center shadow-md shadow-indigo-500/20 group-hover:scale-125 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                        <component 
                            :is="item.type === 'education' ? GraduationCap : Briefcase" 
                            class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-indigo-500 group-hover:text-white transition-colors" 
                        />
                    </div>

                    <!-- Content Card -->
                    <div class="p-6 sm:p-7 rounded-3xl bg-white dark:bg-[#0B0F17] border border-slate-200 dark:border-slate-800 shadow-xl group-hover:border-indigo-500/40 group-hover:shadow-2xl transition-all duration-300">
                        <div class="flex flex-wrap items-center justify-between gap-3 mb-3">
                            <div>
                                <span 
                                    class="inline-block px-2.5 py-0.5 rounded-full text-[11px] font-mono font-semibold uppercase tracking-wider mb-1"
                                    :class="item.type === 'education' ? 'bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 border border-cyan-500/20' : 'bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 border border-indigo-500/20'"
                                >
                                    {{ item.type === 'education' ? 'Academic Milestone' : 'Work Experience' }}
                                </span>
                                <h3 class="text-xl font-extrabold text-slate-900 dark:text-white group-hover:text-indigo-500 transition-colors">
                                    {{ item.position }}
                                </h3>
                            </div>

                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-mono font-semibold bg-slate-100 dark:bg-slate-800/80 text-slate-600 dark:text-slate-300 border border-slate-200/80 dark:border-slate-700/80">
                                <Calendar class="w-3.5 h-3.5 text-indigo-400" />
                                {{ item.period }}
                            </span>
                        </div>

                        <!-- Company / Institution -->
                        <div class="flex items-center gap-2 text-sm font-semibold text-indigo-600 dark:text-indigo-400 mb-4">
                            <Building2 class="w-4 h-4" />
                            <span>{{ item.company }}</span>
                        </div>

                        <!-- Description -->
                        <p class="text-sm sm:text-base text-slate-600 dark:text-slate-300 leading-relaxed">
                            {{ item.description }}
                        </p>
                    </div>

                </div>

            </div>

        </div>
    </section>
</template>
