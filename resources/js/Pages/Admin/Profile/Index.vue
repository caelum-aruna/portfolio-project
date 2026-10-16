<script setup>
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { 
    User, 
    Save, 
    Upload, 
    Link as LinkIcon, 
    Sparkles, 
    CheckCircle2,
    Mail,
    Phone,
    MapPin,
    Globe
} from 'lucide-vue-next';

const props = defineProps({
    settings: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    name: props.settings.name || 'Ikbal Muhammad',
    role: props.settings.role || 'Full Stack Developer',
    greeting: props.settings.greeting || 'Hello, I am',
    description: props.settings.description || '',
    about_bio_1: props.settings.about_bio_1 || '',
    about_bio_2: props.settings.about_bio_2 || '',
    email: props.settings.email || '',
    phone: props.settings.phone || '',
    location: props.settings.location || 'Indonesia',
    availability: props.settings.availability || 'Available for Freelance & Full-time',
    resume_url: props.settings.resume_url || '#',
    socials: {
        github: props.settings.socials?.github || 'https://github.com',
        linkedin: props.settings.socials?.linkedin || 'https://linkedin.com',
        instagram: props.settings.socials?.instagram || 'https://instagram.com',
        twitter: props.settings.socials?.twitter || 'https://x.com',
    },
    hero_image: props.settings.hero_image || '/images/hero-image.png',
    hero_image_file: null,
});

const handleImageChange = (e) => {
    const file = e.target.files[0];
    if (file) {
        form.hero_image_file = file;
    }
};

const submitForm = () => {
    form.post(route('admin.settings.update'), {
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Portfolio Profile Settings - Admin" />

    <AuthenticatedLayout>
        <template #header>
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                    Portfolio & Profile Settings
                </h1>
                <p class="text-xs text-slate-500 dark:text-slate-400 font-mono mt-0.5">
                    Update your personal branding, biography copy, contact points, and social links.
                </p>
            </div>

            <button 
                @click="submitForm"
                type="button"
                :disabled="form.processing"
                class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-semibold bg-indigo-600 text-white shadow-md shadow-indigo-500/20 hover:bg-indigo-700 disabled:opacity-50 transition-colors"
            >
                <Save class="w-4 h-4" />
                <span>{{ form.processing ? 'Saving...' : 'Save Settings' }}</span>
            </button>
        </template>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <form @submit.prevent="submitForm" class="space-y-8">
                
                <!-- Section 1: Hero Identity -->
                <div class="p-6 sm:p-8 rounded-3xl bg-white dark:bg-[#0E131F] border border-slate-200 dark:border-slate-800 shadow-sm space-y-6">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                        <Sparkles class="w-5 h-5 text-indigo-500" />
                        Hero Identity & Branding
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 items-start">
                        <!-- Hero Avatar Preview -->
                        <div class="space-y-3 text-center sm:text-left">
                            <label class="block text-xs font-mono text-slate-400 uppercase">Profile Photo</label>
                            <div class="w-32 h-40 mx-auto sm:mx-0 rounded-2xl overflow-hidden bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-md">
                                <img 
                                    :src="form.hero_image || '/images/hero-image.png'" 
                                    alt="Hero Image"
                                    class="w-full h-full object-cover"
                                    onerror="this.src='/images/hero-image.png'"
                                />
                            </div>
                            <input 
                                type="file" 
                                accept="image/*"
                                @change="handleImageChange"
                                class="w-full text-xs text-slate-400 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-[11px] file:font-semibold file:bg-indigo-50 file:text-indigo-600 dark:file:bg-slate-800 dark:file:text-indigo-400 hover:file:bg-indigo-100"
                            />
                        </div>

                        <!-- Inputs -->
                        <div class="sm:col-span-2 space-y-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="space-y-1">
                                    <label class="block text-xs font-mono text-slate-400 uppercase">Full Name</label>
                                    <input 
                                        v-model="form.name" 
                                        type="text" 
                                        required
                                        class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-sm focus:border-indigo-500 outline-none"
                                    />
                                </div>
                                <div class="space-y-1">
                                    <label class="block text-xs font-mono text-slate-400 uppercase">Role / Title</label>
                                    <input 
                                        v-model="form.role" 
                                        type="text" 
                                        required
                                        class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-sm focus:border-indigo-500 outline-none"
                                    />
                                </div>
                            </div>

                            <div class="space-y-1">
                                <label class="block text-xs font-mono text-slate-400 uppercase">Hero Tagline / Description</label>
                                <textarea 
                                    v-model="form.description" 
                                    rows="3" 
                                    required
                                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-sm focus:border-indigo-500 outline-none"
                                ></textarea>
                            </div>

                            <div class="space-y-1">
                                <label class="block text-xs font-mono text-slate-400 uppercase">Work Availability Badge</label>
                                <input 
                                    v-model="form.availability" 
                                    type="text" 
                                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-sm focus:border-indigo-500 outline-none"
                                />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 2: About Biography -->
                <div class="p-6 sm:p-8 rounded-3xl bg-white dark:bg-[#0E131F] border border-slate-200 dark:border-slate-800 shadow-sm space-y-4">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                        <User class="w-5 h-5 text-cyan-500" />
                        About Me Narrative
                    </h3>

                    <div class="space-y-1">
                        <label class="block text-xs font-mono text-slate-400 uppercase">Biography Paragraph 1</label>
                        <textarea 
                            v-model="form.about_bio_1" 
                            rows="3" 
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-sm focus:border-indigo-500 outline-none"
                        ></textarea>
                    </div>

                    <div class="space-y-1">
                        <label class="block text-xs font-mono text-slate-400 uppercase">Biography Paragraph 2</label>
                        <textarea 
                            v-model="form.about_bio_2" 
                            rows="3" 
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-sm focus:border-indigo-500 outline-none"
                        ></textarea>
                    </div>
                </div>

                <!-- Section 3: Contact & Links -->
                <div class="p-6 sm:p-8 rounded-3xl bg-white dark:bg-[#0E131F] border border-slate-200 dark:border-slate-800 shadow-sm space-y-4">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                        <Globe class="w-5 h-5 text-emerald-500" />
                        Contact Channels & Social Media
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="space-y-1">
                            <label class="block text-xs font-mono text-slate-400 uppercase">Email Address</label>
                            <input 
                                v-model="form.email" 
                                type="email" 
                                required
                                class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-sm focus:border-indigo-500 outline-none"
                            />
                        </div>

                        <div class="space-y-1">
                            <label class="block text-xs font-mono text-slate-400 uppercase">Phone / WA</label>
                            <input 
                                v-model="form.phone" 
                                type="text" 
                                class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-sm focus:border-indigo-500 outline-none"
                            />
                        </div>

                        <div class="space-y-1">
                            <label class="block text-xs font-mono text-slate-400 uppercase">Location</label>
                            <input 
                                v-model="form.location" 
                                type="text" 
                                class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-sm focus:border-indigo-500 outline-none"
                            />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                        <div class="space-y-1">
                            <label class="block text-xs font-mono text-slate-400 uppercase">GitHub Profile URL</label>
                            <input 
                                v-model="form.socials.github" 
                                type="url" 
                                class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-sm focus:border-indigo-500 outline-none"
                            />
                        </div>

                        <div class="space-y-1">
                            <label class="block text-xs font-mono text-slate-400 uppercase">LinkedIn Profile URL</label>
                            <input 
                                v-model="form.socials.linkedin" 
                                type="url" 
                                class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-sm focus:border-indigo-500 outline-none"
                            />
                        </div>

                        <div class="space-y-1">
                            <label class="block text-xs font-mono text-slate-400 uppercase">Instagram URL</label>
                            <input 
                                v-model="form.socials.instagram" 
                                type="url" 
                                class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-sm focus:border-indigo-500 outline-none"
                            />
                        </div>

                        <div class="space-y-1">
                            <label class="block text-xs font-mono text-slate-400 uppercase">Twitter / X URL</label>
                            <input 
                                v-model="form.socials.twitter" 
                                type="url" 
                                class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-sm focus:border-indigo-500 outline-none"
                            />
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button 
                        type="submit" 
                        :disabled="form.processing"
                        class="px-6 py-3 rounded-xl text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 shadow-lg shadow-indigo-500/25 disabled:opacity-50 transition-colors flex items-center gap-2"
                    >
                        <Save class="w-4 h-4" />
                        <span>{{ form.processing ? 'Saving...' : 'Save Profile Changes' }}</span>
                    </button>
                </div>

            </form>

        </div>
    </AuthenticatedLayout>
</template>
