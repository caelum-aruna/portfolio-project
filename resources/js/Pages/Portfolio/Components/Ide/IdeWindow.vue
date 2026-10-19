<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { 
    Maximize2, 
    Minimize2, 
    Search, 
    Sun, 
    Moon, 
    Menu, 
    X, 
    LayoutTemplate, 
    Monitor,
    LogIn,
    LayoutDashboard
} from 'lucide-vue-next';
import { Link } from '@inertiajs/vue3';

import IdeActivityBar from './IdeActivityBar.vue';
import IdeSidebar from './IdeSidebar.vue';
import IdeTabs from './IdeTabs.vue';
import IdeStatusBar from './IdeStatusBar.vue';
import IdeCommandPalette from './IdeCommandPalette.vue';

import IdeOverview from './IdeOverview.vue';
import IdeProjects from './IdeProjects.vue';
import IdeSkills from './IdeSkills.vue';
import IdeExperience from './IdeExperience.vue';
import IdeContact from './IdeContact.vue';
import IdeReadme from './IdeReadme.vue';

const props = defineProps({
    profile: {
        type: Object,
        required: true,
    },
    skills: {
        type: Array,
        required: true,
    },
    projects: {
        type: Array,
        required: true,
    },
    experiences: {
        type: Array,
        required: true,
    },
    canLogin: Boolean,
    auth: Object,
});

const emit = defineEmits(['switch-to-classic']);

// State
const isDark = ref(true);
const isSidebarOpen = ref(true);
const isCommandPaletteOpen = ref(false);
const isFullscreen = ref(false);
const isMobileSidebarOpen = ref(false);

const activeFile = ref('Overview.vue');
const openTabs = ref(['Overview.vue', 'Projects.vue', 'TechArsenal.json', 'Contact.sh']);
const viewMode = ref('preview'); // 'preview' or 'code'

// File opening
const openFile = (fileName) => {
    activeFile.value = fileName;
    if (!openTabs.value.includes(fileName)) {
        openTabs.value.push(fileName);
    }
    isMobileSidebarOpen.value = false;
};

// Tab closing
const closeTab = (fileName) => {
    const idx = openTabs.value.indexOf(fileName);
    if (idx !== -1) {
        openTabs.value.splice(idx, 1);
        if (activeFile.value === fileName) {
            if (openTabs.value.length > 0) {
                activeFile.value = openTabs.value[Math.max(0, idx - 1)];
            } else {
                openFile('Overview.vue');
            }
        }
    }
};

// Theme toggle
const toggleTheme = () => {
    isDark.value = !isDark.value;
    if (isDark.value) {
        document.documentElement.classList.add('dark');
        localStorage.setItem('theme', 'dark');
    } else {
        document.documentElement.classList.remove('dark');
        localStorage.setItem('theme', 'light');
    }
};

// Fullscreen toggle
const toggleFullscreen = () => {
    if (!document.fullscreenElement) {
        document.documentElement.requestFullscreen().catch(() => {});
        isFullscreen.value = true;
    } else {
        if (document.exitFullscreen) {
            document.exitFullscreen().catch(() => {});
        }
        isFullscreen.value = false;
    }
};

// CV Download
const downloadCv = () => {
    const resumeUrl = props.profile?.resume_url;
    if (resumeUrl && resumeUrl !== '#') {
        window.open(resumeUrl, '_blank');
    } else {
        alert('Curriculum Vitae link: Silakan hubungi langsung via terminal Contact.sh atau email ke ' + (props.profile?.email || 'ikbal@email.com'));
    }
};

// Keyboard listener for Ctrl+K
const handleGlobalKeydown = (e) => {
    if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') {
        e.preventDefault();
        isCommandPaletteOpen.value = !isCommandPaletteOpen.value;
    }
};

onMounted(() => {
    window.addEventListener('keydown', handleGlobalKeydown);
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'light') {
        isDark.value = false;
        document.documentElement.classList.remove('dark');
    } else {
        isDark.value = true;
        document.documentElement.classList.add('dark');
    }

    // Auto-collapse sidebar on very small screens
    if (window.innerWidth < 768) {
        isSidebarOpen.value = false;
    }
});

onUnmounted(() => {
    window.removeEventListener('keydown', handleGlobalKeydown);
});
</script>

<template>
    <div class="h-screen w-screen overflow-hidden bg-zinc-100 dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 flex flex-col font-sans select-none antialiased">
        
        <!-- ================= TOP WINDOW TITLEBAR ================= -->
        <header class="h-10 bg-white dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-800 flex items-center justify-between px-3 shrink-0 z-30 select-none">
            
            <!-- Left: macOS Traffic Lights & Mobile Menu -->
            <div class="flex items-center space-x-3">
                <!-- Mobile Sidebar Toggle -->
                <button
                    @click="isMobileSidebarOpen = !isMobileSidebarOpen"
                    class="md:hidden p-1 rounded hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white"
                    title="Toggle Explorer"
                >
                    <Menu class="w-4 h-4" />
                </button>

                <!-- macOS Traffic Lights -->
                <div class="hidden sm:flex items-center space-x-2">
                    <!-- Red: Reset tabs to Overview -->
                    <button
                        @click="openFile('Overview.vue')"
                        title="Reset to Overview.vue"
                        class="w-3 h-3 rounded-full bg-rose-500 hover:bg-rose-600 transition-colors focus:outline-none"
                    ></button>

                    <!-- Yellow: Toggle Sidebar -->
                    <button
                        @click="isSidebarOpen = !isSidebarOpen"
                        title="Toggle Sidebar"
                        class="w-3 h-3 rounded-full bg-amber-500 hover:bg-amber-600 transition-colors focus:outline-none"
                    ></button>

                    <!-- Green: Toggle Fullscreen -->
                    <button
                        @click="toggleFullscreen"
                        title="Toggle Fullscreen"
                        class="w-3 h-3 rounded-full bg-emerald-500 hover:bg-emerald-600 transition-colors focus:outline-none"
                    ></button>
                </div>

                <!-- Window Title -->
                <div class="text-xs font-mono text-zinc-600 dark:text-zinc-400 hidden lg:flex items-center space-x-1.5 pl-2">
                    <span class="text-zinc-900 dark:text-white font-semibold font-heading">ikbal-portfolio</span>
                    <span class="text-zinc-400 dark:text-zinc-600">—</span>
                    <span class="text-zinc-600 dark:text-zinc-400">src/{{ activeFile }}</span>
                </div>
            </div>

            <!-- Center: Command Palette Trigger Button -->
            <div class="flex-1 max-w-sm sm:max-w-md mx-2">
                <button
                    @click="isCommandPaletteOpen = true"
                    class="w-full flex items-center justify-between px-3 py-1 bg-zinc-50 dark:bg-zinc-950 hover:bg-zinc-100 dark:hover:bg-zinc-800 border border-zinc-200 dark:border-zinc-800 rounded-md text-zinc-500 dark:text-zinc-400 hover:text-zinc-800 dark:hover:text-zinc-200 transition-colors text-xs font-sans"
                >
                    <div class="flex items-center space-x-2 truncate">
                        <Search class="w-3.5 h-3.5 text-zinc-400 dark:text-zinc-500 shrink-0" />
                        <span class="truncate">Search commands or files...</span>
                    </div>
                    <kbd class="hidden sm:inline-block px-1.5 py-0.5 rounded bg-zinc-200 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 border border-zinc-300 dark:border-zinc-700 font-mono text-[10px]">
                        Ctrl+K
                    </kbd>
                </button>
            </div>

            <!-- Right: Actions & Controls -->
            <div class="flex items-center space-x-2">
                <!-- Theme Toggle -->
                <button
                    @click="toggleTheme"
                    class="p-1.5 rounded hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-500 dark:text-zinc-400 hover:text-amber-500 dark:hover:text-amber-400 transition-colors"
                    title="Toggle Theme"
                >
                    <Sun v-if="isDark" class="w-4 h-4" />
                    <Moon v-else class="w-4 h-4" />
                </button>

                <!-- Switch to Classic Page Mode Toggle -->
                <button
                    @click="emit('switch-to-classic')"
                    class="hidden sm:flex items-center space-x-1 px-2.5 py-1 rounded bg-zinc-100 dark:bg-zinc-800 hover:bg-zinc-200 dark:hover:bg-zinc-700 text-zinc-700 dark:text-zinc-300 hover:text-zinc-900 dark:hover:text-white text-xs font-sans transition-colors border border-zinc-200 dark:border-zinc-700"
                    title="Switch to Single-Page Scroll View"
                >
                    <LayoutTemplate class="w-3.5 h-3.5 text-indigo-500 dark:text-indigo-400" />
                    <span>Classic View</span>
                </button>

                <!-- Fullscreen Button -->
                <button
                    @click="toggleFullscreen"
                    class="hidden sm:flex p-1.5 rounded hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white transition-colors"
                    title="Toggle Fullscreen"
                >
                    <Minimize2 v-if="isFullscreen" class="w-4 h-4" />
                    <Maximize2 v-else class="w-4 h-4" />
                </button>
            </div>
        </header>

        <!-- ================= MAIN WORKSPACE BODY ================= -->
        <div class="flex-1 flex overflow-hidden relative">
            
            <!-- 1. Activity Bar (Narrow left strip) -->
            <IdeActivityBar
                :is-sidebar-open="isSidebarOpen"
                :is-dark="isDark"
                :profile="profile"
                :auth="auth"
                :can-login="canLogin"
                @toggle-sidebar="isSidebarOpen = !isSidebarOpen"
                @open-command-palette="isCommandPaletteOpen = true"
                @open-file="openFile"
                @toggle-theme="toggleTheme"
            />

            <!-- 2. Desktop File Explorer Sidebar -->
            <IdeSidebar
                v-if="isSidebarOpen"
                :active-file="activeFile"
                :projects-count="projects.length"
                :skills-count="skills.length"
                @select-file="openFile"
                class="hidden md:flex"
            />

            <!-- 2b. Mobile Off-Canvas Sidebar -->
            <div 
                v-if="isMobileSidebarOpen"
                class="fixed inset-0 z-40 md:hidden flex"
            >
                <div 
                    class="fixed inset-0 bg-zinc-950/60 dark:bg-zinc-950/80 backdrop-blur-sm"
                    @click="isMobileSidebarOpen = false"
                ></div>

                <div class="relative w-72 max-w-xs h-full bg-white dark:bg-zinc-950 z-50 flex flex-col shadow-2xl">
                    <div class="p-3 bg-zinc-50 dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-800 flex items-center justify-between">
                        <span class="font-heading font-bold text-sm text-zinc-900 dark:text-white">File Explorer</span>
                        <button 
                            @click="isMobileSidebarOpen = false"
                            class="p-1 rounded text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white"
                        >
                            <X class="w-4 h-4" />
                        </button>
                    </div>

                    <IdeSidebar
                        :active-file="activeFile"
                        :projects-count="projects.length"
                        :skills-count="skills.length"
                        @select-file="openFile"
                        class="w-full flex-1"
                    />
                </div>
            </div>

            <!-- 3. Central Editor Area -->
            <main class="flex-1 flex flex-col overflow-hidden bg-white dark:bg-zinc-950 min-w-0">
                
                <!-- Editor Tabs & Path Bar -->
                <IdeTabs
                    :open-tabs="openTabs"
                    :active-tab="activeFile"
                    :view-mode="viewMode"
                    @select-tab="openFile"
                    @close-tab="closeTab"
                    @change-view-mode="viewMode = $event"
                />

                <!-- Active File Content View -->
                <div class="flex-1 overflow-hidden relative">
                    <!-- Overview.vue -->
                    <IdeOverview
                        v-if="activeFile === 'Overview.vue'"
                        :profile="profile"
                        :view-mode="viewMode"
                        @open-file="openFile"
                        @download-cv="downloadCv"
                    />

                    <!-- Projects.vue -->
                    <IdeProjects
                        v-else-if="activeFile === 'Projects.vue'"
                        :projects="projects"
                        :view-mode="viewMode"
                    />

                    <!-- TechArsenal.json -->
                    <IdeSkills
                        v-else-if="activeFile === 'TechArsenal.json'"
                        :skills="skills"
                        :profile="profile"
                        :view-mode="viewMode"
                    />

                    <!-- Journey.log -->
                    <IdeExperience
                        v-else-if="activeFile === 'Journey.log'"
                        :experiences="experiences"
                        :view-mode="viewMode"
                    />

                    <!-- Contact.sh -->
                    <IdeContact
                        v-else-if="activeFile === 'Contact.sh'"
                        :profile="profile"
                        :view-mode="viewMode"
                    />

                    <!-- README.md -->
                    <IdeReadme
                        v-else-if="activeFile === 'README.md'"
                        :profile="profile"
                        :view-mode="viewMode"
                        @open-file="openFile"
                        @download-cv="downloadCv"
                    />
                </div>

            </main>
        </div>

        <!-- ================= BOTTOM STATUS BAR ================= -->
        <IdeStatusBar
            :active-file="activeFile"
            :profile="profile"
        />

        <!-- ================= COMMAND PALETTE MODAL ================= -->
        <IdeCommandPalette
            :is-open="isCommandPaletteOpen"
            :profile="profile"
            :is-dark="isDark"
            :view-mode="viewMode"
            @close="isCommandPaletteOpen = false"
            @select-file="openFile"
            @toggle-theme="toggleTheme"
            @change-view-mode="viewMode = $event"
            @download-cv="downloadCv"
        />

    </div>
</template>
