<script setup>
import { 
    X, 
    Eye, 
    Code2, 
    ChevronRight, 
    Copy, 
    Check, 
    Share2,
    Sparkles
} from 'lucide-vue-next';
import { ref } from 'vue';

const props = defineProps({
    openTabs: {
        type: Array,
        required: true,
    },
    activeTab: {
        type: String,
        required: true,
    },
    viewMode: {
        type: String,
        default: 'preview', // 'preview' or 'code'
    },
});

const emit = defineEmits(['select-tab', 'close-tab', 'change-view-mode']);

const copied = ref(false);

const getTabIcon = (tab) => {
    if (tab.endsWith('.vue')) return { text: 'V', color: 'text-emerald-400 bg-emerald-950/80 border-emerald-800/50' };
    if (tab.endsWith('.json')) return { text: '{}', color: 'text-amber-400 bg-amber-950/80 border-amber-800/50' };
    if (tab.endsWith('.log')) return { text: 'LOG', color: 'text-purple-400 bg-purple-950/80 border-purple-800/50' };
    if (tab.endsWith('.sh')) return { text: '>_', color: 'text-sky-400 bg-sky-950/80 border-sky-800/50' };
    if (tab.endsWith('.md')) return { text: 'MD', color: 'text-blue-400 bg-blue-950/80 border-blue-800/50' };
    return { text: 'FILE', color: 'text-zinc-400 bg-zinc-900 border-zinc-700' };
};

const getBreadcrumb = (tab) => {
    if (tab === 'Projects.vue') return 'ma_portfolio > src > projects > Projects.vue';
    if (tab === 'README.md') return 'ma_portfolio > docs > README.md';
    return `ma_portfolio > src > ${tab}`;
};

const copyFilePath = () => {
    navigator.clipboard.writeText(getBreadcrumb(props.activeTab));
    copied.value = true;
    setTimeout(() => {
        copied.value = false;
    }, 2000);
};
</script>

<template>
    <div class="bg-zinc-100 dark:bg-zinc-950 border-b border-zinc-200 dark:border-zinc-800 select-none z-10 font-mono text-xs shrink-0">
        <!-- Top Tabs Row -->
        <div class="flex items-center justify-between overflow-x-auto no-scrollbar bg-zinc-100 dark:bg-zinc-950/90 border-b border-zinc-200 dark:border-zinc-800">
            <!-- Left: Tab Items -->
            <div class="flex items-center">
                <div
                    v-for="tab in openTabs"
                    :key="tab"
                    @click="emit('select-tab', tab)"
                    :class="[
                        'group flex items-center space-x-2 px-3.5 py-2.5 border-r border-zinc-200 dark:border-zinc-800/80 cursor-pointer transition-colors relative',
                        activeTab === tab
                            ? 'bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white font-medium border-t-2 border-t-indigo-500'
                            : 'bg-zinc-100 dark:bg-zinc-950 text-zinc-500 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-900/60 hover:text-zinc-800 dark:hover:text-zinc-200'
                    ]"
                >
                    <!-- File Badge -->
                    <span 
                        :class="[
                            'text-[10px] font-bold px-1 py-0.2 rounded border',
                            getTabIcon(tab).color
                        ]"
                    >
                        {{ getTabIcon(tab).text }}
                    </span>

                    <!-- Tab Label -->
                    <span class="truncate max-w-[120px] sm:max-w-none">{{ tab }}</span>

                    <!-- Close Tab Button -->
                    <button
                        v-if="openTabs.length > 1"
                        @click.stop="emit('close-tab', tab)"
                        title="Close Tab"
                        class="p-0.5 rounded-full hover:bg-zinc-200 dark:hover:bg-zinc-800 hover:text-zinc-900 dark:hover:text-white text-zinc-400 dark:text-zinc-500 opacity-60 group-hover:opacity-100 transition-opacity"
                    >
                        <X class="w-3.5 h-3.5" />
                    </button>
                </div>
            </div>

            <!-- Right: View Mode Toggle ([👁 Preview] vs [</> Code]) -->
            <div class="flex items-center space-x-1 px-3 py-1 bg-zinc-100 dark:bg-zinc-950 shrink-0">
                <div class="inline-flex rounded-md p-0.5 bg-zinc-200 dark:bg-zinc-900 border border-zinc-300 dark:border-zinc-800">
                    <button
                        @click="emit('change-view-mode', 'preview')"
                        :class="[
                            'flex items-center space-x-1.5 px-2.5 py-1 rounded text-[11px] font-sans font-semibold transition-all',
                            viewMode === 'preview'
                                ? 'bg-indigo-600 text-white shadow-sm'
                                : 'text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-200 hover:bg-zinc-300/50 dark:hover:bg-zinc-800'
                        ]"
                        title="Interactive Visual Preview"
                    >
                        <Eye class="w-3.5 h-3.5" />
                        <span>Visual Preview</span>
                    </button>

                    <button
                        @click="emit('change-view-mode', 'code')"
                        :class="[
                            'flex items-center space-x-1.5 px-2.5 py-1 rounded text-[11px] font-sans font-semibold transition-all',
                            viewMode === 'code'
                                ? 'bg-indigo-600 text-white shadow-sm'
                                : 'text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-200 hover:bg-zinc-300/50 dark:hover:bg-zinc-800'
                        ]"
                        title="Inspect Source Code"
                    >
                        <Code2 class="w-3.5 h-3.5" />
                        <span>Source Code</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Breadcrumbs Row -->
        <div class="h-7 px-4 bg-zinc-50 dark:bg-zinc-900/60 border-t border-zinc-200 dark:border-transparent flex items-center justify-between text-zinc-600 dark:text-zinc-400 text-[11px]">
            <div class="flex items-center space-x-1.5 truncate">
                <span class="text-zinc-400 dark:text-zinc-500">portfolio</span>
                <ChevronRight class="w-3 h-3 text-zinc-400 dark:text-zinc-600 shrink-0" />
                <span class="text-zinc-600 dark:text-zinc-400 truncate">{{ getBreadcrumb(activeTab) }}</span>
            </div>

            <!-- Actions -->
            <div class="flex items-center space-x-2 shrink-0">
                <button
                    @click="copyFilePath"
                    class="flex items-center space-x-1 text-zinc-500 hover:text-zinc-800 dark:hover:text-zinc-300 transition-colors"
                    title="Copy path"
                >
                    <Check v-if="copied" class="w-3 h-3 text-emerald-500 dark:text-emerald-400" />
                    <Copy v-else class="w-3 h-3" />
                    <span class="text-[10px] hidden sm:inline">{{ copied ? 'Copied!' : 'Copy Path' }}</span>
                </button>
            </div>
        </div>
    </div>
</template>
