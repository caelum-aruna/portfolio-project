<script setup>
import { Terminal, Heart, ArrowUp } from 'lucide-vue-next';

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
    <footer class="py-12 bg-white dark:bg-[#070A0F] border-t border-slate-200 dark:border-slate-800/80 transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                
                <!-- Brand Info -->
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-indigo-600 to-cyan-400 p-[1px]">
                        <div class="w-full h-full bg-slate-900 rounded-[11px] flex items-center justify-center text-white">
                            <Terminal class="w-4 h-4 text-indigo-400" />
                        </div>
                    </div>
                    <div>
                        <p class="font-extrabold text-slate-900 dark:text-white tracking-tight text-base">
                            Ikbal<span class="text-indigo-500">.dev</span>
                        </p>
                        <p class="text-xs text-slate-500 dark:text-slate-400 font-mono">
                            Full Stack Web Architect
                        </p>
                    </div>
                </div>

                <!-- Center: Tech Signature -->
                <div class="text-center text-xs font-mono text-slate-500 dark:text-slate-400 flex items-center gap-1.5">
                    <span>Engineered with Laravel 11</span>
                    <span class="text-slate-300 dark:text-slate-700">•</span>
                    <span>Inertia.js</span>
                    <span class="text-slate-300 dark:text-slate-700">•</span>
                    <span>Vue 3</span>
                    <span class="text-slate-300 dark:text-slate-700">•</span>
                    <span>Tailwind CSS</span>
                </div>

                <!-- Right: Back to Top & Copyright -->
                <div class="flex items-center gap-4">
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        &copy; {{ new Date().getFullYear() }} {{ profile.name || 'Ikbal Muhammad' }}. All rights reserved.
                    </p>
                    <button 
                        @click="scrollToTop"
                        type="button"
                        aria-label="Scroll to top"
                        class="p-2 rounded-xl bg-slate-100 dark:bg-slate-900 text-slate-600 dark:text-slate-400 hover:text-indigo-500 hover:bg-slate-200 dark:hover:bg-slate-800 transition-colors border border-slate-200 dark:border-slate-800"
                    >
                        <ArrowUp class="w-4 h-4" />
                    </button>
                </div>

            </div>
        </div>
    </footer>
</template>
