<script setup>
import { ref, computed, onMounted, onUnmounted, nextTick, watch } from 'vue';
import { 
    Search, 
    FileCode2, 
    FileJson, 
    Terminal, 
    FileText, 
    Download, 
    Sun, 
    Moon, 
    Github, 
    Linkedin, 
    ExternalLink, 
    Code2, 
    Eye,
    X,
    CornerDownLeft
} from 'lucide-vue-next';

const props = defineProps({
    isOpen: Boolean,
    profile: {
        type: Object,
        default: () => ({}),
    },
    isDark: Boolean,
    viewMode: String,
});

const emit = defineEmits([
    'close', 
    'select-file', 
    'toggle-theme', 
    'change-view-mode',
    'download-cv'
]);

const searchQuery = ref('');
const selectedIndex = ref(0);
const searchInput = ref(null);

const allCommands = computed(() => [
    {
        category: 'Files',
        items: [
            { id: 'file-overview', title: 'Open Overview.vue', desc: 'Hero profile, bio, quick stats & resume', icon: FileCode2, color: 'text-emerald-400', action: () => emit('select-file', 'Overview.vue') },
            { id: 'file-projects', title: 'Open Projects.vue', desc: 'Showcase of web apps, systems & mobile projects', icon: FileCode2, color: 'text-indigo-400', action: () => emit('select-file', 'Projects.vue') },
            { id: 'file-skills', title: 'Open TechArsenal.json', desc: 'Technical skills, frameworks, and proficiencies', icon: FileJson, color: 'text-amber-400', action: () => emit('select-file', 'TechArsenal.json') },
            { id: 'file-journey', title: 'Open Journey.log', desc: 'Work history, education milestones, and logs', icon: Terminal, color: 'text-purple-400', action: () => emit('select-file', 'Journey.log') },
            { id: 'file-contact', title: 'Open Contact.sh', desc: 'Interactive message terminal & inquiry form', icon: Terminal, color: 'text-sky-400', action: () => emit('select-file', 'Contact.sh') },
            { id: 'file-readme', title: 'Open README.md', desc: 'Documentation, architecture, and background', icon: FileText, color: 'text-blue-400', action: () => emit('select-file', 'README.md') },
        ]
    },
    {
        category: 'Workspace Actions',
        items: [
            { 
                id: 'action-theme', 
                title: props.isDark ? 'Switch to Light Mode' : 'Switch to Dark Mode', 
                desc: 'Toggle between dark and clean light workspace', 
                icon: props.isDark ? Sun : Moon, 
                color: 'text-amber-400', 
                action: () => emit('toggle-theme') 
            },
            { 
                id: 'action-viewmode', 
                title: props.viewMode === 'preview' ? 'Switch to Source Code View' : 'Switch to Visual Preview', 
                desc: 'Toggle between raw code editor and visual preview', 
                icon: props.viewMode === 'preview' ? Code2 : Eye, 
                color: 'text-indigo-400', 
                action: () => emit('change-view-mode', props.viewMode === 'preview' ? 'code' : 'preview') 
            },
            { 
                id: 'action-cv', 
                title: 'Download Curriculum Vitae (CV)', 
                desc: 'Get a copy of Ikbal Muhammad resume PDF', 
                icon: Download, 
                color: 'text-emerald-400', 
                action: () => emit('download-cv') 
            },
            { 
                id: 'action-github', 
                title: 'Visit GitHub Profile', 
                desc: 'Open GitHub in a new browser tab', 
                icon: Github, 
                color: 'text-zinc-300', 
                action: () => {
                    const url = props.profile.socials?.github || 'https://github.com';
                    window.open(url, '_blank');
                    emit('close');
                } 
            },
            { 
                id: 'action-linkedin', 
                title: 'Visit LinkedIn Profile', 
                desc: 'Connect with Ikbal on LinkedIn', 
                icon: Linkedin, 
                color: 'text-blue-400', 
                action: () => {
                    const url = props.profile.socials?.linkedin || 'https://linkedin.com';
                    window.open(url, '_blank');
                    emit('close');
                } 
            },
        ]
    }
]);

const flatFilteredItems = computed(() => {
    const q = searchQuery.value.trim().toLowerCase();
    const result = [];
    allCommands.value.forEach(group => {
        group.items.forEach(item => {
            if (!q || item.title.toLowerCase().includes(q) || item.desc.toLowerCase().includes(q)) {
                result.push(item);
            }
        });
    });
    return result;
});

watch(() => props.isOpen, (newVal) => {
    if (newVal) {
        searchQuery.value = '';
        selectedIndex.value = 0;
        nextTick(() => {
            searchInput.value?.focus();
        });
    }
});

const handleKeyDown = (e) => {
    if (!props.isOpen) return;

    if (e.key === 'ArrowDown') {
        e.preventDefault();
        if (selectedIndex.value < flatFilteredItems.value.length - 1) {
            selectedIndex.value++;
        } else {
            selectedIndex.value = 0;
        }
    } else if (e.key === 'ArrowUp') {
        e.preventDefault();
        if (selectedIndex.value > 0) {
            selectedIndex.value--;
        } else {
            selectedIndex.value = flatFilteredItems.value.length - 1;
        }
    } else if (e.key === 'Enter') {
        e.preventDefault();
        const selected = flatFilteredItems.value[selectedIndex.value];
        if (selected) {
            selected.action();
            emit('close');
        }
    } else if (e.key === 'Escape') {
        emit('close');
    }
};

onMounted(() => {
    window.addEventListener('keydown', handleKeyDown);
});

onUnmounted(() => {
    window.removeEventListener('keydown', handleKeyDown);
});
</script>

<template>
    <div 
        v-if="isOpen"
        class="fixed inset-0 z-50 flex items-start justify-center pt-20 px-4 bg-zinc-950/60 dark:bg-zinc-950/80 backdrop-blur-sm"
        @click.self="emit('close')"
    >
        <div class="w-full max-w-xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl shadow-2xl overflow-hidden font-mono text-xs animate-in fade-in zoom-in-95 duration-150">
            <!-- Search Bar Header -->
            <div class="flex items-center px-4 py-3 border-b border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950">
                <Search class="w-4 h-4 text-zinc-400 dark:text-zinc-500 mr-2.5 shrink-0" />
                <input
                    ref="searchInput"
                    v-model="searchQuery"
                    type="text"
                    placeholder="Type a command or search files... (e.g. projects, cv, theme)"
                    class="w-full bg-transparent border-0 p-0 text-zinc-900 dark:text-white placeholder-zinc-400 dark:placeholder-zinc-500 focus:ring-0 focus:outline-none text-sm font-sans"
                />
                <button
                    @click="emit('close')"
                    class="p-1 rounded text-zinc-400 dark:text-zinc-500 hover:text-zinc-900 dark:hover:text-white hover:bg-zinc-200 dark:hover:bg-zinc-800 transition-colors"
                >
                    <X class="w-4 h-4" />
                </button>
            </div>

            <!-- Command List -->
            <div class="max-h-80 overflow-y-auto p-2 space-y-1">
                <div v-if="flatFilteredItems.length === 0" class="py-8 text-center text-zinc-500 font-sans">
                    No matching commands or files found for "<span class="text-zinc-800 dark:text-zinc-300">{{ searchQuery }}</span>"
                </div>

                <div
                    v-for="(item, idx) in flatFilteredItems"
                    :key="item.id"
                    @click="item.action(); emit('close')"
                    @mouseenter="selectedIndex = idx"
                    :class="[
                        'w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-left cursor-pointer transition-colors',
                        selectedIndex === idx
                            ? 'bg-indigo-600 text-white'
                            : 'text-zinc-800 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800/80'
                    ]"
                >
                    <div class="flex items-center space-x-3 truncate">
                        <component :is="item.icon" :class="['w-4 h-4 shrink-0', selectedIndex === idx ? 'text-white' : item.color]" />
                        <div class="truncate">
                            <div class="font-sans font-semibold text-xs leading-snug">{{ item.title }}</div>
                            <div :class="['text-[11px] truncate', selectedIndex === idx ? 'text-indigo-100' : 'text-zinc-500 dark:text-zinc-400']">
                                {{ item.desc }}
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center space-x-1.5 shrink-0 ml-2">
                        <span 
                            :class="[
                                'text-[10px] px-1.5 py-0.5 rounded border',
                                selectedIndex === idx 
                                    ? 'bg-indigo-700/60 text-white border-indigo-400/40' 
                                    : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 border-zinc-200 dark:border-zinc-700'
                            ]"
                        >
                            <CornerDownLeft class="w-3 h-3 inline" />
                        </span>
                    </div>
                </div>
            </div>

            <!-- Modal Footer Hints -->
            <div class="px-4 py-2 bg-zinc-50 dark:bg-zinc-950 border-t border-zinc-200 dark:border-zinc-800 flex items-center justify-between text-zinc-500 text-[11px] font-sans">
                <div class="flex items-center space-x-3">
                    <span><kbd class="px-1 py-0.5 bg-zinc-200 dark:bg-zinc-800 rounded border border-zinc-300 dark:border-zinc-700 font-mono text-[10px] text-zinc-700 dark:text-zinc-300">↑↓</kbd> Navigate</span>
                    <span><kbd class="px-1 py-0.5 bg-zinc-200 dark:bg-zinc-800 rounded border border-zinc-300 dark:border-zinc-700 font-mono text-[10px] text-zinc-700 dark:text-zinc-300">↵</kbd> Select</span>
                    <span><kbd class="px-1 py-0.5 bg-zinc-200 dark:bg-zinc-800 rounded border border-zinc-300 dark:border-zinc-700 font-mono text-[10px] text-zinc-700 dark:text-zinc-300">esc</kbd> Close</span>
                </div>
                <div>
                    IKBAL WORKSPACE
                </div>
            </div>
        </div>
    </div>
</template>
