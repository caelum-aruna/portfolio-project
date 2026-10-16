<script setup>
import { ref } from 'vue';
import { 
    ArrowRight, 
    Download, 
    Sparkles, 
    Check, 
    Copy, 
    Code2, 
    Briefcase
} from 'lucide-vue-next';

const props = defineProps({
    profile: {
        type: Object,
        required: true,
    },
});

const isCopied = ref(false);

const copyEmail = () => {
    if (props.profile.email) {
        navigator.clipboard.writeText(props.profile.email);
        isCopied.value = true;
        setTimeout(() => {
            isCopied.value = false;
        }, 2500);
    }
};
</script>

<template>
    <section id="hero" class="relative pt-32 pb-20 md:pt-40 md:pb-28">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">
                
                <!-- Left Column: Intro & Headline -->
                <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                    
                    <!-- Availability Pill Badge -->
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full border border-zinc-200 dark:border-zinc-800 bg-zinc-100 dark:bg-zinc-900 text-zinc-800 dark:text-zinc-200 text-xs font-medium font-sans">
                        <span class="flex h-2 w-2 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                        <span>{{ profile.availability || 'Available for Freelance & Full-time' }}</span>
                    </div>

                    <!-- Main Headline with Syne Font -->
                    <div class="space-y-2">
                        <p class="text-xs sm:text-sm font-mono uppercase tracking-widest text-indigo-600 dark:text-indigo-400 font-semibold">
                            {{ profile.greeting || 'Hello, I am' }}
                        </p>
                        <h1 class="font-heading text-4xl sm:text-6xl lg:text-7xl font-extrabold tracking-tight text-zinc-900 dark:text-white leading-[1.08]">
                            <span>{{ profile.name?.split(' ')[0] || 'Ikbal' }}</span>
                            <span class="block text-indigo-600 dark:text-indigo-400">
                                {{ profile.name?.split(' ').slice(1).join(' ') || 'Muhammad' }}
                            </span>
                        </h1>
                    </div>

                    <!-- Role Tagline -->
                    <div class="inline-block px-3 py-1 rounded-md bg-zinc-100 dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200 font-mono text-xs sm:text-sm font-semibold border border-zinc-200 dark:border-zinc-700">
                        &lt;{{ profile.role || 'Full Stack Developer' }} /&gt;
                    </div>

                    <!-- Bio Description with Inter Font -->
                    <p class="font-sans text-base sm:text-lg text-zinc-600 dark:text-zinc-400 max-w-2xl mx-auto lg:mx-0 leading-relaxed">
                        {{ profile.description || 'I build modern, responsive, and scalable web applications with the Laravel & Vue.js ecosystem, turning complex concepts into high-impact digital experiences.' }}
                    </p>

                    <!-- Solid High-Contrast Action Buttons -->
                    <div class="pt-2 flex flex-wrap items-center justify-center lg:justify-start gap-4">
                        <a 
                            href="#projects" 
                            class="inline-flex items-center gap-2 px-6 py-3.5 rounded-xl text-sm font-semibold font-sans bg-indigo-600 hover:bg-indigo-700 text-white shadow-sm transition-colors active:scale-95"
                        >
                            <span>View Projects</span>
                            <ArrowRight class="w-4 h-4" />
                        </a>

                        <a 
                            href="#contact" 
                            class="inline-flex items-center gap-2 px-6 py-3.5 rounded-xl text-sm font-semibold font-sans text-zinc-900 dark:text-zinc-100 bg-zinc-100 dark:bg-zinc-800 hover:bg-zinc-200 dark:hover:bg-zinc-700 border border-zinc-200 dark:border-zinc-700 transition-colors active:scale-95"
                        >
                            Contact Me
                        </a>

                        <a 
                            :href="profile.resume_url || '#'" 
                            download
                            class="inline-flex items-center gap-2 px-4 py-3.5 rounded-xl text-sm font-semibold font-sans text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white transition-colors"
                        >
                            <Download class="w-4 h-4" />
                            <span>Download CV</span>
                        </a>
                    </div>

                    <!-- Email Quick-Copy & Social Media -->
                    <div class="pt-6 border-t border-zinc-200 dark:border-zinc-800 flex flex-wrap items-center justify-center lg:justify-start gap-6">
                        <!-- Quick Copy Email -->
                        <button 
                            @click="copyEmail" 
                            type="button"
                            class="group flex items-center gap-2 px-3.5 py-1.5 rounded-lg bg-zinc-100 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 text-xs font-mono text-zinc-600 dark:text-zinc-400 hover:border-zinc-300 dark:hover:border-zinc-700 transition-colors"
                            :title="isCopied ? 'Copied!' : 'Click to copy email'"
                        >
                            <Check v-if="isCopied" class="w-3.5 h-3.5 text-emerald-500" />
                            <Copy v-else class="w-3.5 h-3.5 text-zinc-400 group-hover:text-zinc-700 dark:group-hover:text-zinc-200 transition-colors" />
                            <span>{{ isCopied ? 'Copied to clipboard!' : (profile.email || 'ikbal@email.com') }}</span>
                        </button>

                        <!-- Social Icon Badges -->
                        <div class="flex items-center gap-2.5">
                            <a 
                                v-if="profile.socials?.github" 
                                :href="profile.socials.github" 
                                target="_blank"
                                rel="noopener noreferrer"
                                aria-label="GitHub Profile"
                                class="w-9 h-9 rounded-lg border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 flex items-center justify-center text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white hover:border-zinc-300 dark:hover:border-zinc-700 transition-colors"
                            >
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z"/></svg>
                            </a>
                            <a 
                                v-if="profile.socials?.linkedin" 
                                :href="profile.socials.linkedin" 
                                target="_blank"
                                rel="noopener noreferrer"
                                aria-label="LinkedIn Profile"
                                class="w-9 h-9 rounded-lg border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 flex items-center justify-center text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white hover:border-zinc-300 dark:hover:border-zinc-700 transition-colors"
                            >
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                            </a>
                            <a 
                                v-if="profile.socials?.instagram" 
                                :href="profile.socials.instagram" 
                                target="_blank"
                                rel="noopener noreferrer"
                                aria-label="Instagram Profile"
                                class="w-9 h-9 rounded-lg border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 flex items-center justify-center text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white hover:border-zinc-300 dark:hover:border-zinc-700 transition-colors"
                            >
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Solid Clean Profile Card -->
                <div class="lg:col-span-5 relative flex items-center justify-center">
                    
                    <div class="relative w-full max-w-[360px] sm:max-w-[390px] p-3 rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-lg">
                        
                        <!-- Image Container -->
                        <div class="relative rounded-xl overflow-hidden aspect-[4/5] bg-zinc-100 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700/60">
                            <img 
                                :src="profile.hero_image || '/images/hero-image.png'" 
                                :alt="profile.name || 'Ikbal Muhammad'"
                                class="w-full h-full object-cover object-center"
                                onerror="this.src='/images/hero-image.png'"
                            />
                            
                            <!-- Bottom Tag inside Image -->
                            <div class="absolute bottom-3 left-3 right-3 flex items-center justify-between text-white text-xs">
                                <div class="flex items-center gap-1.5 bg-zinc-950/80 px-3 py-1.5 rounded-lg border border-white/10">
                                    <Sparkles class="w-3.5 h-3.5 text-amber-400" />
                                    <span class="font-medium font-sans">Laravel & Vue 3 Architect</span>
                                </div>
                            </div>
                        </div>

                        <!-- Floating Badge 1: Tech Stack Badge (Top Right) -->
                        <div class="absolute -top-4 -right-2 sm:-right-4 px-3.5 py-2 rounded-xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 shadow-md flex items-center gap-2.5">
                            <div class="w-7 h-7 rounded-lg bg-zinc-100 dark:bg-zinc-800 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-mono font-bold text-xs">
                                <Code2 class="w-4 h-4" />
                            </div>
                            <div>
                                <p class="text-[10px] uppercase font-mono tracking-wider text-zinc-400">Stack</p>
                                <p class="text-xs font-bold text-zinc-900 dark:text-white font-sans">Laravel + Inertia</p>
                            </div>
                        </div>

                        <!-- Floating Badge 2: Experience / Projects (Bottom Left) -->
                        <div class="absolute -bottom-4 -left-2 sm:-left-4 px-3.5 py-2 rounded-xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 shadow-md flex items-center gap-2.5">
                            <div class="w-7 h-7 rounded-lg bg-zinc-100 dark:bg-zinc-800 text-emerald-600 dark:text-emerald-400 flex items-center justify-center">
                                <Briefcase class="w-4 h-4" />
                            </div>
                            <div>
                                <p class="text-xs font-bold text-zinc-900 dark:text-white font-sans">15+ Completed</p>
                                <p class="text-[10px] text-zinc-400 font-sans">Web Apps & APIs</p>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
</template>
