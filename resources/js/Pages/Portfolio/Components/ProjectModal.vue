<script setup>
import { 
    X, 
    ExternalLink, 
    Github, 
    Sparkles
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
            enter-active-class="transition duration-200 ease-out"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition duration-150 ease-in"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div 
                v-if="isOpen && project" 
                class="fixed inset-0 z-50 overflow-y-auto bg-zinc-950/80 backdrop-blur-sm flex items-center justify-center p-4 sm:p-6"
                @click.self="emit('close')"
            >
                <!-- Modal Card -->
                <div 
                    class="relative w-full max-w-3xl rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-xl overflow-hidden"
                >
                    <!-- Header Image / Banner -->
                    <div class="relative h-56 sm:h-64 w-full overflow-hidden bg-zinc-900">
                        <img 
                            :src="project.thumbnail || '/images/tech-stack.png'" 
                            :alt="project.title"
                            class="w-full h-full object-cover object-center"
                            onerror="this.src='/images/tech-stack.png'"
                        />

                        <!-- Close Button -->
                        <button 
                            @click="emit('close')"
                            type="button"
                            class="absolute top-4 right-4 p-2 rounded-xl bg-zinc-950/80 hover:bg-zinc-950 text-white/80 hover:text-white border border-white/10 transition-colors"
                        >
                            <X class="w-5 h-5" />
                        </button>

                        <!-- Banner Title Overlay with Solid Background -->
                        <div class="absolute bottom-4 left-5 right-5">
                            <span class="inline-block px-2.5 py-0.5 rounded text-[11px] font-mono font-semibold bg-zinc-900/90 text-white mb-2 border border-white/10">
                                {{ project.category }}
                            </span>
                            <h2 class="font-heading text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
                                {{ project.title }}
                            </h2>
                        </div>
                    </div>

                    <!-- Modal Body -->
                    <div class="p-6 sm:p-8 space-y-6">
                        
                        <!-- Description -->
                        <div class="space-y-2">
                            <h4 class="text-xs font-mono uppercase tracking-wider text-zinc-400 font-semibold">Project Overview</h4>
                            <p class="font-sans text-zinc-700 dark:text-zinc-300 leading-relaxed text-sm sm:text-base">
                                {{ project.description }}
                            </p>
                        </div>

                        <!-- Architecture & Technical Details -->
                        <div v-if="project.details" class="p-4 rounded-xl bg-zinc-50 dark:bg-zinc-800/50 border border-zinc-200 dark:border-zinc-700/60 space-y-2">
                            <h4 class="text-xs font-mono uppercase tracking-wider text-indigo-600 dark:text-indigo-400 font-semibold flex items-center gap-1.5">
                                <Sparkles class="w-3.5 h-3.5" />
                                Technical Architecture
                            </h4>
                            <p class="font-sans text-xs sm:text-sm text-zinc-600 dark:text-zinc-300 leading-relaxed">
                                {{ project.details }}
                            </p>
                        </div>

                        <!-- Tech Stack Tags -->
                        <div class="space-y-2">
                            <h4 class="text-xs font-mono uppercase tracking-wider text-zinc-400 font-semibold">Technologies Utilized</h4>
                            <div class="flex flex-wrap gap-1.5">
                                <span 
                                    v-for="(tech, idx) in project.tech_stack" 
                                    :key="idx"
                                    class="px-2.5 py-1 rounded-lg text-xs font-mono bg-zinc-100 dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200 border border-zinc-200 dark:border-zinc-700"
                                >
                                    {{ tech }}
                                </span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="pt-4 border-t border-zinc-200 dark:border-zinc-800 flex flex-wrap items-center justify-end gap-3">
                            <button 
                                @click="emit('close')"
                                type="button"
                                class="px-5 py-2.5 rounded-xl text-xs font-semibold font-sans text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors"
                            >
                                Close
                            </button>

                            <a 
                                v-if="project.repo_url" 
                                :href="project.repo_url" 
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-semibold font-sans bg-zinc-100 dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200 hover:bg-zinc-200 dark:hover:bg-zinc-700 transition-colors border border-zinc-200 dark:border-zinc-700"
                            >
                                <Github class="w-4 h-4" />
                                <span>Source Code</span>
                            </a>

                            <a 
                                v-if="project.demo_url" 
                                :href="project.demo_url" 
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-semibold font-sans bg-indigo-600 hover:bg-indigo-700 text-white shadow-sm transition-colors"
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
