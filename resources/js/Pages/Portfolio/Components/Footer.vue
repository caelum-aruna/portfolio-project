<script setup>
import { Terminal, ArrowUp } from 'lucide-vue-next';

const props = defineProps({
    profile: {
        type: Object,
        required: true,
    },
});

const scrollToTop = () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
};
</script>

<template>
    <footer class="py-12 bg-white dark:bg-zinc-950 border-t border-zinc-200 dark:border-zinc-800 transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                
                <!-- Brand Info -->
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-zinc-900 text-white dark:bg-white dark:text-zinc-900 flex items-center justify-center">
                        <Terminal class="w-4 h-4 text-white dark:text-zinc-900" />
                    </div>
                    <div>
                        <p class="font-heading font-extrabold text-zinc-900 dark:text-white tracking-tight text-base">
                            Ikbal<span class="text-indigo-600 dark:text-indigo-400">.dev</span>
                        </p>
                        <p class="text-[11px] text-zinc-400 font-mono">
                            Full Stack Web Architect
                        </p>
                    </div>
                </div>

                <!-- Center: Tech Signature -->
                <div class="text-center text-xs font-mono text-zinc-500 dark:text-zinc-400 flex items-center gap-1.5">
                    <span>Laravel 11</span>
                    <span class="text-zinc-300 dark:text-zinc-700">•</span>
                    <span>Inertia.js</span>
                    <span class="text-zinc-300 dark:text-zinc-700">•</span>
                    <span>Vue 3</span>
                    <span class="text-zinc-300 dark:text-zinc-700">•</span>
                    <span>Tailwind CSS</span>
                </div>

                <!-- Right: Back to Top & Copyright -->
                <div class="flex items-center gap-4">
                    <p class="text-xs font-sans text-zinc-500 dark:text-zinc-400">
                        &copy; {{ new Date().getFullYear() }} {{ profile.name || 'Ikbal Muhammad' }}. All rights reserved.
                    </p>
                    <button 
                        @click="scrollToTop"
                        type="button"
                        aria-label="Scroll to top"
                        class="p-2 rounded-xl bg-zinc-100 dark:bg-zinc-900 text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white transition-colors border border-zinc-200 dark:border-zinc-800"
                    >
                        <ArrowUp class="w-4 h-4" />
                    </button>
                </div>

            </div>
        </div>
    </footer>
</template>
