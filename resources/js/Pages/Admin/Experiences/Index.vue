<script setup>
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import { 
    Milestone, 
    Plus, 
    Pencil, 
    Trash2, 
    X,
    Briefcase,
    GraduationCap
} from 'lucide-vue-next';

const props = defineProps({
    experiences: {
        type: Array,
        required: true,
    },
});

const isModalOpen = ref(false);
const editingExperience = ref(null);

const form = useForm({
    position: '',
    company: '',
    period: '',
    description: '',
    type: 'work',
    order: 0,
});

const openCreateModal = () => {
    editingExperience.value = null;
    form.reset();
    form.clearErrors();
    form.type = 'work';
    form.order = props.experiences.length + 1;
    isModalOpen.value = true;
};

const openEditModal = (exp) => {
    editingExperience.value = exp;
    form.clearErrors();
    form.position = exp.position;
    form.company = exp.company;
    form.period = exp.period;
    form.description = exp.description;
    form.type = exp.type;
    form.order = exp.order || 0;
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
    editingExperience.value = null;
};

const submitForm = () => {
    if (editingExperience.value) {
        form.put(route('admin.experiences.update', editingExperience.value.id), {
            onSuccess: () => closeModal(),
        });
    } else {
        form.post(route('admin.experiences.store'), {
            onSuccess: () => closeModal(),
        });
    }
};

const deleteExperience = (exp) => {
    if (confirm(`Hapus data pengalaman "${exp.position}" di ${exp.company}?`)) {
        router.delete(route('admin.experiences.destroy', exp.id));
    }
};
</script>

<template>
    <Head title="Manage Experiences - Admin" />

    <AuthenticatedLayout>
        <template #header>
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                    Manage Experience & Education
                </h1>
                <p class="text-xs text-slate-500 dark:text-slate-400 font-mono mt-0.5">
                    Maintain your career history, internships, and education history.
                </p>
            </div>

            <button 
                @click="openCreateModal"
                type="button"
                class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-semibold bg-indigo-600 text-white shadow-md shadow-indigo-500/20 hover:bg-indigo-700 transition-colors"
            >
                <Plus class="w-4 h-4" />
                <span>Add Milestone</span>
            </button>
        </template>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            <div class="rounded-3xl bg-white dark:bg-[#0E131F] border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900/60 text-[11px] font-mono uppercase tracking-wider text-slate-400">
                                <th class="py-3.5 px-6">Role / Position</th>
                                <th class="py-3.5 px-6">Organization</th>
                                <th class="py-3.5 px-6">Period</th>
                                <th class="py-3.5 px-6">Type</th>
                                <th class="py-3.5 px-6">Order</th>
                                <th class="py-3.5 px-6 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60 text-sm">
                            <tr 
                                v-for="e in experiences" 
                                :key="e.id"
                                class="hover:bg-slate-50/50 dark:hover:bg-slate-900/30 transition-colors"
                            >
                                <td class="py-4 px-6 font-bold text-slate-900 dark:text-white">
                                    {{ e.position }}
                                </td>

                                <td class="py-4 px-6 text-slate-700 dark:text-slate-300">
                                    {{ e.company }}
                                </td>

                                <td class="py-4 px-6 font-mono text-xs text-indigo-500">
                                    {{ e.period }}
                                </td>

                                <td class="py-4 px-6">
                                    <span 
                                        class="px-2.5 py-0.5 rounded-full text-xs font-mono font-medium"
                                        :class="e.type === 'education' ? 'bg-cyan-500/10 text-cyan-500' : 'bg-indigo-500/10 text-indigo-500'"
                                    >
                                        {{ e.type }}
                                    </span>
                                </td>

                                <td class="py-4 px-6 font-mono text-xs text-slate-500">
                                    #{{ e.order }}
                                </td>

                                <td class="py-4 px-6 text-right space-x-2">
                                    <button 
                                        @click="openEditModal(e)"
                                        type="button"
                                        class="p-2 rounded-lg text-slate-400 hover:text-indigo-500 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
                                    >
                                        <Pencil class="w-4 h-4" />
                                    </button>
                                    <button 
                                        @click="deleteExperience(e)"
                                        type="button"
                                        class="p-2 rounded-lg text-slate-400 hover:text-rose-500 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
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
                    <div class="relative w-full max-w-lg rounded-3xl bg-white dark:bg-[#0E131F] border border-slate-200 dark:border-slate-800 shadow-2xl p-6 sm:p-8 space-y-6">
                        
                        <div class="flex items-center justify-between pb-4 border-b border-slate-200 dark:border-slate-800">
                            <h3 class="text-xl font-extrabold text-slate-900 dark:text-white">
                                {{ editingExperience ? 'Edit Milestone' : 'Add Milestone' }}
                            </h3>
                            <button @click="closeModal" class="p-1.5 rounded-lg text-slate-400 hover:text-slate-600 dark:hover:text-white">
                                <X class="w-5 h-5" />
                            </button>
                        </div>

                        <form @submit.prevent="submitForm" class="space-y-4">
                            
                            <div class="space-y-1">
                                <label class="block text-xs font-mono text-slate-400 uppercase">Position / Role</label>
                                <input 
                                    v-model="form.position" 
                                    type="text" 
                                    required
                                    placeholder="e.g. Full Stack Developer, Student"
                                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-sm focus:border-indigo-500 outline-none"
                                />
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="space-y-1">
                                    <label class="block text-xs font-mono text-slate-400 uppercase">Company / Institution</label>
                                    <input 
                                        v-model="form.company" 
                                        type="text" 
                                        required
                                        placeholder="e.g. Tech Solutions Inc."
                                        class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-sm focus:border-indigo-500 outline-none"
                                    />
                                </div>

                                <div class="space-y-1">
                                    <label class="block text-xs font-mono text-slate-400 uppercase">Period / Timeline</label>
                                    <input 
                                        v-model="form.period" 
                                        type="text" 
                                        required
                                        placeholder="e.g. 2024 - Present"
                                        class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-sm focus:border-indigo-500 outline-none"
                                    />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="space-y-1">
                                    <label class="block text-xs font-mono text-slate-400 uppercase">Category Type</label>
                                    <select 
                                        v-model="form.type"
                                        class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-sm focus:border-indigo-500 outline-none"
                                    >
                                        <option value="work">Work Experience</option>
                                        <option value="education">Education</option>
                                        <option value="organization">Organization</option>
                                    </select>
                                </div>

                                <div class="space-y-1">
                                    <label class="block text-xs font-mono text-slate-400 uppercase">Order</label>
                                    <input 
                                        v-model.number="form.order" 
                                        type="number" 
                                        class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-sm focus:border-indigo-500 outline-none"
                                    />
                                </div>
                            </div>

                            <div class="space-y-1">
                                <label class="block text-xs font-mono text-slate-400 uppercase">Description / Key Responsibilities</label>
                                <textarea 
                                    v-model="form.description" 
                                    rows="3" 
                                    required
                                    placeholder="Responsibilities, achievements, algorithms studied..."
                                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-sm focus:border-indigo-500 outline-none"
                                ></textarea>
                            </div>

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
                                    {{ editingExperience ? 'Save Changes' : 'Create Milestone' }}
                                </button>
                            </div>

                        </form>

                    </div>
                </div>
            </teleport>

        </div>
    </AuthenticatedLayout>
</template>
