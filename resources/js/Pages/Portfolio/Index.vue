<script setup>
import { Head } from '@inertiajs/vue3';
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
</script>

<template>
    <Head :title="profile.name ? `${profile.name} - ${profile.role || 'Full Stack Developer'}` : 'Ikbal Muhammad - Portfolio'" />

    <div class="min-h-screen bg-slate-50 dark:bg-[#0B0F17] text-slate-900 dark:text-slate-100 selection:bg-indigo-500 selection:text-white relative">
        
        <!-- Subtle Grid Pattern in Dark Mode -->
        <div class="fixed inset-0 pointer-events-none -z-20 opacity-30 dark:opacity-20 [background-image:radial-gradient(#6366f1_1px,transparent_1px)] [background-size:32px_32px]"></div>

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

    </div>
</template>
