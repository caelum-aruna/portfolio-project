<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { GitBranch, RefreshCw, CheckCircle2, Globe, Clock, Code2 } from 'lucide-vue-next';

const props = defineProps({
    activeFile: {
        type: String,
        default: 'Overview.vue',
    },
    profile: {
        type: Object,
        default: () => ({}),
    },
    lineCount: {
        type: Number,
        default: 56,
    },
});

const currentTime = ref('');

const updateTime = () => {
    const now = new Date();
    currentTime.value = now.toLocaleTimeString('id-ID', {
        timeZone: 'Asia/Makassar',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: false,
    });
};

let timer = null;
onMounted(() => {
    updateTime();
    timer = setInterval(updateTime, 1000);
});

onUnmounted(() => {
    if (timer) clearInterval(timer);
});
</script>

<template>
    <footer class="h-7 w-full bg-indigo-700 text-white font-mono text-xs flex items-center justify-between px-3 select-none z-30 shrink-0 border-t border-indigo-800">
        <!-- Left Section: Git & Workspace Info -->
        <div class="flex items-center space-x-3 truncate">
            <div class="flex items-center space-x-1.5 hover:bg-indigo-800 px-2 py-0.5 rounded cursor-default transition-colors">
                <GitBranch class="w-3.5 h-3.5" />
                <span class="font-semibold">main*</span>
            </div>

            <div class="hidden sm:flex items-center space-x-1.5 hover:bg-indigo-800 px-2 py-0.5 rounded cursor-default transition-colors">
                <RefreshCw class="w-3 h-3 text-indigo-200" />
                <span>0↓ 1↑</span>
            </div>

            <div class="hidden md:flex items-center space-x-1.5 text-indigo-200">
                <span>ma_portfolio</span>
                <span>/</span>
                <span class="text-white font-medium">{{ activeFile }}</span>
            </div>
        </div>

        <!-- Right Section: Language, Encoding, Time, Status -->
        <div class="flex items-center space-x-3">
            <div class="hidden lg:flex items-center space-x-1 text-indigo-100 hover:bg-indigo-800 px-2 py-0.5 rounded cursor-default">
                <Code2 class="w-3.5 h-3.5 text-emerald-300" />
                <span>Vue 3 + Laravel 11</span>
            </div>

            <div class="hidden sm:flex items-center space-x-1 text-indigo-100">
                <span>UTF-8</span>
            </div>

            <div class="hidden sm:flex items-center space-x-1 text-indigo-100">
                <span>Ln {{ lineCount }}, Col 1</span>
            </div>

            <!-- Availability Status Badge -->
            <div class="flex items-center space-x-1.5 bg-emerald-500 text-zinc-950 font-sans font-bold px-2 py-0.5 rounded text-[11px] shadow-sm">
                <span class="w-1.5 h-1.5 rounded-full bg-zinc-950 animate-ping"></span>
                <span class="truncate max-w-[140px]">{{ profile.availability || 'Available for Work' }}</span>
            </div>

            <!-- Clock -->
            <div class="hidden md:flex items-center space-x-1.5 text-indigo-200">
                <Clock class="w-3 h-3" />
                <span>{{ currentTime }} WITA</span>
            </div>
        </div>
    </footer>
</template>
