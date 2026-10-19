<script setup>
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import { Terminal, LayoutTemplate } from 'lucide-vue-next';

// IDE Workspace Components
import IdeWindow from './Components/Ide/IdeWindow.vue';

// Classic Scroll Components (Optional alternate mode)
import Navbar from './Components/Navbar.vue';
import HeroSection from './Components/HeroSection.vue';
import AboutSection from './Components/AboutSection.vue';
import SkillsSection from './Components/SkillsSection.vue';
import ProjectsSection from './Components/ProjectsSection.vue';
import ExperienceSection from './Components/ExperienceSection.vue';
import ContactSection from './Components/ContactSection.vue';
import Footer from './Components/Footer.vue';

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
    canRegister: Boolean,
});

// Layout mode: 'ide' (default) or 'classic'
const layoutMode = ref('ide');
</script>

<template>
    <div>
        <Head :title="profile.name ? `${profile.name} — ${profile.role || 'Full Stack Developer'} (Workspace)` : 'Ikbal Muhammad — Developer Workspace'" />

        <!-- ================= 1. PRIMARY: DEVELOPER IDE WORKSPACE ================= -->
        <div v-if="layoutMode === 'ide'" class="w-full h-screen overflow-hidden">
            <IdeWindow
                :profile="profile"
                :skills="skills"
                :projects="projects"
                :experiences="experiences"
                :can-login="canLogin"
                :auth="$page.props.auth"
                @switch-to-classic="layoutMode = 'classic'"
            />
        </div>

        <!-- ================= 2. SECONDARY: CLASSIC SINGLE-PAGE SCROLL ================= -->
        <div v-else class="min-h-screen bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 selection:bg-indigo-600 selection:text-white relative font-sans">
            
            <!-- Sticky Header Navigation -->
            <Navbar 
                :can-login="canLogin" 
                :auth="$page.props.auth" 
            />

            <main>
                <!-- Hero Section -->
                <HeroSection :profile="profile" />

                <!-- About Section -->
                <AboutSection :profile="profile" />

                <!-- Skills Section -->
                <SkillsSection :skills="skills" />

                <!-- Projects Showcase Section -->
                <ProjectsSection :projects="projects" />

                <!-- Experience & Journey Timeline -->
                <ExperienceSection :experiences="experiences" />

                <!-- Contact Section -->
                <ContactSection :profile="profile" />
            </main>

            <!-- Footer -->
            <Footer :profile="profile" />

            <!-- Floating Return to IDE Action Button -->
            <button
                @click="layoutMode = 'ide'"
                title="Return to Developer IDE Workspace"
                class="fixed bottom-6 right-6 z-40 flex items-center space-x-2 px-4 py-2.5 rounded-full bg-zinc-900 text-white border border-zinc-700 shadow-xl hover:bg-zinc-800 hover:scale-105 transition-all text-xs font-mono font-semibold"
            >
                <Terminal class="w-4 h-4 text-emerald-400" />
                <span>Open IDE Mode</span>
            </button>
        </div>
    </div>
</template>
