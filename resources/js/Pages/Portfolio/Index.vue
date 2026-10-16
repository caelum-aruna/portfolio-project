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

    <div class="min-h-screen bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 selection:bg-indigo-600 selection:text-white relative font-sans">
        
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
