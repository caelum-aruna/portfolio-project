<script setup>
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import { 
    FolderGit2, 
    Plus, 
    Pencil, 
    Trash2, 
    ExternalLink, 
    Github, 
    Sparkles, 
    X,
    Upload,
    Check
} from 'lucide-vue-next';

const props = defineProps({
    projects: {
        type: Array,
        required: true,
    },
});

const isModalOpen = ref(false);
const editingProject = ref(null);
const fileInput = ref(null);

const form = useForm({
    title: '',
    category: 'Full Stack',
    description: '',
    details: '',
    tech_stack: '',
    demo_url: '',
    repo_url: '',
    is_featured: true,
    order: 0,
    thumbnail: '',
    thumbnail_file: null,
});

const openCreateModal = () => {
    editingProject.value = null;
    form.reset();
    form.clearErrors();
    form.category = 'Full Stack';
    form.is_featured = true;
    form.order = props.projects.length + 1;
    isModalOpen.value = true;
};

const openEditModal = (project) => {
    editingProject.value = project;
    form.clearErrors();
    form.title = project.title;
    form.category = project.category;
    form.description = project.description;
    form.details = project.details || '';
    form.tech_stack = Array.isArray(project.tech_stack) ? project.tech_stack.join(', ') : '';
    form.demo_url = project.demo_url || '';
    form.repo_url = project.repo_url || '';
    form.is_featured = !!project.is_featured;
    form.order = project.order || 0;
    form.thumbnail = project.thumbnail || '';
    form.thumbnail_file = null;
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
    editingProject.value = null;
};

const handleFileChange = (e) => {
    const file = e.target.files[0];
    if (file) {
        form.thumbnail_file = file;
    }
};

const submitForm = () => {
    if (editingProject.value) {
        // Use POST with _method=PUT to support file uploads in Laravel
        form.transform((data) => ({
            ...data,
            _method: 'PUT',
        })).post(route('admin.projects.update', editingProject.value.id), {
            onSuccess: () => closeModal(),
        });
    } else {
        form.post(route('admin.projects.store'), {
            onSuccess: () => closeModal(),
        });
    }
};

const deleteProject = (project) => {
    if (confirm(`Yakin ingin menghapus project "${project.title}"?`)) {
        router.delete(route('admin.projects.destroy', project.id));
    }
};
</script>

<template>
    <Head title="Manage Projects - Admin" />

    <AuthenticatedLayout>
        <template #header>
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                    Manage Portfolio Projects
                </h1>
                <p class="text-xs text-slate-500 dark:text-slate-400 font-mono mt-0.5">
                    Add, edit, or reorganize showcase projects displayed on your portfolio.
                </p>
            </div>

            <button 
                @click="openCreateModal"
                type="button"
                class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-semibold bg-indigo-600 text-white shadow-md shadow-indigo-500/20 hover:bg-indigo-700 transition-colors"
            >
                <Plus class="w-4 h-4" />
                <span>Add Project</span>
            </button>
        </template>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            <!-- Projects Table Card -->
            <div class="rounded-3xl bg-white dark:bg-[#0E131F] border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900/60 text-[11px] font-mono uppercase tracking-wider text-slate-400">
                                <th class="py-3.5 px-6">Project</th>
                                <th class="py-3.5 px-6">Category</th>
                                <th class="py-3.5 px-6">Tech Stack</th>
                                <th class="py-3.5 px-6">Status</th>
                                <th class="py-3.5 px-6">Order</th>
                                <th class="py-3.5 px-6 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60 text-sm">
                            <tr 
                                v-for="p in projects" 
                                :key="p.id"
                                class="hover:bg-slate-50/50 dark:hover:bg-slate-900/30 transition-colors"
                            >
                                <td class="py-4 px-6 flex items-center gap-3">
                                    <img 
                                        :src="p.thumbnail || '/images/tech-stack.png'" 
                                        :alt="p.title"
                                        class="w-12 h-12 rounded-xl object-cover bg-slate-800 shrink-0 border border-slate-200 dark:border-slate-700"
                                        onerror="this.src='/images/tech-stack.png'"
                                    />
                                    <div>
                                        <h4 class="font-bold text-slate-900 dark:text-white">{{ p.title }}</h4>
                                        <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-1 max-w-xs">{{ p.description }}</p>
                                    </div>
                                </td>

                                <td class="py-4 px-6">
                                    <span class="px-2.5 py-1 rounded-md text-xs font-mono font-medium bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 border border-indigo-200/60 dark:border-indigo-800/60">
                                        {{ p.category }}
                                    </span>
                                </td>

                                <td class="py-4 px-6">
                                    <div class="flex flex-wrap gap-1 max-w-xs">
                                        <span 
                                            v-for="(tech, idx) in (p.tech_stack || []).slice(0, 3)" 
                                            :key="idx"
                                            class="px-2 py-0.5 rounded text-[10px] font-mono bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300"
                                        >
                                            {{ tech }}
                                        </span>
                                        <span v-if="(p.tech_stack || []).length > 3" class="text-[10px] font-mono text-slate-400">
                                            +{{ (p.tech_stack || []).length - 3 }}
                                        </span>
                                    </div>
                                </td>

                                <td class="py-4 px-6">
                                    <span 
                                        v-if="p.is_featured"
                                        class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-mono font-semibold bg-amber-500/10 text-amber-500 border border-amber-500/20"
                                    >
                                        <Sparkles class="w-3 h-3" />
                                        Featured
                                    </span>
                                    <span v-else class="text-xs text-slate-400">Standard</span>
                                </td>

                                <td class="py-4 px-6 font-mono text-xs text-slate-500">
                                    #{{ p.order }}
                                </td>

                                <td class="py-4 px-6 text-right space-x-2">
                                    <button 
                                        @click="openEditModal(p)"
                                        type="button"
                                        class="p-2 rounded-lg text-slate-400 hover:text-indigo-500 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
                                        title="Edit Project"
                                    >
                                        <Pencil class="w-4 h-4" />
                                    </button>
                                    <button 
                                        @click="deleteProject(p)"
                                        type="button"
                                        class="p-2 rounded-lg text-slate-400 hover:text-rose-500 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
                                        title="Delete Project"
                                    >
                                        <Trash2 class="w-4 h-4" />
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Create / Edit Modal -->
            <teleport to="body">
                <div 
                    v-if="isModalOpen" 
                    class="fixed inset-0 z-50 overflow-y-auto bg-black/70 backdrop-blur-sm flex items-center justify-center p-4"
                >
                    <div class="relative w-full max-w-2xl rounded-3xl bg-white dark:bg-[#0E131F] border border-slate-200 dark:border-slate-800 shadow-2xl p-6 sm:p-8 space-y-6">
                        
                        <div class="flex items-center justify-between pb-4 border-b border-slate-200 dark:border-slate-800">
                            <h3 class="text-xl font-extrabold text-slate-900 dark:text-white">
                                {{ editingProject ? 'Edit Project' : 'Add New Project' }}
                            </h3>
                            <button @click="closeModal" class="p-1.5 rounded-lg text-slate-400 hover:text-slate-600 dark:hover:text-white">
                                <X class="w-5 h-5" />
                            </button>
                        </div>

                        <form @submit.prevent="submitForm" class="space-y-4">
                            
                            <!-- Title & Category -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="space-y-1">
                                    <label class="block text-xs font-mono text-slate-400 uppercase">Project Title</label>
                                    <input 
                                        v-model="form.title" 
                                        type="text" 
                                        required
                                        placeholder="e.g. E-Commerce Platform"
                                        class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-sm focus:border-indigo-500 outline-none"
                                    />
                                </div>
                                <div class="space-y-1">
                                    <label class="block text-xs font-mono text-slate-400 uppercase">Category</label>
                                    <input 
                                        v-model="form.category" 
                                        type="text" 
                                        required
                                        placeholder="e.g. Full Stack, Enterprise, AI"
                                        class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-sm focus:border-indigo-500 outline-none"
                                    />
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="space-y-1">
                                <label class="block text-xs font-mono text-slate-400 uppercase">Short Description</label>
                                <textarea 
                                    v-model="form.description" 
                                    rows="2" 
                                    required
                                    placeholder="Brief summary of the project and its core impact..."
                                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-sm focus:border-indigo-500 outline-none"
                                ></textarea>
                            </div>

                            <!-- Architecture Details -->
                            <div class="space-y-1">
                                <label class="block text-xs font-mono text-slate-400 uppercase">Architecture & Technical Details</label>
                                <textarea 
                                    v-model="form.details" 
                                    rows="2" 
                                    placeholder="Explanation of architecture, design patterns, database constraints..."
                                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-sm focus:border-indigo-500 outline-none"
                                ></textarea>
                            </div>

                            <!-- Tech Stack (Comma separated) -->
                            <div class="space-y-1">
                                <label class="block text-xs font-mono text-slate-400 uppercase">Tech Stack (comma separated)</label>
                                <input 
                                    v-model="form.tech_stack" 
                                    type="text" 
                                    placeholder="Laravel, Vue.js 3, Tailwind CSS, MySQL"
                                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-sm focus:border-indigo-500 outline-none"
                                />
                            </div>

                            <!-- URLs -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="space-y-1">
                                    <label class="block text-xs font-mono text-slate-400 uppercase">Live Demo URL</label>
                                    <input 
                                        v-model="form.demo_url" 
                                        type="url" 
                                        placeholder="https://demo.example.com"
                                        class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-sm focus:border-indigo-500 outline-none"
                                    />
                                </div>
                                <div class="space-y-1">
                                    <label class="block text-xs font-mono text-slate-400 uppercase">Repository URL</label>
                                    <input 
                                        v-model="form.repo_url" 
                                        type="url" 
                                        placeholder="https://github.com/user/project"
                                        class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-sm focus:border-indigo-500 outline-none"
                                    />
                                </div>
                            </div>

                            <!-- Thumbnail Upload & Order & Featured -->
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-center">
                                <div class="space-y-1 sm:col-span-2">
                                    <label class="block text-xs font-mono text-slate-400 uppercase">Thumbnail Image</label>
                                    <input 
                                        type="file" 
                                        accept="image/*"
                                        @change="handleFileChange"
                                        class="w-full text-xs text-slate-400 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-600 dark:file:bg-slate-800 dark:file:text-indigo-400 hover:file:bg-indigo-100"
                                    />
                                </div>
                                <div class="space-y-1">
                                    <label class="block text-xs font-mono text-slate-400 uppercase">Display Order</label>
                                    <input 
                                        v-model="form.order" 
                                        type="number" 
                                        class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-sm focus:border-indigo-500 outline-none"
                                    />
                                </div>
                            </div>

                            <!-- Featured Checkbox -->
                            <div class="flex items-center gap-2 pt-2">
                                <input 
                                    v-model="form.is_featured" 
                                    id="featured_cb" 
                                    type="checkbox" 
                                    class="rounded border-slate-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                />
                                <label for="featured_cb" class="text-xs font-semibold text-slate-700 dark:text-slate-300">
                                    Mark as Featured Project
                                </label>
                            </div>

                            <!-- Actions -->
                            <div class="pt-4 border-t border-slate-200 dark:border-slate-800 flex items-center justify-end gap-3">
                                <button 
                                    @click="closeModal" 
                                    type="button" 
                                    class="px-4 py-2 text-xs font-semibold text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl"
                                >
                                    Cancel
                                </button>
                                <button 
                                    type="submit" 
                                    :disabled="form.processing"
                                    class="px-5 py-2 text-xs font-semibold bg-indigo-600 text-white rounded-xl shadow-md hover:bg-indigo-700 disabled:opacity-50"
                                >
                                    {{ editingProject ? 'Save Changes' : 'Create Project' }}
                                </button>
                            </div>

                        </form>

                    </div>
                </div>
            </teleport>

        </div>
    </AuthenticatedLayout>
</template>
