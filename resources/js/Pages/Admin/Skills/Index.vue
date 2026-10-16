<script setup>
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import { 
    Wrench, 
    Plus, 
    Pencil, 
    Trash2, 
    X,
    Code,
    Server,
    Terminal
} from 'lucide-vue-next';

const props = defineProps({
    skills: {
        type: Array,
        required: true,
    },
});

const isModalOpen = ref(false);
const editingSkill = ref(null);

const form = useForm({
    name: '',
    category: 'Frontend',
    icon: '',
    proficiency: 85,
    order: 0,
});

const openCreateModal = () => {
    editingSkill.value = null;
    form.reset();
    form.clearErrors();
    form.category = 'Frontend';
    form.proficiency = 85;
    form.order = props.skills.length + 1;
    isModalOpen.value = true;
};

const openEditModal = (skill) => {
    editingSkill.value = skill;
    form.clearErrors();
    form.name = skill.name;
    form.category = skill.category;
    form.icon = skill.icon || '';
    form.proficiency = skill.proficiency;
    form.order = skill.order || 0;
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
    editingSkill.value = null;
};

const submitForm = () => {
    if (editingSkill.value) {
        form.put(route('admin.skills.update', editingSkill.value.id), {
            onSuccess: () => closeModal(),
        });
    } else {
        form.post(route('admin.skills.store'), {
            onSuccess: () => closeModal(),
        });
    }
};

const deleteSkill = (skill) => {
    if (confirm(`Hapus keahlian "${skill.name}"?`)) {
        router.delete(route('admin.skills.destroy', skill.id));
    }
};
</script>

<template>
    <Head title="Manage Skills - Admin" />

    <AuthenticatedLayout>
        <template #header>
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                    Manage Technical Skills
                </h1>
                <p class="text-xs text-slate-500 dark:text-slate-400 font-mono mt-0.5">
                    Organize your frontend, backend, and devops skill proficiencies.
                </p>
            </div>

            <button 
                @click="openCreateModal"
                type="button"
                class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-semibold bg-indigo-600 text-white shadow-md shadow-indigo-500/20 hover:bg-indigo-700 transition-colors"
            >
                <Plus class="w-4 h-4" />
                <span>Add Skill</span>
            </button>
        </template>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            <div class="rounded-3xl bg-white dark:bg-[#0E131F] border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900/60 text-[11px] font-mono uppercase tracking-wider text-slate-400">
                                <th class="py-3.5 px-6">Skill Name</th>
                                <th class="py-3.5 px-6">Category</th>
                                <th class="py-3.5 px-6">Proficiency</th>
                                <th class="py-3.5 px-6">Order</th>
                                <th class="py-3.5 px-6 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60 text-sm">
                            <tr 
                                v-for="s in skills" 
                                :key="s.id"
                                class="hover:bg-slate-50/50 dark:hover:bg-slate-900/30 transition-colors"
                            >
                                <td class="py-4 px-6 font-bold text-slate-900 dark:text-white">
                                    {{ s.name }}
                                </td>

                                <td class="py-4 px-6">
                                    <span class="px-2.5 py-1 rounded-md text-xs font-mono font-medium bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300">
                                        {{ s.category }}
                                    </span>
                                </td>

                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3 max-w-xs">
                                        <div class="flex-1 h-2 rounded-full bg-slate-100 dark:bg-slate-800 overflow-hidden">
                                            <div 
                                                class="h-full rounded-full bg-gradient-to-r from-indigo-500 to-cyan-500"
                                                :style="{ width: `${s.proficiency}%` }"
                                            ></div>
                                        </div>
                                        <span class="text-xs font-mono font-bold text-slate-500 dark:text-slate-400 w-9">
                                            {{ s.proficiency }}%
                                        </span>
                                    </div>
                                </td>

                                <td class="py-4 px-6 font-mono text-xs text-slate-500">
                                    #{{ s.order }}
                                </td>

                                <td class="py-4 px-6 text-right space-x-2">
                                    <button 
                                        @click="openEditModal(s)"
                                        type="button"
                                        class="p-2 rounded-lg text-slate-400 hover:text-indigo-500 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
                                    >
                                        <Pencil class="w-4 h-4" />
                                    </button>
                                    <button 
                                        @click="deleteSkill(s)"
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
                    <div class="relative w-full max-w-md rounded-3xl bg-white dark:bg-[#0E131F] border border-slate-200 dark:border-slate-800 shadow-2xl p-6 space-y-6">
                        
                        <div class="flex items-center justify-between pb-4 border-b border-slate-200 dark:border-slate-800">
                            <h3 class="text-xl font-extrabold text-slate-900 dark:text-white">
                                {{ editingSkill ? 'Edit Skill' : 'Add New Skill' }}
                            </h3>
                            <button @click="closeModal" class="p-1.5 rounded-lg text-slate-400 hover:text-slate-600 dark:hover:text-white">
                                <X class="w-5 h-5" />
                            </button>
                        </div>

                        <form @submit.prevent="submitForm" class="space-y-4">
                            
                            <div class="space-y-1">
                                <label class="block text-xs font-mono text-slate-400 uppercase">Skill Name</label>
                                <input 
                                    v-model="form.name" 
                                    type="text" 
                                    required
                                    placeholder="e.g. Vue.js 3, Laravel, Docker"
                                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-sm focus:border-indigo-500 outline-none"
                                />
                            </div>

                            <div class="space-y-1">
                                <label class="block text-xs font-mono text-slate-400 uppercase">Category</label>
                                <select 
                                    v-model="form.category"
                                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-sm focus:border-indigo-500 outline-none"
                                >
                                    <option value="Frontend">Frontend</option>
                                    <option value="Backend">Backend</option>
                                    <option value="Tools & DevOps">Tools & DevOps</option>
                                    <option value="Mobile">Mobile</option>
                                </select>
                            </div>

                            <div class="space-y-1">
                                <div class="flex items-center justify-between">
                                    <label class="block text-xs font-mono text-slate-400 uppercase">Proficiency Level</label>
                                    <span class="text-xs font-mono font-bold text-indigo-500">{{ form.proficiency }}%</span>
                                </div>
                                <input 
                                    v-model.number="form.proficiency" 
                                    type="range" 
                                    min="10" 
                                    max="100" 
                                    step="5"
                                    class="w-full accent-indigo-600 cursor-pointer"
                                />
                            </div>

                            <div class="space-y-1">
                                <label class="block text-xs font-mono text-slate-400 uppercase">Display Order</label>
                                <input 
                                    v-model.number="form.order" 
                                    type="number" 
                                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-sm focus:border-indigo-500 outline-none"
                                />
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
                                    {{ editingSkill ? 'Save Changes' : 'Create Skill' }}
                                </button>
                            </div>

                        </form>

                    </div>
                </div>
            </teleport>

        </div>
    </AuthenticatedLayout>
</template>
