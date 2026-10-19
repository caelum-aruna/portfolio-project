<script setup>
import { ref, computed } from 'vue';
import { 
    ExternalLink, 
    Github, 
    Layers, 
    Sparkles, 
    Code2, 
    Check, 
    Copy, 
    Info, 
    FolderGit2 
} from 'lucide-vue-next';
import ProjectModal from '../ProjectModal.vue';

const props = defineProps({
    projects: {
        type: Array,
        required: true,
    },
    viewMode: {
        type: String,
        default: 'preview',
    },
});

const selectedCategory = ref('All');
const activeProjectForModal = ref(null);
const isModalOpen = ref(false);
const codeCopied = ref(false);

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
    if (selectedCategory.value === 'All') return props.projects;
    return props.projects.filter(p => p.category === selectedCategory.value);
});

const parseTechStack = (tech) => {
    if (!tech) return [];
    if (Array.isArray(tech)) return tech;
    return tech.split(',').map(t => t.trim()).filter(Boolean);
};

const openProjectModal = (proj) => {
    activeProjectForModal.value = proj;
    isModalOpen.value = true;
};

const projectsJsonString = computed(() => {
    return JSON.stringify(props.projects, null, 2);
});

const copyCode = () => {
    navigator.clipboard.writeText(projectsJsonString.value);
    codeCopied.value = true;
    setTimeout(() => {
        codeCopied.value = false;
    }, 2000);
};
</script>

<template>
    <div class="flex-1 h-full overflow-y-auto bg-white dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 flex">
        
        <!-- ================= MODE 1: VISUAL PREVIEW ================= -->
        <div v-if="viewMode === 'preview'" class="w-full p-4 sm:p-8 max-w-6xl mx-auto space-y-6 font-sans">
            
            <!-- Section Header -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-zinc-200 dark:border-zinc-800 pb-5">
                <div>
                    <div class="flex items-center space-x-2 text-xs font-mono text-indigo-600 dark:text-indigo-400 uppercase tracking-wider mb-1">
                        <FolderGit2 class="w-4 h-4" />
                        <span>Source Repositories & Deployments</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold font-heading text-zinc-900 dark:text-white">
                        Featured Projects ({{ filteredProjects.length }})
                    </h1>
                </div>

                <!-- Category Filter Pills -->
                <div class="flex flex-wrap gap-1.5 bg-zinc-100 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 p-1 rounded-lg">
                    <button
                        v-for="cat in categories"
                        :key="cat"
                        @click="selectedCategory = cat"
                        :class="[
                            'px-3 py-1 rounded text-xs font-medium transition-colors font-sans',
                            selectedCategory === cat
                                ? 'bg-indigo-600 text-white font-semibold'
                                : 'text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white hover:bg-zinc-200 dark:hover:bg-zinc-800'
                        ]"
                    >
                        {{ cat }}
                    </button>
                </div>
            </div>

            <!-- Empty State -->
            <div v-if="filteredProjects.length === 0" class="py-16 text-center text-zinc-500 font-mono">
                No projects found in category "{{ selectedCategory }}"
            </div>

            <!-- Projects Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div
                    v-for="project in filteredProjects"
                    :key="project.id"
                    class="bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl overflow-hidden flex flex-col justify-between hover:border-zinc-300 dark:hover:border-zinc-700 transition-all group"
                >
                    <!-- Project Thumbnail -->
                    <div class="aspect-video w-full bg-zinc-100 dark:bg-zinc-950 relative overflow-hidden border-b border-zinc-200 dark:border-zinc-800">
                        <img
                            v-if="project.image"
                            :src="project.image"
                            :alt="project.title"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                        />
                        <div v-else class="w-full h-full flex items-center justify-center bg-zinc-100 dark:bg-zinc-950 text-zinc-400 dark:text-zinc-600">
                            <Layers class="w-10 h-10 opacity-40" />
                        </div>

                        <!-- Featured Badge -->
                        <div 
                            v-if="project.is_featured" 
                            class="absolute top-2.5 right-2.5 px-2 py-0.5 rounded bg-indigo-600 text-white text-[10px] font-mono font-bold tracking-wider uppercase shadow-sm"
                        >
                            Featured
                        </div>

                        <!-- Category Badge -->
                        <div class="absolute bottom-2.5 left-2.5 px-2 py-0.5 rounded bg-white/90 dark:bg-zinc-900/90 text-zinc-700 dark:text-zinc-300 border border-zinc-200 dark:border-zinc-700 text-[10px] font-mono">
                            {{ project.category || 'Full Stack' }}
                        </div>
                    </div>

                    <!-- Project Body -->
                    <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                        <div>
                            <h3 class="text-lg font-bold font-heading text-zinc-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                {{ project.title }}
                            </h3>
                            <p class="text-xs text-zinc-600 dark:text-zinc-400 mt-2 line-clamp-3 leading-relaxed">
                                {{ project.description }}
                            </p>
                        </div>

                        <!-- Tech Stack Tags -->
                        <div class="space-y-3 pt-3 border-t border-zinc-200 dark:border-zinc-800/80">
                            <div class="flex flex-wrap gap-1.5">
                                <span
                                    v-for="tech in parseTechStack(project.tech_stack)"
                                    :key="tech"
                                    class="text-[11px] font-mono px-2 py-0.5 rounded bg-white dark:bg-zinc-950 text-zinc-700 dark:text-zinc-300 border border-zinc-200 dark:border-zinc-800"
                                >
                                    {{ tech }}
                                </span>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex items-center justify-between pt-2">
                                <button
                                    @click="openProjectModal(project)"
                                    class="inline-flex items-center space-x-1.5 text-xs text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white transition-colors"
                                >
                                    <Info class="w-3.5 h-3.5" />
                                    <span>Details</span>
                                </button>

                                <div class="flex items-center space-x-2">
                                    <a
                                        v-if="project.github_url"
                                        :href="project.github_url"
                                        target="_blank"
                                        title="View Source Code"
                                        class="p-2 rounded bg-white dark:bg-zinc-800 hover:bg-zinc-100 dark:hover:bg-zinc-700 text-zinc-600 dark:text-zinc-300 hover:text-zinc-900 dark:hover:text-white border border-zinc-200 dark:border-zinc-700 transition-colors"
                                    >
                                        <Github class="w-3.5 h-3.5" />
                                    </a>
                                    <a
                                        v-if="project.demo_url"
                                        :href="project.demo_url"
                                        target="_blank"
                                        title="Live Demo Preview"
                                        class="inline-flex items-center space-x-1 px-3 py-1.5 rounded bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-semibold transition-colors"
                                    >
                                        <span>Demo</span>
                                        <ExternalLink class="w-3 h-3" />
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Project Specs Modal -->
            <ProjectModal
                v-if="isModalOpen"
                :is-open="isModalOpen"
                :project="activeProjectForModal"
                @close="isModalOpen = false"
            />
        </div>

        <!-- ================= MODE 2: SOURCE CODE VIEW ================= -->
        <div v-else class="w-full flex font-mono text-xs overflow-x-auto bg-white dark:bg-zinc-950">
            <!-- Line Numbers Gutter -->
            <div class="w-12 py-4 select-none text-right pr-4 text-zinc-400 dark:text-zinc-600 bg-zinc-50 dark:bg-zinc-950 border-r border-zinc-200 dark:border-zinc-800 shrink-0 space-y-1">
                <div v-for="n in 60" :key="n">{{ n }}</div>
            </div>

            <!-- Code Content -->
            <div class="flex-1 p-4 relative text-zinc-800 dark:text-zinc-300">
                <button
                    @click="copyCode"
                    class="absolute top-4 right-4 flex items-center space-x-1 px-2.5 py-1 rounded bg-zinc-100 dark:bg-zinc-800 hover:bg-zinc-200 dark:hover:bg-zinc-700 text-zinc-700 dark:text-zinc-300 text-xs border border-zinc-300 dark:border-zinc-700"
                >
                    <Check v-if="codeCopied" class="w-3.5 h-3.5 text-emerald-500 dark:text-emerald-400" />
                    <Copy v-else class="w-3.5 h-3.5" />
                    <span>{{ codeCopied ? 'Copied' : 'Copy JSON' }}</span>
                </button>

                <pre class="leading-relaxed whitespace-pre font-mono text-amber-700 dark:text-amber-300"><code>{{ projectsJsonString }}</code></pre>
            </div>
        </div>

    </div>
</template>
