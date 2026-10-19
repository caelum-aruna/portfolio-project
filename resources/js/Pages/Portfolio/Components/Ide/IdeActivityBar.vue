<script setup>
import { 
    Files, 
    Search, 
    GitBranch, 
    Terminal, 
    FileText, 
    Sun, 
    Moon, 
    Settings,
    User,
    LayoutDashboard
} from 'lucide-vue-next';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    isSidebarOpen: Boolean,
    activeView: String, // 'explorer', 'search', 'git', 'terminal'
    isDark: Boolean,
    profile: {
        type: Object,
        default: () => ({}),
    },
    auth: {
        type: Object,
        default: () => ({ user: null }),
    },
    canLogin: Boolean,
});

const emit = defineEmits([
    'toggle-sidebar', 
    'change-view', 
    'open-command-palette', 
    'open-file',
    'toggle-theme'
]);
</script>

<template>
    <aside class="w-12 md:w-13 bg-zinc-100 dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-800 flex flex-col justify-between items-center py-3 select-none z-20 shrink-0">
        <!-- Top Navigation Icons -->
        <div class="flex flex-col items-center space-y-3 w-full">
            <!-- Explorer Toggle Button -->
            <button
                @click="emit('toggle-sidebar')"
                title="Explorer (Toggle Sidebar)"
                :class="[
                    'w-10 h-10 flex items-center justify-center rounded-lg transition-all relative group',
                    isSidebarOpen 
                        ? 'text-zinc-900 dark:text-white bg-zinc-200 dark:bg-zinc-800' 
                        : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white hover:bg-zinc-200/60 dark:hover:bg-zinc-800/60'
                ]"
            >
                <span 
                    v-if="isSidebarOpen" 
                    class="absolute left-0 top-2 bottom-2 w-0.5 bg-indigo-500 rounded-r"
                ></span>
                <Files class="w-5 h-5" />
                <span class="sr-only">Explorer</span>
            </button>

            <!-- Search / Command Palette -->
            <button
                @click="emit('open-command-palette')"
                title="Search / Command Palette (Ctrl+K)"
                class="w-10 h-10 flex items-center justify-center rounded-lg text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white hover:bg-zinc-200/60 dark:hover:bg-zinc-800/60 transition-all"
            >
                <Search class="w-5 h-5" />
                <span class="sr-only">Search</span>
            </button>

            <!-- Git Source Control -->
            <button
                @click="emit('open-file', 'Journey.log')"
                title="Source Control / Career Commits (Journey.log)"
                class="w-10 h-10 flex items-center justify-center rounded-lg text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white hover:bg-zinc-200/60 dark:hover:bg-zinc-800/60 transition-all relative"
            >
                <GitBranch class="w-5 h-5" />
                <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-indigo-500 rounded-full"></span>
                <span class="sr-only">Git Log</span>
            </button>

            <!-- Terminal / Contact -->
            <button
                @click="emit('open-file', 'Contact.sh')"
                title="Interactive Terminal (Contact.sh)"
                class="w-10 h-10 flex items-center justify-center rounded-lg text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white hover:bg-zinc-200/60 dark:hover:bg-zinc-800/60 transition-all relative"
            >
                <Terminal class="w-5 h-5" />
                <span class="sr-only">Terminal</span>
            </button>

            <!-- Documentation / README -->
            <button
                @click="emit('open-file', 'README.md')"
                title="System Documentation (README.md)"
                class="w-10 h-10 flex items-center justify-center rounded-lg text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white hover:bg-zinc-200/60 dark:hover:bg-zinc-800/60 transition-all"
            >
                <FileText class="w-5 h-5" />
                <span class="sr-only">README</span>
            </button>
        </div>

        <!-- Bottom Actions -->
        <div class="flex flex-col items-center space-y-3 w-full">
            <!-- Theme Toggle -->
            <button
                @click="emit('toggle-theme')"
                title="Toggle Theme (Dark / Light)"
                class="w-10 h-10 flex items-center justify-center rounded-lg text-zinc-500 dark:text-zinc-400 hover:text-amber-500 dark:hover:text-amber-400 hover:bg-zinc-200/60 dark:hover:bg-zinc-800/60 transition-all"
            >
                <Sun v-if="isDark" class="w-5 h-5" />
                <Moon v-else class="w-5 h-5" />
                <span class="sr-only">Toggle Theme</span>
            </button>

            <!-- Admin Link (Only visible when authenticated) -->
            <div v-if="auth?.user">
                <Link
                    href="/dashboard"
                    title="Admin Dashboard"
                    class="w-10 h-10 flex items-center justify-center rounded-lg text-indigo-400 bg-indigo-950/60 hover:bg-indigo-900 border border-indigo-700/50 transition-all"
                >
                    <LayoutDashboard class="w-4 h-4" />
                </Link>
            </div>

            <!-- Profile Avatar Thumbnail -->
            <button
                @click="emit('open-file', 'Overview.vue')"
                title="View Profile Overview"
                class="w-8 h-8 rounded-full border-2 border-indigo-500 overflow-hidden relative group hover:scale-105 transition-transform"
            >
                <img 
                    v-if="profile?.hero_image" 
                    :src="profile.hero_image" 
                    :alt="profile.name || 'Ikbal'" 
                    class="w-full h-full object-cover"
                />
                <div v-else class="w-full h-full bg-indigo-600 flex items-center justify-center text-white text-xs font-bold">
                    IM
                </div>
            </button>
        </div>
    </aside>
</template>
