<script setup>
import { ref, computed, onMounted } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import { 
    FolderGit2, 
    ExternalLink, 
    Github, 
    Sparkles, 
    ArrowUpRight,
    ArrowLeft,
    Search,
    X,
    Sun,
    Moon,
    Terminal,
    Eye,
    LayoutDashboard,
    Layers,
    Filter
} from 'lucide-vue-next';
import ProjectModal from './Components/ProjectModal.vue';
import Footer from './Components/Footer.vue';

const props = defineProps({
    profile: {
        type: Object,
        default: () => ({}),
    },
    projects: {
        type: Array,
        required: true,
    },
    canLogin: Boolean,
    auth: {
        type: Object,
        default: () => ({ user: null }),
    },
});

const isDark = ref(true);
const searchQuery = ref('');
const activeCategory = ref('All');
const selectedProject = ref(null);
const isModalOpen = ref(false);

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

onMounted(() => {
    isDark.value = document.documentElement.classList.contains('dark');
});

// Dynamic category list from projects
const categories = computed(() => {
    const list = ['All'];
    props.projects.forEach(p => {
        if (p.category && !list.includes(p.category)) {
            list.push(p.category);
        }
    });
    return list;
});

// Real-time filtered projects by category AND search query
const filteredProjects = computed(() => {
    let list = props.projects;

    if (activeCategory.value !== 'All') {
        list = list.filter(p => p.category === activeCategory.value);
    }

    if (searchQuery.value.trim() !== '') {
        const query = searchQuery.value.toLowerCase().trim();
        list = list.filter(p => {
            const titleMatch = (p.title || '').toLowerCase().includes(query);
            const descMatch = (p.description || '').toLowerCase().includes(query);
            const catMatch = (p.category || '').toLowerCase().includes(query);
            const techMatch = Array.isArray(p.tech_stack) 
                ? p.tech_stack.some(t => String(t).toLowerCase().includes(query))
                : false;

            return titleMatch || descMatch || catMatch || techMatch;
        });
    }

    return list;
});

const resetFilters = () => {
    searchQuery.value = '';
    activeCategory.value = 'All';
};

const openProjectModal = (project) => {
    selectedProject.value = project;
    isModalOpen.value = true;
};

const closeProjectModal = () => {
    isModalOpen.value = false;
    selectedProject.value = null;
};
</script>

<template>
    <div class="min-h-screen bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 selection:bg-indigo-600 selection:text-white relative font-sans flex flex-col justify-between">
        <Head :title="profile.name ? `All Projects & Case Studies — ${profile.name}` : 'All Projects & Case Studies — Ikbal Muhammad'" />

        <!-- ================= TOP STICKY NAVBAR ================= -->
        <header class="sticky top-0 left-0 right-0 z-40 bg-white/90 dark:bg-zinc-950/90 backdrop-blur-md border-b border-zinc-200 dark:border-zinc-800 transition-colors">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3.5 flex items-center justify-between">
                
                <!-- Left: Brand Logo & Back Button -->
                <div class="flex items-center space-x-4">
                    <Link 
                        :href="route('portfolio')"
                        class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl text-xs font-semibold font-mono bg-zinc-100 dark:bg-zinc-900 text-zinc-700 dark:text-zinc-300 hover:text-zinc-900 dark:hover:text-white border border-zinc-200 dark:border-zinc-800 hover:border-zinc-300 dark:hover:border-zinc-700 transition-all group"
                        title="Return to Portfolio Homepage"
                    >
                        <ArrowLeft class="w-3.5 h-3.5 group-hover:-translate-x-0.5 transition-transform" />
                        <span>Back to Portfolio</span>
                    </Link>

                    <div class="hidden sm:block h-4 w-px bg-zinc-200 dark:bg-zinc-800"></div>

                    <!-- Brand Link -->
                    <Link :href="route('portfolio')" class="hidden sm:flex items-center gap-2 tracking-tight">
                        <div class="w-7 h-7 rounded-lg bg-zinc-900 text-white dark:bg-white dark:text-zinc-900 flex items-center justify-center">
                            <Terminal class="w-3.5 h-3.5 text-white dark:text-zinc-900" />
                        </div>
                        <span class="font-heading font-bold text-sm text-zinc-900 dark:text-white tracking-tight">
                            Ikbal<span class="text-indigo-600 dark:text-indigo-400">.dev</span>
                        </span>
                    </Link>
                </div>

                <!-- Right: Actions & Theme Toggle -->
                <div class="flex items-center space-x-2.5">
                    <!-- Theme Toggle -->
                    <button 
                        @click="toggleTheme" 
                        type="button"
                        aria-label="Toggle Dark Mode"
                        class="p-2 rounded-xl border border-zinc-200 dark:border-zinc-800 bg-zinc-100 dark:bg-zinc-900 text-zinc-700 dark:text-zinc-300 hover:text-zinc-900 dark:hover:text-white transition-colors"
                    >
                        <Sun v-if="isDark" class="w-4 h-4 text-amber-500" />
                        <Moon v-else class="w-4 h-4 text-zinc-700" />
                    </button>

                    <!-- Admin Dashboard Link (if logged in) -->
                    <template v-if="auth?.user">
                        <Link 
                            :href="route('dashboard')"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold bg-zinc-100 dark:bg-zinc-900 text-zinc-800 dark:text-zinc-200 hover:bg-zinc-200 dark:hover:bg-zinc-800 transition-colors border border-zinc-200 dark:border-zinc-800"
                        >
                            <LayoutDashboard class="w-3.5 h-3.5 text-indigo-500" />
                            <span class="hidden md:inline">Dashboard</span>
                        </Link>
                    </template>

                    <!-- Contact Hire Me CTA -->
                    <a 
                        :href="route('portfolio') + '#contact'" 
                        class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-semibold font-sans bg-zinc-900 text-white hover:bg-zinc-800 dark:bg-white dark:text-zinc-900 dark:hover:bg-zinc-100 shadow-sm transition-colors"
                    >
                        <span>Hire Me</span>
                        <ArrowUpRight class="w-3.5 h-3.5" />
                    </a>
                </div>

            </div>
        </header>

        <!-- ================= MAIN CONTENT ================= -->
        <main class="flex-1 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 w-full space-y-12">
            
            <!-- Breadcrumbs -->
            <nav class="flex items-center space-x-2 text-xs font-mono text-zinc-500">
                <Link :href="route('portfolio')" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                    Home
                </Link>
                <span>/</span>
                <span class="text-zinc-900 dark:text-white font-medium">Projects Archive</span>
            </nav>

            <!-- Hero Header -->
            <div class="space-y-4 max-w-3xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 dark:bg-indigo-950/60 border border-indigo-200 dark:border-indigo-800/60 text-indigo-600 dark:text-indigo-400 text-xs font-mono font-semibold uppercase tracking-wider">
                    <FolderGit2 class="w-3.5 h-3.5" />
                    <span>Project Archive & Case Studies</span>
                </div>
                
                <h1 class="font-heading text-3xl sm:text-4xl lg:text-5xl font-extrabold text-zinc-900 dark:text-white tracking-tight">
                    All Projects & Engineering Works
                </h1>
                
                <p class="font-sans text-base sm:text-lg text-zinc-600 dark:text-zinc-400 leading-relaxed">
                    Explore the complete collection of full-stack web applications, business platforms, open-source utilities, and technical architectures built by {{ profile.name || 'Ikbal Muhammad' }}.
                </p>

                <!-- Stats summary badges -->
                <div class="pt-2 flex flex-wrap items-center gap-3 text-xs font-mono">
                    <span class="px-3 py-1 rounded-lg bg-zinc-100 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 text-zinc-700 dark:text-zinc-300">
                        Total Works: <strong class="text-zinc-900 dark:text-white font-bold">{{ projects.length }}</strong>
                    </span>
                    <span class="px-3 py-1 rounded-lg bg-zinc-100 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 text-zinc-700 dark:text-zinc-300">
                        Categories: <strong class="text-zinc-900 dark:text-white font-bold">{{ categories.length - 1 }}</strong>
                    </span>
                    <span class="px-3 py-1 rounded-lg bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/40 text-emerald-700 dark:text-emerald-400">
                        Live Prototypes Ready
                    </span>
                </div>
            </div>

            <!-- ================= SEARCH & FILTER TOOLBAR ================= -->
            <div class="space-y-4 pt-4 border-t border-zinc-200 dark:border-zinc-800/80">
                <div class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4">
                    
                    <!-- Search Input -->
                    <div class="relative flex-1 max-w-lg">
                        <Search class="w-4 h-4 text-zinc-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" />
                        <input 
                            v-model="searchQuery"
                            type="text" 
                            placeholder="Search by title, description, or tech stack (e.g. Vue, Laravel)..."
                            class="w-full pl-10 pr-9 py-2.5 rounded-xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 text-xs sm:text-sm text-zinc-900 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all font-sans"
                        />
                        <button
                            v-if="searchQuery"
                            @click="searchQuery = ''"
                            type="button"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 p-0.5 rounded-full"
                            title="Clear search"
                        >
                            <X class="w-3.5 h-3.5" />
                        </button>
                    </div>

                    <!-- Results Count Indicator -->
                    <div class="flex items-center space-x-2 text-xs font-mono text-zinc-500 dark:text-zinc-400 self-end md:self-center">
                        <Filter class="w-3.5 h-3.5 text-zinc-400" />
                        <span>Showing {{ filteredProjects.length }} of {{ projects.length }} projects</span>
                    </div>

                </div>

                <!-- Category Pills -->
                <div class="flex flex-wrap items-center gap-2">
                    <button 
                        v-for="cat in categories" 
                        :key="cat"
                        @click="activeCategory = cat"
                        type="button"
                        class="px-4 py-1.5 rounded-xl text-xs font-semibold font-sans transition-colors border"
                        :class="[
                            activeCategory === cat
                                ? 'bg-zinc-900 border-zinc-900 text-white dark:bg-white dark:border-white dark:text-zinc-900 shadow-sm'
                                : 'bg-white dark:bg-zinc-900 border-zinc-200 dark:border-zinc-800 text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white hover:border-zinc-300 dark:hover:border-zinc-700'
                        ]"
                    >
                        {{ cat }}
                    </button>
                </div>
            </div>

            <!-- ================= PROJECTS GRID ================= -->
            <div v-if="filteredProjects.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div 
                    v-for="project in filteredProjects" 
                    :key="project.id"
                    class="group flex flex-col rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-sm overflow-hidden hover:border-zinc-300 dark:hover:border-zinc-700 transition-colors"
                >
                    <!-- Card Thumbnail -->
                    <div class="relative h-52 sm:h-56 w-full overflow-hidden bg-zinc-900">
                        <img 
                            :src="project.thumbnail || '/images/tech-stack.png'" 
                            :alt="project.title"
                            class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-300 ease-out"
                            onerror="this.src='/images/tech-stack.png'"
                        />

                        <!-- Top Badges -->
                        <div class="absolute top-3 left-3 right-3 flex items-center justify-between">
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-mono font-semibold bg-zinc-900/90 text-white border border-white/10">
                                {{ project.category }}
                            </span>
                            <span 
                                v-if="project.is_featured"
                                class="flex items-center gap-1 px-2.5 py-0.5 rounded-lg text-[10px] font-mono font-bold bg-amber-400 text-zinc-950 shadow-sm"
                            >
                                <Sparkles class="w-3 h-3" />
                                Featured
                            </span>
                        </div>

                        <!-- Quick Preview Overlay Button -->
                        <button 
                            @click="openProjectModal(project)"
                            type="button"
                            class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 bg-zinc-950/60 transition-opacity duration-200"
                        >
                            <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-white text-zinc-900 text-xs font-bold shadow-md">
                                <Eye class="w-4 h-4 text-indigo-600" />
                                View Details
                            </span>
                        </button>
                    </div>

                    <!-- Card Content -->
                    <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                        <div class="space-y-2">
                            <h3 
                                @click="openProjectModal(project)"
                                class="font-heading text-lg font-bold text-zinc-900 dark:text-white hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors cursor-pointer line-clamp-1"
                            >
                                {{ project.title }}
                            </h3>
                            <p class="font-sans text-xs sm:text-sm text-zinc-600 dark:text-zinc-400 line-clamp-3 leading-relaxed">
                                {{ project.description }}
                            </p>
                        </div>

                        <!-- Tech Stack Tags -->
                        <div class="space-y-4 pt-2">
                            <div class="flex flex-wrap gap-1.5">
                                <span 
                                    v-for="(tech, idx) in (project.tech_stack || []).slice(0, 4)" 
                                    :key="idx"
                                    class="px-2 py-0.5 rounded text-[10px] font-mono bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300 border border-zinc-200 dark:border-zinc-700"
                                >
                                    {{ tech }}
                                </span>
                                <span 
                                    v-if="(project.tech_stack || []).length > 4"
                                    class="px-2 py-0.5 rounded text-[10px] font-mono bg-zinc-100 dark:bg-zinc-800 text-zinc-400"
                                >
                                    +{{ (project.tech_stack || []).length - 4 }}
                                </span>
                            </div>

                            <!-- Footer Links -->
                            <div class="pt-3 border-t border-zinc-100 dark:border-zinc-800 flex items-center justify-between">
                                <button 
                                    @click="openProjectModal(project)"
                                    type="button"
                                    class="text-xs font-semibold font-sans text-indigo-600 dark:text-indigo-400 hover:underline flex items-center gap-1"
                                >
                                    <span>Learn more</span>
                                    <ArrowUpRight class="w-3.5 h-3.5" />
                                </button>

                                <div class="flex items-center gap-2">
                                    <a 
                                        v-if="project.repo_url" 
                                        :href="project.repo_url" 
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        aria-label="GitHub Repository"
                                        class="p-2 rounded-lg bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white transition-colors"
                                    >
                                        <Github class="w-4 h-4" />
                                    </a>
                                    <a 
                                        v-if="project.demo_url" 
                                        :href="project.demo_url" 
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        aria-label="Live Demo"
                                        class="p-2 rounded-lg bg-zinc-100 dark:bg-zinc-800 text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 transition-colors"
                                    >
                                        <ExternalLink class="w-4 h-4" />
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Empty Search State -->
            <div 
                v-else 
                class="py-16 text-center rounded-2xl bg-white dark:bg-zinc-900 border border-dashed border-zinc-200 dark:border-zinc-800 p-8 space-y-4"
            >
                <div class="w-12 h-12 mx-auto rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center text-zinc-400">
                    <Search class="w-5 h-5" />
                </div>
                <div class="space-y-1">
                    <h3 class="font-heading font-bold text-base text-zinc-900 dark:text-white">
                        No projects found
                    </h3>
                    <p class="text-xs sm:text-sm text-zinc-500 max-w-sm mx-auto font-sans">
                        No projects matched your search "{{ searchQuery }}" in category "{{ activeCategory }}".
                    </p>
                </div>
                <div>
                    <button
                        @click="resetFilters"
                        type="button"
                        class="px-4 py-2 rounded-xl bg-zinc-900 text-white dark:bg-white dark:text-zinc-900 text-xs font-semibold hover:bg-zinc-800 dark:hover:bg-zinc-100 transition-colors"
                    >
                        Reset filters
                    </button>
                </div>
            </div>

            <!-- Project Details Modal Popup -->
            <ProjectModal 
                :project="selectedProject" 
                :is-open="isModalOpen" 
                @close="closeProjectModal" 
            />

        </main>

        <!-- ================= FOOTER ================= -->
        <Footer :profile="profile" />

    </div>
</template>
