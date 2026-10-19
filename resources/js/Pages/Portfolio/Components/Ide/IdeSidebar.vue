<script setup>
import { ref } from 'vue';
import { 
    ChevronDown, 
    ChevronRight, 
    Folder, 
    FolderOpen, 
    FileCode2, 
    FileJson, 
    Terminal, 
    FileText, 
    FileSpreadsheet, 
    MoreHorizontal,
    Code,
    Sparkles
} from 'lucide-vue-next';

const props = defineProps({
    activeFile: {
        type: String,
        default: 'Overview.vue',
    },
    projectsCount: {
        type: Number,
        default: 0,
    },
    skillsCount: {
        type: Number,
        default: 0,
    },
});

const emit = defineEmits(['select-file']);

// Folder open states
const folders = ref({
    root: true,
    src: true,
    projects: true,
    docs: true,
});

const toggleFolder = (key) => {
    folders.value[key] = !folders.value[key];
};

const files = [
    {
        name: 'Overview.vue',
        path: 'src/Overview.vue',
        type: 'vue',
        badge: 'Hero',
        badgeColor: 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30',
        folder: 'src',
    },
    {
        name: 'Projects.vue',
        path: 'src/projects/Projects.vue',
        type: 'vue',
        badge: props.projectsCount ? `${props.projectsCount}` : 'All',
        badgeColor: 'bg-indigo-500/20 text-indigo-400 border border-indigo-500/30',
        folder: 'projects',
    },
    {
        name: 'TechArsenal.json',
        path: 'src/TechArsenal.json',
        type: 'json',
        badge: props.skillsCount ? `${props.skillsCount}+` : 'Skills',
        badgeColor: 'bg-amber-500/20 text-amber-400 border border-amber-500/30',
        folder: 'src',
    },
    {
        name: 'Journey.log',
        path: 'src/Journey.log',
        type: 'log',
        badge: 'Career',
        badgeColor: 'bg-purple-500/20 text-purple-400 border border-purple-500/30',
        folder: 'src',
    },
    {
        name: 'Contact.sh',
        path: 'src/Contact.sh',
        type: 'sh',
        badge: 'Form',
        badgeColor: 'bg-sky-500/20 text-sky-400 border border-sky-500/30',
        folder: 'src',
    },
    {
        name: 'README.md',
        path: 'docs/README.md',
        type: 'md',
        badge: 'Docs',
        badgeColor: 'bg-zinc-500/20 text-zinc-400 border border-zinc-500/30',
        folder: 'docs',
    },
];
</script>

<template>
    <div class="w-64 sm:w-68 bg-zinc-50 dark:bg-zinc-950 text-zinc-700 dark:text-zinc-300 border-r border-zinc-200 dark:border-zinc-800 flex flex-col h-full select-none font-mono text-xs z-10 shrink-0">
        <!-- Sidebar Header -->
        <div class="h-9 px-3 flex items-center justify-between border-b border-zinc-200 dark:border-zinc-800 font-sans text-xs tracking-wider uppercase font-bold text-zinc-500 dark:text-zinc-400">
            <span>Explorer</span>
            <span class="text-[11px] text-zinc-500 font-mono lowercase">workspace</span>
        </div>

        <!-- File Tree -->
        <div class="flex-1 overflow-y-auto py-2 px-1 space-y-0.5">
            <!-- Root Folder: ikbal-portfolio -->
            <div>
                <button
                    @click="toggleFolder('root')"
                    class="w-full flex items-center space-x-1.5 px-2 py-1 text-left text-zinc-800 dark:text-zinc-200 hover:bg-zinc-200/60 dark:hover:bg-zinc-900 rounded font-bold tracking-wide"
                >
                    <ChevronDown v-if="folders.root" class="w-3.5 h-3.5 text-zinc-500 dark:text-zinc-400 shrink-0" />
                    <ChevronRight v-else class="w-3.5 h-3.5 text-zinc-500 dark:text-zinc-400 shrink-0" />
                    <FolderOpen v-if="folders.root" class="w-4 h-4 text-indigo-500 dark:text-indigo-400 shrink-0" />
                    <Folder v-else class="w-4 h-4 text-indigo-500 dark:text-indigo-400 shrink-0" />
                    <span class="truncate font-heading tracking-normal">IKBAL-PORTFOLIO</span>
                </button>

                <!-- Sub-items inside root -->
                <div v-show="folders.root" class="pl-3 space-y-0.5 border-l border-zinc-200 dark:border-zinc-800/80 ml-3.5 mt-0.5">
                    
                    <!-- Folder: src -->
                    <div>
                        <button
                            @click="toggleFolder('src')"
                            class="w-full flex items-center space-x-1.5 px-2 py-1 text-left text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200/60 dark:hover:bg-zinc-900 rounded"
                        >
                            <ChevronDown v-if="folders.src" class="w-3.5 h-3.5 text-zinc-400 dark:text-zinc-500 shrink-0" />
                            <ChevronRight v-else class="w-3.5 h-3.5 text-zinc-400 dark:text-zinc-500 shrink-0" />
                            <FolderOpen v-if="folders.src" class="w-3.5 h-3.5 text-amber-500 dark:text-amber-400 shrink-0" />
                            <Folder v-else class="w-3.5 h-3.5 text-amber-500 dark:text-amber-400 shrink-0" />
                            <span>src</span>
                        </button>

                        <!-- Items inside src -->
                        <div v-show="folders.src" class="pl-3 space-y-0.5 border-l border-zinc-200 dark:border-zinc-800/60 ml-3.5 mt-0.5">
                            
                            <!-- Overview.vue -->
                            <button
                                @click="emit('select-file', 'Overview.vue')"
                                :class="[
                                    'w-full flex items-center justify-between px-2 py-1.5 rounded text-left transition-colors group',
                                    activeFile === 'Overview.vue'
                                        ? 'bg-zinc-200/80 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 font-medium border-l-2 border-emerald-500'
                                        : 'text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-200 hover:bg-zinc-200/50 dark:hover:bg-zinc-900'
                                ]"
                            >
                                <div class="flex items-center space-x-2 truncate">
                                    <span class="text-[11px] font-bold text-emerald-600 dark:text-emerald-400 bg-emerald-100 dark:bg-emerald-950/80 px-1 py-0.2 rounded border border-emerald-300 dark:border-emerald-800/50">V</span>
                                    <span class="truncate">Overview.vue</span>
                                </div>
                                <span class="text-[10px] px-1.5 py-0.2 rounded bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20">Bio</span>
                            </button>

                            <!-- Folder: projects -->
                            <div>
                                <button
                                    @click="toggleFolder('projects')"
                                    class="w-full flex items-center space-x-1.5 px-2 py-1 text-left text-zinc-600 dark:text-zinc-400 hover:bg-zinc-200/60 dark:hover:bg-zinc-900 rounded"
                                >
                                    <ChevronDown v-if="folders.projects" class="w-3 h-3 text-zinc-400 dark:text-zinc-500 shrink-0" />
                                    <ChevronRight v-else class="w-3 h-3 text-zinc-400 dark:text-zinc-500 shrink-0" />
                                    <FolderOpen v-if="folders.projects" class="w-3.5 h-3.5 text-indigo-500 dark:text-indigo-400 shrink-0" />
                                    <Folder v-else class="w-3.5 h-3.5 text-indigo-500 dark:text-indigo-400 shrink-0" />
                                    <span>projects</span>
                                </button>

                                <div v-show="folders.projects" class="pl-3 space-y-0.5 border-l border-zinc-200 dark:border-zinc-800/60 ml-3 mt-0.5">
                                    <!-- Projects.vue -->
                                    <button
                                        @click="emit('select-file', 'Projects.vue')"
                                        :class="[
                                            'w-full flex items-center justify-between px-2 py-1.5 rounded text-left transition-colors group',
                                            activeFile === 'Projects.vue'
                                                ? 'bg-zinc-200/80 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 font-medium border-l-2 border-indigo-500'
                                                : 'text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-200 hover:bg-zinc-200/50 dark:hover:bg-zinc-900'
                                        ]"
                                    >
                                        <div class="flex items-center space-x-2 truncate">
                                            <span class="text-[11px] font-bold text-emerald-600 dark:text-emerald-400 bg-emerald-100 dark:bg-emerald-950/80 px-1 py-0.2 rounded border border-emerald-300 dark:border-emerald-800/50">V</span>
                                            <span class="truncate">Projects.vue</span>
                                        </div>
                                        <span class="text-[10px] px-1.5 py-0.2 rounded bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 border border-indigo-500/20">
                                            {{ projectsCount }}
                                        </span>
                                    </button>
                                </div>
                            </div>

                            <!-- TechArsenal.json -->
                            <button
                                @click="emit('select-file', 'TechArsenal.json')"
                                :class="[
                                    'w-full flex items-center justify-between px-2 py-1.5 rounded text-left transition-colors group',
                                    activeFile === 'TechArsenal.json'
                                        ? 'bg-zinc-200/80 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 font-medium border-l-2 border-amber-500'
                                        : 'text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-200 hover:bg-zinc-200/50 dark:hover:bg-zinc-900'
                                ]"
                            >
                                <div class="flex items-center space-x-2 truncate">
                                    <span class="text-[11px] font-bold text-amber-600 dark:text-amber-400 bg-amber-100 dark:bg-amber-950/80 px-1 py-0.2 rounded border border-amber-300 dark:border-amber-800/50">{}</span>
                                    <span class="truncate">TechArsenal.json</span>
                                </div>
                                <span class="text-[10px] px-1.5 py-0.2 rounded bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/20">
                                    Skills
                                </span>
                            </button>

                            <!-- Journey.log -->
                            <button
                                @click="emit('select-file', 'Journey.log')"
                                :class="[
                                    'w-full flex items-center justify-between px-2 py-1.5 rounded text-left transition-colors group',
                                    activeFile === 'Journey.log'
                                        ? 'bg-zinc-200/80 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 font-medium border-l-2 border-purple-500'
                                        : 'text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-200 hover:bg-zinc-200/50 dark:hover:bg-zinc-900'
                                ]"
                            >
                                <div class="flex items-center space-x-2 truncate">
                                    <span class="text-[10px] font-bold text-purple-600 dark:text-purple-400 bg-purple-100 dark:bg-purple-950/80 px-1 py-0.2 rounded border border-purple-300 dark:border-purple-800/50">LOG</span>
                                    <span class="truncate">Journey.log</span>
                                </div>
                                <span class="text-[10px] px-1.5 py-0.2 rounded bg-purple-500/10 text-purple-600 dark:text-purple-400 border border-purple-500/20">
                                    Career
                                </span>
                            </button>

                            <!-- Contact.sh -->
                            <button
                                @click="emit('select-file', 'Contact.sh')"
                                :class="[
                                    'w-full flex items-center justify-between px-2 py-1.5 rounded text-left transition-colors group',
                                    activeFile === 'Contact.sh'
                                        ? 'bg-zinc-200/80 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 font-medium border-l-2 border-sky-500'
                                        : 'text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-200 hover:bg-zinc-200/50 dark:hover:bg-zinc-900'
                                ]"
                            >
                                <div class="flex items-center space-x-2 truncate">
                                    <span class="text-[10px] font-bold text-sky-600 dark:text-sky-400 bg-sky-100 dark:bg-sky-950/80 px-1 py-0.2 rounded border border-sky-300 dark:border-sky-800/50">&gt;_</span>
                                    <span class="truncate">Contact.sh</span>
                                </div>
                                <span class="text-[10px] px-1.5 py-0.2 rounded bg-sky-500/10 text-sky-600 dark:text-sky-400 border border-sky-500/20">
                                    Terminal
                                </span>
                            </button>

                        </div>
                    </div>

                    <!-- Folder: docs -->
                    <div>
                        <button
                            @click="toggleFolder('docs')"
                            class="w-full flex items-center space-x-1.5 px-2 py-1 text-left text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200/60 dark:hover:bg-zinc-900 rounded"
                        >
                            <ChevronDown v-if="folders.docs" class="w-3.5 h-3.5 text-zinc-400 dark:text-zinc-500 shrink-0" />
                            <ChevronRight v-else class="w-3.5 h-3.5 text-zinc-400 dark:text-zinc-500 shrink-0" />
                            <FolderOpen v-if="folders.docs" class="w-3.5 h-3.5 text-indigo-500 dark:text-indigo-400 shrink-0" />
                            <Folder v-else class="w-3.5 h-3.5 text-indigo-500 dark:text-indigo-400 shrink-0" />
                            <span>docs</span>
                        </button>

                        <div v-show="folders.docs" class="pl-3 space-y-0.5 border-l border-zinc-200 dark:border-zinc-800/60 ml-3.5 mt-0.5">
                            <!-- README.md -->
                            <button
                                @click="emit('select-file', 'README.md')"
                                :class="[
                                    'w-full flex items-center justify-between px-2 py-1.5 rounded text-left transition-colors group',
                                    activeFile === 'README.md'
                                        ? 'bg-zinc-200/80 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 font-medium border-l-2 border-blue-500'
                                        : 'text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-200 hover:bg-zinc-200/50 dark:hover:bg-zinc-900'
                                ]"
                            >
                                <div class="flex items-center space-x-2 truncate">
                                    <span class="text-[10px] font-bold text-blue-600 dark:text-blue-400 bg-blue-100 dark:bg-blue-950/80 px-1 py-0.2 rounded border border-blue-300 dark:border-blue-800/50">MD</span>
                                    <span class="truncate">README.md</span>
                                </div>
                                <span class="text-[10px] px-1.5 py-0.2 rounded bg-zinc-200 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-400">
                                    About
                                </span>
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Sidebar Footer Status -->
        <div class="p-3 border-t border-zinc-200 dark:border-zinc-800/80 bg-zinc-50 dark:bg-zinc-950 text-[11px] text-zinc-500 flex items-center justify-between">
            <span class="flex items-center space-x-1">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                <span>Branch: main</span>
            </span>
            <span class="font-sans text-[10px] text-zinc-500">v2.4.0</span>
        </div>
    </div>
</template>
