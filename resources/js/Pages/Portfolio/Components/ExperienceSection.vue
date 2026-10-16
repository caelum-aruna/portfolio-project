<script setup>
import { 
    Briefcase, 
    GraduationCap, 
    Calendar, 
    Building2, 
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
    <section id="experience" class="py-24 relative bg-white dark:bg-zinc-950">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Section Header -->
            <div class="text-center max-w-3xl mx-auto space-y-3 mb-16">
                <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-zinc-100 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 text-zinc-800 dark:text-zinc-200 text-xs font-mono font-semibold uppercase tracking-wider">
                    <Milestone class="w-3.5 h-3.5 text-indigo-600 dark:text-indigo-400" />
                    <span>Career & Journey</span>
                </div>
                <h2 class="font-heading text-3xl sm:text-4xl lg:text-5xl font-extrabold text-zinc-900 dark:text-white tracking-tight">
                    Professional Experience & Education
                </h2>
                <p class="font-sans text-base sm:text-lg text-zinc-600 dark:text-zinc-400">
                    A chronicle of roles, academic milestones, and hands-on software development milestones.
                </p>
            </div>

            <!-- Timeline Container -->
            <div class="relative border-l-2 border-zinc-200 dark:border-zinc-800 ml-4 sm:ml-8 pl-6 sm:pl-10 space-y-10">
                
                <div 
                    v-for="(item, idx) in experiences" 
                    :key="item.id"
                    class="relative group"
                >
                    <!-- Timeline Node Indicator -->
                    <div class="absolute -left-[31px] sm:-left-[47px] top-1.5 w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-white dark:bg-zinc-900 border-2 border-indigo-600 flex items-center justify-center shadow-sm">
                        <component 
                            :is="item.type === 'education' ? GraduationCap : Briefcase" 
                            class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-indigo-600 dark:text-indigo-400" 
                        />
                    </div>

                    <!-- Content Card -->
                    <div class="p-6 sm:p-7 rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-sm transition-colors hover:border-zinc-300 dark:hover:border-zinc-700">
                        <div class="flex flex-wrap items-center justify-between gap-3 mb-2.5">
                            <div>
                                <span 
                                    class="inline-block px-2.5 py-0.5 rounded-md text-[10px] font-mono font-semibold uppercase tracking-wider mb-1"
                                    :class="item.type === 'education' ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 border border-zinc-200 dark:border-zinc-700' : 'bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-800'"
                                >
                                    {{ item.type === 'education' ? 'Academic Milestone' : 'Work Experience' }}
                                </span>
                                <h3 class="font-heading text-xl font-bold text-zinc-900 dark:text-white">
                                    {{ item.position }}
                                </h3>
                            </div>

                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-mono font-semibold bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 border border-zinc-200 dark:border-zinc-700">
                                <Calendar class="w-3.5 h-3.5 text-indigo-500" />
                                {{ item.period }}
                            </span>
                        </div>

                        <!-- Company / Institution -->
                        <div class="flex items-center gap-2 text-sm font-semibold font-sans text-indigo-600 dark:text-indigo-400 mb-3">
                            <Building2 class="w-4 h-4" />
                            <span>{{ item.company }}</span>
                        </div>

                        <!-- Description -->
                        <p class="font-sans text-sm sm:text-base text-zinc-600 dark:text-zinc-400 leading-relaxed">
                            {{ item.description }}
                        </p>
                    </div>

                </div>

            </div>

        </div>
    </section>
</template>
