<script setup>
import { 
    X, 
    ExternalLink, 
    Github, 
    Code2, 
    Calendar, 
    Sparkles,
    CheckCircle2
} from 'lucide-vue-next';

const props = defineProps({
    project: {
        type: Object,
        default: null,
    },
    isOpen: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(['close']);
</script>

<template>
    <teleport to="body">
        <transition
            enter-active-class="transition duration-300 ease-out"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition duration-200 ease-in"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div 
                v-if="isOpen && project" 
                class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/80 backdrop-blur-md flex items-center justify-center p-4 sm:p-6"
                @click.self="emit('close')"
            >
                <!-- Modal Card -->
                <div 
                    class="relative w-full max-w-3xl rounded-3xl bg-white dark:bg-[#0B0F17] border border-slate-200 dark:border-slate-800 shadow-2xl overflow-hidden transition-all duration-300 transform scale-100"
                >
                    <!-- Header Image / Banner -->
                    <div class="relative h-56 sm:h-72 w-full overflow-hidden bg-slate-900">
                        <img 
                            :src="project.thumbnail || '/images/tech-stack.png'" 
                            :alt="project.title"
                            class="w-full h-full object-cover object-center"
                            onerror="this.src='/images/tech-stack.png'"
                        />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>

                        <!-- Close Button -->
                        <button 
                            @click="emit('close')"
                            type="button"
                            class="absolute top-4 right-4 p-2 rounded-full bg-slate-900/70 hover:bg-slate-900 text-white/80 hover:text-white backdrop-blur-md border border-white/10 transition-colors"
                        >
                            <X class="w-5 h-5" />
                        </button>

                        <!-- Banner Title Overlay -->
                        <div class="absolute bottom-5 left-6 right-6">
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-mono font-semibold bg-indigo-500/90 text-white mb-2 shadow-sm">
                                {{ project.category }}
                            </span>
                            <h2 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
                                {{ project.title }}
                            </h2>
                        </div>
                    </div>

                    <!-- Modal Body -->
                    <div class="p-6 sm:p-8 space-y-6">
                        
                        <!-- Description -->
                        <div class="space-y-3">
                            <h4 class="text-xs font-mono uppercase tracking-wider text-slate-400 font-semibold">Project Overview</h4>
                            <p class="text-slate-700 dark:text-slate-300 leading-relaxed text-sm sm:text-base">
                                {{ project.description }}
                            </p>
                        </div>

                        <!-- Architecture & Technical Details -->
                        <div v-if="project.details" class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200/80 dark:border-slate-800/80 space-y-2">
                            <h4 class="text-xs font-mono uppercase tracking-wider text-indigo-600 dark:text-indigo-400 font-semibold flex items-center gap-1.5">
                                <Sparkles class="w-3.5 h-3.5" />
                                Technical Architecture
                            </h4>
                            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                                {{ project.details }}
                            </p>
                        </div>

                        <!-- Tech Stack Tags -->
                        <div class="space-y-2">
                            <h4 class="text-xs font-mono uppercase tracking-wider text-slate-400 font-semibold">Technologies Utilized</h4>
                            <div class="flex flex-wrap gap-2">
                                <span 
                                    v-for="(tech, idx) in project.tech_stack" 
                                    :key="idx"
                                    class="px-3 py-1 rounded-lg text-xs font-medium font-mono bg-indigo-50 dark:bg-indigo-950/40 text-indigo-700 dark:text-indigo-300 border border-indigo-200/60 dark:border-indigo-800/50"
                                >
                                    {{ tech }}
                                </span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="pt-4 border-t border-slate-200 dark:border-slate-800 flex flex-wrap items-center justify-end gap-3">
                            <button 
                                @click="emit('close')"
                                type="button"
                                class="px-5 py-2.5 rounded-xl text-sm font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
                            >
                                Close
                            </button>

                            <a 
                                v-if="project.repo_url" 
                                :href="project.repo_url" 
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-slate-200 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors"
                            >
                                <Github class="w-4 h-4" />
                                <span>Source Code</span>
                            </a>

                            <a 
                                v-if="project.demo_url" 
                                :href="project.demo_url" 
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold bg-gradient-to-r from-indigo-600 to-cyan-500 text-white shadow-lg shadow-indigo-500/25 hover:opacity-95 transition-opacity"
                            >
                                <span>Live Demo</span>
                                <ExternalLink class="w-4 h-4" />
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </transition>
    </teleport>
</template>
