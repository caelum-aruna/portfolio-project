<script setup>
import { ref, computed } from 'vue';
import { 
    FolderGit2, 
    ExternalLink, 
    Github, 
    Sparkles, 
    Layers, 
    ArrowUpRight,
    Eye
} from 'lucide-vue-next';
import ProjectModal from './ProjectModal.vue';

const props = defineProps({
    projects: {
        type: Array,
        required: true,
    },
});

const activeCategory = ref('All');
const selectedProject = ref(null);
const isModalOpen = ref(false);

const categories = computed(() => {
    const list = ['All'];
    props.projects.forEach(p => {
        if (p.category && !list.includes(p.category)) {
            list.push(p.category);
        }
    });
    return list;
});

const filteredProjects = computed(() => {
    if (activeCategory.value === 'All') {
        return props.projects;
    }
    return props.projects.filter(p => p.category === activeCategory.value);
});

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
    <section id="projects" class="py-24 relative overflow-hidden bg-slate-100/50 dark:bg-slate-900/40 border-y border-slate-200/80 dark:border-slate-800/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Section Header -->
            <div class="text-center max-w-3xl mx-auto space-y-3 mb-12">
                <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-600 dark:text-indigo-400 text-xs font-mono font-semibold uppercase tracking-wider">
                    <FolderGit2 class="w-3.5 h-3.5" />
                    <span>Selected Works</span>
                </div>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                    Featured Projects & Engineering Case Studies
                </h2>
                <p class="text-base sm:text-lg text-slate-600 dark:text-slate-400">
                    A collection of real-world applications engineered with modern architectures, high performance, and user-centric design.
                </p>
            </div>

            <!-- Category Filter Pills -->
            <div class="flex flex-wrap items-center justify-center gap-2 mb-14">
                <button 
                    v-for="cat in categories" 
                    :key="cat"
                    @click="activeCategory = cat"
                    type="button"
                    class="px-5 py-2.5 rounded-full text-xs sm:text-sm font-semibold transition-all duration-200 border"
                    :class="[
                        activeCategory === cat
                            ? 'bg-indigo-600 border-indigo-600 text-white shadow-lg shadow-indigo-500/25 scale-105'
                            : 'bg-white/80 dark:bg-slate-900/80 border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-300 hover:border-indigo-400 dark:hover:border-slate-700'
                    ]"
                >
                    {{ cat }}
                </button>
            </div>

            <!-- Projects Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div 
                    v-for="project in filteredProjects" 
                    :key="project.id"
                    class="group flex flex-col rounded-3xl bg-white dark:bg-[#0B0F17] border border-slate-200 dark:border-slate-800 shadow-xl overflow-hidden hover:border-indigo-500/50 hover:shadow-2xl hover:shadow-indigo-500/10 transition-all duration-300 hover:-translate-y-1.5"
                >
                    <!-- Card Thumbnail -->
                    <div class="relative h-52 sm:h-56 w-full overflow-hidden bg-slate-900">
                        <img 
                            :src="project.thumbnail || '/images/tech-stack.png'" 
                            :alt="project.title"
                            class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500 ease-out"
                            onerror="this.src='/images/tech-stack.png'"
                        />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>

                        <!-- Top Badges -->
                        <div class="absolute top-4 left-4 right-4 flex items-center justify-between">
                            <span class="px-3 py-1 rounded-full text-[11px] font-mono font-semibold bg-slate-900/80 text-white backdrop-blur-md border border-white/10">
                                {{ project.category }}
                            </span>
                            <span 
                                v-if="project.is_featured"
                                class="flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-mono font-bold bg-amber-500/90 text-slate-950 shadow-sm"
                            >
                                <Sparkles class="w-3 h-3" />
                                Featured
                            </span>
                        </div>

                        <!-- Quick Preview Overlay Button -->
                        <button 
                            @click="openProjectModal(project)"
                            type="button"
                            class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 bg-indigo-950/40 backdrop-blur-sm transition-opacity duration-300"
                        >
                            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white text-slate-900 text-xs font-bold shadow-lg transform translate-y-2 group-hover:translate-y-0 transition-transform">
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
                                class="text-xl font-extrabold text-slate-900 dark:text-white group-hover:text-indigo-500 transition-colors cursor-pointer line-clamp-1"
                            >
                                {{ project.title }}
                            </h3>
                            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 line-clamp-3 leading-relaxed">
                                {{ project.description }}
                            </p>
                        </div>

                        <!-- Tech Stack Tags -->
                        <div class="space-y-4 pt-2">
                            <div class="flex flex-wrap gap-1.5">
                                <span 
                                    v-for="(tech, idx) in (project.tech_stack || []).slice(0, 4)" 
                                    :key="idx"
                                    class="px-2.5 py-0.5 rounded-md text-[11px] font-mono bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-200/60 dark:border-slate-700/60"
                                >
                                    {{ tech }}
                                </span>
                                <span 
                                    v-if="(project.tech_stack || []).length > 4"
                                    class="px-2 py-0.5 rounded-md text-[11px] font-mono bg-slate-100 dark:bg-slate-800 text-slate-400"
                                >
                                    +{{ (project.tech_stack || []).length - 4 }}
                                </span>
                            </div>

                            <!-- Footer Links -->
                            <div class="pt-3 border-t border-slate-100 dark:border-slate-800/80 flex items-center justify-between">
                                <button 
                                    @click="openProjectModal(project)"
                                    type="button"
                                    class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 hover:underline flex items-center gap-1"
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
                                        class="p-2 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:text-indigo-500 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors"
                                    >
                                        <Github class="w-4 h-4" />
                                    </a>
                                    <a 
                                        v-if="project.demo_url" 
                                        :href="project.demo_url" 
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        aria-label="Live Demo"
                                        class="p-2 rounded-lg bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-100 dark:hover:bg-indigo-900/60 transition-colors"
                                    >
                                        <ExternalLink class="w-4 h-4" />
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Project Details Modal Popup -->
            <ProjectModal 
                :project="selectedProject" 
                :is-open="isModalOpen" 
                @close="closeProjectModal" 
            />

        </div>
    </section>
</template>
