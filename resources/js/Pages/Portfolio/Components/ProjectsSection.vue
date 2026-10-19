<script setup>
import { ref, computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import { 
    FolderGit2, 
    ExternalLink, 
    Github, 
    Sparkles, 
    ArrowUpRight,
    ArrowRight,
    Eye
} from 'lucide-vue-next';
import ProjectModal from './ProjectModal.vue';

const props = defineProps({
    projects: {
        type: Array,
        required: true,
    },
    limit: {
        type: Number,
        default: 6,
    },
    showViewAll: {
        type: Boolean,
        default: true,
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
    const list = activeCategory.value === 'All'
        ? props.projects
        : props.projects.filter(p => p.category === activeCategory.value);

    return props.limit ? list.slice(0, props.limit) : list;
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
    <section id="projects" class="py-24 relative bg-zinc-50 dark:bg-zinc-900/50 border-y border-zinc-200 dark:border-zinc-800/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Section Header -->
            <div class="text-center max-w-3xl mx-auto space-y-3 mb-12">
                <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-zinc-100 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 text-zinc-800 dark:text-zinc-200 text-xs font-mono font-semibold uppercase tracking-wider">
                    <FolderGit2 class="w-3.5 h-3.5 text-indigo-600 dark:text-indigo-400" />
                    <span>Selected Works</span>
                </div>
                <h2 class="font-heading text-3xl sm:text-4xl lg:text-5xl font-extrabold text-zinc-900 dark:text-white tracking-tight">
                    Featured Projects & Engineering Case Studies
                </h2>
                <p class="font-sans text-base sm:text-lg text-zinc-600 dark:text-zinc-400">
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
                    class="px-5 py-2 rounded-xl text-xs sm:text-sm font-semibold font-sans transition-colors border"
                    :class="[
                        activeCategory === cat
                            ? 'bg-zinc-900 border-zinc-900 text-white dark:bg-white dark:border-white dark:text-zinc-900 shadow-sm'
                            : 'bg-white dark:bg-zinc-900 border-zinc-200 dark:border-zinc-800 text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white'
                    ]"
                >
                    {{ cat }}
                </button>
            </div>

            <!-- Projects Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
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

            <!-- View All Projects CTA Banner / Link -->
            <div v-if="showViewAll" class="mt-14 text-center">
                <Link 
                    :href="route('portfolio.projects')"
                    class="inline-flex items-center gap-3 px-8 py-4 rounded-2xl bg-zinc-900 hover:bg-zinc-800 text-white dark:bg-white dark:hover:bg-zinc-100 dark:text-zinc-900 font-heading font-bold text-sm sm:text-base shadow-md hover:shadow-xl hover:-translate-y-0.5 active:translate-y-0 transition-all group"
                >
                    <span>View All Projects</span>
                    <span class="px-2.5 py-0.5 rounded-full bg-white/20 dark:bg-zinc-900/10 text-xs font-mono font-bold">
                        {{ projects.length }}
                    </span>
                    <ArrowRight class="w-4 h-4 group-hover:translate-x-1 transition-transform text-indigo-400 dark:text-indigo-600" />
                </Link>
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
